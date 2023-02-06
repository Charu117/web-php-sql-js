<?php session_start(); 
require_once '../Logic/class.php'; 

$email = $_SESSION['username'];

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
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container"> 
        <a class="navbar-brand" href="#">Techosource</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu"><span class="navbar-toggler-icon"></span></button>
        <div class="justify-content-sm-end collapse navbar-collapse" id="navmenu">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="../view/home.php" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a href="../view/user.php" class="nav-link">Account</a>
                </li>
                <li class="nav-item">
                    <button type="submit" class="btn btn-dark btn-sm mt-1">Log out</button>
                </li>
                <li class="nav-item">
                    <a href="cart.php" class="nav-link"><i class="bi bi-bag"></i></a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<section class="container-sm">
    <div class="row">
    <div id="main" class="col order-5"></div>
    </div>
</section>

<section class="container">
    <div class="mt-3">
        <form method="post">
            <button type="submit" class="btn btn-warning" name="checkOutSubmit">Check Out</button>
        </form>
    </div>
</section>
<?php 
    
?>
<script type="text/javascript">
    window.onload = () => {
        const main = document.getElementById('main')
        const productObj = JSON.parse('<?php $user = new UserReg(); echo $user->viewCart($email);?>')

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
                        <p class="card-text"><small class="text-muted">${obj.price}</small></p>
                        <form method="post">
                            <div class="input-group mb-3">
                                <input type="number" class="form-control" value="${obj.quantity}" aria-label="Qty" aria-describedby="basic-addon2" name="quantity" id="${obj.input_reference}">
                                <button type="submit" class="btn btn-outline-danger" name="del-${obj.input_reference}"><i class="bi bi-trash"></i></button>
                                <button type="submit" class="btn btn-outline-success" name="save-${obj.input_reference}"><i class="bi bi-check2">Save</i></button>
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
</body>
</html>