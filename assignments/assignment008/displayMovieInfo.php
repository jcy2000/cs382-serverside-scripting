<?php
    if (isset($pageTitle))
        echo "<h4>{$pageTitle}</h4>";
    
    // Check if the dataList is not empty
    if(empty($dataList)) {
        echo "There is no data";
        exit();
    }

    /* In this case, the SQL should return just one record matching the given movieID.
        Hence, $dataList is an array that consists of just one matching record
    */
    $movie = $dataList[0];

    // Display title of the selected movie
    echo "<p>Title: {$movie['title']}</p>";
?>
<!--Use an HTML form to display data-->
<form action="index.php?mode=updateMovieInfo" method="post">
    <table class="table" style="width: 500px;">
        <tbody>
            <tr>
                <th>Title</th>
                <td>
                    <input type="text" name="title" value="<?php echo $movie['title']; ?>" />
                </td>
            </tr>
            <tr>
                <th>Movie Type</th>
                <td>
                    <select name="movieType">
                        <?php
                            foreach($genres as $g) {
                                echo "<option value='{$g["type"]}'";

                                if($movie["type"] == $g["type"])
                                    echo "selected";
                                
                                echo ">{$g['type']}</option>";
                            }
                        ?>
                    </select>
                </td>
            </tr>
        </tbody>
    </table>
    <!-- Need to send movieID to the server using an input element (key=value ). 
        We can use a hidden field to define a key=value pair. A hidden field will not be displayed.
    -->
    <input type="hidden" name="movieID" value="<?php echo $movie['movieID']; ?>" />
    <p><button type="submit" class="btn btn-primary">Update Movie Information </button>
</form>