<?php

include 'db.php';

/* CATEGORY FILTER */

$category_id = 0;

if(isset($_GET['category'])){
    $category_id = (int)$_GET['category'];
}

/* SEARCH */

$search = '';

if(isset($_GET['search'])){
    $search = trim($_GET['search']);
}

/* MAIN BLOG QUERY */

$where = " WHERE blogs.status='Published' ";

if($category_id > 0){
    $where .= " AND blogs.category_id='$category_id' ";
}

if($search != ''){
    $where .= "
    AND blogs.title LIKE '%$search%'
    ";
}

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

ORDER BY blogs.created_at DESC
"
);

/* CATEGORIES */

$categories = mysqli_query(
$conn,
"
SELECT *
FROM blog_categories
WHERE status='Active'
ORDER BY category_name ASC
"
);

/* POPULAR POSTS */

$popular = mysqli_query(
$conn,
"
SELECT *
FROM blogs
WHERE status='Published'
ORDER BY views DESC
LIMIT 3
"
);

$featured_blog = mysqli_query(
$conn,
"
SELECT
blogs.*,
blog_categories.category_name
FROM blogs
LEFT JOIN blog_categories
ON blogs.category_id = blog_categories.id
WHERE blogs.featured=1
AND blogs.status='Published'
ORDER BY blogs.id DESC
LIMIT 1
"
);

$featured = mysqli_fetch_assoc($featured_blog);

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Blogs & Insights | Caring Squad</title>

<link rel="preconnect"
href="https://fonts.googleapis.com">

<link rel="preconnect"
href="https://fonts.gstatic.com"
crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap"
rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>

/* HERO SECTION */

*{
margin:0;
padding:0;
box-sizing:border-box;
}

.blog-hero{
padding:80px 0;
background:#f8f4ee;
}

.blog-hero-grid{
display:grid;
grid-template-columns:1fr 1fr;
gap:70px;
align-items:center;
}

.hero-label{
font-size:13px;
font-weight:600;
letter-spacing:3px;
color:#C89B4D;
text-transform:uppercase;
}

.hero-divider{
width:80px;
height:2px;
background:#C89B4D;
margin:18px 0 28px;
}

.hero-content h1{
font-family:'Cormorant Garamond',serif;
font-size:72px;
line-height:1.05;
margin-bottom:20px;
}

.hero-content h1 span{
color:#C89B4D;
}

.hero-heart{
color:#C89B4D;
font-size:18px;
margin-bottom:20px;
}

.hero-content p{
font-size:17px;
line-height:1.9;
max-width:550px;
color:#666;
}

.hero-image img{
width:100%;
border-radius:24px;
display:block;
}

body{
font-family:'Montserrat',sans-serif;
background:#f8f4ee;
color:#061326;
}

.container{
width:90%;
max-width:1400px;
margin:auto;
}

/* HEADER */

.header{
background:#fff;
border-bottom:1px solid #eee;
position:sticky;
top:0;
z-index:999;
}

.nav-container{
display:flex;
align-items:center;
justify-content:space-between;
height:90px;
}

.site-logo{
height:55px;
}

.nav-links{
display:flex;
list-style:none;
gap:30px;
}

.nav-links a{
text-decoration:none;
color:#061326;
font-size:15px;
font-weight:500;
}

.nav-links a:hover{
color:#C89B4D;
}

.header-phone{
background:#061326;
color:#fff;
padding:12px 20px;
border-radius:50px;
font-size:14px;
display:flex;
align-items:center;
gap:8px;
}

/* BLOG MAIN */

.blog-main{
padding:60px 0;
}

.blog-layout{
display:grid;
grid-template-columns:2.5fr 1fr;
gap:50px;
}

.category-tabs{
display:flex;
flex-wrap:wrap;
gap:12px;
margin-bottom:25px;
}

.tab-btn{
text-decoration:none;
padding:12px 22px;
border-radius:50px;
background:#fff;
border:1px solid #e8dfd2;
color:#061326;
font-size:14px;
font-weight:500;
transition:.3s;
}

.tab-btn:hover{
background:#C89B4D;
color:#fff;
}

.tab-btn.active{
background:#061326;
color:#fff;
}

.blog-search{
display:flex;
margin-bottom:35px;
}

.blog-search input{
flex:1;
height:54px;
border:1px solid #ddd;
padding:0 18px;
border-radius:12px 0 0 12px;
outline:none;
}

.blog-search button{
width:60px;
border:none;
background:#061326;
color:#fff;
border-radius:0 12px 12px 0;
cursor:pointer;
}

.blog-grid{
display:grid;
grid-template-columns:repeat(2,1fr);
gap:30px;
}

.blog-card{
background:#fff;
border-radius:22px;
overflow:hidden;
box-shadow:0 10px 30px rgba(0,0,0,.05);
transition:.3s;
}

.blog-card:hover{
transform:translateY(-6px);
}

.blog-card-image img{
width:100%;
height:260px;
object-fit:cover;
display:block;
}

.blog-card-content{
padding:25px;
}

.blog-category{
display:inline-block;
padding:8px 16px;
border-radius:30px;
background:#f5efe5;
color:#C89B4D;
font-size:12px;
font-weight:600;
margin-bottom:15px;
}

.blog-card h3{
font-family:'Cormorant Garamond',serif;
font-size:32px;
line-height:1.2;
margin-bottom:15px;
color:#061326;
}

.blog-card p{
line-height:1.8;
font-size:14px;
color:#666;
margin-bottom:20px;
}

.blog-meta{
display:flex;
gap:20px;
font-size:13px;
margin-bottom:20px;
color:#777;
}

.read-more{
display:inline-block;
padding:12px 22px;
border-radius:50px;
background:#061326;
color:#fff;
text-decoration:none;
font-size:14px;
font-weight:600;
}

.blog-right{
display:flex;
flex-direction:column;
gap:25px;
}

.sidebar-card{
background:#fff;
padding:25px;
border-radius:20px;
box-shadow:0 10px 25px rgba(0,0,0,.04);
}

.sidebar-card h3{
font-family:'Cormorant Garamond',serif;
font-size:28px;
margin-bottom:18px;
}

.popular-post{
padding:12px 0;
border-bottom:1px solid #eee;
}

.popular-post:last-child{
border-bottom:none;
}

.popular-post a{
text-decoration:none;
color:#061326;
font-weight:500;
line-height:1.6;
}

.sidebar-categories{
list-style:none;
}

.sidebar-categories li{
margin-bottom:12px;
}

.sidebar-categories a{
text-decoration:none;
color:#061326;
}

.newsletter-box p{
margin-bottom:18px;
line-height:1.8;
color:#666;
}

.newsletter-box input{
width:100%;
height:50px;
border:1px solid #ddd;
padding:0 15px;
border-radius:10px;
margin-bottom:12px;
}

.newsletter-box button{
width:100%;
height:50px;
border:none;
background:#061326;
color:#fff;
border-radius:10px;
cursor:pointer;
}

.featured-blog{
padding:20px 0 60px;
}

.featured-card{
display:grid;
grid-template-columns:1.2fr 1fr;
background:#fff;
border-radius:28px;
overflow:hidden;
box-shadow:0 10px 30px rgba(0,0,0,.05);
}

.featured-image img{
width:100%;
height:100%;
object-fit:cover;
display:block;
}

.featured-content{
padding:50px;
display:flex;
flex-direction:column;
justify-content:center;
}

.featured-tag{
color:#C89B4D;
font-size:13px;
font-weight:700;
letter-spacing:2px;
text-transform:uppercase;
margin-bottom:15px;
}

.featured-content h2{
font-family:'Cormorant Garamond',serif;
font-size:52px;
line-height:1.1;
margin-bottom:20px;
}

.featured-content p{
line-height:1.9;
color:#666;
margin-bottom:25px;
}

.featured-btn{
display:inline-block;
width:max-content;
padding:14px 24px;
background:#061326;
color:#fff;
text-decoration:none;
border-radius:50px;
}

.cta-section{
padding:80px 0;
}

.cta-box{
background:#061326;
border-radius:30px;
padding:70px;
text-align:center;
color:#fff;
}

.cta-box h2{
font-family:'Cormorant Garamond',serif;
font-size:58px;
margin-bottom:20px;
}

.cta-box p{
max-width:700px;
margin:auto;
line-height:1.9;
font-size:16px;
opacity:.9;
margin-bottom:30px;
}

.cta-btn{
display:inline-block;
padding:15px 30px;
background:#C89B4D;
color:#fff;
text-decoration:none;
border-radius:50px;
font-weight:600;
}

.footer{
background:#061326;
padding:80px 0 30px;
color:#fff;
}

.footer-grid{
display:grid;
grid-template-columns:2fr 1fr 1fr 1fr;
gap:50px;
}

.footer-logo{
height:60px;
margin-bottom:20px;
}

.footer-about p{
line-height:1.9;
color:#d9d9d9;
}

.footer-title{
font-family:'Cormorant Garamond',serif;
font-size:28px;
margin-bottom:20px;
color:#fff;
}

.footer-links{
list-style:none;
}

.footer-links li{
margin-bottom:12px;
}

.footer-links a{
text-decoration:none;
color:#d9d9d9;
}

.footer-links a:hover{
color:#C89B4D;
}

.footer-bottom{
margin-top:50px;
padding-top:25px;
border-top:1px solid rgba(255,255,255,.1);
text-align:center;
color:#bfbfbf;
font-size:14px;
}

/* =========================
   MOBILE RESPONSIVE
========================= */

@media(max-width:1024px){

.blog-layout{
grid-template-columns:1fr;
}

.blog-right{
margin-top:40px;
}

.blog-grid{
grid-template-columns:1fr;
}

.featured-card{
grid-template-columns:1fr;
}

.hero-content h1{
font-size:56px;
}

.footer-grid{
grid-template-columns:1fr 1fr;
}

}

@media(max-width:768px){

.container{
width:94%;
}

.nav-container{
flex-direction:column;
height:auto;
padding:15px 0;
gap:15px;
}

.nav-links{
flex-wrap:wrap;
justify-content:center;
gap:15px;
}

.blog-hero{
padding:50px 0;
}

.blog-hero-grid{
grid-template-columns:1fr;
gap:40px;
}

.hero-content h1{
font-size:42px;
}

.hero-content p{
font-size:15px;
}

.featured-content{
padding:30px;
}

.featured-content h2{
font-size:38px;
}

.blog-grid{
grid-template-columns:1fr;
}

.blog-card h3{
font-size:26px;
}

.cta-box{
padding:40px 25px;
}

.cta-box h2{
font-size:40px;
}

.footer-grid{
grid-template-columns:1fr;
gap:35px;
}

}

@media(max-width:480px){

.hero-content h1{
font-size:34px;
}

.featured-content h2{
font-size:30px;
}

.page-btn{
width:40px;
height:40px;
}

.cta-box h2{
font-size:30px;
}

.footer-title{
font-size:24px;
}

}

</style>

</head>

<body>

<header class="header">

<div class="container nav-container">

<a href="index.php">

<img
src="assets/images/caringsquad-logo.png"
class="site-logo"
alt="Caring Squad">

</a>

<ul class="nav-links">

<li><a href="index.php">Home</a></li>

<li><a href="about.php">Our Story</a></li>

<li><a href="doctor.php">Expert Consultation</a></li>

<li><a href="care.php">Care</a></li>

<li><a href="companion.php">Companion</a></li>

<a
href="blog.php"
class="tab-btn <?php echo ($category_id==0)?'active':''; ?>">
All Articles
</a>

</ul>

<div class="header-phone">

<i class="fa-solid fa-phone"></i>

1800 571 1929

</div>

</div>

</header>

<section class="blog-hero">

<div class="container">

<div class="blog-hero-grid">

<div class="hero-content">

<div class="hero-label">
CARE • COMPANIONS • GUARDIANS
</div>

<div class="hero-divider"></div>

<h1>
Insights that care.
<br>
<span>Guidance that empowers.</span>
</h1>

<div class="hero-heart">
<i class="fa-solid fa-heart"></i>
</div>

<p>
Expert insights, real stories, and practical guidance
to help families make better care decisions with confidence.
</p>

</div>

<div class="hero-image">

<img
src="assets/images/blog-hero.jpg"
alt="Blog Hero">

</div>

</div>

</div>

</section>

<?php if($featured){ ?>

<section class="featured-blog">

<div class="container">

<div class="featured-card">

<div class="featured-image">

<img
src="admin/uploads/blogs/<?php echo $featured['featured_image']; ?>"
alt="<?php echo htmlspecialchars($featured['title']); ?>">

</div>

<div class="featured-content">

<span class="featured-tag">

Featured Article

</span>

<h2>

<?php echo $featured['title']; ?>

</h2>

<p>

<?php echo $featured['excerpt']; ?>

</p>

<a
href="blog_details.php?slug=<?php echo $featured['slug']; ?>"
class="featured-btn">

Read Full Story

</a>

</div>

</div>

</div>

</section>

<?php } ?>

<section class="blog-main">

<div class="container">

<div class="blog-layout">

<div class="blog-left">

<!-- Category Tabs -->

<div class="category-tabs">

<a
href="blog.php"
class="tab-btn active">

All Articles

</a>

<?php
while($cat=mysqli_fetch_assoc($categories)){
?>

<a
href="blog.php?category=<?php echo $cat['id']; ?>"
class="tab-btn <?php echo ($category_id==$cat['id'])?'active':''; ?>">

<?php echo $cat['category_name']; ?>

</a>

<?php } ?>

</div>

<!-- Search -->

<form
method="GET"
class="blog-search">

<input
type="text"
name="search"
placeholder="Search articles..."
value="<?php echo htmlspecialchars($search); ?>">

<button type="submit">

<i class="fa-solid fa-magnifying-glass"></i>

</button>

</form>

<div class="blog-grid">

<?php while($blog=mysqli_fetch_assoc($blogs)){ ?>

<div class="blog-card">

<div class="blog-card-image">

<?php if(!empty($blog['featured_image'])){ ?>

<img
src="admin/uploads/blogs/<?php echo $blog['featured_image']; ?>"
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

<?php echo substr(strip_tags($blog['excerpt']),0,120); ?>...

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

<?php } ?>

</div>

<div class="blog-pagination"></div>

<a href="#" class="page-btn active">1</a>

<a href="#" class="page-btn">2</a>

<a href="#" class="page-btn">3</a>

<a href="#" class="page-btn">

<i class="fa-solid fa-arrow-right"></i>

</a>

</div>

<div class="blog-right">

<div class="sidebar-card">

<h3>
Popular Articles
</h3>

<?php while($pop=mysqli_fetch_assoc($popular)){ ?>

<div class="popular-post">

<a
href="blog_details.php?slug=<?php echo $pop['slug']; ?>">

<?php echo $pop['title']; ?>

</a>

</div>

<?php } ?>

</div>

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
WHERE status='Active'
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

<div class="sidebar-card newsletter-box">

<h3>
Join Our Newsletter
</h3>

<p>

Get elder care tips,
wellness insights and updates.

</p>

<form>

<input
type="email"
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

<section class="cta-section">

<div class="container">

<div class="cta-box">

<h2>

Need Personal Care Guidance?

</h2>

<p>

Connect with our care experts and get personalized
recommendations for elder care, companionship,
wellness support and healthcare services.

</p>

<a
href="contact.php"
class="cta-btn">

Talk To An Expert

</a>

</div>

</div>

</section>

<footer class="footer">

<div class="container">

<div class="footer-grid">

<div class="footer-about">

<img
src="assets/images/caringsquad-logo.png"
class="footer-logo"
alt="Caring Squad">

<p>

Compassionate elder care,
expert consultations,
companionship and wellness
support for every stage of life.

</p>

</div>

<div>

<h3 class="footer-title">

Company

</h3>

<ul class="footer-links">

<li><a href="about.php">About Us</a></li>

<li><a href="care.php">Care Services</a></li>

<li><a href="companion.php">Companion</a></li>

<li><a href="contact.php">Contact</a></li>

</ul>

</div>

<div>

<h3 class="footer-title">

Resources

</h3>

<ul class="footer-links">

<li><a href="blog.php">Blogs</a></li>

<li><a href="#">FAQs</a></li>

<li><a href="#">Privacy Policy</a></li>

<li><a href="#">Terms</a></li>

</ul>

</div>

<div>

<h3 class="footer-title">

Support

</h3>

<ul class="footer-links">

<li>1800 571 1929</li>

<li>support@caringsquad.in</li>

<li>India</li>

</ul>

</div>

</div>

<div class="footer-bottom">

© <?php echo date('Y'); ?> Caring Squad.
All Rights Reserved.

</div>

</div>

</footer>
</body>
</html>