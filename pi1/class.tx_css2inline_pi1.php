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
 * @author    Olivier Schopfer <ops@wcc-coe.org>
 * @package    TYPO3
 * @subpackage    tx_css2inline
 */
class tx_css2inline_pi1 extends \TYPO3\CMS\Frontend\Plugin\AbstractPlugin
{

    public $prefixId = 'tx_css2inline_pi1';
    public $scriptRelPath = 'pi1/class.tx_css2inline_pi1.php';
    public $extKey = 'css2inline';
    public $pi_checkCHash = true;

    /**
     * The main method of the plugin.
     *
     * @param string $content The plugin content
     * @param array $conf The plugin configuration
     * @return string The content that is displayed on the website
     */
    public function main($content, array $conf)
    {
        // Require 3rd-party libraries, in case TYPO3 does not run in composer mode
        $pharFileName = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($this->extKey) . 'Libraries/pelago-emogrifier.phar';
        if (is_file($pharFileName)) {
            @include 'phar://' . $pharFileName . '/vendor/autoload.php';
        }

        $css = $this->cObj->cObjGetSingle($conf['css'], $conf['css.']);
        $html = $this->cObj->cObjGetSingle($conf['html'] ?: 'COA', $conf['html.']);

        $emogrifier = new \Pelago\Emogrifier($html, $css);

        /**
         * By default, Emogrifier will grab all <style> blocks in the HTML and will apply the CSS styles as inline
         * "style" attributes to the HTML. The <style> blocks will then be removed from the HTML. If you want to disable
         * this functionality so that Emogrifier leaves these <style> blocks in the HTML and does not parse them, you
         * should use this option. If you use this option, the contents of the <style> blocks will not be applied as
         * inline styles and any CSS you want Emogrifier to use must be passed in.
         */
        $emogrifier->disableStyleBlocksParsing();

        // Merge HTML and CSS
        $mergedHtml = $emogrifier->emogrify();

        return $mergedHtml;
    }

}
