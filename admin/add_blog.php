<?php

session_start();
include '../db.php';

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

/* FETCH CATEGORIES */

$categories = mysqli_query(
    $conn,
    "SELECT *
     FROM blog_categories
     WHERE status=1
     ORDER BY category_name ASC"
);

/* SAVE BLOG */

if(isset($_POST['save_blog'])){

    $title = mysqli_real_escape_string(
        $conn,
        trim($_POST['title'])
    );

    $slug = strtolower($title);

    $slug = preg_replace(
        '/[^A-Za-z0-9-]+/',
        '-',
        $slug
    );

    $category_id = (int)$_POST['category_id'];

    $excerpt = mysqli_real_escape_string(
        $conn,
        $_POST['excerpt']
    );

    $content = mysqli_real_escape_string(
        $conn,
        $_POST['content']
    );

    $author = mysqli_real_escape_string(
        $conn,
        $_POST['author']
    );

    $read_time = mysqli_real_escape_string(
        $conn,
        $_POST['read_time']
    );

    $status = mysqli_real_escape_string(
        $conn,
        $_POST['status']
    );

    $featured =
        isset($_POST['featured'])
        ? 1
        : 0;

    $featured_image = "";

    if(
isset($_FILES['featured_image']) &&
!empty($_FILES['featured_image']['name'])
)
{
$featured_image =
    time().'_'.
    basename(
        $_FILES['featured_image']['name']
    );

move_uploaded_file(
    $_FILES['featured_image']['tmp_name'],
    'uploads/blogs/' .
    $featured_image
);

}

mysqli_query(
$conn,
"INSERT INTO blogs
(
title,
slug,
category_id,
featured_image,
excerpt,
content,
author,
read_time,
status,
featured
)
VALUES
(
'$title',
'$slug',
'$category_id',
'$featured_image',
'$excerpt',
'$content',
'$author',
'$read_time',
'$status',
'$featured'
)"
);

header("Location: blog_list.php");
exit();

}
?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Add Blog</title>

<link rel="preconnect"
href="https://fonts.googleapis.com">

<link rel="preconnect"
href="https://fonts.gstatic.com"
crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap"
rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

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
}

.sidebar-logo{
text-align:center;
margin-bottom:40px;
}

.brand-logo{
width:220px;
}

.sidebar-menu{
list-style:none;
}

.sidebar-menu li{
margin-bottom:12px;
}

.sidebar-menu a{
display:flex;
align-items:center;
gap:14px;
padding:15px 18px;
border-radius:14px;
text-decoration:none;
color:#fff;
}

.sidebar-menu a.active{
background:rgba(214,175,120,.15);
color:#d6af78;
}

.main-content{
margin-left:280px;
width:calc(100% - 280px);
padding:30px;
}

.page-card{
background:#fff;
border-radius:22px;
padding:35px;
box-shadow:0 8px 20px rgba(0,0,0,.04);
}

.page-title{
font-family:'Cormorant Garamond',serif;
font-size:42px;
margin-bottom:30px;
}

.form-group{
margin-bottom:22px;
}

.form-group label{
display:block;
font-weight:600;
margin-bottom:8px;
}

.form-group input,
.form-group select,
.form-group textarea{
width:100%;
border:1px solid #ddd;
border-radius:12px;
padding:14px;
font-size:14px;
}

.form-group input{
height:55px;
}

.submit-btn{
background:#d6af78;
border:none;
padding:15px 30px;
border-radius:12px;
font-weight:700;
cursor:pointer;
}

</style>

</head>

<body>

<div class="dashboard-layout">

<aside class="sidebar">

<div class="sidebar-logo">

<img
src="../assets/images/caringsquad-logo.png"
class="brand-logo">

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
<a href="manage.php">
<i class="fa-solid fa-hospital-user"></i>
Manage Doctors
</a>
</li>

<li>
<a href="blog_categories.php">
<i class="fa-solid fa-layer-group"></i>
Blog Categories
</a>
</li>

<li>
<a href="add_blog.php" class="active">
<i class="fa-solid fa-pen"></i>
Add Blog
</a>
</li>

<li>
<a href="blog_list.php">
<i class="fa-solid fa-newspaper"></i>
Manage Blogs
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

<div class="page-card">

<h1 class="page-title">
Add New Blog
</h1>

<form
method="POST"
enctype="multipart/form-data">
<div class="form-group">

<label>Blog Title</label>

<input
type="text"
name="title"
required>

</div>

<div class="form-group">

<label>Category</label>

<select
name="category_id"
required>

<option value="">
Select Category
</option>

<?php
while($cat =
mysqli_fetch_assoc($categories)){
?>

<option
value="<?php echo $cat['id']; ?>">

<?php
echo $cat['category_name'];
?>

</option>

<?php } ?>

</select>

</div>

<div class="form-group">

<label>Featured Image</label>

<input
type="file"
name="featured_image"
accept="image/*">

</div>

<div class="form-group">

<label>Excerpt</label>

<textarea
name="excerpt"
rows="4"></textarea>

</div>

<div class="form-group">

<label>Blog Content</label>

<textarea
name="content"
id="editor"></textarea>

</div>

<div class="form-group">

<label>Author</label>

<input
type="text"
name="author"
value="Caring Squad">

</div>

<div class="form-group">

<label>Read Time</label>

<input
type="text"
name="read_time"
placeholder="5 min read">

</div>

<div class="form-group">

<label>Status</label>

<select name="status">

<option value="Published">
Published
</option>

<option value="Draft">
Draft
</option>

</select>

</div>

<div class="form-group">

<label>

<input
type="checkbox"
name="featured"
value="1"
style="
width:auto;
height:auto;
margin-right:8px;
">

Featured Blog

</label>

</div>

<div class="form-group">

<button
type="submit"
name="save_blog"
class="submit-btn">

Save Blog

</button>

</div>
</form>

</div>

</main>

</div>
<script>

ClassicEditor
.create(
document.querySelector('#editor')
)
.catch(error=>{
console.error(error);
});

</script>
</body>
</html>
