<div id="title">
<!-- Links/Lynx fix -->
	<h1><a href="<?php echo $this->Html->url('/'); ?>"><span>Massidea.org</span></a></h1>
</div>

<div id="search">
	<div id="search-top">
		<a href="#" id="loginlink" class="loginLink">Login</a> | <a href="#">Sign up</a>
	</div>
	<?php echo $this->element('layout'.DS.'forms'.DS.'globalsearch', array('cache' => true));  ?>
	<div class="clear"></div>
	<div id="select">
		<div class="left">
	<?php echo $this->element('layout'.DS.'forms'.DS.'languagechange', array('cache' => true));  ?>		
		</div>
		<div class="right"></div>
		<div class="clear"></div>
	</div>
</div>
