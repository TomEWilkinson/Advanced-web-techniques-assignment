<?php 
	require_once 'login.php'; 

	$delete_lesson = $_POST['delete_lesson'];

	

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

	if($delete_lesson == 1)
	{
		$session_id = $_POST['session_id'];
		$update_lesson_query = "DELETE FROM sessions WHERE session_id='$session_id'";
	}
	else if(isset($_POST['session_id']))
	{
		$session_id = $_POST['session_id'];
		$lesson_time = $_POST['lesson_time'];

		$update_lesson_query ="UPDATE sessions SET start_time='$lesson_time' WHERE session_id='$session_id'";

	}
	else {

		$lesson_name      = $_POST['lesson_name'];
		$lesson_time      = $_POST['lesson_time'];
		$free_places      = $_POST['free_places'];
		$staff_first_name = $_POST['staff_first_name'];
		$staff_id         = $_POST['staff_id'];


		$update_lesson_query = "INSERT INTO sessions (lesson_name, staff_id, staff_first_name, start_time, free_spaces) 
										Values ('$lesson_name', '$staff_id', '$staff_first_name', '$lesson_time', '$free_places')";
	}

	$results = mysql_query($update_lesson_query);

	$msg = "Details update sucessfully";


	echo $msg;


 ?>