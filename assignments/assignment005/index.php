<?php
$genre = "All";
if(isset($_POST) && isset($_POST["genre"]))
    $genre = $_POST["genre"];
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Viewing a table with genres</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
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
            
            .button {
                background-color: #336699;
                border: none;
                color: white;
                padding: 10px 22px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                border-radius: 5px;
            }

            form {
                margin-bottom: 10px;
            }
        </style>
    </head>
    <body>
        <h3>List of Movies</h3>
        <form action="index.php" method="post">
            <div class="dropdown">
                <span>Select genre:</span>
                <select name="genre">
                    <option class="dropdown-item" <?php if($genre == "All") {echo "selected";} ?> value="All">All</option>
                    <option class="dropdown-item" <?php if($genre == "Action") {echo "selected";} ?> value="Action">Action</option>
                    <option class="dropdown-item" <?php if($genre == "Adventure") {echo "selected";} ?> value="Adventure">Adventure</option>
                    <option class="dropdown-item" <?php if($genre == "Animation") {echo "selected";} ?> value="Animation">Animation</option>
                    <option class="dropdown-item" <?php if($genre == "Comedy") {echo "selected";} ?> value="Comedy">Comedy</option>
                    <option class="dropdown-item" <?php if($genre == "Drama") {echo "selected";} ?> value="Drama">Drama</option>
                    <option class="dropdown-item" <?php if($genre == "Musical") {echo "selected";} ?> value="Musical">Musical</option>
                    <option class="dropdown-item" <?php if($genre == "Mystery") {echo "selected";} ?> value="Mystery">Mystery</option>
                    <option class="dropdown-item" <?php if($genre == "Romance") {echo "selected";} ?> value="Romance">Romance</option>
                    <option class="dropdown-item" <?php if($genre == "Sci-Fi") {echo "selected";} ?> value="Sci-Fi">Sci-Fi</option>
                    <option class="dropdown-item" <?php if($genre == "Suspense") {echo "selected";} ?> value="Suspense">Suspense</option>
                    <option class="dropdown-item" <?php if($genre == "Western") {echo "selected";} ?> value="Western">Western</option>
                </select>
                <button type="submit" class="btn btn-primary">Filter by Genre</button>
            </div>
        </form>

        <?php

            // Open the text file and read the list of movies
            $scheduleList = getTextData($genre);

            displaySchedule($scheduleList);
                
            // End main

            // Define functions
            function getTextData($genre) {
                $fp = fopen("../../resources/movielist.txt", "r");

                if (!$fp) {
                    echo "Could not open the file";
                }

                /* Each line contains information about each movie, separated by a comma.
                    Format: name, year, genre
                */
                $list = [];
                if ($genre == "All") {
                    while ($movie = fgetcsv($fp, 255, ',')) {
                        $list[] = $movie;
                    }
                }
                else {
                    while ($movie = fgetcsv($fp, 255, ',')) {
                    
                        // filter movie by genre
                        if(trim($movie[3]) == $genre) {
                            // add the movie to the list
                            // The empty brackets means that $movie is appended to $list
                            $list[] = $movie;
                        }
                    }
                }

                fclose($fp);
                return $list;
            }

            function displaySchedule($list) {
        ?>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Year</th>
                <tr>
            </thead>
            <tbody>
                <?php
                foreach($list as $movie) {
                    echo "<tr>";
                    echo "<td>{$movie[1]}</td>";
                    echo "<td>{$movie[2]}</td>";
                    echo "<td>{$movie[3]}</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </body>
</html>

<?php
}
?>