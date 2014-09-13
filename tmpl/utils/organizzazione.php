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


if($_GET['action'] == 'export'){
	
	/*
	
	id	int(11) Auto Increment	 
	event	varchar(255)	 
	name	text	 
	email	text	 
	nick	text	 
	citta	text	 
	provincia	text	 
	referrer	varchar(64)	 
	token	text	 
	pranzo	int(1)	 
	noglutine	int(1)	 
	vegetariano	int(1)	 
	vegan	int(1)	 
	dateins	datetime	 
	datemod	datetime	 
	confirmed	int(1)	  
	
	*/
	
	$csv_file = "id,name,email,nick,citta,provincia,pranzo,noglutine,vegetariano,vegan,dateins,datemod,confirmed\n";;
	$data = mrksql_select('guests', 'id,name,email,nick,citta,provincia,pranzo,noglutine,vegetariano,vegan,dateins,datemod,confirmed', array('event'=>$theEvent));
	foreach($data as $subscriber){
		$csv_file .= $subscriber['id'].",".$subscriber['name'].",".$subscriber['email'].",".$subscriber['nick'].",".$subscriber['citta'].",".$subscriber['provincia'].",".$subscriber['pranzo'].",".$subscriber['noglutine'].",".$subscriber['vegetariano'].",".$subscriber['vegan'].",".$subscriber['dateins'].",".$subscriber['datemod'].",".$subscriber['confirmed']."\n";	
	}
	
	header('Content-Type: text/plain');
	header('Content-Disposition: attachment; filename="subscribers.csv"');
	print($csv_file);
	die();

}


$totalGuests = mrksql_count('guests', '*', array('event'=>$theEvent));
$confirmedGuests = mrksql_count('guests', '*', 'event="'.$theEvent.'" AND confirmed >= 1');



$guests = mrksql_select('guests', '*', array('event'=>$theEvent), 'nick ASC', false);

?><!DOCTYPE html>
<html>
	<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title><?php echo $theEvent; ?> &raquo; Organizzazione</title>
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
	
	<style type="text/css">
		.row{
		border-bottom:1px dashed #cccccc;
		padding:0.5em 0;
		}
		
		.row:hover
		{
		background:#ffffaa;
		}
		
		.btn
		{
		margin-right:0.5em;
		}
	
	</style>
	</head>
	<body>
	<!--[if lte IE 7]>
	Outdated browser alert!
	<![endif]-->
	
	<?php if(file_exists($_SERVER['DOCUMENT_ROOT'].'/tmpl/utils/'.$theEvent.'-menu.php')){ 
		include($_SERVER['DOCUMENT_ROOT'].'/tmpl/utils/'.$theEvent.'-menu.php');
	} ?>
	
	<div id="wrapper" class="container text-left" style="width:90%;max-width:90%;">
	
	
		<h2 style="overflow:hidden;">
			<a href="<?php echo $base_url; ?>"><?php echo strtoupper($theEvent); ?></a> &raquo; <a href="<?php echo $base_url; ?>organizzazione/">Organizzazione</a>
			<!--
			<button style="font-size:75%;" class="pull-right" data-toggle="modal" data-target="#tehModal">
			Inserisci <span style="font-size:75%;" class="glyphicon glyphicon-pencil"></span>
			</button>
			-->
		</h2>
		
		<div class="clearfix"></div>
		
		<?php foreach($guests as $k => $guest) { ?>
	
			<div class="row">
			
			
			<div class="col-xs-4 col-sm-6 col-md-8 col-lg-8" style="padding:6px 12px;">
			<?php //echo $guest['name']; ?>
			<b><?php echo $guest['name']; ?></b> [<?php echo $guest['email']; ?>]
			</div>
			
			<div class="col-xs-8 col-sm-6 col-md-4 col-lg-4">
			<?php switch($guest['confirmed']){
				case 0: //Iscritto ?>
					
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
		
				case 1: //Confermato ?>
				
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
		
				case 2: //Presente ?>
					
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
	
	
			}?>
			
			</div>
			
			
			
			
			
			</div>

		<?php } ?>

	
	
	

	</div><!-- eof #wrapper -->
	
	<div style="margin:2em auto; padding:0 2em; border:1px dashed #cccccc; background:#eeeeee;">
	<h4>Totale iscritti: <?php echo $totalGuests; ?></h4>
	<h4>Totale confermati: <?php echo $confirmedGuests; ?></h4>
	<h4><a href="?action=export">Esporta dettagli (.CSV)</a></h4>
	</div>
	
	</body>
</html>
