<?php
if (!defined('TYPO3_MODE')) die('Not in Typo3');

// defines content object XPATH
$TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_content.php']['cObjTypeAndClass'][] = array(
	0 => 'XPATH',
	1 => 'EXT:cobj_xpath/class.tx_cobj_xpath.php:tx_cobj_xpath',
);
?>