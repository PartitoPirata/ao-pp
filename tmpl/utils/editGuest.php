<?php

require_once('lib/config.php');
require_once("lib/mathguard/ClassMathGuard.php");


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

if(!in_array($_SERVER['PHP_AUTH_USER'], $admins)){
	die('Solo gli amministratori possono accedere a questa risorsa.');
}

$guest = mrksql_select('guests', '*', array('event'=>$theEvent, 'id'=>$_POST['id']), false, false);
$guest = $guest[0];

?>

<?php switch($_POST['action']){


				case 0: //Iscritto
				mrksql_update('guests', array('confirmed'=>0), array('id'=>$guest['id']));
				?>
					
					<button type="button" class="btn">
					Iscritto
					</button>
				
					<a class="pull-right" href="javascript:;" onclick="$(this).parent().load('<?php echo $base_url; ?>editGuest/', {'id':'<?php echo $guest['id']; ?>','action':'1'})">
					
					<button type="button" class="btn btn-success">
					<span class="glyphicon glyphicon-ok"></span>
					</button>
					
					</a>
				
				<?php
				break;
		
				case 1: //Confermato
				mrksql_update('guests', array('confirmed'=>1), array('id'=>$guest['id']));
				?>
				
					<button type="button" class="btn">
					Confermato
					</button>
				
					
				
					<a class="pull-right" href="javascript:;" onclick="$(this).parent().load('<?php echo $base_url; ?>editGuest/', {'id':'<?php echo $guest['id']; ?>','action':'2'})">
					
					<button type="button" class="btn btn-success">
					<span class="glyphicon glyphicon-ok"></span>
					</button>
					
					</a>
					
					
					
					<a class="pull-right" href="javascript:;" onclick="$(this).parent().load('<?php echo $base_url; ?>editGuest/', {'id':'<?php echo $guest['id']; ?>','action':'0'})">
					<button type="button" class="btn btn-danger">
					<span class="glyphicon glyphicon-remove"></span>
					</button>
					</a>
					
		
				<?php
				break;
		
				case 2: //Presente
				mrksql_update('guests', array('confirmed'=>2), array('id'=>$guest['id']));
				?>
					
					<button type="button" class="btn btn-success">
					Presente
					</button>
					
					<a class="pull-right" href="javascript:;" onclick="$(this).parent().load('<?php echo $base_url; ?>editGuest/', {'id':'<?php echo $guest['id']; ?>','action':'1'})">
					<button type="button" class="btn btn-default">
					<span class="glyphicon glyphicon-remove"></span>
					</button>
					</a>
					
				<?php
				break;


/*

	case 0: //Iscritto
	mrksql_update('guests', array('confirmed'=>0), array('id'=>$guest['id']));
	?>
	
		Iscritto
	
		<a href="javascript:;" onclick="$(this).parent().load('<?php echo $base_url; ?>editGuest/', {'id':'<?php echo $guest['id']; ?>','action':'confirm'})"><small>Conferma</small></a>
		
	<?php
	break;
	
	case 1: 
	mrksql_update('guests', array('confirmed'=>1), array('id'=>$guest['id']));
	//Confermato ?>
	
		Confermato
		
		<a href="javascript:;" onclick="$(this).parent().load('<?php echo $base_url; ?>editGuest/', {'id':'<?php echo $guest['id']; ?>','action':'unconfirm'})"><small>[annulla]</small></a>
	
		<a href="javascript:;" onclick="$(this).parent().load('<?php echo $base_url; ?>editGuest/', {'id':'<?php echo $guest['id']; ?>','action':'present'})">Segna presente</a>
		
	<?php
	break;
	
	case 2:
	mrksql_update('guests', array('confirmed'=>2), array('id'=>$guest['id']));
	//Presente ?>
	
		Presente
		
		<a href="javascript:;" onclick="$(this).parent().load('<?php echo $base_url; ?>editGuest/', {'id':'<?php echo $guest['id']; ?>','action':'confirm'})"><small>[annulla]</small></a>
		
	<?php
	break;
	
*/


}?>
