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

	$class_record_query = "SELECT * FROM class_record";

	if (isset($_POST['student_id']))
	{
		$student_id = sanitizeMySQL($_POST['student_id']);
		$class_record_query = $class_record_query . " where student_id='$student_id'";
	}

	$class_record_return_arr = array();

	$class_record_result = mysql_query($class_record_query);

	if (mysql_num_rows($class_record_result)) {
		while ($row = mysql_fetch_array($class_record_result, MYSQL_ASSOC)) {
			$class_record_return_arr[] = $row['session_id'];
		} 
	}

	$lessons_query = "SELECT * FROM lessons";

	$lessons_return_arr = array();

	$lessons_result = mysql_query($lessons_query);

	while ($row = mysql_fetch_array($lessons_result, MYSQL_ASSOC)) {
		$lessons_return_arr[$row['lesson_name']] = $row['lesson_Building'];
	} 


    $sessions_query = "SELECT * FROM sessions where session_id in(";


	foreach ($class_record_return_arr as $value) {
		$sessions_query = $sessions_query  . $value . ",";
	}
	$sessions_query  = rtrim($sessions_query, ',');
	$sessions_query = $sessions_query .  ")";

	$sessions_result = mysql_query($sessions_query); 
	
	$map_return_arr = array();

	if (mysql_num_rows($sessions_result)) {

		while ($row = mysql_fetch_array($sessions_result, MYSQL_ASSOC)) {
			$map_return_arr[$row['lesson_name']][$row['start_time']] = $row['room_number'];
			$map_return_arr[$row['lesson_name']]['building_name'] = $lessons_return_arr[$row['lesson_name']];

		}

	}

	$output = json_encode($map_return_arr);

	echo $output;

 ?>