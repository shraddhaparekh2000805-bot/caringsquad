<?php

include 'db.php';
include 'blog_setup.php';

ensureBlogTables($conn);

/* =========================================
   CATEGORY FILTER
========================================= */

$category_id = isset($_GET['category'])
    ? (int)$_GET['category']
    : 0;

/* =========================================
   SEARCH
========================================= */

$search = isset($_GET['search'])
    ? trim($_GET['search'])
    : '';

/* =========================================
   PAGINATION
========================================= */

$limit = 6;

$page = isset($_GET['page'])
    ? (int)$_GET['page']
    : 1;

if($page < 1){
    $page = 1;
}

$start = ($page - 1) * $limit;

/* =========================================
   WHERE CONDITIONS
========================================= */

$where = " WHERE blogs.status='Published' ";

if($category_id > 0){
    $where .= " AND blogs.category_id='$category_id' ";
}

if($search != ''){

    $search = mysqli_real_escape_string(
        $conn,
        $search
    );

    $where .= "
    AND (
        blogs.title LIKE '%$search%'
        OR blogs.excerpt LIKE '%$search%'
    )";
}

/* =========================================
   TOTAL BLOGS
========================================= */

$total_query = mysqli_query(
$conn,
"
SELECT COUNT(*) AS total
FROM blogs
LEFT JOIN blog_categories
ON blogs.category_id = blog_categories.id
$where
"
);

$total_row = mysqli_fetch_assoc($total_query);
$total_records = $total_row ? (int)$total_row['total'] : 0;

$total_pages = ceil(
    $total_records / $limit
);

/* =========================================
   BLOG LIST
========================================= */

$blogs = mysqli_query(
$conn,
"
SELECT
blogs.*,
blog_categories.category_name

FROM blogs

LEFT JOIN blog_categories
ON blogs.category_id =
blog_categories.id

$where

ORDER BY blogs.created_at ASC

LIMIT $start,$limit
"
);

/* =========================================
   FEATURED BLOG
========================================= */

$featured_blog = mysqli_query(
$conn,
"
SELECT
blogs.*,
blog_categories.category_name

FROM blogs

LEFT JOIN blog_categories
ON blogs.category_id =
blog_categories.id

WHERE blogs.featured='1'
AND blogs.status='Published'

ORDER BY blogs.id DESC

LIMIT 1
"
);

$featured = mysqli_fetch_assoc(
$featured_blog
);

/* =========================================
   POPULAR POSTS
========================================= */

$popular = mysqli_query(
$conn,
"
SELECT *
FROM blogs
WHERE status='Published'
ORDER BY views DESC
LIMIT 5
"
);

/* =========================================
   CATEGORIES
========================================= */

$categories = mysqli_query(
$conn,
"
SELECT *
FROM blog_categories
WHERE status='1'
ORDER BY category_name ASC
"
);

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>
Blogs & Insights | Caring Squad
</title>

<link rel="preconnect"
href="https://fonts.googleapis.com">

<link rel="preconnect"
href="https://fonts.gstatic.com"
crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap"
rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<link rel="stylesheet"
href="style.css">

</head>

<body>

<!-- ========================= -->
<!-- HEADER -->
<!-- ========================= -->

<header class="header">
        <div class="container nav-container">

            <div class="logo">
                <img class="site-logo" src="assets/images/caringsquad-logo.png" alt="Caring Squad">
            </div>

            <nav class="navbar">
                <ul class="nav-links">
                    <li><a href="index.php">Home</a></li>
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
        <li><a href="blog.php" class="active">Blog</a></li>
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

<!-- ========================= -->
<!-- HERO -->
<!-- ========================= -->

<section class="blog-hero">

    <div class="container">

        <div class="about-hero-grid">

            <div class="about-hero-content">

                <h1>

                    Insights that Care

                    <br>

                    <span>
                        Guidance that Empowers
                    </span>

                </h1>

                <p>

                    Expert insights, real stories
                    and practical advice to help
                    families make informed care
                    decisions.

                </p>

                <div class="hero-buttons">

                    <a
                    href="#blogs"
                    class="btn btn-primary">

                        Explore Blogs

                    </a>

                    <a
                    href="contact.php"
                    class="btn btn-secondary">

                        Contact Us

                    </a>

                </div>

            </div>

        </div>

    </div>

</section>


<!-- ========================= -->
<!-- BLOG MAIN SECTION -->
<!-- ========================= -->

<section class="blog-main" id="blogs">

    <div class="container">

        <div class="blog-layout">

            <!-- ========================= -->
            <!-- LEFT SIDE -->
            <!-- ========================= -->

            <div class="blog-left">

                <!-- CATEGORY TABS -->

                <div class="category-tabs">

                    <a
                    href="blog.php"
                    class="tab-btn <?php echo ($category_id==0)?'active':''; ?>">

                        All Articles

                    </a>

                    <?php

                    mysqli_data_seek(
                        $categories,
                        0
                    );

                    while($cat=mysqli_fetch_assoc($categories)){

                    ?>

                    <a
                    href="blog.php?category=<?php echo $cat['id']; ?>"
                    class="tab-btn <?php echo ($category_id==$cat['id'])?'active':''; ?>">

                        <?php echo $cat['category_name']; ?>

                    </a>

                    <?php } ?>

                </div>

                <!-- SEARCH -->

                <form
                method="GET"
                class="blog-search">

                    <?php

                    if($category_id>0){

                    ?>

                    <input
                    type="hidden"
                    name="category"
                    value="<?php echo $category_id; ?>">

                    <?php } ?>

                    <input
                    type="text"
                    name="search"
                    placeholder="Search articles..."
                    value="<?php echo htmlspecialchars($search); ?>">

                    <button type="submit">

                        <i class="fa-solid fa-magnifying-glass"></i>

                    </button>

                </form>

                <!-- BLOG GRID -->

                <div class="blog-grid">

                <?php

                if(mysqli_num_rows($blogs)>0){

                while($blog=mysqli_fetch_assoc($blogs)){

                ?>

                <div class="blog-card">

                    <div class="blog-card-image">

                        <?php

                        if(!empty($blog['featured_image'])){

                        ?>

                        <img
                        src="uploads/blogs/<?php echo $blog['featured_image']; ?>"
                        alt="<?php echo htmlspecialchars($blog['title']); ?>">

                        <?php } ?>

                    </div>

                    <div class="blog-card-content">

                        <span class="blog-category">

                            <?php echo $blog['category_name']; ?>

                        </span>

                        <h3>

                            <?php echo $blog['title']; ?>

                        </h3>

                        <p>

                            <?php

                            echo substr(
                                strip_tags(
                                    $blog['excerpt']
                                ),
                                0,
                                140
                            );

                            ?>...

                        </p>

                        <div class="blog-meta">

                            <span>

                                <i class="fa-regular fa-user"></i>

                                <?php echo $blog['author']; ?>

                            </span>

                            <span>

                                <i class="fa-regular fa-clock"></i>

                                <?php echo $blog['read_time']; ?>

                            </span>

                        </div>

                        <a
                        href="blog_details.php?slug=<?php echo $blog['slug']; ?>"
                        class="read-more">

                            Read Article

                        </a>

                    </div>

                </div>

                <?php

                }

                }else{

                ?>

                <div class="no-blogs">

                    <h2>

                        No Articles Found

                    </h2>

                    <p>

                        Try changing search
                        keywords or category.

                    </p>

                </div>

                <?php

                }

                ?>

                </div>

            </div>

            <!-- ========================= -->
            <!-- RIGHT SIDEBAR -->
            <!-- ========================= -->

            <div class="blog-right">

                <!-- POPULAR ARTICLES -->

                <div class="sidebar-card">

                    <h3>

                        Popular Articles

                    </h3>

                    <?php

                    while($pop=mysqli_fetch_assoc($popular)){

                    ?>

                    <div class="popular-post">

                        <a
                        href="blog_details.php?slug=<?php echo $pop['slug']; ?>">

                            <?php echo $pop['title']; ?>

                        </a>

                    </div>

                    <?php } ?>

                </div>

                <!-- CATEGORIES -->

                <div class="sidebar-card">

                    <h3>

                        Categories

                    </h3>

                    <ul class="sidebar-categories">

                    <?php

                    $side_categories = mysqli_query(
                    $conn,
                    "
                    SELECT *
                    FROM blog_categories
                    WHERE status='1'
                    ORDER BY category_name ASC
                    "
                    );

                    while($scat=mysqli_fetch_assoc($side_categories)){

                    ?>

                    <li>

                        <a
                        href="blog.php?category=<?php echo $scat['id']; ?>">

                            <?php echo $scat['category_name']; ?>

                        </a>

                    </li>

                    <?php } ?>

                    </ul>

                </div>

                <!-- NEWSLETTER -->

                <div class="sidebar-card newsletter-box">

                    <h3>

                        Join Our Newsletter

                    </h3>

                    <p>

                        Get elder care tips,
                        wellness insights and
                        Caring Squad updates.

                    </p>

                    <form action="" method="post">

                        <input
                        type="email"
                        name="email"
                        placeholder="Your Email Address">

                        <button type="submit">

                            Subscribe

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- ========================= -->
<!-- PAGINATION -->
<!-- ========================= -->

<?php if($total_pages > 1){ ?>

<section class="blog-pagination-section">

    <div class="container">

        <div class="blog-pagination">

            <!-- PREVIOUS -->

            <?php if($page > 1){ ?>

            <a
            href="?page=<?php echo $page-1; ?>&category=<?php echo $category_id; ?>&search=<?php echo urlencode($search); ?>"
            class="page-btn">

                <i class="fa-solid fa-chevron-left"></i>

            </a>

            <?php } ?>

            <!-- PAGE NUMBERS -->

            <?php

            for($i=1;$i<=$total_pages;$i++){

            ?>

            <a
            href="?page=<?php echo $i; ?>&category=<?php echo $category_id; ?>&search=<?php echo urlencode($search); ?>"
            class="page-btn <?php echo ($page==$i)?'active':''; ?>">

                <?php echo $i; ?>

            </a>

            <?php } ?>

            <!-- NEXT -->

            <?php if($page < $total_pages){ ?>

            <a
            href="?page=<?php echo $page+1; ?>&category=<?php echo $category_id; ?>&search=<?php echo urlencode($search); ?>"
            class="page-btn">

                <i class="fa-solid fa-chevron-right"></i>

            </a>

            <?php } ?>

        </div>

    </div>

</section>

<?php } ?>

<!-- ========================= -->
<!-- CTA SECTION -->
<!-- ========================= -->

<section class="cta-section">

    <div class="container">

        <div class="cta-box">

            <h2>

                Need Personal Care Guidance?

            </h2>

            <p>

                Connect with our care experts and get
                personalized recommendations for elder care,
                companionship, wellness support and
                healthcare services.

            </p>

            <a
            href="contact.php"
            class="cta-btn">

                Talk To An Expert

            </a>

        </div>

    </div>

</section>

<!-- ========================= -->
<!-- FOOTER -->
<!-- ========================= -->

<footer class="footer">

    <div class="container footer-grid">

        <div class="footer-brand">

            <div class="logo footer-logo">

                <div class="logo-icon">

                    <i class="fa-regular fa-heart"></i>

                </div>

                <div class="logo-text">

                    <h2>CARING SQUAD</h2>

                    <span>
                        Care | Companions | Guardians
                    </span>

                </div>

            </div>

            <p>

                A trusted ecosystem designed around care,
                companionship and protection.

            </p>

            <div class="social-icons">

                <a href="#">
                    <i class="fa-brands fa-facebook-f"></i>
                </a>

                <a href="#">
                    <i class="fa-brands fa-instagram"></i>
                </a>

                <a href="#">
                    <i class="fa-brands fa-linkedin-in"></i>
                </a>

                <a href="#">
                    <i class="fa-brands fa-youtube"></i>
                </a>

            </div>

        </div>

        <!-- SERVICES -->

        <div class="footer-links">

            <h4>Our Services</h4>

            <ul>

                <li>
                    <a href="care.php">
                        Care
                    </a>
                </li>

                <li>
                    <a href="companion.php">
                        Companion
                    </a>
                </li>

                <li>
                    <a href="#">
                        Guardian
                    </a>
                </li>

                <li>
                    <a href="cityguardian.php">
                        City Guardian
                    </a>
                </li>

                <li>
                    <a href="travel.php">
                        Travel Companion
                    </a>
                </li>

            </ul>

        </div>

        <!-- COMPANY -->

        <div class="footer-links">

            <h4>Company</h4>

            <ul>

                <li>
                    <a href="about.php">
                        About Us
                    </a>
                </li>

                <li>
                    <a href="#">
                        Safety & Trust
                    </a>
                </li>

                <li>
                    <a href="#">
                        Membership Plans
                    </a>
                </li>

                <li>
                    <a href="joinus.php">
                        Join Us
                    </a>
                </li>

                <li>
                    <a href="blog.php">
                        Blog
                    </a>
                </li>

            </ul>

        </div>

        <!-- SUPPORT -->

        <div class="footer-links">

            <h4>Support</h4>

            <ul>

                <li>
                    <a href="#">
                        Help Center
                    </a>
                </li>

                <li>
                    <a href="#">
                        FAQs
                    </a>
                </li>

                <li>
                    <a href="#">
                        Care Resources
                    </a>
                </li>

                <li>
                    <a href="#">
                        Privacy Policy
                    </a>
                </li>

                <li>
                    <a href="#">
                        Terms & Conditions
                    </a>
                </li>

            </ul>

        </div>

        <!-- CONTACT -->

        <div class="footer-contact">

            <h4>

                Get In Touch

            </h4>

            <ul>

                <li>

                    <i class="fa-solid fa-phone"></i>

                    1800 571 1929

                </li>

                <li>

                    <i class="fa-brands fa-whatsapp"></i>

                    +91 81404 69546

                </li>

                <li>

                    <i class="fa-solid fa-envelope"></i>

                    info@caringsquad.in

                </li>

                <li>

                    <i class="fa-solid fa-location-dot"></i>

                    STC, Ambli T Junction,
                    Ambli, Ahmedabad

                </li>

                <li>

                    <a
                    href="admin/login.php"
                    class="admin-footer-link">

                        Admin Login

                    </a>

                </li>

            </ul>

        </div>

    </div>

    <div class="footer-bottom">

        <p>

            © <?php echo date('Y'); ?>
            Caring Squad.
            All rights reserved.

        </p>

    </div>

</footer>

<!-- ========================= -->
<!-- JS -->
<!-- ========================= -->

<script src="script.js"></script>

<script>

document.addEventListener(
'DOMContentLoaded',
function(){

const mobileMenu =
document.getElementById(
'mobileMenuBtn'
);

if(mobileMenu){

mobileMenu.addEventListener(
'click',
function(){

document
.querySelector('.navbar')
.classList.toggle('active');

});

}

});

</script>

</body>
</html>