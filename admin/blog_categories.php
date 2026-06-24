<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../db.php';
if(!isset($_SESSION['admin'])){ header("Location: login.php"); exit(); }

/* ADD CATEGORY */

if(isset($_POST['add_category'])){
$category_name = mysqli_real_escape_string(
$conn,
trim($_POST['category_name'])
);
if($category_name != ''){
mysqli_query(
$conn,
"INSERT INTO blog_categories
(category_name)
VALUES
('$category_name')"
);
}
header("Location: blog_categories.php");
exit();
}

/* DELETE CATEGORY */

if(isset($_GET['delete'])){
$id = (int)$_GET['delete'];
mysqli_query(
$conn,
"DELETE FROM blog_categories
WHERE id='$id'"
);
header("Location: blog_categories.php");
exit();
}

/* TOGGLE STATUS */

if(isset($_GET['toggle'])){

    $id = (int)$_GET['toggle'];

    mysqli_query(
        $conn,
        "UPDATE blog_categories
         SET status = IF(status=1,0,1)
         WHERE id='$id'"
    );

    header("Location: blog_categories.php");
    exit();
}

$categories = mysqli_query( $conn, "SELECT * FROM blog_categories ORDER BY id ASC" );
?>

<!DOCTYPE html> <html>
<head>
<meta charset="UTF-8"> <meta name="viewport" content="width=device-width,initial-scale=1">
<title>Blog Categories</title>
<link rel="preconnect" href="https://fonts.googleapis.com">

<link href="https://fonts.googleapis.com/css2?
family=Cormorant+Garamond:wght@500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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
.card{ 
    background:#fff; 
    padding:30px; 
    border-radius:20px; 
    margin-bottom:25px; 
}
h1{ 
    font-family:'Cormorant Garamond',serif; 
    font-size:42px; 
    margin-bottom:25px; 
}
input{ 
    width:100%; 
    height:55px; 
    border:1px solid #ddd; 
    border-radius:12px; 
    padding:0 15px; 
}
button{ 
    margin-top:15px; 
    background:#d6af78; 
    border:none; 
    padding:14px 25px; 
    border-radius:10px;
    font-weight:600; 
    cursor:pointer; 
}
table{ 
    width:100%; 
    border-collapse:collapse; 
    background:#fff; 
    border-radius:20px; 
    overflow:hidden; 
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

.status-active{ 
    color:green; 
    font-weight:600; 
}
.status-inactive{ 
    color:red; 
    font-weight:600; 
}
.action-btn{ 
    padding:8px 12px; 
    border-radius:8px; 
    text-decoration:none; 
    font-size:13px; 
    margin-right: 5px; 
}
.toggle{ 
    background:#d6af78; 
    color:#04142b; 
}
.delete{ 
    background:#eb5757; 
    color:white; 
}

</style>
</head>
<body>

<div class="dashboard-layout">
<aside class="sidebar">
<div class="sidebar-logo">
<img src="../assets/images/caringsquad-logo.png" class="brand-logo">
</div>
<ul class="sidebar-menu">
<li> <a href="dashboard.php"> <i class="fa-solid fa-house"></i> Dashboard </a> </li>
<li> <a href="add-doctor.php"> <i class="fa-solid fa-user-plus"></i> Add Doctor </a> </li>
<li> <a href="manage.php"> <i class="fa-solid fa-hospital-user"></i> Manage Doctors </a> </li>
<li> <a href="blog_categories.php" class="active"> <i class="fa-solid fa-layer-group"></i> Blog Categories </a> </li>
<li> <a href="add_blog.php"> <i class="fa-solid fa-pen"></i> Add Blog </a> </li>
<li> <a href="blog_list.php"> <i class="fa-solid fa-newspaper"></i> Manage Blogs </a> </li>
<li> <a href="logout.php"> <i class="fa-solid fa-right-from-bracket"></i> Logout </a> </li>
</ul>
</aside>
<main class="main-content">

<div class="card">
<h1>Blog Categories</h1>
<form method="POST">
<input type="text" name="category_name" placeholder="Enter Category Name" required>
<button type="submit" name="add_category"> Add Category </button>
</form>
</div>
<table>
<thead>
<tr>
<th>ID</th> <th>Category</th> <th>Status</th> <th>Actions</th>
</tr>
</thead>
<tbody>
<?php while($cat=mysqli_fetch_assoc($categories)){ ?>
<tr>
<td><?php echo $cat['id']; ?></td>
<td><?php echo $cat['category_name']; ?></td>
<td>
<?php if($cat['status']==1){ ?>
<span class="status-active"> Active </span>
<?php }else{ ?>
<span class="status-inactive"> Inactive </span>
<?php } ?>
</td>

<td>
<a class="action-btn toggle"
href="?toggle=<?php echo $cat['id']; ?>">

<?php
echo ($cat['status']==1)
? 'Deactivate'
: 'Activate';
?>

</a>

<a class="action-btn delete" onclick="return confirm('Delete category?')" href="?delete=<?php echo
$cat['id']; ?>"> Delete </a>

</td>
</tr>
<?php } ?>
</tbody>
</table>
</main>
</div>
</body>
</html>