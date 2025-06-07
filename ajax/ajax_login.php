<?php
require_once '../includes/connect.php';

$response['status'] = 'NA';
$data = $_POST['data'];

$email = $data['email'];
$password = $data['password'];

$q = "
    SELECT *
    FROM users
    WHERE email = ?
";
$params = [$email];

$result = runQuery($q, $params);

if(mysqli_num_rows($result) == 0){
    $response['status'] = 'error';
    $response['msg'] = 'email or password incorrect';
    echo json_encode($response);
    exit;
}

$row = mysqli_fetch_assoc($result);

if(password_verify($password,$row['password'] )){
    $response['status'] = 'success';
    $response['msg'] = 'login success';
    
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['user_email'] = $row['email'];

    echo json_encode($response);
    exit;
}
else{
    $response['status'] = 'error';
    $response['msg'] = 'email or password incorrect';
    echo json_encode($response);
    exit;
}

