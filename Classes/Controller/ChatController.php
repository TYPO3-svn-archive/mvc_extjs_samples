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
	 * @var Tx_MvcExtjsSamples_Domain_Repository_MessageRepository
	 */
	protected $messageRepository;
	
	/**
	 * @see Classes/MVC/Controller/Tx_Extbase_MVC_Controller_ActionController#initializeAction()
	 */
	public function initializeAction() {
		$this->backendUserRepository = t3lib_div::makeInstance('Tx_MvcExtjsSamples_Domain_Repository_BackendUserRepository');
		$this->chatRepository = t3lib_div::makeInstance('Tx_MvcExtjsSamples_Domain_Repository_ChatRepository');
		$this->channelRepository = t3lib_div::makeInstance('Tx_MvcExtjsSamples_Domain_Repository_ChannelRepository');
		$this->messageRepository = t3lib_div::makeInstance('Tx_MvcExtjsSamples_Domain_Repository_MessageRepository');
	}
	
	/**
	 * Renders the whole HTML markup containing the JavaScript code.
	 * Have a look at the template file!
	 * 
	 * @return string
	 */
	public function indexAction() {
		// hand over data that is neccessary for building up the first markup
		// maybe objects to fill up array stores or other settings
		// TODO: LLL and user access - where to put the logic for those requests?
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
			// we persist here, because we want the response to include the uid.
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
		$this->flashMessages->add('Disconnected!',Tx_Extbase_MVC_Controller_FlashMessage::TYPE_OK);
	}
	
	/**
	 * Join a Channel.
	 * 
	 * @param Tx_MvcExtjsSamples_Domain_Model_Channel $channel
	 * @param Tx_MvcExtjsSamples_Domain_Model_Chat $chat
	 * @return string
	 * @dontverifyrequesthash
	 */
	public function joinChannelAction(Tx_MvcExtjsSamples_Domain_Model_Channel $channel, Tx_MvcExtjsSamples_Domain_Model_Chat $chat) {
		$chat->addChannel($channel);
		$this->flashMessages->add('Channel: ' . $name . ' succesfully joined.',Tx_Extbase_MVC_Controller_FlashMessage::TYPE_OK);
		$this->view->assign('channel',$channel);
	}
	
	/**
	 * Query for new messages.
	 * 
	 * @param Tx_MvcExtjsSamples_Domain_Model_Chat $chat
	 * @return string
	 * @dontverifyrequesthash
	 */
	public function queryAction(Tx_MvcExtjsSamples_Domain_Model_Chat $chat = NULL) {
		t3lib_div::sysLog('lastMessage: ' . print_r($lastMessage,true),'MvcExtjsSamples',0);
		$messages = $this->messageRepository->findByLastQuery($chat);
		t3lib_div::sysLog('message: ' . print_r($messages,true),'MvcExtjsSamples',0);
		$chat->setLastQuery(new DateTime());
		$this->view->assign('messages',$messages);
	}
	
}

?>