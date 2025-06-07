<?php
require_once '../includes/connect.php';
require_once '../includes/session_check.php';

$response['status'] = 'NA';
$data = $_POST['data'];

switch($data['operation']){

    case 'fetch-all-users':
        fetchAllUsers();
        break;
    
    case 'delete-user':
        $user_id = $data['user_id'];
        deleteUser($user_id);
        break;
    
    case 'update-user':
        updateUser();
        break;
    
    case 'create-user':
        createUser();
        break;
    
    default:
        $response['status'] = 'error';
        $response['msg'] = 'Invalid operation';
}



function createUser(){

    global $data;
    $name = $data['name'];
    $email = $data['email'];
    $password = $data['password'];

    if(checkEmailAlreadyExists( $email)){
        $response['status'] = 'error';
        $response['msg'] = "new email already exists ";
        echo json_encode($response);
        exit;
    }

    $q = "
        INSERT INTO users
        (name, email, password)
        values
        (?,?,?)
    ";
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $params = [$name, $email, $hashed_password];

    $result  = runQuery($q, $params);

    if($result > 0){
        $response['status'] = 'success';
        $response['msg'] = " new user created succesfully";
    }
    else{
        $response['status'] = 'error';
        $response['msg'] = " error creating new user !";
    }
    echo json_encode($response);
    exit;

}

function updateUser(){
    
    global $data;
    $new_name = $data['new_name'];
    $new_email = $data['new_email'];
    $new_password = $data['new_password'];
    $user_id = $data['user_id'];
    
    if(checkEmailAlreadyExists($new_email,$user_id )){
        $response['status'] = 'error';
        $response['msg'] = "new email already exists ";
        echo json_encode($response);
        exit;
    }

    if($new_password == ""){
        $q = "
            UPDATE users
            set name = ?, email = ?
            WHERE id = ?
        ";
        $params = [$new_name, $new_email, $user_id];
    }
    else{
        $q = "
            UPDATE users
            set name = ?, email = ?, password = ?
            WHERE id = ?
        ";
        $hashed_password = password_hash($new_password,PASSWORD_DEFAULT);
        $params = [$new_name, $new_email, $hashed_password, $user_id];
    }

    $result = runQuery($q, $params);
    
    if($result > 0){
        $response['status'] = 'success';
        $response['msg'] = " user with id $user_id updated successfully !";
    }
    else{
        $response['status'] = 'error';
        $response['msg'] = " cannot update user !";
    }

    echo json_encode($response);
    exit;
}

function checkEmailAlreadyExists($email, $user_id=-1){

    if($user_id == -1){
        $q = "
                SELECT id
                FROM users
                WHERE email = ?
            ";
            $params = [$email];
    }
    else{
        $q = "
            SELECT id
            FROM users
            WHERE email = ? AND id != ?
        ";
        $params = [$email, $user_id];
    }
    

    $result = runQuery($q,$params);

    if(mysqli_num_rows($result)>0){
        return true;
    }
    else{
        return false;
    }
}

function deleteUser($user_id){

    //<todo> avoid deleting all users

    $q = "
        DELETE FROM users
        WHERE id = ?
    ";
    $user_id = intval($user_id);

    $arr = [$user_id];

    $result = runQuery($q,$arr);

    if($result > 0){
        $response['status'] = 'success';
        $response['msg'] = " user with id $user_id deleted successfully !";
    }
    else{
        $response['status'] = 'error';
        $response['msg'] = " cannot delete user !";
    }

    echo json_encode($response);
}


function fetchAllUsers(){
    global $response;
    $html = "";
    $q = "
        SELECT id, name, email
        FROM users
    ";

    $result = runQuery($q,[]);

    // no users available
    if(mysqli_num_rows($result)==0){
        $html = "
            <tr style='text-align:center;'>
                <td colspan='4'> No Users Available </td>
            </tr>
        ";

        $response['status'] = 'success';
        $response['msg'] = 'no users available';
        $response['html'] = $html;

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        exit;
    }

    while($row = mysqli_fetch_assoc($result)){

        $user_list[$row['id']]['name'] = $row['name'];
        $user_list[$row['id']]['email'] = $row['email'];

        $html .= "
            <tr>
                <td> ".$row['id']." </td>
                <td> ".$row['name']." </td>
                <td> ".$row['email']." </td>
                <td>
                    <button class='btn btn-sm btn-primary' data-toggle='modal' data-target='#myModal' onclick='editUser(\"".$row['id']."\")'> Edit </button>
                    <button class='btn btn-sm btn-danger' onclick='deleteUser(\"".$row['id']."\")'> Delete </button>
                </td>
            </tr>
        ";
    }

    $response['status'] = 'success';
    $response['msg'] = mysqli_num_rows($result) . ' users found ';
    $response['html'] = $html;
    $response['user_list'] = $user_list;

    echo json_encode($response);
    exit;
}

