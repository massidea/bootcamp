<?php
/**
 *  AppControllerr
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
 *  AppControllerr - class
 *
 *  @package        controllers
 *  @author         Jari Korpela
 *  @copyright      
 *  @license        GPL v2
 *  @version        1.0
 */

//App::import('i18n'); Needed for translations
App::import('Lib', 'Jsmeta', array('file' => 'jsmeta.php'));

class AppController extends Controller {
	public $layout = 'layout';
	public $helpers = array('Session','Html','Form','Cache');
	public $components = array('Session');
	public $Nodes;
	
	public function beforeFilter() {
		$this->set('title_for_layout','Massidea.org');
		$this->Nodes = Classregistry::init('Node');
		$this->Nodes->map = array('RelatedCompany' => 'RelatedCompanies');
		
		/**
		 * Setting content class
		 * 
		 * content_class is used to define how the page is viewed. Default contentWithSidebar.
		 * Should be overridden in controller if wished to use other class.
		 */
		$this->set('content_class','contentWithSidebar');
		//End of automated class load for content
	}
	
	public function beforeRender() {
		/**
		 * Automated CSS load
		 * 
		 * $cssFiles array is used to automatically load controller and action specific CSS files for layout if either one exists.
		 * 
		 * We search for controller specific CSS file from: css/controller/controller.css
		 * Then we search for action specific CSS file from: css/controller/action.css
		 * After searches, we set this array to $css_for_layout for layout
		 * 
		 */
		$cssFiles = array();
		if (file_exists(CSS . DS . strtolower($this->name) . DS . strtolower($this->name) . '.css')) {
			$cssFiles[] = strtolower($this->name) . DS . strtolower($this->name);
        }
        if (file_exists(CSS . DS . strtolower($this->name) . DS . $this->action . '.css')) {
            $cssFiles[] = strtolower($this->name) . DS . $this->action;
        } 
		$this->set('css_for_layout',$cssFiles);
		//End of automated CSS load
				
		/**
		 * Jsmeta - Inject JSON encoded PHP variables for Javascript access (hidden metabox in layout)
		 * Uses jsmeta.php in libs
		 */
		$Jsmeta = new Jsmeta();
		$this->set('Jsmeta',$Jsmeta->append("baseUrl",$this->base));
		
		
	}

}