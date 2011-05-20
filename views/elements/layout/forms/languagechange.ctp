<?php

echo $form->create(null, array('url' => array('controller'  => 'language',
												'action'	=> 'change'),
												'type' 		=> 'post',
												'enctype'	=> 'application/x-www-form-urlencoded',
												'id'		=> 'translation_form'));

echo $form->select('translation_select',
						array('fi' => 'Finnish'),
						null,
						array('empty' => false));

echo $form->end(array('name'  => 'submit',
					'label' => 'submit',
					'class' => 'hidden',
					'id'	=> 'submit',
					'div' 	=> false
					)); 
							
?>