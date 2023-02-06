<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/style.css">
    <title>E-shop</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container"> 
        <a class="navbar-brand" href="#">Techosource</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu"><span class="navbar-toggler-icon"></span></button>
        <div class="justify-content-sm-end collapse navbar-collapse" id="navmenu">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="home.php" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a href="user.php" class="nav-link">Account</a>
                </li>
                <li class="nav-item">
                    <button type="submit" class="btn btn-dark btn-sm mt-1">Log out</button>
                </li>
                <li class="nav-item">
                    <a href="../cart/cart.php" class="nav-link"><i class="bi bi-bag"></i></a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="text-center mt-4"><h3>Account Details</h3></div>
<div class="container-sm mt-5">
<form method="post">
    <div class="input-group mb-3">
        <input type="text" class="form-control" name="name" id="name" readOnly>
        <button type="button" class="btn btn-outline-secondary" id="btn-name" onclick="writeName()"><i class="bi bi-pen-fill"></i></button>  
    </div>
    <div class="input-group mb-3">
        <input type="text" class="form-control" name="surname" id="surname" readOnly>
        <button type="button" class="btn btn-outline-secondary" id="btn-surname" onclick="writeSurname()"><i class="bi bi-pen-fill"></i></button>  
    </div>
    <div class="input-group mb-3">
        <input type="text" class="form-control" name="address" id="address" readOnly>
        <button type="button" class="btn btn-outline-secondary" id="btn-address" onclick="writeAddress()"><i class="bi bi-pen-fill"></i></button>  
    </div>
    <div class="input-group mb-3">
        <input type="text" class="form-control" name="postCode" id="postCode" readOnly>
        <button type="button" class="btn btn-outline-secondary" id="btn-postCode" onclick="writePostCode()"><i class="bi bi-pen-fill"></i></button>  
    </div> 
    <div class="input-group mb-3">
        <input type="text" class="form-control" name="city" id="city" readOnly>
        <button type="button" class="btn btn-outline-secondary" id="btn-city" onclick="writeCity()"><i class="bi bi-pen-fill"></i></button>  
    </div> 
    <div class="input-group mb-3">
        <input type="text" class="form-control" name="phone" id="phone" readOnly>
        <button type="button" class="btn btn-outline-secondary" id="btn-phone" onclick="writePhone()"><i class="bi bi-pen-fill"></i></button>  
    </div> 

    <div class="input-group mb-3">
        <input type="text" class="form-control" name="email" id="email" readOnly>
        <button type="button" class="btn btn-outline-secondary" id="btn-email"><i class="bi bi-pen-fill"></i></button>  
    </div> 
    <div class="input-group mb-3">
        <input type="text" class="form-control" name="password" id="password" readOnly>
        <button type="button" class="btn btn-outline-secondary" id="btn-password" onclick="writePassword()"><i class="bi bi-pen-fill"></i></button>  
    </div> 
    <div class="input-group mb-3 justify-content-center">
        <input type="submit" class="btn btn-secondary" name="submit" value="Save changes">
    </div>

</form>
</div>
<?php require_once '../Logic/class.php';
    $email = $_SESSION['username'];

    $user = new UserReg();
    
    if(isset($_POST['submit']) ? true : false){
        $user->update_userDetails($_REQUEST['name'], $_REQUEST['surname'], $_REQUEST['password'], $_REQUEST['address'], $_REQUEST['postcode'],$_REQUEST['city'],$_REQUEST['phone'],$email);
    }
    
   
?>
<script type="text/javascript">

function writeName(){
    document.getElementById('name').readOnly = false;
}
function writeSurname(){
    document.getElementById('surname').readOnly = false;
}
function writeAddress(){
    document.getElementById('address').readOnly = false;
}
function writePostCode(){
    document.getElementById('postCode').readOnly = false;
}
function writeCity(){
    document.getElementById('city').readOnly = false;
}
function writePhone(){
    document.getElementById('phone').readOnly = false;
}
function writePassword(){
    document.getElementById('password').readOnly = false;
}

window.onload = () => {
    let customerObj = JSON.parse('<?php echo $user->currentUser($email); ?>')

    document.getElementById('name').value = customerObj[0].name
    document.getElementById('surname').value = customerObj[0].surname
    document.getElementById('address').value = customerObj[0].address
    document.getElementById('postCode').value = customerObj[0].post_code
    document.getElementById('city').value = customerObj[0].city
    document.getElementById('phone').value = customerObj[0].phone
    document.getElementById('email').value = customerObj[0].email
    document.getElementById('password').value = customerObj[0].password
}
</script>
</body>
</html>