<?php 

$url_add_challenge = $html->url(array('controller' => 'contents', 'action' => 'add', 'challenge', $contentId));
$url_add_idea = $html->url(array('controller' => 'contents', 'action' => 'add', 'idea', $contentId));
$url_add_vision = $html->url(array('controller' => 'contents', 'action' => 'add', 'vision', $contentId));
?>

<div id="add_new_link">
	<?php echo $form->create('Content', array('url' => array('controller' => 'contents', 'action' => 'linksearch'),
												'id' => 'ContentsLinkForm', 'class' => 'left')); ?>
	<?php echo $form->hidden('id', array('value' => $contentId)); ?>
	<?php echo $form->input('title',array('label' => 'Search: ')); ?>
	<?php echo $form->end(); ?>
	<div id="add_new_link_buttons" class="right">
		<a href="<?php echo $url_add_vision; ?>" class="margin border-vision " >New vision</a>
		<a href="<?php echo $url_add_idea; ?>" class="margin border-idea " >New idea</a>
		<a href="<?php echo $url_add_challenge; ?>" class="margin border-challenge " >New challenge</a>
	</div>
	<div class="clear"></div>
	<?php echo $form->create('LinkSearchOptions', array('class' => "small-padding-left-right")); ?>
	<?php echo $form->input('challenge',array('type' => 'checkbox', 'label' => 'Challenge', 'div' => '', 'checked' => true)); ?>
	<?php echo $form->input('idea',array('type' => 'checkbox', 'label' => 'Idea', 'div' => '', 'checked' => true)); ?>
	<?php echo $form->input('vision',array('type' => 'checkbox', 'label' => 'Vision', 'div' => '', 'checked' => true)); ?>
	<?php echo $form->end(); ?>
	<div class="add_new_link_list">
		<h2 class="margin">Available contents to link</h2>
		<span class="shrinkFontMore bold small-padding-left-right">View</span>|<span class="shrinkFontMore bold small-padding-left-right">Link content by clicking</span>
		<ul>
			<li><?php echo $html->image('ajax-loader-black.gif'); ?></li>
		</ul>
	</div>
	<div class="clear"></div>
	<div class="box shrinkFont">
        <h4>What is content linking?</h4>
        <div class="box-content">
            <span>Combining different contents together boost creativity and increase the likelihood of unexpected findings.
			By linking you can create logical relationships between different contents.
			You can link your own published content to other users or to your own contents.
			One content can be linked to multiple contents.
			If you want, you can remove links later on from your content page.</span>
            <div class="clear"></div>
        </div>
    </div>
</div>