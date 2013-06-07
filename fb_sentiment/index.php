<?php

/*
 *  INDEX.PHP
 *  
 *  Landing page of the site. Provides links to go to each feature built
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
 */

require_once 'fb/auth.php';

// If there is no logged in user, redirect to login.php
if(!$user) 
  header("Location: login.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" type="text/css" href="css/style.css" />
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
            <meta name="description" lang="ro" xml:lang="ro"
               content="Proiect la disciplina Tehnologii Web"/>
            <meta name="keywords" lang="ro" xml:lang="ro"
               content="Web, WWW, technologie, informatica, facultate, universitate, proiect, programare, software, infoiasi, tw2013"/>
            <meta name="author" content="Ionut Captari - http://www.neaion.ro"/> 
</head>
<body>
  <div class="container" style="margin-top: 20px">
    <div class='page-header'>
      <h1>
        Your sentiments generated from your latest statuses - Proiect Infoiasi 2013<br/><br/>
        <small>Proiect no.22 : MoSoR (Mood Social Recommender)</small><br/><br/>
		<small>ROU:  Se doreste implementarea unei aplicatii Web care sa analizeze mesajele emise pe Twitter si Facebook pentru a pune la dispozitie recomandari de resurse in functie de starea de spirit a utilizatorului --aceasta poate fi stabilita dinamic de catre utilizator sau (bonus) va putea fi detectata automat.</small><br/><br/>
		<small>EN:  We need to implement a web app which will analyze posts on Twitter and on Facebook and suggest recommendations according to users sentiments --  this can be dynamically set by the user or (bonus) will be automatically detected.</small><br/>
      <small><br/>Resources: <a href="http://help.sentiment140.com/api"> http://help.sentiment140.com/api</a></small><br/>
	  </h1>
    </div>
    <div class="btn-group">
      <a class='btn' href='status.php'>Status sentiment (Open graph)</a>
      <a class='btn' href='event.php'>Friends events (FQL Multiquery)</a>
    </div>
  </div>
  
  <br/><br/>
  <center>
  <a href="http://www.gnu.org/licenses/gpl.html" target="_blank"> 
  <img src="http://www.gnu.org/graphics/gplv3-88x31.png" border="0" />
  </a> 
  <center>
  
</body>
</html>
