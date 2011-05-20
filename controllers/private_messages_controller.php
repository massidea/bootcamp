<?php
/**
 *  PrivateMessagesController
 *
 *  This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License
 *  as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied
 *  warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for
 *  more details.
 *
 *  You should have received a copy of the GNU General Public License along with this program; if not, write to the Free
 *  Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
 *
 *  License text found in /license/
 */

/**
 *  PrivateMessages - class
 *  Handles private messages
 *
 *  @package        controllers
 *  @author         Jari Korpela
 *  @copyright      
 *  @license        GPL v2
 *  @version        1.0
 */

class PrivateMessagesController extends AppController {
	var $components = array('RequestHandler');
	
	public function beforeFilter() {
		parent::beforeFilter();

	}
	
	public function send() {
		$this->autoRender = false;
		$this->autoLayout = false;
		
		if ($this->RequestHandler->isAjax()) {
            if (!empty($this->data)) {
            	//When users are ready this needs validation because data can be altered by end user.
            	$this->data['PrivateMessage']['sender'] = 2; //Should be replaced with user id from session when they are ready!
				if($this->PrivateMessage->save($this->data)) {
					echo 1;
				} else {
					die;
				}
            }
		} else {
			$this->redirect('/');
		}
	}
	
	
	
}