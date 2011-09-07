<?php 
$layout = 'layout'.DS; //Used for element folder structures
echo $html->docType('xhtml11'); 
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo $title_for_layout ?></title>
	<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
	<?php /*
	 echo $html->charset();
	 For some reason this returns content as just text/html which is used for HTML.
	 application/xhtml+xml is for XHTML. Wonder why CakePHP doesnt use this as default unless we are now at HTML 5 age :O	 
	*/ ?>	
	<link rel="shortcut icon" href="<?php echo $html->url('/') . 'favicon.ico'; ?>" type="image/x-icon">
	
	<?php 
	//Here we set our own css files
	$cssFiles = array_merge(array('reset', //Resets the CSS for browsers
					'layout' //Layout CSS file
	),$css_for_layout); //Adds controller.css and its action.css files to CSS styles if they exists
	
	//Sidebar css file added if we have a sidebar
	if ($content_class == 'contentWithSidebar' || $content_class == 'contentWithTopAndSidebar') {
		$cssFiles[] = 'sidebar'; //Sidebar CSS file
	}
	//Here we add additional CSS files from plugins etc.
	$cssFiles[] = 'smoothness'.DS.'jquery-ui-1.8.7.custom.css'; //jQuery UI CSS file
	echo $html->css($cssFiles);

	?>
	
	<!--[if IE 7]> <?php echo $html->css('ie7fix'); ?> <![endif]-->
	<?php 
	echo $html->script(array('jquery-1.4.4.min', //jQuery javascript library
							'jquery-ui-1.8.7.custom.min', //User Interface extension for jQuery
							'jquery.cookie', //jQuery cookie plugin
							'global' //All global JS things used in site
	)); 
	?>

	<?php echo $scripts_for_layout; ?>	

</head>
<body>
	<!--[if lt IE 7]> <span id="iewhine">Internet Explorer version 6 and below are not supported. Please update your browser for your own security.<br/> <a href="http://www.microsoft.com/windows/internet-explorer/worldwide-sites.aspx">Download newer version here</a> </span><![endif]-->
	<div id="alert"><?php //This element is hidden because its used to notify users if we are going to do updates to our site. 
		echo $this->element($layout.'alert', array('cache' => false)); 
	?> 
	</div>
	<div id="flash"><?php echo $session->flash(); ?></div>
	<div id="background">
		<div id="container">
			<div id="header">
				<?php echo $this->element($layout.'header', array('cache' => true)); ?> 
			</div>
			<div id="menu">
				<?php echo $this->element($layout.'menu', array('cache' => true)); ?>
			</div>
			<?php 
			/**
			 *	Some controller pages have sidebar and some dont. 
			 *	All pages have content div and its defined id is: controller
			 *	Inside this div there is action div with defined id: action-page
			 *	The $content_class defines whether the content uses narrow or wide style.
			 *	narrow style is used with sidebar and wide without and it's globally set to narrow in app_controller.php.
			 *	Sidebar is loaded from elements:
			 *	elements/controller/sidebars/action.ctp
			 */
			 $controller_id = strtolower($this->name);
			 $action_id		= $this->action . '-page';
			 $sidebar		= strtolower($this->name) . DS . 'sidebars' . DS. $this->action;
			 $top			= strtolower($this->name) . DS . 'tops' . DS. $this->action;
			 ?>
			 
			<?php if($content_class == 'contentWithTopAndSidebar'): ?>
			<div id="content-top">
				<?php echo $this->element($top, array('cache' => false)); ?>
			</div>
			<?php endif; ?>
			
			<div id="content">
				<div id="<?php echo $controller_id; ?>" class="<?php echo $content_class; ?>">
					<div id="<?php echo $action_id; ?>">
						<?php echo $content_for_layout ?>
					</div>
				</div>
			</div>
			<?php ?>
			<?php if ($content_class == 'contentWithSidebar' || $content_class == 'contentWithTopAndSidebar'): ?>
			<div id="sidebar">
				<?php 
				/**
				 * Its important that sidebar element is not cached because its view may also depend on parameters
				 * and not just action. If you want to cache things in sidebar, you should cache them inside the element.
				 */
				echo $this->element($sidebar, array('cache' => false));
				?>
			</div>
			<?php endif; ?>
			<div class="clear"></div>
			<div id="footer">
				<?php echo $this->element($layout.'footer', array('cache' => true)); ?>
			</div>			
		</div>
	</div>
	<div id="jsmetabox">
    	<?php echo $Jsmeta->output(); ?>
    </div>
</body>
</html>
