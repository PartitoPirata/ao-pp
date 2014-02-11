<?php

/*****
Modulo registrazione evento php / mysql

Installazione:
Creare il seguente database e configurare i parametri su questo file di configurazione.

-- INIZIO COMANDO MYSQL

SET NAMES utf8;
SET foreign_key_checks = 0;
SET time_zone = '+01:00';
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE TABLE `board` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event` varchar(255) NOT NULL,
  `name` tinytext NOT NULL,
  `message` text NOT NULL,
  `dateins` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `guests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event` varchar(255) NOT NULL,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `nick` text NOT NULL,
  `citta` text NOT NULL,
  `provincia` text NOT NULL,
  `token` text NOT NULL,
  `pranzo` int(1) NOT NULL,
  `noglutine` int(1) NOT NULL,
  `vegetariano` int(1) NOT NULL,
  `vegan` int(1) NOT NULL,
  `dateins` datetime NOT NULL,
  `datemod` datetime NOT NULL,
  `confirmed` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event` varchar(255) NOT NULL,
  `name` tinytext NOT NULL,
  `message` text NOT NULL,
  `dateins` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- FINE COMANDO MYSQL

Copyright (C) 2013 Marco Bertocco [mrk25] http://bquery.com
This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
You should have received a copy of the GNU General Public License along with this program. If not, see http://www.gnu.org/licenses/. 

*****/

$folder_path = '/';

$base_url = ($_SERVER['HTTPS'])?'https':'http';
$base_url .= '://'.$_SERVER['HTTP_HOST'].$folder_path;
$base_dir = $_SERVER['DOCUMENT_ROOT'].$folder_path;


$theEvent = "ao-ppit-2014";
$confirm_subject  = "Assemblea Occasionale Partito Pirata: conferma la registrazione.";
$confirm_content = '';
$confirm_content .= "Hai effettuato la registrazione per l'assemblea occasionale del Partito Pirata Italiano che avrà luogo il giorno 25 Gennaio 2014 a Firenze, Via Campo d'Arrigo, 40 r.";
$confirm_sender = "noreply@bquery.com";
$tmpl = $theEvent;

$db_charset = 'utf-8';
$algo="sha256";
$salt = '3a1e8fa7fb5e5b013b938fb40c08fb46a8e460a0ac2a0809c6fb94868ccbafa0';


$users = array(
	'piratiFirenze' => 'supersecretpassword',
	'guest'=>'secretpassword',
	'pirata'=>'55d7ec4e6e4e2ddf35a6ab6d3f97cec35e197a76de9fd13f5ab4477a2b9d54d7',
);

$admins = array(
	'mrk25',
	'piratiFirenze'
);



$mysql_conn = mysql_connect('localhost', 'mysql_user', 'mysql_password');
if(!$mysql_conn){
die();
} else {
mysql_select_db('events');
$mysql_table_prefix = '';
}

require_once('functions.php');



function makeToken($email){
	global $algo, $salt;
	return hash($algo, $email.$salt);
}






if($_GET['confirm']){

	$confirmRow = mrksql_select('guests', '*', array('token'=>$_GET['confirm']), false, false);
	if(is_array($confirmRow[0])){
		mrksql_update('guests', array('confirmed'=>'1', 'datemod'=>date('Y-m-d H:i:s')), array('token'=>$_GET['confirm']));
		header('Location: '.$base_url.'confermato/');
	}

}



?>
