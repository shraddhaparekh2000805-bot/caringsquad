<?php

session_start();
include '../db.php';

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

/* DELETE BLOG */

if(isset($_GET['delete'])){

    $id = (int)$_GET['delete'];

    $blogQuery = mysqli_query(
        $conn,
        "SELECT featured_image
         FROM blogs
         WHERE id='$id'"
    );

    $blogData = mysqli_fetch_assoc($blogQuery);

    if(!empty($blogData['featured_image'])){

        $imagePath =
        "../uploads/blogs/" .
        $blogData['featured_image'];

        if(file_exists($imagePath)){
            unlink($imagePath);
        }
    }

    mysqli_query(
        $conn,
        "DELETE FROM blogs
         WHERE id='$id'"
    );

    header("Location: blog_list.php");
    exit();
}

/* FETCH BLOGS */

$blogs = mysqli_query(
    $conn,
    "SELECT
        blogs.*,
        blog_categories.category_name
     FROM blogs
     LEFT JOIN blog_categories
     ON blogs.category_id =
        blog_categories.id
     ORDER BY blogs.id ASC"
);

?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width,initial-scale=1">

<title>Manage Blogs</title>

<link rel="preconnect"
href="https://fonts.googleapis.com">

<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap"
rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

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
left:0;
top:0;
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
padding:30px;
border-radius:20px;
}

.page-title{
font-family:'Cormorant Garamond',serif;
font-size:42px;
margin-bottom:25px;
}

table{
width:100%;
border-collapse:collapse;
}

thead{
background:#04142b;
color:#fff;
}

th,td{
padding:16px;
text-align:left;
}

tr{
border-bottom:1px solid #eee;
}

.blog-thumb{
width:80px;
height:60px;
object-fit:cover;
border-radius:8px;
}

.status{
padding:8px 14px;
border-radius:30px;
font-size:12px;
font-weight:600;
}

.published{
background:#d4edda;
color:#155724;
}

.draft{
background:#f8d7da;
color:#721c24;
}

.featured{
background:#d6af78;
padding:5px 10px;
border-radius:20px;
font-size:12px;
}

.action-btn{
padding:8px 12px;
border-radius:8px;
text-decoration:none;
font-size:13px;
margin-right:5px;
}

.edit{
background:#007bff20;
color:#007bff;
}

.delete{
background:#eb575720;
color:#eb5757;
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
<a href="add_blog.php">
<i class="fa-solid fa-pen"></i>
Add Blog
</a>
</li>

<li>
<a href="blog_list.php"
class="active">
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
Manage Blogs
</h1>

<table>

<thead>

<tr>
<th>ID</th>
<th>Image</th>
<th>Title</th>
<th>Category</th>
<th>Status</th>
<th>Featured</th>
<th>Created</th>
<th width="220">Actions</th>
</tr>

</thead>

<tbody>

<?php while($blog = mysqli_fetch_assoc($blogs)){ ?>

<tr>

<td>
<?php echo $blog['id']; ?>
</td>

<td>

<?php if(!empty($blog['featured_image'])){ ?>

<img
src="../uploads/blogs/<?php echo $blog['featured_image']; ?>"
class="blog-thumb">

<?php } else { ?>

No Image

<?php } ?>

</td>

<td>

<strong>
<?php echo $blog['title']; ?>
</strong>

</td>

<td>

<?php echo $blog['category_name']; ?>

</td>

<td>

<?php if($blog['status']=='Published'){ ?>

<span class="status published">
Published
</span>

<?php } else { ?>

<span class="status draft">
Draft
</span>

<?php } ?>

</td>

<td>

<?php if($blog['featured']==1){ ?>

<span class="featured">
Featured
</span>

<?php } else { ?>

-
<?php } ?>

</td>

<td>

<?php
echo date(
'd M Y',
strtotime($blog['created_at'])
);
?>

</td>

<td>

<a
href="edit_blog.php?id=<?php echo $blog['id']; ?>"
class="action-btn edit">

Edit

</a>

<a
href="?delete=<?php echo $blog['id']; ?>"
class="action-btn delete"
onclick="return confirm('Delete this blog?')">

Delete

</a>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</main>

</div>

</body>
</html>