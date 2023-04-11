<?php
    /*  This shows how to use the date() and time() in PHP
        This specific method gets the amount of days there are until a certain date.
        1. Get the current date.
        2. Calculate the due date. Each movie is due by 6:00pm on the due date.
    */

    // 1. find the number of seconds between now and the January 1 1970 00:00:00 GMT.
    $now = time();
    
    // 2. Find the current year
    $currentYear  = date("Y"); // date("Y") returns the current year

    /* 3. use maketime() function to find the number of seconds between your birthday and the January 1 1970 00:00:00 GMT.
    Syntax: mktime(hour, minute, second, month, day, year) */
    $birthDate = mktime(0, 0, 0, 1, 1, $currentYear + 1);

    // 4. find the number of seconds between now and your birdhday 
    $diff = $birthDate - $now;
    
    /* 5. Divide the number of seconds by the number of seconds per day to find the number of days left.
    Use ceil() method to round it up to the next integer. */
    $days = ceil($diff/60/60/24);

    // Read the current date. Format: yyyy-mm-dd
    $currentDate = date("Y-m-d");
    
    // Define the birthday
    $chosenDate = date("Y-m-d", $birthDate);
    
    // Display values
    echo "<p>Today is {$currentDate} <br/>";
    echo "Chosen date is {$chosenDate} <br/>";
    echo "Number of days until next birthday: {$days}</p> ";
?>