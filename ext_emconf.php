<?php

########################################################################
# Extension Manager/Repository config file for ext "cobj_xpath".
#
# Auto generated 19-11-2012 22:59
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'XPATH Content Object',
	'description' => 'Extends tslib_cObj with a new cObject XPATH for XML treatment and display with TypoScript.',
	'category' => 'fe',
	'shy' => 0,
	'version' => '1.2.0',
	'dependencies' => '',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => '',
	'state' => 'stable',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearcacheonload' => 1,
	'lockType' => '',
	'author' => 'Torsten Schrade',
	'author_email' => 'schradt@uni-mainz.de',
	'author_company' => 'Academy of Sciences and Literature | Mainz',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'constraints' => array(
		'depends' => array(
			'typo3' => '4.5.0-6.0.99',
		),
		'conflicts' => array(
		),
		'suggests' => array(
			'cobj_xslt' => '',
		),
	),
	'_md5_values_when_last_written' => 'a:8:{s:13:"ChangeLog.txt";s:4:"0ba5";s:23:"class.tx_cobj_xpath.php";s:4:"d646";s:16:"ext_autoload.php";s:4:"4f7e";s:12:"ext_icon.gif";s:4:"08dd";s:17:"ext_localconf.php";s:4:"84cc";s:39:"Classes/ViewHelpers/QueryViewHelper.php";s:4:"94cb";s:14:"doc/manual.sxw";s:4:"bb65";s:14:"doc/README.txt";s:4:"4d8d";}',
	'suggests' => array(
	),
);

?>