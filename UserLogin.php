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

	$query = "SELECT * FROM users";

	$sql_where;

	if (isset($_POST['email']))
	{
		$sql_where[] = "email = '" . sanitizeMySQL($_POST['email']) . "'";
	} 

	if (isset($_POST['password']))
	{
		$sql_where[] = "password = '" . sanitizeMySQL($_POST['password']) . "'";
	} 

	if (isset($_POST['user_id']))
	{
		$sql_where[] = "user_id = '" . sanitizeMySQL($_POST['user_id']) . "'";
	}

	$first = 1;

	foreach ($sql_where as $value) {
		if($first == 1)
		{
			$query = $query . " where " . $value;
		}
		else {
			$query = $query . " and " . $value;
		}
		$first++;
	}

	//$query = "SELECT * FROM users where email=\"" . $email . "\" and password= \"" . $password . "\""
	$result = mysql_query($query); 

	$return_arr = array();

	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
	    $row_array['user_id'] = $row['user_id'];
	    $row_array['first_name'] = $row['first_name'];
	    $row_array['second_name'] = $row['second_name'];
	    $row_array['email'] = $row['email'];
	    $row_array['phone'] = $row['phone'];
	    $row_array['is_staff'] = $row['is_staff'];

	    array_push($return_arr,$row_array);
	}

	$output = json_encode($return_arr);

	echo $output;

 ?>