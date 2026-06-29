<?php

include 'db.php';
include 'blog_setup.php';

ensureBlogTables($conn);

$slug = isset($_GET['slug']) ? trim($_GET['slug']) : '';

if ($slug === '') {
    header('Location: blog.php');
    exit();
}

$slug = mysqli_real_escape_string($conn, $slug);

$blogQuery = mysqli_query(
    $conn,
    "
    SELECT
        blogs.*,
        blog_categories.category_name
    FROM blogs
    LEFT JOIN blog_categories
        ON blogs.category_id = blog_categories.id
    WHERE blogs.slug = '$slug'
      AND blogs.status = 'Published'
    LIMIT 1
    "
);

if (!$blogQuery || mysqli_num_rows($blogQuery) === 0) {
    header('Location: blog.php');
    exit();
}

$blog = mysqli_fetch_assoc($blogQuery);
$blogId = (int)$blog['id'];
$categoryId = (int)$blog['category_id'];

mysqli_query(
    $conn,
    "UPDATE blogs SET views = views + 1 WHERE id = '$blogId'"
);

$popular = mysqli_query(
    $conn,
    "
    SELECT *
    FROM blogs
    WHERE status = 'Published'
      AND id != '$blogId'
    ORDER BY views DESC, created_at DESC
    LIMIT 5
    "
);

$related = mysqli_query(
    $conn,
    "
    SELECT
        blogs.*,
        blog_categories.category_name
    FROM blogs
    LEFT JOIN blog_categories
        ON blogs.category_id = blog_categories.id
    WHERE blogs.status = 'Published'
      AND blogs.category_id = '$categoryId'
      AND blogs.id != '$blogId'
    ORDER BY blogs.created_at DESC
    LIMIT 3
    "
);

$categories = mysqli_query(
    $conn,
    "
    SELECT *
    FROM blog_categories
    WHERE status = '1'
    ORDER BY category_name ASC
    "
);

$pageTitle = htmlspecialchars($blog['title']) . ' | Caring Squad';
$metaDescription = !empty($blog['excerpt'])
    ? htmlspecialchars(strip_tags($blog['excerpt']))
    : htmlspecialchars($blog['title']);

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="<?php echo $metaDescription; ?>">

<title><?php echo $pageTitle; ?></title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap"
rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<link rel="stylesheet" href="style.css">

</head>

<body>

<header class="header">

    <div class="container nav-container">

        <div class="logo">
            <img
            class="site-logo"
            src="assets/images/caringsquad-logo.png"
            alt="Caring Squad">
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
                        <li><a href="blog.php">Blog</a></li>
                        <li><a href="joinus.php">Join Us</a></li>
                        <li><a href="contactus.php">Contact Us</a></li>
                    </ul>
                </li>
            </ul>
        </nav>

        <div class="header-right">
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

<section class="blog-detail-hero">

    <div class="container">

        <a href="blog.php" class="blog-back-link">
            <i class="fa-solid fa-arrow-left"></i>
            Back to Articles
        </a>

        <?php if (!empty($blog['category_name'])) { ?>

        <a
        href="blog.php?category=<?php echo $categoryId; ?>"
        class="blog-category blog-detail-category">

            <?php echo htmlspecialchars($blog['category_name']); ?>

        </a>

        <?php } ?>

        <h1><?php echo htmlspecialchars($blog['title']); ?></h1>

        <?php if (!empty($blog['excerpt'])) { ?>

        <p class="blog-detail-excerpt">
            <?php echo htmlspecialchars(strip_tags($blog['excerpt'])); ?>
        </p>

        <?php } ?>

        <div class="blog-detail-meta">

            <span>
                <i class="fa-regular fa-user"></i>
                <?php echo htmlspecialchars($blog['author']); ?>
            </span>

            <?php if (!empty($blog['read_time'])) { ?>

            <span>
                <i class="fa-regular fa-clock"></i>
                <?php echo htmlspecialchars($blog['read_time']); ?>
            </span>

            <?php } ?>

            <span>
                <i class="fa-regular fa-calendar"></i>
                <?php echo date('M d, Y', strtotime($blog['created_at'])); ?>
            </span>

        </div>

    </div>

</section>

<section class="blog-main blog-detail-main">

    <div class="container">

        <div class="blog-layout">

            <div class="blog-left">

                <?php if (!empty($blog['featured_image'])) { ?>

                <div class="blog-detail-image">
                    <img
                    src="uploads/blogs/<?php echo htmlspecialchars($blog['featured_image']); ?>"
                    alt="<?php echo htmlspecialchars($blog['title']); ?>">
                </div>

                <?php } ?>

                <div class="blog-detail-content">

                    <?php

                    if (!empty(trim(strip_tags($blog['content'])))) {
                        echo $blog['content'];
                    } elseif (!empty($blog['excerpt'])) {
                        echo '<p>' . nl2br(htmlspecialchars(strip_tags($blog['excerpt']))) . '</p>';
                    } else {
                        echo '<p>This article is being updated. Please check back soon.</p>';
                    }

                    ?>

                </div>

                <?php if ($related && mysqli_num_rows($related) > 0) { ?>

                <div class="blog-related-posts">

                    <h3>Related Articles</h3>

                    <div class="blog-related-grid">

                        <?php while ($relatedBlog = mysqli_fetch_assoc($related)) { ?>

                        <article class="blog-related-card">

                            <?php if (!empty($relatedBlog['featured_image'])) { ?>

                            <a
                            href="blog_details.php?slug=<?php echo urlencode($relatedBlog['slug']); ?>"
                            class="blog-related-image">

                                <img
                                src="uploads/blogs/<?php echo htmlspecialchars($relatedBlog['featured_image']); ?>"
                                alt="<?php echo htmlspecialchars($relatedBlog['title']); ?>">

                            </a>

                            <?php } ?>

                            <div class="blog-related-content">

                                <?php if (!empty($relatedBlog['category_name'])) { ?>

                                <span class="blog-category">
                                    <?php echo htmlspecialchars($relatedBlog['category_name']); ?>
                                </span>

                                <?php } ?>

                                <h4>
                                    <a href="blog_details.php?slug=<?php echo urlencode($relatedBlog['slug']); ?>">
                                        <?php echo htmlspecialchars($relatedBlog['title']); ?>
                                    </a>
                                </h4>

                                <a
                                href="blog_details.php?slug=<?php echo urlencode($relatedBlog['slug']); ?>"
                                class="read-more">

                                    Read Article

                                </a>

                            </div>

                        </article>

                        <?php } ?>

                    </div>

                </div>

                <?php } ?>

            </div>

            <div class="blog-right">

                <div class="sidebar-card">
                    <h3>Popular Articles</h3>

                    <?php if ($popular && mysqli_num_rows($popular) > 0) { ?>

                        <?php while ($pop = mysqli_fetch_assoc($popular)) { ?>

                        <div class="popular-post">
                            <a href="blog_details.php?slug=<?php echo urlencode($pop['slug']); ?>">
                                <?php echo htmlspecialchars($pop['title']); ?>
                            </a>
                        </div>

                        <?php } ?>

                    <?php } else { ?>

                        <p class="sidebar-empty">More articles coming soon.</p>

                    <?php } ?>

                </div>

                <div class="sidebar-card">
                    <h3>Categories</h3>
                    <ul class="sidebar-categories">
                        <?php while ($cat = mysqli_fetch_assoc($categories)) { ?>
                        <li>
                            <a href="blog.php?category=<?php echo (int)$cat['id']; ?>">
                                <?php echo htmlspecialchars($cat['category_name']); ?>
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                </div>

                <div class="sidebar-card newsletter-box">
                    <h3>Join Our Newsletter</h3>
                    <p>
                        Get elder care tips, wellness insights and
                        Caring Squad updates.
                    </p>
                    <form action="" method="post">
                        <input
                        type="email"
                        name="email"
                        placeholder="Your Email Address"
                        required>
                        <button type="submit">Subscribe</button>
                    </form>
                </div>

            </div>

        </div>

    </div>

</section>

<section class="cta-section">

    <div class="container">

        <div class="cta-box">

            <h2>Need Personal Care Guidance?</h2>

            <p>
                Connect with our care experts and get personalized recommendations
                for elder care, companionship, wellness support and healthcare services.
            </p>

            <a href="contact.php" class="cta-btn">
                Talk To An Expert
            </a>

        </div>

    </div>

</section>

<footer class="footer">

    <div class="container footer-grid">

        <div class="footer-brand">

            <div class="footer-logo">
    <a href="index.php">
        <img src="assets/images/caringsquad-logo.png"
             alt="Caring Squad Logo"
             class="footer-logo-img">
    </a>
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
                <li><a href="care.php">Care</a></li>
                <li><a href="companion.php">Companion</a></li>
                <li><a href="#">Guardian</a></li>
                <li><a href="cityguardian.php">City Guardian</a></li>
                <li><a href="travel.php">Travel Companion</a></li>
            </ul>
        </div>

        <div class="footer-links">
            <h4>Company</h4>
            <ul>
                <li><a href="about.php">About Us</a></li>
                <li><a href="#">Safety & Trust</a></li>
                <li><a href="#">Membership Plans</a></li>
                <li><a href="joinus.php">Join Us</a></li>
                <li><a href="blog.php">Blog</a></li>
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
                <li><i class="fa-solid fa-envelope"></i> support@caringsquad.in</li>
                <li>
                    <i class="fa-solid fa-location-dot"></i>
                    STC, Ambli T Junction, Ambli, Ahmedabad
                </li>
                <li>
                    <a href="admin/login.php" class="admin-footer-link">
                        Admin Login
                    </a>
                </li>
            </ul>
        </div>

    </div>

    <div class="footer-bottom">
        <p>
            © <?php echo date('Y'); ?> Caring Squad. All rights reserved.
        </p>
    </div>

</footer>

<script src="script.js"></script>

</body>
</html>
