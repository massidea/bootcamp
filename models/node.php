<?php

/**
* @author Jussi Raitanen <jussi.raitanen@samk.fi>
* @package Model
*/

App::import('Model','Baseclass');



/**
* @package Model
*/
class Node extends AppModel {
	var $name = 'Node';
	var $useTable = false;
	var $TableModel = null;
	var $last_id = null;
	var $other = array();
	private $_map = array();
	private $_map_keys = array();
	private $_join = array();
	private $_cache = true;

/**
* Deletes a record or multiple records based on criteria.
* @param mixed $id Can be passed as an array or a single id.
* @param boolean $cascade Not used.
*/
	function delete($id = null, $cascade = true) {

		if (!is_array($id)) {
			$this->query("set @real_delete = 0");
			$this->query("delete from baseclasses where id = $id");
			$this->query("delete from deleted");
		} else {
			$bc = new Baseclass();
			$bc->deleteAll($id);
		}

		if ($this->_cache) {
			$hash = $this->_createHash($id);
        	        $obj = Cache::delete('Node:'.$hash);
		}
	}

/**
* Returns all nodes that matches the criteria.
* @param mixed $id Can be passed as an array or a single id.
* @param array $params See CakePHP find
* @param boolean $walk Can be used to find all objects that relates directly.
*/
	function find($id = null, $params = array(), $walk = true) {

		if ($this->_cache) {
			$hash = $this->_createHash($id);
        	        $obj = Cache::read('Node:'.$hash);

			if ($obj !== false) {
				return $obj;
			}
		}

		$bc = new Baseclass();
		$class = get_class($bc);

		if(is_array($id)) {
			if ($type = isset($id['type']) ? $id['type'] : null ) {

				$inst = $this->get_type($type);

				$bc = new $inst();
				$class = get_class($bc);
			}

			$_type = $inst;
			unset($id['type']);

			$basejoin = array('table' => 'baseclasses', 'alias' => 'Privileges', 'type' => 'left', 'conditions' => array("Privileges.id = $_type.id") );
			$joins = array($basejoin);
			if ($this->_join) {
				foreach ($this->_join as $j)
				$joins[] = $j;
			}


			$cond = array('conditions' => $id, 'fields' => array('*'), 'joins' => $joins );
			$cond = array_merge($cond, $params);

			$result = $bc->find('all', $cond);


			$nodes = null;

			$index = 0;
			foreach ($result as $res) {
				$result[$index]['Node'] = $result[$index][$class];
				unset($result[$index][$class]);
				$index++;
			}



			if ($walk) {
			foreach ($result as $res) {
				static $node_id = 0;
				$node = $this->find($res['Node']['id']);

				$node = isset($node[0]) ? $node[0] : $node;
				$nodes[$node_id] = $node;
				$node_id++;
			}

			if ($this->_cache)
				$this->writeCache($hash, $nodes);

			return $nodes;
			}

			if ($this->_cache)
				$this->writeCache($hash, $result);


			return $result;
		} else {

		$m = $bc->query("select * from mapping as o2, baseclasses as o1 inner join baseclasses as o3 on o1.id where o2.parent_object = o1.id and o3.id=o2.child_object and o1.id = $id;");
		$obj = null;

		if($m) {
		$inst = $this->get_type($m[0]['o1']['type']);

		$basejoin = array('table' => 'baseclasses', 'alias' => 'Privileges', 'type' => 'left', 'conditions' => array("Privileges.id = $inst.id") );
                $joins = array($basejoin);
                if ($this->_join) {
                	foreach ($this->_join as $j)
                        	$joins[] = $j;
                }

                $cond = array('conditions' => array("$inst.id" => $id), 'fields' => array('*'), 'joins' => $joins );

		$t = new $inst();
		$node = $t->find('all',$cond);
		$node[0]['Node'] = $node[0][$inst];
		unset($node[0][$inst]);
		$obj = $node;

                foreach ($m as $d) {
			$id = $d['o3']['id'];
			$inst = $this->get_type($d['o3']['type']);

			$t = new $inst();
			$result = $t->find(array('id' => $id));
			$object = $result[$inst];

			$obj[0]['Child'][] = $object;
                }
		
		} else {
			$res = null;
			$inst = null;

			$res = $bc->find(array('id' => $id));
			if ($res)
				$inst = $this->get_type($res['Baseclass']['type']);

			if ($inst) {
				$t = new $inst();
				$_type = $inst;
				$basejoin = array('table' => 'baseclasses', 'alias' => 'Privileges', 'type' => 'left', 'conditions' => array("Privileges.id = $_type.id") );
	                        $joins = array($basejoin);
				if ($this->_join) {
                	                foreach ($this->_join as $j)
        	                        $joins[] = $j;
	                        }
				
				$cond = array('conditions' => array("$inst.id" => $id), 'fields' => array('*'), 'joins' => $joins );
				$node = $t->find('all', $cond); //array('id' => $id));
				$node[0]['Node'] = $node[0][$inst];
				unset($node[0][$inst]);

				if ($this->_cache)
					$this->writeCache($hash, $node);

				return $node;
			}

		}

		if ($this->_cache)
			$this->writeCache($hash, $obj);

		return $obj;
		}
	}

	function writeCache($hash, $obj) {
		if ($this->_cache)
			Cache::write('Node:'.$hash, $obj);
	}


/**
* Inserts a new object or modifies existing object.
* @param array $data Actual node to be saved
*/
	function save($data) {

		if(!isset($data['Node']['type']))
			return NULL;

		$bc = new Baseclass();

		$type = $this->get_type($data['Node']['type']);


		$inst = $type;
		@$base_data['type'] = $data['Node']['type'];
		@$base_data['creator'] = $data['Privileges']['creator'];
		@$base_data['privileges'] = $data['Privileges']['privileges'];
		
		if (isset($data['Node']['id']))
			$base_data['id'] = $data['Node']['id'];

		$bc->save($base_data);
		$last_id = $bc->getLastInsertId();

		if ($last_id)
			$data['Node']['id'] = $last_id;

		$node_data = $data['Node'];

		$this->last_id = $data['Node']['id'];

		$t = new $inst();
		$success = $t->save($node_data);

		$id = (string)$node_data['id'];

		if ($this->_cache) {
                	$hash = $this->_createHash($id);
                	$obj = Cache::delete('Node:'.$hash);
		}

		return $success;
	}

/**
* Creates a sha1 hash from passed value.
* @param mixed $value
*/
	function _createHash($value) {

		$tmp = null;

		foreach ($this->_join as $join) {
			foreach ($join as $v) {
				$tmp .= is_array($v) ? implode($v) : $v;
			}
		}


                if (is_array($value)) {
			foreach ($value as $v)
				$tmp .= is_array($v) ? implode($v) : $v;
		}
                else
                        $tmp .= (string)$value;

                $hash = sha1($tmp);

		return $hash;
	}

/**
* Links together two nodes.
* @param integer $parent Parent node
* @param integer $child Child node
* @param boolean $hardlink If hardlink is true and parent is deleted then the child node will be deleted automatically. 
* @return Returns true if linked successfully otherwise false
*/
	function link($parent, $child, $hardlink = true) {

		$parent_node = $this->find($parent);
		$child_node = $this->find($child);
		$found = null;

		$res = null;

		if ($parent_node[0]['Node']['type'] == $child_node[0]['Node']['type']) {
			$found = $this->query("select count(`from`) as found from linked_contents where `from` = $parent and `to` = $child");
			if ($found[0][0]['found'] == '1')
				return true;

			@$res = $this->query("insert into linked_contents(`from`,`to`,`created`) values($parent,$child,now())");
		} else {
			$found = $this->query("select count(parent_object) as found from mapping where parent_object = $parent and child_object = $child");
			if ($found[0][0]['found'] == '1')
				return true;
			$hardlink = (int)$hardlink;
			$res = @$this->query("insert into mapping(parent_object,child_object,hardlink) values($parent,$child,$hardlink)");
		}


		if ($this->_cache) {
	                $phash = $this->_createHash($parent);
	                $chash = $this->_createHash($child);

                	Cache::delete('Node:'.$phash);
                	Cache::delete('Node:'.$chash);
		}

		if ($res)
			return $res;
		return false;
	}

/**
* Removes the link between two nodes.
* @param integer $parent Parent node
* @param integer $child Child node
*/
	function removeLink($parent, $child) {

                $parent_node = $this->find($parent);
                $child_node = $this->find($child);
		$res = null;

		if ($parent_node[0]['Node']['type'] == $child_node[0]['Node']['type']) {
			@$res = $this->query("delete from linked_contents where `from` = $parent and `to` = $child");
		} else {
			@$res = $this->query("delete from mapping where parent_object = $parent and child_object = $child");
		}

		if ($this->_cache) {
			$phash = $this->_createHash($parent);
        	        $chash = $this->_createHash($child);

                	Cache::delete('Node:'.$phash);
                	Cache::delete('Node:'.$chash);
		}

		return $res;
	}

/**
* Returns last inserted id
*/
	function last_id() {
		return $this->last_id;
	}

	function __set($name, $value) {
		if ($name == 'map') {
			$this->_map = array_merge($this->_map, $value);
			$this->_map_keys = array_keys($this->_map);
			return;
		}
		if($name == 'join') {
			foreach ($value as $v)
				$this->_join[] = $v;
		}
		if($name == 'cache') {
			$this->_cache = $value;
		}
	}

	function __get($name) {
/*		$$name = Classregistry::init($name);
		$s = $$name->find('all');
		$this->other[$name] = "LELE";
		return $this;
*/
	}

/**
* Returns node type
* @param mixed $parent Node type
*/
	private function get_type($type) {
		$inst = null;
		if (!in_array($type, $this->_map_keys))
	                $inst = $type . 's';
                else
        	        $inst = $this->_map[$type];

		return $inst;
	}

}

?>
