<?php

  //get configuration variables
  $singularity = file("../config.html");
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
 
  //problem header
  $p_header = "- Blue Pill Red Pill";

/************************************************************************/
// test area
/************************************************************************/

	//timed refresh
	//Echo "<meta http-equiv='refresh' content='4'>"; 

  //external style sheet
	echo "<head> 
              <link rel='stylesheet' href='../scoreboard.css' type='text/css'>	
			</head>";

	//header for Standings page
  //$header = "In Preparation for Finals (Part II) Scoreboard";
  //$subheader = "MTHS024 N1 3:00PM - 4:30PM";
  //$section = "N1";
	Echo "<br><font size='6'> " . $n_header . " Problem " . $p_header . " </font> <img id='seal' src='../sealg.png' alt='Adnu Seal' width='60' height='60' align='left'><br>
  <font face='Verdana' size='1'>| " . $n_subjname . " " . $n_section . "<br>| " . $n_subheader . "</font> <br><hr>";

  //query player list
	$display_team_ranking = mysql_query("select * from players, slates where section='" . $n_section . "' and slateID=id order by score desc");
		
   
  //query number of problems
  $display_probs = mysql_query("select * from problems where sec='" . $n_section . "'");
  //count number of problems
  $count_probs = mysql_num_rows(mysql_query("select * from problems where sec='" . $n_section . "'"));
               //echo $count_probs;
               //echo ord('a');
               //echo chr(1+96);
  
  //header for last ten minutes
	//echo "<center><font color='red' size=7>Please include R Command used for Problem B</font></center><br><br>";

  echo "<body id=linearBg2>";

  $question = "<p>Ino, your younger brother, noticed that <a href='http://dcs.adnu.edu.ph/~neithan/pfedpsprobd.ods' style='color:#880000'>this spreadsheet document</a> has differently colored cells. <br /></p>
<p> Since at elementary school they're being taught how to add and multiply, Ino got curious about what could be the possible output if he would <br /></p>
<p>(1) get the sum of the blue colored cells and <br /></p>
<p>(2) get the product of the red colored cells.</p>
<p>Being the good brother/sister that you are, you decided to help him. <br /></p>
<p>Important! Ino can't understand scientific notation yet. Be sure to convert your product, if it gets too big, to a number readable by a five year old. :) </p> ";

  //begin table
	echo "<center>";
	echo "<table border=1 cellpadding=7 cellspacing=1 width=90%>";
       echo "<tr>";
            echo "<td>";
                 echo $question;
            echo "</td>";
       echo "</tr>";
	//end table
	echo "</table>";
	echo "</center>";


	
	Echo "
		<center>
		<div id='footer'>
        <hr>
        <!--
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
         -->   
            <font size='1' face='Verdana'>made with love <br> Neithan Casano | Raphael Garay | (c) 2013 <br></font>
        </div>
	
	";

  echo "</body>";

?>
 
