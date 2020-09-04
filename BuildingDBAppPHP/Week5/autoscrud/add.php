<?php
	session_start();
	if ( ! isset($_SESSION['name']) ) {
		die("ACCESS DENIED");
	}	
	require_once("pdo.php");
	// Demand a GET parameter
	
	// If the user requested logout go back to index.php
	if ( isset($_POST['cancel']) ) {
		header('Location: index.php');
		return;
	}
	
	$failure = false;
	$ok = false;
	if ( isset($_POST['model']) && isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage']) ) {
		
		
		if ( strlen($_POST['model']) < 1 || strlen($_POST['make']) < 1 || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1  ) {
			$failure = "All fields are required";
		}
		else if(!is_numeric($_POST["mileage"])){
			$failure = "Mileage must be an integer ";
		}
		else if(!is_numeric($_POST["year"])){
			$failure = "Year must be an integer ";
		}
		else{
			
			$stmt = $pdo->prepare('INSERT INTO autos (make, year, mileage,model) VALUES ( :mk, :yr, :mi, :mo)');
			$stmt->execute(array(
			':mk' => $_POST['make'],
			':yr' => $_POST['year'],
			':mi' => $_POST['mileage'],
			':mo' => $_POST['model'])
			);
			$ok="Record added";
			$_SESSION['success'] = "Record added";
			header("Location: index.php");
			return;
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
				<p>Make:  <input type="text" name="make" id="make" size=40/></p>
				<p>Model:  <input type="text" name="model" id="model" size=40/></p>
				<p>Year:  <input type="text" name="year" id="year" size=10/></p>
				<p>Mileage:  <input type="text" name="mileage" id="mileage" size=10/></p>
				<input type="submit" value="Add">
				<input type="submit" name="cancel" value="Cancel">
			</form>
			
		</div>
	</body>
</html>
