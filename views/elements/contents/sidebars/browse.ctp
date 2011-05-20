<?php if($content_type === 'all'): ?>
	<?php echo $this->element('contents'.DS.'what_is_massidea', array('cache' => true));  ?>
	
	<?php echo $this->element('contents'.DS.'sign_up_link', array('cache' => true));  ?>
	
	<?php echo $this->element('contents'.DS.'recent_campaigns', array('cache' => true));  ?>
	
	<?php echo $this->element('contents'.DS.'recent_groups', array('cache' => true));  ?>
	
	<?php echo $this->element('contents'.DS.'most_active_users', array('cache' => true));  ?>

<?php else: ?>
	<?php echo $this->element('contents'.DS.'what_is_'.$content_type, array('cache' => true));  ?>
	
	<?php echo $this->element('contents'.DS.'most_viewed_'.$content_type, array('cache' => true));  ?>
<?php endif; ?>

<?php echo $this->element('contents'.DS.'most_popular_tags', array('cache' => true));  ?>

<?php echo $this->element('contents'.DS.'missing_feature', array('cache' => true));  ?>