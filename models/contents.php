<?php
class Contents extends AppModel {
	var $name = 'Contents';
	var $displayField = 'title';
	
	var $validate = array(
		'title' => array(
			'maxlength' => array(
				'rule' => array('maxlength',140)
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'lead' => array(
			'maxlength' => array(
				'rule' => array('maxlength',320),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'body' => array(
			'maxlength' => array(
				'rule' => array('maxlength',4000),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'references' => array(
			'maxlength' => array(
				'rule' => array('maxlength',2000),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),

	);
	
/*
	var $hasOne = array(
		'Baseclass' => array(
			'className' => 'Baseclass',
			'foreignKey' => 'id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);*/
}
?>
