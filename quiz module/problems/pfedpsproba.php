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
  $p_header = "- Totally Eugene";

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

  $question = "<p>Eugene's Manager gave Eugene (who is by the way your best friend) the task of computing for the total of all cell values from A1 - R105 in the <a href='http://dcs.adnu.edu.ph/~neithan/pfedpsproba.ods' style='color:#880000'>spreadsheet file given by Eugene's boss</a>.</p>
<p>You decide to help Eugene, because you're a kind person - - - and you're secretly in love with him/her.</p>
<p>Given this spreadsheet document, calculate for the total of all cells in yellow background color (A1 - R105). Submit your answer in the submission page. </p>  ";

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
 