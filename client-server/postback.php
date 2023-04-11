<!DOCTYPE html>    <!-- guess.php -->
<html lang="en">
	<head>
		<title>Guess a Number</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	</head>
	
	<?php

		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$randNum = rand(1, 10);
				
			if ($randNum == $_POST["num"])
				echo "<h1>Correct!</h1>";
			else
				echo "<p>No, I was thinking of $randNum.</p>"; 
		}
	?>

	<form method="post" action="postback.php">
		<p>I'm thinking of a number between 1 and 10.</p>
		<p>Your guess? <input type="number" name="num" min="1" max="10" value="<?php if ($_SERVER["REQUEST_METHOD"] == "POST") echo $_POST["num"]; ?>" autofocus></p>
		<input type="submit" value="Guess">
	</form>
</html>