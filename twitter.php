<?php
/* 
 * We will add the following line to the top 
 * of any page to be protected:
 * 	twitterProtect();
 *
 * CONFIG
 * $consumer_key - Twitter consumer key
 * $consumer_secret - Twitter consumer secret
 * $home - Where to send users upon login
 */

$consumer_key = "lrEEhEQKwxEQovpju5oWUQ";
$consumer_secret = "jY4PFaieh8PEExqa3goSWKVKfotU6WADNbEk0UgtaE";
$home = "http://students.info.uaic.ro/~ionut.captari/protected.php";


session_start();
require_once 'twitter-async/EpiCurl.php';
require_once 'twitter-async/EpiOAuth.php';
require_once 'twitter-async/EpiTwitter.php';

/* Call this wherever you would like your login link */
function twitterLogin(){
	global $consumer_key, $consumer_secret;
	if (!$consumer_key || !$consumer_secret) die ('Please enter your consumer key/secret!');
	if (isset($_GET['oauth_token'])) twitterCallback();
	$twitterObj = new EpiTwitter($consumer_key, $consumer_secret);
	$url = $twitterObj->getAuthorizationUrl();

	
       echo "<div class='container' style='margin:50px 0px; padding:0px;text-align:center;'>
                  <div class='page-header' style='width:900px;	margin:0px auto;text-align:left;padding:15px;border:1px dashed #333;background-color:#eee;'>
            <h1> Your Twitter sentiments generated from your latest tweets - Proiect Infoiasi 2013<br/><br/>
              <small>Proiect no.22 : MoSoR (Mood Social Recommender)</small><br/><br/>
		<small>ROU:  Se doreste implementarea unei aplicatii Web care sa analizeze mesajele emise pe Twitter si Facebook pentru a pune la dispozitie recomandari de resurse in functie de starea de spirit a utilizatorului --aceasta poate fi stabilita dinamic de catre utilizator sau (bonus) va putea fi detectata automat.</small><br/><br/>
		<small>EN:  We need to implement a web app which will analyze posts on Twitter and on Facebook and suggest recommendations according to users sentiments --  this can be dynamically set by the user or (bonus) will be automatically detected.</small><br/>
              <small><br/>Resources: <a href='http://help.sentiment140.com/api'> http://help.sentiment140.com/api</a></small><br/>

	     </h1>
                 </div><br/><br/><center>
                <div class='btn-group'>
                <a class='btn' href='$url'><img src=\"https://si0.twimg.com/images/dev/buttons/sign-in-with-twitter-l.png\" /></a>
                <a class='btn' href='protected.php'>   Status sentiment (Twitter API)</a>
                </div></center>
           </div>
<br/><br/>
  <center>
  <a href='http://www.gnu.org/licenses/gpl.html' target='_blank'> 
  <img src='http://www.gnu.org/graphics/gplv3-88x31.png' />
  </a> 
  <center>
";
}


/* We'll call this function on every protected page.
 * If the user is not logged in, the logon link is displayed.
 */
function twitterProtect(){
	if ($_SESSION['logged_in']) return true;
	echo "<p>You must be logged in to view this page!</p>";
	// Display login link for convenience
	twitterLogin();
	exit();
}

function postUser(){ print_r($userr);}
/* Process login callback, this can be called from any page proteced by
 * twitterLogin(), the index.php page is recommended though.
 * Once logged in, we are forwarded to the homepage.
 */
function twitterCallback(){
	if ($_SESSION['logged_in']){ header ('Location: /'); exit(); }
	global $consumer_key, $consumer_secret, $home;
	$twitterObj = new EpiTwitter($consumer_key, $consumer_secret);
	$twitterObj->setToken($_GET['oauth_token']);
	$token = $twitterObj->getAccessToken();
	$twitterObj->setToken($token->oauth_token, $token->oauth_token_secret);
	$_SESSION['ot'] = $token->oauth_token;
	$_SESSION['ots'] = $token->oauth_token_secret;
	$twitterInfo= $twitterObj->get_accountVerify_credentials();
	$twitterInfo->response;
	$username = $twitterInfo->screen_name;
	$_SESSION['logged_in'] = $username;
	// Here you can integrate a database backed login system with stored users and sessions
	header ("Location: $home");
	echo $_SESSION['logged_in'];
	exit(); 
	
}


/* Function to log the user out and destroy the session */
function twitterLogout(){
	unset($_SESSION['logged_in']);
	session_destroy();
	echo "You have logged out, <a href=\"/\">click here</a> to return to the home page.";
	exit();
}

?>
