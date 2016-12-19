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

	$lesson_query = "SELECT * FROM sessions";

	if(isset($_POST['start_date']) && isset($_POST['end_date']))
	{
		$start_date = sanitizeMySQL($_POST['start_date']);
		$end_date = sanitizeMySQL($_POST['end_date']); 
		$lesson_query = $lesson_query  . " where start_time between '" .  $start_date . "' and '" .  $end_date . "'"; 
	}

	$lesson_result = mysql_query($lesson_query); 
	
	$lesson_return_arr = array();

	if (mysql_num_rows($lesson_result)) {

		while ($row = mysql_fetch_array($lesson_result, MYSQL_ASSOC)) {
			$row_array['lesson'] = $row['lesson_name'];
			$row_array['start_time'] =  strtotime($row['start_time']);
			$row_array['free_spaces'] = $row['free_spaces'];
			$row_array['session_id'] = $row['session_id'];

			array_push($lesson_return_arr,$row_array);
		}

	}

	$output = json_encode($lesson_return_arr);

	echo $output;

 ?>