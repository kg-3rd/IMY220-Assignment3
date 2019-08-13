<?php
	// See all errors and warnings
	error_reporting(E_ALL);
	ini_set('error_reporting', E_ALL);

	// Your database details might be different
	$mysqli = mysqli_connect("localhost", "root", "", "dbUser");

	$email = isset($_POST["email"]) ? $_POST["email"] : true;
	$pass = isset($_POST["pass"]) ? $_POST["pass"] : true;	
	
?>

<!DOCTYPE html>
<html>
<head>
	<title>IMY 220 - Assignment 3</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="style.css" />
	<meta charset="utf-8" />
	<meta name="author" content="Kgothalang Moifo">
	<!-- Replace Name Surname with your name and surname -->
</head>
<body>
	<div class="container">
		<?php
			
			if($email && $pass){
				//$query = "SELECT * FROM tbusers WHERE email = '$email' AND password = '$pass'";
				$query = "SELECT * FROM tbusers WHERE email = 'kg@g.com' AND password = '123'";
				$res = $mysqli->query($query);
				if($row = mysqli_fetch_array($res)){
					$user = $row["email"];
					echo 	"<table class='table table-bordered mt-3'>
								<tr>
									<td>Name</td>
									<td>" . $row['name'] . "</td>
								<tr>
								<tr>
									<td>Surname</td>
									<td>" . $row['surname'] . "</td>
								<tr>
								<tr>
									<td>Email Address</td>
									<td>" . $row['email'] . "</td>
								<tr>
								<tr>
									<td>Birthday</td>
									<td>" . $row['birthday'] . "</td>
								<tr>
							</table>";
				
					echo 	"<form action = '' enctype='multipart/form-data' method ='GET'>
								<div class='form-group'>
									<input type='file' class='form-control' name='picToUpload' id='picToUpload' /><br/>
									<input type='text' class='form-control' name='email' id='email' hidden='hidden' value=" . $row['email'] . ">
									<input type='text' class='form-control' name='pass' id='pass' hidden='hidden' value=" . $row['password'] . " >
									<input type='submit' class='btn btn-standard' value='Upload Image' name='submit' />
								</div>
						  	</form>";

						?><h2>Image Gallery</h2>
							<div class="container">
  								<div class ="row imageGallery">
  										<?php
  											$sql = "SELECT * FROM tbgallery where user_id ='$user'";
											$result = mysqli_query($mysqli,$sql);	
											echo mysqli_num_rows($result);
											if (mysqli_num_rows($result) > 0)
											{
											 	// output data of each row
											 	while($img = mysqli_fetch_assoc($result)) 
											 	{
													echo "<div class='col-3' style='background-image: url(".$img['filename'].")'></div>";
											 	}
											}
  										?>
  								</div>
  							</div>
  						<?php

					if(isset($_GET["picToUpload"]))
					{
						$fileS = $_GET["picToUpload"];
						$userID = $_GET["email"];
						$extension = pathinfo($_GET["picToUpload"], PATHINFO_EXTENSION);
						$extension = strtolower($extension);
						if(($extension == "jpg" || $extension == "jpeg") && filesize($fileS) < 2000000)
						{
						    $sql= "INSERT INTO tbgallery(user_id, filename)
									VALUES ('$userID', '$fileS')";

							if (mysqli_query($mysqli, $sql)) 
							{
								mysqli_close($mysqli);
								header("Refresh:0");
							}
						 	else 
						 	{
						 		echo "Error: " . $sql. "<br>" . mysqli_error($mysqli);
						 		mysqli_close($mysqli);
						 	}
							
						}
						else
						{
							echo '<div class="alert alert-danger mt-3" role="alert">Upload image of correct format and size should not exceed 1MB!</div>';
						}
					}
					else
					{
						echo "not set";
					}
				}
				else{
					echo 	'<div class="alert alert-danger mt-3" role="alert">
	  							You are not registered on this site!
	  						</div>';
				}
			} 
			else{
				echo 	'<div class="alert alert-danger mt-3" role="alert">
	  						Could not log you in
	  					</div>';
			}
		?>
	</div>
</body>
</html>