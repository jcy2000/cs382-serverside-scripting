<!--
    Using a Named Parameter to Fetch Different Results
    Note: when the Drama Movies link is clicked, the URL changes to 
    http://localhost/spring22/getMovieList.php?type=Drama
    and when the Adventure Movies link is clicked the URL changes to 
    http://localhost/spring22/getMovieList.php?type=Adventure
    In each of those cases, the browser sends a name=value pair to the server using the URL.
-->
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>CS382 - Example 07</title>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <style type="text/css">
    
    table { 
        border: 2px solid black; 
        border-collapse: collapse; 
        background: #fff; 
    }
   
    th, td { 
        border: 2px solid black; 
        padding: .2em .7em;   
        color: black; 
        font-size: 16px; 
        font-weight: 350; 
    } 
    
    thead th { 
        background-color: #336699; 
        color: #fff; 
        font-weight: bold;
        font-face: calibri;
    }
    
    .container { 
        margin: 10px;
    }
 </style>

    </head>
    <body>
        <?php
            // Establish database connection
            include('../pdo_connect.php');

            /* Check if the database connection is established. If not, exit the program. */
            if (!$db) {
                echo "Could not connect to the database";
                exit();
            }

            try {
                // Define the SQL statement
                $sql = "SELECT type FROM `movies` group by `type`";

                // Obtain data
                $genreList = getAll($sql, $db);

                // Iterate through the genres and create a link for each one
                foreach($genreList as $key=>$genre){
                    /* Each $movie is an associative array.  Keys are the same as the field names 
                        used in the SQL statement: title and type. */
                    echo "<p><a href='index.php?type=".$genre["type"]."'>".$genre["type"]." Movies</a></p>";
                }
            }
            catch(PDOException $e) {
                echo "Error!: ". $e->getMessage() . "<br/>";
                die();
            }
        ?>
        <div class='container'>
            <?php
                // Define variables
                $movieGenre = "";
                $parameterValues = null;
                
                //This if statement is the key to changing what is displayed
                if (isset($_GET['type'])) {
                    $movieGenre = $_GET['type'];

                try {
                    // Define the SQL statement
                    $sql = "SELECT title, type FROM `movies` where type=:type";
                    
                    // Define values for named parameters, if any
                    $parameterValues = array(":type" => $movieGenre);
                    // Obtain data
                    $movieList = getAll($sql, $db, $parameterValues);
                    
                    // Use a table structure for displaying data
                    echo "<h3>List of {$movieGenre} Movies</h2>";
                    echo "<table class='table'>
                            <thead><tr><th>Title</th><th>Genre</th></tr></thead>
                            <tbody>";
                    
                    foreach($movieList as $movie){
                        /* Each $movie is an associative array.  Keys are the same as the field names 
                            used in the SQL statement: title and type. */
                        echo "<tr><td>{$movie['title']}</td><td>{$movie['type']}</td></tr>";
                    }
                    echo "</table>";
                            
                    } catch (PDOException $e) {
                        echo "Error!: ". $e->getMessage() . "<br/>";
                        die();
                    }
                }
            ?>
        </div>
    </body>
</html>
<?php

function getAll($sql, $db, $parameterValues = null){
    /* Prepare the SQL statement. 
        The $db->prepare($sql) method returns an object.
    */
    $statement = $db->prepare($sql);

    /* Execute prepared statement. The execute( ) method returns a resource object.  */
    $statement->execute($parameterValues );

    /* Use the fetchAll( ) method to extract records from the result set.
    */
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    
    return $result;
}

?>