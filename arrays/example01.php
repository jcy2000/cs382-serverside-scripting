<!--
    Example code to create a table using a numerically-indexed array.
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
  <?php 
  // Define an array
  $enrollment = array(
    array('CS172', 55, 70),
    array('CS174', 47, 70),
    array('CS382', 35, 35)

    );

 ?>
  <h4>Example 1: Enrollment Data</h4>
  <table class="table">
  <thead>
    <tr>
      
      <th >Course</th>
      <th >Enrolled</th>
      <th>Capacity</th>
    </tr>
  </thead>
    <tbody>
      <!-- use PHP to generate each table row
          This example uses an indexed array.
          There are three cells (columns) in each row.
      Hence, we need to generate the following HTML structure for each course:
            <tr><td>CS172</td><td>55</td><td>70</td></tr>
            <tr><td>CS174</td><td>47</td><td>70</td></tr>
            <tr><td>CS382</td><td>35</td><td>35</td></tr>
      -->
      <?php
        foreach ($enrollment as $course) {
            $tRow = "<tr>";
            /* Each element( $course ) is an array. 
               Use a loop to append table cells to $tRow string using elements of 
               the $course array.
            */
             foreach($course as $c) {
                $tRow .= "<td>".$c."</td>";
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