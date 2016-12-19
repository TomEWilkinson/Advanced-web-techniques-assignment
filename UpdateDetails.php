<?php 
	require_once 'login.php';
	require_once 'sanitize.php'; 

	$email_pattern = '/\w+@\w+\.\w+|\w.+@\w+\.\w+\.\w+/';

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
	
	$user_id = sanitizeMySQL($_POST['user_id']);
	$password = sanitizeMySQL($_POST['password']);
	$oldPassword = sanitizeMySQL($_POST['oldPassword']);
	$email = sanitizeMySQL($_POST['email']);
	$firstname = sanitizeMySQL($_POST['firstName']);
	$surname = sanitizeMySQL($_POST['surname']);
	$phone = sanitizeMySQL($_POST['phone']);

	if(empty($_POST['user_id']))
	{
		$msg = $msg . "User ID not found <br>";	
	}
	else {
		$password_check_query = "SELECT * FROM users where user_id = '$user_id'";
		$student_password = "";           

		$password_check = mysql_query($password_check_query);

		while ($row = mysql_fetch_array($password_check, MYSQL_ASSOC)) {
			$student_password = $row['password'];	
		}
		if ($oldPassword != $student_password)
		{
			$msg = $msg . "Previous Password does not match <br>";	
		}

	}

	if(empty($password))
	{
		$msg = $msg . "password not found <br>";	
	}
	else if(!preg_match("/[a-z]/", $password) || !preg_match("/[A-Z]/", $password) || !preg_match("/[0-9]/", $password) || !preg_match("/_|[^\w]/", $password) || strlen($password) < 6)
	{
		$msg = $msg . "password contain at least one lower case and upper case letter, at least one digit, at least one non alphanumeric character and have more than 6 charcters<br>";
	}

	if(empty($email))
	{
		$msg = $msg . "email not found <br>";	
	}
	else if (!preg_match($email_pattern, $email)) 
	{
		$msg = $msg . "Invalid email entered <br>";	
	}
	else {
		$email_check_query = "SELECT * FROM users where email = '$email'";
		$student_password = "";           

		$password_check = mysql_query($email_check_query);

		if(mysql_num_rows($password_check) > 0)
		{
			$msg = $msg . "email address already in database<br>";
		}
	}

	if(empty($firstname))
	{
		$msg = $msg . "firstname not found <br>";	
	}
	else if (!ctype_alpha($firstname)) 
	{
		$msg = $msg . "firstname can only contain letters <br>";
	}

	if(empty($surname))
	{
		$msg = $msg . "Surname not found <br>";	
	}
	else if (!ctype_alpha($surname)) 
	{
		$msg = $msg . "surname can only contain letters <br>";
	}


	if(empty($phone))
	{
		$msg = $msg . "Phone nunber not found <br>";	
	}
	else if(!preg_match("/\d+/", $phone) ||  strlen($phone) < 11)
	{
		$msg = $msg . "Phone nunber not valid <br>";	
	}

	if($msg == "")
	{ 
		$update_details_query = "UPDATE users SET  password='$password', email='$email', first_name='$firstname', second_name='$surname', phone='$phone' WHERE user_id='$user_id'";

		mysql_query($update_details_query);

		$msg = "Details update sucessfully";
	} 


	echo $msg;


 ?>