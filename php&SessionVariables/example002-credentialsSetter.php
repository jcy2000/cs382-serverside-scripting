<?php
    /*  This code sets up the username and passwords of members on the database by
        creating new columns and assignment those values right away.
    */
    
    include("examples-helper.php");
    // Define the SQL statement
    $sql = "select count(memberID) from `members`";

    /* Prepare the SQL statement. 
        The $db->prepare($sql) method returns an object. */
    $stm = $db->prepare($sql);

    // Prepare any parameters that will be used in the SQL statement
    $parameterValues=null;

    //Execute the SQL statement and put it into a variable
    $numMembers = $stm->execute($parameterValues);

    // Use the fetchAll( ) method to extract records from the result set.
    // When getting the count of variables, it's really weird and stores it as a key=>value pair with the key being the 'count(memberID)'.
    $data = $stm->fetchAll(PDO::FETCH_ASSOC);
    $numMembers = $data[0]["count(memberID)"];

    // Define the SQL statement. This statement will be used multiple times in the for-loop later in the code
    $sql = "UPDATE `members`  SET `username` = :username, `password` = :password WHERE memberID = :id";

    /* Prepare the SQL statement. 
        The $db->prepare($sql) method returns an object. */
    $stm = $db->prepare($sql);

    for ($i = 1; $i < $numMembers; $i++) {
        $username = "user".$i;
        $password = md5("password".$i);
        $parameterValues = [":username" => $username, ":password" => $password, ":id" => $i];
        $stm->execute($parameterValues);
    }

    echo "Done";
?>