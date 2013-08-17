<?php

//	Connect
require("config.inc.php");

//if posted data is not empty
if (!empty($_POST)) {
    //If not all values are set
    if (empty($_POST['password']) || empty($_POST['email'])) {
		$msg = "Please Enter values to all fields.";
		
		if (!empty($_POST['password']) || !empty($_POST['email'])) {
			$msg = "Please Enter values to all fields. (got some info).";
		}		
		
	    // Create some data that will be the JSON response		
	    $response["success"] = 0;
	    $response["message"] = $msg;

        die(json_encode($response));
    }
    
	// Check for same id user
    $query        = " SELECT 1 FROM users WHERE Email = :email";
    //now lets update what :user should be
    $query_params = array(
        ':email' => $_POST['email']
    );
    
    try {
        $stmt   = $db->prepare($query);
        $result = $stmt->execute($query_params);
    }
    catch (PDOException $ex) {
       	$response["success"] = 0;
		$response["message"] = $ex->getMessage();
		die(json_encode($response));
    }
    
	// try to find the user
    $row = $stmt->fetch();
    if (!$row) {        
		$response["success"] = 0;
		$response["message"] = "I'm sorry, No user found with entered email";
		die(json_encode($response));
    }
    	
    $query = "SELECT * FROM users WHERE Email = :email AND Password = :pass";
    
    //Again, we need to update our tokens with the actual data:
    $query_params = array(
		':pass' => $_POST['password'],
		':email' => $_POST['email']	
    );
    
    //time to run our query,
	$result = "";
    try {
		
        $stmt   = $db->prepare($query);
        $result = $stmt->execute($query_params);
				
		if ($data = $stmt->fetch()) {
        do {				
				$response["success"] = 1;
				$response["message"] = json_encode($data);
				die(json_encode($response));
			} 
			while ($data = $stmt->fetch());
		} 
		else {
			$response["success"] = 0;
			$response["message"] = "I'm sorry, Password is wrong";
			die(json_encode($response));
		}		
    }
    catch (PDOException $ex) {
		$response["success"] = 0;
		$response["message"] = "Database Error. Please Try Again!";
		die(json_encode($response));
    }
	
} else {
?>
	<h1>Register</h1> 
	<form action="getUserByEMailAndPassword.php" method="post"> 
		
	    Password:<br /> 
	    <input type="password" name="password" value="" /> 
	    <br /><br /> 
		Email:<br /> 
	    <input type="text" name="email" value="" /> 
	    <br /><br />
				
	    <input type="submit" value="Log User" /> 		
	</form>
	<?php
}
?>
