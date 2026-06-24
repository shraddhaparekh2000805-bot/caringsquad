<?php

session_start();

include '../db.php';

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

/* =========================================
   DELETE DOCTOR
========================================= */

if(isset($_GET['delete'])){

    $delete_id = intval($_GET['delete']);

    mysqli_query(
        $conn,
        "DELETE FROM doctors WHERE id='$delete_id'"
    );

    header("Location: manage.php");
    exit();
}

/* =========================================
   UPDATE STATUS
========================================= */

if(isset($_GET['status'])){

    $doctor_id = intval($_GET['id']);

    $status = $_GET['status'];

    mysqli_query(
        $conn,
        "UPDATE doctors
        SET status='$status'
        WHERE id='$doctor_id'"
    );

    header("Location: manage.php");
    exit();
}

/* =========================================
   UPDATE DOCTOR
========================================= */

if(isset($_POST['update_doctor'])){

    $doctor_id = intval($_POST['doctor_id']);

    $name = mysqli_real_escape_string($conn,$_POST['name']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $mobile = mysqli_real_escape_string($conn,$_POST['mobile']);
    $whatsapp = mysqli_real_escape_string($conn,$_POST['whatsapp']);
    $gender = mysqli_real_escape_string($conn,$_POST['gender']);
    $dob = mysqli_real_escape_string($conn,$_POST['dob']);
    $state = mysqli_real_escape_string($conn,$_POST['state']);
    $city = mysqli_real_escape_string($conn,$_POST['city']);
    $degree = mysqli_real_escape_string($conn,$_POST['degree']);
    $language = mysqli_real_escape_string($conn,$_POST['language']);
    $speciality = mysqli_real_escape_string($conn,$_POST['speciality']);
    $experience = mysqli_real_escape_string($conn,$_POST['experience']);
    $hospital = mysqli_real_escape_string($conn,$_POST['hospital']);
    $license_number = mysqli_real_escape_string($conn,$_POST['license_number']);
    $council = mysqli_real_escape_string($conn,$_POST['council']);
    $clinic_fee = mysqli_real_escape_string($conn,$_POST['clinic_fee']);
    $cs_fee = mysqli_real_escape_string($conn,$_POST['cs_fee']);
    $priority_fee = mysqli_real_escape_string($conn,$_POST['priority_fee']);
    $professional_bio = mysqli_real_escape_string($conn,$_POST['professional_bio']);
    $profession = mysqli_real_escape_string($conn,$_POST['profession']);
$sub_specialization = mysqli_real_escape_string($conn,$_POST['sub_specialization']);
$additional_certifications = mysqli_real_escape_string($conn,$_POST['additional_certifications']);
$current_designation = mysqli_real_escape_string($conn,$_POST['current_designation']);
$registration_valid_till = mysqli_real_escape_string($conn,$_POST['registration_valid_till']);
$additional_registrations = mysqli_real_escape_string($conn,$_POST['additional_registrations']);

$online_consultation = mysqli_real_escape_string($conn,$_POST['online_consultation']);
$home_visit = mysqli_real_escape_string($conn,$_POST['home_visit']);
$consultation_mode = mysqli_real_escape_string($conn,$_POST['consultation_mode']);
$platform = mysqli_real_escape_string($conn,$_POST['platform']);

$video_whatsapp = mysqli_real_escape_string($conn,$_POST['video_whatsapp']);
$audio_mobile = mysqli_real_escape_string($conn,$_POST['audio_mobile']);

$consultation_duration = mysqli_real_escape_string($conn,$_POST['consultation_duration']);
$consultation_languages = mysqli_real_escape_string($conn,$_POST['consultation_languages']);

$availability = mysqli_real_escape_string($conn,$_POST['availability']);
$available_days = mysqli_real_escape_string($conn,$_POST['available_days']);

$priority_consultation = mysqli_real_escape_string($conn,$_POST['priority_consultation']);
$response_time = mysqli_real_escape_string($conn,$_POST['response_time']);
$emergency_charges = mysqli_real_escape_string($conn,$_POST['emergency_charges']);
$max_priority_consultation = mysqli_real_escape_string($conn,$_POST['max_priority_consultation']);

$followup_available = mysqli_real_escape_string($conn,$_POST['followup_available']);
$followup_fee = mysqli_real_escape_string($conn,$_POST['followup_fee']);
$free_followup_period = mysqli_real_escape_string($conn,$_POST['free_followup_period']);

$report_review = mysqli_real_escape_string($conn,$_POST['report_review']);
$digital_prescription = mysqli_real_escape_string($conn,$_POST['digital_prescription']);

$display_name = mysqli_real_escape_string($conn,$_POST['display_name']);
$display_degree = mysqli_real_escape_string($conn,$_POST['display_degree']);
$display_speciality = mysqli_real_escape_string($conn,$_POST['display_speciality']);
$display_experience = mysqli_real_escape_string($conn,$_POST['display_experience']);
$display_languages = mysqli_real_escape_string($conn,$_POST['display_languages']);
    $image = $_POST['old_image'];

if(
    isset($_FILES['image']) &&
    !empty($_FILES['image']['name'])
){

    $image =
    time().'_'.basename($_FILES['image']['name']);

    move_uploaded_file(
        $_FILES['image']['tmp_name'],
        '../uploads/'.$image
    );
}

    mysqli_query($conn,

        "UPDATE doctors SET

        image='$image',
        name='$name',
        email='$email',
        mobile='$mobile',
        whatsapp='$whatsapp',
        gender='$gender',
        dob='$dob',
        state='$state',
        city='$city',
        degree='$degree',
        language='$language',
        speciality='$speciality',
        experience='$experience',
        hospital='$hospital',
        license_number='$license_number',
        council='$council',
        clinic_fee='$clinic_fee',
        cs_fee='$cs_fee',
        priority_fee='$priority_fee',
professional_bio='$professional_bio',

profession='$profession',
sub_specialization='$sub_specialization',
additional_certifications='$additional_certifications',

current_designation='$current_designation',
registration_valid_till='$registration_valid_till',
additional_registrations='$additional_registrations',

online_consultation='$online_consultation',
home_visit='$home_visit',

consultation_mode='$consultation_mode',
platform='$platform',

video_whatsapp='$video_whatsapp',
audio_mobile='$audio_mobile',

consultation_duration='$consultation_duration',
consultation_languages='$consultation_languages',

availability='$availability',
available_days='$available_days',

priority_consultation='$priority_consultation',
response_time='$response_time',
emergency_charges='$emergency_charges',
max_priority_consultation='$max_priority_consultation',

followup_available='$followup_available',
followup_fee='$followup_fee',
free_followup_period='$free_followup_period',

report_review='$report_review',
digital_prescription='$digital_prescription',

display_name='$display_name',
display_degree='$display_degree',
display_speciality='$display_speciality',
display_experience='$display_experience',
display_languages='$display_languages'

        WHERE id='$doctor_id'"

    );

    header("Location: manage.php");
    exit();
}

/* =========================================
   SEARCH
========================================= */

$search = "";

$where = "WHERE 1";

if(isset($_GET['search'])){

    $search = mysqli_real_escape_string($conn,$_GET['search']);

    $where .= " AND (
        name LIKE '%$search%' OR
        speciality LIKE '%$search%' OR
        city LIKE '%$search%'
    )";
}

/* =========================================
   FETCH DOCTORS
========================================= */

$doctorQuery = mysqli_query(
    $conn,
    "SELECT * FROM doctors
    $where
    ORDER BY id DESC"
);

$totalDoctors = mysqli_num_rows($doctorQuery);

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Manage Doctors</title>

<link rel="preconnect" href="https://fonts.googleapis.com">

<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Montserrat',sans-serif;
    background:#f6f3ee;
    color:#04142b;
}

/* SIDEBAR */

.sidebar{
    width:250px;
    background:#04142b;
    position:fixed;
    height:100vh;
    left:0;
    top:0;
    padding:30px 22px;
}

.sidebar-logo{
    text-align:center;
    margin-bottom:40px;
}

.brand-logo{
    width:220px;
    max-width:100%;
    display:block;
    margin:0 auto 10px;
}

.sidebar h2{
    font-family:'Cormorant Garamond',serif;
    color:#d6af78;
    font-size:42px;
}

.sidebar ul{
    list-style:none;
    margin-top:40px;
}

.sidebar ul li{
    margin-bottom:14px;
}

.sidebar ul li a{
    display:flex;
    align-items:center;
    gap:12px;
    padding:16px 18px;
    border-radius:14px;
    color:#fff;
    text-decoration:none;
}

.sidebar ul li a.active,
.sidebar ul li a:hover{
    background:rgba(214,175,120,0.14);
    color:#d6af78;
}

/* MAIN */

.main{
    margin-left:250px;
    padding:20px;
}

.topbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    background:#fff;
    padding:18px 24px;
    border-radius:20px;
    margin-bottom:20px;
}

.topbar-right{
    display:flex;
    align-items:center;
    gap:18px;
}

.bulk-import-btn{
    background:#198754;
    color:#fff;
    text-decoration:none;
    padding:10px 16px;
    border-radius:14px;
    font-weight:600;
    display:flex;
    align-items:center;
    gap:8px;
    transition:.3s;
}

.bulk-import-btn:hover{
    background:#157347;
}

.topbar h1{
    font-family:'Cormorant Garamond',serif;
    font-size:30px;
}

/* SEARCH */

.search-box{
    margin-bottom:18px;
}

.search-box form{
    display:flex;
    gap:15px;
}

.search-box input{
    flex:1;
    height:48px;
    border:none;
    border-radius:14px;
    padding:0 20px;
    font-size:15px;
}

.search-box button{
    border:none;
    background:#c89753;
    color:#04142b;
    padding:0 26px;
    border-radius:14px;
    font-weight:600;
    cursor:pointer;
    height:48px;
    font-size:14px;
}

/* TABLE */

.table-box{
    background:#fff;
    border-radius:18px;
    padding:16px;
    overflow:auto;
    box-shadow:0 8px 20px rgba(0,0,0,0.04);
}

table{
    width:100%;
    border-collapse:collapse;
    table-layout:fixed;
}

th{
    background:#04142b;
    color:#fff;
    padding:12px 8px;
    font-size:12px;
    text-align:center;
    white-space:nowrap;
}

td{
    padding:12px;
    border-bottom:1px solid #eee;
    font-size:13px;
}

.doctor-img{
    width:42px;
    height:42px;
    border-radius:50%;
    object-fit:cover;
}

.status{
    padding:8px 16px;
    border-radius:30px;
    font-size:13px;
    font-weight:600;
}

.active-status{
    background:#dff7ea;
    color:#20bf6b;
}

.inactive-status{
    background:#fde9e9;
    color:#eb5757;
}

.action-buttons{
    display:flex;
    gap:10px;
}

.btn{
    border:none;
    padding:7px 12px;
    border-radius:12px;
    cursor:pointer;
    text-decoration:none;
    font-size:13px;
    font-weight:600;
}

.edit-btn{
    background:#e3efff;
    color:#1677ff;
}

.delete-btn{
    background:#fdeaea;
    color:#ff4d4f;
}

.status-btn{
    background:#fff4df;
    color:#c58b2d;
}

/* MODAL */

.modal{
    position:fixed;
    inset:0;
    background:rgba(0,0,0,0.5);
    display:none;
    align-items:center;
    justify-content:center;
    z-index:999;
}

.modal-content{
    width:95%;
    max-width:1100px;
    background:#fff;
    border-radius:26px;
    max-height:90vh;
    overflow:auto;
    padding:35px;
}

.modal-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
}

.modal-header h2{
    font-family:'Cormorant Garamond',serif;
    font-size:40px;
}

.close-btn{
    font-size:30px;
    cursor:pointer;
}

.form-grid{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:24px;
}

.form-group{
    display:flex;
    flex-direction:column;
}

.form-group.full{
    grid-column:span 2;
}

.form-group label{
    margin-bottom:10px;
    font-size:14px;
    font-weight:600;
}

.form-group input,
.form-group textarea,
.form-group select{
    height:56px;
    border:1px solid #ddd;
    border-radius:14px;
    padding:0 16px;
    font-family:inherit;
}

.form-group textarea{
    height:140px;
    padding-top:16px;
    resize:none;
}

.save-btn{
    margin-top:30px;
    height:56px;
    border:none;
    background:#04142b;
    color:#fff;
    border-radius:14px;
    padding:0 30px;
    font-weight:600;
    cursor:pointer;
}

</style>

</head>

<body>

<aside class="sidebar">

<div class="sidebar-logo">

    <img
        src="../assets/images/caringsquad-logo.png"
        alt="Caring Squad"
        class="brand-logo"
    >

</div>

<ul class="sidebar-menu">

<li>
<a href="dashboard.php">
<i class="fa-solid fa-house"></i>
Dashboard
</a>
</li>

<li>
<a href="add-doctor.php">
<i class="fa-solid fa-user-plus"></i>
Add Doctor
</a>
</li>

<li>
<a href="manage.php"  class="active">
<i class="fa-solid fa-hospital-user"></i>
Manage Doctors
</a>
</li>

 <li>
                <a href="blog_categories.php">
                    <i class="fa-solid fa-hospital-user"></i>
                    Blog Categories
                </a>
            </li>

            <li>
                <a href="add_blog.php">
                    <i class="fa-solid fa-hospital-user"></i>
                    Add Blog
                </a>
            </li>

            <li>
                <a href="blog_list.php">
                    <i class="fa-solid fa-hospital-user"></i>
                    Manage Blog
                </a>
            </li>

<li>
<a href="logout.php">
<i class="fa-solid fa-right-from-bracket"></i>
Logout
</a>
</li>

</ul>

</aside>


<div class="main">

    <div class="topbar">

    <h1>Manage Doctors</h1>

    <div class="topbar-right">

        <span>
            Total Doctors :
            <strong><?php echo $totalDoctors; ?></strong>
        </span>

        <a href="bulk_import.php" class="bulk-import-btn">
            <i class="fa-solid fa-file-excel"></i>
            Bulk Import
        </a>

    </div>

</div>

    <div class="search-box">

        <form>

            <input
                type="text"
                name="search"
                placeholder="Search doctors..."
                value="<?php echo $search; ?>"
            >

            <button type="submit">
                Search
            </button>

        </form>

    </div>

    <div class="table-box">

        <table>

            <tr>
                <th>Sr No</th>
                <th>Doctor ID</th>
                <th>Photo</th>
                <th>Display Name</th>
                <th>Degree</th>
                <th>Speciality</th>
                <th>Experience</th>
                <th>Languages</th>
                <th>Consultation Type</th> 
                <th>Caring Squad Fee</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>

<?php $sr = 1; while($doctor = mysqli_fetch_assoc($doctorQuery)){ ?>

<tr>

<?php
$imagePath =
(!empty($doctor['image']) &&
file_exists('../uploads/doctors/'.$doctor['image']))
?
'../uploads/doctors/'.$doctor['image']
:
'../assets/images/default-doctor.png';
?>

<td><?php echo $sr++; ?></td>

<td><?php echo $doctor['dr_id']; ?></td>

<td>
<img
src="<?php echo $imagePath; ?>"
class="doctor-img">
</td>

<td>
<?php echo $doctor['display_name']; ?>
</td>

<td>
<?php echo $doctor['display_degree']; ?>
</td>

<td>
<?php echo $doctor['display_speciality']; ?>
</td>

<td>
<?php echo $doctor['display_experience']; ?>
</td>

<td>
<?php echo $doctor['display_languages']; ?>
</td>

<td>
<?php echo $doctor['consultation_type']; ?>
</td>

<td>
₹<?php echo $doctor['cs_fee']; ?>
</td>

                <td>

                    <?php if($doctor['status'] == 'Active'){ ?>

                        <span class="status active-status">
                            Active
                        </span>

                    <?php } else { ?>

                        <span class="status inactive-status">
                            Inactive
                        </span>

                    <?php } ?>

                </td>

                <td>

                    <div class="action-buttons">

                        <button
                            class="btn edit-btn"
                            onclick="openModal('modal<?php echo $doctor['id']; ?>')"
                        >
                            Edit
                        </button>

                        <a
                            href="?delete=<?php echo $doctor['id']; ?>"
                            class="btn delete-btn"
                            onclick="return confirm('Delete doctor?')"
                        >
                            Delete
                        </a>

                        <?php if($doctor['status'] == 'Active'){ ?>

                            <a
                                href="?id=<?php echo $doctor['id']; ?>&status=Inactive"
                                class="btn status-btn"
                            >
                                Inactive
                            </a>

                        <?php } else { ?>

                            <a
                                href="?id=<?php echo $doctor['id']; ?>&status=Active"
                                class="btn status-btn"
                            >
                                Active
                            </a>

                        <?php } ?>

                    </div>

                </td>

            </tr>

            <!-- MODAL -->

            <div
                class="modal"
                id="modal<?php echo $doctor['id']; ?>"
            >

                <div class="modal-content">

                    <div class="modal-header">

                        <h2>Edit Doctor</h2>

                        <span
                            class="close-btn"
                            onclick="closeModal('modal<?php echo $doctor['id']; ?>')"
                        >
                        </span>

                    </div>

                    <form method="POST" enctype="multipart/form-data">

                        <input
                            type="hidden"
                            name="doctor_id"
                            value="<?php echo $doctor['id']; ?>"
                        >

                        <input
                            type="hidden"
                            name="old_image"
                            value="<?php echo $doctor['image']; ?>"
                        >

                        <div class="form-grid">

                        <div class="form-group full">

<label>Doctor Photo</label>

<img
src="../uploads/<?php echo $doctor['image']; ?>"
style="
width:120px;
height:120px;
border-radius:15px;
object-fit:cover;
margin-bottom:15px;
border:1px solid #ddd;
">

<input
type="file"
name="image"
accept="image/*">

</div>

                            <div class="form-group">
                                <label>Full Name</label>
                                <input type="text" name="name" value="<?php echo $doctor['name']; ?>">
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" value="<?php echo $doctor['email']; ?>">
                            </div>

                            <div class="form-group">
                                <label>Mobile</label>
                                <input type="text" name="mobile" value="<?php echo $doctor['mobile']; ?>">
                            </div>

                            <div class="form-group">
                                <label>Whatsapp</label>
                                <input type="text" name="whatsapp" value="<?php echo $doctor['whatsapp']; ?>">
                            </div>

                            <div class="form-group">
                                <label>Gender</label>

                                <select name="gender">

                                    <option <?php if($doctor['gender']=="Male"){echo "selected";} ?>>
                                        Male
                                    </option>

                                    <option <?php if($doctor['gender']=="Female"){echo "selected";} ?>>
                                        Female
                                    </option>

                                </select>

                            </div>

                            <div class="form-group">
                                <label>DOB</label>
                                <input type="date" name="dob" value="<?php echo $doctor['dob']; ?>">
                            </div>

                            <div class="form-group">
                                <label>State</label>
                                <input type="text" name="state" value="<?php echo $doctor['state']; ?>">
                            </div>

                            <div class="form-group">
                                <label>City</label>
                                <input type="text" name="city" value="<?php echo $doctor['city']; ?>">
                            </div>

                            <div class="form-group">
                                <label>Degree</label>
                                <input type="text" name="degree" value="<?php echo $doctor['degree']; ?>">
                            </div>

                            <div class="form-group">
                                <label>Language</label>
                                <input type="text" name="language" value="<?php echo $doctor['language']; ?>">
                            </div>

                            <div class="form-group">
                                <label>Speciality</label>
                                <input type="text" name="speciality" value="<?php echo $doctor['speciality']; ?>">
                            </div>

                            <div class="form-group">
                                <label>Experience</label>
                                <input type="text" name="experience" value="<?php echo $doctor['experience']; ?>">
                            </div>

                            <div class="form-group">
                                <label>Hospital</label>
                                <input type="text" name="hospital" value="<?php echo $doctor['hospital']; ?>">
                            </div>

                            <div class="form-group">
                                <label>License Number</label>
                                <input type="text" name="license_number" value="<?php echo $doctor['license_number']; ?>">
                            </div>

                            <div class="form-group">
                                <label>Council</label>
                                <input type="text" name="council" value="<?php echo $doctor['council']; ?>">
                            </div>

                            <div class="form-group">
                                <label>Clinic Fee</label>
                                <input type="text" name="clinic_fee" value="<?php echo $doctor['clinic_fee']; ?>">
                            </div>

                            <div class="form-group">
                                <label>Caring Squad Fee</label>
                                <input type="text" name="cs_fee" value="<?php echo $doctor['cs_fee']; ?>">
                            </div>

                            <div class="form-group">
                                <label>Priority Fee</label>
                                <input type="text" name="priority_fee" value="<?php echo $doctor['priority_fee']; ?>">
                            </div>

                            <div class="form-group full">
                                <label>Professional Bio</label>

                                <textarea name="professional_bio"><?php echo $doctor['professional_bio']; ?></textarea>
                            </div>

                            <!-- SECTION B EXTRA -->

<div class="form-group">
<label>Professional Category</label>
<input type="text"
name="profession"
value="<?php echo $doctor['profession']; ?>">
</div>

<div class="form-group">
<label>Sub Specialization</label>
<input type="text"
name="sub_specialization"
value="<?php echo $doctor['sub_specialization']; ?>">
</div>

<div class="form-group full">
<label>Additional Certifications</label>
<input type="text"
name="additional_certifications"
value="<?php echo $doctor['additional_certifications']; ?>">
</div>

<div class="form-group">
<label>Current Designation</label>
<input type="text"
name="current_designation"
value="<?php echo $doctor['current_designation']; ?>">
</div>

<div class="form-group">
<label>Registration Valid Till</label>
<input type="date"
name="registration_valid_till"
value="<?php echo $doctor['registration_valid_till']; ?>">
</div>

<div class="form-group full">
<label>Additional Registrations</label>
<input type="text"
name="additional_registrations"
value="<?php echo $doctor['additional_registrations']; ?>">
</div>

<!-- ONLINE CONSULTATION -->

<div class="form-group">
<label>Online Consultation</label>
<input type="text"
name="online_consultation"
value="<?php echo $doctor['online_consultation']; ?>">
</div>

<div class="form-group">
<label>Home Visit</label>
<input type="text"
name="home_visit"
value="<?php echo $doctor['home_visit']; ?>">
</div>

<div class="form-group full">
<label>Consultation Mode</label>
<input type="text"
name="consultation_mode"
value="<?php echo $doctor['consultation_mode']; ?>">
</div>

<div class="form-group full">
<label>Platform</label>
<input type="text"
name="platform"
value="<?php echo $doctor['platform']; ?>">
</div>

<div class="form-group">
<label>Video Whatsapp</label>
<input type="text"
name="video_whatsapp"
value="<?php echo $doctor['video_whatsapp']; ?>">
</div>

<div class="form-group">
<label>Audio Mobile</label>
<input type="text"
name="audio_mobile"
value="<?php echo $doctor['audio_mobile']; ?>">
</div>

<div class="form-group">
<label>Consultation Duration</label>
<input type="text"
name="consultation_duration"
value="<?php echo $doctor['consultation_duration']; ?>">
</div>

<div class="form-group full">
<label>Consultation Languages</label>
<input type="text"
name="consultation_languages"
value="<?php echo $doctor['consultation_languages']; ?>">
</div>

<div class="form-group full">
<label>Availability</label>
<input type="text"
name="availability"
value="<?php echo $doctor['availability']; ?>">
</div>

<div class="form-group full">
<label>Available Days</label>
<input type="text"
name="available_days"
value="<?php echo $doctor['available_days']; ?>">
</div>

<div class="form-group">
<label>Priority Consultation</label>
<input type="text"
name="priority_consultation"
value="<?php echo $doctor['priority_consultation']; ?>">
</div>

<div class="form-group">
<label>Response Time</label>
<input type="text"
name="response_time"
value="<?php echo $doctor['response_time']; ?>">
</div>

<div class="form-group">
<label>Emergency Charges</label>
<input type="text"
name="emergency_charges"
value="<?php echo $doctor['emergency_charges']; ?>">
</div>

<div class="form-group">
<label>Max Priority Consultation</label>
<input type="text"
name="max_priority_consultation"
value="<?php echo $doctor['max_priority_consultation']; ?>">
</div>

<div class="form-group">
<label>Followup Available</label>
<input type="text"
name="followup_available"
value="<?php echo $doctor['followup_available']; ?>">
</div>

<div class="form-group">
<label>Followup Fee</label>
<input type="text"
name="followup_fee"
value="<?php echo $doctor['followup_fee']; ?>">
</div>

<div class="form-group">
<label>Free Followup Period</label>
<input type="text"
name="free_followup_period"
value="<?php echo $doctor['free_followup_period']; ?>">
</div>

<div class="form-group">
<label>Report Review</label>
<input type="text"
name="report_review"
value="<?php echo $doctor['report_review']; ?>">
</div>

<div class="form-group">
<label>Digital Prescription</label>
<input type="text"
name="digital_prescription"
value="<?php echo $doctor['digital_prescription']; ?>">
</div>

<!-- DISPLAY PROFILE -->

<div class="form-group">
<label>Display Name</label>
<input type="text"
name="display_name"
value="<?php echo $doctor['display_name']; ?>">
</div>

<div class="form-group">
<label>Display Degree</label>
<input type="text"
name="display_degree"
value="<?php echo $doctor['display_degree']; ?>">
</div>

<div class="form-group">
<label>Display Speciality</label>
<input type="text"
name="display_speciality"
value="<?php echo $doctor['display_speciality']; ?>">
</div>

<div class="form-group">
<label>Display Experience</label>
<input type="text"
name="display_experience"
value="<?php echo $doctor['display_experience']; ?>">
</div>

<div class="form-group full">
<label>Display Languages</label>
<input type="text"
name="display_languages"
value="<?php echo $doctor['display_languages']; ?>">
</div>

</div>

                        </div>

                        <button
                            type="submit"
                            name="update_doctor"
                            class="save-btn"
                        >
                            Update Doctor
                        </button>

                    </form>

                </div>

            </div>

            <?php } ?>

        </table>

    </div>

</div>

<script>

function openModal(id){

    document.getElementById(id).style.display = "flex";
}

function closeModal(id){

    document.getElementById(id).style.display = "none";
}

</script>

</body>
</html>