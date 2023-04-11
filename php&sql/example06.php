<?php
    /*  An unnamed parameter uses a question mark instead of named parameters to indicate
        the location of the parameter in the SQL statement. Then the bindValue method
        should be used to bind vales to these parameters by using integer values for the parameters.
    */
    include('examples-helper.php');

    $query = 'SELECT * from `movies` where `type` = ?';

    // Prepare sql statements
    $statement = $db->prepare($query);

    $statement->bindValue(1, 'Drama');

    // execute query
    $statement->execute();

    echo "Number of rows in the result set: ".$statement->rowCount()."<br/>\n";

    while($row = $statement->fetch())
        print($row['title']."<br>");
?>