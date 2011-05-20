<h2>
	Recent posts
	<a href="#">
		<?php echo $html->image('icon_rss_28x28.png',array('alt' => 'RSS', 'class' => 'rsslogo')); ?>
	</a>
	<a href="#">
		<?php echo $html->image('podcasts.png',array('alt' => 'RSS', 'class' => 'rsslogo')); ?>
	</a>
</h2>

<?php foreach($contents as $content): ?>
<div id="postid_<?php echo $content['Node']['id']; ?>" class="user_content_row">
	<div class="user">
		<div class="photo <?php echo $content['Node']['class']; ?>">
			<a href="#"><?php echo $html->image('no_profile_img_placeholder.png'); ?></a>
		</div>
		<div class="context">
			<h3>
				<a class="username" href="#"><?php echo $content['Privileges']['creator']; ?> (1)</a>
				<strong><a href="<?php echo $html->url(array('controller' => 'contents', 'action' => 'view', $content['Node']['id'])); ?>"><?php echo $content['Node']['title']; ?></a></strong>
			</h3>
			<p><?php echo $content['Node']['lead']; ?></p>
			<p>
				<a href="#">Tags: </a>
				<?php if(isset($content['Child'])): $i=0; foreach($content['Child'] as $child):
						if($child['type'] == 'Tag'): $i++;
				?>
				<a href="#"><span class="<?php echo ($i%2)?'first':'second'; ?>_tag"><?php echo $child['name']; ?></span></a>
				<?php endif; endforeach; endif; ?>
			</p>
			<p class="translate">
				<span class="summary_translatelink_meta"><?php echo json_encode(array('id' => $content['Node']['id'], 'language_name' => $content['Language']['name'])); ?></span>
				<span class="summary_translatelink_text">[<a onclick="toggleTranslation('<?php echo $content['Node']['id']; ?>'); return false;" href="#">Show original</a>, translated from <?php echo $content['Language']['name']; ?>]</span>
			</p>
		</div>
	</div>
	<div class="clear"></div>
</div>
<? endforeach; ?>