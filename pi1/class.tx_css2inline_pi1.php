<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2009 Olivier Schopfer <ops@wcc-coe.org>
 *  Parts of the code taken from Emogrifier http://www.pelagodesign.com/sidecar/emogrifier/
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 * Hint: use extdeveval to insert/update function index above.
 */



/**
 * Plugin 'Converter' for the 'css2inline' extension.
 *
 * @author	Olivier Schopfer <ops@wcc-coe.org>
 * @package	TYPO3
 * @subpackage	tx_css2inline
 */
class tx_css2inline_pi1 extends tslib_pibase {
	var $prefixId      = 'tx_css2inline_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_css2inline_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'css2inline';	// The extension key.
	var $pi_checkCHash = true;
	var $encoding = '';

	private $html = '';
	private $css = '';
	private $unprocessableHTMLTags = array('wbr');

	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	function main($content, $conf)	{
		$css = $this->cObj->cObjGet($conf['css.']);
		$html = $this->cObj->cObjGet($conf['html.']);
		$charset = $GLOBALS['TSFE']->config['config']['renderCharset'];
		$this->encoding = $charset?$charset:'iso-8859-1';
		$this->setCSS($css);
		$this->setHTML($html);
		if ($conf['removeAttributes']) $this->removeAttributes = t3lib_div::trimExplode(',', $conf['removeAttributes']);
		return html_entity_decode($this->emogrify(),ENT_QUOTES,$this->encoding);
	}
	/*
	 *
	 * Library taken from http://www.pelagodesign.com/sidecar/emogrifier/
	UPDATES

	2008-08-10  Fixed CSS comment stripping regex to add PCRE_DOTALL (changed from '/\/\*.*\*\//U' to '/\/\*.*\*\//sU')
	2008-08-18  Added lines instructing DOMDocument to attempt to normalize HTML before processing
	2008-10-20  Fixed bug with bad variable name... Thanks Thomas!

	 */
	// you can extend this to support file input/output or just add new functions to this class!


	public function __construct($html = '', $css = '') {
		$this->html = $html;
		$this->css  = $css;
	}

	public function setHTML($html = '') { $this->html = $html; }
	public function setCSS($css = '') { $this->css = $css; }

	// there are some HTML tags that DOMDocument cannot process, and will throw an error if it encounters them.
	// these functions allow you to add/remove them if necessary
	public function addUnprocessableHTMLTag($tag) { $this->unprocessableHTMLTags[] = $tag; }
	public function removeUnprocessableHTMLTag($tag) {
		if (($key = array_search($tag,$this->unprocessableHTMLTags)) !== false)
		unset($this->unprocessableHTMLTags[$key]);
	}

	// applies the CSS you submit to the html you submit. places the css inline
	public function emogrify() {
		// process the CSS here, turning the CSS style blocks into inline css
		$unprocessableHTMLTags = implode('|',$this->unprocessableHTMLTags);
		$body = preg_replace("/<($unprocessableHTMLTags)[^>]*>/i",'',$this->html);

		$xmldoc = new DOMDocument();
		$xmldoc->strictErrorChecking = false;
		$xmldoc->formatOutput = true;
		$xmldoc->encoding = $this->encoding;
		$xmldoc->loadHTML($body);
		$xmldoc->normalizeDocument();

		$xpath = new DOMXPath($xmldoc);

		// get rid of css comment code
		$re_commentCSS = '/\/\*.*\*\//sU';
		$css = preg_replace($re_commentCSS,'',$this->css);

		// process the CSS file for selectors and definitions
		$re_CSS = '/^\s*([^{]+){([^}]+)}/mis';
		preg_match_all($re_CSS,$css,$matches);

		foreach ($matches[1] as $key => $selectorString) {
			// if there is a blank definition, skip
			if (!strlen(trim($matches[2][$key]))) continue;

			// split up the selector
			$selectors = explode(',',$selectorString);
			foreach ($selectors as $selector) {
				// don't process pseudo-classes
				if (strpos($selector,':') !== false) continue;

				// query the body for the xpath selector
				$nodes = $xpath->query($this->translateCSStoXpath(trim($selector)));

				foreach($nodes as $node) {
					// if it has a style attribute, get it, process it, and append (overwrite) new stuff
					if ($node->hasAttribute('style')) {
						$style = $node->getAttribute('style');
						// break it up into an associative array
						$oldStyleArr = $this->cssStyleDefinitionToArray($node->getAttribute('style'));
						$newStyleArr = $this->cssStyleDefinitionToArray($matches[2][$key]);

						// new styles overwrite the old styles (not technically accurate, but close enough)
						$combinedArr = array_merge($oldStyleArr,$newStyleArr);
						$style = '';
						foreach ($combinedArr as $k => $v) $style .= ($k . ':' . $v . ';');
					} else {
						// otherwise create a new style
						$style = trim($matches[2][$key]);
					}
					$node->setAttribute('style',$style);
				}
			}
		}

		// This removes styles from your email that contain display:none;. You could comment these out if you want.
		// $nodes = $xpath->query('//*[contains(translate(@style," ",""),"display:none;")]');
		// foreach ($nodes as $node) $node->parentNode->removeChild($node);
		if ($this->removeAttributes) {
			foreach ($this->removeAttributes as $attribute) {
				$nodes = $xpath->query("//*[@" . $attribute . "]");
				foreach ($nodes as $node) $node->removeAttribute($attribute);
			}
		}


		return $xmldoc->saveHTML();

	}

	// right now we only support CSS 1 selectors, but include CSS2/3 selectors are fully possible.
	// http://plasmasturm.org/log/444/
	private function translateCSStoXpath($css_selector) {
		// returns an Xpath selector
		$search = array(
												'/\s+>\s+/', // Matches any F element that is a child of an element E.
												'/(\w+)\s+\+\s+(\w+)/', // Matches any F element that is a child of an element E.
												'/\s+/', // Matches any F element that is a descendant of an E element.
												'/(\w+)?\#([\w\-]+)/e', // Matches id attributes
												'/(\w+)?\.([\w\-]+)/e', // Matches class attributes
		);
		$replace = array(
												'/',
												'\\1/following-sibling::*[1]/self::\\2',
												'//',
												"(strlen('\\1') ? '\\1' : '*').'[@id=\"\\2\"]'",
												"(strlen('\\1') ? '\\1' : '*').'[contains(concat(\" \",@class,\" \"),concat(\" \",\"\\2\",\" \"))]'",
		);
		return '//'.preg_replace($search,$replace,trim($css_selector));
	}

	private function cssStyleDefinitionToArray($style) {
		$definitions = explode(';',$style);
		$retArr = array();
		foreach ($definitions as $def) {
			list($key, $value) = preg_split('/:/', $def, 2, PREG_SPLIT_NO_EMPTY);
			if (empty($key) || !isset($value)) continue;
			$retArr[trim($key)] = trim($value);
		}
		return $retArr;
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/css2inline/pi1/class.tx_css2inline_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/css2inline/pi1/class.tx_css2inline_pi1.php']);
}

?>