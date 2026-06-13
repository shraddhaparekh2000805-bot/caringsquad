<?php

include '../db.php';

if(isset($_POST['state_id']))
{
    $state_id = (int)$_POST['state_id'];

    $query = mysqli_query(
        $conn,
        "SELECT city_name
         FROM cities
         WHERE state_id = $state_id
         ORDER BY city_name ASC"
    );

    echo '<option value="">Select City</option>';

    while($row = mysqli_fetch_assoc($query))
    {
        echo '<option value="'.$row['city_name'].'">'
            .$row['city_name'].
            '</option>';
    }
}
else
{
    echo '<option value="">Select City</option>';
}
?>