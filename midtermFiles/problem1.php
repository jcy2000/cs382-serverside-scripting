<?php
    /* This is a helper file to processing the net income for problem 1 of the midterm */
    $gross_income = 0;
    $num_dependants = 0;

    // Verify if user input is valid
    if(isset($_POST)) {
        if(isset($_POST["grossIncome"]))
            $gross_income = floatval($_POST["grossIncome"]);
        
        if(isset($_POST["dependents"]))
            $num_dependants = $_POST["dependents"];
    }

    if($gross_income == 0)
        exit("<h1 style='color: red;'>No gross income was entered.</h1>");

    switch($num_dependants) {
        case 0:
            $tax_rate = 33;
            break;
        case 1:
            $tax_rate = 25;
            break;
        case 2:
            $tax_rate = 18;
            break;
        case 3:
            $tax_rate = 15;
            break;
        default:
            $tax_rate = 10;
    }

    $tax_amount = $gross_income * floatval($tax_rate)/100;
    $net_income = $gross_income - $tax_amount;

    echo "<h1>Gross Income: \$".$gross_income."</h1>";
    echo "<h1>Tax Rate: ".$tax_rate."%</h1>";
    echo "<h1>Tax Amount: \$".$tax_amount."</h1>";
    echo "<h1>Net Income: \$".$net_income."</h1>";
?>
