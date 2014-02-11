<?php

require_once('lib/config.php');
require_once("lib/mathguard/ClassMathGuard.php");


if (!isset($_SERVER['PHP_AUTH_USER'])) {
	header('WWW-Authenticate: Basic realm="AO 2014 PP-IT"');
	header('HTTP/1.0 401 Unauthorized');
	echo 'Devi autenticarti per accedere a questa risorsa.';
	exit;
} else {
    
    if($_SERVER['PHP_AUTH_PW'] != $users[$_SERVER['PHP_AUTH_USER']]){
	header('WWW-Authenticate: Basic realm="AO 2014 PP-IT"');
	header('HTTP/1.0 401 Unauthorized');
	echo 'Devi autenticarti per accedere a questa risorsa.';
	exit;
    }
    
}



switch($_POST['action']){
	
	
	case 'newMessage':
		

		if (MathGuard :: checkResult($_REQUEST['mathguard_answer'], $_REQUEST['mathguard_code'])) {
		
			$oktags = (in_array($_SERVER['PHP_AUTH_USER'], $admins))?'<a><b><i><u><img><iframe><video><source>':'<a><b><i><u>';
	
			mrksql_insert('board', array(
					'event'=>$theEvent,
					'name'=>$_POST['name'],
					'message'=>nl2br(strip_tags($_POST['message'], $oktags)),
					'dateins'=>date('Y-m-d H:i:s'),
				), false);
		
		} else {
		
			$error = 'Captcha error!';
	
		}
		
		
	break;
	
	default:
		$error = false;	
	 	


}



$messages = mrksql_select('board', '*', array('event'=>$theEvent), 'dateins DESC', '100');


?><!DOCTYPE html>
<html>
	<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title><?php echo $theEvent; ?> &raquo; Interventi</title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="author" content="mrk25" />
	<meta name="robots" content="noindex, nofollow" />
	<meta name="viewport" content="width=device-width" />
	<link rel="shortcut icon" href="<?php echo $base_url; ?>img/<?php echo $theEvent; ?>.ico" />
	<link rel="stylesheet" href="<?php echo $base_url; ?>css/fonts.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php echo $base_url; ?>css/style.css" type="text/css" media="screen" />
	<!--[if IE]>
	<link rel="stylesheet" href="css/ie.css" type="text/css" media="screen" />
	<![endif]-->
	<link rel="stylesheet" href="<?php echo $base_url; ?>css/print.css" type="text/css" media="print" />
	<link rel="stylesheet" href="<?php echo $base_url; ?>css/desktop.css" type="text/css" media="screen and (min-width:1024px)" />
	<link rel="stylesheet" href="<?php echo $base_url; ?>css/mobile.css" type="text/css" media="screen and (max-width:1023px)" />
	<link rel="stylesheet" href="<?php echo $base_url; ?>css/bootstrap.min.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php echo $base_url; ?>css/bootstrap-theme.min.css" type="text/css" media="screen" />
	
	<script type="text/javascript" src="<?php echo $base_url; ?>js/jquery-2.0.3.min.js"></script>
	<script type="text/javascript" src="<?php echo $base_url; ?>js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo $base_url; ?>js/livevalidation.min.js"></script>
	<script type="text/javascript" src="<?php echo $base_url; ?>js/frontend.js"></script>
	</head>
	<body>
	<!--[if lte IE 7]>
	Outdated browser alert!
	<![endif]-->
	
	<?php 
	
	if(!$_GET['headless']){
		if(file_exists($_SERVER['DOCUMENT_ROOT'].'/tmpl/utils/'.$theEvent.'-menu.php')){ 
		include($_SERVER['DOCUMENT_ROOT'].'/tmpl/utils/'.$theEvent.'-menu.php');
		}
	}
	?>
	
	<div id="wrapper" class="container text-left" style="width:90%;max-width:90%;">
		
		<?php if($error != ''){ ?>
			<h3 style="color:#aa0000;" class="text-center"><?php echo $error; ?></h3>
		<?php } ?>
		

	
		<div id="tehModal" class="modal fade">
		<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title">Inserisci un intervento</h4>
			</div>
			
			
			<form role="form" method="post" action="<?php echo $base_url; ?>board/">
			<div class="modal-body">
				<div id="messageForm">
					  
					  <input type="hidden" name="action" value="newMessage" />
					  
					  <div class="form-group">
					    <label for="guestName">Nome</label>
					    <input name="name" type="text" class="form-control" id="boardName" placeholder="Nome visualizzato" value="<?php echo $_POST['name']; ?>">
					  </div>
					  
					  
					  <div class="form-group">
					    <label for="guestName">Messaggio</label>
					    <textarea name="message" class="form-control" id="boardMessage" placeholder="Inserisci il tuo messaggio"></textarea>
					    <small>Puoi utilizzare i tags <b><?php echo htmlspecialchars($oktags); ?></b></small>
					  </div>
					  
					  
					  
					  
					  <div class="form-group">
					  <?php MathGuard::insertQuestion(); ?>
					  </div>
					  
	
				</div>
	
				<script type="text/javascript">
				//<![CDATA[

					var valid_board_name = new LiveValidation('boardName', {validMessage: "Ok!"} );
					valid_board_name.add( Validate.Presence, { failureMessage: "Obbligatorio!" } );

					var valid_board_message = new LiveValidation('boardMessage', {validMessage: "Ok!"} );
					valid_board_message.add( Validate.Presence, { failureMessage: "Obbligatorio!" } );

				//]]>
				</script>


			</div>
			<div class="modal-footer">
			<button type="submit" class="btn btn-primary">Inserisci <span class="glyphicon glyphicon-ok"></span></button>
			</div>
			</form>
			
			
		</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		
		
		
		
		<h2 style="overflow:hidden;<?php if($_GET['headless']){ echo 'display:none;'; } ?>">
			<a href="<?php echo $base_url; ?>"><?php echo strtoupper($theEvent); ?></a> &raquo; <a href="<?php echo $base_url; ?>board/">Interventi</a>
		
			<button style="font-size:75%;" class="pull-right" data-toggle="modal" data-target="#tehModal">
			Inserisci <span style="font-size:75%;" class="glyphicon glyphicon-pencil"></span>
			</button>
		</h2>
		
		<div style="margin:1em 0;overflow:hidden;">
		<ul id="messages" class="list-group pull-left" style="width:66%;">
		
		<?php foreach ($messages as $k=>$message) { ?>
	
			<li class="list-group-item">
				<h4><?php echo $message['name']; ?> <small>@ <?php echo $message['dateins']; ?></small></h4>
				<p>
				<?php echo $message['message']; ?>
				</p>
			</li>

		<?php } ?>
		
		</ul>
		
		<script type="text/javascript">
		//<![CDATA[
		function refreshBoard(){
			$('#messages').load('<?php echo $base_url; ?>ajaxboard/');
		}
		
		$(document).ready(function(){
			setInterval('refreshBoard()', 60000)
		});
		//]]>
		</script>
		
		
		<div id="twitter_timeline" class="pull-right" style="width:33%;">
		
		<?php include($theEvent.'-widgets.php'); ?>
		
		</div>

		</div>
		
	




			
	
		
		
	</div><!-- eof #wrapper -->
	
	</body>
</html>
