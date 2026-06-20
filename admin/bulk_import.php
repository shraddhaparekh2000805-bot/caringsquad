<?php

session_start();
include '../db.php';

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

$message = "";
$messageType = "";

$imported = 0;
$skipped = 0;

if(isset($_POST['import_doctors'])){

    if(isset($_FILES['excel_file']) && $_FILES['excel_file']['error']==0){

        $fileName = $_FILES['excel_file']['name'];
        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if($extension == "xlsx" || $extension == "xls"){

            try{

                $spreadsheet = IOFactory::load($_FILES['excel_file']['tmp_name']);

                $rows = $spreadsheet
                    ->getActiveSheet()
                    ->toArray();

                foreach($rows as $index => $row){

                    // Skip Header
                    if($index == 0){
                        continue;
                    }

                    if(empty(trim($row[0]))){
                        continue;
                    }

                    $name = mysqli_real_escape_string($conn,$row[0]);
                    $email = mysqli_real_escape_string($conn,$row[1]);
                    $mobile = mysqli_real_escape_string($conn,$row[2]);
                    $whatsapp = mysqli_real_escape_string($conn,$row[3]);
                    $gender = mysqli_real_escape_string($conn,$row[4]);
                    $dob = mysqli_real_escape_string($conn,$row[5]);
                    $state = mysqli_real_escape_string($conn,$row[6]);
                    $city = mysqli_real_escape_string($conn,$row[7]);
                    $degree = mysqli_real_escape_string($conn,$row[8]);
                    $language = mysqli_real_escape_string($conn,$row[9]);
                    $speciality = mysqli_real_escape_string($conn,$row[10]);
                    $experience = mysqli_real_escape_string($conn,$row[11]);
                    $hospital = mysqli_real_escape_string($conn,$row[12]);
                    $license_number = mysqli_real_escape_string($conn,$row[13]);
                    $council = mysqli_real_escape_string($conn,$row[14]);
                    $clinic_fee = mysqli_real_escape_string($conn,$row[15]);
                    $cs_fee = mysqli_real_escape_string($conn,$row[16]);
                    $priority_fee = mysqli_real_escape_string($conn,$row[17]);
                    $professional_bio = mysqli_real_escape_string($conn,$row[18]);
                    $status = mysqli_real_escape_string($conn,$row[19]);

                    // Duplicate Email Check

                    $check = mysqli_query(
                        $conn,
                        "SELECT id FROM doctors
                        WHERE email='$email'
                        LIMIT 1"
                    );

                    if(mysqli_num_rows($check) > 0){
                        $skipped++;
                        continue;
                    }

                    $insert = mysqli_query($conn,"

                        INSERT INTO doctors
                        (
                            name,
                            email,
                            mobile,
                            whatsapp,
                            gender,
                            dob,
                            state,
                            city,
                            degree,
                            language,
                            speciality,
                            experience,
                            hospital,
                            license_number,
                            council,
                            clinic_fee,
                            cs_fee,
                            priority_fee,
                            professional_bio,
                            status
                        )

                        VALUES

                        (
                            '$name',
                            '$email',
                            '$mobile',
                            '$whatsapp',
                            '$gender',
                            '$dob',
                            '$state',
                            '$city',
                            '$degree',
                            '$language',
                            '$speciality',
                            '$experience',
                            '$hospital',
                            '$license_number',
                            '$council',
                            '$clinic_fee',
                            '$cs_fee',
                            '$priority_fee',
                            '$professional_bio',
                            '$status'
                        )

                    ");

                    if($insert){
                        $imported++;
                    }else{
                        $skipped++;
                    }

                }

                $message =
                    "Imported : ".$imported.
                    " | Skipped : ".$skipped;

                $messageType = "success";

            }catch(Exception $e){

                $message = $e->getMessage();
                $messageType = "error";
            }

        }else{

            $message = "Please upload Excel file only.";
            $messageType = "error";
        }

    }else{

        $message = "Please select a file.";
        $messageType = "error";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Bulk Import Doctors</title>

<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
}

body{
background:#f6f3ee;
font-family:'Montserrat',sans-serif;
}

.container{
max-width:900px;
margin:50px auto;
padding:30px;
}

.card{
background:#fff;
border-radius:24px;
padding:40px;
box-shadow:0 10px 30px rgba(0,0,0,.05);
}

h1{
font-size:32px;
margin-bottom:10px;
color:#04142b;
}

.sub{
color:#777;
margin-bottom:30px;
}

.upload-box{
border:2px dashed #d6af78;
padding:50px;
text-align:center;
border-radius:20px;
background:#faf8f5;
}

.upload-box input{
margin-top:20px;
}

.btn{
border:none;
padding:14px 30px;
border-radius:12px;
font-size:15px;
font-weight:600;
cursor:pointer;
}

.import-btn{
background:#198754;
color:#fff;
margin-top:25px;
}

.import-btn:hover{
background:#157347;
}

.back-btn{
background:#04142b;
color:#fff;
text-decoration:none;
display:inline-block;
margin-top:20px;
}

.message{
padding:16px;
border-radius:12px;
margin-bottom:20px;
font-weight:600;
}

.success{
background:#dff7ea;
color:#198754;
}

.error{
background:#fde9e9;
color:#dc3545;
}

.table{
width:100%;
margin-top:30px;
border-collapse:collapse;
}

.table th{
background:#04142b;
color:#fff;
padding:12px;
font-size:13px;
}

.table td{
border:1px solid #ddd;
padding:12px;
font-size:13px;
}

.note{
margin-top:25px;
background:#fff8e7;
padding:18px;
border-radius:12px;
line-height:28px;
}

</style>

</head>

<body>

<div class="container">

<div class="card">

<h1>Bulk Import Doctors</h1>

<p class="sub">
Upload Excel file and import doctors instantly.
</p>

<?php if(!empty($message)){ ?>

<div class="message <?php echo $messageType; ?>">
<?php echo $message; ?>
</div>

<?php } ?>

<form method="POST" enctype="multipart/form-data">

<div class="upload-box">

<h3>Select Excel File</h3>

<input
type="file"
name="excel_file"
accept=".xlsx,.xls"
required
>

<br>

<button
type="submit"
name="import_doctors"
class="btn import-btn"
>
Import Doctors
</button>

</div>

</form>

<a href="manage.php" class="btn back-btn">
← Back To Manage Doctors
</a>

<div class="note">

<b>Excel Column Order Must Be:</b>

<br><br>

Name, Email, Mobile, Whatsapp, Gender, DOB,
State, City, Degree, Language,
Speciality, Experience, Hospital,
License Number, Council,
Clinic Fee, CS Fee,
Priority Fee, Professional Bio,
Status

</div>

<table class="table">

<tr>
<th>Column</th>
<th>Example</th>
</tr>

<tr><td>Name</td><td>Dr. Amit Shah</td></tr>
<tr><td>Email</td><td>amit@gmail.com</td></tr>
<tr><td>Mobile</td><td>9876543210</td></tr>
<tr><td>Gender</td><td>Male</td></tr>
<tr><td>Degree</td><td>MBBS, MD</td></tr>
<tr><td>Speciality</td><td>Cardiologist</td></tr>
<tr><td>Status</td><td>Active</td></tr>

</table>

</div>

</div>

</body>
</html>