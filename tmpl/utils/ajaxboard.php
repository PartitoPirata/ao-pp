<?php

require_once('lib/config.php');

if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="AO 2014 PP-IT"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Devi autenticarti per accedere a questa risorsa.';
    exit;
} else {
    
    if($_SERVER['PHP_AUTH_PW'] == $users[$_SERVER['PHP_AUTH_USER']]){
    	# AUTENTICAZIONE OK
    } else {
    	header('Location: '.$base_url.'board/');
    }
}


$messages = mrksql_select('board', '*', array('event'=>$theEvent), 'dateins DESC', '100');

foreach ($messages as $k=>$message) { ?>

	<li class="list-group-item">
		<h4><?php echo $message['name']; ?> <small>@ <?php echo $message['dateins']; ?></small></h4>
		<p>
		<?php echo $message['message']; ?>
		</p>
	</li>

<?php } ?>
