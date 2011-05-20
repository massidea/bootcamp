<?php
class LibloaderComponent extends Object {

	function initialize($Controller) {
    	$this->Controller = $Controller;
	}
	
	/**
	 * loadLib
	 * Enables loading 1st party librarys from controllers action
	 * 
	 * @param	array $libs Key as library name and Value as Options ['file'], ['className']
	 * @return	null
	 * @author	Jari Korpela
	 */
	function loadLib($libs = array()) {
	    foreach ($libs as $libName => $options) {
	    	$path = $options['file'];
	    	$className = $options['className'];
	
	        if (isset($this->Controller->{$libName})) {
	            continue;
	        }
	        App::import('Lib', $libName, array('file' => $path));
	        
	        $lib = new $className;
	        $this->Controller->{$libName} = $lib;
	    }
	}
	
}