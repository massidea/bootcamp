<?php echo $this->Html->script('elements'.DS.'flag',array('inline' => false)); ?>
<?php $flagTypes = array('Spam',
						'Sexual content',
						'Violent or Repulsive content',
						'Hateful or Abusive content',
						'Copyright violation',
						'Other'
						
); ?>
<div id="flag-page" title="Flag as inappropriate" class="hidden">
	<?php echo $form->create('flag',array('action' => 'add')); ?>
	<?php echo $form->input('type', array('type' => 'select', 'options' => $flagTypes, 'label' => 'Select a reason: ')); ?>
	<div class="margin-top">
	<?php echo $form->input('description', array('type' => 'textarea',
											'rows' => 5,
											'cols' => 50,
											'label' => 'Description (Optional)')
	); ?>
	</div>
	<p>You have <span id="flagCharacters">1000</span> characters left.</p>
	<?php echo $form->end(); ?>
			
</div>