<?php
    define("MILK_CHOCOLATE_PRICE", 2.9);
    define("ASSORTED_FINE_CHOCOLATE_PRICE", 4.59);
    define("ASSORTED_MILK_AND_DARK_CHOCOLATE_PRICE", 5.25);
    define("TAX_RATE", .05);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Online Order Form</title>
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
    
    input[type=text] { 
        text-align: right; 
        width: 200px; 
        color: #000;
    }
    
    input[type="number"] {
        width: 3em;
    }
    
    .button { 
        border: 1px solid #273746; 
        border-radius: 5px; 
        padding: 4px; 
        background-color: #273746; 
        color: #fff; 
    }
    
    .default {
        background-color: #fff; 
        color: #000;
    }
    
    .container { 
        margin: 10px;
    }
    </style>
  </head>
  <body class="container-fluid">
  
  <h4>Online Order Form</h4>
    <form action="index.php" method="post">
    <table class="table">
        <thead>
            <tr>  
                <th >Product</th>
                <th >Quantity</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Milk Chocolate</td>
                <td><input type="number" name="milkchocolate" min="0" required /> </td>
            </tr>
            <tr>
                <td>Assorted Fine Chocolate</td>
                <td><input type="number" name="assortedfine"  min="0" required/> </td>
            </tr>
            <tr>
                <td>Assorted Milk and Dark Chocolate</td>
                <td><input type="number" name="assortedmilk"  min="0" required/> </td>
            </tr>        
        </tbody>
    </table>
    <p>
        <input type="submit" value="Submit" class="button">
        <input type="reset" value="Clear" class="button default">
    </p>
    </form>

    <?php
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            echo "<p>Number of milk chocolates: ".$_POST["milkchocolate"]."</p>";
            echo "<p>Number of assorted fine chocolates: ".$_POST["assortedfine"]."</p>";
            echo "<p>Number of assorted milk and dark chocolates:".$_POST["assortedmilk"]."</p>";

            $totalCost = ($_POST["milkchocolate"] * MILK_CHOCOLATE_PRICE) +
                            ($_POST["assortedfine"] * ASSORTED_FINE_CHOCOLATE_PRICE) +
                            ($_POST["assortedmilk"] * ASSORTED_MILK_AND_DARK_CHOCOLATE_PRICE);

            $taxCost = round($totalCost * TAX_RATE, 2);

            echo "<p>Total cost: \$".$totalCost."</p>";
            echo "<p>5% Taxes: \$".$taxCost."</p>";
            echo "<p>Total amount: \$".($totalCost + $taxCost)."</p>";

        }
    ?>
  </body>
</html>