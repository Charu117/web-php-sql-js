<?php

//Classe astratta (padre) che raggruppa i metodi comuni
abstract class User{
    //proprietà protette della classe padre
    protected $hostname = "192.168.1.182";
    protected $dbN = "eCommerce";
    
    protected $dbh;
    protected $stmt;

    public function __construct()
    {
        $this->connection();
    }

    protected function getProducts(){
        $sql = "SELECT * FROM product";
        $this->stmt = $this->dbh->prepare($sql);
        $this->stmt->execute();
        $data = $this->stmt->fetchAll(PDO::FETCH_ASSOC);

        $json = json_encode($data);
        $json = str_replace('\/', '/',$json);
        return $json;
    }
    protected function connection(){}
}
// Classe dell'utente navigatore 
class UserNav extends User{
    // La classe UserNav estenderà quindi eredita le proprietà e i metodi protetti
    private $username = "admin";
    private $password = "charu2001";
    public function connection(){
        $dsn = "mysql:host=" . $this->hostname . ";dbname=" . $this->dbN;
        try{
            $this->dbh = new PDO($dsn, $this->username, $this->password);
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            echo "failed: " . $e->getMessage();
        }
    }
    // richiamo della funzione getProducts di classe padre
    public function products(){
        return $this->getProducts();
    }
    public function set_session_id(){
        $sql = "INSERT INTO customer(name,surname,password,email,address,post_code,city,phone,session_id,reg_date) VALUES (NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,UUID_SHORT(),NULL)";
        $this->dbh->exec($sql);

        $last_id = $this->dbh->lastInsertId();
        
        $sql = "SELECT session_id FROM customer WHERE idC=?";
        $this->stmt = $this->dbh->prepare($sql);
        $this->stmt->execute([$last_id]);
        
        $session_id = $this->stmt->fetch();

        return $session_id["session_id"];
    }
}
// Class dell'utente registrato 
class UserReg extends User{
    // For accessing database
    private $username = "admin";
    private $password = "charu2001";

    // user details of the current customer
    
    public function connection(){
        $dsn = "mysql:host=" . $this->hostname . ";dbname=" . $this->dbN;
        try{
            $this->dbh = new PDO($dsn, $this->username, $this->password);
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "connected";
        }catch(PDOException $e){
            echo "failed: " . $e->getMessage();
        }
    }

    public function register($name, $surname, $password_user, $email, $address, $postCode, $city, $phoneNum, $session_id){
        $isLogged = $this->login($email,$password_user);
        $cond = NULL;
        if($isLogged){
            $cond = false;
        }else{
            //$sql = "INSERT INTO customer(name,surname,password,email,address,post_code,city,phone) VALUES (?,?,?,?,?,?,?,?)";
            $sql = "UPDATE customer SET name=? ,surname=?,password=?,email=?,address=?,post_code=?,city=?,phone=? WHERE session_id=?";
            $this->stmt = $this->dbh->prepare($sql);
            $this->stmt->execute([$name, $surname, $password_user, $email, $address, $postCode, $city, $phoneNum, $session_id]);
            $cond = true;
        }
        return $cond;
    }

    public function login($email, $password_user){
        $isLogged = false;
        $sql = "SELECT * FROM customer WHERE email=? AND email is not null";
        $this->stmt = $this->dbh->prepare($sql);
        $this->stmt->execute([$email]);

        $user = $this->stmt->fetch();

        if($user['password'] == $password_user){
            $isLogged = true;
        }

        return $isLogged;
    }
    public function currentUser($email){
        $sql = "SELECT * FROM customer WHERE email=?";
        $this->stmt = $this->dbh->prepare($sql);
        $this->stmt->execute([$email]);

        $customer = $this->stmt->fetchAll(PDO::FETCH_ASSOC);

        return json_encode($customer);
    }
    // metodo per modificare i dati personali di un user/customer
    public function update_userDetails($name, $surname, $password_user, $address, $postCode, $city, $phoneNum, $customer_email){
        if(!empty($name)){
            $sql = "UPDATE `customer` SET name=? WHERE email=?";
            $this->stmt = $this->dbh->prepare($sql);
            $this->stmt->execute([$name, $customer_email]);
        }elseif(!empty($surname)){
            $sql = "UPDATE `customer` SET surname=? WHERE email=?";
            $this->stmt = $this->dbh->prepare($sql);
            $this->stmt->execute([$surname, $customer_email]);
        }elseif(!empty($password_user)){
            $sql = "UPDATE `customer` SET password=? WHERE email=?";
            $this->stmt = $this->dbh->prepare($sql);
            $this->stmt->execute([$password_user, $customer_email]);
        }elseif(!empty($address)){
            $sql = "UPDATE `customer` SET address=? WHERE email=?";
            $this->stmt = $this->dbh->prepare($sql);
            $this->stmt->execute([$address, $customer_email]);
        }
        elseif(!empty($postCode)){
            $sql = "UPDATE `customer` SET post_code=? WHERE email=?";
            $this->stmt = $this->dbh->prepare($sql);
            $this->stmt->execute([$postCode, $customer_email]);
        }
        elseif(!empty($city)){
            $sql = "UPDATE `customer` SET city=? WHERE email=?";
            $this->stmt = $this->dbh->prepare($sql);
            $this->stmt->execute([$city, $customer_email]);
        }elseif(!empty($phoneNum)){
            $sql = "UPDATE `customer` SET phone=? WHERE email=?";
            $this->stmt = $this->dbh->prepare($sql);
            $this->stmt->execute([$phoneNum, $customer_email]);
        }

    }
    // Cart methods
    public function add_to_cart($email, $id_product,$quantity){
        $date = date('y-m-d');
        $sql = "SELECT fk_customer,fk_product, quantity FROM orderDetails, customer WHERE fk_customer=customer.idC AND fk_product=?";
        $this->stmt = $this->dbh->prepare($sql);
        $this->stmt->execute([$id_product]);
        $rowData = $this->stmt->fetch();
        $rowCount = $this->stmt->rowCount();

        if($rowCount > 0){
            $updatedQty = $rowData['quantity'] + $quantity;
            $sql = "UPDATE `orderDetails` SET quantity=? WHERE fk_customer=? AND fk_product=?";
            $this->stmt = $this->dbh->prepare($sql);
            $this->stmt->execute([$updatedQty, $rowData["fk_customer"], $rowData["fk_product"]]);
        }else{
            $sql = "INSERT INTO orderDetails(fk_customer,fk_product, quantity, order_date) values ((SELECT idC FROM customer WHERE email=?), (SELECT idP FROM product WHERE idP= ?), ?, ?)";
            $this->stmt = $this->dbh->prepare($sql);
            $this->stmt->execute([$email, $id_product, $quantity, $date]);
        }
    }

    public function count_rows_products(){
        $sql = "SELECT COUNT(*) as count FROM product";
        $this->stmt = $this->dbh->prepare($sql);
        $this->stmt->execute();
        $data = $this->stmt->fetch();

        return $data;
    }

    public function viewCart($email){
        $sql = "SELECT  p.image, p.price, p.product_name, p.input_reference, quantity FROM orderDetails o, customer c,product p WHERE fk_customer=c.idC AND c.email=? AND p.idP=fk_product";
        $this->stmt = $this->dbh->prepare($sql);
        $this->stmt->execute([$email]);

        $data = $this->stmt->fetchAll(PDO::FETCH_ASSOC);

        $json = json_encode($data);
        $json = str_replace('\/', '/',$json);
        return $json;

    }
     
}