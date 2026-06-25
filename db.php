<?php

if ($_SERVER['SERVER_NAME'] == 'localhost') {

    $conn = mysqli_connect(
        "localhost",
        "root",
        "",
        "caringsquad"
    );

} else {

    $conn = mysqli_connect(
        "localhost",
        "caringsquad",
        "Caringsquad@123",
        "u306816562_caringsquad"
    );

}

?>