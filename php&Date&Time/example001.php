<?php
    /*  This shows how to use the date() and time() in PHP
        This specific method gets the date 10 days from now
     */

    $currentDate = date("Y-m-d");
    echo "<p>Current date: {$currentDate} </p>";
    // Find current year, month, and date
    $currentMonth  = date("m");  //  date("m") returns the current month as a string with leading zero (01 - 12)
    $currentYear   = date("Y");  //  date("Y") returns the current year
    $currentDate   = date("d");  //  date("d") returns the current day of the month, with a leading zero

    //Calculate the future date which is 10 days from the current date
    $numDays = 10;
    $futureDate = mktime(0,0,0, $currentMonth, $currentDate + $numDays, $currentYear);

    // Display the future date
    $fDay = date("Y-m-d", $futureDate);
    echo "<p>Future date: {$fDay} </p>";
?>