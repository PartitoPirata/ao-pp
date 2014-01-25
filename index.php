<?php

require_once('lib/config.php');

if(file_exists('tmpl/utils/'.$_GET['file'].'.php')){

	require_once('tmpl/utils/'.$_GET['file'].'.php');

} else {

	require_once('tmpl/'.$tmpl.'.php');

}

?>
