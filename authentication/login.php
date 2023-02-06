<?php ob_start();  session_start();
  //echo $_SESSION['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/style.css">
    <title>Register or Login</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container"> 
        <a class="navbar-brand" href="#">Techosource</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu"><span class="navbar-toggler-icon"></span></button>
        <div class="justify-content-sm-end collapse navbar-collapse" id="navmenu">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="../index.php" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Register/Login</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link"><i class="bi bi-bag"></i></a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- Login and Register forms -->
<section class="container mt-5" style="width: 40rem;">
    <div class="container-fluid" style="display:block;" id="login">
        <div class="text-center">
            <h3>Log In</h3>
        </div>
        <form method="post">
            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="logEmail" name="logEmail" placeholder="name@example.com" required>
                <label for="logEmail">Email address</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="logPassword" name="logPassword" placeholder="Password" required>
                <label for="logPassword">Password</label>
            </div>
            <div>
                <input type="submit" class="btn btn-secondary mt-3" style="width: 37rem;" name="login" value="Login">
            </div>
            <div class="h7">
                if you haven't logged in yet, <button type="button" class="btn btn-light btn-sm" onclick="hideLogin()">click here,</button>to register!
            </div>
        </form>
    </div>
    <div class="container-fluid" style="width: 30rem;display:none" id="register">
    <div class="text-center">
            <h3>Register</h3>
        </div>
        <form method="post">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="RegName" name="RegName" placeholder="Name">
                <label for="RegName">Name</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" name="RegSurname" placeholder="Surname">
                <label for="RegSurname">Surname</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="RegAddress" name="RegAddress" placeholder="Home Address" required>
                <label for="RegAddress">Home Address</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="PostalCode" name="PostalCode" placeholder="Post Code" required>
                <label for="PostalCode">Post Code</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="city" name="city" placeholder="City" required>
                <label for="city">City</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="phoneNum" name="phoneNum" placeholder="Phone Number" required>
                <label for="phoneNum">Phone Number</label>
            </div>
            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="RegEmail" name="RegEmail" placeholder="Email" required>
                <label for="RegEmail">Email Address</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="passwd" name="passwd" placeholder="Password" required>
                <label for="passwd">Password</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="confpwd" name="confpwd" placeholder="Confirm Password" required>
                <label for="confpwd">Confirm Password</label>
            </div>
            <div>
                <input type="submit" class="btn btn-secondary mt-3" style="width: 28.5rem;" name="register" value="Register">
            </div>
            <div class="h7 mt-3">
                if you have already registered, <button type="button" class="btn btn-light btn-sm" onclick="hideRegister()">click here,</button>to log in!
            </div>
        </form>
    </div>
</section>

<script>
    function hideRegister(){
        document.getElementById('login').style.display ="block";
        document.getElementById('register').style.display = "none";

    }
    function hideLogin(){
        document.getElementById('login').style.display ="none";
        document.getElementById('register').style.display = "block";
    }
</script>
<?php
    require_once '../Logic/class.php';

    if(isset($_POST['login'])){
        $user = new UserReg();
        $verified = $user->login($_REQUEST['logEmail'],$_REQUEST['logPassword']);
        if($verified){
            $_SESSION['username'] = $_REQUEST['logEmail'];
            header('Location: http://techosource.com/view/home.php', true);
        }
    }elseif(isset($_POST['register']) && $_POST['passwd'] == $_POST['confpwd']){
        $session_id = $_SESSION['id'];
        $user = new UserReg();
        $verified = $user->register($_REQUEST['RegName'],$_REQUEST['RegSurname'],$_REQUEST['passwd'],$_REQUEST['RegEmail'],$_REQUEST['RegAddress'],$_REQUEST['PostalCode'],$_REQUEST['city'],$_REQUEST['phoneNum'], $session_id);
        if($verified){
            $_SESSION['username'] = $_REQUEST['RegEmail'];
            header('Location: http://techosource.com/view/home.php',true);
        }
    }
?>
</body>
</html>