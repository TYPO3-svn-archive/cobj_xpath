<?php
/***************************************************************
 *  Copyright notice
 *
 *  Copyright (c) 2012 Torsten Schrade <schradt@uni-mainz.de>
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

if (!defined ('TYPO3_MODE'))
	die ('Access denied.');

/**
 * Extends tslib_cObj with XPATH cobject
 *
 * @access public
 * @author Torsten Schrade
 * @package TYPO3
 * @subpackage tx_cobj_xpath
 */
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 *   46: class tx_cobj_xpath
 *   57:     public function cObjGetSingleExt($name, $conf, $TSkey, &$oCObj)
 *  202:     private function display_xml_error($error, $xml)
 *
 * TOTAL FUNCTIONS: 2
 *
 */
class tx_cobj_xpath {

	/**
	 * Rendering function for the XPATH content object
	 *
	 * @param	string		XPATH
	 * @param	array		TypoScript configuration of the cObj
	 * @param	string		Key in the TypoScript array passed to this function
	 * @param	object		Reference to the parent class
	 * @return	mixed
	 */
	public function cObjGetSingleExt($name, $conf, $TSkey, &$oCObj) {

		$content = '';

		// fetch xml data
		if (is_array($conf['source.']) || isset($conf['source'])) {

			// get XML by url
			if (isset($conf['source.']['url']) && t3lib_div::isValidUrl($conf['source.']['url'])) {

				$xmlsource = t3lib_div::getURL($conf['source.']['url'], 0, FALSE);
				if (!$xmlsource) $GLOBALS['TT']->setTSlogMessage('XML could not be fetched from URL.', 3);

			// get XML with stdWrap
			} else {
				if ($conf['source.']['url']) unset($conf['source.']['url']);
				$xmlsource = $oCObj->stdWrap($conf['source'], $conf['source.']);
			}
		} else {
			$GLOBALS['TT']->setTSlogMessage('Source for XML is not configured.', 3);
			return $oCObj->stdWrap($content, $conf['stdWrap.']);
		}

		// xpath expression
		if (is_array($conf['expression.']) || isset($conf['expression'])) {
			$expression = $oCObj->stdWrap($conf['expression'], $conf['expression.']);
		} else {
			$GLOBALS['TT']->setTSlogMessage('No xpath expression set.', 3);
			return $oCObj->stdWrap($content, $conf['stdWrap.']);
		}

		if ($xmlsource) {

			// try to load a simpleXML object
			libxml_use_internal_errors(true);
			$xml = simplexml_load_string($xmlsource);

			if ($xml instanceof SimpleXMLElement) {

				// possible namespaces for query
				if (TRUE == $conf['registerNamespace.']['getFromSource']) {
					$namespaces = array_merge($xml->getDocNamespaces(), $xml->getNamespaces());
					if ($conf['registerNamespace.']['getFromSource.']['debug']) t3lib_div::debug($namespaces);
					if (count($namespaces) > 0 && isset($conf['registerNamespace.']['getFromSource.']['listNum'])) {
						$listNumData = array();
						foreach ($namespaces as $prefix => $ns) {
							$listNumData[] = $prefix.'|'.$ns;
						}
						$listNumConf['listNum'] = $conf['registerNamespace.']['getFromSource.']['listNum'];
						if (is_array($conf['registerNamespace.']['getFromSource.']['listNum.'])) $listNumConf['listNum.'] = $conf['registerNamespace.']['getFromSource.']['listNum.'];
						$listNumConf['listNum.']['splitChar'] = ',';
						$conf['registerNamespace'] = $oCObj->stdWrap_listNum(implode(',', $listNumData), $listNumConf);
					} else {
						$conf['registerNamespace'] = '';
					}
				}

				if (isset($conf['registerNamespace'])) {
					$namespace = t3lib_div::trimExplode('|', $conf['registerNamespace'], 1);
					if (count($namespace) == 2 && t3lib_div::isValidUrl($namespace[1])) $xml->registerXPathNamespace($namespace[0], $namespace[1]);
				}

				// perform xpath query
				$result = $xml->xpath($expression);

				// if there was a result
				if (is_array($result) && count($result) > 0) {

					// otherwise return configured format for the query result
					switch ($conf['return']) {

						case 'count':
							$content = count($result);
							return $oCObj->stdWrap($content, $conf['stdWrap.']);
						break;

						case 'boolean':
							$content = TRUE;
							return $oCObj->stdWrap($content, $conf['stdWrap.']);
						break;

						case 'xml':
							foreach ($result as $key => $value) {
								$result[$key] = $value->asXML();
							}
						break;

						case 'array':
							foreach ($result as $key => $value) {
								// idea from soloman at http://www.php.net/manual/en/book.simplexml.php
								$json = json_encode($value);
								$result[$key] = json_decode($json,TRUE);
							}
							// replace the current $cObj->data array with the result array
							$oCObj->data = $result;
						break;

						case 'json':
							foreach ($result as $key => $value) {
								$result[$key] = json_encode($value);
							}
						break;

						case 'string':
						default:
							foreach ($result as $key => $value) {
								$result[$key] = (string) $value;
							}
						break;
					}

					// hand the result to split for further treatment with TS
					if (is_array($conf['resultObj.'])) {
						$conf['resultObj.']['token'] = '###COBJ_XPATH###';
						$content = $oCObj->splitObj(implode('###COBJ_XPATH###', $result), $conf['resultObj.']);
					} else {
						$GLOBALS['TT']->setTSlogMessage('No resultObj configured.', 2);
					}

				} else {
					$GLOBALS['TT']->setTSlogMessage('The xpath query returned no results.', 2);
				}

			} else {
				$errors = libxml_get_errors();
				foreach ($errors as $error) {
					$GLOBALS['TT']->setTSlogMessage('XML exception: '.$this->display_xml_error($error, $xml), 3);
				}
				libxml_clear_errors();
			}

		} else {
			$GLOBALS['TT']->setTSlogMessage('The configured XML source did not return any data.', 3);
		}

		return $oCObj->stdWrap($content, $conf['stdWrap.']);
	}

	/**
	 * Returns XML error codes for the TSFE admin panel. Function inspired by http://www.php.net/manual/en/function.libxml-get-errors.php
	 *
	 * @param	string
	 * @param	string
	 * @return	string
	 */
	private function display_xml_error($error, $xml) {

		switch ($error->level) {
			case LIBXML_ERR_WARNING:
				$errormessage .= 'Warning '.$error->code.': ';
			break;
			case LIBXML_ERR_ERROR:
				$errormessage .= 'Error '.$error->code.': ';
			break;
			case LIBXML_ERR_FATAL:
				$errormessage .= 'Fatal error '.$error->code.': ';
			break;
		}

		$errormessage .= trim($error->message).' - Line: '.$error->line.', Column:'.$error->column;

		if ($error->file) {
			$errormessage .= ' - File: '.$error->file;
		}

	    return $errormessage;
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/cobj_xpath/class.tx_cobj_xpath.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/cobj_xpath/class.tx_cobj_xpath.php']);
}
?>