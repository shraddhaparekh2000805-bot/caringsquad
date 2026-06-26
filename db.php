<?php

$host = $_SERVER['SERVER_NAME'] ?? $_SERVER['HTTP_HOST'] ?? 'localhost';
$host = strtolower(preg_replace('/:\d+$/', '', $host));

if ($host === 'localhost' || $host === '127.0.0.1') {

    $conn = mysqli_connect(
        "localhost",
        "root",
        "",
        "caringsquad"
    );

} else {

    $conn = mysqli_connect(
        "localhost",
        "u306816562_caringsquad",
        "Caringsquad@123",
        "u306816562_caringsquad"
    );

}

?>