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
	if ( isset($_POST['autos_id']) ) {
		
		
		if ( strlen($_POST['autos_id']) < 1  ) {
			$failure = "All fields are required";
		}
		else if(!is_numeric($_POST["autos_id"])){
			$failure = "Mileage must be an integer ";
		}
		else{
			
			$stmt = $pdo->prepare('delete from  autos where autos_id= :id ');
			$stmt->execute(array(
			':id' => $_POST["autos_id"])
			);
			$ok="Record deleted";
			$_SESSION['success'] = "Record deleted";
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

			<p>Confirm: Deleting <?php echo $row["make"]; ?></p>
			<form method="post">
				<input type="hidden" name="autos_id" value="<?php echo $row["autos_id"]; ?>">
				<input type="submit" value="Delete" name="delete"><a href="index.php">Cancel</a>
			</form>
			
		</div>
	</body>
</html>
