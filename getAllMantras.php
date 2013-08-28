<?php

//	Connect
require("config.inc.php");

//if posted data is not empty
if (!empty($_POST)) {
		
    $query = "SELECT * FROM mantras WHERE 1";
	    
    //time to run our query, and create the mantra
    try {
        $stmt   = $db->prepare($query);
        $result = $stmt->execute();
		$data = $stmt->fetch();
		$response["success"] = 1;
		$response["message"] = "";
		
		$msg = "";
				
        do	{							
				$msg = $msg . " , " . json_encode($data);
			} 
			while ($data = $stmt->fetch());
			
		$response["success"] = 1;
		$response["message"] = $msg;
		
		die(json_encode($response));		
    }
    catch (PDOException $ex) {        
		$response["success"] = 0;
		$response["message"] = "Database Error. Please Try Again!";
		die(json_encode($response));
    }
    
} else {
?>
	<h1>Get All Mantras.</h1> 
	<form action="getAllMantras.php" method="post"> 	
		<input type="text" name="tmp" value="">
	    <input type="submit" value="get mantra" /> 		
	</form>
	<?php
	}
?>
