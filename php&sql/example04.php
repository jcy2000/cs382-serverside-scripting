<?php
/*  Covers prepared statements with parameters. bindValue and bindparam are part of it.
    Also goes over rowCount
*/

// Create database connection
include('examples-helper.php');

try {
    $query = 'SELECT * from `movies` where `year` > :year';

    // Prepare sql statements
    $statement = $db->prepare($query);

    // Bind values to parameters
    $statement->bindValue(':year', '2016');

    // execute query
    $statement->execute();

    //This tells you how many rows were affected by the previous SQL statement
    echo "Number of rows in the result set ".$statement->rowCount()."<br/>\n";

    while($row = $statement->fetch()) {
        // Each $row is an associative row
        print($row['title']."<br>\n");
    }

    $statement->closeCursor();
    $db = null;
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>\n";
    die();
}