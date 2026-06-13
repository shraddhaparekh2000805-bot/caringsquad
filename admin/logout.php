<?php

session_start();

/* =========================================
   CHECK ADMIN SESSION
========================================= */

if(!isset($_SESSION['admin'])){

    header("Location: login.php");
    exit();
}

/* =========================================
   LOGOUT VALIDATION
========================================= */

if(isset($_GET['confirm']) && $_GET['confirm'] == 'yes'){

    /* REMOVE SESSION */

    session_unset();

    /* DESTROY SESSION */

    session_destroy();

    /* REDIRECT */

    header("Location: login.php?logout=success");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Logout | Caring Squad</title>

<link rel="preconnect" href="https://fonts.googleapis.com">

<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{

    font-family:'Montserrat',sans-serif;

    background:#f5f3ef;

    display:flex;

    align-items:center;

    justify-content:center;

    height:100vh;
}

.logout-card{

    width:450px;

    background:#fff;

    border-radius:24px;

    padding:45px;

    text-align:center;

    box-shadow:0 10px 35px rgba(0,0,0,0.08);
}

.logout-icon{

    width:90px;
    height:90px;

    border-radius:50%;

    margin:0 auto 25px;

    background:rgba(235,87,87,0.12);

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:38px;

    color:#eb5757;
}

.logout-card h2{

    font-family:'Cormorant Garamond',serif;

    font-size:42px;

    color:#04142b;

    margin-bottom:14px;
}

.logout-card p{

    color:#666;

    font-size:15px;

    line-height:1.8;

    margin-bottom:35px;
}

.logout-actions{

    display:flex;

    gap:15px;
}

.cancel-btn,
.logout-btn{

    flex:1;

    height:55px;

    border:none;

    border-radius:14px;

    font-size:15px;

    font-weight:600;

    cursor:pointer;

    transition:0.3s;
}

.cancel-btn{

    background:#f1f1f1;

    color:#04142b;
}

.cancel-btn:hover{

    background:#e4e4e4;
}

.logout-btn{

    background:linear-gradient(to right,#b98b4c,#d7b27c);

    color:#04142b;
}

.logout-btn:hover{

    transform:translateY(-2px);
}

</style>

</head>

<body>

<div class="logout-card">

    <div class="logout-icon">

        ⎋

    </div>

    <h2>

        Logout

    </h2>

    <p>

        Are you sure you want to logout from the admin dashboard?

    </p>

    <div class="logout-actions">

        <button
            class="cancel-btn"
            onclick="window.location.href='dashboard.php'"
        >

            Cancel

        </button>

        <button
            class="logout-btn"
            onclick="window.location.href='logout.php?confirm=yes'"
        >

            Logout

        </button>

    </div>

</div>

</body>
</html>