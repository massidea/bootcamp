<?php echo $form->create(null, array('url' => array('controller' => 'search',
													'action'	 => 'global'),
									'type' => 'post')); ?>


<div id="search-field">
<?php echo $form->text('globalSearch', array('class' => 'top_search_field',
											'id' 	 => 'globalSearch',
											'name' 	 => 'globalSearch')); ?>
</div>
	
<?php echo $form->end(array('name' 	=> 'submitsearch',
							'label' => 'Search',
							'class' => 'submit-button',
							'id'	=> 'submitsearch',
							'alt'	=> 'Search',
							'div' 	=> array('id' 	=> 'search-submit',
											'class' => null))); ?>