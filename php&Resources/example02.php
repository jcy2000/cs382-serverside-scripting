<?php
$subject = "all";
if (isset($_POST) && isset($_POST["subject"])) {
    $subject = $_POST["subject"];
}
?>
<html>
<head>
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
</style>
</head>
<body>
<h3>Schedule of Classes</h3>
<form action="" method="post">
<p>Select subject: 
<select name="subject">
    <!--These php statements found within the option tags are asthetics. They do, however, help users identify
        what was selected previously. Run code to see what I mean, then delete the php statements and run again-->
    <option value="all" <?php if($subject === "all") {echo "selected";} ?>>All Subjects</option>
    <option value="COMPSCI" <?php if($subject === "COMPSCI") {echo "selected";} ?>>Computer Science</option>
    <option value="MATH" <?php if($subject === "MATH") {echo "selected";} ?> >Mathematics</option>
</select>
<button type="submit" class="button">Filter by Subject</button>
</p>
</form>
<?php

// Open the text file and read the list of schedules
$scheduleList = getTextData($subject);


displaySchedule($scheduleList);
    
   

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
            $list[] = $schedule;
        }
        
    } else {
    
        while ($schedule = fgetcsv($fp, 255, ',')) {
        
            // filter schedule by subject
            if(trim($schedule[1]) === $subject) {
                // add the schedule to the list
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