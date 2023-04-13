<?php
require "config/config.php";
require "config/crxckdconfig.php";

function crxckdDBConnect() {
    $db = new mysqli(SERVER, USERNAME, PASSWORD, DATABASE);

    if($db->connect_errno !=0 ) {
        $error = $db->connect_error;
        $error_date = date("F j, Y, g:i a");
        $message = "${error} | ${error_date} \r\n";
        file_put_contents("../../logs/db-log.txt");
        return false;
    } else {
        $db->set_charset("utf8mb4");
        return $db;
    }
}

function guidv4($data = null) {
    // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
    $data = $data ?? random_bytes(16);
    assert(strlen($data) == 16);

    // Set version to 0100
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    // Set bits 6-7 to 10
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    // Output the 36 character UUID.
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

function crxckdRegisterUser($username, $password, $confirm_password) {
    $db = crxckdDBConnect();
    $args = func_get_args();

    $args = array_map(function($value){
        return trim($value);
    }, $args);

    foreach ($args as $value) { // check if all fields are filled
        if(empty($value)){
            return "All fields are required";
        }
    }

    foreach ($args as $value) { // no weird characters
        if(preg_match("/([<|>])/", $value)){
            return "<> characters are not allowed";
        }
    }

    // no email validate
    // no email existence check
    
    // check if username > 3
    if(strlen($username) < 3){
        return "Please choose a username that is 3 characters or longer.";
    }

    // check if username < 100 characters
    if(strlen($username) > 100){
        return "Username is to long";
    }

    //check if username exists
    $stmt = $db->prepare("SELECT username FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    if($data != NULL){
        return "Username already exists, please use a different username";
    }

    //check if password is > 8
    if (strlen($password) < 8) {
        return "For your own safety, please choose a password thats longer than eight characters.";
    }
    //check if password is < 255
    if(strlen($password) > 255){
        return "Password is to long";
    }

    if($password != $confirm_password){
        return "Passwords don't match";
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $uuid = guidv4(); // generate uuid for user

    $stmt = $db->prepare("INSERT INTO users(user_id, username, password) VALUES(?,?,?)");
    $stmt->bind_param("sss", $uuid, $username, $hashed_password);
    $stmt->execute();
    if($stmt->affected_rows != 1){
        return "An error occurred. Please try again";
    }else{
        return "success";			
    }
}

function crxckdLoginUser($username, $password){
    $db = crxckdDBConnect();
    $username = trim($username);
    $password = trim($password);

    if($username == "" || $password == ""){
        return "Both fields are required";
    }

    $username = filter_var($username, FILTER_SANITIZE_STRING);
    $password = filter_var($password, FILTER_SANITIZE_STRING);

    $sql = "SELECT username, password, user_type, account_status FROM users WHERE username = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    if($data == NULL){
        return "Wrong username or password";
    }

    if(password_verify($password, $data["password"]) == FALSE){
        return "Wrong username or password";
    }else{
        $_SESSION["user"] = $username;
        $_SESSION["account_status"] = $data['account_status'];
        $_SESSION["account_type"] = $data['user_type'];
        header("location: $URL_REDIRECT_AFTER_LOGIN");
        exit();
    }
}

function crxckdLogoutUser(){
    session_destroy();
    header("Location: $URL_REDIRECT_AFTER_LOGOUT");
    exit();
}

function crxckdScheduleAccountForDeletion(){
    //
}

function crxckdINMDeleteUser(){
    $db = connect();

    $sql = "DELETE FROM users WHERE username = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("s", $_SESSION['user']);
    $stmt->execute();
    if($stmt->affected_rows != 1){
        return "An error occurred. Please try again";
    }else{
        session_destroy();
        header("location: $URL_REDIRECT_AFTER_INMEDIATE_ACCOUNT_DELETION");			
        exit();
    }
}