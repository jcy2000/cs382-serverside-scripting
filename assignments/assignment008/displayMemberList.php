<?php
    if(isset($pageTitle))
        echo "<h4>{$pageTitle}</h4>";

    // Check if the dataList is not empty
    if(empty($dataList)) {
        echo "There are no members";
        exit();
    }

    foreach($dataList as $row) {
    /* Each element is an associative array with three elements: memberID, firstName, and lastName. */
    echo "<ul>";
    // Remember that this is how more effectively include variables instead of the '.'
    echo "<li><a href='index.php?mode=displayMemberInfo&memberID={$row['memberID']}'>{$row['lastName']}, {$row['firstName']}</a></li>";
    echo "</ul>";
    }
?>