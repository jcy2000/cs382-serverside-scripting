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
		<title>PHP&SessionVariables Example 001 - Page Two</title>
		<meta charset="utf-8">
		<meta name="viewpoint" content="width=device-width, initial-scale=1 shrink-to-fit=no">
	</head>
    <body>
        <h2>Second Page</h2>
        <?php
            if(isset($_SESSION['user'])){
                // display current data
                echo "<p>You are logged in as {$_SESSION['user']}.</p>";
            }
            elseif(isset($_POST['user'])){
                // Define a new session variable to register the user
                $_SESSION['user'] = $_POST['user'];
                echo "<p>Hello {$_SESSION['user']}</p>";
            }
        ?>

        <p>
            <a href='example001page1.php'>Previous page</a>
        </p>
        <p>
            <a href='example001page3.php'>Next page</a>
        </p>
    </body>
</html>
<?php
    // Register another session variable
    if (!isset($_SESSION['class']))
        $_SESSION['class'] = "CompSci 482";
?>