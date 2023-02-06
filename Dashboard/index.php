<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/style.css">
    <title>Admin Dashboard</title>
</head>
<body>
    <section class="container mt-5" style="width: 40rem;">
        <div class="container-fluid row" id="login">
            <div class="text-center">
                <h3>Log In</h3>
            </div>
            <form method="post">
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="logEmail" name="logEmail" placeholder="name@example.com" required>
                    <label for="logEmail">Email address</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="logPassword" name="logPassword" placeholder="Password" required>
                    <label for="logPassword">Password</label>
                </div>
                <div class="">
                    <input type="submit" class="btn btn-secondary mt-3" style="width: 34rem;" name="login" value="Login">
                </div>
            </form>
        </div>
    </section>
    
</body>
</html>