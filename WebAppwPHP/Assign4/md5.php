<!DOCTYPE html>
<head><title>Kevin Rojas MD5 Cracker</title></head>
<body>
	<h1>MD5 cracker</h1>
	<p>
	This application takes an MD5 hash of a four digit pin and check all 10,000 possible four digit PINs to determine the PIN.
	<p>
	<pre>Debug Output:
<?php
			$goodtext = "Not found";
			// If there is no parameter, this code is all skipped
			if ( isset($_GET['md5']) ) {
				$time_pre = microtime(true);
				$md5 = $_GET['md5'];
				
				$show = 15;
				$count=0;
				for($i=0; $i<10; $i++ ) {	
					for($j=0; $j<10; $j++ ) {
						for($jj=0; $jj<10; $jj++ ) {
							for($jjj=0; $jjj<10; $jjj++ ) {
								$count++;
								// Concatenate the four numbers together to 
								// form the "possible" pre-hash text
								$try=$i.$j.$jj.$jjj;
								// Run the hash and then check to see if we match
								$check = hash('md5', $try);
								if ( $check == $md5 ) {
									$goodtext = $try;
									break 4;   // Exit the inner loops
								}
								
								// Debug output until $show hits 0
								if ( $show > 0 ) {
									print "$check $try\n";
									$show = $show - 1;
								}
							}
						}
					}
				}
				print "Total checks:";
				print $count;
				print "\n";
				// Compute elapsed time
				$time_post = microtime(true);
				print "Elapsed time: ";
				print $time_post-$time_pre;
				print "\n";
			}
		?>
		</pre>
		<!-- Use the very short syntax and call htmlentities() -->
		<p>Original Text: <?= htmlentities($goodtext); ?></p>
		<form method="GET">
			<input type="text" name="md5" size="40" />
			<input type="submit" value="Crack MD5"/>
		</form>
		<ul>
			<li><a href="md5.php">Reset</a></li>			
		</ul>
</body>
</html>

