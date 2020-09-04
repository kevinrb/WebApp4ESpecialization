<?php
	require_once("pdo.php");
	// Demand a GET parameter
	if ( ! isset($_GET['name']) || strlen($_GET['name']) < 1  ) {
		die('Name parameter missing');
	}
	
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
				
			}
		}
		else{
			
			$failure="Mileage and year must be numeric";
			
		}
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
				// Note triple not equals and think how badly double
				// not equals would work here...
				if ( $failure !== false ) {
					// Look closely at the use of single and double quotes
					echo('<p style="color: red;">'.htmlentities($failure)."</p>\n");
				}
				if ( $ok !== false ) {
					// Look closely at the use of single and double quotes
					echo('<p style="color: green;">'.htmlentities($ok)."</p>\n");
				}
			?>
			<form method="post">
				<p>Make:  <input type="text" name="make" id="make" size=60/></p>
				<p>Year:  <input type="text" name="year" id="year" /></p>
				<p>Mileage:  <input type="text" name="mileage" id="mileage" /></p>
				<input type="submit" value="Add">
				<input type="submit" name="logout" value="Logout">
			</form>
			<h2>Automobiles</h2>
			<ul>
			<p></p>
				<?php
					$res=$pdo->query("select make,year,mileage from autos order by make");
					
					$rows = $res->fetchAll(PDO::FETCH_ASSOC);
					foreach($rows as $row){
						echo "<li>{$row["year"]} ".htmlentities($row["make"])." / {$row["mileage"]}</li>";
					}
				?>
			</ul>
		</div>
	</body>
</html>
