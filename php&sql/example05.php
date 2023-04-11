<?php
    /*   It is possible to use the same prepared statement multiple times,
        with different values.
    */

    // Create database connection
    include('examples-helper.php');
    try {
        $query = 'SELECT * from `movies` where `type` = :type';

        // Prepare sql statements
        $statement = $db->prepare($query);

        // Define a  value for the parameter and obtain a result set
        $statement->bindValue(':type', 'Drama');

        // execute query
        $statement->execute();

        //Tells you how many rows were affected by the previous sql statement
        echo "Number of rows in the result set: ".$statement->rowCount()."<br/>\n";

        while($row = $statement->fetch()) {
            // Each $row is an associative row 
            print($row['title']."<br>");
        }

    // Define another value and obtain the corresponding result set
        $statement->bindValue(':type', 'Ad venture');

        // execute query
        $statement->execute();

        //Tells you how many rows were affected by the previous sql statement
        echo "Number of rows in the result set: ".$statement->rowCount()."\n";

        while($row = $statement->fetch()) {
            // Each $row is an associative row 
            print($row['title']."<br>");
        }

    

    // Close the connection to the server
        $statement->closeCursor(); 
        $db = null;

    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
?>