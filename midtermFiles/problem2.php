<?php
    /* This is a helper file to processing the net income for problem 2 of the midterm */
    $car_type = "";
    $time = 0;
    $covered = FALSE;

    // Verify if user input is valid
    if(isset($_POST)) {
        if(isset($_POST["category"]))
            $car_type = $_POST["category"];
        
        if(isset($_POST["numDays"]))
            $time = $_POST["numDays"];

        if(isset($_POST["coverage"]))
            $covered = $_POST["coverage"];
    }

    $cost = 0;

    switch($car_type) {
        case "car":
            $cost += ($time * 20);
            break;
        case "suv":
            $cost += ($time * 40);
            break;
        case "minivan":
            $cost += ($time * 50);
            break;
        default:
            exit("<h1 style='color: red;'>It seems like either no option was chosen or an option was chosen that the scripts were not updated for.</h1>
                    <h2 style='color: red;'>Consult HR or something, idk lol.</h2>");
    }

    if($covered)
        $cost += ($time * 20);
    
    echo "<h1>Car Type: ".$car_type."</h1>";
    echo "<h1>Time Rented: ".$time."</h1>";
    if($covered)
        echo "<h1>Coverage: Yes</h1>";
    else
        echo "<h1>Coverage: No</h1>";
    echo "<hr class='hrule'></hr>";
    echo "<h1>Total Cost: \$".$cost."</h1>";
?>