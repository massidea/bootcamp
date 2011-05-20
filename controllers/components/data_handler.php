<?php
/**
 * DataHandler - class for Data Handling related things
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
 *  DataHandler  -  class
 *
 *  @package    Components
 *  @author     Jari Korpela
 *  @copyright  2011 Jari Korpela
 *  @license    GPL v2
 *  @version    1.0
 */ 
class DataHandlerComponent extends Object {
	
	protected $_privileges = array();
	
	function __construct() {
		$this->Nodes = Classregistry::init('Node');
	}
	
	/**
	 * array_unique_values
	 * Gets unique values from non associative array. Is faster than array_unique
	 * @author	Jari Korpela
	 * @param	array $array
	 * @return	array $array	 *
	 */
	public function array_unique_values($arr) {
		$res = array();
		foreach($arr as $key=>$val) {   
      		$res[$val] = true;
    	}
    	$res = array_keys($res); 
    	return $res;
	}
	
	/**
	 * striptagsAndTrimArrayValues
	 * Goes through array and trims its values and strips tags after trim
	 * @author	Jari Korpela
	 * @param	array $array
	 * @return	array $array	 *
	 */
	public function striptagsAndTrimArrayValues($arr) {
		$res = array();
		foreach($arr as $val) {
			$val = strip_tags(trim($val));
			if($val != "") {
      			$res[] = $val;
			}
    	}
    	return $res;
	}
	/**
	 * addHtmlSpecialCharsToArrayValues
	 * Goes through $data array and adds addHtmlSpecialChars to values
	 * @author	Jari Korpela
	 * @param	array $data - Data to which add addHtmlSpecialChars
	 * @return	array $newData - The same data array with addHtmlSpecialChars added	 *
	 */
	public function addHtmlSpecialCharsToArrayValues($data) {
		$newData = array();
		foreach($data as $k => $v) {
			$newData[$k] = htmlspecialchars($v);
		}
		return $newData;		
	}
	
	/**
	 * toExternals
	 * Forms' array data to string (#key[base64encoded value]#otherkey[...])
	 * @author	Jussi Raitanen
	 * @param	array $data - Associative array to form into string
	 * @return	string $data - Result string	 *
	 */
	public function toExternals($data = null) {	
		$externals = "";
		foreach ($data as $k => $v) {
			$v = base64_encode($v);
			$externals .= "#$k" . '[' . "$v" . ']';
		}
		return $externals;	
	}
	
	/**
	 * parseExternals
	 * Parses string data formatted as (#key[base64encoded value]#otherkey[...]) to array
	 * @author	Jussi Raitanen
	 * @param	string $data - Associative array to form into string
	 * @return	array $data - Result array
	 */
	public function parseExternals($data) {
		$custom_types = array();
		
		$start_tag = 0;
		$start_data = 0;
		$end_data = 0;
		$nest_level = 0;
		
		for($i=0; $i < strlen($data); $i++) {
			$c = $data[$i];
		
			if ($c == '#') {
			if ($nest_level == 0 )
				$start_tag = $i +1;
			}
		
			if ($c == '[') {
				$nest_level++;
				if ($nest_level == 1)
					$start_data = $i +1;
			}
		
			if ($c == ']') {
		                if ($nest_level == 1) {
		                        $end_data = $i -1;
		
					$tag = substr($data, $start_tag, $start_data - $start_tag -1);
					$type_data = substr($data, $start_data, $end_data - $start_data +1);
					$custom_types[$tag] = base64_decode($type_data);
				}
		                $nest_level--;
		        }
		}
		
		return $custom_types;
	}
	
	/**
	 * parseNamesToNodes
	 * @author	Jari Korpela
	 * @param 	array $dataNames - List of names
	 * @param 	string $dataType - Node type
	 * @param	boolean $unique - Defaults false, set only unique data names
	 * @return 	boolean false OR array $tags - If fails, returns false, else returns Array of nodes 
	 */
	public function parseNamesToNodes($dataNames,$dataType,$unique = false) {
		if(is_array($dataNames) && $dataType) {
			if($this->_privileges !== null) {
				if($unique) {
					$dataNames = $this->array_unique_values($dataNames);
				}
				$datas = array();
				foreach($dataNames as $name) {
					$datas[] = array('Node' => array(
											'name' => $name, // Set name
											'type' => $dataType), // Set node type so Node knows what we are saving
										'Privileges' => $this->_privileges // Set privileges
					); 
				}	
			} else {
				return false;
			}
		} else {
			return false;
		}
		return $datas;
	}
	
	/**
	 * parseToNodes
	 * Puts $dataOptions inside Node with $dataType. Also includes privileges
	 * @author	Jari Korpela
	 * @param	array $dataOptions - Options to add inside Node
	 * @param	string $dataType - Datatype to include in Node
	 * @return	array $datas - Returns the array of Nodes with privileges
	 */
	public function parseToNodes($dataOptions,$dataType) {
		if(is_array($dataOptions) && $dataType) {
			if($this->_privileges !== null) {
				$datas = array();
				foreach($dataOptions as $options) {
					$datas[] = array('Node' => array_merge($options,array('type' => $dataType)), // Set node type so Node knows what we are saving
									 'Privileges' => $this->_privileges // Set privileges
					); 
				}	
			} else {
				return false;
			}
		} else {
			return false;
		}
		return $datas;
	}
	
	
	/**
	 * saveData
	 * Saves datas and if objectId is given it also links saved datas to object id
	 * @author	Jari Korpela
	 * @param	array $datas - Array of node+privilege couples to be saved
	 * @param	int $objectId - ObjectId to link datas to
	 * @param	boolean $hardlink - Defaults false, sets the link type
	 * @return	mixed $result - If links were created successfully returns array with new object ids, else false
	 */
	public function saveData($datas,$objectId = -1, $hardlink = false) {
		$result = array();
		foreach($datas as $k => $data) { // We go through every new data.
			if($this->Nodes->save($data) !== false) { // check If saving was successfull
				$dataId = $this->Nodes->last_id(); // Get the saved id
				$result[$k] = $dataId;
				if($objectId != -1) {
					$this->Nodes->link($objectId,$dataId,$hardlink); // Link object_id and data_id
				}
			} else {
				return false;
			}
		}
		return $result;	
	}
	
	/**
	 * addLinkBetween
	 * Adds a link between object and array of nodes
	 * @author	Jari Korpela
	 * @param	int $objectId - The object id to link data to
	 * @param	array $datas - The data nodes to which to link to
	 * @param	boolean $hardlink - Defaults false, sets the link type
	 * @return	boolean $result - If links were created successfully returns true, else false
	 */
	public function addLinkBetween($objectId,$datas,$hardlink = false) {
		$result = true;
		foreach($datas as $data) {
			$result = $this->Nodes->link($objectId,$data['Node']['id'],$hardlink); // Link object_id and tag_id
			if(!$result) return false;
		}
		return $result;
	}
	
	/**
	 * getExistingDataNames
	 * Fetches existing $dataType datas from database that are in $dataNames
	 * @author	Jari Korpela
	 * @param	array $dataNames - Array for names to be checked
	 * @param	string $dataType - Type of data to check
	 * @return	array $existingData - Returns all existing data in Node
	 */
	public function getExistingDataNames($dataNames,$dataType) {
		$existingData = $this->Nodes->find(array('type' => $dataType, 'name' => $dataNames),array(),false);
		return $existingData;
	}
	
	/**
	 * getNewDataNames
	 * Fetches dataNames from databases that are not in $dataNames.
	 * If existingDataNames are alredy known it may be passed as third parameter to fasten operation.
	 * @author	Jari Korpela
	 * @param	array $dataNames - Array for names to be checked
	 * @param	string $dataType - Type of data to check
	 * @param	array $existingData - If we know the existingDataNames already it may be passed as third parameter
	 * @return	array $existingData - Returns all existing data in Node	 *
	 */
	public function getNewDataNames($dataNames, $dataType, $existingData = array()) {
		if(empty($existingData)) {
			$existingData = $this->Nodes->find(array('type' => $dataType, 'name' => $dataNames),array(),false);
		}
		$newDataList = array();
		foreach($existingData as $data) {
			$newDataList[] = $data['Node']['name'];
		}
		
		$newData = array_diff($dataNames,$newDataList);
		return $newData;
		
	}
	
	/**
	 * setPrivileges
	 * Sets what privileges to use for all data handling
	 * @author	Jari Korpela
	 * @param	array $privileges - if empty array is passed the default privileges is used
	 * @return	boolean - Returns true if privileges were set, else false
	 */
	public function setPrivileges($privileges) {
		if(is_array($privileges)) {
			if(!isset($privileges['privileges'])) {
				$privileges['privileges'] = 777;
			}
			if(!isset($privileges['creator'])) {
				$privileges['creator'] = NULL;
			}	
			$this->_privileges = array('privileges' => $privileges['privileges'], 'creator' => $privileges['creator']);
			return true;
		}
		return false;
	}
	
	public function removeLinksBetweenNodes($parentId,$childs) {
		foreach($childs as $child) {
			$this->Nodes->removeLink($parentId, $child['id']);
		}		
	}
	
}
