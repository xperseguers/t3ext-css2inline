<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "css2inline".
 *
 * Auto generated 07-08-2014 11:27
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array (
	'title' => 'CSS to inline converter for direct mail',
	'description' => 'Moves the styles from CSS sheets into inline CSS, in order to comply with uncooperative email clients. Can be used as a post-processing stdWrap in TypoScript.',
	'category' => 'plugin',
	'shy' => 0,
	'version' => '0.1.6-dev',
	'dependencies' => '',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => '',
	'state' => 'stable',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearcacheonload' => 0,
	'lockType' => '',
	'author' => 'Olivier Schopfer',
	'author_email' => 'ops@wcc-coe.org',
	'author_company' => '',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'constraints' => array(
		'depends' =>  array(
			'typo3' => '4.5.0-6.2.99',
			'php' => '5.3.0-5.6.99'
		),
		'conflicts' => array(
		),
		'suggests' =>  array(
		),
	),
	'_md5_values_when_last_written' => 'a:8:{s:9:"ChangeLog";s:4:"89e7";s:12:"ext_icon.gif";s:4:"ef6a";s:17:"ext_localconf.php";s:4:"3601";s:10:"README.txt";s:4:"ee2d";s:14:"doc/manual.sxw";s:4:"ecaa";s:19:"doc/wizard_form.dat";s:4:"3ca4";s:20:"doc/wizard_form.html";s:4:"9b71";s:31:"pi1/class.tx_css2inline_pi1.php";s:4:"176c";}',
);

?>