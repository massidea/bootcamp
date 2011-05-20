<?php
echo $this->Html->script(strtolower($this->name).DS.'add',array('inline' => false));

 
/*
$this->TinyMce->editor(array(
		'theme' => 'advanced',
		'mode' => 'exact',
		'elements' => 'NodeBody',
		'theme_advanced_toolbar_location' => "top",
		'theme_advanced_disable' => "charmap,sup,sub,code,help,cleanup,image,anchor,unlink,link,removeformat,visualaid,hr"
));
*/

/**
 * Here we set content specific field texts
 * 
 */ 
$challenge = '(Answer what, why, who, when and where questions)';
$idea = '(What is the idea and why it is important)';
$vision = '(What is the vision of the future and why it is important)';
$body = '';
?>

<div id="form_content_realcontent">
<?php if($content_type === 'challenge'): $body = $challenge; ?>

	<h2 class="light-gray border-problem">Share your challenge</h2>
	<p>Challenge is personal, business or social related problem, need, situation or observation. It describes the current status of affairs and recognizes the need to resolve the matter. </p>
	<p>Write to a person who is not familiar with the topic.</p>
	<p>Keep your focus on challenge and not related solutions or visions. You can publish those one a separate document and link them later on to this challenge.</p>

<?php elseif($content_type === 'idea'): $body = $idea; ?>

	<h2 class="light-gray border-idea">Share your new idea</h2>
	<p>Ideas are solutions to today’s challenges and visions of the future related opportunities and threats. Idea can suggest small incremental improvement or radical revolutionary change in thinking, products, processes or organization. </p>
	<p>Write to a person who is not familiar with the topic. </p>
	<p>Keep your focus on idea and not related challenges or visions. You can publish those on a separate document and link them later on to this idea.</p>

<?php elseif($content_type === 'vision'): $body = $vision; ?>

	<h2 class="light-gray border-finfo">Share your vision of the future</h2>
	<p>Vision concern the long-term future which is usually at least 10 years away. It can be future scenario, trend or anti-trend, which is most likely to be realized. It can also describe an alternative unlikely future based on seed of change or weak signal, which might significantly change all our life if realized.</p>
	<p>Write to a person who is not familiar with the topic.</p>
	<p>Keep your focus on vision and not related challenges or ideas. You can publish those on a separate document and link them later on to this vision.</p>

<?php endif; ?>
</div>


<?php 
$beforeTemplate = '<div class="field-label"><small class="right">%text%</small>';
$between = '</div><div class="field">';
$after = '</div><div class="limit bad">required</div></div><div class="clear">';
$afterNoReq = '</div></div><div class="clear">';
$afterClear = '</div><div class="clear">';
?>

<?php echo $form->create('Node', array('type' => 'file',
						 				'url' => array('controller' => 'contents', 'action' => 'edit'),
						 				'inputDefaults' => array('label' => false,
																'div' => false)
));
?>

<?php echo $form->hidden('type', array('value' => "Content")); ?>

<?php echo $form->hidden('id'); ?>

<?php echo $form->hidden('class', array('value' => $content_type)); ?>

<?php echo $form->hidden('Privileges.privileges'); ?>

<div id="content_languages" class="row field">
<?php echo $form->input('language_id', array('type' => 'select',
											 'selected' => "en",
											 'label' => 'Select language',
											 'options' => $language_list )); ?>

</div>
<div class="clear"></div>

<div id="content_title" class="row">
	<div class="field-label">
		<label for="NodeTitle">Header</label>
		<small class="right">(Explain in one sentence the whole story)</small>
	</div>
	<div class="field">
	<?php echo $form->input('title', array('error' 	=> array('tooLong' => 'This is too long', 'wrap' => 'div', 'class' => 'error', true))); ?>
	</div>
	<div class="limit bad">required</div>
</div>
<div class="clear"></div>

<div id="content_lead" class="row">
	<div class="field-label">
		<label for="NodeLead">Lead chapter</label>
		<small class="right">(This text is shown in search result lists)</small>
	</div>
	<div class="field">
	<?php echo $form->input('lead', array('type' => 'textarea',	'error' => array('tooLong' => 'This is too long', 'wrap' => 'div', 'class' => 'error', true))); ?>	
	</div>
	<div class="limit bad">required</div>
</div>
<div class="clear"></div>



<?php if($content_type === 'challenge'): ?>

<div id="content_research" class="row">
	<div class="field-label">
		<label for="SpecificResearch">Research question</label>
		<small class="right">(The single question you want to get an answer)</small>
	</div>
	<div class="field">
	<?php echo $form->input('Specific.research', array('error' => array('tooLong' => 'This is too long', 'wrap' => 'div', 'class' => 'error', true))); ?>
	</div>
	<div class="limit bad">required</div>
</div>
<div class="clear"></div>



<?php elseif($content_type === 'idea'): ?>

<div id="content_solution" class="row">
	<div class="field-label">
		<label for="SpecificSolution">Solution</label>
	</div>
	<div class="field">
	<?php echo $form->input('Specific.solution', array('error' => array('tooLong' => 'This is too long', 'wrap' => 'div', 'class' => 'error', true))); ?>
	</div>
	<div class="limit bad">required</div>
</div>
<div class="clear"></div>


<?php elseif($content_type === 'vision'): ?>

<div id="content_opportunity" class="row">
	<div class="field-label">
		<label for="SpecificOpportunity">Opportunity</label>
		<small class="right">(The most important if future scenario becomes realized)</small>
	</div>
	<div class="field">
	<?php echo $form->input('Specific.opportunity', array('error' => array('tooLong' => 'This is too long', 'wrap' => 'div', 'class' => 'error', true))); ?>
	</div>
	<div class="limit bad">required</div>
</div>
<div class="clear"></div>

<div id="content_threat" class="row">
	<div class="field-label">
		<label for="SpecificThreat">Threat</label>
		<small class="right">(The most important if future scenario becomes realized)</small>
	</div>
	<div class="field">
	<?php echo $form->input('Specific.threat', array('error' => array('tooLong' => 'This is too long', 'wrap' => 'div', 'class' => 'error', true))); ?>
	</div>
	<div class="limit bad">required</div>
</div>
<div class="clear"></div>

<?php endif;?>

<div id="content_tags" class="row">
	<div class="field-label">
		<label for="TagsTags">Keywords, Tags</label>
		<small class="right">(Use commas to separate tags)</small>
	</div>
	<div class="field">
	<?php echo $form->input('Tags.tags', array('error' => array('tooLong' => 'This is too long', 'wrap' => 'div', 'class' => 'error', true))); ?>
	</div>
	<div class="limit bad">required</div>
</div>
<div class="clear"></div>

<div id="content_companies" class="row">
	<div class="field-label">
		<label for="CompaniesCompanies">Related companies and organizations</label>
		<small class="right">(Use commas to separate)</small>
	</div>
	<div class="field">
	<?php echo $form->input('Companies.companies', array('error' => array('tooLong' => 'This is too long', 'wrap' => 'div', 'class' => 'error', true))); ?>
	</div>
	<div class="limit bad">required</div>
</div>
<div class="clear"></div>

<div id="content_body" class="row">
	<div class="field-label">
		<label for="NodeBody">Body text</label>
		<small class="right"><?php echo $body; ?></small>
	</div>
	<div class="field">
	<?php echo $form->input('body', array('type' => 'textarea',	'rows' => '20' , 'error' => array('tooLong' => 'This is too long', 'wrap' => 'div', 'class' => 'error', true))); ?>	
	</div>
	<div class="limit bad">required</div>
</div>
<div class="clear"></div>


<div id="content_references" class="row">
	<div class="field-label">
		<label for="NodeReferences">References</label>
		<small class="right">(Youtube video url references are embedded)</small>
	</div>
	<div class="field">
	<?php echo $form->input('references', array('type' => 'textarea', 'error' => array('tooLong' => 'This is too long', 'wrap' => 'div', 'class' => 'error', true))); ?>	
	</div>
	<div class="limit bad">required</div>
</div>
<div class="clear"></div>

<?php echo $form->input('published', array('type' 	=> 'radio',
										'legend' 	=> 'Do you want to publish your content now?',
										'label'		=> true,
										'div'		=> array('id' => 'content_publish', 'class' => 'row'),
										'options'	=> array('1' => 'Yes', '0' => 'No, I want to save it for later editing'),
										'value'		=> '0',
										'after'		=> '</div><div class="clear">'						
)); 
?>

<?php echo $form->end(array('div' => array('class' => 'row field',
											'id' => 'content_send'),
							'value' => 'Send',
							'label' => 'Send',
							'after'	=> '</div><div class="clear">'
));
 ?>







