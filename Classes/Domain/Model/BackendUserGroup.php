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
 * A Backend Usergroup.
 *
 * @author      Dennis Ahrens <dennis.ahrens@fh-hannover.de>
 * @author		Ruben Hohndorf <hohndorf@stud.fh-hannover.de>
 * @license     http://www.gnu.org/copyleft/gpl.html
 * @version     SVN: $Id:$
 * @entity
 */
class Tx_MvcExtjsSamples_Domain_Model_BackendUserGroup extends Tx_Extbase_DomainObject_AbstractEntity {
	
	/**
	 * @var int
	 */
	protected $pid;
	/**
	 * @var string
	 */
	protected $title;
	/**
	 * @var string
	 */
	protected $lockToDomain;
	/**
	 * @var string
	 */
	protected $description;
	/**
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_MvcExtjsSamples_Domain_Model_BackendUserGroup>
	 */
	protected $subgroup;
	
	/**
	 * Default constructor
	 */
	public function __construct() {
		$this->subgroup = new Tx_Extbase_Persistence_ObjectStorage();
	}
	
	/**
	 * Sets the pid
	 * 
	 * @param int $pid
	 * @return void
	 */
	public function setPid($pid) {
		$this->pid = $pid;
	}
	
	/**
	 * Gets the pid
	 * 
	 * @return int
	 */
	public function getPid() {
		return $this->pid;
	}
	
	/**
	 * Sets the title value
	 *
	 * @param string $title
	 * @return void
	 * @api
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Returns the title value
	 *
	 * @return string
	 * @api
	 */
	public function getTitle() {
		return $this->title;
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

	/**
	 * Sets the description value
	 *
	 * @param string $description
	 * @return void
	 * @api
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * Returns the description value
	 *
	 * @return string
	 * @api
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Sets the subgroups. Keep in mind that the property is called "subgroup"
	 * although it can hold several subgroups.
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_MvcExtjsSamples_Domain_Model_BackendUserGroup> $subgroup An object storage containing the subgroups to add
	 * @return void
	 * @api
	 */
	public function setSubgroup(Tx_Extbase_Persistence_ObjectStorage $subgroup) {
		$this->subgroup = $subgroup;
	}

	/**
	 * Adds a subgroup to the backend user
	 *
	 * @param Tx_MvcExtjsSamples_Domain_Model_BackendUserGroup $subgroup
	 * @return void
	 * @api
	 */
	public function addSubgroup(Tx_MvcExtjsSamples_Domain_Model_BackendUserGroup $subgroup) {
		$this->subgroup->attach($subgroup);
	}

	/**
	 * Removes a subgroup from the Backend user group
	 *
	 * @param Tx_MvcExtjsSamples_Domain_Model_BackendUserGroup $subgroup
	 * @return void
	 * @api
	 */
	public function removeSubgroup(Tx_MvcExtjsSamples_Domain_Model_BackendUserGroup $subgroup) {
		$this->subgroup->detach($subgroup);
	}

	/**
	 * Returns the subgroups. Keep in mind that the property is called "subgroup"
	 * although it can hold several subgroups.
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage An object storage containing the subgroups
	 * @api
	 */
	public function getSubgroup() {
		return $this->subgroups;
	}
}
?>