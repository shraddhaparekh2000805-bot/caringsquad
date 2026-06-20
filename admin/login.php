<?php

session_start();

if(isset($_SESSION['admin'])){

    header("Location: dashboard.php");
    exit();
}

$error = "";

if(isset($_POST['admin_login'])){

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    /* STATIC ADMIN LOGIN */

    $admin_email = "admin@caringsquad.in";
    $admin_password = "caringsquad";

    if($email == $admin_email && $password == $admin_password){

        $_SESSION['admin'] = true;
        $_SESSION['admin_name'] = "Administrator";

        header("Location: dashboard.php");
        exit();

    }else{

        $error = "Invalid Email or Password!";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Login | Caring Squad</title>

    <!-- GOOGLE FONTS -->

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- FONT AWESOME -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>

        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body{

            font-family: 'Montserrat', sans-serif;

            background:
            linear-gradient(rgba(3,15,33,0.85), rgba(3,15,33,0.90)),
            url('https://images.unsplash.com/photo-1576091160550-2173dba999ef?q=80&w=2070&auto=format&fit=crop');

            background-size: cover;
            background-position: center;

            min-height: 100vh;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 20px;
        }

        .login-card{

            width: 100%;
            max-width: 460px;

            background: rgba(255,255,255,0.96);

            border-radius: 24px;

            padding: 50px 45px;

            box-shadow: 0 20px 50px rgba(0,0,0,0.25);

            position: relative;

            overflow: hidden;
        }

        .login-card::before{

            content: "";

            position: absolute;

            top: 0;
            left: 0;

            width: 100%;
            height: 6px;

            background: linear-gradient(to right,#c8a46b,#e4c38d);
        }

        .login-logo{

            text-align: center;

            margin-bottom: 35px;
        }

        .logo-circle{

            width: 78px;
            height: 78px;

            margin: auto;

            border-radius: 50%;

            background: #04142b;

            display: flex;
            align-items: center;
            justify-content: center;

            margin-bottom: 18px;
        }

        .logo-circle i{

            color: #d4b07b;

            font-size: 30px;
        }

        .login-logo h1{

            font-family: 'Cormorant Garamond', serif;

            font-size: 38px;

            color: #04142b;

            letter-spacing: 1px;
        }

        .login-logo p{

            color: #666;

            margin-top: 8px;

            font-size: 14px;
        }

        .error-box{

            background: #ffe8e8;

            color: #d62828;

            padding: 14px 16px;

            border-radius: 12px;

            margin-bottom: 20px;

            font-size: 14px;

            border-left: 4px solid #d62828;
        }

        .input-group{

            margin-bottom: 22px;
        }

        .input-group label{

            display: block;

            margin-bottom: 10px;

            font-size: 14px;

            font-weight: 600;

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

            color: #888;
        }

        .input-box input{

            width: 100%;

            height: 58px;

            border: 1px solid #ddd;

            border-radius: 14px;

            padding: 0 18px 0 50px;

            font-size: 15px;

            outline: none;

            transition: 0.3s;
        }

        .input-box input:focus{

            border-color: #c8a46b;

            box-shadow: 0 0 0 4px rgba(200,164,107,0.15);
        }

        .login-btn{

            width: 100%;

            height: 58px;

            border: none;

            border-radius: 14px;

            background: linear-gradient(to right,#b99155,#d8b37a);

            color: #04142b;

            font-size: 16px;

            font-weight: 700;

            cursor: pointer;

            transition: 0.3s;

            margin-top: 10px;
        }

        .login-btn:hover{

            transform: translateY(-2px);

            box-shadow: 0 10px 25px rgba(185,145,85,0.35);
        }

        .bottom-text{

            text-align: center;

            margin-top: 24px;

            color: #777;

            font-size: 14px;
        }

        .bottom-text span{

            color: #c8a46b;

            font-weight: 600;
        }

        @media(max-width:500px){

            .login-card{

                padding: 40px 25px;
            }

            .login-logo h1{

                font-size: 30px;
            }
        }

    </style>

</head>

<body>

    <div class="login-card">

        <div class="login-logo">

            <div class="logo-circle">
                <i class="fa-regular fa-heart"></i>
            </div>

            <h1>Caring Squad</h1>

            <p>
                Admin Dashboard Login
            </p>

        </div>

        <?php if(!empty($error)){ ?>

            <div class="error-box">

                <?php echo $error; ?>

            </div>

        <?php } ?>

        <form method="POST">

            <div class="input-group">

                <label>Email Address</label>

                <div class="input-box">

                    <i class="fa-regular fa-envelope"></i>

                    <input
                        type="email"
                        name="email"
                        placeholder="Enter admin email"
                        required
                    >

                </div>

            </div>

            <div class="input-group">

                <label>Password</label>

                <div class="input-box">

                    <i class="fa-solid fa-lock"></i>

                    <input
                        type="password"
                        name="password"
                        placeholder="Enter password"
                        required
                    >

                </div>

            </div>

            <button
                type="submit"
                name="admin_login"
                class="login-btn"
            >
                Login to Dashboard
            </button>

        </form>

        <div class="bottom-text">

            Caring Squad <span>Admin Panel</span>

        </div>

    </div>

</body>
</html>