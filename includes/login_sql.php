<?php
session_start(); 
include 'database_connection.php';

/**
* 1. Koppla upp till databasen
* 2. Hämta användaren från databasen
* 3. Kolla så att lösenordet stämmer
* överrens med lösenordet som användaren
* fyllt i formuläret: password_verify
*/

//if user fills in login fields
if(isset($_POST["username"]) && isset($_POST["password"])){
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    $select_all_with_username = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    
    $select_all_with_username->execute(
        [
            ":username" => $username
        ]
);

$fetched_user = $select_all_with_username->fetch();

// compare
$is_password_correct = password_verify($password, $fetched_user["password"]);

if($is_password_correct){
    //save user globally to session
    $_SESSION["username"] = $fetched_user["username"];
    $_SESSION["user_id"] = $fetched_user["id"];
    //go to product page
    header('Location: ../index.php ');
    
}else{
    //handle errors, go back to front page and populate $_GET
    header('Location: ../views/login.php?error=Your username or password is incorrect');
}
}