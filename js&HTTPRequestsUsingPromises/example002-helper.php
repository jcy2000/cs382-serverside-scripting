<?php
    /*This script sends information needed to update part of an existing document via XMLHttpRequest call.
    Therefore, there should be only one echo statement in the PHP script. HTTP requests should be restricted.
    The Access-Control properties can be used to restrict access to web services.
    In this example, we let requests come from any domain, using '*'.
    The key thing to note here is how we are allowing for cross-domain access control.
    Not exactly too sure what these mean. Just realized that you can't comment before the php tag
    or when you call this file from a Promise object, it doesn't run properly.
    */

    //Include headers for cross-domain access control.
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, OPTIONS, POST, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, , Authorization, X-Requested-With");

    // Read input values
    $length = 0;
    $width = 0;
    $area = 0;

    if (isset($_GET['boxLength']) && isset($_GET['boxWidth']))
    {
        $length = $_GET['boxLength'];
        $width = $_GET['boxWidth'];

        // Validate data
        if (is_numeric($length) && is_numeric($width) && $length >= 0 && $width >=0 ){
            // calculate the area
            $area = $width*$length;
        }
    }

    // Output result
    // NOTE: this is the only output (echo) statement in the whole script. Refer to top for more info.
    echo $area;
?>