<?php
    /*  Covers using php to connect to a database using the include function.
        Then it prepares a statement and executes it.
    */

    // Establish database connection
    include('examples-helper.php');

    try {

        // Prepare SQL statement
        $query = "SELECT title, type FROM `movies`";
        $statement = $db->prepare($query);

        /* Execute prepared statement. The execute( ) method returns a resource object.  */
        $statement->execute( );
        
    /*  Loop through the result set and read each row using the fetch( ) method of the resource object ($statement object).
        Read each row while there are records to be read.
    */
        while ($row = $statement->fetch()){
        /* Each $row is an associative array.  Keys are the same as the field names 
            used in the SQL statement: title and type. */
        echo "<p>Title: ".$row['title'].", Type: ".$row['type']."</p>";
        }

        $db = null; // clear connection
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
?>