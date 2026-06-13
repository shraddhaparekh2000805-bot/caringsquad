<?php

include '../db.php';

/* =========================================
   EXPORT CSV
========================================= */

$fileName = "doctors-data-" . date('Y-m-d') . ".csv";

/* HEADERS */

header('Content-Type: text/csv');

header('Content-Disposition: attachment; filename="'.$fileName.'"');

/* OPEN OUTPUT STREAM */

$output = fopen("php://output", "w");

/* CSV COLUMN HEADERS */

fputcsv($output, array(

    'ID',
    'Doctor Name',
    'Degree',
    'Speciality',
    'Experience',
    'Rating',
    'Language',
    'Consultation Fee',
    'Hospital',
    'City',
    'State',
    'Status'

));

/* FETCH DOCTORS */

$query = mysqli_query(
    $conn,
    "SELECT * FROM doctors ORDER BY id DESC"
);

/* LOOP DATA */

while($doctor = mysqli_fetch_assoc($query)){

    fputcsv($output, array(

        $doctor['id'],
        $doctor['name'],
        $doctor['degree'],
        $doctor['speciality'],
        $doctor['experience'],
        $doctor['rating'],
        $doctor['language'],
        $doctor['fee'],
        $doctor['hospital'],
        $doctor['city'],
        $doctor['state'],
        $doctor['status']

    ));
}

/* CLOSE STREAM */

fclose($output);

exit();

?>