<?php

  //get configuration variables
  $singularity = file("config.html");
  $bigbang = explode(",", $singularity[0]);
  
  $n_host = $bigbang[0];
  $n_uname = $bigbang[1];
  $n_passwd = $bigbang[2];
  $n_header = $bigbang[3];
  $n_subheader = $bigbang[4];
  $n_subjname = $bigbang[5];
  $n_section = $bigbang[6];
  
	//connect to database
	$con = mysql_connect($n_host,$n_uname,$n_passwd);
	if (!$con)
	  {
	  die('Could not connect: ' . mysql_error());
	  }
	
	mysql_select_db("neithanST", $con);

/************************************************************************/                                                                       


//HEADER
  //external style sheet
	echo "<head> 
              <link rel='stylesheet' href='scoreboard.css' type='text/css'>	
			</head>";

	//header for Standings page
  //$header = "In Preparation for Finals (Part II) Scoreboard";
  //$subheader = "MTHS024 N1 3:00PM - 4:30PM";
  //$section = "N1";
	Echo "<br><br><font size='4' face='Verdana'> &nbsp;" . $n_header . " Teacher's Page </font> <img class='labelbutton' id='seal' src='resources/sealg.png' alt='Adnu Seal' width='35' height='35' align='left'><br>
  <font face='Verdana' size='1'>&nbsp; " . $n_subjname . " " . $n_section . "<br>&nbsp; " . $n_subheader . "</font> <br><br><!-- <hr> -->";




	$NumProbs = mysql_num_rows(mysql_query("select * from problems where sec='" . $n_section . "'")); // Number of problems in the set
	$NumStuds = mysql_num_rows(mysql_query("select * from players where section='" . $n_section . "' order by score desc")); // Number of students in the class	

/*
	for ($i = 1; $i <= $NumStuds; $i = $i + 1){
        	for ($j = 1; $j <= $NumProbs; $j = $j + 1){
			
			echo $i . $j . " ";
		}
		echo "<br>";
	}

*/
  
  //get the maximum id, to serve as limit during the check., student 34 could have an id of 2314 so... yeah.,., I want coffee.
  $get_maxID = mysql_query("select id from players where section='" . $n_section . "' order by id desc limit 1");
  $maxID = mysql_fetch_row($get_maxID) or die(mysql_error());
  //echo "Maximum value is ::  ".$maxID[0];
  
  
  //begin table
  echo "<center><table border=1 cellpadding=7 cellspacing=1 width=90% class='labelbuttontable'>";

	for ($x = 1; $x <= $NumProbs; $x++){

		$y = chr($x+96);
		//echo $y . $x . " ";

			//if ($_GET[$y] == 'on'){
				echo "<tr><td>Submissions for problem - " . $y . "<br><br>";

				for ($i = 1; $i <= $maxID[0]; $i = $i + 1){
					//echo $y.$i . " ";
                 
					if ($_GET[$y.$i] == 'on'){ //update if AC submission
						echo "<font color=#229922>AC from team ID " . $i . "</font><br></td></tr>";
                    
            //update score         
            //check if there was already a previous successful submission from the team. If exists, then do not add a point to the team
            $duplicateSub = mysql_query("select p" . $y . "s from slates, players where id=" . $i . " and id=slateID");
            $pdS = mysql_fetch_row($duplicateSub) or die(mysql_error());
            //echo $pdS[0]; //will print N or Y depending on if the problem was already solved or not.
            if ($pdS[0] == 'N'){
               mysql_query("update players,slates set score=score+1, p" . $y . "s='Y', p" . $y ."a = p" . $y . "a + 1 where slateID=id and id = " . $i);
               
               
               
               //add score check if 99999
               $get_scorepeek = mysql_query("select time from players where id=" . $i);
               $scorepeek = mysql_fetch_row($get_scorepeek) or die(mysql_error());
               //echo $scorepeek[0];
               
               //set to zero if score is > 9000
               if ($scorepeek[0] > 9000)
                  mysql_query("update players set time=0 where id=" . $i);
               
               //add problem specific time to team/player time
               $updatePlayerTime = "update players, slates set time=time+p" . $y  . "t where slateID=id and id =" . $i;
               //echo $updatePlayerTime;
               mysql_query($updatePlayerTime);
               
            }
            //write to logs for team to know if their submissions got through
/*          $file = fopen("slogs.html","a") or die("can't open file");
            $log = "Verdict: Team " . $i . "'s submission for problem " . strtoupper($y) . " - ACCEPTED!<br>" . PHP_EOL;
            fwrite($file, $log); 
 */            
            //delete from submissions table
            $toBeDeleted = mysql_query("select subID from submissions where probID='" . $y . "'and teamID='" . $i . "'");
            while ($tbd_display = mysql_fetch_array($toBeDeleted)){
                  mysql_query("delete from submissions where subID='" . $tbd_display['subID'] . "'");
            }            
            

					}

        

					if ($_GET[$y."attempt".$i] == 'on'){ //update if !AC submission
						echo "<font color=#992222>!AC from team ID " . $i . "</font><br>";
            mysql_query("update players,slates set p" . $y ."a = p" . $y . "a + 1, p" . $y . "t=99999 where slateID=id and id = " . $i);

/*          $file = fopen("slogs.html","a") or die("can't open file"); //write to logs for team to know if their submissions got through
            $log = "Verdict: Team " . $i . "'s submission for problem " . strtoupper($y) . " - INCORRECT! <br>" . PHP_EOL;
            fwrite($file, $log); 
 */
            //delete from submissions table
            $toBeDeleted = mysql_query("select subID from submissions where probID='" . $y . "'and teamID='" . $i . "'");
            while ($tbd_display = mysql_fetch_array($toBeDeleted)){
                  mysql_query("delete from submissions where subID='" . $tbd_display['subID'] . "'");
            }            

					}
           
				}
		
			//}

	}
 
  //end table
  echo "</table></center>";


  //unusual teamID==0 phenomenon check
  mysql_query("delete from submissions where teamID=0");

/************************************************************************/

	echo "<br><center><a href='submissions.php' style='text-decoration:none'><input type='button' class='button' value='Check Some More Submissions!'></a></center>";
	
?>
