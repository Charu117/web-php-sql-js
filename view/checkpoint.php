<?php require_once '../Logic/class.php';
session_start();

function getUser(){
    $email = $_SESSION['user_id'];
    $user = new UserReg();
    return $user->currentUser($email);
}
