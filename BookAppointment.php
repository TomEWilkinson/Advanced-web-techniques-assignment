<?php 
	require_once 'login.php';
	require_once 'sanitize.php'; 

	$msg = "";

	
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
	if(isset($_POST['student_id']) && isset($_POST['session_id']))
	{

		$student_id =  sanitizeMySQL($_POST['student_id']);
		$session_id =  sanitizeMySQL($_POST['session_id']);

		$appointment_query = "SELECT * FROM class_record where student_id='$student_id' and session_id='$session_id'"; 
		$appointment_check_query = "SELECT * FROM sessions WHERE session_id='$session_id'";
		$insert_appointment_query = "INSERT INTO class_record (student_id, session_id) VALUES('$student_id', '$session_id')"; 
		$update_free_spaces_query = "UPDATE sessions SET free_spaces = free_spaces - 1 WHERE session_id='$session_id'";

		$appointment_result = mysql_query($appointment_query); 
		$appointment_check_result  = mysql_query($appointment_check_query);

		while ($row = mysql_fetch_array($appointment_check_result, MYSQL_ASSOC)) {
			$lesson_name = $row['lesson_name'];
			$free_spaces = $row['free_spaces'];
		}
		if($free_spaces != 0) {

			$lesson_names = array();
			
			$lesson_check_query = "SELECT * FROM sessions";
			$class_record_check_query = "SELECT * FROM class_record where student_id='$student_id'";


			$lesson_check_result = mysql_query($lesson_check_query);
			$class_record_check_result = mysql_query($class_record_check_query);

			while ($row = mysql_fetch_array($lesson_check_result, MYSQL_ASSOC)) { 
				$lesson_names[$row['session_id']] = $row['lesson_name'];
			}
			if (mysql_num_rows($appointment_result) && $msg == "") {
				$msg = "Lesson already booked";
			} 

			if($msg == "")
			{
				while ($row = mysql_fetch_array($class_record_check_result, MYSQL_ASSOC)) { 
					if($lesson_names[$row['session_id']] == $lesson_names[$session_id]) {

						$msg =  "you've already booked a appointment for this week";

					}
				}
			}
			if($msg == ""){
				mysql_query($insert_appointment_query); 
				mysql_query($update_free_spaces_query); 
				$msg = "lesson added";
			}
		}
		else {
			$msg =  "lesson is full apologies";
		}
	}	

	echo $msg

 ?>