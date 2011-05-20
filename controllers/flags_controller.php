<?php
/**
 *  FlagsController
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
 *  FlagsController - class
 *  For Flagging things
 *	TODO: User checks when users done.
 *  @package        controllers
 *  @author         Jari Korpela
 *  @copyright      Jari Korpela
 *  @license        GPL v2
 *  @version        1.0
 */
 
class FlagsController extends AppController {
	var $components = array('RequestHandler');
	public $helpers = null; //Set helpers off
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->autoRender = false;
		$this->autoLayout = false;

	}
	
	protected function _getFlagPage($type,$getUrlString = true, $params = null) {
		$flagPages = array(
			'Content' => array('controller' => 'contents', 'action' => 'view')
		);
		
		$url = $flagPages[$type];
		if(empty($url)) {
			return null;
		} else {
			if(isset($params) && is_array($params)) {
				$url = array_merge($flagPages[$type],$params);
			} else {
				$url = $flagPages[$type];
			}
			
			if($getUrlString) {
				return Router::url($url);
			} else {
				return $url;
			}
		}
	}
	
	public function add() {
		if ($this->RequestHandler->isAjax()) {
			echo 1; die;
			if (!empty($this->data)) {
				$page = $this->_getFlagPage($this->data['flag']['type'],true,array($this->data['flag']['id']));
				
				var_dump($page);
			}
		}
	}

}