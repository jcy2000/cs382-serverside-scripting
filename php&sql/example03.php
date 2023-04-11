<?php
// Establish database connection
include('examples-helper.php');

/* Check if the database connection is established. If not, exit the program. */
if (!$db) {
    echo "Could not connect to the database";
    exit();
}

try {
    // Define the SQL statement
    $sql = "SELECT title, type FROM `movies` where type='Drama'";

    // Obtain data
    $movieList = getAll($sql, $db);
    
    // Display data
    foreach( $movieList as $movie){
        /* Each $movie is an associative array.  Keys are the same as the field names 
            used in the SQL statement: title and type. */
        echo "<p>Title: ".$movie['title'].", Type: ".$movie['type']."</p>";
    }
         
} catch (PDOException $e) {
    echo "Error!: ". $e->getMessage() . "<br/>";
    die();
}

function getAll($sql, $db){
    /* Prepare the SQL statement. 
        The $db->prepare($sql) method returns an object.
    */
    $statement = $db->prepare($sql);

    /* Execute prepared statement. The execute( ) method returns a resource object.  */
    $statement->execute( );

    /* Use the fetchAll( ) method to extract records from the result set.
    */
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    
    return $result;
}