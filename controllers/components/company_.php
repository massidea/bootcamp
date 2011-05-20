<?php
/**
 * CompanyComponent - class for company managing
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
 *  Company -  class
 *
 *  @package    Components
 *  @author     Jari Korpela
 *  @copyright  2011 Jari Korpela
 *  @license    GPL v2
 *  @version    1.0
 */ 

class Company_Component extends Object {
	var $components = array('DataHandler');
	
	private $__type = 'RelatedCompany';
	protected $_companies = array();
	protected $_companiesList = array();
	protected $_newCompanies = array();
	protected $_newCompaniesList = array();	
	protected $_existingCompanies = array();
	protected $_privileges = array('privileges' => 777, 'creator' => NULL);
		
	public function linkCompaniesToObject($objectId = -1) {
		if($objectId != -1) {
			$this->DataHandler->addLinkBetween($objectId,$this->_existingCompanies);
			$this->DataHandler->saveData($this->_newCompanies,$objectId);
		} else {
			return false;
		}
	}

	public function setCompaniesForSave($companies) {
		$companies = explode(',',$companies); // Get tags to array
		$companyList = $this->DataHandler->striptagsAndTrimArrayValues($companies); // Trims of whitespaces etc.
		
		$this->DataHandler->setPrivileges($this->_privileges); // Privileges must be set before parsing is possible		
		$companies = $this->DataHandler->parseNamesToNodes($companyList,$this->__type,true);
		
		$existingCompanies = $this->DataHandler->getExistingDataNames($companyList,$this->__type);
		
		$newCompanyList = $this->DataHandler->getNewDataNames($companyList,$this->__type,$existingCompanies);
		$newCompanies = $this->DataHandler->parseNamesToNodes($newCompanyList,$this->__type,true);
				
		$this->_companiesList = $companyList;
		$this->_companies = $companies;
		$this->_newCompanyList = $newCompanyList;
		$this->_newCompanies = $newCompanies;
		$this->_existingCompanies = $existingCompanies;
		
		return $this;
	}
	
	public function getCompanies() {
		return $this->_companies;
	}
	
	public function getNewAndExistingCompanies() {
		return array_merge($this->_newCompanies,$this->_existingCompanies);
	}
	
}


