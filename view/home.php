<?php session_start();
require_once '../Logic/class.php';
if(isset($_SESSION['username']) ? true : false){
  /* */
}else{
  header("Location: http://techosource.com/authentication/login.php");
}
  
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
    <title>E-shop</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark">
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
                    <button type="submit" class="btn btn-dark btn-sm mt-1" name="logOut">Log out</button>
                </li>
                <li class="nav-item">
                    <a href="../cart/cart.php" class="nav-link"><i class="bi bi-bag"></i></a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<?php
  if(isset($_POST['logOut']) ? true : false){
    header("Location: http://techosource.com/authentication/login.php");
    session_destroy();
  }
  
?>

<section class="container-sm py-5">
    <div id="main" style="margin-right: 50px !important; width:200px;"></div>
</section>
<script type="text/javascript">
    
    window.onload = () => {
        const main = document.getElementById('main')
        const productObj = JSON.parse('<?php $user = new UserNav(); echo $user->products();?>')

        //variable to hold html
        let output = ''

        // loop over the two nested arrays
        for (var i = 0; i < productObj.length; i++){
            var obj = productObj[i]
            output += `<div class="card mt-5 me-5" style="width: 40rem;">
                            <div class="row g-0">
                                <div class="col-md-3">
                                <img src="${obj.image}" class="img-fluid rounded" alt="...">
                            </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">${obj.product_name}</h5>
                                        <p class="card-text">${obj.description}</p>
                                        <form method="POST">
                                            <div class="input-group mb-3">
                                                <input type="number" class="form-control" placeholder="Qty" aria-label="Qty" aria-describedby="basic-addon2" name="qty-${obj.category}-${obj.idP}">
                                                <button type="submit" class="btn btn-outline-secondary" name="sub-${obj.category}-${obj.idP}"><i class="bi bi-bag-plus"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>`
        }
        main.insertAdjacentHTML('afterbegin', output) 
    }
</script>
<?php 
    $customer = new UserReg();
    $i = 0;
    while($i < $customer->count_rows_products()["count"]){
        $json = json_decode($user->products(), true);
        //echo "sub-".$json[$i]["category"] . "-" . $json[$i]["idP"];
        $current_submit = "sub-".$json[$i]["category"] . "-" . $json[$i]["idP"];
        $current_element = "qty-".$json[$i]["category"] . "-" . $json[$i]["idP"];
        if(isset($_POST[$current_submit])){
            //echo "HERE";
            $email = $_SESSION['username'];
            $input_value = $_REQUEST[$current_element];
            $customer->add_to_cart($email, $json[$i]["idP"], $input_value);
            //echo "HERE";
           
        }
        $i++;
    }
    
?>
<footer class="container">
  <div class="row">
    <div class="col-12 col-md">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="d-block mb-2" role="img" viewBox="0 0 24 24"><title>Product</title><circle cx="12" cy="12" r="10"/><path d="M14.31 8l5.74 9.94M9.69 8h11.48M7.38 12l5.74-9.94M9.69 16L3.95 6.06M14.31 16H2.83m13.79-4l-5.74 9.94"/></svg>
      <small class="d-block mb-3 text-muted">&copy; 2022–2023</small>
    </div>
    <div class="col-6 col-md">
      <h5>Features</h5>
      <ul class="list-unstyled text-small">
        <li><a class="link-secondary" href="#">Cool stuff</a></li>
        <li><a class="link-secondary" href="#">Random feature</a></li>
        <li><a class="link-secondary" href="#">Team feature</a></li>
        <li><a class="link-secondary" href="#">Stuff for developers</a></li>
        <li><a class="link-secondary" href="#">Another one</a></li>
        <li><a class="link-secondary" href="#">Last time</a></li>
      </ul>
    </div>
    <div class="col-6 col-md">
      <h5>Resources</h5>
      <ul class="list-unstyled text-small">
        <li><a class="link-secondary" href="#">Resource name</a></li>
        <li><a class="link-secondary" href="#">Resource</a></li>
        <li><a class="link-secondary" href="#">Another resource</a></li>
        <li><a class="link-secondary" href="#">Final resource</a></li>
      </ul>
    </div>
    <div class="col-6 col-md">
      <h5>Resources</h5>
      <ul class="list-unstyled text-small">
        <li><a class="link-secondary" href="#">Business</a></li>
        <li><a class="link-secondary" href="#">Education</a></li>
        <li><a class="link-secondary" href="#">Government</a></li>
        <li><a class="link-secondary" href="#">Gaming</a></li>
      </ul>
    </div>
    <div class="col-6 col-md">
      <h5>About</h5>
      <ul class="list-unstyled text-small">
        <li><a class="link-secondary" href="#">Team</a></li>
        <li><a class="link-secondary" href="#">Locations</a></li>
        <li><a class="link-secondary" href="#">Privacy</a></li>
        <li><a class="link-secondary" href="#">Terms</a></li>
      </ul>
    </div>
  </div>
</footer>
</body>
</html>