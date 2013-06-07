<?php

/*
 *  EVENT.PHP
 *
 *  This page shows you upcoming events your friends are going to. 
 *  Events are ranked by the number of friends attending.
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
</head>
<body>
  <div class="container" style="margin-top: 20px">
    <div class='page-header'>
      <h1>
        Evenimentele la care participa prietenii tai:
			</h1>
    </div>
  
    <?php

      // Do a batch query to grab events
      $multiquery = '{
        "getFriends":"SELECT uid2 FROM friend WHERE uid1 = me()",
        "getEventIDs":"SELECT eid FROM event_member WHERE uid in (SELECT uid2 FROM #getFriends) AND rsvp_status=\'attending\' AND start_time > '.time().'",
        "getEventNames":"SELECT pic_small, eid, name FROM event WHERE eid in (SELECT eid FROM #getEventIDs)",
      }';
      $results = $facebook->api(array('method' => 'fql.multiquery',
                                      'queries' => $multiquery));

      // Populate associated arrays that map ids to names and img_urls
      $events = $results[2]['fql_result_set'];
      foreach($events as $event) {
        $event_names[$event['eid']] = $event['name'];
        $event_pics[$event['eid']] = $event['pic_small'];
      }

      // Populate an array of event ids that friends are attending
      $members = $results[1]['fql_result_set'];
      foreach($members as $member) {
        $event_members[] = $member['eid'];
      }

      // Get the count of each element and sort to get the events most friends are attending
      $member_counts = array_count_values($event_members);
      arsort($member_counts);

      // Grab the 10 events most friends are attending
      $top_event_ids = array_slice($member_counts, 0, 10, true);

      // Display each event
      foreach($top_event_ids as $event_id => $count) {
        echo "
          <a href='http://facebook.com/".$event_id."'>
            <div class='well'>
              <img src='".$event_pics[$event_id]."' />
              <span>".$count." friends are attending ".$event_names[$event_id]."</span>
            </div>
          </a><br/>";
      }

    ?>

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
