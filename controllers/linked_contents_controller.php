<?php
/**
 *  LinkedContentsController
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
 *  LinkedContentsController - class
 *  For Linking things together (Do not get mixed up by word "contents", it means any kind of content, like campaigns etc.)
 *	TODO: User checks when users done.
 *  @package        controllers
 *  @author         Jari Korpela
 *  @copyright      Jari Korpela
 *  @license        GPL v2
 *  @version        1.0
 */
 
class LinkedContentsController extends AppController {
	public $uses = array('LinkedContent','Contents','Tags','RelatedCompanies');
	public $components = array('RequestHandler');
	public $helpers = null; //Set helpers off
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->autoRender = false;
		$this->autoLayout = false;

	}
		
	/**
	 * contentLinkSearch action - method
	 * Searches contents linked contents
	 * TODO: Get only logged in users contents
	 * @author Jari Korpela
	 */
	public function contentLinkSearch() {
		if ($this->RequestHandler->isAjax()) {
			if (!empty($this->data)) {
				$title = $this->data['Content']['title'];
				$id = $this->data['Content']['id'];
				
				$contents; //Here should be code that finds contents
				//$contents = $this->Nodes->find(array('type' => 'Content', 'published' => 1),array('order' => 'title DESC'),true);
				if(empty($contents)) { echo "[]";die; }

				$contentLinks = $this->LinkedContent->find('all',array('conditions' => array('from' => $id)));
				$links = array();
				foreach($contentLinks as $link) {
					$links[] = $link['LinkedContent']['to'];
				}
							
				$parsedContents = array();
	            foreach($contents as $content) {
	            	if(!in_array($content['Node']['id'],$links)) {
		            	$parsedContents[] = array('id' => $content['Node']['id'],
		            							'class' => $content['Node']['class'],
		            							'title' => $content['Node']['title']);
	            	}
	            }
	         
	            echo json_encode($parsedContents);
			}
		}
	}
	
	/**
	 * add action - method
	 * Links two things together
	 * TODO: Data validation and check that user who tries to add the link has privileges
	 * @author Jari Korpela
	 */
	public function add() {
		if ($this->RequestHandler->isAjax()) {
			if (!empty($this->params['form'])) {
				$to = $this->params['form']['to'];
				$from = $this->params['form']['from'];
				
				echo 1;
			}
		}
	}
	
	/**
	 * delete action - method
	 * Deletes a link between Ids
	 * TODO: Data validation and check that user who tries to delete the link has privileges
	 * @author Jari Korpela
	 */
	public function delete() {
		if ($this->RequestHandler->isAjax()) {
			if (!empty($this->params['form'])) {
				$to = $this->params['form']['to'];
				$from = $this->params['form']['from'];

				echo 1;
			}
		}
	}
}