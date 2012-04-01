<?php

########################################################################
# Extension Manager/Repository config file for ext "cobj_xpath".
#
# Auto generated 01-04-2012 09:01
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
	'version' => '1.1.0',
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
			'php' => '5.2.0-0.0.0',
			'typo3' => '4.5.0-0.0.0',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:7:{s:13:"ChangeLog.txt";s:4:"4521";s:23:"class.tx_cobj_xpath.php";s:4:"4c73";s:16:"ext_autoload.php";s:4:"4f7e";s:12:"ext_icon.gif";s:4:"08dd";s:17:"ext_localconf.php";s:4:"84cc";s:14:"doc/README.txt";s:4:"73d2";s:14:"doc/manual.sxw";s:4:"10bd";}',
	'suggests' => array(
	),
);

?>