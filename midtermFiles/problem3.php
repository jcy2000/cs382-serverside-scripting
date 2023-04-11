<?php
    /* This is a helper file to processing the net income for problem 3 of the midterm */
    $preferred = "";
    $regular = "";
    $mode = "";

    if(isset($_POST)) {
        if(isset($_POST["Preferred"]))
            $preferred = $_POST["Preferred"];
        
        if(isset($_POST["Regular"]))
            $regular = $_POST["Regular"];
    }

    if($preferred)
        if($regular)
            $mode = "All";
        else
            $mode = "Preferred";
    else
        if($regular)
            $mode = "Regular";
        else
            exit("<h1 style='color: red;'>Neither the preferrred or regular checkbox was checked. Please try again.");

    $file = fopen("../resources/members.txt", "r");

    if(!$file)
        echo "Could not open the file.";

    $table = "<table>
                <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Member Type</th>
                </tr>";
    
    $counter = 0;
    while(!feof($file)) {
        $rowData = fgetcsv($file);
        switch($mode) {
            case "All":
                $row = createRow($rowData);
                $table .= $row;
                break;
            case "Regular":
                if($rowData[4] == "Regular") {
                    $row = createRow($rowData);
                    $table .= $row;
                }
                break;
            case "Preferred":
                if($rowData[4] == "Preferred") {
                    $row = createRow($rowData);
                    $table .= $row;
                }
                break;
            default:
                echo "Nothing happened";
        }
    }

    $table .= "</table>";
    echo $table;

    //end main

    function createRow($rowData) {
        $row = "<tr>";
        $row .="<td>".$rowData[1]." ".$rowData[2]."</td>";
        $row .="<td>".$rowData[3]."</td>";
        $row .="<td>".$rowData[4]."</td>";
        $row .= "</tr>";
        return $row;
    }
?>