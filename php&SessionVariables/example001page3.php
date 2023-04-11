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
		<title>PHP&SessionVariables Example 001 - Page Three</title>
		<meta charset="utf-8">
		<meta name="viewpoint" content="width=device-width, initial-scale=1 shrink-to-fit=no">
	</head>
    <body>
        <h2>Third Page</h2>
        <?php
            if(isset($_SESSION['user']))
                // display current data
                echo "<p>You are logged in as {$_SESSION['user']}.</p>";
            else {
                echo "<p>You are not logged in! Please <a href='example001page1.php' />sign in</a></p>";
            }

            if (isset($_SESSION['class']))
                echo "<p>Your are taking  {$_SESSION['class']} this semester.</p>";
        ?>

        <p>
            <a href='example001page2.php'>Previous page</a>
        </p>
        <p>
            <a href='example001page4.php'>Next page</a>
        </p>
    </body>
</html>
<?php
    // delete a session variable
    if (isset($_SESSION['class']))
        unset($_SESSION['class']);
?>