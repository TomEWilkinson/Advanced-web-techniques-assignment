<?php 
	require_once 'login.php'; 
	
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

	// the selection succeeded, now let's try querying a table: 
	$class_record_query = "SELECT * FROM class_record "; 

	if(isset($_POST['student_id'])) {
		$student_id = $_POST['student_id'];
		$class_record_query = $class_record_query . "where student_id=" . $student_id;
	}
	
	$class_record_result = mysql_query($class_record_query);

	$lesson_query = "SELECT * FROM sessions"; 

	if(isset($_POST['start_date']) && isset($_POST['end_date']))
	{
		$start_date = $_POST['start_date'];
		$end_date = $_POST['end_date']; 
		$lesson_query = $lesson_query  . " where start_time between '" .  $start_date . "' and '" .  $end_date . "'"; 
	}

	$lesson_result = mysql_query($lesson_query); 
	
	$lesson_return_arr = array();
	$class_record_return_arr = array();

	if (mysql_num_rows($class_record_result)) {

		while ($row = mysql_fetch_array($lesson_result, MYSQL_ASSOC)) {
			$lesson_return_arr[$row['session_id']]['lesson_name'] = $row['lesson_name'];
			$lesson_return_arr[$row['session_id']]['start_time'] = $row['start_time'];
			$lesson_return_arr[$row['session_id']]['free_spaces'] = $row['free_spaces'];
		}



		while ($row = mysql_fetch_array($class_record_result, MYSQL_ASSOC)) {
			if(isset($lesson_return_arr[$row['session_id']])) {
			    $row_array['lesson'] = $lesson_return_arr[$row['session_id']]['lesson_name'];
			    $row_array['start_time'] = strtotime($lesson_return_arr[$row['session_id']]['start_time']);
			    $row_array['free_spaces'] = $lesson_return_arr[$row['session_id']]['free_spaces'];
			    $row_array['session_id'] = $row['session_id'];

			   	array_push($class_record_return_arr,$row_array);
			}
		}
	}

	$output = json_encode($class_record_return_arr);

	echo $output;

 ?>
