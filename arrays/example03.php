<!--
    Example code to create a table using a associative array.
    This one uses a foreach loop instead of a for-loop
-->
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
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

    
 <h4>Example 2: Semester Plan</h4>
 <?php
    // Define a two-dimensional associative array
    $semesterPlan = [["subject" =>  "COMPSCI", "course" => 382, "credits" => 3, "category" => "Elective"], 
                ["subject" =>  "COMPSCI", "course" => 223, "credits" => 3, "category" => "Core"],
                ["subject" =>  "MATH", "course" => 250, "credits" => 5, "category" => "Unique"]
            ];
    
    ?>
  <table class="table">
  <thead>
    <tr>
      
      <th >Subject</th>
      <th >Course#</th>
      <th>Credits</th>
      <th>Category</th>
    </tr>
  </thead>
    <tbody>
      <!-- use PHP to generate each table row 
            This example uses an indexed array.
            There are four cells (columns) in each row.
      <tr><td>COMPSCI</td><td>382</td><td>3</td><td>Elective</td></tr>
      <tr><td>COMPSCI</td><td>223</td><td>3</td><td>Core</td></tr>
      <tr><td>MATH</td><td>250</td><td>5</td><td>Unique</td></tr>
      -->
      <?php
        foreach ($semesterPlan as $s) {
            $tRow = "<tr>";
            /* Each element $s is an associative array. 
               Use a loop to append table cells to $tRow string using elements of 
               the array $s.
            */
             foreach($s as $key => $value) {
                $tRow .= "<td>".$value."</td>";
             }
             // close the tr element
             $tRow .= "</tr>";
             // Display table row
             echo $tRow;
        }
        ?>
    </tbody>
</table>

  </body>
</html>