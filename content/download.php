<?php

// Error reporting:
error_reporting(E_ALL^E_NOTICE);

// Including the connection file:

$directory='upload_file';
if(!$_GET['file']) error('Missing parameter!');
if($_GET['file']{0}=='.') error('Wrong file!');



if(file_exists($_GET['file']))

{
	
	/* If the visitor is not a search engine, count the downoad: */
	if(!is_bot())
		
		$date=date("d-m-Y G:i:s");
	mysql_query("	INSERT INTO download_ebook SET kd_ebook='".mysql_real_escape_string($_GET['id'])."' 
					ON DUPLICATE KEY UPDATE hits=hits+1") or die(mysql_error());
	
	echo"<script>window.location=\"".$_GET['file']."\"</script>"; 
	
	exit;
}
else error("This file does not exist!");


/* Helper functions: */

function error($str)
{
	die($str);
}


function is_bot()
{
	/* This function will check whether the visitor is a search engine robot */
	
	$botlist = array("Teoma", "alexa", "froogle", "Gigabot", "inktomi",
	"looksmart", "URL_Spider_SQL", "Firefly", "NationalDirectory",
	"Ask Jeeves", "TECNOSEEK", "InfoSeek", "WebFindBot", "girafabot",
	"crawler", "www.galaxy.com", "Googlebot", "Scooter", "Slurp",
	"msnbot", "appie", "FAST", "WebBug", "Spade", "ZyBorg", "rabaz",
	"Baiduspider", "Feedfetcher-Google", "TechnoratiSnoop", "Rankivabot",
	"Mediapartners-Google", "Sogou web spider", "WebAlta Crawler","TweetmemeBot",
	"Butterfly","Twitturls","Me.dium","Twiceler");

	foreach($botlist as $bot)
	{
		if(strpos($_SERVER['HTTP_USER_AGENT'],$bot)!==false)
		return true;	// Is a bot
	}

	return false;	// Not a bot
}
?>