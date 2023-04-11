<?php
    /* Servers usually allow GET requests from other domains but allow POST requests only
    from the same domain by default.

    Include headers for cross-domain access control 
    */

    header("Access-Control-Allow-Origin: *");
    // Allow the following request methods
    header("Access-Control-Allow-Methods: GET, OPTIONS, POST, PUT, DELETE");
    // Define other parameters
    header("Access-Control-Allow-Headers: Content-Type, , Authorization, X-Requested-With");
    // include examples-helper.php file
    include('examples-helper.php');


    /* Define variables and assign default values */
    $parameterValues = null; // Set the $parameterValues to null
    $type = null;
    $error = "Invalid request";

    /* Most of the page requests are sent using the GET method
    The 'type' defines the particular task requested.
    Read user input 'type' */
    if(isset($_GET['type']))
        $type = $_GET['type'];

    // Define response based on the user request (input)
    switch ($type) {
        case 'movies':
            // Read the request type: movie genre
            $genre = (isset($_GET['genre'])) ? $_GET['genre'] : '-1';
            if ($genre === '-1')
                $response = $error;
            else {
                if($genre === 'All' ) {
                    // Display a list of all the movies
                    $sql = "SELECT title, year, type FROM `movies` order by title, year";
                } 
                else {
                    // Display a list of movies based on the user selection
                    $sql = "SELECT title, year, type FROM `movies` WHERE type = :genre";

                    // Define value(s) for 'named' parameters
                    $parameterValues = array(':genre' => $genre);
                }

                // Execute SQL statement and obtain data
                $response = getAllRecords($sql, $db, $parameterValues);
            }

            break;

        case 'members' :
            // Define SQL statement
            $sql = "SELECT * FROM `members`";

            // This SQL statement does not use any parameters. Use the default $parameterValues array.
            $response = getAllRecords($sql, $db, $parameterValues);

            break;

        default :
            $response = array();
            break;
    } // end switch


    /* $response is an array of matching records (array of associative arrays). The server response must be a string so we
    have to convert this array into a string with a format that is easy to convert to
    an array of Javascript objects.

    We use the json_encode() method to convert the $response into a string using a format which can
    easily be converted into an array of JavaScript objects called JSON objects.
    */
    echo json_encode($response);


    function getAllRecords($sql, $db, $values = null){
        /* Input values:
        1. SQL statement that includes 'named' parameters
        2. Database connection
        3. (Optional) Values for 'named' parameters, if there are any 'named' parameters in the SQL statement
        Output: Array of matching result records. Each element in the array is an associative array.
        */
        // prepare SQL statement
        $stm = $db->prepare($sql);
        // execute SQL statement
        $stm->execute($values);
        // fetch all records
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
        // return the result set
        return $result;
    }
?>