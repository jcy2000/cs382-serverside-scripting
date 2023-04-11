<!--
    The key thing that this helper php file does is set up the variable "$db".
    This is mainly to allow other php files to utilize this one and reduce code
    size when the other php files call "include(examples-helepr.php);"
-->
<?php
    $user = 'root';
    $pass = ''; // default password is a blank string
    $dsn='mysql:host=localhost;dbname=moviestore';
    try {
        $db = new PDO($dsn, $user, $pass);
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
?>