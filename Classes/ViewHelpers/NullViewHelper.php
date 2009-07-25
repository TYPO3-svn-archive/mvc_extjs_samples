<?php
/*                                                                        *
 * This script belongs to the FLOW3 package "Fluid".                      *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License as published by the *
 * Free Software Foundation, either version 3 of the License, or (at your *
 * option) any later version.                                             *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser       *
 * General Public License for more details.                               *
 *                                                                        *
 * You should have received a copy of the GNU Lesser General Public       *
 * License along with the script.                                         *
 * If not, see http://www.gnu.org/licenses/lgpl.html                      *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

/**
 * @package Fluid
 * @subpackage ViewHelpers
 * @version $Id: BaseViewHelper.php 725 2009-05-28 21:45:46Z sebastian $
 */

/**
 * View helper which return input as it is
 *
 * = Examples =
 *
 * <f:null>{anyString}</f:null>
 *
 *
 * @package Fluid
 * @subpackage ViewHelpers
 * @version $Id: BaseViewHelper.php 725 2009-05-28 21:45:46Z sebastian $
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 * @scope prototype
 */
class Tx_MvcExtjsSamples_ViewHelpers_NullViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	protected $objectAccessorPostProcessorEnabled = FALSE;
	
	/**
	 * Render 
	 *
	 * Note: renders as <base></base>, because IE6 will else refuse to display
	 * the page...
	 *
	 * @return string 
	 * @author Steffen Kamper <info@sk-typo3.de>
	 */
	public function render() {
		$content = $this->renderChildren(); 
		return $content;
	}
}
?>