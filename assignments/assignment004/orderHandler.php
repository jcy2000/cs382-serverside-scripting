
<?php
    /*
        $specs: associative array
            Contains the information of the computer system that user picked out.
            Formating is "name,price"
        $ea: associative array
            Extra Accessories that user picked out.
            Formating is "name,price"
        $info: associative array
            Information about the user such as name, email, and their comments
    */
    $specs = null; $info = null; $ea = null;
    define("TAX_RATE", .05);

    if(isset($_POST)) {
        if(isset($_POST["specs"]))
            $specs = $_POST["specs"];
        
        if(isset($_POST["ea"]))
            $ea = $_POST["ea"];

        if(isset($_POST["info"]))
            $info = $_POST["info"];

        // If the user failed to choose an operating system, do this
        if(!isset($specs["os"])) {
            echo "<p style='margin: 10px'>No Operating System was selected.</p>";
            echo "<a style='margin: 10px' href=index.html>Return</a>";
            exit;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Thank you!</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
                integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
        <style type="text/css">
            body {
                margin: 10px;
            }

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
        </style>
    </head>
    
    <body>
        <h1>Online Order Complete!</h1> <hr>
        <h2>Information</h2>
        <table>
            <tr>
                <th>Name</th>
                <td><?php echo $info["name"] ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?php echo $info["email"] ?></td>
            </tr>
            <tr>
                <th>Comments</th>
                <td><?php echo $info["comments"] ?></td>
            </tr>
        </table>

        <h2>You have selected the following system:</h2>
        <table style="margin-bottom: 50px;">
            <tr>
                <th>Operating System</th>
                <td><?php echo explode(",", $specs["os"])[0] ?></td>
            </tr>
            <tr>
                <th>Processor</th>
                <td><?php echo explode(",", $specs["processor"])[0] ?></td>
            </tr>
            <tr>
                <th>Memory</th>
                <td><?php echo explode(",", $specs["memory"])[0] ?></td>
            </tr>
            <tr>
                <th>Hard Disk</th>
                <td><?php echo explode(",", $specs["hd"])[0] ?></td>
            </tr>
            <tr>
                <th>Accessories</th>
                <td>
                    <?php
                        if(empty($ea))
                            echo "None";
                        else
                            foreach($ea as $key=>$value)
                                echo "<p style='margin: 0'>".$key."</p>";
                    ?>
                </td>
            </tr>
        </table>
        
        <table>
            <tr>
                <th><strong>Total Cost</strong></th>
                <td>
                    <?php
                        $sum = 0;
                        $sum += explode(",", $specs["processor"])[1] +
                                explode(",", $specs["memory"])[1] +
                                explode(",", $specs["hd"])[1];

                        if(!empty($ea))
                            foreach($ea as $key=>$value)
                                $sum += $value;

                        if($sum == 0)
                            $sum = 800;

                        echo "<strong>".$sum."</strong>";
                    ?>
                </td>
            </tr>
            <tr>
                <th>5% Taxes:</th>
                <td><?php echo $taxAmount = $sum * TAX_RATE ?></td>
            </tr>
            <tr>
                <th>Total Amount:</th>
                <td><?php echo $sum + $taxAmount ?></td>
            </tr>
        </table>
    </body>
</html>