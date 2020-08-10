<!DOCTYPE html>
<html lang="en-US">
	<head>
		<title> Kevin Rojas PHP </title>
		<meta charset="UTF-8">
	</head>
	<body>
		<h1>Kevin Rojas PHP</h1>
		<p> The SHA256 hash of "Kevin Rojas" is 
			<?php
				print hash('sha256', 'Kevin Rojas');
				
			?>
		</p>
		<pre>
ASCII ART:

    ----    ---- 
    ****   ****  
    ----  ----   
    *********    
    ---------    
    ****  ****   
    ----   ----  
    ****    **** 
		</pre>
		<a href="check.php">Click here to check the error setting</a>
		<br />
		<a href="fail.php">Click here to cause a traceback</a>
	</body>
</html>