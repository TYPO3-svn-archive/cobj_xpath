<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2012 Torsten Schrade <schradt@uni-mainz.de>
*
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
 *
 * @author Torsten Schrade
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @package dabase
 */

class Tx_CobjXpath_ViewHelpers_QueryViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * @var Tx_Extbase_Configuration_ConfigurationManagerInterface
	 */
	protected $configurationManager;

	/**
	 * @var tslib_cObj
	 */
	protected $contentObject;

	/**
	 * @param Tx_Extbase_Configuration_ConfigurationManagerInterface $configurationManager
	 * @return void
	 */
	public function injectConfigurationManager(Tx_Extbase_Configuration_ConfigurationManagerInterface $configurationManager) {
		$this->configurationManager = $configurationManager;
		$this->contentObject = $this->configurationManager->getContentObject();
		$this->contentObject->start(array(),'');
	}

	/**
	 * Fluid view helper wrapper for the XPATH content object. Calls the content object class directly. This makes it possible to 
	 * return multi value results like arrays directly to the fluid template
	 * 
	 * @param mixed $source
	 * @param string $expression
	 * @param string $return
	 * 
	 * @return mixed
	 */
	public function render($source=NULL, $expression='', $return='string') {

		if ($source === NULL) {
			$source = $this->renderChildren();
		}

		$configuration = array(
			'source' => $source,
			'expression' => $expression,
			'return' => $return,
			'returnRaw' => 1
		);

		$content = $this->contentObject->cObjHookObjectsArr['XPATH']->cObjGetSingleExt('XPATH', $configuration, '', $this->contentObject);

		return $content;
	}
}
?>