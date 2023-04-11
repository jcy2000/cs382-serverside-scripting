<?php
   //define variables and assign default values

   $length = 0;
   $width = 0;
   $area = 0;

   //Use the $_GET variable to access data sent using the GET method

   /* Use the appropriate key (name or label) to access its value
      example $_GET['length'] to access to value sent using the name 'length' and
      $_GET['width'] to access the value sent using the name 'width'.
      Use is_numeric( ) method to check if the input value is a numeric value.
   */

   // If the request includes the length and width, read the values
   if (isset($_GET['length']) && is_numeric($_GET['length']))
      $length = $_GET['length'];
   if(isset($_GET['width']) && is_numeric($_GET['width']))
      $width = $_GET['width'];

   // calculate the area
   $area = $length*$width;

   // display output
   echo "<p>Length: {$length} </p>\n";
   echo "<p>Width: ".$width." </p>\n";
   echo "<p>Area: $area  </p?\n";
?>