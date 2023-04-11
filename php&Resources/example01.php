<?php
// This script accepts GET requests
$subject = "all";
if (isset($_GET) && isset($_GET["subject"])) {
    $subject = $_GET["subject"];
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>PHP And Resources Example 1</title>
        <style type="text/css">
            
            table { 
                border: 1px solid black; 
                border-collapse: collapse; 
                background: #fff; 
            }
            
            th, td { 
                border: 1px solid black; 
                padding: .2em .7em;   
                color: #000;
                font-size: 16px; 
                font-weight: 400; 
            } 
            
            thead th { 
                background-color: #1A466A; 
                color: #fff; 
                font-weight: bold;  
            }
            
            .button {
                background-color: #336699;
                border: none;
                color: white;
                padding: 10px 22px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                border-radius: 5px;
            }
            
            .link {
                    padding: 10px 20px;
            }
        </style>
    </head>
    <body>
        <h3>Schedule of Classes</h3>

        <p>
            <span class="link"><a href="example01.php?subject=all">All subjects</a></span>
            <span class="link"><a href="example01.php?subject=COMPSCI">Computer Science</a></span>
            <span class="link"><a href="example01.php?subject=MATH">Mathematics</a></span>
        </p>

        <?php

        // Open the text file and read the list of schedules
        $scheduleList = getTextData($subject);

        displaySchedule($scheduleList);
            
        // End main

        // Define functions

        function getTextData($subject) {
            $fp = fopen("../resources/fall22schedule.txt", "r");

            if (!$fp) {
                echo "Could not open the file";
            }

            /* Each line contains information about each course section, separated by a comma.
                Format: id, subject, number, section, time, instructor, location
                Step 1: Read each line and separate data into an array using the fgetcsv( ) method.
            */    
            
            $list = [];
            if ($subject === "all") {
                while ($schedule = fgetcsv($fp, 255, ',')) {
                    // The empty brackets means that $schedule is appended to $list
                    $list[] = $schedule;
                }
                
            } else {
            
                while ($schedule = fgetcsv($fp, 255, ',')) {
                
                    // filter schedule by subject
                    if(trim($schedule[1]) === $subject) {
                        // add the schedule to the list
                        // The empty brackets means that $schedule is appended to $list
                            $list[] = $schedule;
                    }
                }
                
            }
            fclose($fp);
            return $list;
        }

        function displaySchedule($list) {
        ?>
        <table>
            <thead>
                <tr>
                    <th>Course</th>
                    <th>Section</th>
                    <th>Instructor</th>
                    <th>Time</th>
                    <th>Location</th>
                <tr>
            </thead>
            <tbody>
        <?php
        foreach($list as $schedule) {
            echo "<tr>";
            echo "<td>{$schedule[1]} {$schedule[2]}</td>";
            echo "<td>{$schedule[3]}</td>";
            echo "<td>{$schedule[5]}</td>";
            echo "<td>{$schedule[4]}</td>";
            echo "<td>{$schedule[6]}</td>";
            echo "</tr>";
        }
        ?>
            </tbody>
        </table>
    </body>
</html>

<?php
}
?>