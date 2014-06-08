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
// test area
/************************************************************************/

	//timed refresh
	Echo "<meta http-equiv='refresh' content='40'>"; 

  //external style sheet
	echo "<head> 
              <link rel='stylesheet' href='scoreboard.css' type='text/css'>	
			</head>";

	//header for Standings page
  //$header = "In Preparation for Finals (Part II) Scoreboard";
  //$subheader = "MTHS024 N1 3:00PM - 4:30PM";
  //$section = "N1";
	Echo "<br><br><font size='4' face='Verdana'> &nbsp;" . $n_header . " Scoreboard </font> <img class='labelbutton' id='seal' src='resources/sealg.png' alt='Adnu Seal' width='35' height='35' align='left'><br>
  <font face='Verdana' size='1'>&nbsp; " . $n_subjname . " " . $n_section . "<br>&nbsp; " . $n_subheader . "</font> <br><br><!-- <hr> -->";

//echo "<center><iframe src='http://free.timeanddate.com/countdown/i42yhino/n145/cf100/cm0/cu4/ct0/cs0/ca0/cr0/ss0/cac000/cpc000/pcfff/tc66c/fs100/szw320/szh135/tatTime%20left%20to%20Event%20in/tac000/tptTime%20since%20Event%20started%20in/tpc000/mac000/mpc000/iso2014-03-26T21:00:00/pd2' frameborder='0' width='320' height='135'></iframe></center>";

  //Echo "<center><font color='red'> Hello Jana, Jen, and Ping!<br> We'll begin in 15 minutes <br> let's use the chatbox below to communicate -N</font></center>";


  //query player list with slates
	$display_team_ranking = mysql_query("select * from players, slates where section='" . $n_section . "' and slateID=id order by score desc, time asc");
   
  //query number of problems
  $display_probs = mysql_query("select * from problems where sec='" . $n_section . "' order by id");
  //count number of problems
  $count_probs = mysql_num_rows(mysql_query("select * from problems where sec='" . $n_section . "'"));
               //echo $count_probs;
               //echo ord('a');
               //echo chr(1+96);
  
  //header for last ten minutes
	//echo "<center><font color='red' size=3>Competition Starts at exactly 07:00PM and ends at exactly 09:00PM<br>You may use the visitor's Chatbox located below for clarifications regarding the problems given.<br>Tell your friends to support you.<br>Detailed instructions found in the MOODLE Site (i.e. usernames, passwords, ranking etc.)</font></center>";
 

  echo "<body id=linearBg2>";

  //begin table
	echo "<center>";
	echo "<table border=1 cellpadding=7 cellspacing=1 width=90% class='labelbuttontable'>";
	
	$i = 0; $j = 0; $p = 1;
	while ($p_display = mysql_fetch_array($display_team_ranking)){
		if($i == 0) {
			echo "<tr>";			
				echo "	<td><font size='2'>ID</font></td>
							<td><font size='1'><strong>TEAM NAME</strong><br/>Members</font> </td>";

        while($p_probs = mysql_fetch_array($display_probs)){
          echo "<td bgcolor=#fefefe ><font size=1><strong>Problem " . strtoupper(chr($p+96)) . "</strong><br/>" . $p_probs['name'] . "</font></td>";
          $p++;
        }

          /*
          while code above attempts to display the problem labels coming from the problems table in the database

							<td bgcolor=#FFFFDD><font size='1'>problem A <br> Crystal Shakers</font></td>
							<td><font size='1'>problem B <br> Golden Trees </font></td>
							<td><font size='1'>problem C <br> The Travelling Salesman</font></td>
							<td><font size='1'>problem D <br> Couple Rituals</font></td>
							<td><font size='1'>problem E <br> Andrew and the Meatballs</font></td>
							<td><font size='1'>problem F <br> Healthy Hugs</font></td>
							<td><font size='1'>problem G <br> Amaterasu </font></td>
           */
						
			echo "</tr>";
		}		
		
    //bgcolor=#efefFF
   
		echo "<tr>" .
					"<td>" . 
						$p_display['id'] . 
					"</td>" . 
					"<td bgcolor=#ececec class='labelbuttontable'><font size=1><strong>" . 
						$p_display['name'] . "</strong></font><br>" . $p_display['nickname'] . 
					"</td>";
        
        $j = 1;      
        while($j <= $count_probs){
                 //dark green color
          // get the minimum time of each column
             // echo "select min(p" . chr($j + 96) . "t) from slates<br>" ;
             // $getMinimumTime = "select min(p" . chr($j + 96) . "t) from slates";
             $getMinimumTime = mysql_query("select min(p" . chr($j + 96) . "t) as colmin from slates, players where section='" . $n_section . "' and slateID=id");
             $p_minimumTime = mysql_fetch_array($getMinimumTime);
             //echo $p_minimumTime['colmin'] . "<br>";
             //'bgcolor=#bbFFbb' <- normal AC
        
					echo "<td table-layout='fixed' align='center' " . 
               ($p_display['p' . chr($j + 96). 's'] == 'Y' ? ($p_display['p' . chr($j + 96). 't'] == $p_minimumTime['colmin'] && $p_minimumTime['colmin'] < 90000 ? 'bgcolor=#44dd44' : 'bgcolor=#bbFFbb') :
                               ($p_display['p' . chr($j + 96) . 'a'] > 0 ? 'bgcolor=#FFaaaa' : 'bgcolor=transparent') ) . ">" . "<font color=#111>" .
                               
						   ($p_display['p' . chr($j + 96) . 's'] == 'Y' ? '&#10004' : 
                               ($p_display['p' . chr($j + 96) . 'a'] > 0 ? '&#10008' : '&#9749') ) . " / " . $p_display['p' . chr($j + 96) . 'a'] . "</font>" . "<br><font color=#333 size=1>" . 
               
               ($p_display['p' . chr($j + 96) . 't'] > 90000 ? "" :
                               ($p_display['p' . chr($j + 96) . 's'] == 'Y' ? $p_display['p' . chr($j + 96) . 't'] . " mins" : "" )).    //print time in minutes                  
					"</font></td>";
          $j++;
        }
              
          /*               

                 while code above attempts to display the records of players per problem if pas(solved) or paa (just attempted) and coffeeplease.,,.XD
                    
					"<td " . ($p_display['pas'] == 'Y' ? 'bgcolor=#88FF88' : ($p_display['paa'] > 0 ? 'bgcolor=#FF8888' : 'bgcolor=#FFFFFF') ) . ">" . 
						($p_display['pas'] == 'Y' ? '&#10004' : ($p_display['paa'] > 0 ? '&#10008' : '&#9749') ) . " / " . $p_display['paa'] .
					"</td>" . 
					"<td>" . 
						$p_display['pbs'] . " / " . $p_display['pba'] .
					"</td>" . 
					"<td>" . 
						$p_display['pcs'] . " / " . $p_display['pca'] .
					"</td>" . 
					"<td>" . 
						$p_display['pds'] . " / " . $p_display['pda'] .
					"</td>" . 
					"<td>" . 
						$p_display['pes'] . " / " . $p_display['pea'] .
					"</td>" . 
					"<td>" . 
						$p_display['pfs'] . " / " . $p_display['pfa'] .
					"</td>" . 
					"<td>" . 
						$p_display['pgs'] . " / " . $p_display['pga'] .
					"</td>" . 
         */
				
				echo "</tr>";
				
		$i++;	
	}
	
	//end table
	echo "</table>"; 
	echo "</center>";

  //spectator chatbox
  
 echo"<center>
<iframe align='center' width='90%' height='60%' src='http://chatroll.com/embed/chat/final-examination-spectator-chatbox?id=ayt0JWK2oaV&platform=php<?= $ssoParams ?>&w=$0' frameborder='0' scrolling='no' marginheight='0' marginwidth='0' allowtransparency='true'></iframe>
<div style='font-size:0.9em;text-align:center;'></div>";



// Chatroll Single Sign-On (SSO) Parameters
//$uid = 1;                   // Current user id
//$uname = 'test';            // Current user name
//$ulink = 'http://example.com/profile/test';   // Current user profile URL (leave blank for none)
//$upic = '';                 // Current user profile picture URL (leave blank for none)
///$ismod = 0;                 // Is current user a moderator?
//$sig = md5($uid . $uname . $ismod . 'chq7wd51pbm7vkl7');
//$ssoParams = '&uid=' . $uid . "&uname=" . urlencode($uname) . "&ulink=" . urlencode($ulink) . "&upic=" . urlencode($upic) . "&ismod=" . $ismod . "&sig=" . $sig;


	
	Echo "
		<center>
		<div id='footer'>
        <!-- <hr> -->
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
            <font size='1' face='Verdana'>XIPHIAS v0.2: A Competitive Quiz Control System <br>(c) Department of Computer Science 2013 <br></font>
        </div>
	
	";

  echo "</body>";

?>
