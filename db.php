<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "caringsquad"
);

if(!$conn){

    die("Database Connection Failed");

}

?>