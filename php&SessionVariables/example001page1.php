<?php
	/* How to use session variables
	Initiate a session or get session variables, it's good practice to do this at the
	start of every code if you plan to use session variables
	*/
	session_start();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>PHP&SessionVariables Example 001 - Page One</title>
		<meta charset="utf-8">
		<meta name="viewpoint" content="width=device-width, initial-scale=1 shrink-to-fit=no">
	</head>
	<body>
		<h2>First Page</h2>
		<?php
			// If user is logged in display user name
			if (isset($_SESSION['user'])){
				echo "<p>You are logged in as {$_SESSION['user']}.</p>";
				echo "<p><a href='example001page2.php' />Next page</a></p>";
			}
			else { //This else block of code doesn't end until later
		?>
		<form action='example001page2.php' method='post'>
			<p>Username:
				<input type='text' name='user' />
			</p>
			<p>
				<input type='submit' value='Sign in' />
			</p>
		</form>
		<?php
			}  // end the if-statement from the previous php block of code
		?>
	</body>
</html>