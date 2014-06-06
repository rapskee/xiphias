<?php

	//connect to database
	$con = mysql_connect("localhost","neithan","neithan");
	if (!$con)
	  {
	  die('Could not connect: ' . mysql_error());
	  }
	
	mysql_select_db("neithanST", $con);

  echo "It works fine!";
  
  mysql_query("update players set name='Ginny - 2' where id=488") or die("query failed");

?>