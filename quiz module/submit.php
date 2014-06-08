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

  if(!isset($_SESSION['currID'])){
    //get username and password
    $p_uname = $_GET['p_uname'];                                       
    $p_passwd = $_GET['p_passwd'];
    
    $loginAuth = mysql_query("select * from players where username='" . $p_uname . "' and password='" . $p_passwd . "'");
    
    while ($p_loginAuth = mysql_fetch_array($loginAuth)){
          $p_id = $p_loginAuth['id'];
          $p_names = $p_loginAuth['name'];
          $p_nicks = $p_loginAuth['nicknames'];
    }
    
    $_SESSION['currID'] = $p_id;
    $_SESSION['currNICKS'] = $p_nicks;
    $_SESSION['currNAMES'] = $p_names;
  }
/************************************************************************/
//TEST AREA

//echo $_SESSION['currID'];


//TEST AREA
/************************************************************************/

	//timed refresh
	//Echo "<meta http-equiv='refresh' content='4'>"; 

	//header interface
  //external style sheet
	echo "<head> 
              <link rel='stylesheet' href='scoreboard.css' type='text/css'>	
			</head>";

	//header for Standings page
  //$header = "Final Examination (Part II) Submission Page";
  //$subheader = "MTHS024 N1 3:00PM - 4:30PM";
  //$section = "N1";
	Echo "<br><br><font size='4' face='Verdana'> &nbsp;" . $n_header . " Submission Page </font> <img class='labelbutton' id='seal' src='resources/sealg.png' alt='Adnu Seal' width='35' height='35' align='left'><br>
  <font face='Verdana' size='1'>&nbsp; " . $n_subjname . " " . $n_section . "<br>&nbsp; " . $n_subheader . "</font> <br><br><!-- <hr> -->";

  //query player list
	$display_team_ranking = mysql_query("select * from players where section='" . $n_section . "' order by score desc");
		
   
  //query number of problems
  $display_probs = mysql_query("select * from problems where sec='" . $n_section . "' order by id");
  //count number of problems
  $count_probs = mysql_num_rows(mysql_query("select * from problems where sec='" . $n_section . "'"));
               //echo $count_probs;
               //echo ord('a');
               //echo chr(1+96);
              
	echo "<center>";               
 
  //logged in as
       if (isset($_SESSION['currID']))
          echo "<br><input type='button' class='labelbutton' value='TEAM " . $_SESSION['currID'] . " | " . $_SESSION['currNAMES'] . "'>";
       else
          echo "<br><input type='button' class='errbutton' value='Login Failed! | Incorrect Username and/or Password'><meta http-equiv='refresh' content='3 ; login.php'>";

  //begin form
	echo "<form action='submit2.php' method='GET'>";
           
       
       //echo "Team ID: <input type='text' name='team'> <br><br>";
       echo "<br>";
       /*
       echo               "PROBLEM A: Unwanted Disturbances <input type='radio' value='a' name='problem'> <br> 
                          PROBLEM B: Amaterasu <input type='radio' value='b' name='problem'>";
       */         

  //begin to display tables only if user auth returns valid
  if(isset($_SESSION['currID'])){
  //table to hold problems and text area for solutions
  echo "<table width='90%' height=40% class='labelbuttontable'>";
  echo "<tr>";
  
   echo "<td><img margins='100px' src='resources/Numbers-1-icon.png' width=16px height=16px> &nbsp;&nbsp; Select a problem...<br><br>";
       $i = 1;
       while ($p_dprobs = mysql_fetch_array($display_probs)){
             $probName = $p_dprobs['name'];
             $probFile = $p_dprobs['file'];
             
             echo "<input type='radio' class='button' value='" . chr($i+96) . ","  . $probName . "' name='problem'> - problem " . strtoupper(chr($i+96)) . " | <a target='_blank' href='problems/" . $probFile . ".pdf'>" . $probName . "</a>  <br/>";
             $i++;
       }
   echo "</td><td><img margins='100px' src='resources/Numbers-2-icon.png' width=16px height=16px> &nbsp;&nbsp; Provide a solution...<br><br>" ;
                          
       echo "<center><textarea name='solution' class='textbox' rows='10' cols='80'> </textarea></center>";
   echo "<br><img margins='100px' src='resources/Numbers-3-icon.png' width=16px height=16px> &nbsp;&nbsp; Submit your solution...<br><br>";
   echo "<center><input type='submit' class='button' value='Submit!'> <a href='login.php' style='text-decoration:none'><input type='button' class='buttontwo' value='Logout'></a></center><br></td>";
       
  echo "</tr>";     
  //end table
  echo "</table>";
  echo "<br>";
	//echo "</center>";
	echo "</form>";
 
  } //very important ending parenthesis for user auth display tables please
  
  echo "<br><hr>";
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
