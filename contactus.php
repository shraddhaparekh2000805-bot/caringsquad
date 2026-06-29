<?php

/*=========================================
    DATABASE CONNECTION
=========================================*/

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
        "u306816562_caringsquad",
        "Caringsquad@123",
        "u306816562_caringsquad"
    );

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Contact Us | Caring Squad</title>

    <!-- Google Fonts -->

    <link rel="preconnect"
        href="https://fonts.googleapis.com">

    <link rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- Main CSS -->

    <link rel="stylesheet" href="style.css">

    <!-- Contact Page CSS -->

    <link rel="stylesheet" href="contact.css">

</head>

<body>

<!--=====================================
HEADER
======================================-->

    <header class="header">
        <div class="container nav-container">

            <div class="logo">
                <img class="site-logo" src="assets/images/caringsquad-logo.png" alt="Caring Squad">
            </div>

            <nav class="navbar">
                <ul class="nav-links">
                    <li><a href="index.php" class="active">Home</a></li>
                    <li><a href="about.php">Our Story</a></li>
                    <li><a href="expert_consultation.php">Expert Consultation</a></li>
                    <li><a href="care.php">Care</a></li>
                    <li><a href="companion.php">Companion</a></li>
                    <li><a href="travel.php">Travel Companion</a></li>
                    <li><a href="cityguardian.php">City Guardian</a></li>
                    <li class="dropdown">
    <a href="#">
        Other
        <i class="fa-solid fa-chevron-down"></i>
    </a>

    <ul class="dropdown-menu">
        <li><a href="blog.php">Blog</a></li>
        <li><a href="joinus.php">Join Us</a></li>
        <li><a href="contactus.php">Contact Us</a></li>
    </ul>
</li>
                </ul>
            </nav>

                <div class="header-phone">
                    <i class="fa-solid fa-phone"></i>
                    <span>1800 571 1929</span>
                </div>
            </div>

            <div class="mobile-menu" id="mobileMenuBtn">
    <i class="fa-solid fa-bars"></i>
</div>

        </div>
    </header>

<!--=====================================
CONTACT HERO
======================================-->

<section class="contact-hero">

    <div class="container">

        <div class="contact-hero-wrapper">

            <div class="contact-hero-content">

                <h1>
                    We're Here to Support You
                    <span>
                        & Your Loved Ones
                    </span>
                    Anytime
                </h1>

                <div class="breadcrumb">

                    <a href="index.php">
                        Home
                    </a>

                    <span>
                        <i class="fa-solid fa-chevron-right"></i>
                    </span>

                    <span>
                        Contact Us
                    </span>

                </div>

            </div>

            <div class="contact-hero-image">

                <img
                    src="assets/images/contact-banner.png"
                    alt="Contact Caring Squad">

            </div>

        </div>

    </div>

</section>

<section class="contact-section">

    <div class="container">

    <!--=====================================
GET IN TOUCH SECTION
======================================-->

<div class="contact-wrapper">

    <!--=========================
        CONTACT FORM
    ==========================-->

    <div class="contact-form-card">

        <div class="section-heading">

            <h2>Get in Touch</h2>

            <p>
                Fill in the details below and our team will get back to you.
            </p>

        </div>

        <form
            action=""
            method="POST"
            class="contact-form">

            <div class="form-grid">

                <!-- Full Name -->

                <div class="form-group">

                    <label>

                        Full Name
                        <span>*</span>

                    </label>

                    <div class="input-box">

                        <i class="fa-regular fa-user"></i>

                        <input
                            type="text"
                            name="fullname"
                            placeholder="Enter your full name"
                            required>

                    </div>

                </div>

                <!-- Mobile -->

                <div class="form-group">

                    <label>

                        Mobile Number
                        <span>*</span>

                    </label>

                    <div class="input-box">

                        <i class="fa-solid fa-phone"></i>

                        <input
                            type="tel"
                            name="mobile"
                            placeholder="Enter your mobile number"
                            required>

                    </div>

                </div>

                <!-- Email -->

                <div class="form-group">

                    <label>

                        Email Address
                        <span>*</span>

                    </label>

                    <div class="input-box">

                        <i class="fa-regular fa-envelope"></i>

                        <input
                            type="email"
                            name="email"
                            placeholder="Enter your email"
                            required>

                    </div>

                </div>

                <!-- Service -->

                <div class="form-group">

                    <label>

                        Select Service
                        <span>*</span>

                    </label>

                    <div class="input-box">

                        <i class="fa-solid fa-stethoscope"></i>

                        <select
                            name="service"
                            required>

                            <option value="">

                                Select a service

                            </option>

                            <option>

                                Home Care

                            </option>

                            <option>

                                Doctor Consultation

                            </option>

                            <option>

                                Physiotherapy at Home

                            </option>

                            <option>

                                Elderly Care

                            </option>

                            <option>

                                Nursing Care

                            </option>

                            <option>

                                Companionship

                            </option>

                            <option>

                                Travel Companion

                            </option>

                            <option>

                                City Guardian

                            </option>

                        </select>

                    </div>

                </div>

            </div>

            <!-- City -->

            <div class="form-group">

                <label>

                    City
                    <span>*</span>

                </label>

                <div class="input-box">

                    <i class="fa-solid fa-location-dot"></i>

                    <input
                        type="text"
                        name="city"
                        placeholder="Enter your city"
                        required>

                </div>

            </div>

            <!-- Message -->

            <div class="form-group">

                <label>

                    Message
                    <span>*</span>

                </label>

                <div class="input-box textarea-box">

                    <i class="fa-regular fa-comment"></i>

                    <textarea
                        rows="5"
                        name="message"
                        placeholder="Type your message here..."
                        required></textarea>

                </div>

            </div>

            <button
                type="submit"
                name="sendInquiry"
                class="contact-btn">

                Send Inquiry

                <i class="fa-solid fa-paper-plane"></i>

            </button>

        </form>

    </div>

    <!--=========================
        HELP CARD
    ==========================-->

    <div class="help-card">

        <h3>

            Need Immediate Help?

        </h3>

        <div class="help-icon">

            <i class="fa-solid fa-phone-volume"></i>

        </div>

        <h2>

            1800 571 1929

        </h2>

        <p>

            We are available 24×7 for you

        </p>

        <ul>

            <li>

                <i class="fa-regular fa-circle-check"></i>

                Emergency Home Care

            </li>

            <li>

                <i class="fa-regular fa-circle-check"></i>

                Doctor Consultation

            </li>

            <li>

                <i class="fa-regular fa-circle-check"></i>

                Elderly Care Support

            </li>

            <li>

                <i class="fa-regular fa-circle-check"></i>

                Physiotherapy at Home

            </li>

            <li>

                <i class="fa-regular fa-circle-check"></i>

                Companionship Services

            </li>

        </ul>

        <a
            href="tel:18005711929"
            class="call-btn">

            <i class="fa-solid fa-phone"></i>

            Call Now

        </a>

    </div>

</div>

</div>

</section>

<!--=====================================
WHY CHOOSE CARING SQUAD
======================================-->

<section class="why-contact-section">

    <div class="container">

        <div class="why-heading">

            <h2>

                WHY CHOOSE CARING SQUAD?

            </h2>

            <div class="heading-divider">

                <span></span>

                <i class="fa-solid fa-diamond"></i>

                <span></span>

            </div>

        </div>

        <div class="why-contact-grid">

            <!-- Card 1 -->

            <div class="why-contact-card">

                <div class="why-icon">

                    <i class="fa-solid fa-shield-heart"></i>

                </div>

                <h3>

                    Verified &<br>
                    Trained Caregivers

                </h3>

                <p>

                    Background verified professionals

                </p>

            </div>

            <!-- Card 2 -->

            <div class="why-contact-card">

                <div class="why-icon">

                    <i class="fa-solid fa-user-doctor"></i>

                </div>

                <h3>

                    Experienced<br>
                    Doctors & Experts

                </h3>

                <p>

                    Trusted by hundreds of families

                </p>

            </div>

            <!-- Card 3 -->

            <div class="why-contact-card">

                <div class="why-icon">

                    <i class="fa-solid fa-house"></i>

                </div>

                <h3>

                    Home Care<br>
                    Services

                </h3>

                <p>

                    Comfort of care at your home

                </p>

            </div>

            <!-- Card 4 -->

            <div class="why-contact-card">

                <div class="why-icon">

                    <i class="fa-solid fa-hand-holding-heart"></i>

                </div>

                <h3>

                    Safe &<br>
                    Reliable

                </h3>

                <p>

                    Your loved ones are in safe hands

                </p>

            </div>

            <!-- Card 5 -->

            <div class="why-contact-card">

                <div class="why-icon">

                    <i class="fa-solid fa-indian-rupee-sign"></i>

                </div>

                <h3>

                    Affordable<br>
                    Packages

                </h3>

                <p>

                    Quality care at reasonable prices

                </p>

            </div>

            <!-- Card 6 -->

            <div class="why-contact-card">

                <div class="why-icon">

                    <i class="fa-solid fa-headset"></i>

                </div>

                <h3>

                    24×7 Support<br>
                    Available

                </h3>

                <p>

                    We're here whenever you need us

                </p>

            </div>

        </div>

    </div>

</section>

<!--=====================================
CALL TO ACTION
======================================-->

<section class="contact-cta">

    <div class="container">

        <div class="contact-cta-wrapper">

            <!--=========================
                LEFT IMAGE
            =========================-->

            <div class="contact-cta-image">

                <img
                    src="assets/images/contact-cta.png"
                    alt="Need Immediate Assistance">

            </div>

            <!--=========================
                CTA CONTENT
            =========================-->

            <div class="contact-cta-content">

                <h2>

                    Need Immediate Assistance?

                </h2>

                <h3>

                    Call Our Care Team Today.

                </h3>

                <div class="cta-phone">

                    <i class="fa-solid fa-phone"></i>

                    <span>

                        1800 571 1929

                    </span>

                </div>

            </div>

            <!--=========================
                CTA BUTTONS
            =========================-->

            <div class="contact-cta-buttons">

                <a
                    href="tel:18005711929"
                    class="cta-call-btn">

                    <i class="fa-solid fa-phone"></i>

                    Call Now

                </a>

                <a
                    href="https://wa.me/918140469546"
                    target="_blank"
                    class="cta-whatsapp-btn">

                    <i class="fa-brands fa-whatsapp"></i>

                    WhatsApp Us

                </a>

            </div>

        </div>

    </div>

</section>

<!--=====================================
FOOTER
======================================-->

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
                    <li><i class="fa-brands fa-whatsapp"></i>+91 81404 69546</li>
                    <li><i class="fa-solid fa-envelope"></i> info@caringsquad.in</li>
                    <li><i class="fa-solid fa-location-dot"></i> STC, Ambli T Junction, Ambli, Ahmedabad</li>
                </ul>

            </div>

        </div>

        <div class="footer-bottom">
            <p>© 2025 Caring Squad. All rights reserved.</p>
        </div>

    </footer>

<!--=====================================
JAVASCRIPT
======================================-->

<script src="script.js"></script>

<script>

document.addEventListener("DOMContentLoaded", function () {

    /*=========================
      HERO SLIDER (if hero uses it)
    =========================*/

    const slides = document.querySelectorAll(".hero-slide");

    if (slides.length > 0) {

        let current = 0;

        setInterval(function () {

            slides[current].classList.remove("active");

            current++;

            if (current >= slides.length) {

                current = 0;

            }

            slides[current].classList.add("active");

        }, 5000);

    }

    /*=========================
      MOBILE MENU
    =========================*/

    const mobileBtn = document.getElementById("mobileMenuBtn");

    const navbar = document.querySelector(".navbar");

    if (mobileBtn && navbar) {

        mobileBtn.addEventListener("click", function () {

            navbar.classList.toggle("active");

        });

    }

});

</script>

</body>

</html>
