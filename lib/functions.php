<?php

unset($query_error);

function mrksql_error(){
	global $query_error;
	if($query_error){
	echo'<div class="error">'.$query_error.'</div>';
	}
}

//escape GET and POST before doing anything

function mrksql_escape(){
	
	global $browser_input_escaped;
	
	//echo 'Input sanitized by mrksql_escape - deprecated';
	
	if($browser_input_escaped == true){
	return true;
	} else {
	
		foreach($_GET as $k => $v){
			if(!is_array($v)){
			$_GET[$k] = mysql_real_escape_string($_GET[$k]);
			} else {
				foreach($v as $kk => $vv){
				$_GET[$k][$kk] = mysql_real_escape_string($_GET[$k][$kk]);
				}
			}
		}
		foreach($_POST as $k => $v){
			if(!is_array($v)){
			$_POST[$k] = mysql_real_escape_string($_POST[$k]);
			} else {
				foreach($v as $kk => $vv){
				$_POST[$k][$kk] = mysql_real_escape_string($_POST[$k][$kk]);
				}
			}
		}
		
		foreach($_REQUEST as $k => $v){
			if(!is_array($v)){
			$_REQUEST[$k] = mysql_real_escape_string($_REQUEST[$k]);
			} else {
				foreach($v as $kk => $vv){
				$_REQUEST[$k][$kk] = mysql_real_escape_string($_REQUEST[$k][$kk]);
				}
			}
		}

		$browser_input_escaped = true;
	
	}
	
}


function mrksql_select($table, $fields, $condition, $order, $limit){

global $db_charset, $query_error, $mysql_table_prefix;
//mrksql_escape();

$query = "SELECT ".$fields." FROM ".$mysql_table_prefix.mysql_real_escape_string($table);

	if($condition){
		//PER VALIDARE UN INPUT UTENTE PASSARE UN ARRAY CHE VIENE ESCAPATO E CONCATENATO COME SERIE DI AND $K = $V
		if(!is_array($condition)){
		//echo '---querying with condition not sanitized---';
		$query .= " WHERE ".$condition;
		} else {
			
			$query .= " WHERE ";
			
			$fields = 0;
			$totfields = count($condition) - 1;
			foreach($condition as $k => $cond){
			//$query .= htmlentities($k, ENT_QUOTES, $db_charset)." = '".htmlentities($cond, ENT_QUOTES, $db_charset)."'";
			$query .= mysql_real_escape_string($k)." = '".mysql_real_escape_string($cond)."'";
				if($fields < $totfields){
				$query .= " AND ";
				}
				$fields++;
			}
		}
		//$query .= " WHERE ".$condition;	
	}
	if($order){
	$query .= " ORDER BY ".$order;
	}
	if($limit){
	$query .= " LIMIT ".$limit;
	}
//echo $query;	
$result = mysql_query($query);
$data = array();
while($row = mysql_fetch_assoc($result)){
$data[] = $row;
}


return $data;

}


function mrksql_insert($table, $array, $htmlentitize=false){

global $db_charset, $query_error, $mysql_table_prefix;
//mrksql_escape();

$keys = "";
$values = "";
$fields = 0;
$totfields = count($array) - 1;
foreach($array as $k => $v){

	if($htmlentitize){
	$keys .= htmlentities($k, ENT_QUOTES, $db_charset);
	} else {
	$keys .= mysql_real_escape_string($k);
	}
	if($fields < $totfields){
	$keys .=",";
	}
	
	if($htmlentitize){
	$values .= "'".htmlentities($v, ENT_QUOTES, $db_charset)."'";
	} else {
	$values .= "'".mysql_real_escape_string($v)."'";
	}
	if($fields < $totfields){
	$values .=",";
	}
	$fields++;

//$keys[] = htmlentities($k, ENT_QUOTES, $db_charset);
//$values[] = htmlentities($v, ENT_QUOTES, $db_charset);
}

//$keys = explode(',' $keys);
$query = "INSERT INTO ".$mysql_table_prefix.mysql_real_escape_string($table)." (".$keys.") VALUES (".$values.")";
//echo $query;
	if(!mysql_query($query)){
	$query_error .= mysql_error().'<br />';
	return false;
	} else {
	return true;
	}
	
}

function mrksql_update($table, $array, $condition, $htmlentitize=false){

global $db_charset, $query_error, $mysql_table_prefix;
//mrksql_escape();

$fields = 0;
$totfields = count($array) - 1;

$query = "UPDATE ".$mysql_table_prefix.mysql_real_escape_string($table)." SET ";
foreach($array as $key => $value){
	if($htmlentitize){
	$query .= htmlentities($key, ENT_QUOTES, $db_charset)." = '".htmlentities($value, ENT_QUOTES, $db_charset)."'";
	} else {
	$query .= mysql_real_escape_string($key)." = '".mysql_real_escape_string($value)."'";
	}
	if($fields < $totfields){
	$query .=', ';
	}
	$fields++;
}

	if($condition){
			
		if(!is_array($condition)){
		//echo '---querying with condition not sanitized---';
		$query .= " WHERE ".$condition;
		} else {
			
			$query .= " WHERE ";
			
			$fields = 0;
			$totfields = count($condition) - 1;
			foreach($condition as $k => $cond){
			//$query .= htmlentities($k, ENT_QUOTES, $db_charset)." = '".htmlentities($cond, ENT_QUOTES, $db_charset)."'";
			$query .= mysql_real_escape_string($k)." = '".mysql_real_escape_string($cond)."'";
				if($fields < $totfields){
				$query .= " AND ";
				}
				$fields++;
			}
		}
			
	} else {
	return false;
	}
	
	if(!mysql_query($query)){
	$query_error .= mysql_error().'<br />';
	return false;
	} else {
	return true;
	}

//echo $query;
	
}


function mrksql_delete($table, $condition){

global $query_error, $mysql_table_prefix;
//mrksql_escape();

$query = "DELETE FROM ".$mysql_table_prefix.mysql_real_escape_string($table)." WHERE ".$condition;
	if(!mysql_query($query)){
	$query_error .= mysql_error().'<br />';
	return false;
	} else {
	return true;
	}
}



//COUNT A RESULT SET
function mrksql_count($table, $fields=0, $condition='1'){
//mrksql_escape();
	
	$query = "SELECT COUNT(".$fields.") FROM ".$table;
		
		if(!is_array($condition)){
		$query .= " WHERE ".$condition;
		} else {
			
			$query .= " WHERE ";
			$fields = 0;
			$totfields = count($condition) - 1;
			foreach($condition as $k => $cond){
			$query .= mysql_real_escape_string($k)." = '".mysql_real_escape_string($cond)."'";
				if($fields < $totfields){
				$query .= " AND ";
				}
				$fields++;
			}
		}
		
	$data = mysql_query($query);
	$data = mysql_result($data, 0);

	return $data; 

}


//FULL TEXT MODE SEARCH
function mrksql_search($table, $fields, $searchfields, $searchkey, $condition=false, $wildcard=true, $boolean_mode=true, $query_expansion=true){
//mrksql_escape();
	
	if($boolean_mode && $wildcard){
	$searchkey = $searchkey.'*';
	}
	
	$query = "SELECT ".$fields." FROM ".$table." WHERE ";
	$query .= "MATCH (".$searchfields.") ";
	$query .= "AGAINST ('".$searchkey."' ";
	
	if($boolean_mode){
	$query .= "IN BOOLEAN MODE ";
	} else {
	$query .= "IN NATURAL LANGUAGE MODE ";
	
		if($query_expansion){
		$query .= "WITH QUERY EXPANSION";
		}
		
	}
	
	

	$query .= ')';
	
	if($condition){
	$query .= " AND ".$condition;
	}
	
	$result = mysql_query($query);
	while($row = mysql_fetch_assoc($result)){
	$data[] = $row;
	}

	return $data;


}

// EOF MySQL lib


function urlsToLinks($text, $blank=true){
   
    preg_match_all('!https?://[\S]+!', $text, $urls);
    foreach($urls['0'] as $k => $url){
        $url = preg_replace('/\//', '\/', quotemeta($url));
            if($blank){
            $text = preg_replace( '/'.$url.'/', '<a target="_blank" href="'.$url.'">'.$url.'</a>', $text);
            } else {
            $text = preg_replace( '/'.$url.'/', '<a href="'.$url.'">'.$url.'</a>', $text);
            }
    }
    
    return stripslashes($text);

}



//FUNZIONE PARSING XML (SOLO PHP5)
function parseFeed($url, $max_items=8, $tagname='item'){

		$doc = new DOMDocument();
		$doc->load($url);


		$feed = array();

		$items = $doc->getElementsByTagName($tagname);

		$nodeNUM = 0;

		foreach ($items as $item) {
		    //echo $item->nodeValue . "<br />";
		    $feed[$nodeNUM] = array();
		    foreach($item->childNodes as $node){
		    	$feed[$nodeNUM][$node->nodeName] = $node->nodeValue;
		    }
		    $nodeNUM++;
		    if($nodeNUM >= $max_items){ break; }
		}

		return $feed;

}




// FUNZIONI PER LE DATE


function timestamp2monday($timestamp){

$day = date('N', $timestamp) -1;
$offset = $day*24*60*60;	
$monday = $timestamp - $offset;

return $monday;

}


function timestamp2sunday($timestamp){

$day = date('N', $timestamp) -1;
$offset = $day*24*60*60;	
$monday = $timestamp - $offset;
$sunday = $monday + 7*24*60*60;

//return date('m/d', $monday).'-'.date('m/d', $sunday);
//return date('M/d', $monday).'-'.date('d', $sunday);
return $sunday;

}


function timestamp2range($timestamp){

$day = date('N', $timestamp) -1;
$offset = $day*24*60*60;	
$monday = $timestamp - $offset;
$sunday = $monday + 7*24*60*60;

//return date('m/d', $monday).'-'.date('m/d', $sunday);
//return date('M/d', $monday).'-'.date('d', $sunday);
return date('M-d', $sunday);

}


function timestamp2month($timestamp){
return date('M Y', $timestamp);
}



function round_yo($number){

$chiphers = strlen(round($number, 0));

//$chiphers = $chiphers/3;
if($chiphers <= 3){
$number = $number;
$unit = '';
}
elseif($chiphers <= 6){
$number = round($number, -3)/1000;
$unit = 'K';
}

elseif($chiphers <= 12){
$number = round($number, -5)/1000000;
$unit = 'M';
}

else {
$number = '&uarr;';
$unit= '&uarr;';
}

return $number.$unit;



}



//DEBUG UTILITY
function debug($var){

	echo '<pre class="debug">';
	print_r($var);
	echo '</pre>';

}

?>
