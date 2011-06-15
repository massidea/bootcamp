<?php 
echo $this->Html->script('infinitecarousel'.DS.'jquery.infinitecarousel2.min',array('inline' => false));
echo $this->Html->script(strtolower($this->name).DS.$this->action,array('inline' => false));
echo $this->element('global'.DS.'private_message', array('cache' => false)); 
echo $this->element('global'.DS.'flag', array('cache' => false));
$this->set('content_class','contentWithSidebar');
?>
<table width="500px">
        <tr>
             <th>Sender ID</th>
             <th>Message</th>
             <th>Time Elapsed</th>
        </tr>
        <?php            foreach ($messages as $message): ?>
        <tr>



            <td class="send-message blockLink" id=""align="center"><input type="hidden" value="6" class="send-message-id" />
		<input type="hidden" value="Hihhuli" class="send-message-name" />
		<a href="#" class="hoverLink blockLink"><?php echo $message['PrivateMessage']['id'];?>		</a>
</td>
            <td align="center"><?php echo $message['PrivateMessage']['message'];?></td>
            <td align="center"><?php echo $this->Time->timeAgoInWords( $message['PrivateMessage']['created'], $options = array(), $backwards = null );?></td>
        </tr>
<?        endforeach;?>
    </table>

     
