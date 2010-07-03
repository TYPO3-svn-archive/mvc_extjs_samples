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
 * A Chat belongs to one Backend User. And holds the registered Channels for this user.
 *
 * @author      Dennis Ahrens <dennis.ahrens@fh-hannover.de>
 * @license     http://www.gnu.org/copyleft/gpl.html
 * @version     SVN: $Id:$
 * @entity
 */
class Tx_MvcExtjsSamples_Domain_Model_Chat extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * @var Tx_MvcExtjsSamples_Domain_Model_BackendUser
	 */
	protected $backendUser;
	
	/**
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_MvcExtjsSamples_Domain_Model_Channel>
	 */
	protected $channels;
	
	/**
	 * @var DateTime
	 */
	protected $start;
	
	/**
	 * Default Constructor.
	 * 
	 * @param Default Constructor. $backendUser
	 */
	public function __construct(Tx_MvcExtjsSamples_Domain_Model_BackendUser $backendUser = NULL) {
		$this->backendUser = $backendUser;
		$this->start = new DateTime();
	}
	
	/**
	 * Returns the name.
	 * 
	 * @return string
	 */
	public function getStart() {
		return $this->start;
	}
	
	/**
	 * Sets the BE user.
	 *
	 * @param Tx_MvcExtjsSamples_Domain_Model_BackendUser $beUser
	 * @return void
	 */
	public function setBackendUser(Tx_MvcExtjsSamples_Domain_Model_BackendUser $beUser) {
		$this->backendUser = $beUser;
	}

	/**
	 * Returns the BE user.
	 *
	 * @return Tx_MvcExtjsSamples_Domain_Model_BackendUser
	 */
	public function getBackendUser() {
		return $this->backendUser;
	}
	
	/**
	 * Returns the channels.
	 * 
	 * @return string
	 */
	public function getChannels() {
		return $this->channels;
	}
	
	/**
	 * Adds a Channel to the Chat.
	 * 
	 * @param Tx_MvcExtjsSamples_Domain_Model_Channel $channel
	 * @return void
	 */
	public function addChannel(Tx_MvcExtjsSamples_Domain_Model_Channel $channel) {
		$this->channels->attach($channel);
	}
	
	/**
	 * Sets the Channels.
	 * 
	 * @param array $channels
	 * @return void
	 */
	public function setChannels(array $channels) {
		$channelStorage = t3lib_div::makeInstance('Tx_Extbase_Persistence_ObjectStorage');
		foreach ($channels as $channel) {
			$channelStorage->attach($channel);
		}
		$this->channels->addAll($channelStorage);
	}
}
?>