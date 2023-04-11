<?php
// Define variables and assign their default values

$length = 0;
$width = 0;
$height = 0;

//Use the $_POST variable to access data sent using the POST method

/* Use the appropriate key (name or label) to access its value
example $_POST['length'] to access to value sent using the
data stream 'length=n'.

   These keys must be the same as the name attributes defined in the XHTML web form
*/

if (isset($_POST['length']) && is_numeric($_POST['length'])){
 // read the length
 $length = $_POST['length'];
}
if (isset($_POST['width']) && is_numeric($_POST['width'])){
 // read the width
 $width = $_POST['width'];
}
if (isset($_POST['height']) && is_numeric($_POST['height'])){
 // read the width
 $height = $_POST['height'];
}

// calculate the volume
$volume = $length*$width*$height;

// display output
echo "<p>Length: {$length} </p>\n";
echo "<p>Width: ".$width." </p>\n";
echo "<p>Height: ".$height." </p>\n";
echo "<p>Volume: $volume </p?\n";
?>