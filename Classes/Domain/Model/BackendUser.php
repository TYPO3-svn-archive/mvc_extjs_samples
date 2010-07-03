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
 * A Backend User.
 *
 * @author      Dennis Ahrens <dennis.ahrens@fh-hannover.de>
 * @author		Ruben Hohndorf <hohndorf@stud.fh-hannover.de>
 * @license     http://www.gnu.org/copyleft/gpl.html
 * @version     SVN: $Id:$
 * @entity
 */
class Tx_MvcExtjsSamples_Domain_Model_BackendUser extends Tx_Extbase_DomainObject_AbstractEntity {


	/**
	 * @var string
	 */
	protected $username;
	/**
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_MvcExtjsSamples_Domain_Model_BackendUserGroup>
	 */
	protected $usergroup;
	/**
	 * 
	 * @var string
	 */
	protected $email;
	/**
	 * 
	 * @var string
	 */
	protected $realname;
	/**
	 * @var string
	 */
	protected $lockToDomain = '';

	/**
	 * Constructs a new Back-End User
	 *
	 * @api
	 */
	public function __construct($username) {
		$this->username = $username;
		$this->usergroup = new Tx_Extbase_Persistence_ObjectStorage();
	}
	
	/**
	 * Sets the username value
	 *
	 * @param string $username
	 * @return void
	 * @api
	 */
	public function setUsername($username) {
		$this->username = $username;
	}

	/**
	 * Returns the username value
	 *
	 * @return string
	 * @api
	 */
	public function getUsername() {
		return $this->username;
	}
	/**
	 * Sets the usergroups. Keep in mind that the property is called "usergroup"
	 * although it can hold several usergroups.
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_MvcExtjsSamples_Domain_Model_BackendUserGroup> $usergroup An object storage containing the usergroups to add
	 * @return void
	 * @api
	 */
	public function setUsergroup(Tx_Extbase_Persistence_ObjectStorage $usergroup) {
		$this->usergroup = $usergroup;
	}

	/**
	 * Adds a usergroup to the backend user
	 *
	 * @param Tx_MvcExtjsSamples_Domain_Model_BackendUserGroup $usergroup
	 * @return void
	 * @api
	 */
	public function addUsergroup(Tx_MvcExtjsSamples_Domain_Model_BackendUserGroup $usergroup) {
		if (! $this->usergroup->contains($usergroup)) {
			$this->usergroup->attach($usergroup);
		}
	}

	/**
	 * Removes a usergroup from the backend user
	 *
	 * @param Tx_MvcExtjsSamples_Domain_Model_BackendUserGroup $usergroup
	 * @return void
	 * @api
	 */
	public function removeUsergroup(Tx_MvcExtjsSamples_Domain_Model_BackendUserGroup $usergroup) {
		$this->usergroup->detach($usergroup);
	}

	/**
	 * Returns the usergroups. Keep in mind that the property is called "usergroup"
	 * although it can hold several usergroups.
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage An object storage containing the usergroup
	 * @api
	 */
	public function getUsergroup() {
		return $this->usergroup;
	}
	/**
	 * Sets the realname value
	 *
	 * @param string $realname
	 * @return void
	 * @api
	 */
	public function setRealname($realname) {
		$this->realname = $realname;
	}

	/**
	 * Returns the realname value
	 *
	 * @return string
	 * @api
	 */
	public function getRealname() {
		return $this->realname;
	}
	/**
	 * Sets the email value
	 *
	 * @param string $email
	 * @return void
	 * @api
	 */
	public function setEmail($email) {
		$this->email = $email;
	}

	/**
	 * Returns the email value
	 *
	 * @return string
	 * @api
	 */
	public function getEmail() {
		return $this->email;
	}
	/**
	 * Sets the lockToDomain value
	 *
	 * @param string $lockToDomain
	 * @return void
	 * @api
	 */
	public function setLockToDomain($lockToDomain) {
		$this->lockToDomain = $lockToDomain;
	}

	/**
	 * Returns the lockToDomain value
	 *
	 * @return string
	 * @api
	 */
	public function getLockToDomain() {
		return $this->lockToDomain;
	}
	
}
?>