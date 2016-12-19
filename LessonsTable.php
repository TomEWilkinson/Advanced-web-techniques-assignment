<?php 
	require_once 'login.php';
	require_once 'sanitize.php';

	$dbserver = mysql_connect($dbhost, $dbuser, $dbpass); 

	if(!$dbserver)  
	{ 
	    // if the connection failed, say why: 
	    die("MySQL connection failed: " . mysql_error()); 
	} 

	// the connection succeeded, now let's try and select our database: 
	$selection = mysql_select_db($dbname, $dbserver); 

	if(!$selection)  
	{ 
	    // if the selection failed, say why: 
	    die("MySQL selection failed: " . mysql_error()); 
	} 

	$lesson_query = "SELECT * FROM lessons";

	$lesson_result = mysql_query($lesson_query); 
	
	$lesson_return_arr = array();

	if (mysql_num_rows($lesson_result)) {

		while ($row = mysql_fetch_array($lesson_result, MYSQL_ASSOC)) {
			$row_array['lesson'] = $row['lesson_name'];
			$row_array['lesson_location_lon'] = $row['lesson_location_lon'];
			$row_array['lesson_location_lat'] = $row['lesson_location_lat'];
			


			array_push($lesson_return_arr,$row_array);
		}

	}

	$output = json_encode($lesson_return_arr);

	echo $output;

 ?>