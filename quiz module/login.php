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
// test area
/************************************************************************/

	//timed refresh
	//Echo "<meta http-equiv='refresh' content='4'>"; 

  //external style sheet
	echo "<head> 
              <link rel='stylesheet' href='scoreboard.css' type='text/css'>	
			</head>";

	//header for Standings page
  //$header = "In Preparation for Finals (Part II) Scoreboard";
  //$subheader = "MTHS024 N1 3:00PM - 4:30PM";
  //$section = "N1";
  /*
	Echo "<br><font size='6'> " . $n_header . " Login Page </font> <img id='seal' src='sealg.png' alt='Adnu Seal' width='60' height='60' align='left'><br>
  <font face='Verdana' size='1'>| " . $n_subjname . " " . $n_section . "<br>| " . $n_subheader . "</font> <br><hr>";
  */
  
  echo "<br><br><br><br><center><br><img src='resources/xiphiaslogo.png' height=100px width=100px class='labelbutton'><br></center>";


  echo "<body id=linearBg2>";

  //begin table
	echo "<center>";
  echo "<form action='submit.php' method='GET'>";
	echo "<table border=0 cellpadding=7 cellspacing=0 width=20%>";
	
    echo "<tr>";
         echo "<td>";
              echo "<font size=2>USERNAME:";
         echo "</td>";
         echo "<td>";
              echo "<input type='textbox' class='textbox' size=40 name='p_uname' value=''>";
         echo "</td>";
    echo "</tr>";
    echo "<tr>";
         echo "<td>";
              echo "<font size=2>PASSWORD:";
         echo "</td>";
         echo "<td>";
              echo "<input type='password' class='textbox' size=40 name='p_passwd' value=''>";
         echo "</td>";
    echo "</tr>"; 
 
	//end table
	echo "</table>";

  echo "<input type='submit' class='button' size=40 value='LOGIN'>";
  //end form
  echo "</form>";
  
 
	echo "</center>";
	
	Echo "
		<center>
		<div id='footer'>
      
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
            <font size='1' face='Verdana'><br> XIPHIAS v0.2: A Competitive Quiz Control System <br> (c) Department of Computer Science 2013 <br></font>
        </div>
	
	";

  echo "</body>";

  //destroy all existing sessions
  session_destroy();

?>
