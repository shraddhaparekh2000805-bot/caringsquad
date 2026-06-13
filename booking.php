<?php

include 'db.php';

/* =========================================
   PAGINATION
========================================= */

$limit = 4;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

if($page < 1){
    $page = 1;
}

$start = ($page - 1) * $limit;

/* =========================================
   SEARCH + FILTER
========================================= */

$search = isset($_GET['search']) ? $_GET['search'] : '';
$speciality = isset($_GET['speciality']) ? trim($_GET['speciality']) : '';

/* FIX SPECIALITY ARRAY ERROR */

if(is_array($speciality)){
    $speciality = $speciality[0];
}

$where = "WHERE 1";

/* SEARCH */

if(!empty($search)){

    $search = mysqli_real_escape_string($conn, $search);

    $where .= " AND (
        name LIKE '%$search%' OR
        speciality LIKE '%$search%' OR
        degree LIKE '%$search%'
    )";
}

/* SPECIALITY FILTER */

if(isset($speciality) && $speciality != ''){

    $speciality = mysqli_real_escape_string($conn, $speciality);

    $where .= " AND speciality LIKE '%$speciality%'";
}

/* =========================================
   TOTAL RECORDS
========================================= */

$totalQuery = mysqli_query(
    $conn,
    "SELECT COUNT(*) as total FROM doctors $where"
);

$totalData = mysqli_fetch_assoc($totalQuery);

$totalRecords = $totalData['total'];

$totalPages = ceil($totalRecords / $limit);

/* =========================================
   FETCH DOCTORS
========================================= */

$query = mysqli_query(
    $conn,
    "SELECT * FROM doctors
    $where
    ORDER BY id DESC
    LIMIT $start,$limit"
);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Consult a Doctor | Caring Squad</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="style.css">

<style>

/* =====================================================
   BOOKING PAGE ONLY CSS
===================================================== */

.booking-main{
    padding:70px 0 100px;
}

/* =====================================================
   LAYOUT
===================================================== */

.booking-layout{
    display:grid;
    grid-template-columns:280px 1fr;
    gap:24px;
    align-items:start;
}

/* =====================================================
   RESULT HEADER
===================================================== */

.doctor-list-top{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.doctor-list-top h2{
    color:#061326;
    font-size:32px;
    font-weight:700;
}

/* =====================================================
   DOCTOR LIST
===================================================== */

.doctor-list-grid{
    display:flex;
    flex-direction:column;
    gap:22px;
}

/* =====================================================
   DOCTOR CARD
===================================================== */

.doctor-card{
    background:#fff;
    border:1px solid #e6ddd0;
    border-radius:15px;
    padding:20px 25px;

    display:grid;
    grid-template-columns:170px 1fr 420px;

    align-items:center;
    gap:34px;

    transition:.3s ease;
}

.doctor-card:hover{
    transform:translateY(-3px);
    box-shadow:0 12px 30px rgba(0,0,0,.06);
}

/* =====================================================
   IMAGE
===================================================== */

.doctor-image{
    width: 180px;
    height: 180px;
    border-radius:11px;
    overflow:hidden;
    background:#f5f5f5;
}

.doctor-image img{
    width: 200px;
    height: 200px;
    object-fit:cover;
}

/* =====================================================
   DOCTOR INFO
===================================================== */

.doctor-info{
    display:flex;
    flex-direction:column;
    justify-content:center;
}

.doctor-name{
    font-size:28px;
    font-weight:700;
    color:#061326;
    margin-bottom:8px;
}

.doctor-degree{
    font-size:16px;
    color:#666;
    margin-bottom:12px;
}

.doctor-speciality{
    color:#c89b4d;
    font-size:17px;
    font-weight:600;
    margin-bottom:14px;
}

.doctor-meta{
    display:flex;
    gap:25px;
    align-items:center;
}

.doctor-meta span{
    display:flex;
    align-items:center;
    gap:8px;

    font-size:16px;
    color:#444;
}

.doctor-meta i{
    color:#111;
}

/* =====================================================
   RIGHT PANEL
===================================================== */

.doctor-right{
    border-left:1px solid #e5e5e5;
    padding-left:34px;

    display:flex;
    flex-direction:column;
    justify-content:center;
}

.detail-row{
    display:flex;
    justify-content:space-between;
    align-items:center;

    padding:14px 0;

    border-bottom:1px solid #ececec;
}

.detail-row:last-child{
    border-bottom:none;
}

.detail-row span{
    display:flex;
    align-items:center;
    gap:10px;

    color:#666;
    font-size:15px;
}

.detail-row strong{
    font-size:15px;
    font-weight:700;
    color:#061326;
}

.consultation-fees-box{
    margin-bottom:8px;
}

.fee-row{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:18px 0;
    border-bottom:1px solid #ececec;
}

.fee-row span{
    color:#666;
    font-size:15px;
}

.standard-fee{
    color:#061326;
    font-size:18px;
    font-weight:700;
}

.caring-fee{
    color:#c89b4d;
    font-size:20px;
    font-weight:700;
}

.gold{
    color:#c89b4d !important;
}

/* =====================================================
   BUTTON
===================================================== */

.book-btn{
    width:100%;
    height:52px;

    margin-top:18px;

    display:flex;
    align-items:center;
    justify-content:center;

    background:#071633;
    color:#fff;

    border-radius:10px;

    font-size:18px;
    font-weight:600;
}

.book-btn:hover{
    background:#b88737;
    color:#fff;
}

/* =====================================================
   PAGINATION
===================================================== */

.pagination{
    margin-top:35px;
    display:flex;
    justify-content:center;
    gap:10px;
}

.pagination a{
    width:44px;
    height:44px;

    display:flex;
    align-items:center;
    justify-content:center;

    background:#fff;
    border:1px solid #ddd;
    border-radius:10px;

    color:#061326;
    font-weight:600;
}

.active-page{
    background:#061326 !important;
    color:#fff !important;
}

/* =====================================================
   RESPONSIVE
===================================================== */

@media(max-width:1200px){

    .doctor-card{
        flex-direction:column;
        align-items:flex-start;
    }

    .doctor-right{
        width:100%;
        border-left:none;
        border-top:1px solid #ececec;
        padding-left:0;
        padding-top:25px;
    }
}

@media(max-width:992px){

    .booking-layout{
        grid-template-columns:1fr;
    }

    .filter-sidebar{
        position:static;
    }
}

@media(max-width:768px){

    .doctor-left{
        flex-direction:column;
        align-items:flex-start;
    }

    .doctor-image{
        width:100%;
        height:240px;
    }

    .doctor-name{
        font-size:28px;
    }

    .doctor-degree{
        font-size:16px;
    }

    .doctor-speciality{
        font-size:18px;
    }

    .doctor-meta span{
        font-size:15px;
    }

    .detail-row{
        flex-direction:column;
        align-items:flex-start;
        gap:8px;
    }

    .book-btn{
        font-size:18px;
    }
}
</style>

</head>

<body>

<!-- =========================================
   HEADER
========================================= -->

<header class="header">

    <div class="container nav-container">

        <div class="logo">

            <div class="logo-icon">
                <i class="fa-regular fa-heart"></i>
            </div>

            <div class="logo-text">
                <h2>CARING SQUAD</h2>
                <span>Care | Companions | Wellness</span>
            </div>

        </div>

        <nav class="navbar">
            <ul class="nav-links">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">Our Story</a></li>
                    <li><a href="doctor.php">Expert Consultation</a></li>
                    <li><a href="care.php">Care</a></li>
                    <li><a href="companion.php">Companion</a></li>
                    <li><a href="travel.php">Travel Companion</a></li>
                    <li><a href="cityguardian.php">City Guardian</a></li>
                    <li><a href="#">Other</a></li>
                </ul>

        </nav>

        <div class="header-phone">
            <i class="fa-solid fa-phone"></i>
            <span>1800 571 1929</span>
        </div>

    </div>

</header>

<!-- =========================================
   HERO
========================================= -->

<section class="booking-hero">

    <div class="container">

        <div class="booking-hero-content">

            <h1>
                Find the Right Doctor <br>
                <span>for Your Health Needs</span>
            </h1>

            <p>
                Search, compare and consult with verified specialists
                from the comfort of your home.
            </p>

        </div>

    </div>

</section>

<!-- =========================================
   SEARCH BAR
========================================= -->

<section class="doctor-search-section">

    <div class="container">

        <form method="GET" class="doctor-search-bar">

            <div class="search-group">

                <label>Search Doctor / Speciality</label>

                <input
                    type="text"
                    name="search"
                    placeholder="e.g. Orthopedic, Dr. Neha Mehta..."
                    value="<?php echo $search; ?>"
                >

            </div>

            <div class="search-group">

                <label>Speciality</label>

                <select name="speciality">

                    <option value="">All Specialities</option>

                    <option value="General Physician">General Physician</option>

                    <option value="Psychologist">Psychologist</option>

                    <option value="Orthopedic Surgeon">Orthopedic Surgeon</option>

                    <option value="Dermatologist">Dermatologist</option>

                </select>

            </div>

            <button type="submit" class="search-btn">
                Search Doctors
                <i class="fa-solid fa-arrow-right"></i>
            </button>

        </form>

    </div>

</section>

<!-- =========================================
   MAIN SECTION
========================================= -->

<section class="booking-main">

    <div class="container">

        <div class="booking-layout">

            <!-- =================================
               FILTER SIDEBAR
            ================================= -->

            <form method="GET" class="filter-sidebar">

                <div class="filter-header">

                    <h3>Filter Doctors</h3>

                    <a href="booking.php">Clear All</a>

                </div>

                <div class="filter-block">

    <h4>Speciality</h4>

    <ul>

        <li>
            <label>
                <input type="checkbox" name="speciality[]" value="General Physician">
                General Physician
            </label>
        </li>

        <li>
            <label>
                <input type="checkbox" name="speciality[]" value="Orthopedic Surgeon">
                Orthopedic
            </label>
        </li>

        <li>
            <label>
                <input type="checkbox" name="speciality[]" value="Psychologist">
                Psychologist
            </label>
        </li>

        <li>
            <label>
                <input type="checkbox" name="speciality[]" value="Dermatologist">
                Dermatologist
            </label>
        </li>

        <li>
            <label>
                <input type="checkbox" name="speciality[]" value="Pediatrician">
                Pediatrician
            </label>
        </li>

    </ul>

</div>

<div class="filter-block">

    <h4>Consultation Type</h4>

    <ul>

        <li><input type="checkbox"> Video Consultation</li>
        <li><input type="checkbox"> Voice Consultation</li>

    </ul>

</div>

<div class="filter-block">

    <h4>Availability</h4>

    <ul>

        <li><input type="checkbox"> Available Now</li>
        <li><input type="checkbox"> Today</li>
        <li><input type="checkbox"> Tomorrow</li>

    </ul>

</div>

<div class="filter-btn-wrap">

    <button type="submit" class="apply-filter-btn">
        Apply Filters
    </button>

</div>

            </form>

            <!-- =================================
               DOCTOR LIST
            ================================= -->

            <div class="doctor-list-area">

                <div class="doctor-list-top">

                    <h3>
                        <?php echo $totalRecords; ?> Doctors Found
                    </h3>

                </div>

                <!-- DOCTORS -->

                <?php
if(mysqli_num_rows($query) > 0){

    while($doctor = mysqli_fetch_assoc($query)){
?>

<div class="doctor-card">

    <div class="doctor-image">
        <img src="uploads/<?php echo $doctor['image']; ?>">
             alt="<?php echo $doctor['name']; ?>">
    </div>

    <div class="doctor-info">

        <h2 class="doctor-name">
            <?php echo $doctor['display_name']; ?>
        </h2>

        <div class="doctor-degree">
            <?php echo $doctor['display_degree']; ?>
        </div>

        <div class="doctor-speciality">
            <?php echo $doctor['display_speciality']; ?>
        </div>

        <div class="doctor-meta">

            <span>
                <i class="fa-solid fa-briefcase"></i>
                <?php echo $doctor['display_experience']; ?>
            </span>

            <span>
                <i class="fa-solid fa-language"></i>
                <?php echo $doctor['display_languages']; ?>
            </span>

        </div>

    </div>

    <div class="doctor-right">

    <div class="consultation-fees-box">

    <div class="fee-row">
        <span>Standard Consultation Fee</span>
        <strong class="standard-fee">
            ₹<?php echo $doctor['fee']; ?>
        </strong>
    </div>

    <div class="fee-row caring-row">
        <span>Caring Squad Fee</span>
        <strong class="caring-fee">
            ₹<?php echo $doctor['caring_squad_fee']; ?>
        </strong>
    </div>

</div>

        <div class="detail-row">
            <span>Consultation Type</span>
            <?php echo $doctor['consultation_type']; ?>
        </div>

        <a href="https://forms.gle/dWUPEMVGmCmFLL8p6"
           class="book-btn">
            Book Consultation
        </a>

    </div>

</div>

<?php

    } 
} 
else{
    echo "<h2>No Doctors Found</h2>";
}
?>

                <!-- =================================
                   PAGINATION
                ================================= -->

                <?php if($totalPages > 1){ ?>

                <div class="pagination">

                    <!-- PREVIOUS -->

                    <?php if($page > 1){ ?>

                    <a href="?page=<?php echo $page - 1; ?>&search=<?php echo $search; ?>&speciality=<?php echo $speciality; ?>">
                        <i class="fa-solid fa-chevron-left"></i>
                    </a>

                    <?php } ?>

                    <!-- PAGE NUMBERS -->

                    <?php

                    for($i = 1; $i <= $totalPages; $i++){

                    ?>

                    <a
                        href="?page=<?php echo $i; ?>&search=<?php echo $search; ?>&speciality=<?php echo $speciality; ?>"
                        class="<?php if($page == $i){ echo 'active-page'; } ?>"
                    >

                        <?php echo $i; ?>

                    </a>

                    <?php } ?>

                    <!-- NEXT -->

                    <?php if($page < $totalPages){ ?>

                    <a href="?page=<?php echo $page + 1; ?>&search=<?php echo $search; ?>&speciality=<?php echo $speciality; ?>">
                        <i class="fa-solid fa-chevron-right"></i>
                    </a>

                    <?php } ?>

                </div>

                <?php } ?>

            </div>

        </div>

    </div>

</section>

<!-- ========================================= -->
<!-- FOOTER -->
<!-- ========================================= -->

<footer class="footer">

    <div class="container footer-grid">

        <div class="footer-brand">

            <div class="logo footer-logo">

                <div class="logo-icon">
                    <i class="fa-regular fa-heart"></i>
                </div>

                <div class="logo-text">
                    <h2>CARING SQUAD</h2>
                    <span>Care | Companions | Guardians</span>
                </div>

            </div>

            <p>
                A trusted ecosystem designed around care,
                companionship and protection.
            </p>

            <div class="social-icons">

                <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="#"><i class="fa-brands fa-instagram"></i></a>
                <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                <a href="#"><i class="fa-brands fa-youtube"></i></a>

            </div>

        </div>

        <div class="footer-links">

            <h4>Our Services</h4>

            <ul>
                <li><a href="#">Care</a></li>
                <li><a href="#">Companion</a></li>
                <li><a href="#">Guardian</a></li>
                <li><a href="#">City Guardian</a></li>
                <li><a href="#">Travel Companion</a></li>
            </ul>

        </div>

        <div class="footer-links">

            <h4>Company</h4>

            <ul>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Safety & Trust</a></li>
                <li><a href="#">Membership Plans</a></li>
                <li><a href="#">Join Us</a></li>
                <li><a href="#">Blog</a></li>
            </ul>

        </div>

        <div class="footer-links">

            <h4>Support</h4>

            <ul>
                <li><a href="#">Help Center</a></li>
                <li><a href="#">FAQs</a></li>
                <li><a href="#">Care Resources</a></li>
                <li><a href="#">Privacy Policy</a></li>
                <li><a href="#">Terms & Conditions</a></li>
            </ul>

        </div>

        <div class="footer-contact">

            <h4>Get In Touch</h4>

            <ul>
                <li><i class="fa-solid fa-phone"></i> 1800 571 1929</li>
                <li><i class="fa-brands fa-whatsapp"></i> +91 81404 69546</li>
                <li><i class="fa-solid fa-envelope"></i> info@caringsquad.in</li>
                <li><i class="fa-solid fa-location-dot"></i> STC, Ambli T Junction, Ambli, Ahmedabad</li>
            </ul>

        </div>

    </div>

    <div class="footer-bottom">
        <p>© 2025 Caring Squad. All rights reserved.</p>
    </div>

</footer>

<script src="script.js"></script>

</body>

</html>
