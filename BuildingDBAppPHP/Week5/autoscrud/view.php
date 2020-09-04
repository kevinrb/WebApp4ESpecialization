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

				if ( isset($_SESSION['success']) ) {
					echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
					unset($_SESSION['success']);
				}
				?>
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
			<p>
				<a href="add.php">Add New</a> |
				<a href="logout.php">Logout</a>
			</p>
		</div>
	</body>
</html>
