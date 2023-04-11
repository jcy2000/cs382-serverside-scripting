<?php
    /* How to use session variables
    Initiate a session or get session variables, it's good practice to do this at the
	start of every code if you plan to use session variables
	*/
    session_start();

    // delete all session variables
    session_unset();
    setcookie(session_name(), '', time()-1000, '/');
    $_SESSION = array();
?>
<!DOCTYPE html>
    <head>
		<title>PHP&SessionVariables Example 001 - Page Four</title>
		<meta charset="utf-8">
		<meta name="viewpoint" content="width=device-width, initial-scale=1 shrink-to-fit=no">
	</head>
    <body>
        <h2>Fifth Page</h2>
        <?php
            /* Previous pages, this condition would be met,
            but with all the session variables being deleted,
            this condition is no longer met
            */
            if (isset($_SESSION['user']))
                echo "<p>You are logged in as {$_SESSION['user']}.</p>";
            else
                echo "<p>You are not logged in. Please <a href='example001page1.php'>sign in</a></p>";
        ?>

        <p>
            <a href='example001page4.php'>Previous page</a>
        </p>
    </body>
</html>