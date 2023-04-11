<!DOCTYPE html>
<!--
    Using a Switch Statement to Process Different User Requests via a Single Server-side Script
-->
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <title>CS382 - Example 08</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>
    <body>
        <div class='container-fluid'>
            <!-- include page content -->
            <?php
                // Establish database connection
                include("examples-helper.php");

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
                                <a class="nav-link" href="example08.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="example08.php?mode=members">Members</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="example08.php?mode=movies&genre=all">All Movies</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="example08.php?mode=movies&genre=Drama">Drama Movies</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
            <?php
                // Define variables and assign their default values
                $mode = ""; // default value for the switch statement
                $parameterValues = null; // default values named parameters
                $pageTitle = ""; // define a title for each output
                $columns = array(); // define an array of column labels for a table header
                
                try {
                    if (isset($_GET['mode'])) {
                        $mode = $_GET['mode'];
                    }
                    
                    switch ($mode) {
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
                                $pageTitle = "List of movies";
                            }
                            
                            
                            // 3. Fetch result set
                            $resultSet = getAll($sql, $db, $parameterValues);
                            
                            // 4. Display result
                            $columns = array("Title", "Genre", "Year"); // three columns, same as the field names in the SQL statement
                            
                            displayResultSet($pageTitle, $resultSet, $columns);
                            break;
                            
                        default: // Default page
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
                foreach($columns as $c) {
                    echo "<th>{$c}</th>";
                }
                echo "</thead>";
            }
            
            echo "<tbody>";
            foreach( $resultSet as $item){
                /* Each $item is an associative array.  Keys are the same as the field names 
                    used in the SQL statement.
                */
                // Define a table row for each item in the $resultSet array
                echo "<tr>";
                
                // We can use a foreach loop to access each element of $item array
                foreach ($item as $key => $value) {
                    echo "<td>{$value}</td>";
                }
                
                echo "</tr>";
                
            }
            echo "</tbody></table>";
}

function getAll($sql, $db, $parameterValues = null){
    /* Prepare the SQL statement. 
        The $db->prepare($sql) method returns an object. */
    $statement = $db->prepare($sql);

    // Execute prepared statement. The execute( ) method returns a resource object.
    $statement->execute($parameterValues );

    // Use the fetchAll( ) method to extract records from the result set.
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    
    return $result;
}
?>