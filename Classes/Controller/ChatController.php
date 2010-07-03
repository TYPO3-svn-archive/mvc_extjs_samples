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
 * The ChatController manages most of the chat related requests.
 *
 * @category    Controller
 * @package     TYPO3
 * @subpackage  tx_mvcextjssamples
 * @author      Dennis Ahrens <dennis.ahrens@googlemail.com> 
 * @license     http://www.gnu.org/copyleft/gpl.html
 * @version     SVN: $Id:$
 */
class Tx_MvcExtjsSamples_Controller_ChatController extends Tx_Extbase_MVC_Controller_ActionController {
	
	/**
	 * @var Tx_MvcExtjsSamples_Domain_Repository_BackendUserRepository
	 */
	protected $backendUserRepository;
	
	/**
	 * @var Tx_MvcExtjsSamples_Domain_Repository_ChatRepository
	 */
	protected $chatRepository;
	
	/**
	 * @var Tx_MvcExtjsSamples_Domain_Repository_ChannelRepository
	 */
	protected $channelRepository;
	
	/**
	 * @see Classes/MVC/Controller/Tx_Extbase_MVC_Controller_ActionController#initializeAction()
	 */
	public function initializeAction() {
		$this->backendUserRepository = t3lib_div::makeInstance('Tx_MvcExtjsSamples_Domain_Repository_BackendUserRepository');
		$this->chatRepository = t3lib_div::makeInstance('Tx_MvcExtjsSamples_Domain_Repository_ChatRepository');
		$this->channelRepository = t3lib_div::makeInstance('Tx_MvcExtjsSamples_Domain_Repository_ChannelRepository');
	}
	
	/**
	 * Connects - creates the chat.
	 * 
	 * @return string
	 */
	public function connectAction() {
		$backendUser = $this->backendUserRepository->findCurrent();
		$chat = t3lib_div::makeInstance('Tx_MvcExtjsSamples_Domain_Model_Chat',$backendUser);
		$this->chatRepository->add($chat);
		Tx_Extbase_Dispatcher::getPersistenceManager()->persistAll();
		$this->flashMessages->add('Connected with chat server',Tx_Extbase_MVC_Controller_FlashMessage::TYPE_OK);
		$this->view->assign('chat',$chat);
	}
	
	/**
	 * Disconnects - deletes the chat.
	 * 
	 * @param Tx_MvcExtjsSamples_Domain_Model_Chat $chat
	 * @return string
	 * @dontverifyrequesthash
	 */
	public function disconnectAction(Tx_MvcExtjsSamples_Domain_Model_Chat $chat) {
		$this->chatRepository->remove($chat);
		Tx_Extbase_Dispatcher::getPersistenceManager()->persistAll();
		$this->flashMessages->add('Disconnected!',Tx_Extbase_MVC_Controller_FlashMessage::TYPE_OK);
	}
	
	/**
	 * 
	 * @return string
	 */
	public function receiveChannelsAction() {
		$channels = $this->channelRepository->findAll();
		t3lib_div::sysLog('channels: ' . print_r($channels,true),'MvcExtjsSamples',0);
		$this->view->assign('channels',$channels);
		$this->flashMessages->add('Channel list received',Tx_Extbase_MVC_Controller_FlashMessage::TYPE_OK);
	}
	
	/**
	 * Ask for the Chat('s changes).
	 * TODO: Not sure where to manage that we just transfer new data on each query.
	 * Answer with the full object (data) description.
	 * 
	 * @param Tx_MvcExtjsSamples_Domain_Model_Chat $chat
	 * @return string
	 * @dontverifyrequesthash
	 */
	public function queryAction(Tx_MvcExtjsSamples_Domain_Model_Chat $chat) {
		$chat->setTstamp(new DateTime());
		$this->view->assign('chat',$chat);
	}
	
	/**
	 * Creates a channel and adds it to the Chat.
	 * 
	 * @param string $name
	 * @param Tx_MvcExtjsSamples_Domain_Model_Chat $chat
	 * @return string
	 * @dontverifyrequesthash
	 */
	public function createChannelAction($name, Tx_MvcExtjsSamples_Domain_Model_Chat $chat) {
		$channel = t3lib_div::makeInstance('Tx_MvcExtjsSamples_Domain_Model_Channel',$name);
		$chat->addChannel($channel);
		Tx_Extbase_Dispatcher::getPersistenceManager()->persistAll();
		$this->flashMessages->add('Channel: ' . $name . ' succesfully created.',Tx_Extbase_MVC_Controller_FlashMessage::TYPE_OK);
		$this->view->assign('channel',$channel);
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
		$message = t3lib_div::makeInstance('Tx_MvcExtjsSamples_Domain_Model_Message', $text, $this->backendUserRepository->findCurrent());
		$channel->addMessage($message);
		$this->view->assign('message',$message);
	}
	
}

?>