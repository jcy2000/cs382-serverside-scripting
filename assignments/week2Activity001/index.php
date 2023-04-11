<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <!-- Set the viewport so this responsive site displays correctly on mobile devices -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CS 382 Week 2 Activity 1</title>
    </head>
    <body>
        <?php
            echo "<h1>Problem 1</h1>";
            $num1 = 10;
            $num2 = 20;

            echo "<p>Number 1: ".$num1."</p>";
            echo "<p>Number 2: ".$num2."</p>";

            echo "<p>Sum: ".($num1 + $num2)."</p>";
            echo "<p>Difference: ".(abs($num1 - $num2))."</p>";
            echo "<p>Product: ".($num1 * $num2);

            echo "<hr>";

            //Problem 2
            echo "<h1>Problem 2</h1>";
            $array = [];

            for($i = 0; $i < 10; $i++)
                $array[$i] = rand(1, 30);

            do {
                $array = array_unique($array);

                if(count($array) < 10)
                    $array[] = rand(1, 30);
            } while(count($array) < 10);

            foreach($array as $i) {
                echo "<p>Number: ".$i.", Squared:".pow($i, 2);
            }

            echo "<hr>";

            //Problem 3
            echo "<h1>Problem 3</h1>";
            $array = [];

            for($i = 0; $i < 10; $i++)
                $array[$i] = rand(-50, 50);

            if(count(array_unique($array)) == count($array))
                $array[0] = $array[rand(0, count($array) - 1)];

            sort($array);
            print_r($array);

            echo "<hr>";

            //Problem 4
            echo "<h1>Problem 4</h1>";
            echo "Sum of array in Problem 3: ".array_sum($array);
            

        ?>
    </body>
</html>