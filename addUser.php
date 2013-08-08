<?php

require("config.inc.php");

//if posted data is not empty
if (!empty($_POST)) {
    //If not all values are set
    if (empty($_POST['id']) || empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])|| empty($_POST['education']) || empty($_POST['newage']) || empty($_POST['health']) || empty($_POST['sport'])) {
			
	    // Create some data that will be the JSON response 
	    $response["success"] = 0;
	    $response["message"] = "Please Enter values to all fields.";

        die(json_encode($response));
    }
    
	// Check for same id user
    $query        = " SELECT 1 FROM users WHERE Id = :id";
    //now lets update what :user should be
    $query_params = array(
        ':id' => $_POST['id']
    );
    
    try {
        $stmt   = $db->prepare($query);
        $result = $stmt->execute($query_params);
    }
    catch (PDOException $ex) {
        die("Failed to run query: " . $ex->getMessage());

		$response["success"] = 0;
		$response["message"] = $ex->getMessage();
		die(json_encode($response));
    }
    
    //fetch is an array of returned data.  If any data is returned,
    //we know that the id is already in use, so we murder our
    //page
    $row = $stmt->fetch();
    if ($row) {
        die("This id is already in use");
		//You could comment out the above die and use this one:
		$response["success"] = 0;
		$response["message"] = "I'm sorry, this id is already in use";
		die(json_encode($response));
    }
    	
    $query = "INSERT INTO users (Id, Name, Email, Password, IntrestEducation, IntrestNewAge, IntrestSport, IntrestHealth) 
				VALUES ( :id, :name, :mail, :pass, :edu, :newage, :sport, :health ) ";
    
    //Again, we need to update our tokens with the actual data:
    $query_params = array(
        ':id' => $_POST['id'],
        ':name' => $_POST['username'],
		':mail' => $_POST['password'],
		':pass' => $_POST['email'],
		':edu' => $_POST['education'],
		':newage' => $_POST['newage'],
		':sport' => $_POST['sport'],
		':health' => $_POST['health']		
    );
    
    //time to run our query, and create the user
    try {
        $stmt   = $db->prepare($query);
        $result = $stmt->execute($query_params);
    }
    catch (PDOException $ex) {
        // Again, don't display $ex->getMessage() when you go live. 
        die("Failed to run query: " . $ex->getMessage());
		//You could comment out the above die and use this one:
		$response["success"] = 0;
		$response["message"] = "Database Error. Please Try Again!";
		die(json_encode($response));
    }

	//If we have made it this far without dying, we have successfully added
	//a new user to our database.  We could do a few things here, such as 
	//redirect to the login page.  Instead we are going to echo out some
	//json data that will be read by the Android application, which will login
	//the user (or redirect to a different activity, I'm not sure yet..)
	$response["success"] = 1;
	$response["message"] = "user Successfully Added!";
	echo json_encode($response);
	
	//for a php webservice you could do a simple redirect and die.
	//header("Location: login.php"); 
	//die("Redirecting to login.php");
    
    
} else {
?>
	<h1>Register</h1> 
	<form action="addUser.php" method="post"> 
		Id:<br /> 
	    <input type="text" name="id" value="" /> 
	    <br /><br />
	    Username:<br /> 
	    <input type="text" name="username" value="" /> 
	    <br /><br /> 
	    Password:<br /> 
	    <input type="password" name="password" value="" /> 
	    <br /><br /> 
		Email:<br /> 
	    <input type="email" name="email" value="" /> 
	    <br /><br />
		Education:<br /> 
	    <input type="number" name="education" value="" /> 
	    <br /><br />
		New Age:<br /> 
	    <input type="number" name="newage" value="" /> 
	    <br /><br />
		Sport:<br /> 
	    <input type="number" name="sport" value="" /> 
	    <br /><br />
		Health:<br /> 
	    <input type="number" name="health" value="" /> 
	    <br /><br />		
	    <input type="submit" value="Register New User" /> 		
	</form>
	<?php
}
?>
