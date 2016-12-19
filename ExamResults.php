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

	$output = "";
	if(isset($_POST['lesson_name']))
	{
		$lesson_name = sanitizeMySQL($_POST['lesson_name']);

		$marks_query = "SELECT * FROM marks ";

		if($lesson_name != "all")
		{
			$marks_query = $marks_query . "where lesson_name='$lesson_name'";
		}
		$marks_query = $marks_query . " order by student_id asc, mark asc";


		$student_query = "SELECT * FROM users where is_staff=0";

		$marks_result = mysql_query($marks_query); 
		$student_result = mysql_query($student_query); 
		
		$marks_return_arr = array();
		$student_return_arr = array();


		if (mysql_num_rows($student_result)) {

			while ($row = mysql_fetch_array($student_result, MYSQL_ASSOC)) {
				$student_return_arr[$row['user_id']] = $row['first_name'] . " " .  $row['second_name'];
			}
		}

		if (mysql_num_rows($marks_result)) {

			while ($row = mysql_fetch_array($marks_result, MYSQL_ASSOC)) {
				$row_array['student_id'] = $row['student_id'];
				$row_array['mark'] = $row['mark'];
				$row_array['student_name'] = $student_return_arr[$row['student_id']];
				$row_array['lesson_name'] = $row['lesson_name'];


				array_push($marks_return_arr,$row_array);
			}

		}

		$output = json_encode($marks_return_arr);

	}

	else if (isset($_POST['update_array'])) {
		$update_marks = json_decode(stripslashes($_POST['update_array']));

		foreach($update_marks as $row){
			$marks_Update_query = "UPDATE marks SET mark=" . $row->mark . " WHERE student_id=" . $row->student_id . " and lesson_name='" . $row->lesson_name . "'";
		    mysql_query($marks_Update_query);
  		}
  		$output = "marks updated successfully";
	}
	else if (isset($_POST['post_array'])) {
		$insert_marks =  json_decode(stripslashes($_POST['post_array']));
		foreach($insert_marks as $row){
			$insert_mark_query = "INSERT INTO marks (lesson_name, student_id, mark) VALUES ('" . $row->lesson_name . "', '" . $row->student_id . "', '" . $row->mark . "')";
			mysql_query($insert_mark_query);
		}
  		$output = "marks updated successfully";

	}

	else if (isset($_POST['student_first_name']) && isset($_POST['student_second_name']) && isset($_POST['mark']) && isset($_POST['lesson']))
	{
		$second_name         = sanitizeMySQL($_POST['student_second_name']);
		$first_name          = sanitizeMySQL($_POST['student_first_name']);
		$mark                = sanitizeMySQL($_POST['mark']);
		$lesson              = sanitizeMySQL($_POST['lesson']);


		$student_query = "SELECT * FROM users where is_staff=0 and first_name='$first_name' and second_name='$second_name'";
		$result        = mysql_fetch_row(mysql_query($student_query));

		if(sizeof($result) > 1){
			$student_id = $result[0];
			$insert_mark_query = "INSERT INTO marks (lesson_name, student_id, mark) VALUES ('$lesson', '$student_id', '$mark')";
			$duplicate_check = "SELECT * FROM marks where lesson_name='$lesson' and student_id='$student_id'";

			$duplicate_check_result = mysql_fetch_row(mysql_query($duplicate_check));
			if (sizeof($duplicate_check_result) <= 1) {
			 	mysql_query($insert_mark_query);
				$output = "mark addded successfully";
			}
			else {
				$output = "Mark has already been added, use the table to edit";
			}
		}
		else {
			$output = "student not found";
		}
	}

	echo $output;

 ?>