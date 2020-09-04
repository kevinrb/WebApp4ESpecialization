<?php
	session_start();
	
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Kevin Rojas Bohorquez </title>
		<?php require_once "bootstrap.php"; ?>
	</head>
	<body>
		<div class="container">
			<h2>Welcome to the Automobiles Database</h2>
			<?php
				if ( isset($_SESSION['name']) ) {
					require_once("pdo.php");	
					
					if ( isset($_SESSION['success']) ) {
						echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
						unset($_SESSION['success']);
					}
					$res=$pdo->query("select autos_id,make,model,year,mileage from autos order by make");
					
					$rows = $res->fetchAll(PDO::FETCH_ASSOC);
					if(count($rows)>0){
						echo "<table border=1>
						<thead><tr>
						<th>Make</th>
						<th>Model</th>
						<th>Year</th>
						<th>Mileage</th>
						<th>Action</th>
						</tr></thead>";
						foreach($rows as $row){
							echo "<tr><td>".htmlentities($row["make"])."</td><td>".htmlentities($row["model"])."</td><td>".htmlentities($row["year"])."</td><td>".htmlentities($row["mileage"])."</td><td><a href='edit.php?autos_id=".htmlentities($row["autos_id"])."'>Edit</a> / <a href='delete.php?autos_id=".htmlentities($row["autos_id"])."'>Delete</a></td></tr>";
						}
						echo "</table>";
					}
					else{
						
						echo "<p>No rows found</p>";
						
					}
					
				?>			
				
				<p><a href="add.php">Add New Entry</a></p>
				<p><a href="logout.php">Logout</a></p>
				
				<?php
				}
				else{
				?>
				<p><a href="login.php">Please log in</a></p>
				<p>Attempt to <a href="add.php">add data</a> without logging in</p>
				
				<?php
				}
			?>
		</div>
	</body>
</html>

