<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Calculate volume</title>
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
            
            .container { 
                margin: 10px;
            }
        </style>
    
    </head>
    <body>
        <div class="container-fluid">
            <h2> Calculate the Volume of a Box</h2>
            <!-- define a form to send data -->
            <form action='http://localhost/cs382/client-server/calculateVolume.php' method='post'>
                <table class='table'>
                    <tr>
                        <th>Length:</th>
                        <td>
                            <input type='number' name='length' required/>
                        </td>
                    </tr>
                    <tr>
                        <th>Width:</th>
                        <td>
                            <input type='number' name='width' required/>
                        </td>
                    </tr>
                    <tr>
                        <th>Height:</th>
                        <td>
                            <input type='number' name='height' required/>
                        </td>
                    </tr>
                </table>
                <p><button class='button' type='submit'>Calculate Volume</button></p>
            </form>
        </div>
    </body>
</html>