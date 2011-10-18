<div id="footer-menu" class="nolist">
	<ul>
		<li>&copy; 2009 <a href="http://massidea.org">Massidea.org</a></li>
		<li><a href="http://www.massidea.org/blog/?page_id=40">About</a></li>		
		<li><a href="http://www.massidea.org/blog/?page_id=71">Contact</a></li>
		<li><a href="http://www.massidea.org/blog/?page_id=74">Development</a></li>
		<li><a id="terms_link" href="#">Terms</a></li> <?php //Terms and privacy will be done with jQuery UI dialog widget ?>
		<li><a id="privacy_link" href="#">Privacy</a></li>
	</ul>
</div>

<div class="dot-line-720 clear"></div>
<div class="left">
	<p>This project is funded by</p>
	<a href="http://www.rakennerahastot.fi/rakennerahastot/en/index.jsp">
		<?php echo $html->image('footer1.png',array('alt' => 'Footer')); ?>
    </a>
</div>

<div class="right">
	<p>Project coordinator</p>
	<a href="http://www.laurea.fi/internet/en/index.jsp">
		<?php echo $html->image('laurea.png',array('alt' => 'Laurea')); ?>
	</a>
	<p>Project group</p>
	<select id="project_groups">
		<option value="0">Select partner university</option>
		<option value="http://www.cop.fi/">Central Ostrobothnia University of Applied Sciences</option>
		<option value="http://www.hamk.fi/">HAMK University of Applied Sciences</option>
		<option value="http://www.tkk.fi/">Helsinki University of Technology</option>
		<option value="http://www.humak.fi/">HUMAK University of Applied Sciences</option>
		<option value="http://www.tokem.fi/">Kemi-Tornio University of Applied Sciences</option>
		<option value="http://www.kyamk.fi/">Kymenlaakso University of Applied Sciences</option>
		<option value="http://www.laurea.fi/internet/en/index.jsp">Laurea University of Applied Sciences</option>
		<option value="http://www.tamk.fi/">PIRAMK University of Applied Sciences</option>
		<option value="http://www.ramk.fi/">Rovaniemi University of Applied Sciences</option>
		<option value="http://www.samk.fi/">Satakunta University of Applied Sciences</option>
		<option value="http://www.tamk.fi/">TAMK University of Applied Sciences</option>
		<option value="http://www.tse.fi/">Finland Future Research Center</option>
	</select>
</div>
                
<div class="dot-line-720 clear"></div>

<div id="terms"><?php echo $this->element('layout'.DS.'register_description', array('cache' => true)); ?></div>
<div id="privacy"><?php echo $this->element('layout'.DS.'network_services_agreement', array('cache' => true)); ?></div>