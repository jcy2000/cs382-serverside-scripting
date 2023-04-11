<!doctype html>
 <html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>CS 382 client-server example 01</title>
    <style type="text/css">
        body {
            margin: 0px;
            padding: 10px;
            font-family: Verdana, sans-serif;
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
    <div class='container'>
    <!-- include a form -->
    <form action='http://localhost/CS382/client-server/example01-helper.php' method='post'>
        <table>
          <tbody>
            <tr><td>Name: </td>
                <td><input type='text' name='fullname'
                placeholder='Enter full name' /></td>
            </tr>
            <tr>
                <td>Status: </td>
                <td><!-- include a group of radio buttons -->
                    <input type='radio' name='status' value='fr'>First year student
                    <input type='radio' name='status' value='sp'>Sophomore
                    <input type='radio' name='status' value='jr'>Junior
                    <input type='radio' name='status' value='sn'>Senior
                </td>
            </tr>
            <tr>
                <td>Available hours</td>
                    <td><!-- include a checkbox -->
                    <input type='checkbox' name='h1' value='1' /> 8:00 - 10:00am <br/>
                    <input type='checkbox' name='h2' value='2' /> 10:00am - noon <br/>
                    <input type='checkbox' name='h3' value='3' /> after 6:00pm
                </td>
            </tr>

            <tr>
                <td>Major:</td>
                <td><!-- include a drop-down menu -->
                    <select name='major' >
                        <option value='1'>Computer Science</option>
                        <option value='2'>MAGD</option>
                        <option value='3'>Math</option>
                        <option value='4'>Econ</option>
                        <option value='5'>Other</option>
                    </select> 
                </td>
            </tr>
            <tr>
                <td>Comments: </td>
                <td><textarea name='comments'></textarea></td>
            </tr>
        </table>
        <p><button class='button' type='submit' >Send Data</button></p>

    </form>
    </div>

</body>
</html>