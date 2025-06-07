<?php
error_reporting(E_ALL);
require_once ('../includes/connect.php');

$response = [
    'status'=> 'NA'
];

// echo json_encode($response);

// $data = file_get_contents("php://input");
// var_dump($_POST);exit;
// $data = json_decode($_POST['arr']);
// var_dump($data);
$data = $_POST['data'];

$name = $data['name'];
$email = $data['email'];
$password = $data['password'];

if( $name == "" || $email == "" || $password == ""){

    $response['status'] = 'error';
    $response['msg'] = 'one or more fields cannot be empty';

    echo json_encode($response);
    exit;
}

// check duplicate email
$sql = "SELECT * FROM users WHERE email = ? ";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $email);
 mysqli_stmt_execute($stmt);
 $result = mysqli_stmt_get_result($stmt);
$rowCount = mysqli_num_rows($result);

if($rowCount > 0){
    $response['status'] = 'error';
    $response['msg'] = 'email already exists !';
    
    echo json_encode($response);
    exit;
}

// other validations go here

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$sql = "
    INSERT INTO users (name, email, password) 
    VALUES (?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    if($stmt){
        mysqli_stmt_bind_param($stmt, "sss", $name, $email, $hashedPassword);

        if (mysqli_stmt_execute($stmt)) {
             $response['status']='success';
             $response['msg'] = 'signup successful !';
        } else {
             $response['status']='error';
             $response['msg'] = 'cannot create user';
        }
    }

    echo json_encode($response);
    exit;





// echo json_encode($response);