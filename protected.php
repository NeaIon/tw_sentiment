<?php
/*
 *  PROTECTED.PHP
 *
 *  The page shows my status messages
 *  It grabs last status messages
 *  also generating the sentiment for them using the API from 
 *  http://help.sentiment140.com/api
 
       Copyright (C) <2013>  <NeaIon>

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
	require_once 'twitter.php';

function download_feed($path){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$path);
        curl_setopt($ch, CURLOPT_FAILONERROR,1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        $retValue = curl_exec($ch);                      
        
        return $retValue;
}
/* gets the sentiment  */
 
function sentiment($url) {
	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}

function polaritate($url) {
	$rezultate = (sentiment($url)); 
	    $obj = json_decode($rezultate, true);
		$foo = $obj[results];
	return $foo;

function getConnectionWithAccessToken($oauth_token, $oauth_token_secret) {
  $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $oauth_token, $oauth_token_secret);
  return $connection;
}
 
$connection = getConnectionWithAccessToken("190362028-ROKMffF5DX0bEOd3oeCOZkYUbkt8zP8IAaLRzkaY", "Fh35bIaAnme1sWQUZA0sRlLNvXocFPCCYEC7mSpDEk");
$content = $connection->get("statuses");
}
?>
<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#">
  <head>
    <title>O lista cu postarile tale:</title>
	<meta charset="utf-8" />
  <link rel="stylesheet" type="text/css" href="css/style.css" />
 <link href='https://fonts.googleapis.com/css?family=Exo:700,700italic|Average' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" type="text/css" href="_/css/mystyle.css">
  <script type="text/javascript" src="_/js/jquery-1.7.2.min.js"></script>
  <script type="text/javascript" src="_/js/myscript.js"></script>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
            <meta name="description" lang="ro" xml:lang="ro"
               content="Proiect la disciplina Tehnologii Web"/>
            <meta name="keywords" lang="ro" xml:lang="ro"
               content="Web, Twitter, WWW, tehnologie, informatica, facultate, universitate, proiect, programare, software, infoiasi, tw2013"/>
            <meta name="author" content="Ionut Captari - http://www.neaion.ro"/> 
</head>
<body>
    
    <div class="container" style="margin-top: 20px">
    <div class='page-header'>
      <h1>O lista cu postarile de pe Twitter a user-ului SnookiLala</h1>
    </div>

<pre>
<?php


$sXML = download_feed('api.twitter.com/1/statuses/user_timeline/SnookiLala.rss?count=10');
$oXML = new SimpleXMLElement($sXML);

$i=0;

foreach($oXML->channel->item as $oDocuments){
        $title = strip_tags($oDocuments->title);
		$desc = $oDocuments->description;
        $url = $oDocuments->link;

        echo "<br/><center><h2>--------   Mesajul  " . $i. "   ------------</h2></center><br/>";
        echo "<br/><center><h2>" .$desc . "</h2></center><br/>";
		echo "<center><a href='". $url. "' target='_blank'>". $url. "'</a></center><br/>";
		echo "<br/>Sentimentul acestui post este:<br/>";
		
		echo "<a href='http://www.sentiment140.com/api/classify?text=". urlencode($title). "' target='_blank'>http://www.sentiment140.com/api/classify?text=". urlencode($title). "'</a><br/>";
		$polar = polaritate("http://www.sentiment140.com/api/classify?text=". urlencode($title). "");
	echo "Are polaritatea {$polar['polarity']}, adica este:";
	$vari = $polar['polarity'];
	
	if ($vari == 4) 
            {echo "POZITIVA!<br/>";
	         echo "<center>Vizionati ceva infricosator.</center><br/>";
			 echo '<center><iframe width="560" height="315" src="https://www.youtube.com/embed/d2oQ6VbVIco" frameborder="3" allowfullscreen></iframe></center>';
			}
	if ($vari == 0) 
	       {echo "NEGATIVA!<br/>";
	        echo "<center>Vizionati ceva mai funny :)</center><br/>";
			echo '<center><iframe width="560" height="315" src="https://www.youtube.com/embed/DMafMtCBRIQ?list=UUBoJgitVZDzJr2BH1BLJQ3A" frameborder="2" allowfullscreen></iframe></center>';
			}
	if ($vari == 2) 
	        {echo "NEUTRA!<br/>";
	        echo "<center>Vizionati ceva normal.</center><br/>";
			echo '<center><iframe width="560" height="315" src="https://www.youtube.com/embed/at_f98qOGY0" frameborder="3" allowfullscreen></iframe></center>';
			}
       $i++;
}


?>
   </pre>
 </div>

<br/><br/>
  <center>
  <a class='btn' href='index.php'>Inapoi</a><br/><br/>
  <a href="http://www.gnu.org/licenses/gpl.html" target="_blank"> 
  <img src="http://www.gnu.org/graphics/gplv3-88x31.png" border="0" />
  </a> 
  <center>
</body>
</html>