<?php
/**
 * Cookievalidation
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License 
 * as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied  
 * warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for  
 * more details.
 * 
 * You should have received a copy of the GNU General Public License along with this program; if not, write to the Free 
 * Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * License text found in /license/
 */

/**
 *  Cookievalidation -  class
 *
 *  @package    Components
 *  @author     Jari Korpela
 *  @copyright  2011 Jari Korpela
 *  @license    GPL v2
 *  @version    1.0
 */ 
class CookievalidationComponent extends object {
	
	public $components = array('Cookie');
	protected $chosenGroups = array();
	protected $event = null;
	private $controller;
	
	function initialize(&$controller) {
		$this->controller = $controller;
	}
	/**
	 *  getGroups
	 *  Function to get cookie groups and their defined types and values
	 *  
	 *  @param	string	$page	We need a $page to choose correct groups	
	 *  @param	string	$event	Optional. Can be used to fetch specific group
	 *  @return	array	$groups	Returns chosen groups based on $page
	 *  
	 *  @see	setcookie()  
	 *  @author Jari Korpela
	 */
	public function getGroups($page, $event = null) {

		$groups = null;
		/*	Here we just set the cookie groups used. 
		 *  Name is required for code convenience
		 *  Default value is used for all types if the cookie does not exist yet
		 *	Types should be types that you want to check $type on
		 *	Values should be types that you want to check $value on
		 *	
		 *	Notice that switch is a loose comparison but the $page is checked in case-sensitive manner BEFORE it is sent to this function.
		*/
		switch($page){
			case 'contentsView':
				$groups = array('expandStatus' => 
							array('name' => 'expandStatus',
								'default' => 'block',
								'types' => array('linked'),
								'values' => array('none','block'))
				); break;
			
				
			default: $groups = null;
		}
	
		if(!empty($event) && isset($groups[$event])) {
			$groups = $groups[$event];
			$this->event = $event;
		}
		
		$this->chosenGroups = $groups;
		return $groups;
	}
	
	/**
	 * doMatchCheck
	 * Checks if given cookies are in valid groups
	 * Requires that getGroups is run with event parameter before this can be executed
	 * 
	 * @param	array $cookies		Array of cookies to be checked
	 * @return	mixed $validCookies	Returns false if cookies are not set or groups not set by getGroups, otherwise returns valid cookies.
	 * @author	Jari Korpela
	 */
	public function doMatchCheck($cookies = array()) {
		if(is_array($cookies) && !empty($cookies) && isset($this->chosenGroups) && !empty($this->event)) {
			$validCookies = array();
			foreach($cookies as $name => $value) {
				if(in_array($name,$this->chosenGroups['types']) && (in_array($value,$this->chosenGroups['values']))) {
					$validCookies[$name] = $value;
				}
			}
		} else {
			return false;
		}
		return $validCookies;
	}
	
	/**
	 * useDefaults
	 * Used when user does not have the cookies set
	 * 
	 * @return	array $defaultValues	Returns the defined default values for cookie
	 * @author	Jari Korpela	 *
	 */
	public function useDefaults() {
		if(isset($this->chosenGroups) && !empty($this->event)) {
			$defaultValues = array();
			foreach($this->chosenGroups['types'] as $type) {
				$defaultValues[$type] = $this->chosenGroups['default']; 
			}
		} else {
			return false;
		}
		return $defaultValues;
	}
	
	public function getAndValidateCookies($event) {
		$cookies = $this->Cookie->read($event);
		$page = Inflector::variable($this->controller->name.'_'.$this->controller->action);
		$this->getGroups($page,$event);
		if(!empty($cookies)) {
			$validCookies = $this->doMatchCheck($cookies);
		} else {
			$validCookies = $this->useDefaults();
		}
		return $validCookies;
	}

	
}