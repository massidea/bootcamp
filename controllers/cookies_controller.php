<?php
/**
 *  CookiesController
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
 *  CookiesController - class
 *  
 *  WARNING: When setting new cookie operation you MUST make sure that you dont use parameters directly but ALWAYS compare them to the specifically allowed strings.
 *  		 If they are not checked, it's possible to add whatever types and values to cookies. 
 *  
 *  @See getGroups() at Cookievalidation component
 *
 *	This controller is intended to use via jQuerys' ajax request function: saveToCookie(page, event, type, value, successMsg) defined in global.js
 *	The cookies should be made inside PHP to make sure they are not abused.
 *
 *  @package        controllers
 *  @author         Jari Korpela
 *  @copyright      2011 Jari Korpela
 *  @license        GPL v2
 *  @version        1.0
 */

class CookiesController extends AppController {
	public $components = array('RequestHandler','Cookie','Cookievalidation'); //Get Cookie component ofcourse :)
	public $helpers = null; //Set helpers off
	public $uses = null; //Set model off
	
	public function beforeFilter() {
		//Set all layout related and unused things off
		parent::beforeFilter();
		$this->autoRender = false;
		$this->autoLayout = false;
		$this->Nodes = null;
		$this->_initCookieSettings(); //Initialize basic settings for Cookies Controller
	}
	
	/**
	 *  _initCookieSettings
	 *  Sets basic settings for Cookies like time and name
	 *  
	 *  @see	beforeFilter()
	 *  @author Jari Korpela
	 */
	protected function _initCookieSettings() {
		$this->Cookie->time = 999999999; //Approx. 30 years
		$this->Cookie->name = 'CakeCookie'; //Default name set
		return;
	}
	
	/**
	 *  _setCookiePath
	 *  Used to define the path of cookie
	 *  
	 *  @see setcookie()
	 *  @author Jari Korpela
	 */
	protected function _setCookiePath($page) {
		$path = Inflector::underscore($page);
		$path = $this->base.'/'.str_replace('_','/',$path);
		$this->Cookie->path = $path;
		return $path;
	}
	
	/**
	 * _saveCookie
	 * Saves cookie and checks that its type and value matches to what is defined in group
	 * 
	 * @param	array	$group	Group information
	 * @param	string	$type	Cookie type to be saved
	 * @param	string	$value	Cookie value to be saved
	 * 
	 * @return	int		$return	Returns 1 if saving is successfull and 0 if not
	 * @see		setcookie()
	 * @author	Jari Korpela	 *
	 */
	protected function _saveCookie($group,$type,$value) {
		$return = 0;
		
		if(in_array($type,$group['types']) && (in_array($value,$group['values'])) && isset($group['name'])) {
			$this->Cookie->write($group['name'].'.'.$type,$value);
			$return = 1;
		} 
		
		return $return;
	}
	

	
	/**
	 *  Add
	 *  Used to set cookies withing site.
	 *  Doesn't really have params as they come from ajax post event
	 *  "Returns" int $result by echoing it if use of the function is correct, otherwise dies.
	 *  $result is 0 if cookie setting failed and 1 if success. 
	 *  Cookie setting can only fail if there is an error in data set in _getGroups, for example name is missing.
	 *  
	 *  @param	string $page 	This parameter is used to find out the controller and view for path
	 *  @param	string $event	Event is groups' name
	 *  @param	string $type 	Type is cookies' name
	 *  @param	string $value 	Value represents cookies' value
	 *  
	 *  @author Jari Korpela $page = null, $event = null, $type = null, $value = null
	 */
	public function add() {
		if ($this->RequestHandler->isAjax()) {
            if (!empty($this->params['form'])) {
            	$page = $this->params['form']['page'];
            	$event = $this->params['form']['event'];
            	$type = $this->params['form']['type'];
            	$value = $this->params['form']['value'];
            	
				if(empty($page) || empty($event)) { die; }
				$result = 0;
				$groups = null;
				$pages = array('contentsView'); //Possible Pages to set cookies to.
				
				if(in_array($page,$pages)) {
					$this->_setCookiePath($page);
					$groups = $this->Cookievalidation->getGroups($page);
				} else { die; }
			
				if(!empty($groups)) {
					$result = $this->_saveCookie($groups[$event],$type,$value); //$result gets 1 if saving is successfull and 0 if fails
				} else { die; }
				
				echo $result;
            }
		} else {
			$this->redirect('/');
		}
	}
	

}
