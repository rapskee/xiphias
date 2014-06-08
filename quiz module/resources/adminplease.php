<?php

	//connect to database
	$con = mysql_connect("localhost","neithan","neithan");
	if (!$con)
	  {
	  die('Could not connect: ' . mysql_error());
	  }
	
	mysql_select_db("neithanST", $con);

/************************************************************************/

/************************************************************************/

	//timed refresh
	//Echo "<meta http-equiv='refresh' content='4'>"; 

	//header interface
	Echo "<br><head><font size='6'> MIDTERM Examination Standings </font> <img src='adnu.jpg' alt='Adnu Seal' width='35' height='35' align='left'></head><br><br><hr>";

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

	$display_team_ranking = mysql_query("select * from players order by score desc");

	echo "<form action='adminplease2.php' method='GET'>";
	echo "<center>";
	//begin table	
	echo "<table border=5 cellpadding=6 cellspacing=6 width=90%>";
	$i = 1;
	
	while ($p_display = mysql_fetch_array($display_team_ranking)){
		if($i == 1) {
			echo "<tr>";			
				echo "	<td><font size='3'>ID</font></td>
							<td><font size='3'>NICKNAME</font> </td>
							<td><font size='1'>problem A <br> Crystal Shakers ni Boss <br> </font></td>
							<td><font size='1'>problem B <br> Golden Trees <br> </font></td>
							<td><font size='1'>problem C <br> The Travelling Salesman</font></td>
							<td><font size='1'>problem D <br> Couple Rituals </font></td>
							<td><font size='1'>problem E <br> Andrew and the Meatballs <br>  </font></td>
							<td><font size='1'>problem F <br> Healthy Hugs <br></font></td>
							<td><font size='1'>problem G <br> Amaterasu <br>  </font></td>
						";
			echo "</tr>";
		}
		echo "<tr>" .
					"<td>" . 
						$p_display['id'] . 
					"</td>" . 
					"<td>" . 
						$p_display['nickname'] .
					"</td>" . 
					"<td>" . 
						"<input type='checkbox' name='a" . $p_display['id'] . "'> / <input type='checkbox' name='aattempt" . $p_display['id'] . "'>"  .
					"</td>" . 
					"<td>" . 
						"<input type='checkbox' name='b". $p_display['id'] ."'> / <input type='checkbox' name='battempt" . $p_display['id'] . "'>"  .
					"</td>" . 
					"<td>" . 
						"<input type='checkbox' name='c". $p_display['id'] ."'> / <input type='checkbox' name='cattempt" . $p_display['id'] . "'>"  .
					"</td>" . 
					"<td>" . 
						"<input type='checkbox' name='d". $p_display['id'] ."'> / <input type='checkbox' name='dattempt" . $p_display['id'] . "'>"  .
					"</td>" . 
					"<td>" . 
						"<input type='checkbox' name='e". $p_display['id'] ."'> / <input type='checkbox' name='eattempt" . $p_display['id'] . "'>"  .
					"</td>" . 
					"<td>" . 
						"<input type='checkbox' name='f". $p_display['id'] ."'> / <input type='checkbox' name='fattempt" . $p_display['id'] . "'>"  .
					"</td>" . 
					"<td>" . 
						"<input type='checkbox' name='g". $p_display['id'] ."'> / <input type='checkbox' name='gattempt" . $p_display['id'] . "'>"  .
					"</td>" . 
/*					
					"<td>" .
						$p_display['score'] . 
					"</td>" .
*/				
				"</tr>";	
		$i++;	
	}

	
	//end table
	echo "</table>";

	echo "<br><input type='submit' value='post score updates'>";
	
	echo "</center>";
	echo "</form>";
	
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
?>
