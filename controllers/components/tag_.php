<?php
/**
 * Tag_Component - class for tag managing
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
 *  Tag_ -  class
 *
 *  @package    Components
 *  @author     Jari Korpela
 *  @copyright  2011 Jari Korpela
 *  @license    GPL v2
 *  @version    1.0
 */ 

class Tag_Component extends Object {
	var $components = array('DataHandler');
	
	private $__type = 'Tag';
	protected $_tags = array();
	protected $_tagList = array();
	protected $_newTags = array();
	protected $_newTagList = array();
	protected $_existingTags = array();
	protected $_privileges = array('privileges' => 777, 'creator' => NULL);
		
	public function linkTagsToObject($objectId = -1) {
		if($objectId != -1) {
			$this->DataHandler->addLinkBetween($objectId,$this->_existingTags);
			$this->DataHandler->saveData($this->_newTags,$objectId); //Needs to make to work :O
		} else {
			return false;
		}
	}
	
	public function removeLinksToObject($objectId = -1) {
		if($objectId != -1) {
			$this->DataHandler->removeLinkBetween($objectId,$this->_existingTags); //Luomatta
		} else {
			return false;
		}
	}
	
	/**
	 * setTagsForSave
	 * @param string $tags
	 * @return Object Tag_Component
	 */
	public function setTagsForSave($tags) {
		$tags = explode(',',$tags); // Get tags to array
		$tagList = $this->DataHandler->striptagsAndTrimArrayValues($tags); // Trims of whitespaces etc.
		
		$this->DataHandler->setPrivileges($this->_privileges); // Privileges must be set before parsing is possible		
		$tags = $this->DataHandler->parseNamesToNodes($tagList,$this->__type,true);
		
		$existingTags = $this->DataHandler->getExistingDataNames($tagList,$this->__type);
		
		$newTagList = $this->DataHandler->getNewDataNames($tagList,$this->__type,$existingTags);
		$newTags = $this->DataHandler->parseNamesToNodes($newTagList,$this->__type,true);
				
		$this->_tagList = $tagList;
		$this->_tags = $tags;
		$this->_newTagList = $newTagList;
		$this->_newTags = $newTags;
		$this->_existingTags = $existingTags;
		
		return $this;
	}
	
	
	public function getTags() {
		return $this->_tags;
	}
	
	public function getNewAndExistingTags() {
		return array_merge($this->_newTags,$this->_existingTags);
	}
		
	
}

