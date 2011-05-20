<?php 
$url_add_challenge = $html->url(array('controller' => 'contents', 'action' => 'add', 'challenge'));
$url_add_idea = $html->url(array('controller' => 'contents', 'action' => 'add', 'idea'));
$url_add_vision = $html->url(array('controller' => 'contents', 'action' => 'add', 'vision'));

$url_view_challenge = $html->url(array('controller' => 'contents', 'action' => 'challenge'));
$url_view_idea = $html->url(array('controller' => 'contents', 'action' => 'idea'));
$url_view_vision = $html->url(array('controller' => 'contents', 'action' => 'vision'));
?>

<div class="left">
	<ul>
		<li id="home" class="deepblue"><a href="<?php echo $html->url('/'); ?>">Home</a></li>
		<li id="challenges" class="red"><a href="<?php echo $url_view_challenge; ?>">Challenges</a></li>
		<li id="ideas" class="green"><a href="<?php echo $url_view_idea; ?>">Ideas</a></li>
		<li id="visions" class="yellow"><a href="<?php echo $url_view_vision; ?>">Visions</a></li>
		<li id="users" class="blue"><a href="#">Users</a></li>
		<li id="groups" class="blue"><a href="#">Groups</a></li>
		<li id="campaigns" class="deepblue"><a href="#">Campaigns</a></li>
		<li id="blog" class="deepblue"><a href="<?php echo $html->url('/blog'); ?>">Blog</a></li>
	</ul>
</div>
<div class="right">
	<div id="addNewContent">
		<input id="addNewContentButton" type="button" value="Add new content" />
		<div id="addNewContentDialog">
			<div id="add_new_challenge" class="add_new">
				<div class="add_new_info">
				<a href="<?php echo $url_add_challenge;?>">
					<span class="add_new_title">> Add your challenge</span>
					<p>Challenge can be personal, business or social related problem, need, situation or observation description.</p>
					<p>It defines the current status of affairs and recognizes the need to resolve the matter.</p>
					<p>Challenges are important source for generating new ideas, since they are describing the current market needs.</p> 
				</a>
				</div>            		
			</div>
			<div id="add_new_idea" class="add_new">
				<div class="add_new_info">
				<a href="<?php echo $url_add_idea;?>">
					<span class="add_new_title">> Add your idea</span>
					<p>Ideas are solutions to today’s challenges and visions of the future related opportunities and threats.</p>
					<p>Idea is always the starting point, plan or intention for potential innovation.</p>
					<p>Idea can suggest small incremental improvement or radical revolutionary change in thinking, products, processes or organization.</p>
				</a>
				</div>
			</div>
			<div id="add_new_vision" class="add_new">
				<div class="add_new_info">
				<a href="<?php echo $url_add_vision;?>">
					<span class="add_new_title">> Add your vision</span>
					<p>Vision concern the long-term future which is usually at least 10 years away.</p>
					<p>It can be future scenario, trend or anti-trend, which is most likely to be realized.</p>
					<p>It can also describe an alternative unlikely future based on seed of change or weak signal, which might significantly change all our life if realized.</p> 
				</a>
				</div>
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>
<div class="clear"></div>

