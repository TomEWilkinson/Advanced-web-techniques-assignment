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
	
	$staff_id = sanitizeMySQL($_POST['staff_id']);
	$start_date = sanitizeMySQL($_POST['start_date']);
	$end_date = sanitizeMySQL($_POST['end_date']);

	// the selction succeeded, now let's try querying a table: 
	$class_record_query = "SELECT * FROM class_record"; 
	$class_record_result = mysql_query($class_record_query); 

	$session_query = "SELECT * FROM sessions where staff_id=" . $staff_id . " and start_time between '" .  $start_date . "' and '" .  $end_date . "' order by start_time ASC";
	
	$session_result = mysql_query($session_query); 
	
	$session_return_arr = array();

 	if (mysql_num_rows($session_result)) {

		while ($row = mysql_fetch_array($session_result, MYSQL_ASSOC)) {
			$session_return_arr[$row['session_id']]['lesson_name'] = $row['lesson_name'];
			$session_return_arr[$row['session_id']]['start_time'] = strtotime($row['start_time']);
			$session_return_arr[$row['session_id']]['free_spaces'] = $row['free_spaces'];
			$session_return_arr[$row['session_id']]['session_id'] = $row['session_id'];
			$session_return_arr[$row['session_id']]['students'] = " ";
			
		}

		while ($row = mysql_fetch_array($class_record_result, MYSQL_ASSOC)) {
			if(isset($session_return_arr[$row['session_id']]))
			{
		    	$session_return_arr[$row['session_id']]['students'] = $session_return_arr[$row['session_id']]['students'] . " " . $row['student_id'];
			}

		}

	}

	$output = json_encode($session_return_arr);

	echo $output;

 ?>