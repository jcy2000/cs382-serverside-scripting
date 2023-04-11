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
		<title>PHP&SessionVariables Example 001 - Page Four</title>
		<meta charset="utf-8">
		<meta name="viewpoint" content="width=device-width, initial-scale=1 shrink-to-fit=no">
	</head>
    <body>
        <h2>Fourth Page</h2>
        <?php
            if(isset($_SESSION['user']))
                echo "<p>You are logged in as {$_SESSION['user']}.</p>";
            if(isset($_SESSION['class']))
                echo "<p>Your are taking  {$_SESSION['class']} this semester.</p>";
            else
                echo "<p>You are not taking CompSci 482 this semester. You are missing all the fun!</p>";
        ?>

        <p>
            <a href='example001page3.php'>Previous page</a>
        </p>
        <p>
            <a href='example001page5.php'>Next page</a>
        </p>
    </body>
</html>