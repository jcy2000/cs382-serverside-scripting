<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>CS382 Assignment003</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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

            .container { 
                margin: 10px;
            }
        </style>
    </head>
    
    <body class="container">
        <?php
            $array2d = createArray();

            //Problem 1
            printItems($array2d);
            echo "<h1>Problem 1: Name, type, and price of each product</h1>";

            //Problem 2
            printItems($array2d, "all", 30);
            echo "<h1>Problem 2: Name, type, and price of each product over $30</h1>";

            //Problem 3
            printItems($array2d, "electronics", 30);
            echo "<h1>Problem 3: Name, type, and price of electronics over $30</h1>";

            //Problem 4
            printItems($array2d, "all", 0, true);
            echo "<h1>Problem 4: Name, type, price, and revenue of each product</h1>";

            //Problem 5
            printItems($array2d, "electronics", 0, true);
            echo "<h1>Problem 5: Name, type, price, and revenue of electronics</h1>";

            //End of Main

            function createArray() {
                return [
                    ['type' => 'electronics', 'name' => 'Audio Technica ATH-M50x'                    , 'price' => 119.99, 'quantity' => 2 ],
                    ['type' => 'electronics', 'name' => 'Sennheiser HD 202 II'                       , 'price' => 24.50 , 'quantity' => 5 ],
                    ['type' => 'electronics', 'name' => 'GPX HM3817DTBK Micro System'                , 'price' => 135.99, 'quantity' => 1 ],
                    ['type' => 'electronics', 'name' => 'Samsung MX-J630 2.0 Channel 230 Watt System', 'price' => 117.99, 'quantity' => 4 ],
                    ['type' => 'electronics', 'name' => 'M-Audio Bass Traveler'                      , 'price' => 29.00 , 'quantity' => 9 ],
                    ['type' => 'electronics', 'name' => 'HLED Strip light kit'                       , 'price' => 17.95 , 'quantity' => 5 ],
                    ['type' => 'movies'     , 'name' => 'Spectre'                                    , 'price' => '19.99', 'quantity' => 0 ],
                    ['type' => 'movies'     , 'name' => 'Finding Dory'                               , 'price' => 19.99 , 'quantity' => 4 ],
                    ['type' => 'movies'     , 'name' => 'Terminator: Genisys'                        , 'price' => 14.95 , 'quantity' => 3 ],
                    ['type' => 'movies'     , 'name' => 'Interstellar'                               , 'price' => 12.00 , 'quantity' => 4 ],
                    ['type' => 'movies'     , 'name' => 'Transformers: Age of Extinction'            , 'price' => 9.95  , 'quantity' => 7 ],
                    ['type' => 'movies'     , 'name' => 'Eye in the Sky'                             , 'price' => 14.95 , 'quantity' => 6 ],
                    ['type' => 'movies'     , 'name' => 'Venom'                                      , 'price' => '22.99', 'quantity' => 0],
                    ['type' => 'movies'     , 'name' => 'The spy who dumped me'                      , 'price' => 29.00 , 'quantity' => 8 ],
                    ['type' => 'movies'     , 'name' => 'Mamma Mia, Here We Go Again'                , 'price' => 22.99 , 'quantity' => 4 ],
                    ['type' => 'electronics', 'name' => 'M-Audio Bass Traveler'                      , 'price' => 29.00 , 'quantity' => 5 ],
                    ['type' => 'video-games', 'name' => 'Battlefield 1'                              , 'price' => 59.99 , 'quantity' => 3 ],
                    ['type' => 'video-games', 'name' => 'Overwatch'                                  , 'price' => 40.00 , 'quantity' => 1 ],
                    ['type' => 'video-games', 'name' => 'Gears of War 4'                             , 'price' => 59.99 , 'quantity' => 8 ],
                    ['type' => 'video-games', 'name' => 'Titanfall 2'                                , 'price' => 59.99 , 'quantity' => 7 ],
                    ['type' => 'video-games', 'name' => 'Sid Meier\'s Civilization VI '              , 'price' => 59.99 , 'quantity' => 4 ],
                    ['type' => 'video-games', 'name' => 'The Sims 4'                                 , 'price' => 39.99 , 'quantity' => 2 ],
                    ['type' => 'video-games', 'name' => 'Grand Theft Auto V'                         , 'price' => 59.99 , 'quantity' => 7 ]];
            }

            function printItems($array2d, $type = "all", $price = 0, $displayRevenue = false) {
                $table = "<table
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Price</th>";

                if($displayRevenue) {
                    $table .= "<th>Quantity</th>";
                    $table .= "<th>Revenue</th>";
                }
                    
                $table .= "</tr>";

                foreach($array2d as $array) {
                    $row = "<tr>";

                    if(($type == "all" || ($type == $array["type"])) && $price < $array["price"]) {
                        $row .= "<td>".$array["name"]."</td>";
                        $row .= "<td>".$array["type"]."</td>";
                        $row .= "<td>".$array["price"]."</td>";

                        if($displayRevenue) {
                            $row .= "<td>".$array["quantity"]."</td>";
                            $row .= "<td>".($array["price"] * $array["quantity"])."</td>";
                        }
                    }

                    $row .= "</tr>";
                    $table .= $row;
                }
                echo $table;
            }
        ?>
    </body>
</html>