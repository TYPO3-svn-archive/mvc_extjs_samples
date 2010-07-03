<?php

/***************************************************************
*  Copyright notice
*
*  (c) 2010 Dennis Ahrens <dennis.ahrens@fh-hannover.de>
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
 * A Channel has a name and it's related messages.
 *
 * @author      Dennis Ahrens <dennis.ahrens@fh-hannover.de>
 * @license     http://www.gnu.org/copyleft/gpl.html
 * @version     SVN: $Id:$
 * @entity
 */
class Tx_MvcExtjsSamples_Domain_Model_Channel extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * @var string
	 */
	protected $name;
	
	/**
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_MvcExtjsSamples_Domain_Model_Message>
	 * @lazy
	 * @cascade remove
	 */
	protected $messages;
	
	/**
	 * Default Constructor.
	 * 
	 * @param string $name
	 */
	public function __construct($name='') {
		$this->name = $name;
	}
	
	/**
	 * Returns the name.
	 * 
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}
	
	/**
	 * Sets the name.
	 * 
	 * @param string $name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * Returns the messages.
	 * 
	 * @return string
	 */
	public function getMessages() {
		return $this->messages;
	}
	
	/**
	 * Adds a Message to the Channel.
	 * 
	 * @param Tx_MvcExtjsSamples_Domain_Model_Message $message
	 * @return void
	 */
	public function addMessage(Tx_MvcExtjsSamples_Domain_Model_Message $message) {
		$this->messages->attach($message);
	}
}
?>