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
 
 //start session
 session_start();

/************************************************************************/
//TEST AREA

//TEST AREA
/************************************************************************/

	//timed refresh
	//Echo "<meta http-equiv='refresh' content='4'>"; 

	//header interface
	//header for Standings page
  //$header = "Final Examination (Part II) Submission Page";
  //$subheader = "MTHS024 N1 3:00PM - 4:30PM";
  //$section = "N1";
  
	Echo "<br><br><font size='4' face='Verdana'> &nbsp;" . $n_header . " Submission Receipt Page </font> <img class='labelbutton' id='seal' src='resources/sealg.png' alt='Adnu Seal' width='35' height='35' align='left'><br>
  <font face='Verdana' size='1'>&nbsp; " . $n_subjname . " " . $n_section . "<br>&nbsp; " . $n_subheader . "</font> <br><br><!-- <hr> -->";

  //external style sheet
	echo "<head> 
              <link rel='stylesheet' href='scoreboard.css' type='text/css'>	
			</head>";

	echo "<form action='submit.php' method='GET'>";
  
  //explode prob letter and name
  $explosion = explode(",", $_GET['problem']);
  
  $team = $_SESSION['currID'];
  $problem = $explosion[0];
  $problemN = $explosion[1];
  $solution = $_GET['solution'];

  echo "<center>";
  echo "<table border=1 cellpadding=7 cellspacing=1 width=90% class='labelbuttontable'>";
   echo "<tr>";
        echo "<td>";
                 echo "team " . $team . "'s submission for problem " . strtoupper($problem);
        echo "</td>";
   echo "</tr>";
   echo "<tr>";
        echo "<td>";
                 echo '<pre>' . nl2br(htmlspecialchars($solution)) . '</pre>' . "<br>";
        echo "</td>";
   echo "</tr>";
  echo "</table>";
  /*
  $file = fopen("slogs.html","a") or die("can't open file"); //write to logs for team to know if their submissions got through
  $log = "Submission: Team " . $team . " submitted a solution for problem " . strtoupper($problem) . "...<br>" . PHP_EOL;
  fwrite($file, $log); 
  */
  //compile code
  /*
  system("touch " . $team . $problem . ".cpp");
  system("chmod a+rwx " . $team . $problem . ".cpp");
  $fh = fopen($team . $problem . ".cpp", 'w') or die("can't open file");
  fwrite($fh, $solution);
  system("g++ " . $team . $problem . ".cpp" . " -o " . $team . $problem);
  $run1 = "./" . $team . $problem;
  exec($run1,$output);
  $final='';
         foreach($output as $out){
                         $final .= $out;
                         $final .= "<br />";
         }
*/
  //if programming write to submissions database for neithan to do some checking mysql_real_escape_string(nl2br(htmlspecialchars($runfl)))
  /* $con = mysql_query("insert into submissions values(NULL,'". $team . "','". $problem . "','" . $problemN . "','" . '<pre>' . $final . '</pre>' ."')")
  
  */
  
  
   
   //if not programming write to solution
   $con = mysql_query("insert into submissions values(NULL,'". $team . "','". $problem . "','" . $problemN . "','" . mysql_real_escape_string(nl2br(htmlspecialchars($solution))) ."')")
   
         or die("<font color='red' size=3>SUBMISSION FAILED<br></font><font color=#500 size=2>" . 
         mysql_error() . "<br><br>
         </font><font color=red>REMEMBER:</font> Do not copy and paste everything that your R command returns<br>
         Include only straightforward commands / results of those commands and appropriate justifications and/or conclusions<br><br>
         <br><input type='submit' value='Go Back To Submission Page'>"
         );
  
//get time of submission relative to start of competition
     $to_time = strtotime(date('Y/m/d h:i:s', time()));
     //echo $to_time . "<br>";
     $from_time = strtotime($n_subheader);
     $sub_time = round(abs($to_time - $from_time) / 60,2);  
  
  if($con){
          echo "<font color='blue' size=3>SUBMISSION RECEIVED!</font><font size=3></font><br><font size=2>solution submitted approximately " . $sub_time . " minutes after contest began</font><br>";
  
  
      //check if there was already a previous successful submission from the team. If exists, then do not add a point to the team
      $duplicateSub = mysql_query("select p" . $problem . "s from slates, players where id=" . $team . " and id=slateID");
      $pdS = mysql_fetch_row($duplicateSub)
             or die(
                "<font color='red' size=3>BUT NO PROBLEM WAS SELECTED</font><font color=#500 size=2><br>Ooooops! It looks like you didn't choose a problem (step 1)<br>we can't really know what to check<br>error report: " . mysql_error() . "<br><font color='red' size=3>PLEASE TRY SUBMITTING AGAIN</font><br>This time make sure you select the problem you're submitting a solution to.<br><br>" .
                
                "<center><a href='submit.php' style='text-decoration:none'><input type='button' class='buttontwo' value='Back to Submissions Page'></a></center>"
                
                );
            
     if ($pdS[0] == 'N'){           
        //write sub time to p-<letter corresponding to problem being solved>-t
        //mysql_query("insert into submissions values(NULL,'". $team . "','". $problem . "','" . $problemN . "','" . '<pre>' . $final . '</pre>' ."')")
        $enterSubTime = "update slates set p" . $problem . "t=" . $sub_time . " where slateID=" . $team . "";
        mysql_query($enterSubTime) or die(mysql.error());
        //echo $enterSubTime . "<br>";    
     }  
  }
  else
          echo "<font color='red' size=3>SUBMISSION FAILED!</font>";
      
      
  echo "<br><br><input type='submit' class='button' value='Go Back To Submission Page'>";
	//echo "</center>";
	echo "</form>";
  echo "<br><br><hr>";
	
 /*
	Echo "
		<center>
		<div id='footer'>
        <hr>
            <table>
                <tr>
                    <td><img src='sykes.jpg' alt='Adnu Footer' width='90' height='40'></td>
                    <td><img src='smart.jpg' alt='Adnu Footer' width='90' height='40'></td>
                    <td><img src='c&e.jpg' alt='Adnu Footer' width='90' height='40'></td>
                    <td><img src='PSITE.png' alt='Adnu Footer' width='90' height='40'></td>
                    <td><img src='coke.jpeg' alt='Adnu Footer' width='90' height='40'></td>
                    <td><img src='hodgepodge.jpg' alt='Adnu Footer' width='90' height='40'></td>
                </tr>
            </table>
            <font size='1' face='Verdana'>made with love by <br> Neithan Casano <font color='gray' size='2'>|</font> Raphael Garay <font color='gray' size'2'>|</font> Copyright 2013 <br></font>
        </div>
	
	";
  */
?>
