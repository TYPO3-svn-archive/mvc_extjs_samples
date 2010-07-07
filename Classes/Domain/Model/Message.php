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
 * A Message - written by a Backend User at DateTime belongs to a Channel.
 *
 * @author      Dennis Ahrens <dennis.ahrens@fh-hannover.de>
 * @license     http://www.gnu.org/copyleft/gpl.html
 * @version     SVN: $Id:$
 * @entity
 */
class Tx_MvcExtjsSamples_Domain_Model_Message extends Tx_Extbase_DomainObject_AbstractEntity {


	/**
	 * @var string
	 */
	protected $text;
	
	/**
	 * @var Tx_MvcExtjsSamples_Domain_Model_BackendUser
	 */
	protected $backendUser;
	
	/**
	 * @var DateTime
	 */
	protected $creationDate;
	
	/**
	 * @var Tx_MvcExtjsSamples_Domain_Model_Channel
	 */
	protected $channel;
	
	/**
	 * Default Constructor.
	 */
	public function __construct($text = '', Tx_MvcExtjsSamples_Domain_Model_BackendUser $beUser = NULL, $channel = NULL) {
		$this->text = $text;
		$this->backendUser = $beUser;
		$this->creationDate = new DateTime();
		$this->channel = $channel;
	}
	
	/**
	 * Gets the DateTime when this message was created.
	 * 
	 * @return DateTime
	 */
	public function getCreationDate() {
		return $this->creationDate;
	}
	
	/**
	 * Sets the DateTime when this message was created.
	 * 
	 * @param DateTime $date
	 * @return void
	 */
	public function setCreationDate(DateTime $date) {
		$this->creationDate = $date;
	}
	
	/**
	 * Sets the text value.
	 *
	 * @param string $text
	 * @return void
	 */
	public function setText($text) {
		$this->text = $text;
	}

	/**
	 * Returns the text value.
	 *
	 * @return string
	 */
	public function getText() {
		return $this->text;
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
	 * Sets the channel.
	 *
	 * @param Tx_MvcExtjsSamples_Domain_Model_Channel $channel
	 * @return void
	 */
	public function setChannel(Tx_MvcExtjsSamples_Domain_Model_Channel $channel) {
		$this->channel = $channel;
	}

	/**
	 * Returns the channel.
	 *
	 * @return Tx_MvcExtjsSamples_Domain_Model_Channel
	 */
	public function getChannel() {
		return $this->channel;
	}
	
}
?>