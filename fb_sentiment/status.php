<?php

/*
 *  STATUS.PHP
 *
 *  The page shows your status messages
 *  It grabs the status messages 
 *  and generating the sentiment for them using the API from http://help.sentiment140.com/api
 *                  Copyright (C) <2013>  <NeaIon>

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
 *
 */

require_once 'fb/auth.php';

// If there is no logged in user, redirect to login.php
if(!$user)
  header("Location: login.php");

// function is using Curl requests to GET response from the API located @ http://www.sentiment140.com/api
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
// function is getting specific polarity value from the returned json object
function polaritate($url) {
	$rezultate = (sentiment($url)); 
	    $obj = json_decode($rezultate, true);
		$foo = $obj[results][polarity];
	return $foo;
}
 

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" type="text/css" href="css/style.css" />
  <title>O lista cu postarile tale:</title>
</head>
<body>
  <div class="container" style="margin-top: 20px">
    <div class='page-header'>
      <h1>
        Sentiment analysis
        <small>by Ionut CAPTARI</small>
      </h1>
    </div>
	
<?php
    // Fetch the user's last 100 statuses
    $statuses = $facebook->api('/'.$user.'/statuses', "GET", array("limit"=>"100"));
    $statuses = $statuses["data"];
?>
	
<h3>Latest 20 posts from your timeline:</h3>

<pre>
<?php 

    for ($i = 0; $i <= 20; $i++)
	{
		$text = $statuses[$i]["message"];
		echo "<div class='well'>";	   
        echo "<br/><center><h3>Message " . $i . ":</h3></center><br/>";
		echo $text;
         echo "<br/>-----------------------------------------------<br/>";
		 
		// if the text lenght is lower than 150 characters the sentiment can be conclusive	
	    if (strlen($text) <= 150){
		echo "<a href='http://www.sentiment140.com/api/classify?text=". urlencode($text). "'>http://www.sentiment140.com/api/classify?text=". urlencode($text). "'</a>";
		if ($text !="") {
		$vari = polaritate("http://www.sentiment140.com/api/classify?text=". urlencode($text). "");
		echo "<br/>-----------------------------------------------<br/>";
	    echo "Has polarity ". $vari . "! This means it is:";
	
	    
    // testing $vari = the returned polarity  and making some sugestions for the user
	if ($vari == 4) 
            {echo "POZITIVE!<br/>";
	         echo "<center><a href='http://www.youtube.com/watch?v=d2oQ6VbVIco'>Vizionati ceva infricosator.</a></center><br/>";
			 echo '<center><iframe width="560" height="315" src="https://www.youtube.com/embed/d2oQ6VbVIco" frameborder="3" allowfullscreen></iframe></center>';
			}
	if ($vari == 0) 
	       {echo "NEGATIVE!<br/>";
	        echo "<center><a href='http://www.youtube.com/user/funnymadshow?feature=chclk'>Vizionati ceva mai funny :)</a></center><br/>";
			echo '<center><iframe width="560" height="315" src="https://www.youtube.com/embed/DMafMtCBRIQ?list=UUBoJgitVZDzJr2BH1BLJQ3A" frameborder="2" allowfullscreen></iframe></center>';
			}
	if ($vari == 2) 
	        {echo "NEUTRAL!<br/>";
	        echo "<center><a href='http://www.youtube.com/watch?v=at_f98qOGY0'>Vizionati ceva normal.</a></center><br/>";
			echo '<center><iframe width="560" height="315" src="https://www.youtube.com/embed/at_f98qOGY0" frameborder="3" allowfullscreen></iframe></center>';
			}
	}
	// if there is no text on the post/there is just a share of something on user's wall then the sentiment will not be generated 
    if ($text =="") { echo "<br/>Message " . $i . " is empty. No sentiment generated.<br/>"; }
				
	}
	// if the text lenght is bigger than 150 characters the sentiment will not be conclusive
	if (strlen($text) > 150){ echo "<br/>Message " . $i . " is too big. No sentiment generated.<br/>"; }
	echo "</div>";}
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
