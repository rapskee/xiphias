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
//TEST AREA
/*
echo ord('a') . "<br><br>";

$test = mysql_query("select * from submissions, problems");
while ($p_test = mysql_fetch_array($test)){

      echo $p_test['subID'] . " " . $p_test['probID'] . " " . $p_test['id'] . " " . $p_test['name'] . " " . $p_test['answer'] . " " . $p_test['solution'] . "<br/>";
      
}
*/
//TEST AREA
/************************************************************************/

	//timed refresh
	//Echo "<meta http-equiv='refresh' content='5'>"; 

  //external style sheet
	echo "<head> 
              <link rel='stylesheet' href='scoreboard.css' type='text/css'>	
			</head>";

	//header for Standings page
  //$header = "Final Examination (Part II) Teacher's Page";
  //$subheader = "MTHS024 N1 3:00PM - 4:30PM";
  //$section = "N1";
  
	Echo "<br><br><font size='4' face='Verdana'> &nbsp;" . $n_header . " Teacher's Page </font> <img class='labelbutton' id='seal' src='resources/sealg.png' alt='Adnu Seal' width='35' height='35' align='left'><br>
  <font face='Verdana' size='1'>&nbsp; " . $n_subjname . " " . $n_section . "<br>&nbsp; " . $n_subheader . "</font> <br><br><!-- <hr> -->";

//  Echo "Good Morning Boss Kong Mahal., :))) I love you! Sana ok ikaw dyan.,,. **akaaaaap* mawoooosh na po papunta sa bosss ko";

	echo "<head>
	
				<style type='text/CSS'>
			        html, body{
			                padding: 0px;
			                margin: 0px;
			        }
			
			        body {
			                padding-bottom: 70px;
			        }
			
			        #footer {
			                position: bottom;
			                bottom: 0;
			                width: 100%;
			                height: 50px;
			        }
			    </style>	
	
			</head>";

	$display_submissions = mysql_query("select subID, teamID, probID, name, answer, solution from submissions, problems where probName=name order by subID desc");

	echo "<form action='adminplease2.php' method='GET'>";
	echo "<center>";
	//begin table	
	echo "<table border=3 cellpadding=1 cellspacing=1 width=90% class='labelbuttontable'>";
	$i = 1;
	
	while ($p_display = mysql_fetch_array($display_submissions)){

		if($i == 1) {
			echo "<tr>";			
				echo "
							<td><font size='1'>submission ID</font> </td>
							<td><font size='1'>team ID </font></td>
							<td><font size='1'>Problem's ID for " . $n_section . "  </font></td>
							<td><font size='1'>Problem Name  </font></td>
							<td><font size='1'>Team's Answer </font></td>
							<td><font size='1'>Problem Setters Solution </font></td>
              <td><font size='1'>AC/!AC </font></td>
						";
			echo "</tr>";
		}

		echo "<tr>" .
					"<td font size='1'>" . 
						$p_display['subID'] . 
					"</td>" . 
					"<td font size='1'>" . 
						$p_display['teamID'] .
					"</td>" . 
					"<td font size='1'>" . 
						$p_display['probID']  .
					"</td>" . 
					"<td font size='1'>" . 
						$p_display['name']  .
					"</td>" . 					
					"<td font size='1'>" . 
						$p_display['answer']  .
					"</td>" . 					
					"<td font size='1'>" . 
						$p_display['solution']  .
					"</td>" . 					
					"<td font size='1'>" .
						"<input type='checkbox' name=" . $p_display['probID'] . $p_display['teamID'] . ">/<input type='checkbox' name=" . $p_display['probID'] . "attempt" . $p_display['teamID'] . ">"  . 
					"</td>" .
				
				"</tr>";	
		$i++;	
	}

	
	//end table
	echo "</table>";

	echo "<br><input type='submit' value='post score updates' class='labelbutton'>";
	
	echo "</center>";
	echo "</form>";

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
            </table> -->
            <font size='1' face='Verdana'><br> XIPHIAS v0.2: A Competitive Quiz Control System <br> (c) Department of Computer Science 2013 <br></font>
        </div>
	
	";

?>
