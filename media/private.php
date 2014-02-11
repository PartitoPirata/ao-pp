<?php


die("Area deprecata.");

ob_start();
require_once('../lib/config.php');


function pushFile($file){
	
	global $base_dir;
       
        if(file_exists($base_dir.'media/private/'.$file)){
       
                header("Pragma: public");
                if($_GET['download'] == 'true'){
		        header("Content-type: application/octet-stream");
		        header('Content-disposition: attachment; filename='.$file);
		        header('Content-Length: ' . filesize($base_dir.'media/private/'.$file));
		        header('Content-Transfer-Encoding: binary');
                } else {
                	header("Content-type: ".mime_content_type($base_dir.'media/private/'.$file));
                }
		
                session_write_close();
               
                ob_clean();
                flush();
                
                readfile($base_dir.'media/private/'.$file);
                die();
        } else {
                return false;
        }


}


if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="AO 2014 PP-IT"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Devi autenticarti per accedere a questa risorsa.';
    exit;
} else {
    
    if($_SERVER['PHP_AUTH_PW'] == $users[$_SERVER['PHP_AUTH_USER']]){
    	pushFile($_GET['object']);
    } else {
    	header('Location: '.$base_url);
    }
}



?>
