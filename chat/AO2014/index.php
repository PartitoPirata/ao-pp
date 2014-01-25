<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Partito Pirata - Assemblea Occasionale 2014</title>
	<link rel="shortcut icon" href="../res/img/favicon.png" type="image/gif" />
	<link rel="stylesheet" type="text/css" href="../res/default.css" />
	
	<script type="text/javascript" src="//ao2014.partito-pirata.it/js/jquery-2.0.3.min.js"></script>
	<script type="text/javascript" src="//ao2014.partito-pirata.it/js/jquery-migrate-1.2.1.min.js"></script>
	<script type="text/javascript" src="../libs/libs.min.js"></script>
	<script type="text/javascript" src="../candy.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			Candy.init('http-bind/', {
				core: { 
					debug: false,
					autojoin: ['pressroom@im.adunanzapirata.tk', 'ao2014@im.adunanzapirata.tk']
				},
				view: { resources: '../res/' }
			});
			
			//Candy.Core.connect();
			Candy.Core.connect('ao2014.partito-pirata.it');
		});
	</script>
</head>
<body>
	<div id="candy"></div>
</body>
</html>
