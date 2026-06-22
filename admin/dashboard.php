<?php

session_start();

include '../db.php';

if(isset($_POST['update_doctor'])){

    $id = (int)$_POST['id'];

    $display_name = mysqli_real_escape_string($conn,$_POST['display_name']);
    $display_degree = mysqli_real_escape_string($conn,$_POST['display_degree']);
    $display_speciality = mysqli_real_escape_string($conn,$_POST['display_speciality']);
    $display_experience = mysqli_real_escape_string($conn,$_POST['display_experience']);
    $display_languages = mysqli_real_escape_string($conn,$_POST['display_languages']);
    $consultation_type = mysqli_real_escape_string($conn,$_POST['consultation_type']);
    $clinic_fee = mysqli_real_escape_string($conn,$_POST['clinic_fee']);
    $caring_squad_fee = mysqli_real_escape_string($conn,$_POST['caring_squad_fee']);
    $imageUpdate = "";

if(
    isset($_FILES['doctor_photo']) &&
    $_FILES['doctor_photo']['error'] == 0
){

    $doctorQuery = mysqli_query(
        $conn,
        "SELECT image FROM doctors WHERE id='$id'"
    );

    $doctorData = mysqli_fetch_assoc($doctorQuery);

    if(!empty($doctorData['image'])){

        $oldImage = "../uploads/doctors/" . $doctorData['image'];

        if(file_exists($oldImage)){
            unlink($oldImage);
        }
    }

    $newImage =
        time() . "_" .
        basename($_FILES['doctor_photo']['name']);

    move_uploaded_file(
        $_FILES['doctor_photo']['tmp_name'],
        "../uploads/doctors/" . $newImage
    );

    $imageUpdate = ", image='$newImage'";
}

    mysqli_query($conn,"
    UPDATE doctors SET
    display_name='$display_name',
    display_degree='$display_degree',
    display_speciality='$display_speciality',
    display_experience='$display_experience',
    display_languages='$display_languages',
    consultation_type='$consultation_type',
    clinic_fee='$clinic_fee',
    caring_squad_fee='$caring_squad_fee'
    WHERE id='$id'
");

    header("Location: dashboard.php");
    exit();
}

if(!isset($_SESSION['admin'])){

    header("Location: login.php");
    exit();
}

/* =========================================
   TOGGLE STATUS
========================================= */

if(isset($_GET['toggle_id'])){

    $id = (int)$_GET['toggle_id'];

    $getStatus = mysqli_query(
        $conn,
        "SELECT status FROM doctors WHERE id='$id'"
    );

    $statusData = mysqli_fetch_assoc($getStatus);

    if($statusData['status'] == 'Active'){

        $newStatus = 'Inactive';

    }else{

        $newStatus = 'Active';
    }

    mysqli_query(
        $conn,
        "UPDATE doctors
         SET status='$newStatus'
         WHERE id='$id'"
    );

    header("Location: dashboard.php");
    exit();
}

/* =========================================
   DELETE DOCTOR
========================================= */

if(isset($_GET['delete_id'])){

    $id = (int)$_GET['delete_id'];

    $doctorQuery = mysqli_query(
        $conn,
        "SELECT image FROM doctors WHERE id='$id'"
    );

    $doctorData = mysqli_fetch_assoc($doctorQuery);

    if(!empty($doctorData['image'])){

        $imagePath = "../uploads/" . $doctorData['image'];

        if(file_exists($imagePath)){

            unlink($imagePath);
        }
    }

    mysqli_query(
        $conn,
        "DELETE FROM doctors WHERE id='$id'"
    );

    header("Location: dashboard.php");
    exit();
}

/* =========================================
   DASHBOARD DATA
========================================= */

$totalDoctors = mysqli_num_rows(
    mysqli_query($conn,"SELECT * FROM doctors")
);

$activeDoctors = mysqli_num_rows(
    mysqli_query($conn,"SELECT * FROM doctors WHERE status='Active'")
);

$inactiveDoctors = mysqli_num_rows(
    mysqli_query($conn,"SELECT * FROM doctors WHERE status='Inactive'")
);

$recentDoctors = mysqli_query(
    $conn,
    "SELECT * FROM doctors ORDER BY id DESC"
);

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Admin Dashboard | Caring Squad</title>

<link rel="preconnect" href="https://fonts.googleapis.com">

<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

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
    background:#f5f3ef;
    color:#04142b;
}

a{
    text-decoration:none;
}

ul{
    list-style:none;
}

.dashboard-layout{
    display:flex;
    min-height:100vh;
}

.sidebar{
    width:280px;
    background:#04142b;
    position:fixed;
    top:0;
    left:0;
    height:100vh;
    padding:20px 12px;
    overflow-y:auto;
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

.sidebar-menu li{
    margin-bottom:12px;
}

.sidebar-menu li a{
    display:flex;
    align-items:center;
    gap:14px;
    padding:15px 18px;
    border-radius:14px;
    color:#fff;
    font-size:15px;
    transition:0.3s;
}

.sidebar-menu li a:hover,
.sidebar-menu li a.active{
    background:rgba(214,175,120,0.15);
    color:#d6af78;
}

.sidebar-menu li a i{
    width:22px;
}

.main-content{
    margin-left:280px;
    width:calc(100% - 280px);
    padding:30px;
}

.topbar{
    background:#fff;
    padding:22px 28px;
    border-radius:20px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin-bottom:28px;
    box-shadow:0 8px 20px rgba(0,0,0,0.04);
}

.topbar h1{
    font-family:'Cormorant Garamond',serif;
    font-size:34px;
    color:#04142b;
}

.csv-btn{
    background:linear-gradient(to right,#b98b4c,#d7b27c);
    color:#04142b;
    padding:13px 22px;
    border-radius:12px;
    font-size:14px;
    font-weight:600;
}

.stats-grid{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:22px;
    margin-bottom:28px;
}

.stat-card{
    background:#fff;
    border-radius:22px;
    padding:28px;
    position:relative;
    overflow:hidden;
    box-shadow:0 8px 20px rgba(0,0,0,0.04);
}

.stat-card::before{
    content:"";
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:5px;
    background:linear-gradient(to right,#b98b4c,#d7b27c);
}

.stat-icon{
    width:62px;
    height:62px;
    border-radius:16px;
    background:rgba(185,139,76,0.12);
    display:flex;
    align-items:center;
    justify-content:center;
    color:#b98b4c;
    font-size:24px;
    margin-bottom:18px;
}

.stat-card h2{
    font-size:38px;
    margin-bottom:8px;
}

.stat-card p{
    color:#666;
    font-size:15px;
}

.table-section{
    background:#fff;
    border-radius:22px;
    padding:28px;
    box-shadow:0 8px 20px rgba(0,0,0,0.04);
    overflow-x:auto;
}

.table-header{
    margin-bottom:24px;
}

.table-header h2{
    font-size:30px;
    font-family:'Cormorant Garamond',serif;
}

table{
    width:100%;
    border-collapse:collapse;
    min-width:1200px;
}

table thead{
    background:#04142b;
    color:#fff;
}

table th{
    padding:17px;
    text-align:left;
    font-size:14px;
    font-weight:600;
    white-space:nowrap;
}

table td{
    padding:17px;
    border-bottom:1px solid #eee;
    font-size:14px;
    vertical-align:top;
}

.doctor-thumb{
    width:60px;
    height:60px;
    border-radius:50%;
    object-fit:cover;
    border:1px solid #ddd;
}


.status{
    padding:8px 14px;
    border-radius:30px;
    font-size:12px;
    font-weight:600;
}

.active{
    background:rgba(32,191,107,0.12);
    color:#20bf6b;
}

.inactive{
    background:rgba(235,87,87,0.12);
    color:#eb5757;
}

.action-buttons{
    display:flex;
    align-items:center;
    justify-content:flex-end;
    gap:8px;
    flex-wrap:nowrap;
    min-width:290px;
}

.action-buttons a,
.action-buttons button{
    white-space:nowrap;
}

.edit-btn,
.delete-btn,
.toggle-btn{
    border:none;
    padding:10px 14px;
    border-radius:10px;
    font-size:13px;
    font-weight:600;
    cursor:pointer;
}

.edit-btn{
    background:rgba(0,123,255,0.12);
    color:#007bff;
}

.delete-btn{
    background:rgba(235,87,87,0.12);
    color:#eb5757;
}

.active-btn{
    background:rgba(235,87,87,0.12);
    color:#eb5757;
}

.inactive-btn{
    background:rgba(32,191,107,0.12);
    color:#20bf6b;
}

.edit-modal{
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.55);
    display:none;
    align-items:center;
    justify-content:center;
    z-index:9999;
    overflow-y:auto;
    padding:20px;
}

.edit-modal-content{
    width:650px;
    max-width:95%;
    max-height:90vh;
    overflow-y:auto;
    background:#fff;
    border-radius:12px;
    padding:25px;
    position:relative;
}

.close-modal{
    position:absolute;
    top:20px;
    right:25px;
    font-size:30px;
    cursor:pointer;
}

.form-group{
    margin-bottom:12px;
}

.form-group label{
    display:block;
    margin-top: 14px;
    margin-bottom:8px;
    font-weight:600;
    font: size 14px;
}

.form-group input{
    width:100%;
    height:52px;
    border:1px solid #ddd;
    border-radius:12px;
    padding:0 16px;
}

.save-btn{
    width:100%;
    height:50px;
    border:none;
    border-radius:10px;
    background:linear-gradient(to right,#b98b4c,#d7b27c);
    color:#04142b;
    font-size:16px;
    font-weight:700;
    cursor:pointer;
    margin-top:15px;
}

</style>

</head>

<body>

<div class="dashboard-layout">

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
<a href="dashboard.php" class="active">
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
<a href="manage.php">
<i class="fa-solid fa-hospital-user"></i>
Manage Doctors
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

<main class="main-content">

<div class="topbar">

<h1>Doctor Management Dashboard</h1>

<a href="export-csv.php" class="csv-btn">

    <i class="fa-solid fa-file-csv"></i>

    Export CSV

</a>

</div>

<div class="stats-grid">

<div class="stat-card">

<div class="stat-icon">
<i class="fa-solid fa-user-doctor"></i>
</div>

<h2><?php echo $totalDoctors; ?></h2>

<p>Total Doctors</p>

</div>

<div class="stat-card">

<div class="stat-icon">
<i class="fa-solid fa-circle-check"></i>
</div>

<h2><?php echo $activeDoctors; ?></h2>

<p>Active Doctors</p>

</div>

<div class="stat-card">

<div class="stat-icon">
<i class="fa-solid fa-circle-xmark"></i>
</div>

<h2><?php echo $inactiveDoctors; ?></h2>

<p>Inactive Doctors</p>

</div>

</div>

<div class="table-section">

<div class="table-header">

<h2>Manage Doctors</h2>

</div>

<table>

<thead>
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
</thead>

<tbody>

<?php

$sr = 1;

while($doctor = mysqli_fetch_assoc($recentDoctors)){

?>

<tr>

<td><?php echo $sr++; ?></td>

<td>
    <?php echo $doctor['dr_id']; ?>
</td>

<td>
    <img
        src="../uploads/doctors/<?php echo $doctor['image']; ?>"
        class="doctor-thumb"
    >
</td>

<td><?php echo $doctor['display_name']; ?></td>
<td><?php echo $doctor['display_degree']; ?></td>
<td><?php echo $doctor['display_speciality']; ?></td>
<td><?php echo $doctor['display_experience']; ?></td>
<td><?php echo $doctor['display_languages']; ?></td>
<td><?php echo $doctor['consultation_type']; ?></td>
<td>₹<?php echo $doctor['clinic_fee']; ?></td>
<td>₹<?php echo $doctor['caring_squad_fee']; ?></td>

<td>

<span class="status <?php echo strtolower($doctor['status']); ?>">

<?php echo $doctor['status']; ?>

</span>

</td>

<td>

<div class="action-buttons">

<button
class="edit-btn"
onclick="openEditModal(
'<?php echo $doctor['id']; ?>',
'<?php echo addslashes($doctor['display_name']); ?>',
'<?php echo addslashes($doctor['display_degree']); ?>',
'<?php echo addslashes($doctor['display_speciality']); ?>',
'<?php echo addslashes($doctor['display_experience']); ?>',
'<?php echo addslashes($doctor['display_languages']); ?>',
'<?php echo addslashes($doctor['consultation_type']); ?>',
'<?php echo addslashes($doctor['clinic_fee']); ?>',
'<?php echo addslashes($doctor['caring_squad_fee']); ?>'
)"
>
Edit
</button>

<a
href="dashboard.php?toggle_id=<?php echo $doctor['id']; ?>"
class="<?php echo ($doctor['status'] == 'Active') ? 'active-btn' : 'inactive-btn'; ?> toggle-btn"
onclick="return confirm('Change doctor status?')"
>

<?php

if($doctor['status'] == 'Active'){
    echo "Inactive";
}else{
    echo "Active";
}

?>

</a>

<a
href="dashboard.php?delete_id=<?php echo $doctor['id']; ?>"
class="delete-btn"
onclick="return confirm('Are you sure you want to delete this doctor?')"
>
Delete
</a>

</div>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</main>

</div>

<!-- EDIT MODAL -->

<div class="edit-modal" id="editModal">

<div class="edit-modal-content">

<span class="close-modal" onclick="closeEditModal()">
&times;
</span>

<h2 style="margin-bottom:25px;">Edit Doctor</h2>

<form action="dashboard.php" method="POST" enctype="multipart/form-data">

<input type="hidden" name="id" id="edit_id">

<div class="form-group">

<label>Display Name</label>
<input type="text" name="display_name" id="edit_display_name">

<label>Degree</label>
<input type="text" name="display_degree" id="edit_display_degree">

<label>Speciality</label>
<input type="text" name="display_speciality" id="edit_display_speciality">

<label>Experience</label>
<input type="text" name="display_experience" id="edit_display_experience">

<label>Languages</label>
<input type="text" name="display_languages" id="edit_display_languages">

<label>Consultation Type</label>
<input type="text" name="consultation_type" id="edit_consultation_type">

<label>Standard Fee</label>
<input type="text" name="clinic_fee" id="edit_clinic_fee">

<label>Caring Squad Fee</label>
<input type="text" name="caring_squad_fee" id="edit_caring_squad_fee">

<label>Doctor Photo</label>
<input
    type="file"
    name="doctor_photo"
    accept="image/*"
    style="margin-bottom:10px;"
>

<button type="submit" name="update_doctor" class="save-btn">

Save Changes

</button>

</form>

</div>

</div>

<script>

function openEditModal(
id,
display_name,
display_degree,
display_speciality,
display_experience,
display_languages,
consultation_type,
clinic_fee,
caring_squad_fee
)

{
    document.getElementById('editModal').style.display='flex';

    document.getElementById('edit_id').value=id;

    document.getElementById('edit_display_name').value=display_name;
    document.getElementById('edit_display_degree').value=display_degree;
    document.getElementById('edit_display_speciality').value=display_speciality;
    document.getElementById('edit_display_experience').value=display_experience;
    document.getElementById('edit_display_languages').value=display_languages;
    document.getElementById('edit_consultation_type').value=consultation_type;
    document.getElementById('edit_clinic_fee').value=clinic_fee;
    document.getElementById('edit_caring_squad_fee').value=caring_squad_fee;
}

function closeEditModal()
{
    document.getElementById('editModal').style.display = 'none';
}

</script>

</body>
</html>