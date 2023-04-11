<?php
    session_start();
?>
<!DOCTYPE html>
<!--
    Using sessions and session variables to track valid users.
    This code asks the user for credentials and keeps it in session variables if it's correct.
    If not, then force the user to put in their credentials again.
    One thing to note is how this code makes use of encryption (uses the md5() function)
    TODO Continue on Step 6 of the final! You're half way there, you can do it!
-->
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <title>CS382 - Final Exam/Project</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
        <style>
                .menu-link>a {
                    color: #fff;
                    font-weight: 500;
                    padding-left: 20px;
                }

                .menu-bar {
                    background-color: maroon;
                }
            </style>
    </head>
    <body>
        <div class='container-fluid'>
            <!-- include page content -->
            <?php
                // Establish database connection
                include("pdo_connect.php");

                /* Check if the database connection is established. If not, exit the program. */
                if (!$db) {
                    echo "Could not connect to the database";
                    exit();
                }
            ?>
            
            <div class="row">
                <div class="col-sm-12">
                    <img src="http://www.southjersey.com//images/page_movies.jpg" alt="Movie store" height="100px">
                </div>
                <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #6c757d;">
                    <div class="collapse navbar-collapse" id="navbarText">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="index.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?mode=movies&genre=all">Movies</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?mode=rentals">My Rentals</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?mode=currentRentals">Current Rentals</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?mode=logout">Sign Out</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>


            <?php
                // Define variables and assign their default values
                $mode = ""; // default value for the switch statement
                if (isset($_GET['mode'])) {
                    $mode = $_GET['mode'];
                }


                if (!isset($_SESSION["memberID"]) && !(isset($_POST["username"]))) {
                    // User is trying to access the page without signing in. Display the login page
                    echo "You are not signed in!";
                    include("loginForm.html");

                    // close the HTML tags and exit
                    echo "</div></body></html>";
                    exit();
                }

                $parameterValues = null; // default values for named parameters
                $pageTitle = ""; // define a title for each output
                $columns = array(); // define an array of column labels for a table header

                try {
                    switch ($mode) {
                        case "login":
                            // read login information
                            $username = (isset($_POST["username"])) ? $_POST["username"] : "-1";
                            $password = (isset($_POST["password"])) ? $_POST["password"] : "-1";
                            // Define SQL statement
                            $sql = "SELECT `memberID`, `firstName`, `lastName` from `members` where username=:username and password = :password ";

                            // Use md5( ) method to encrypt the password
                            $parameters = [":username" => $username, ":password" => md5($password)];

                            // Execute the SQL statement
                            $stm = $db->prepare($sql);
                            $stm->execute($parameters);
                            $result = $stm->fetch();

                            // validate the user
                            if (isset($result) && isset($result["memberID"])) {
                                // Valid user. Store the memberID using a session variable
                                $_SESSION["memberID"] = $result["memberID"];

                                // You may save any other information. For example, the full name can be assigned to a session variable.
                                $_SESSION["name"] = $result["firstName"] . " " . $result["lastName"];
                                echo "<p>Logged in as {$_SESSION["name"]}</p>";
                                echo "<div class='container'>
                                        <h3 class='text-center'>Welcome to the Online Movie Club<h3>
                                        <img class='mx-auto d-block' src='resources/disney_titles.jpg'>
                                      </div>";
                            }
                            else {
                                echo "<p>Invalid user</p>";
                                // Display the login form
                                include("loginForm.html");
                            }
                            break;

                        case "logout":
                            // Remove all the session variables and display the login form
                            session_unset();
                            setcookie(session_name(), '', time() - 1000, '/');
                            $_SESSION = array();
                            include("loginForm.html");
                            break;

                        case "rentMovie":
                            $memberID = $_SESSION["memberID"];
                            $movieID = null;

                            // If movie title is chosen, then convert it back to normal format (with spaces) and set movieID
                            if(isset($_GET) && isset($_GET["movie"])) {
                                $title = str_replace("_", " ", $_GET["movie"]);

                                //Define SQL Statement and parameters
                                $sql = "SELECT `movieID` from `movies` where title = :title";
                                $parameters = [":title" => $title];

                                // Execute the SQL statement
                                $stm = $db->prepare($sql);
                                $stm->execute($parameters);
                                $result = $stm->fetch();

                                //Set movieID value
                                $movieID = $result["movieID"];
                            }

                            if(isset($movieID)) {
                                /* Check if movie has currently rented */
                                //Define SQL Statement
                                $sql = "SELECT returned
                                        FROM rentals
                                        WHERE memberID = :memberID and movieID = :movieID";

                                // Define values for the named parameters
                                $parameters = [":memberID" => $memberID, ":movieID" => $movieID];

                                // Execute the SQL statement
                                $stm = $db->prepare($sql);
                                $stm->execute($parameters);
                                $result = $stm->fetch();

                                if(isset($result["returned"]) && $result["returned"] == "0000-00-00") {
                                    echo "<p>You've already checked out the movie: \"${title}\"<p>";
                                }
                                else {
                                    //Define SQL Statement
                                    $sql = "INSERT INTO `rentals`(dateOut, movieID, memberID)
                                            VALUES (:dateOut, :movieID, :memberID)";

                                    // Define values for the named parameters
                                    $parameters = [":dateOut" => date("Y-m-d"),
                                                    ":movieID" => $movieID,
                                                    "memberID" => $_SESSION["memberID"]
                                                    ];

                                    // Execute the SQL statement
                                    $stm = $db->prepare($sql);
                                    $stm->execute($parameters);

                                    echo "<p>You have checked out the movie: \"${title}\"</p>";

                                    //Get rent due date
                                    $timestamp = mktime(0, 0, 0, date("m"), date("d") + 7, date("Y"));
                                    $date = date("Y-m-d", $timestamp);

                                    echo "<p>Your rental is due by ${date}</p>";
                                }
                                
                            }
                            else {
                                echo "Looks like an error has occurred, please contact the support desk.";
                            }
                            break;

                        case "returnMovie":
                            // If movie title is chosen, then convert it back to normal format (with spaces) and set movieID
                            if(isset($_GET) && isset($_GET["movie"])) {
                                $title = str_replace("_", " ", $_GET["movie"]);

                                //Define SQL Statement and parameters
                                $sql = "SELECT `movieID` from `movies` where title = :title";
                                $parameters = [":title" => $title];

                                // Execute the SQL statement
                                $stm = $db->prepare($sql);
                                $stm->execute($parameters);
                                $result = $stm->fetch();

                                //Set movieID value
                                $movieID = $result["movieID"];
                            }

                            if(isset($movieID)) {
                                /* Check if movie has currently rented */
                                //Define SQL Statement
                                $sql = "SELECT returned
                                        FROM rentals
                                        WHERE memberID = :memberID and movieID = :movieID and returned = '0000-00-00'";

                                // Define values for the named parameters
                                $parameters = [":memberID" => $_SESSION["memberID"], ":movieID" => $movieID];

                                // Execute the SQL statement
                                $stm = $db->prepare($sql);
                                $stm->execute($parameters);
                                $result = $stm->fetch();

                                if(isset($result["returned"]) && $result["returned"] == "0000-00-00") {
                                    //Define SQL Statement
                                    $sql = "UPDATE rentals
                                            SET returned = :returned
                                            WHERE memberID = :memberID and movieID = :movieID and returned = '0000-00-00'";

                                    // Define values for the named parameters
                                    $parameters = [":returned" => date("Y-m-d"), "memberID" => $_SESSION["memberID"], ":movieID" => $movieID];

                                    // Execute the SQL statement
                                    $stm = $db->prepare($sql);
                                    $stm->execute($parameters);

                                    echo "<p>You have returned the movie: \"${title}\"</p>";
                                }
                            }
                            else {
                                echo "Looks like an error has occurred, please contact the support desk.";
                            }
                            break;

                        case "currentRentals":
                            //Define SQL Statement
                            $sql = "SELECT DISTINCT mov.title, mov.type, r.dateOut
                                    FROM movies as mov, members as mem, rentals as r
                                    WHERE r.memberID = :memberID and r.movieID = mov.movieID and r.returned = '0000-00-00'
                                    ORDER BY r.dateOut;";

                            // Define values for the named parameters
                            $parameters = [":memberID" => $_SESSION["memberID"]];

                            // Execute the SQL statement
                            $stm = $db->prepare($sql);
                            $stm->execute($parameters);
                            $result = $stm->fetchAll(PDO::FETCH_ASSOC);

                            if(!empty($result)) {
                                // Display result
                                $pageTitle = "List of Rented Movies";
                                $columns = array("Title", "Genre", "Rental Date", "Due Date"); // we will use a two-column table to display members
                                displayResultSet($pageTitle, $result, $columns);
                            }
                            else
                                echo "There are currently no rentals";
                           
                            break;

                        case "members": // display a list of members
                            // 1. define SQL statement
                            $sql = "SELECT `firstName`, `lastName` FROM `members` order by `lastName`";

                            // 2. Define values for named parameters. There are no parameters in this SQL statement. Use the default.

                            // 3. Fetch result set
                            $resultSet = getAll($sql, $db, $parameterValues);

                            // 4. Display result
                            $pageTitle = "List of Members";
                            $columns = array("First Name", "Last Name"); // we will use a two-column table to display members
                            displayResultSet($pageTitle, $resultSet, $columns);
                            break;

                        case "movies": // display a list of movies, based on the selected genre

                            // 1. define SQL statement

                            /* Note: We use two key/value pairs: 
                                mode - identifies the switch case
                                genre - movie type
                                If genre=all then display all the movies.
                                If genre=Drama then display Drams type movies.
                                Need two different SQL statements.
                                We can use an if ... else statement to handle these values.
                            */

                            //Get all genres in the database
                            $sql = "SELECT DISTINCT type
                            FROM movies
                            ORDER BY type";

                            $stm = $db->prepare($sql);
                            $stm->execute();
                            $allGenres = $stm->fetchAll(PDO::FETCH_COLUMN);
                            ?>
                            
                            <form action="index.php" method="get">
                                <div class="dropdown">
                                    <span>Select genre:</span>
                                    <input hidden name="mode" value="movies">
                                    <select name="genre">
                                        <?php
                                            foreach($allGenres as $key=>$value) {
                                                $text = ($_GET["genre"] == $value) ? "<option class='dropdown-item' selected>${value}</option>" : 
                                                        "<option class='dropdown-item' <?php if(\$genre == ${value}) {echo 'selected';} ?>${value}</option>";

                                                echo $text;
                                            }
                                        ?>
                                    </select>
                                    <button type="submit" class="btn btn-primary">Filter by Genre</button> 
                                </div>
                            </form>
                            
                            <?php
                            if (isset($_GET['genre']) && $_GET['genre'] !== "all") {
                                $genre = $_GET['genre'];
                                $sql = "SELECT `title`, `type`, `year` FROM `movies` where `type` = :genre order by `title`";

                                // 2. Define values for named parameters. 
                                $parameterValues = array(":genre" => $genre);

                                // Define page title
                                $pageTitle = "List of {$genre} movies";
                            } else {
                                // Default output is a list of all the movies
                                $sql = "SELECT `title`, `type`, `year` FROM `movies`  order by `title`";

                                // 2. Define values for named parameters. There are no parameters in this SQL statement. Use the default.

                                // Define page title
                                $pageTitle = "List of movies";
                            }


                            // 3. Fetch result set
                            $resultSet = getAll($sql, $db, $parameterValues);

                            // 4. Display result
                            $columns = array("Title", "Genre", "Year"); // three columns, same as the field names in the SQL statement

                            displayResultSet($pageTitle, $resultSet, $columns);
                            break;

                        case "rentals":
                            $memberID = $_SESSION["memberID"];
                            $sql = "SELECT mov.title, mov.type, r.dateOut, r.returned
                                    FROM movies as mov, members as mem, rentals as r
                                    WHERE r.memberID = :memberID and r.movieID = mov.movieID
                                    GROUP BY r.id
                                    ORDER BY r.dateOut;";

                            // 2. Define values for named parameters. 
                            $parameterValues = array(":memberID" => $memberID);

                            // Define page title
                            $pageTitle = "List of Rentals";

                            // 3. Fetch result set
                            $resultSet = getAll($sql, $db, $parameterValues);

                            // 4. Display result
                            $columns = array("Title", "Genre", "Rental Date", "Date Returned"); // three columns, same as the field names in the SQL statement

                            displayResultSet($pageTitle, $resultSet, $columns);
                            break;

                        default: // Default page
                            echo "<p>Logged in as {$_SESSION["name"]}</p>";
                            echo "<div class='container'>
                                    <h3 class='text-center'>Welcome to the Online Movie Club<h3>
                                    <img class='mx-auto d-block' src='resources/disney_titles.jpg'>
                                    </div>";
                            break;
                    }
                } catch (PDOException $e) {
                    echo "Error!: " . $e->getMessage() . "<br/>";
                    die();
                }
                /* end main section */
            ?>
        </div>
    </body>
</html>

<?php
function displayResultSet($pageTitle, $resultSet, $columns)
{
    // Use a table structure for displaying data
    echo $pageTitle;
    echo "<table class='table table-sm'>";
    // If the $columns array is not empty then display table header
    $numCols = count($columns); // find the size of the array
    if ($numCols > 0) {
        echo "<thead><tr>";

        foreach ($columns as $c)
            echo "<th>{$c}</th>";

        if($_GET["mode"] != "rentals")
            echo "<th></th>";

        echo "</thead>";
    }

    echo "<tbody>";
    foreach ($resultSet as $item) {
        /* Each $item is an associative array.  Keys are the same as the field names 
                    used in the SQL statement.
                */
        // Define a table row for each item in the $resultSet array
        echo "<tr>";

        // We can use a foreach loop to access each element of $item array
        foreach ($item as $key => $value) {
            if($value == "0000-00-00") {
                $dueDate = getDueDate($item["dateOut"]);

                if(date("Y-m-d") > $dueDate)
                    echo "<td class='text-danger'>Due on {$dueDate} Overdue</td>";
                else
                    echo "<td>Due on {$dueDate}</td>";
                
            }
            else
                echo "<td>{$value}</td>";
        }

        $mode = $_GET["mode"];
        
        switch($mode) {
            case "movies":
                $title = convertMovieTitle($item["title"]);
                echo "<td><a href=index.php?mode=rentMovie&movie=${title}>Rent</td>";
                break;
            case "currentRentals":
                $dueDate = getDueDate($item["dateOut"]);
                echo "<td>${dueDate}</td>";

                $title = convertMovieTitle($item["title"]);
                echo "<td><a href=index.php?mode=returnMovie&movie=${title}>Return</td>";
                break;
            default:
                echo "</tr>";
        }
    }
    echo "</tbody></table>";
}

function getAll($sql, $db, $parameterValues = null)
{
    /* Prepare the SQL statement. 
        The $db->prepare($sql) method returns an object.
    */
    $statement = $db->prepare($sql);

    /* Execute prepared statement. The execute( ) method returns a resource object.  */
    $statement->execute($parameterValues);

    /* Use the fetchAll( ) method to extract records from the result set.
    */
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}

function convertMovieTitle($title) {
    $newTitle = "";
    $words = explode(" ", $title);

    foreach($words as $w) {
        if($w == $words[count($words) - 1])
            $newTitle .= $w;
        else
            $newTitle .= $w."_";
    }

    return $newTitle;
}

function getDueDate($date) {
    $time = explode("-", $date);
    $time[2] = (string) ((int) $time[2] + 7);

    $dueDate = "";
    foreach($time as $t) {
        if($t == $time[count($time) - 1])
            $dueDate .= $t;
        else
            $dueDate .= $t."-";
    }

    return $dueDate;
}