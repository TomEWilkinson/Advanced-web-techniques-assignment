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

	if(isset($_POST['student_id']))
	{
		$student_id = sanitizeMySQL($_POST['student_id']);
		$class_record_query = $class_record_query . " where student_id=" . $student_id;
	}

	$lesson_query = "SELECT * FROM sessions";
	$student_query = "SELECT * FROM users where is_staff = '0'";

	$class_record_result = mysql_query($class_record_query);
	$student_result = mysql_query($student_query);
	$lesson_result = mysql_query($lesson_query); 

	$lesson_names = array();
	$student_names = array();
	$student_images = array();

	while ($row = mysql_fetch_array($lesson_result, MYSQL_ASSOC)) { 
		$lesson_names[$row['session_id']] = $row['lesson_name'];
	} 
	while ($row = mysql_fetch_array($student_result, MYSQL_ASSOC)) { 
		$student_names[$row['user_id']] = $row['first_name'] . " " . $row['second_name'];
		$student_images[$row['user_id']] = $row['student_image'];
	} 

	$attendance = array();

	$row_array = array();

	while ($row = mysql_fetch_array($class_record_result, MYSQL_ASSOC)) {
		$row_array['lesson'] = $lesson_names[$row['session_id']];
		$row_array['session_id'] = $row['session_id'];
		$row_array['student_name'] = $student_names[$row['student_id']];
		$row_array['student_id'] = $row['student_id'];
		$row_array['attendance'] = $row['attendance'];
		$row_array['image'] = $student_images[$row['student_id']];

		array_push($attendance,$row_array);
	}

	usort($attendance, function($a, $b) {
    	return  $b['student_name'] - $a['student_name'];
	});


	$output = json_encode($attendance);

	echo $output;
 ?>