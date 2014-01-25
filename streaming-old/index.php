<?php require_once('../lib/config.php'); ?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title><?php echo $theEvent; ?> &raquo; Live streaming</title>
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

<style type="text/css">


.container
{
padding:0 20px 20px;
margin-bottom:40px;
overflow:hidden;
}

.streaming .frame
{
margin:0 auto;
padding:0;
width:640px;
height:480px;
max-width:100%;
max-height:100%;
}

.streaming .frame
{
width:640px;
height:480px;
border:1px solid #333333;
}

.streaming .iframe
{
width:640px;
height:480px;
}

@media (min-width:1200px)
{

	.container
	{
	width:1200px;
	max-width:1200px;
	min-height:500px;
	}
	
	
	.streaming
	{
	float:left;
	width:578px;
	height:433px;
	}
	
	.streaming .frame
	{
	width:578px;
	height:433px;
	}
	
	.streaming .iframe
	{
	width:578px;
	height:433px;
	}

}

@media (max-width:639px)
{
	
	.container
	{
	padding:0!important;
	}
	
	.streaming .frame
	{
	width:358px;
	height:270px;
	}
	
	.streaming .iframe
	{
	width:358px;
	height:270px;
	}
	
	h3 small
	{
	display:block;
	}
}





</style>

<script type="text/javascript" src="<?php echo $base_url; ?>js/jquery-2.0.3.min.js"></script>
<script type="text/javascript" src="<?php echo $base_url; ?>js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo $base_url; ?>js/livevalidation.min.js"></script>
<script type="text/javascript" src="<?php echo $base_url; ?>js/frontend.js"></script>
</head>
<body>
<!--[if lte IE 7]>
Outdated browser!
<![endif]-->
<body>

<?php if(file_exists($_SERVER['DOCUMENT_ROOT'].'/tmpl/utils/'.$theEvent.'-menu.php')){ 
	include($_SERVER['DOCUMENT_ROOT'].'/tmpl/utils/'.$theEvent.'-menu.php');
} ?>

<header>
<img id="main_logo" style="max-height:2em;" src="<?php echo $base_url; ?>img/partito-pirata.png" />
<h4>Assemblea Occasionale 2014</h4>
<h4>Firenze, 25 Gennaio 2014</h4>
</header>

<div class="container">

	<div class="streaming">
	<h3>STREAMING <small style="font-variant:small-caps;">&raquo; assemblea in diretta</small></h3>
	<div class="frame">
	<iframe border="0" frameborder="0" width="100%" height="100%" src="http://www.ustream.tv/embed/16932496?v=3&amp;wmode=direct" scrolling="no"></iframe>
	</div>
	</div>

	<div class="streaming">
	<h3>CHAT <small style="font-variant:small-caps;">&raquo; accesso publico con nickname</small></h3>
	<div class="frame">
	<iframe border="0" frameborder="0" width="100%" height="100%" src="http://ao2014.partito-pirata.it/chat/AO2014/"></iframe>
	</div>
	</div>
</div>

<footer>
<p>
<a href="https://www.partito-pirata.it">Partito Pirata Italiano</a>
<br />
<a href="<?php echo $base_url; ?>">Assemblea Occasionale 2014</a>
</p>
<p>L'Assemblea Occasionale 2014 &egrave; organizzata dalla sezione territoriale dell'area metropolitana di Firenze.
<br />
Per qualsiasi comunicazione con gli organizzatori scrivere all'indirizzo:<br />firenze [at] lists.partito-pirata [punto] it
</p>
</footer>

</body>
</html>
