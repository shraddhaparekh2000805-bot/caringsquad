```php
<?php

session_start();

include '../db.php';

if(!isset($_SESSION['admin']))
{
    header("Location: login.php");
    exit();
}

$success = "";
$error = "";

if(isset($_POST['add_doctor']))
{

    /* ============================
       BASIC INFORMATION
    ============================ */

    $doctor_id = isset($_POST['doctor_id']) ? mysqli_real_escape_string($conn,$_POST['doctor_id']) : "";
    $full_name = isset($_POST['full_name']) ? mysqli_real_escape_string($conn,$_POST['full_name']) : "";
    $gender = isset($_POST['gender']) ? mysqli_real_escape_string($conn,$_POST['gender']) : "";
    $dob = isset($_POST['dob']) ? mysqli_real_escape_string($conn,$_POST['dob']) : "";
    $mobile = isset($_POST['mobile']) ? mysqli_real_escape_string($conn,$_POST['mobile']) : "";
    $whatsapp = isset($_POST['whatsapp']) ? mysqli_real_escape_string($conn,$_POST['whatsapp']) : "";
    $email = isset($_POST['email']) ? mysqli_real_escape_string($conn,$_POST['email']) : "";
    $city = isset($_POST['city']) ? mysqli_real_escape_string($conn,$_POST['city']) : "";
    $state_id = isset($_POST['state']) ? (int)$_POST['state'] : 0;


    /* ============================
       FRONTEND DATA
    ============================ */

    $display_name = isset($_POST['display_name']) ? mysqli_real_escape_string($conn,$_POST['display_name']) : "";
    $display_degree = isset($_POST['display_degree']) ? mysqli_real_escape_string($conn,$_POST['display_degree']) : "";
    $display_speciality = isset($_POST['display_speciality']) ? mysqli_real_escape_string($conn,$_POST['display_speciality']) : "";
    $display_experience = isset($_POST['display_experience']) ? mysqli_real_escape_string($conn,$_POST['display_experience']) : "";
    $display_languages = isset($_POST['display_languages']) ? mysqli_real_escape_string($conn,$_POST['display_languages']) : "";
    $consultation_type = isset($_POST['consultation_type']) ? mysqli_real_escape_string($conn,$_POST['consultation_type']) : "";


    /* ============================
       STATE NAME
    ============================ */

    $state = "";

    if($state_id > 0)
    {
        $stateQuery = mysqli_query(
            $conn,
            "SELECT state_name
             FROM states
             WHERE id='$state_id'"
        );

        if($stateQuery && mysqli_num_rows($stateQuery) > 0)
        {
            $stateData = mysqli_fetch_assoc($stateQuery);
            $state = $stateData['state_name'];
        }
    }


    /* ============================
       PROFESSIONAL DETAILS
    ============================ */

    $language = isset($_POST['language']) ? mysqli_real_escape_string($conn,$_POST['language']) : "";
    $degree = isset($_POST['degree']) ? mysqli_real_escape_string($conn,$_POST['degree']) : "";
    $specialization = isset($_POST['specialization']) ? mysqli_real_escape_string($conn,$_POST['specialization']) : "";
    $experience = isset($_POST['experience']) ? mysqli_real_escape_string($conn,$_POST['experience']) : "";
    $clinic_name = isset($_POST['clinic_name']) ? mysqli_real_escape_string($conn,$_POST['clinic_name']) : "";
    $clinic_fee = isset($_POST['clinic_fee']) ? mysqli_real_escape_string($conn,$_POST['clinic_fee']) : "";
    $caring_squad_fee = isset($_POST['cs_fee']) ? mysqli_real_escape_string($conn,$_POST['cs_fee']) : "";


    /* ============================
       INSERT DOCTOR
    ============================ */

    $insert = mysqli_query($conn,"
        INSERT INTO doctors
        (
            dr_id,
            name,
            gender,
            dob,
            mobile,
            whatsapp,
            email,
            city,
            state,
            language,
            degree,
            speciality,
            experience,
            hospital,
            clinic_fee,
            caring_squad_fee,
            display_name,
            display_degree,
            display_speciality,
            display_experience,
            display_languages,
            consultation_type
        )

        VALUES
        (
            '$doctor_id',
            '$full_name',
            '$gender',
            '$dob',
            '$mobile',
            '$whatsapp',
            '$email',
            '$city',
            '$state',
            '$language',
            '$degree',
            '$specialization',
            '$experience',
            '$clinic_name',
            '$clinic_fee',
            '$caring_squad_fee',
            '$display_name',
            '$display_degree',
            '$display_speciality',
            '$display_experience',
            '$display_languages',
            '$consultation_type'
        )
    ");

    if($insert)
    {
        $success = "Doctor details added successfully.";
    }
    else
    {
        $error = mysqli_error($conn);
    }

}

?>
```

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Doctor | Caring Squad</title>

    <!-- GOOGLE FONTS -->

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- FONT AWESOME -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>

        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body{

            font-family: 'Montserrat', sans-serif;
            background: #f7f3ee;
            color: #04142b;
        }

        a{
            text-decoration: none;
        }

        ul{
            list-style: none;
        }

        /* =====================================
           LAYOUT
        ===================================== */

        .dashboard-layout{
            display: flex;
            min-height: 100vh;
        }

        /* =====================================
           SIDEBAR
        ===================================== */

        .sidebar{
            width: 280px;
            background: #04142b;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            padding: 30px 22px;
        }

        .sidebar-logo{
            margin-bottom: 45px;
        }

        .sidebar-logo h2{
            font-family: 'Cormorant Garamond', serif;
            font-size: 38px;
            color: #d6af78;
        }

        .sidebar-logo p{
            color: #ccc;
            font-size: 13px;
            margin-top: 5px;
        }

        .sidebar-menu li{
            margin-bottom: 12px;
        }

        .sidebar-menu li a{
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 15px 18px;
            border-radius: 14px;
            color: #fff;
            font-size: 15px;
            transition: 0.3s;
        }

        .sidebar-menu li a:hover,
        .sidebar-menu li a.active{
            background: rgba(214,175,120,0.14);
            color: #d6af78;
        }

        /* =====================================
           MAIN CONTENT
        ===================================== */

        .main-content{
            margin-left: 280px;
            width: calc(100% - 280px);
            padding: 35px;
        }

        /* =====================================
           PAGE HEADER
        ===================================== */

        .page-header{
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .page-header h1{
            font-size: 38px;
            font-family: 'Cormorant Garamond', serif;
            color: #04142b;
        }

        .back-btn{
            background: #04142b;
            color: #fff;
            padding: 13px 22px;
            border-radius: 12px;
            font-size: 14px;
        }

        /* =====================================
           ALERTS
        ===================================== */

        .success-box{
            background: rgba(32,191,107,0.12);
            color: #20bf6b;
            padding: 16px 18px;
            border-radius: 14px;
            margin-bottom: 25px;
            font-size: 14px;
        }

        .error-box{
            background: rgba(235,87,87,0.12);
            color: #eb5757;
            padding: 16px 18px;
            border-radius: 14px;
            margin-bottom: 25px;
            font-size: 14px;
        }

        /* =====================================
           FORM SECTION
        ===================================== */

        .form-section{
            background: #fff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        }

        .section-top{
            padding: 28px 35px;
            background: linear-gradient(to right,#04142b,#0b2347);
            border-bottom: 1px solid rgba(214,175,120,0.15);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .section-title{
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .section-icon{
            width: 60px;
            height: 60px;
            border-radius: 18px;
            background: rgba(214,175,120,0.12);
            color: #d6af78;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            border: 1px solid rgba(214,175,120,0.20);
        }

        .section-title h2{
            font-size: 28px;
            font-family: 'Cormorant Garamond', serif;
            color: #fff;
            margin-bottom: 4px;
        }

        .section-title p{
            color: rgba(255,255,255,0.8);
            font-size: 13px;
        }

        .section-badge{
            background: rgba(214,175,120,0.12);
            color: #d6af78;
            border: 1px solid rgba(214,175,120,0.20);
            padding: 10px 18px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 600;
        }

        /* =====================================
           FORM BODY
        ===================================== */

        .section-body{
            padding: 35px;
        }

        .form-grid{
            display: grid;
            grid-template-columns: repeat(2,1fr);
            gap: 26px;
        }

        .form-group{
            display: flex;
            flex-direction: column;
        }

        .form-group.full{
            grid-column: span 2;
        }

        .form-group label{
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 12px;
            color: #04142b;
        }

        .input-box{
            position: relative;
        }

        .input-box i{
            position: absolute;
            top: 50%;
            left: 18px;
            transform: translateY(-50%);
            color: #b98b4c;
            font-size: 15px;
        }

        .input-box input,
        .input-box select{
            width: 100%;
            height: 58px;
            border: 1px solid #e5ddd2;
            border-radius: 16px;
            background: #fcfbf9;
            padding: 0 18px 0 50px;
            font-size: 14px;
            font-family: inherit;
            outline: none;
            transition: 0.3s;
        }

        .input-box input:focus,
        .input-box select:focus{
            border-color: #b98b4c;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(185,139,76,0.10);
        }

        /* =====================================
           NEXT SECTION
        ===================================== */

        .next-section{
            margin-top: 35px;
            background: #fff;
            border-radius: 24px;
            padding: 45px;
            text-align: center;
            border: 2px dashed #dccab4;
        }

        .next-section i{
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: rgba(214,175,120,0.12);
            color: #b98b4c;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            margin-bottom: 20px;
        }

        .next-section h3{
            font-size: 30px;
            font-family: 'Cormorant Garamond', serif;
            color: #04142b;
            margin-bottom: 10px;
        }

        .next-section p{
            color: #777;
            font-size: 14px;
        }

        /* =====================================
           RESPONSIVE
        ===================================== */

        @media(max-width:950px){

            .sidebar{
                display: none;
            }

            .main-content{
                margin-left: 0;
                width: 100%;
            }

            .form-grid{
                grid-template-columns: 1fr;
            }

            .form-group.full{
                grid-column: span 1;
            }

            .page-header{
                flex-direction: column;
                align-items: flex-start;
                gap: 18px;
            }

            .section-top{
                flex-direction: column;
                align-items: flex-start;
                gap: 18px;
            }
        }

    </style>

</head>

<body>

<div class="dashboard-layout">

    <!-- SIDEBAR -->

    <aside class="sidebar">

        <div class="sidebar-logo">

            <h2>Caring Squad</h2>

            <p>
                Admin Dashboard
            </p>

        </div>

        <ul class="sidebar-menu">

            <li>
                <a href="dashboard.php">
                    <i class="fa-solid fa-house"></i>
                    Dashboard
                </a>
            </li>

            <li>
                <a href="add-doctor.php" class="active">
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

    <!-- MAIN CONTENT -->

    <main class="main-content">

        <!-- PAGE HEADER -->

        <div class="page-header">

            <h1>
                Doctor Onboarding
            </h1>

            <a href="dashboard.php" class="back-btn">
                Back to Dashboard
            </a>

        </div>

        <!-- ALERTS -->

        <?php if($success != ""){ ?>

            <div class="success-box">

                <?php echo $success; ?>

            </div>

        <?php } ?>

        <?php if($error != ""){ ?>

            <div class="error-box">

                <?php echo $error; ?>

            </div>

        <?php } ?>

<form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="add_doctor" value="1">

<!-- =====================================
FRONTEND DATA SECTION
===================================== -->

<div class="form-section" style="margin-top:35px;">

    <div class="section-top">

        <div class="section-title">

            <div class="section-icon">
                <i class="fa-solid fa-display"></i>
            </div>

            <div>

                <h2>
                    Frontend Data
                </h2>

                <p>
                    Information that will be displayed on the website
                </p>

            </div>

        </div>

        <div class="section-badge">
            FRONTEND
        </div>

    </div>

    <div class="section-body">

        <div class="form-grid">

            <!-- Display Name -->

            <div class="form-group">

                <label>Doctor Display Name</label>

                <div class="input-box">

                    <i class="fa-solid fa-user-doctor"></i>

                    <input
                        type="text"
                        name="display_name"
                        placeholder=""
                        >

                </div>

            </div>

            <!-- Display Degree -->

            <div class="form-group">

                <label>Display Degree</label>

                <div class="input-box">

                    <i class="fa-solid fa-graduation-cap"></i>

                    <input
                        type="text"
                        name="display_degree"
                        placeholder=""
                        >

                </div>

            </div>

            <!-- Display Speciality -->

            <div class="form-group">

                <label>Display Speciality</label>

                <div class="input-box">

                    <i class="fa-solid fa-stethoscope"></i>

                    <input
                        type="text"
                        name="display_speciality"
                        placeholder=""
                        >

                </div>

            </div>

            <!-- Display Experience -->

            <div class="form-group">

                <label>Display Experience</label>

                <div class="input-box">

                    <i class="fa-solid fa-briefcase"></i>

                    <input
                        type="text"
                        name="display_experience"
                        placeholder=""
                        >

                </div>

            </div>

            <!-- Display Languages -->

            <div class="form-group">

                <label>Display Languages</label>

                <div class="input-box">

                    <i class="fa-solid fa-language"></i>

                    <input
                        type="text"
                        name="display_languages"
                        placeholder=""
                        >

                </div>

            </div>

            <!-- Consultation Type -->

            <div class="form-group">

                <label>Consultation Type</label>

                <div class="input-box">

                    <i class="fa-solid fa-video"></i>

                    <select
                        name="consultation_type"
                        
                    >

                        <option value="">Select</option>

                        <option value="Video Consultation">
                            Video Consultation
                        </option>

                        <option value="Audio Consultation">
                            Audio Consultation
                        </option>

                        <option value="Home Visit">
                            Home Visit
                        </option>

                    </select>

                </div>

            </div>

        </div>

    </div>

</div>

<div class="form-section" style="margin-top:35px;">
<!-- SECTION A -->


                <div class="section-top">

                    <div class="section-title">

                        <div class="section-icon">

                            <i class="fa-solid fa-user-doctor"></i>

                        </div>

                        <div>

                            <h2>
                                Basic Doctor Information
                            </h2>

                            <p>
                                Fill all  doctor personal details
                            </p>

                        </div>

                    </div>

                    <div class="section-badge">
                        SECTION A
                    </div>

                </div>

                <!-- SECTION BODY -->

                <div class="section-body">

                    <div class="form-grid">

                        <!-- DR ID -->

<div class="form-group">

    <label>
        Doctor ID
        
    </label>

    <div class="input-box">

        <i class="fa-solid fa-id-card"></i>

        <input
            type="text"
            name="doctor_id"
            
        >

    </div>

</div>

<!-- FULL NAME -->

<div class="form-group">

    <label>
        Full Name
    </label>

    <div class="input-box">

        <i class="fa-solid fa-user"></i>

        <input
            type="text"
            name="full_name"
            
        >

    </div>

</div>

                        <!-- GENDER -->

                        <div class="form-group">

                            <label>
                                Gender
            
                            </label>

                            <div class="input-box">

                                <i class="fa-solid fa-venus-mars"></i>

                                <select
                                    name="gender"
                                    
                                >

                                    <option value="">
                                        Select Gender
                                    </option>

                                    <option value="Male">
                                        Male
                                    </option>

                                    <option value="Female">
                                        Female
                                    </option>

                                    <option value="Other">
                                        Other
                                    </option>

                                </select>

                            </div>

                        </div>

                        <!-- DOB -->

                        <div class="form-group">

                            <label>
                                Date of Birth
                                
                            </label>

                            <div class="input-box">

                                <i class="fa-solid fa-calendar-days"></i>

                                <input
                                    type="text"
                                    name="dob"
                                    
                                >

                            </div>

                        </div>

                        <!-- MOBILE -->

                        <div class="form-group">

                            <label>
                                Mobile Number
                                
                            </label>

                            <div class="input-box">

                                <i class="fa-solid fa-phone"></i>

                                <input
                                    type="text"
                                    name="mobile"
                                    
                                >

                            </div>

                        </div>

                        <!-- WHATSAPP -->

                        <div class="form-group">

                            <label>
                                Whatsapp Number
                                
                            </label>

                            <div class="input-box">

                                <i class="fa-brands fa-whatsapp"></i>

                                <input
                                    type="text"
                                    name="whatsapp"
                                    
                                >

                            </div>

                        </div>

<!-- EMAIL -->

<div class="form-group">

    <label>
        Email Address
        
    </label>

    <div class="input-box">

        <i class="fa-solid fa-envelope"></i>

        <input
            type="text"
            name="email"
            
        >

    </div>

</div>

<!-- LANGUAGE -->

<div class="form-group">

    <label>
        Language Spoken
        
    </label>

    <div class="input-box">

        <i class="fa-solid fa-language"></i>

        <input
            type="text"
            name="language"
            
        >

    </div>

</div>

<!-- STATE -->

<div class="form-group">

    <label>
        State
        
    </label>

    <div class="input-box">

        <i class="fa-solid fa-location-dot"></i>

        <select
    name="state"
    id="state"
    
>

<option value="">
    Select State
</option>

<?php

$states = mysqli_query(
    $conn,
    "SELECT * FROM states
     ORDER BY state_name ASC"
);

while($state = mysqli_fetch_assoc($states))
{
?>

<option value="<?php echo $state['id']; ?>">

    <?php echo $state['state_name']; ?>

</option>

<?php } ?>

</select>

    </div>

</div>

<!-- CITY -->

<div class="form-group">

    <label>
        Current City
        
    </label>

    <div class="input-box">

        <i class="fa-solid fa-city"></i>

        <select
            name="city"
            id="city"
            
        >

            <option value="">
                Select City
            </option>

        </select>

    </div>

</div>

                    </div>

                </div>

            </div>

<!-- =====================================
SECTION B
===================================== -->

<div class="form-section" style="margin-top:35px;">

    <!-- SECTION TOP -->

    <div class="section-top">

        <div class="section-title">

            <div class="section-icon">

                <i class="fa-solid fa-user-doctor"></i>

            </div>

            <div>

                <h2>
                    Professional Details
                </h2>

                <p>
                    Fill doctor professional and practice details
                </p>

            </div>

        </div>

        <div class="section-badge">
            SECTION B
        </div>

    </div>

    <!-- SECTION BODY -->

    <div class="section-body">

        <div class="form-grid">

            <!-- PROFESSION -->

            <div class="form-group full">

                <label>
                    Profession
                    
                </label>

                <div class="input-box">

                    <i class="fa-solid fa-stethoscope"></i>

                    <select
                        name="profession"
                        
                    >

                        <option value="">
                            Select Profession
                        </option>

                        <option value="General Physician">
                            General Physician
                        </option>

                        <option value="Specialist Doctor">
                            Specialist Doctor
                        </option>

                        <option value="Physiotherapist">
                            Physiotherapist
                        </option>

                        <option value="Nutritionist">
                            Nutritionist
                        </option>

                        <option value="Dietician">
                            Dietician
                        </option>

                        <option value="Psychologist">
                            Psychologist
                        </option>

                        <option value="Psychiatrist">
                            Psychiatrist
                        </option>

                        <option value="Ayurveda Doctor">
                            Ayurveda Doctor
                        </option>

                        <option value="Homeopathy Doctor">
                            Homeopathy Doctor
                        </option>

                        <option value="Yoga Expert">
                            Yoga Expert
                        </option>

                        <option value="Wellness Coach">
                            Wellness Coach
                        </option>

                        <option value="Counsellor">
                            Counsellor
                        </option>

                        <option value="Other">
                            Other
                        </option>

                    </select>

                </div>

            </div>

<!-- Degree -->

<div class="form-group">

    <label>
        Degree
        
    </label>

    <div class="input-box">

        <i class="fa-solid fa-graduation-cap"></i>

        <select
            name="degree"
            
        >

            <option value="">
                Select Degree
            </option>

            <option value="MBBS">
                MBBS
            </option>

            <option value="MD">
                MD
            </option>

            <option value="MS">
                MS
            </option>

            <option value="BDS">
                BDS
            </option>

            <option value="MDS">
                MDS
            </option>

            <option value="BAMS">
                BAMS
            </option>

            <option value="BHMS">
                BHMS
            </option>

            <option value="BUMS">
                BUMS
            </option>

            <option value="BPT">
                BPT
            </option>

            <option value="MPT">
                MPT
            </option>

            <option value="PhD">
                PhD
            </option>

            <option value="Diploma">
                Diploma
            </option>

            <option value="Other">
                Other
            </option>

        </select>

    </div>

</div>

<!-- SPECIALIZATION -->

<div class="form-group">

    <label>
        Specialization
        
    </label>

    <div class="input-box">

        <i class="fa-solid fa-heart-pulse"></i>

        <select
            name="specialization"
            
        >

            <option value="">
                Select Specialization
            </option>

            <option value="Cardiologist">
                Cardiologist
            </option>

            <option value="Dermatologist">
                Dermatologist
            </option>

            <option value="Neurologist">
                Neurologist
            </option>

            <option value="Orthopedic">
                Orthopedic
            </option>

            <option value="Psychologist">
                Psychologist
            </option>

            <option value="Psychiatrist">
                Psychiatrist
            </option>

            <option value="Pediatrician">
                Pediatrician
            </option>

            <option value="Gynecologist">
                Gynecologist
            </option>

            <option value="Physiotherapist">
                Physiotherapist
            </option>

            <option value="Nutritionist">
                Nutritionist
            </option>

            <option value="General Physician">
                General Physician
            </option>

             <option value="General Physician">
                General Medicine
            </option>

            <option value="ENT Specialist">
                ENT Specialist
            </option>

            <option value="Other">
                Other
            </option>

        </select>

    </div>

</div>

            <!-- EXPERIENCE -->

            <div class="form-group">

                <label>
                    Years of Experience
                    
                </label>

                <div class="input-box">

                    <i class="fa-solid fa-briefcase"></i>

                    <select
                        name="experience"
                        
                    >

                        <option value="">
                            Select Experience
                        </option>

                        <option value="Fresher">
                            Fresher
                        </option>

                        <option value="1-3 Years">
                            1-3 Years
                        </option>

                        <option value="3-5 Years">
                            3-5 Years
                        </option>

                        <option value="5-10 Years">
                            5-10 Years
                        </option>

                        <option value="10-15 Years">
                            10-15 Years
                        </option>

                        <option value="15+ Years">
                            15+ Years
                        </option>

                    </select>

                </div>

            </div>

            <!-- CURRENT CLINIC -->

            <div class="form-group">

                <label>
                    Current Clinic / Hospital / Practice Name
                    
                </label>

                <div class="input-box">

                    <i class="fa-solid fa-hospital"></i>

                    <input
                        type="text"
                        name="clinic_name"
                        
                    >

                </div>

            </div>

            <!-- LICENSE NUMBER -->

            <div class="form-group">

                <label>
                    Registration Number / License Number
                    
                </label>

                <div class="input-box">

                    <i class="fa-solid fa-id-card"></i>

                    <input
                        type="text"
                        name="license_number"
                        
                    >

                </div>

            </div>

            <!-- COUNCIL -->

            <div class="form-group">

                <label>
                    Registration Council / Authority
                    
                </label>

                <div class="input-box">

                    <i class="fa-solid fa-building-columns"></i>

                    <input
                        type="text"
                        name="council"
                        
                    >

                </div>

            </div>

        </div>

    </div>

</div>

<!-- =====================================
     SECTION C
===================================== -->

<div class="form-section" style="margin-top:35px;">

    <!-- SECTION TOP -->

    <div class="section-top">

        <div class="section-title">

            <div class="section-icon">

                <i class="fa-solid fa-video"></i>

            </div>

            <div>

                <h2>
                    Online Consultation Details
                </h2>

                <p>
                    Configure online consultation availability and pricing
                </p>

            </div>

        </div>

        <div class="section-badge">
            SECTION C
        </div>

    </div>

    <!-- SECTION BODY -->

    <div class="section-body">

        <div class="form-grid">

            <!-- ONLINE CONSULTATION -->

            <div class="form-group">

                <label>
                    Available for Online Consultation
                    
                </label>

                <div class="input-box">

                    <i class="fa-solid fa-laptop-medical"></i>

                    <select
                        name="online_consultation"
                        
                    >

                        <option value="">
                            Select Option
                        </option>

                        <option value="Yes">
                            Yes
                        </option>

                        <option value="No">
                            No
                        </option>

                    </select>

                </div>

            </div>

            <!-- HOME VISIT -->

            <div class="form-group">

                <label>
                    Available for Home Visits
                    
                </label>

                <div class="input-box">

                    <i class="fa-solid fa-house-medical"></i>

                    <select
                        name="home_visit"
                        
                    >

                        <option value="">
                            Select Option
                        </option>

                        <option value="Yes">
                            Yes
                        </option>

                        <option value="No">
                            No
                        </option>

                        <option value="Depends on Location">
                            Depends on Location
                        </option>

                    </select>

                </div>

            </div>

            <!-- CONSULTATION MODE -->

            <div class="form-group full">

                <label>
                    Preferred Modes of Consultation
                    
                </label>

                <div class="checkbox-grid">

                    <label class="check-item">
                        <input type="checkbox" name="consultation_mode[]" value="Audio Consultation">
                        Audio Consultation
                    </label>

                    <label class="check-item">
                        <input type="checkbox" name="consultation_mode[]" value="Video Consultation">
                        Video Consultation
                    </label>

                    <label class="check-item">
                        <input type="checkbox" name="consultation_mode[]" value="Home Visit Consultation">
                        Home Visit Consultation
                    </label>

                </div>

            </div>

            <!-- CONSULTATION PLATFORM -->

            <div class="form-group full">

                <label>
                    Preferred Platform for Consultation
                    
                </label>

                <div class="checkbox-grid">

                    <label class="check-item">
                        <input type="checkbox" name="platform[]" value="WhatsApp Video Call">
                        WhatsApp Video Call
                    </label>

                    <label class="check-item">
                        <input type="checkbox" name="platform[]" value="Phone Call">
                        Phone Call
                    </label>

                    <label class="check-item">
                        <input type="checkbox" name="platform[]" value="Google Meet">
                        Google Meet
                    </label>

                    <label class="check-item">
                        <input type="checkbox" name="platform[]" value="Microsoft Teams">
                        Microsoft Teams
                    </label>

                    <label class="check-item">
                        <input type="checkbox" name="platform[]" value="Zoom">
                        Zoom
                    </label>

                    <label class="check-item">
                        <input type="checkbox" name="platform[]" value="Other">
                        Other
                    </label>

                </div>

            </div>

            <!-- WHATSAPP NUMBER -->

            <div class="form-group">

                <label>
                    WhatsApp Number for Video Consultation
                    
                </label>

                <div class="input-box">

                    <i class="fa-brands fa-whatsapp"></i>

                    <input
                        type="text"
                        name="video_whatsapp"
                        
                    >

                </div>

            </div>

            <!-- AUDIO NUMBER -->

            <div class="form-group">

                <label>
                    Mobile Number for Audio Consultation
                    
                </label>

                <div class="input-box">

                    <i class="fa-solid fa-phone-volume"></i>

                    <input
                        type="text"
                        name="audio_mobile"
                        
                    >

                </div>

            </div>

            <!-- STANDARD FEE -->

            <div class="form-group">

                <label>
                    Standard Clinic Consultation Fee (₹)
                    
                </label>

                <div class="input-box">

                    <i class="fa-solid fa-indian-rupee-sign"></i>

                    <input
                        type="text"
                        name="clinic_fee"
                        
                    >

                </div>

            </div>

            <!-- CARING SQUAD FEE -->

            <div class="form-group">

                <label>
                    Preferred Caring Squad Consultation Fee (₹)
                    
                </label>

                <div class="input-box">

                    <i class="fa-solid fa-money-bill"></i>

                    <input
                        type="text"
                        name="cs_fee"
                        
                    >

                </div>

            </div>

            <!-- PRIORITY FEE -->

            <div class="form-group">

                <label>
                    Priority Consultation Fee (₹)
                    
                </label>

                <div class="input-box">

                    <i class="fa-solid fa-bolt"></i>

                    <input
                        type="text"
                        name="priority_fee"
                        
                    >

                </div>

            </div>

            <!-- CONSULTATION DURATION -->

            <div class="form-group">

                <label>
                    Standard Consultation Duration
                    
                </label>

                <div class="input-box">

                    <i class="fa-solid fa-clock"></i>

                    <select
                        name="consultation_duration"
                        
                    >

                        <option value="">
                            Select Duration
                        </option>

                        <option value="Up to 30 Minutes">
                            Up to 30 Minutes
                        </option>

                        <option value="45 Minutes">
                            45 Minutes
                        </option>

                        <option value="60 Minutes">
                            60 Minutes
                        </option>

                    </select>

                </div>

            </div>

            <!-- CONSULTATION LANGUAGES -->

            <div class="form-group full">

                <label>
                    Preferred Consultation Languages
                    
                </label>

                <div class="checkbox-grid">

                    <label class="check-item">
                        <input type="checkbox" name="consultation_languages[]" value="English">
                        English
                    </label>

                    <label class="check-item">
                        <input type="checkbox" name="consultation_languages[]" value="Hindi">
                        Hindi
                    </label>

                    <label class="check-item">
                        <input type="checkbox" name="consultation_languages[]" value="Gujarati">
                        Gujarati
                    </label>

                    <label class="check-item">
                        <input type="checkbox" name="consultation_languages[]" value="Marathi">
                        Marathi
                    </label>

                    <label class="check-item">
                        <input type="checkbox" name="consultation_languages[]" value="Tamil">
                        Tamil
                    </label>

                    <label class="check-item">
                        <input type="checkbox" name="consultation_languages[]" value="Telugu">
                        Telugu
                    </label>

                    <label class="check-item">
                        <input type="checkbox" name="consultation_languages[]" value="Kannada">
                        Kannada
                    </label>

                    <label class="check-item">
                        <input type="checkbox" name="consultation_languages[]" value="Bengali">
                        Bengali
                    </label>

                    <label class="check-item">
                        <input type="checkbox" name="consultation_languages[]" value="Punjabi">
                        Punjabi
                    </label>

                    <label class="check-item">
                        <input type="checkbox" name="consultation_languages[]" value="Other">
                        Other
                    </label>

                </div>

            </div>

            <!-- AVAILABILITY -->

            <div class="form-group full">

                <label>
                    Standard Availability for Online Consultation
                    
                </label>

                <div class="checkbox-grid">

                    <label class="check-item">
                        <input type="checkbox" name="availability[]" value="06:00 AM - 09:00 AM">
                        06:00 AM - 09:00 AM
                    </label>

                    <label class="check-item">
                        <input type="checkbox" name="availability[]" value="09:00 AM - 12:00 PM">
                        09:00 AM - 12:00 PM
                    </label>

                    <label class="check-item">
                        <input type="checkbox" name="availability[]" value="12:00 PM - 03:00 PM">
                        12:00 PM - 03:00 PM
                    </label>

                    <label class="check-item">
                        <input type="checkbox" name="availability[]" value="03:00 PM - 06:00 PM">
                        03:00 PM - 06:00 PM
                    </label>

                    <label class="check-item">
                        <input type="checkbox" name="availability[]" value="06:00 PM - 09:00 PM">
                        06:00 PM - 09:00 PM
                    </label>

                    <label class="check-item">
                        <input type="checkbox" name="availability[]" value="09:00 PM - 11:00 PM">
                        09:00 PM - 11:00 PM
                    </label>

                    <label class="check-item">
                        <input type="checkbox" name="availability[]" value="Night Consultation">
                        Available During Night for Immediate or NRI Consultation
                    </label>

                </div>

            </div>

            <!-- AVAILABLE DAYS -->

            <div class="form-group full">

                <label>
                    Available Days for Online Consultation
                    
                </label>

                <div class="checkbox-grid">

                    <label class="check-item">
                        <input type="checkbox" name="available_days[]" value="Monday">
                        Monday
                    </label>

                    <label class="check-item">
                        <input type="checkbox" name="available_days[]" value="Tuesday">
                        Tuesday
                    </label>

                    <label class="check-item">
                        <input type="checkbox" name="available_days[]" value="Wednesday">
                        Wednesday
                    </label>

                    <label class="check-item">
                        <input type="checkbox" name="available_days[]" value="Thursday">
                        Thursday
                    </label>

                    <label class="check-item">
                        <input type="checkbox" name="available_days[]" value="Friday">
                        Friday
                    </label>

                    <label class="check-item">
                        <input type="checkbox" name="available_days[]" value="Saturday">
                        Saturday
                    </label>

                    <label class="check-item">
                        <input type="checkbox" name="available_days[]" value="Sunday">
                        Sunday
                    </label>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- EXTRA CSS FOR CHECKBOX DESIGN -->

<style>

.checkbox-grid{

    display: grid;

    grid-template-columns: repeat(2,1fr);

    gap: 18px;

    margin-top: 10px;
}

.check-item{

    display: flex;

    align-items: center;

    gap: 12px;

    background: #fcfbf9;

    border: 1px solid #e5ddd2;

    border-radius: 14px;

    padding: 16px 18px;

    font-size: 14px;

    font-weight: 500;

    color: #04142b;
}

.check-item input[type="checkbox"]{

    width: 18px;
    height: 18px;

    accent-color: #d6af78;
}

@media(max-width:768px){

    .checkbox-grid{

        grid-template-columns: 1fr;
    }
}

</style>

<!-- =====================================
     SECTION D
===================================== -->

<div class="form-section" style="margin-top:35px;">

    <!-- SECTION TOP -->

    <div class="section-top">

        <div class="section-title">

            <div class="section-icon">

                <i class="fa-solid fa-bolt"></i>

            </div>

            <div>

                <h2>
                    Priority / Emergency Consultation
                </h2>

                <p>
                    Configure emergency consultation availability and charges
                </p>

            </div>

        </div>

        <div class="section-badge">
            SECTION D
        </div>

    </div>

    <!-- SECTION BODY -->

    <div class="section-body">

        <div class="form-grid">

            <!-- PRIORITY CONSULTATION -->

            <div class="form-group">

                <label>
                    Available for Priority / Emergency Consultation?
                    
                </label>

                <div class="input-box">

                    <i class="fa-solid fa-siren-on"></i>

                    <select
                        name="priority_consultation"
                        
                    >

                        <option value="">
                            Select Option
                        </option>

                        <option value="Yes">
                            Yes
                        </option>

                        <option value="No">
                            No
                        </option>

                    </select>

                </div>

            </div>

            <!-- RESPONSE TIME -->

            <div class="form-group">

                <label>
                    Priority Consultation Response Time
                    
                </label>

                <div class="input-box">

                    <i class="fa-solid fa-clock"></i>

                    <select
                        name="response_time"
                        
                    >

                        <option value="">
                            Select Response Time
                        </option>

                        <option value="Within 15 Minutes">
                            Within 15 Minutes
                        </option>

                        <option value="Within 30 Minutes">
                            Within 30 Minutes
                        </option>

                        <option value="Within 1 Hour">
                            Within 1 Hour
                        </option>

                        <option value="Within 2 Hours">
                            Within 2 Hours
                        </option>

                        <option value="Same Day">
                            Same Day
                        </option>

                        <option value="Subject to Availability">
                            Subject to Availability
                        </option>

                    </select>

                </div>

            </div>

            <!-- EMERGENCY CHARGES -->

            <div class="form-group">

                <label>
                    Priority / Emergency Consultation Charges (₹)
                    
                </label>

                <div class="input-box">

                    <i class="fa-solid fa-indian-rupee-sign"></i>

                    <input
                        type="number"
                        name="emergency_charges"
                        
                    >

                </div>

            </div>

            <!-- MAX CONSULTATIONS -->

            <div class="form-group">

                <label>
                    Maximum Priority Consultations Per Day
                    
                </label>

                <div class="input-box">

                    <i class="fa-solid fa-user-clock"></i>

                    <input
                        type="number"
                        name="max_priority_consultation"
                        
                    >

                </div>

            </div>

        </div>

    </div>

</div>

<!-- =====================================
    SECTION E
===================================== -->

<div class="form-section" style="margin-top:35px;">

    <!-- SECTION TOP -->

    <div class="section-top">

        <div class="section-title">

            <div class="section-icon">

                <i class="fa-solid fa-notes-medical"></i>

            </div>

            <div>

                <h2>
                    Follow-up Consultation Policy
                </h2>

                <p>
                    Configure follow-up consultation and prescription settings
                </p>

            </div>

        </div>

        <div class="section-badge">
            SECTION E
        </div>

    </div>

    <!-- SECTION BODY -->

    <div class="section-body">

        <div class="form-grid">

            <!-- FOLLOW UP AVAILABLE -->

            <div class="form-group">

                <label>
                    Follow-up Consultation Available?
                    
                </label>

                <div class="input-box">

                    <i class="fa-solid fa-user-doctor"></i>

                    <select
                        name="followup_available"
                        
                    >

                        <option value="">
                            Select Option
                        </option>

                        <option value="Yes">
                            Yes
                        </option>

                        <option value="No">
                            No
                        </option>

                    </select>

                </div>

            </div>

            <!-- FOLLOW UP FEE -->

            <div class="form-group">

                <label>
                    Follow-up Consultation Fee (₹)
                    
                </label>

                <div class="input-box">

                    <i class="fa-solid fa-indian-rupee-sign"></i>

                    <input
                        type="text"
                        name="followup_fee"
                        
                    >

                </div>

            </div>

            <!-- FREE FOLLOW UP PERIOD -->

            <div class="form-group">

                <label>
                    Free Follow-up Period
                    
                </label>

                <div class="input-box">

                    <i class="fa-solid fa-calendar-check"></i>

                    <select
                        name="free_followup_period"
                        
                    >

                        <option value="">
                            Select Period
                        </option>

                        <option value="No Free Follow-up">
                            No Free Follow-up
                        </option>

                        <option value="Within 3 Days">
                            Within 3 Days
                        </option>

                        <option value="Within 7 Days">
                            Within 7 Days
                        </option>

                        <option value="Within 15 Days">
                            Within 15 Days
                        </option>

                        <option value="Within 30 Days">
                            Within 30 Days
                        </option>

                    </select>

                </div>

            </div>

            <!-- REPORT REVIEW -->

            <div class="form-group">

                <label>
                    Reports Review Available?
                    
                </label>

                <div class="input-box">

                    <i class="fa-solid fa-file-medical"></i>

                    <select
                        name="report_review"
                        
                    >

                        <option value="">
                            Select Option
                        </option>

                        <option value="Yes">
                            Yes
                        </option>

                        <option value="No">
                            No
                        </option>

                    </select>

                </div>

            </div>

            <!-- DIGITAL PRESCRIPTION -->

            <div class="form-group full">

                <label>
                    Digital Prescription Available?
                    
                </label>

                <div class="input-box">

                    <i class="fa-solid fa-prescription"></i>

                    <select
                        name="digital_prescription"
                        
                    >

                        <option value="">
                            Select Option
                        </option>

                        <option value="Yes">
                            Yes
                        </option>

                        <option value="No">
                            No
                        </option>

                        <option value="Other">
                            Other
                        </option>

                    </select>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- =====================================
     SECTION F
===================================== -->

<div class="form-section" style="margin-top:35px;">

    <!-- SECTION TOP -->

    <div class="section-top">

        <div class="section-title">

            <div class="section-icon">

                <i class="fa-solid fa-house-medical"></i>

            </div>

            <div>

                <h2>
                    Home Visit Consultation
                </h2>

                <p>
                    Configure home visit availability and consultation charges
                </p>

            </div>

        </div>

        <div class="section-badge">
            SECTION F
        </div>

    </div>

    <!-- SECTION BODY -->

    <div class="section-body">

        <div class="form-grid">

            <!-- HOME VISIT AVAILABLE -->

            <div class="form-group">

                <label>
                    Available for Home Visits?
                    
                </label>

                <div class="input-box">

                    <i class="fa-solid fa-house-chimney-medical"></i>

                    <select
                        name="home_visit_available"
                        
                    >

                        <option value="">
                            Select Option
                        </option>

                        <option value="Yes">
                            Yes
                        </option>

                        <option value="No">
                            No
                        </option>

                    </select>

                </div>

            </div>

            <!-- SERVICE RADIUS -->

            <div class="form-group">

                <label>
                    Service Radius
                    
                </label>

                <div class="input-box">

                    <i class="fa-solid fa-location-dot"></i>

                    <select
                        name="service_radius"
                        
                    >

                        <option value="">
                            Select Radius
                        </option>

                        <option value="5 KM">
                            5 KM
                        </option>

                        <option value="10 KM">
                            10 KM
                        </option>

                        <option value="20 KM">
                            20 KM
                        </option>

                        <option value="30 KM">
                            30 KM
                        </option>

                        <option value="Entire City">
                            Entire City
                        </option>

                    </select>

                </div>

            </div>

            <!-- HOME VISIT FEE -->

            <div class="form-group full">

                <label>
                    Home Visit Consultation Fee (₹)
                    
                </label>

                <div class="input-box">

                    <i class="fa-solid fa-indian-rupee-sign"></i>

                    <input
                        type="text"
                        name="home_visit_fee"
                        
                    >

                </div>

            </div>

        </div>

    </div>

</div>

<!-- =====================================
     SECTION G
===================================== -->

<div class="form-section" style="margin-top:35px;">

    <!-- SECTION TOP -->

    <div class="section-top">

        <div class="section-title">

            <div class="section-icon">

                <i class="fa-solid fa-id-card"></i>

            </div>

            <div>

                <h2>
                    Professional Profile
                </h2>

                <p>
                    Upload professional documents and profile information
                </p>

            </div>

        </div>

        <div class="section-badge">
            SECTION G
        </div>

    </div>

    <!-- SECTION BODY -->

    <div class="section-body">

        <div class="form-grid">

            <!-- PROFESSIONAL PHOTO -->

            <div class="form-group">

                <label>
                    Upload Professional Photograph
                   <!--  -->
                </label>

                <div class="input-box">

                    <i class="fa-solid fa-camera"></i>

                    <input
                        type="file"
                        name="doctor_photo"
                        accept="image/*"
                        
                    >

                </div>

            </div>

            <!-- DEGREE CERTIFICATES -->

            <div class="form-group">

                <label>
                    Upload Degree Certificate(s)
                    <!--  -->
                </label>

                <div class="input-box">

                    <i class="fa-solid fa-graduation-cap"></i>

                    <input
                        type="file"
                        name="degree_certificate[]"
                        multiple
                        
                    >

                </div>

            </div>

            <!-- REGISTRATION CERTIFICATE -->

            <div class="form-group">

                <label>
                    Upload Registration Certificate / License
                   <!--  -->
                </label>

                <div class="input-box">

                    <i class="fa-solid fa-certificate"></i>

                    <input
                        type="file"
                        name="registration_certificate"
                        
                    >

                </div>

            </div>

            <!-- GOVERNMENT ID -->

            <div class="form-group">

                <label>
                    Upload Government ID Proof
                   <!--  -->
                </label>

                <div class="input-box">

                    <i class="fa-solid fa-address-card"></i>

                    <input
                        type="file"
                        name="government_id"
                        
                    >

                </div>

            </div>

            <!-- LINKEDIN -->

            <div class="form-group">

                <label>
                    LinkedIn Profile
                    <span style="color:#888;font-weight:500;">
                        (Optional)
                    </span>
                </label>

                <div class="input-box">

                    <i class="fa-brands fa-linkedin"></i>

                    <input
                        type="url"
                        name="linkedin_profile"
                    >

                </div>

            </div>

            <!-- WEBSITE -->

            <div class="form-group">

                <label>
                    Website / Social Media Profile
                    <span style="color:#888;font-weight:500;">
                        (Optional)
                    </span>
                </label>

                <div class="input-box">

                    <i class="fa-solid fa-globe"></i>

                    <input
                        type="url"
                        name="website_profile"
                    >

                </div>

            </div>

            <!-- PROFESSIONAL BIO -->

            <div class="form-group full">

                <label>
                    Professional Bio / Introduction
                    
                </label>

                <div class="input-box">

                    <i class="fa-solid fa-user-doctor"></i>

                    <textarea
                        name="professional_bio"
                        rows="6"
                        
                        style="
                            width:100%;
                            border:1px solid #e5ddd2;
                            border-radius:16px;
                            background:#fcfbf9;
                            padding:18px 18px 18px 50px;
                            font-size:14px;
                            font-family:inherit;
                            outline:none;
                            resize:none;
                        "
                    ></textarea>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- =====================================
     SECTION H
===================================== -->

<div class="form-section" style="margin-top:35px;">

    <!-- SECTION TOP -->

    <div class="section-top">

        <div class="section-title">

            <div class="section-icon">

                <i class="fa-solid fa-handshake-angle"></i>

            </div>

            <div>

                <h2>
                    About You
                </h2>

                <p>
                    Share your motivation and support for Caring Squad mission
                </p>

            </div>

        </div>

        <div class="section-badge">
            SECTION H
        </div>

    </div>

    <!-- SECTION BODY -->

    <div class="section-body">

        <div class="form-grid">

            <!-- WHY JOIN CARING SQUAD -->

            <div class="form-group full">

                <label>
                    Why Would You Like To Join Caring Squad?
                    
                </label>

                <div class="checkbox-grid">

                    <label class="check-item">
                        <input type="checkbox" name="join_reason[]" value="Healthcare Accessibility Mission">
                        Healthcare Accessibility Mission
                    </label>

                    <label class="check-item">
                        <input type="checkbox" name="join_reason[]" value="Additional Patient Reach">
                        Additional Patient Reach
                    </label>

                    <label class="check-item">
                        <input type="checkbox" name="join_reason[]" value="Online Consultation Opportunities">
                        Online Consultation Opportunities
                    </label>

                    <label class="check-item">
                        <input type="checkbox" name="join_reason[]" value="Home Visit Opportunities">
                        Home Visit Opportunities
                    </label>

                    <label class="check-item">
                        <input type="checkbox" name="join_reason[]" value="Flexible Practice">
                        Flexible Practice
                    </label>

                    <label class="check-item">
                        <input type="checkbox" name="join_reason[]" value="Digital Presence">
                        Digital Presence
                    </label>

                    <label class="check-item">
                        <input type="checkbox" name="join_reason[]" value="Professional Networking">
                        Professional Networking
                    </label>

                    <label class="check-item">
                        <input type="checkbox" name="join_reason[]" value="Community Service">
                        Community Service
                    </label>

                    <label class="check-item">
                        <input type="checkbox" name="join_reason[]" value="Treat the remote patient">
                        Treat the remote patient
                    </label>

                    <label class="check-item">
                        <input type="checkbox" name="join_reason[]" value="Other">
                        Other
                    </label>

                </div>

            </div>

            <!-- SPECIAL CONSULTATION FEE -->

            <div class="form-group full">

                <label>
                    Would you be willing to offer a special Caring Squad consultation fee to support healthcare accessibility?
                    
                </label>

                <div class="form-grid">

                    <div class="input-box">

                        <i class="fa-solid fa-heart"></i>

                        <select
                            name="special_consultation_fee"
                            
                        >

                            <option value="">
                                Select Option
                            </option>

                            <option value="Yes">
                                Yes
                            </option>

                            <option value="No">
                                No
                            </option>

                            <option value="If Yes, then how much">
                                If Yes, then how much
                            </option>

                            <option value="Depends on Case">
                                Depends on Case
                            </option>

                        </select>

                    </div>

                    <div class="input-box">

                        <i class="fa-solid fa-indian-rupee-sign"></i>

                        <input
                            type="number"
                            name="special_fee_amount"
                            placeholder="Enter Special Consultation Fee Amount"
                        >

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<style>

    .form-action-bar{

        display: flex;

        align-items: center;
        justify-content: space-between;

        margin-top: 40px;

        padding-bottom: 40px;
    }

    .clear-btn{

        border: none;

        background: transparent;

        color: #8b5247;

        font-size: 18px;

        font-weight: 500;

        font-family: inherit;

        cursor: pointer;

        transition: 0.3s;
    }

    .clear-btn:hover{

        color: #04142b;
    }

    .submit-btn{

        border: none;

        background: linear-gradient(to right,#04142b,#0b2247);

        color: #fff;

        height: 56px;

        padding: 0 36px;

        border-radius: 14px;

        font-size: 15px;

        font-weight: 600;

        font-family: inherit;

        cursor: pointer;

        display: flex;

        align-items: center;

        gap: 10px;

        transition: 0.3s;
    }

    .submit-btn:hover{

        transform: translateY(-2px);

        box-shadow: 0 12px 24px rgba(4,20,43,0.20);
    }

    @media(max-width:768px){

        .form-action-bar{

            flex-direction: column-reverse;

            align-items: stretch;

            gap: 16px;
        }

        .submit-btn{

            justify-content: center;
        }

        .clear-btn{

            text-align: center;
        }
    }

</style>

<!-- =====================================
     FORM BUTTONS
===================================== -->

<div class="form-action-bar">

    <!-- LEFT SIDE -->

    <button
        type="reset"
        class="clear-btn"
    >
        Clear Form
    </button>

    <!-- RIGHT SIDE -->

    <button
        type="submit"
        name="add_doctor"
        class="submit-btn"
    >
        Submit
    </button>

</div>

</form>

    </main>

</div>

<script>

$(document).ready(function(){

    $('#state').change(function(){

        var state_id = $(this).val();

        $.ajax({

            url:'get_cities.php',

            type:'POST',

            data:{
                state_id:state_id
            },

            success:function(response){

                $('#city').html(response);

            }

        });

    });

});

</script>

</body>
</html>