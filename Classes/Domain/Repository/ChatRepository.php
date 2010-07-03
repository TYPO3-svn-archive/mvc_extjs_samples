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
 * A BackendUserRepository.
 *
 * @author      Dennis Ahrens <dennis.ahrens@fh-hannover.de>
 * @author		Ruben Hohndorf <hohndorf@stud.fh-hannover.de>
 * @license     http://www.gnu.org/copyleft/gpl.html
 * @version     SVN: $Id:$
 */
class Tx_MvcExtjsSamples_Domain_Repository_ChatRepository extends Tx_Extbase_Persistence_Repository {
	
	/**
	 * Removes Chat Objects that are expired.
	 * TODO: fix the error
	 * 
	 * @see Classes/Persistence/Tx_Extbase_Persistence_Repository#add($object)
	 */
	public function add($object) {
		//$this->deleteExpired();
		parent::add($object);
	}
	
	/**
	 * Deletes expired Chats.
	 * 
	 * @return void
	 */
	private function deleteExpired() {
		$expiredChats = $this->findExpired();
		foreach ($expiredChats as $chat) {
			$this->remove($chat);
		}
	}
	
	/**
	 * Finds Chats that are older than yesterday at midnight.
	 * 
	 * @return array
	 */
	public function findExpired() {
		$query = $this->createQuery();
		return $query->matching($query->lessThan('tstamp',new DateTime('yesterday')))->execute();
	}
	
}
?>