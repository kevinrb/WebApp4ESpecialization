<?php
	session_start();
	if ( ! isset($_SESSION['name']) ) {
		die('Not logged in');
	}	
	require_once("pdo.php");
	// Demand a GET parameter
	
	// If the user requested logout go back to index.php
	if ( isset($_POST['logout']) ) {
		header('Location: index.php');
		return;
	}
	
	$failure = false;
	$ok = false;
	if ( isset($_POST['mileage']) && isset($_POST['make']) && isset($_POST['year']) ) {
		if(is_numeric($_POST["mileage"]) AND is_numeric($_POST["year"])){
			if ( strlen($_POST['make']) < 1  ) {
				$failure = "Make is required";
			}
			else{
				$stmt = $pdo->prepare('INSERT INTO autos (make, year, mileage) VALUES ( :mk, :yr, :mi)');
				$stmt->execute(array(
				':mk' => $_POST['make'],
				':yr' => $_POST['year'],
				':mi' => $_POST['mileage'])
				);
				$ok="Record inserted";
				$_SESSION['success'] = "Record inserted";
				header("Location: view.php");
				return;
			}
		}
		else{
			
			$failure="Mileage and year must be numeric";
			
		}
		$_SESSION['error'] = $failure;
		header("Location: add.php");
		return;
	}
	
	
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Kevin Rojas Bohorquez </title>
		<?php require_once "bootstrap.php"; ?>
	</head>
	<body>
		<div class="container">
			<h1>Tracking Autos for 
				<?php
					if ( isset($_REQUEST['name']) ) {
						
						echo htmlentities($_REQUEST['name']);
					}
				?>
			</h1>
			<?php

				if ( isset($_SESSION['error']) ) {
					echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
					unset($_SESSION['error']);
				}
			?>
			<form method="post">
				<p>Make:  <input type="text" name="make" id="make" size=60/></p>
				<p>Year:  <input type="text" name="year" id="year" /></p>
				<p>Mileage:  <input type="text" name="mileage" id="mileage" /></p>
				<input type="submit" value="Add">
				<input type="submit" name="logout" value="Logout">
			</form>
			
		</div>
	</body>
</html>
