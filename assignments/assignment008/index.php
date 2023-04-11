<!--
    Using a Switch Statement to Process Different User Requests via a Single Server-side Script
    Key thing to note: the include() function essentially transfers code from another file onto this code. This
    is done this way to reduce clutter and increase optimization!
-->
<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <title>Movies Database Display v4.0 /w Admin Privilege</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    </head>
    <body>
        <div class='container-fluid'>
            <!-- include page content -->
            <?php
                // Establish database connection
                include("../pdo_connect.php");

                /* Check if the database connection is established. If not, exit the program. */
                if (!$db) {
                    echo "Could not connect to the database";
                    exit();
                }
            ?>
            <style>
                .menu-link > a { color: #fff; font-weight: 500; padding-left: 20px; }
                .menu-bar { background-color: maroon; }
            </style>
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
                                <a class="nav-link" href="index.php?mode=members">Members</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?mode=movies&genre=all">All Movies</a>
                            </li>
                            <li>
                                <a  class="nav-link" href="index.php?mode=displaynewmemberform">Add New Member</a> 
                            </li> 
                            <li>
                                <a  class="nav-link" href="index.php?mode=displaynewmovieform">Add New Movie</a> 
                            </li> 
                            <li class="nav-item ">
                                <a class="nav-link" href="index.php?mode=selectmember">Update Member Information</a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="index.php?mode=selectmovie">Update Movie Information</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?mode=logout">Sign Out</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
            <?php
                try {
                    // Define variables and assign their default values
                    $mode = ""; // default value for the switch statement

                    if(isset($_GET['mode']))
                        $mode = $_GET['mode'];

                    $parameterValues = null; // default values named parameters
                    $pageTitle = ""; // define a title for each output
                    $columns = array(); // define an array of column labels for a table header
                    
                    if(!isset($_SESSION["username"]) && !(isset($_POST["password"]))) {
                        // User is trying to access the page without signing in. Display the login page
                        if($mode && $mode != "logout")
                            echo "You are not signed in!";
                        include("loginForm.html");
    
                        // close the HTML tags and exit
                        echo "</div></body></html>";
                        exit();
                    }
                    
                    switch ($mode) {
                        case "login": // read login information
                            $username = (isset($_POST["username"])) ? $_POST["username"] : "-1";
                            $password = (isset($_POST["password"])) ? $_POST["password"] : "-1";

                            // Define SQL statement
                            $sql = "SELECT * from `admin` where `username` = :username and `password` = :password";

                            // Use md5( ) method to encrypt the password
                            $parameters = [":username" => $username, ":password" => md5($password)];

                            // Execute the SQL statement
                            $stm = $db->prepare($sql);
                            $stm->execute($parameters);
                            $result = $stm->fetch();

                            // validate the user
                            if (isset($result) && isset($result["username"])) {
                                // Valid user. Store the memberId using a session variable
                                $_SESSION["username"] = $result["username"];
                                $_SESSION["password"] = $result["password"];

                                echo "<p>Logged in as {$_SESSION["username"]}</p>";
                                echo "<h3>Welcome to Admin Page<h3>";
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
                                $pageTitle = "List of Movies";
                            }
                            
                            
                            // 3. Fetch result set
                            $resultSet = getAll($sql, $db, $parameterValues);
                            
                            // 4. Display result
                            $columns = array("Title", "Genre", "Year"); // three columns, same as the field names in the SQL statement
                            
                            displayResultSet($pageTitle, $resultSet, $columns);
                            break;
                        
                        case "displaynewmemberform":
                            //Display HTML form for new members
                            include("displaynewmemberform.html");
                            break;

                        case "displaynewmovieform":
                            //Display HTML form for new movies
                            include("displaynewmovieform.html");
                            break;

                        case "selectmember":
                            // Need to display a list of members so that we can select a member to update data
                            $sql = "select `memberID`, `firstName`, `lastName` from `members` order by `lastName`";
                            
                            // This SQL statement does not use any parameters. Use the default $parameterValues array.
                            $dataList = getAll($sql, $db, $parameterValues);
                            
                            // Define page title 
                            $pageTitle = "Select a Member from the List to Update Information";
                            
                            // Include a template to display a list of members
                            include('displayMemberList.php');
                            break;
                        
                        case "selectmovie":
                            // Need to display a list of members so that we can select a member to update data
                            $sql = "select * from `movies` order by `title`";

                            // This SQL statement does not use any parameters. Use the default $parameterValues array.
                            $dataList = getAll($sql, $db, $parameterValues);

                            // Define page title
                            $pageTitle = "Select a Movie from the List to Update Information";

                            // Include a template to display a list of members
                            include('displayMovieList.php');
                            break;

                        case 'addNewMember' : // add a new member
                            // Read input values
                            $firstName = "";
                            $lastName = "";
                            $phone = "";
                            $memberType = "";

                            if (isset($_POST['firstName'])) {
                                $firstName = $_POST['firstName'];
                            }
                            if (isset($_POST['lastName'])) {
                                $lastName = $_POST['lastName'];
                            }
                            if (isset($_POST['phone'])) {
                                $phone = $_POST['phone'];
                            }
                            if (isset($_POST['memberType'])) {
                                $memberType = $_POST['memberType'];
                            }
                            
                            /* if the first name or last name is empty then display
                            an error message. */
                            if ($firstName === '' || $lastName === '')
                                echo "Invalid data";
                            else {
                                // Define the SQL statement
                                $sql = "INSERT INTO `members`(firstName, lastName, phone, memberType)
                                        VALUES (:firstName, :lastName, :phone, :memberType)";
                                
                                // Define values for the named parameters
                                $parameters = [":firstName" => $firstName,
                                                ":lastName" => $lastName,
                                                ":phone" =>$phone, 
                                                ":memberType" =>$memberType];
                            
                                // Prepare SQL statement
                                $stm =$db->prepare($sql);

                                // execute the statement object
                                $stm->execute($parameters);

                                // display an appropriate message
                                echo "<p>Added a new member</p>";
                            }
                            break;

                        case 'addNewMovie' : // add a new member
                            // Read input values
                            $title = "";
                            $type = "";
                            $year = "";

                            if (isset($_POST['title'])) {
                                $title = $_POST['title'];
                            }
                            if (isset($_POST['genre'])) {
                                $type = $_POST['genre'];
                            }
                            if (isset($_POST['year'])) {
                                $year = $_POST['year'];
                            }
                            
                            /* if the first name or last name is empty then display
                            an error message. */
                            if ($title === '' || $type === '' || $year === '')
                                echo "Invalid data";
                            else {
                                // Define the SQL statement
                                $sql = "INSERT INTO `movies`(title, type, year)
                                        VALUES (:title, :type, :year)";

                                // Define values for the named parameters
                                $parameters = [":title" => $title,
                                                ":type" => $type,
                                                ":year" =>$year];
                            
                                // Prepare SQL statement
                                $stm =$db->prepare($sql);
    
                                // execute the statement object
                                $stm->execute($parameters);
    
                                // display an appropriate message
                                echo "<p>Added a new movie</p>";

                                echo "Title: ".$title."<br>";
                                echo "Type: ".$type."<br>";
                                echo "Year: ".$year."<br>";
                            }
                            break;

                        case "displayMemberInfo":
                            /* The request (link) sends two key=value pairs using the GET method: type and memberID */
                            
                            // By default, a link uses the GET method to send key/value pairs. Use the $_GET array to read the member id
                            $memberID = (isset($_GET['memberID'])) ? $_GET['memberID'] : null;
                            
                            // If the $memberID is null then display an error message and exit.
                            if (!isset($memberID)) {
                                echo "You have not selected a member!";
                                exit();
                            }
                            
                            /* Select member's data
                                The '*' selects everything from the database,
                                and then the condition checks all records where the memberID matches.
                                In this case, there should only be one record where the memberID matches,
                                so only one record will be returned by this SQL statement
                            */
                            $sql = "select * from `members` where `memberID` = :memberID";
                            
                            // Define values for named parameters
                            $parameterValues = array(":memberID" => $memberID);
                            
                            // Fetch data
                            $dataList = getAll($sql, $db, $parameterValues);
                            
                            // Define page title
                            $pageTitle = "Update Member Information";
                            
                            // Include a template to display the member's info
                            include('displayMemberInfo.php');
                            break;

                        case 'updateMemberInfo' : // Update selected member
                            // Read input values
                            $phone = "";
                            $memberType = "";
                            $memberID = "";
                            if (isset($_POST['phone'])) {
                                    $phone = $_POST['phone'];
                            }
                            if (isset($_POST['memberType'])) {
                                    $memberType = $_POST['memberType'];
                            }
                            if (isset($_POST['memberID'])) {
                                    $memberID = $_POST['memberID'];
                            }

                            /* if the memberID, phone,  or memberType is empty then display
                            an error message.
                            */
                            if ($memberID === '' || $phone === '' || $memberType === "") {
                                echo "Invalid data";
                                exit();
                            } 

                            // Define the SQL statement
                            $sql = "UPDATE  `members` SET `phone` = :phone, `memberType` = :memberType WHERE memberID = :memberID";
                            
                            // Define values for the named parameters
                            $parameterValues = array(":phone" => $phone,
                                    ":memberType" => $memberType,
                                        ":memberID" =>$memberID
                                );
                
                            // Prepare SQL statement
                            $stm =$db->prepare($sql);

                            // execute the statement object
                            $stm->execute($parameterValues);

                            // display an appropriate message
                            echo "Successfully updated selected member's information.";
                            break;

                        case "displayMovieInfo":
                            /* The request (link) sends two key=value pairs using the GET method: type and memberID */
                            
                            // By default, a link uses the GET method to send key/value pairs. Use the $_GET array to read the member id
                            $movieID = (isset($_GET['movieID'])) ? $_GET['movieID'] : null;
                            
                            // If the $memberID is null then display an error message and exit.
                            if (!isset($movieID)) {
                                echo "You have not selected a movie!";
                                exit();
                            }
                            
                            /* Select movie's data
                                The '*' selects everything from the database,
                                and then the condition checks all records where the movieID matches.
                                In this case, there should only be one record where the movieID matches,
                                so only one record will be returned by this SQL statement
                            */
                            $sql = "select * from `movies` where `movieID` = :movieID";
                            
                            // Define values for named parameters
                            $parameterValues = array(":movieID" => $movieID);
                            
                            // Fetch data
                            $dataList = getAll($sql, $db, $parameterValues);

                            // Second sql statement so that we can extract the genres to send to the displayMovieInfo.php file
                            $sql = "SELECT DISTINCT `type` from `movies` order by `type`"; 

                            // Define values for named parameters
                            $parameterValues = null;

                            //Fetch data
                            $genres = getAll($sql, $db, $parameterValues);
                            
                            // Define page title
                            $pageTitle = "Update Movie Information";
                            
                            // Include a template to display the movie's info
                            include('displayMovieInfo.php');
                            break;

                        case "updateMovieInfo": // Update selected movie
                            // Read input values
                            $title = "";
                            $movieType = "";
                            $movieID = "";
                            if (isset($_POST['title'])) {
                                    $title = $_POST['title'];
                            }
                            if (isset($_POST['movieType'])) {
                                    $movieType = $_POST['movieType'];
                            }
                            if (isset($_POST['movieID'])) {
                                    $movieID = $_POST['movieID'];
                            }

                            /* if the movieID, title,  or movieType is empty then display
                            an error message.
                            */
                            if ($movieID === '' || $title === '' || $movieType === "") {
                                echo "Invalid data";
                                exit();
                            } 

                            // Define the SQL statement
                            $sql = "UPDATE  `movies` SET `title` = :title, `type` = :movieType WHERE movieID = :movieID";
                            
                            // Define values for the named parameters
                            $parameterValues = array(":title" => $title,
                                        ":movieType" => $movieType,
                                        ":movieID" =>$movieID);
                
                            // Prepare SQL statement
                            $stm =$db->prepare($sql);

                            // execute the statement object
                            $stm->execute($parameterValues);

                            // display an appropriate message
                            echo "Successfully updated selected movie's information.";
                            break;

                        default: // Default page
                            if(isset($_SESSION["username"]))
                                echo "<p>Logged in as {$_SESSION["username"]}</p>";
                            echo "<h3>Welcome to Online Movie Club<h3>";
                            break;
                    }     
                }
                catch (PDOException $e) {
                    echo "Error!: ". $e->getMessage() . "<br/>";
                    die();
                }
                /* end main section */
            ?>
        </div>
    </body>
</html>

<?php
function displayResultSet($pageTitle, $resultSet, $columns) {
    // Use a table structure for displaying data
    echo $pageTitle;
    echo "<table class='table table-sm'>";
    // If the $columns array is not empty then display table header
    $numCols = count($columns); // find the size of the array
    if ($numCols > 0) {
        echo "<thead><tr>";
        foreach($columns as $c)
            echo "<th>{$c}</th>";
        echo "</thead>";
    }
    
    echo "<tbody>";
    foreach( $resultSet as $item){
        /* Each $item is an associative array.  Keys are the same as the field names 
            used in the SQL statement. */
        // Define a table row for each item in the $resultSet array
        echo "<tr>";
        
        // We can use a foreach loop to access each element of $item array
        foreach ($item as $key => $value)
            echo "<td>{$value}</td>";
        
        echo "</tr>";
    }
    echo "</tbody></table>";
}

function getAll($sql, $db, $parameterValues = null){
    /* Prepare the SQL statement. 
        The $db->prepare($sql) method returns an object. */
    $statement = $db->prepare($sql);

    // Execute prepared statement. The execute( ) method returns a resource object.
    $statement->execute($parameterValues);

    // Use the fetchAll( ) method to extract records from the result set.
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    
    return $result;
}
?>