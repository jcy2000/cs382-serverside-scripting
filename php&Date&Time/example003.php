<!DOCTYPE html>
<html lang="en">
    <head>
        <title>CS 382 - PHP&Date&Time - Example003</title>
        <meta charset="utf-8">
        <meta name="viewpoint" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    </head>
    <body>
        <h4>Select a movie</h4>
        <ul>
            <!--Notice how these href attributes are partially incomplete.
            This is actually a faster way to have the link redirect to itself rather than putting in the whole directory-->
            <li>
                <a href='?mode=reserve&movieID=1&days=3'>Star Wars 3-day rents</a>
            </li>
            <li>
                <a href='?mode=reserve&movieID=2&days=7'>Lion King 7-day rental</a>
            </li>
        </ul>
        <?php
            $mode = null;
            // Read user input
            if (isset($_GET['mode']))
                $mode = $_GET['mode'];

            // Read the request type: movie genre
            $movieId = (isset($_GET['movieID'])) ? $_GET['movieID']: '-1';
            $numdays = (isset($_GET['days'])) ? $_GET['days']: '-1';
            if ($movieId === '-1' && $numdays === '-1') {
                // echo "Please select a movie";
                exit();
            }
            
            /*  Calculate due date.
            1. Get the current date.
            2. Calculate the due date. Each movie is due by 6:00pm on the due date. */

            // 1. find the current date
                $currentMonth  = date("m");  //  date("m") returns the current month as a string with leading zero (01 - 12)
                $currentYear   = date("Y");  //  date("Y") returns the current year
                $currentDate   = date("d");  //  date("d") returns the current day of the month, with a leading zero

            /* 2. use mktime() function to calculate a date: 3 days from the current date
            Syntax: mktime(hour, minute, second, month, day, year) */
            $dueDateTimeStamp = mktime(18, 0, 0, $currentMonth, $currentDate + $numdays, $currentYear);
            
            /* mktime( ) method returns the number of seconds between the due date and January 1 1970 00:00:00 GMT.
            Use the date( ) method to display the time using a human-readerble format. */
            $dueDate = date("Y-m-d", $dueDateTimeStamp);
            
            $title = ($movieId == 1) ? "Star Wars" : "Lion King";
            echo "<p>Movie selected : {$title} </p>";
            echo "<p>Due date: {$dueDate}</p>";
        ?>
    </body>
</html>