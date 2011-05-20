<?php echo $this->Html->script('elements'.DS.'private_message',array('inline' => false)); ?>

<div id="send_private_message" title="Send private message" class="hidden">
	<p>You have <span id="privateMessageCharacters">1000</span> characters left.</p>
	<?php echo $form->create('PrivateMessage', array('url' => '#','inputDefaults' => array('div' => false), 'id' => 'PrivateMessageForm')); ?>
	
	<label for="PrivateMessageTo">To</label>
	<p id="PrivateMessageTo"></p>
	
	<?php echo $form->hidden('receiver', array('value' => 0)); ?>

	<?php echo $form->input('message', array('type' => 'text',
											'label' => 'Message')
	); ?>	
	
	<?php echo $form->end(); ?>
</div>