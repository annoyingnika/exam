<?php
	//require another php file
	// ../../../ means > 3 folders back
	require_once("../../config.php");
	
	//if the variable doesn't exist in the urldecode
	if(!isset ($_GET["edit"])){
		
			//redirect user_error
			echo "Redirect";
			
			
			header("Location: table.php");
			exit(); //don't execute futher
			
	}else{
		
			echo "User wants to edit row:".$_GET["edit"];
			
			//ask for latest data for single row
			$mysql = new mysqli("localhost", $db_username, $db_password, "webpr2016_nicole");
			
			
			//may be  user wants update the data after clicking Save to DB
			if(isset($_GET["start"]) && isset($_GET["destination"])&& isset($_GET["price"])){
				
				echo "User modified the data, tries to save";
				
				
				//should be validation?
				$stmt = $mysql->prepare("UPDATE exam1 SET start_location=?, destination=?, price=? WHERE id=?");
				
				echo $mysql->error;
				
				$stmt->bind_param("sssi", $_GET["start"], $_GET["destination"], $_GET["price"],$_GET["edit"]);
				
				if($stmt->execute()){
					
					echo "Saved successfully";
					
					// option nr1 - redirect
					header("Location: table.php");
					exit();
					
					//option nr 2 - upgrade variables
					
					//$recipient = $_GET["to"];
					//$message = $_GET["message"];
					//$id = $_GET["edit"];
				}else{
					
					echo $stmt->error;
				}
				
				
			}else{
				
				//user did not click any buttons yet
				//give user latest db data
					
				$stmt = $mysql->prepare ("SELECT id, start_location, destination, price FROM exam1 WHERE id=?");
			
			echo $mysql->error;
			
			// replace the ? mark
			$stmt->bind_param("i",$_GET["edit"]);
			
			//bind result data
			$stmt->bind_result($id, $start_location, $destination, $price);
			
			$stmt->execute();
			
			// we have only 1 row of data
			if($stmt->fetch()){
				
				//we have data
				echo $start_location." ".$destination." ".$price;
				
				
			}else{
				
				//sth wrong
				echo $stmt->error;
				}
			}
	}	
?>

<?php
			$dataExists = false;
				if ($_SERVER["REQUEST_METHOD"] == "POST")
				{
			$name = $_POST["name"];
			$Login_id = $_POST["Login_id"];
			$date = $_POST["date"];
			$genre = $_POST["genre"];
			$description = $_POST["description"];
				if($name && $Login_id && $date && $genre)
					{
			$dataExists = true;
					}
				}
?>
<a href="table.php">table</a>
<h2> Taxi application </h2>

<form method="get">
	
	<input hidden name="edit" value="<?=$id;?>"><br>

	<label for="start">Start Location:<label><br>
	<input type="text" name="start" value="<?=$start_location; ?>" <br><br>
	
	
	<label for="destination">Destination:<label><br>
	<input type="text" name="destination" value="<?=$destination; ?>" <br><br>
	
	<label for="price">Price:<label><br>
	<input type="text" name="price" value="<?=$price; ?>" <br><br>
	
	
	<input type="submit" value="Save changes">
	
	
<form>	