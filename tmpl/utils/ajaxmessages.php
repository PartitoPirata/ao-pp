<?php

require_once('lib/config.php');


$messages = mrksql_select('messages', '*', array('event'=>$theEvent), 'dateins DESC', '100');

foreach ($messages as $k=>$message) { ?>

	<li class="list-group-item">
		<h4><?php echo $message['name']; ?> <small>@ <?php echo $message['dateins']; ?></small></h4>
		<p>
		<?php echo $message['message']; ?>
		</p>
	</li>

<?php } ?>
