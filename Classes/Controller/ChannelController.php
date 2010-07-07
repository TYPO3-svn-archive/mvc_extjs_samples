<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Dennis Ahrens <dennis.ahrens@googlemail.com> 
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
 * The ChannelController manages Channel specific requests.
 *
 * @category    Controller
 * @package     TYPO3
 * @subpackage  tx_mvcextjssamples
 * @author      Dennis Ahrens <dennis.ahrens@googlemail.com> 
 * @license     http://www.gnu.org/copyleft/gpl.html
 * @version     SVN: $Id:$
 */
class Tx_MvcExtjsSamples_Controller_ChannelController extends Tx_Extbase_MVC_Controller_ActionController {
	
	/**
	 * @var Tx_MvcExtjsSamples_Domain_Repository_BackendUserRepository
	 */
	protected $backendUserRepository;
	
	/**
	 * @var Tx_MvcExtjsSamples_Domain_Repository_ChannelRepository
	 */
	protected $channelRepository;
	
	/**
	 * @see Classes/MVC/Controller/Tx_Extbase_MVC_Controller_ActionController#initializeAction()
	 */
	public function initializeAction() {
		$this->backendUserRepository = t3lib_div::makeInstance('Tx_MvcExtjsSamples_Domain_Repository_BackendUserRepository');
		$this->channelRepository = t3lib_div::makeInstance('Tx_MvcExtjsSamples_Domain_Repository_ChannelRepository');
	}
	
	/**
	 * Returns all channels.
	 * 
	 * @return string
	 */
	public function indexAction() {
		$channels = $this->channelRepository->findAll();
		$this->view->assign('channels',$channels);
		$this->flashMessages->add('Channel list received',Tx_Extbase_MVC_Controller_FlashMessage::TYPE_OK);
	}
	
	/**
	 * Creates a new channel.
	 * 
	 * @param Tx_MvcExtjsSamples_Domain_Model_Channel $newChannel
	 * @return string
	 * @dontverifyrequesthash
	 * @dontvalidate
	 */
	public function createAction(Tx_MvcExtjsSamples_Domain_Model_Channel $newChannel) {
		$this->channelRepository->add($newChannel);
		Tx_Extbase_Dispatcher::getPersistenceManager()->persistAll();
		$this->flashMessages->add('Channel: ' . $name . ' succesfully created.',Tx_Extbase_MVC_Controller_FlashMessage::TYPE_OK);
		$this->view->assign('channel',$newChannel);
	}
	
	/**
	 * Sends a new Message to a Channel.
	 * 
	 * @param string $text
	 * @param Tx_MvcExtjsSamples_Domain_Model_Channel $channel
	 * @param Tx_MvcExtjsSamples_Domain_Model_Chat $chat
	 * @return string
	 * @dontverifyrequesthash
	 */
	public function sendMessageAction($text, Tx_MvcExtjsSamples_Domain_Model_Channel $channel, Tx_MvcExtjsSamples_Domain_Model_Chat $chat) {
		$chat->setLastQuery(new DateTime()); // TODO: does not completely avoids double messages in gui.
		$message = t3lib_div::makeInstance('Tx_MvcExtjsSamples_Domain_Model_Message', $text, $this->backendUserRepository->findCurrent(),$channel);
		$channel->addMessage($message);
		Tx_Extbase_Dispatcher::getPersistenceManager()->persistAll(); // TODO: Neccessary? we don't need the need uid's for gui - do we? 
		$this->view->assign('message',$message);
	}
	
}

?>