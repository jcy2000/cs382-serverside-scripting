<?php
    /* This is a helper file to processing the net income for problem 4 of the midterm */
    $cartLength = 0;
    $cartHeight = 0;
    $distance = 0;
    define("WIDTH", 8);
    define("SAND_VOLUME", 50000);
    define("COST_PER_MILE", 20);

    if(isset($_POST)) {
        if(isset($_POST["cartLength"]))
            $cartLength = $_POST["cartLength"];
        if(isset($_POST["cartHeight"]))
            $cartHeight = $_POST["cartHeight"];
        if(isset($_POST["distance"]))
            $distance = $_POST["distance"];
    }

    // Cart Length must be between 20 and 60. Cart Height must be between 10 and 15. Distance must be greater than 0.
    if($cartLength < 20 || $cartLength > 60 || $cartHeight < 10 || $cartHeight > 15 || $distance < 0)
        exit("<h1 style='color: red'>Invalid Dimensions were entered.</h1>");
    
    $cartDimensions = $cartLength * $cartHeight * WIDTH;
    $numCarts = ceil(SAND_VOLUME / $cartDimensions);
    $cartCost = $numCarts * COST_PER_MILE;
    $totalCost = $cartCost * $distance;

    echo "<h1>Cart Dimensions:</h1>";
    echo "<h2>Length: ".$cartLength."</h2>";
    echo "<h2>Width: ".WIDTH."</h2>";
    echo "<h2>Height: ".$cartHeight."</h2>";
    echo "<h1>Amount of Sand: ".SAND_VOLUME." cubic feet</h1>";
    echo "<h1>Number of carts needed: ".$numCarts."</h1>";
    echo "<h1>Cost of Cart/Mile: ".COST_PER_MILE."</h1>";
    echo "<h1>Total Cost: ".$totalCost."</h1>";
?>