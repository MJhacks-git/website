<?php
	$first_name = $_POST['first-name']
	$last_name = $_POST['last-name']
	$email = $_POST['email']
	$query = $_POST['queries']

	if(!empty($first_name) || !empty($last_name) !empty($email) !empty($query)){
		$host = "localhost";
		$dbUsername = "root";
		$dbPassword = "";
		$dbname = "mjhacks";

		//Creating connection
		$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

		if(mysqli_connect_error()){
			die('Connection Error('. mysqli_connect_errno().')'.mysqli_connect_error());
		}
		else{
			$SELECT = "SELECT email From queries Where email = ? Limit 1";
			$INSERT = "INSERT Into queries (first_name, last_name, email, query) values(?, ?, ?, ?)";

			//Prepare Statement

			$stmt = $conn->prepare($SELECT);
			$stmt->bind_param('s', $email);
			$stmt->execute();
			$stmt->bind_result($email);
			$stmt->store_result();
			$rnum = $stmt->num_rows;
			if(rnum==0){
				$stmt->close();

				$stmt = $conn->prepare($INSERT);
				$stmt->bind_param("ssss", $first_name, $last_name, $email, $query);
				$stmt->execute();
				echo "Form Submitted Successfully!";
			}
			else{
				echo "This email is already used before.";
			}
			$stmt->close();
			$conn->close();
		}
	}
	else{
		echo "All fields are required";
		die();
	} 
?>