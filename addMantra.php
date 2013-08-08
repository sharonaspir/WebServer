<?php

require("config.inc.php");

//if posted data is not empty
if (!empty($_POST)) {
    //If not all values are set
    if (empty($_POST['id']) || empty($_POST['mantraName']) || empty($_POST['desc']) || empty($_POST['sport'])|| empty($_POST['education']) || empty($_POST['newage'])|| empty($_POST['health']) || empty($_POST['date'])) {
			
	    // Create some data that will be the JSON response 
	    $response["success"] = 0;
	    $response["message"] = "Please Enter values to all fields.";

		//die will kill the page and not execute any code below, it will also
		//display the parameter... in this case the JSON data our Android
		//app will parse
        die(json_encode($response));
    }
    
    //if the page hasn't died, we will check with our database to see if there is
    //already a mantra with the mantraname specificed in the form.  ":mantra" is just
    //a blank variable that we will change before we execute the query.  We
    //do it this way to increase security, and defend against sql injections
    $query        = " SELECT 1 FROM mantras WHERE Id = :id";
    //now lets update what :mantra should be
    $query_params = array(
        ':id' => $_POST['id']
    );
    
    //Now let's make run the query:
    try {
        // These two statements run the query against your database table. 
        $stmt   = $db->prepare($query);
        $result = $stmt->execute($query_params);
    }
    catch (PDOException $ex) {
        // Note: On a production website, you should not output $ex->getMessage(). 
        // It may provide an attacker with helpful information about your code.  
        die("Failed to run query: " . $ex->getMessage());

		//You eventually want to comment out the above die and use this one:
		$response["success"] = 0;
		$response["message"] = "Database Error. Please Try Again!";
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
    
    //If we have made it here without dying, then we are in the clear to 
    //create a new mantra.  Let's setup our new query to create a mantra.  
    //Again, to protect against sql injects, mantra tokens such as :id and :mantraName
	
    $query = "INSERT INTO mantras (Id, Name, Description, ReleventSport, ReleventEducation, ReleventNewAge, ReleventHealth, CreationDate) 
				VALUES ( :id, :mantraName, :desc, :sport, :edu, :newage,  :health, :date ) ";
    
    // we need to update our tokens with the actual data:
    $query_params = array(
        ':id' => $_POST['id'],
        ':mantraName' => $_POST['mantraName'],
		':desc' => $_POST['desc'],
		':sport' => $_POST['sport'],
		':edu' => $_POST['education'],
		':newage' => $_POST['newage'],
		':health' => $_POST['health'],
		':date' => $_POST['date'],		
    );
    
    //time to run our query, and create the mantra
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
	//a new mantra to our database.  We could do a few things here, such as 
	//redirect to the login page.  Instead we are going to echo out some
	//json data that will be read by the Android application, which will login
	//the mantra (or redirect to a different activity, I'm not sure yet..)
	$response["success"] = 1;
	$response["message"] = "mantra Successfully Added!";
	echo json_encode($response);
	
	//for a php webservice you could do a simple redirect and die.
	//header("Location: login.php"); 
	//die("Redirecting to login.php");
    
    
} else {
?>
	<h1>Register</h1> 
	<form action="addMantra.php" method="post"> 
		Id:<br /> 
	    <input type="text" name="id" value="" /> 
	    <br /><br />
	    Name!:<br /> 
	    <input type="text" name="mantraName" value="" /> 
	    <br /><br /> 
	    Text:<br /> 
	    <input type="text" name="desc" value="" /> 
	    <br /><br /> 
		Sport:<br /> 
	    <input type="number" name="sport" value="" /> 
	    <br /><br />
		Education:<br /> 
	    <input type="number" name="education" value="" /> 
	    <br /><br />
		New Age:<br /> 
	    <input type="number" name="newage" value="" /> 
	    <br /><br />
		Health:<br /> 
	    <input type="number" name="health" value="" /> 
	    <br /><br />
		CreationDate:<br /> 
	    <input type="date" name="date" value="" /> 
	    <br /><br />		
	    <input type="submit" value="Register Mantra" /> 		
	</form>
	<?php
	}
?>
