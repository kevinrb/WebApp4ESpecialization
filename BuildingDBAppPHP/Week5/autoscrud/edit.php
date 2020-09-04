<?php
	session_start();
	if ( ! isset($_SESSION['name']) or (!isset($_GET['autos_id']) )) {
		die("ACCESS DENIED");
	}	
	require_once("pdo.php");
	// Demand a GET parameter
	
	// If the user requested logout go back to index.php
	if ( isset($_POST['cancel']) ) {
		header('Location: index.php');
		return;
	}
	
	$res=$pdo->query("select autos_id,make,model,year,mileage from autos where autos_id ='{$_GET["autos_id"]}'");
	$row = $res->fetchAll(PDO::FETCH_ASSOC);
	if(count($row)>0){
		$row=$row[0];
	}
	else{
		die("ACCESS DENIED");
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
			
			$stmt = $pdo->prepare('update autos set make= :mk,year= :yr, mileage= :mi, model= :mo where autos_id= :id ');
			$stmt->execute(array(
			':mk' => $_POST['make'],
			':yr' => $_POST['year'],
			':mi' => $_POST['mileage'],
			':mo' => $_POST['model'],
			':id' => $_GET["autos_id"])
			);
			$ok="Record edited";
			$_SESSION['success'] = "Record edited";
			header("Location: index.php");
			return;
		}
		
		
		$_SESSION['error'] = $failure;
		header("Location: edit.php");
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
				<p>Make:  <input type="text" name="make" id="make" size=40 value="<?php echo $row["make"]; ?>"/></p>
				<p>Model:  <input type="text" name="model" id="model" size=40 value="<?php echo $row["model"]; ?>"/></p>
				<p>Year:  <input type="text" name="year" id="year" size=10 value="<?php echo $row["year"]; ?>"/></p>
				<p>Mileage:  <input type="text" name="mileage" id="mileage" size=10 value="<?php echo $row["mileage"]; ?>"/></p>
				<input type="submit" value="Save">
				<input type="submit" name="cancel" value="Cancel">
			</form>
			
		</div>
	</body>
</html>
