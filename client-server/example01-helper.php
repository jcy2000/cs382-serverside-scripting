<?php
	// Define variables and assign default values
	$name = '';
	$status = '';
	$h1 = '';
	$h2 = '';
	$h3 = '';
	$major = '';
	$comments = '';

	/* HTML form is sending either 'fr', 'sp', 'jr', or 'sn' as the selected 'Status'.
	Need to store corresponding labels on the server side to produce an appropriate output.
	We can use an associative array to define labels for status
	*/
	$status_labels = array('fr'  => 'First year student',
							'sp' => 'Second year student',
							'jr' => 'Third year student',
							'sn' => 'Graduating class' );

	// Similarly, define an associative array to store labels for majors
	$major_labels = array('1' => 'Computer Science',
					'2' => 'MAGD', '3' => 'Math' , '4' => 'Econ',
					'5' => 'Other' );

	// Define an associative array to store labels for available hours
	$hour_labels = array('1' => '8:00 - 10:00am', '2' => '10:00 - noon',
					'3' => 'After 6:00pm' );

	/* Read input values into variables.
	It is a good practice to uise the isset( ) method to check user input values
	*/
	if (isset($_POST['fullname']))
		$name = $_POST['fullname'];

	/* If the name is empty, then display an error message */
	if ($name === '') {
		echo "<p>Name cannot be empty! </p>";
		exit();
	}


	if (isset($_POST['status'])) {
			$status = $_POST['status']; // $status is either 'fr', 'sp', 'jr', or 'sn'
			$statusLabel = $status_labels[$status];  // Read the corresponding label
	}
	if (isset($_POST['h1']))
			$h1 = $_POST['h1'];
	if (isset($_POST['h2']))
			$h2 = $_POST['h2'];
	if (isset($_POST['h3']))
			$h3 = $_POST['h3'];
	if (isset($_POST['comments']))
			$comments = $_POST['comments'];
	if (isset($_POST['major']))
			$major = $_POST['major'];

	// Prepare available hour labels
	$available_hours = array();
	for ($i=1; $i<4; $i++) {
		$hr = "h".$i;
		$hour = $$hr; // using variable variables
		if (isset($hour) && (int) $hour>0 && (int) $hour <4)
			$available_hours[] = $hour_labels[$hour];

	}
	$num_hours = count($available_hours);

	// display output
	echo "<table><tr>";
	echo "<td>Name: </td><td>{$name}</td>";
	echo "</tr>";
	echo "<tr><td>Status:</td><td>{$statusLabel}</td></tr>";
	echo "<tr><td>Major:</td><td>{$major_labels[$major]}</td></tr>";
	echo "<tr><td>Available hours:</td><td>";


	if ($num_hours >0)
		foreach($available_hours as $hr_label)
			echo $hr_label."<br/>";
			
	echo "</td></tr>";
	echo "<tr><td>Comments: </td><td>{$comments}</td></tr>";
	echo "</table>";
?>