<?php 
if($content_type) {
	echo $this->element('contents'.DS.'how_to_write_'.$content_type, array('cache' => true)); 
}
?>