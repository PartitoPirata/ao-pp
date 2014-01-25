<?php

require_once('lib/config.php');

/* first we need to require our MathGuard class */
require("lib/mathguard/ClassMathGuard.php");
/* this condition checks the user input. Don't change the condition, just the body within the curly braces */
if (MathGuard :: checkResult($_REQUEST['mathguard_answer'], $_REQUEST['mathguard_code'])) {
	//echo ("Great !");
	
	$guestRow = mrksql_select('guests', '*', array('email'=>$_POST['email']), false, false);
	
	$MXdomain = explode('@', $_POST['email']);
	$MXdomain = escapeshellarg($MXdomain[1]);
	
	exec("dig -t MX +short ".$MXdomain, $validateMX);
##	print_r($validateMX);
##	echo '<br />'.count($validateMX);
##	echo '<br />'.$MXdomain;
##	die();
	
	if(!is_array($guestRow[0]) && (count($validateMX) >= 1)){
		
		$token = makeToken($_POST['email']);
		
		
		$confirm_content .= "\n\nConferma la tua partecipazione visitando il seguente indirizzo:\n\n";
		$confirm_content .= $base_url."?confirm=".$token."#registrazioneonline\n\n";
		
		//Spedisco mail di conferma
		if(mail($_POST['email'], $confirm_subject, $confirm_content, "From: ".$confirm_sender, "-f".$confirm_sender)){
			mrksql_insert('guests', array(
				'event'=>$theEvent,
				'name'=>$_POST['name'],
				'email'=>$_POST['email'],
				'nick'=>$_POST['nick'],
				'citta'=>$_POST['citta'],
				'provincia'=>$_POST['provincia'],
				'pranzo'=>($_POST['pranzo'])?1:0,
				'noglutine'=>($_POST['noglutine'])?1:0,
				'vegetariano'=>($_POST['vegetariano'])?1:0,
				'vegan'=>($_POST['vegan'])?1:0,
				'token'=>$token,
				'dateins'=>date('Y-m-d H:i:s'),
				'confirmed'=>0,
			), false);
		
			//Spedisco mail all'amministratore
			mail("subaddiction@subaddiction.net", "[".$theEvent."] Utente registrato", $_POST['email']." ha effettuato la registrazione.", "From: ".$confirm_sender, "-f".$confirm_sender);
			
		
			header('Location: '.$base_url.'registrato/#registrazioneonline');
		
		} else {
			header('Location: '.$base_url.'erroremail/#registrazioneonline');
		}
		
	} else {
	
	// ERRORE INDIRIZZO EMAIL GIA PRESENTE
	header('Location: '.$base_url.'erroremail/#registrazioneonline');
	
	}
	
} else {
	header('Location: '.$base_url.'errore/#registrazioneonline');
}
?>
