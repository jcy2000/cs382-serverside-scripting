<?php
    if (isset($pageTitle))
        echo "<h4>{$pageTitle}</h4>";
    
    // Check if the dataList is not empty
    if(empty($dataList)) {
        echo "There is no data";
        exit();
    }

    /* In this case, the SQL should return just one record matching the given memberId.
        Hence, $dataList is an array that consists of just one matching record
    */
    $member = $dataList[0];

    // Display name of the selected member
    echo "<p>Name: {$member['lastName']}, {$member['firstName']}</p>";
?>
<!--Use an HTML form to display data-->
<form action="index.php?mode=updateMemberInfo" method="post">
    <table class="table" style="width: 500px;">
        <tbody>
            <tr>
                <th>Phone</th>
                <td>
                    <input type="text" name="phone" value="<?php echo $member['phone']; ?>" />
                </td>
            </tr>
            <tr>
                <th>Member Type</th>
                <td>
                    <select name="memberType">
                        <option value="Preferred" <?php if ($member['memberType'] === "Preferred") echo "selected='selected'"; ?> >Preferred</option> 
                        <option value="Regular" <?php if ($member['memberType'] === "Regular") echo "selected='selected'"; ?> > Regular </option>	
                        <option value="Student" <?php if ($member['memberType'] === "Student") echo "selected='selected'"; ?> >Student </option>
                    </select>
                </td>
            </tr>
        </tbody>
    </table>
    <!-- Need to send memberID to the server using an input element (key=value ). 
        We can use a hidden field to define a key=value pair. A hidden field will not be displayed.
    -->
    <input type="hidden" name="memberID" value="<?php echo $member['memberID']; ?>" />
    <p><button type="submit" class="btn btn-primary">Update Member Information </button>
</form>