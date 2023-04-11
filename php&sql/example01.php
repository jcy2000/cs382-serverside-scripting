<?php
/*Covers using php to connect to a database */

include('examples-helper.php');

// check for db connection
if(isset($db))
        echo "Successfully Connected!";
else
        echo "Could not connect. :(";

?>