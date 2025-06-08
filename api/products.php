<?php

header("Content-Type: application/json");

require_once '../includes/connect.php';

$method = $_SERVER['REQUEST_METHOD'];
$params = json_decode(file_get_contents('php://input'), true);

// print_r($method);
// echo "<br/><br/>";
// print_r($params);

switch ($method) {
    case 'GET':
        // fetch record
        fetchProduct($conn,$params);
        break;
    case 'POST':
        // insert record
        createProduct($conn, $params);
        break;
    case 'PUT':
        // update record
        updateProduct($conn, $params);
        break;
    case 'DELETE':
        // delete record
        deleteProduct($conn, $params);
        break;
    default:
        $response = ['message' => 'Invalid request method'];
        echo json_encode($response);
        break;
}

function fetchProduct($conn,$params) {
    
    if(empty($params) || count($params) == 0){

        $q = "SELECT * FROM products ";
        $res = runQuery($q,[]);
        $data = mysqli_fetch_all($res);
        echo json_encode($data);
        exit;
    }

    $ids = array_column($params, 'id');
    $id_list = implode(',',$ids);

    $q = "
        SELECT *
        FROM products
        WHERE id in ( $id_list )
    ";
    $res = runQuery($q,[]);
    $data = mysqli_fetch_all($res);

    if(count($data)>0){
        $data['msg'] = count($data).' records found !';
    }
    else{
        $data['msg'] = ' no records found !';
    }

    echo json_encode($data);
    exit;
    // print_r( $str);
    // echo json_encode($params);
}

function createProduct($conn, $params) {

    if(empty($params) || count($params) == 0){
        $response['msg'] = 'no input received';
        echo json_encode($response);
        exit;
    }

    $product = $params[0];
    if( !isset($product['name']) || !isset($product['description']) || !isset($product['price']) ){
        $response['msg'] = 'invalid inputs received';
        echo json_encode($response);
        exit;
    }
    
    $product['price'] = intval($product['price']);
    $q = "  INSERT INTO products
            (name, description, price)
            VALUES
            (?,?,?)";
    
    $res = runQuery($q, [$product['name'], $product['description'], $product['price']]);


    if($res == 0){
        echo json_encode( [ "msg"=>"cannot create product !"] );
    }
    else{
        echo json_encode( [ "msg"=>"product added successfully !"] );
    }

}

function updateProduct($conn, $params) {
    if(empty($params) || count($params) == 0){
        $response['msg'] = 'no input received';
        echo json_encode($response);
        exit;
    }

    $product = $params[0];
    if( !isset($product['id']) || !isset($product['name']) || !isset($product['description']) || !isset($product['price']) ){
        $response['msg'] = 'invalid inputs received';
        echo json_encode($response);
        exit;
    }
    $product['price'] = intval($product['price']);
    $q = "  UPDATE products
            SET name=?, description=?, price=?
            WHERE id = ?";
    
    $res = runQuery($q, [$product['name'], $product['description'], $product['price'], $product['id']]);


    if($res == 0){
        echo json_encode( [ "msg"=>"cannot update product !"] );
    }
    else{
        echo json_encode( [ "msg"=>"product updated successfully !"] );
    }
}

function deleteProduct($conn, $params) {

    // print_r($params);
    if(empty($params) || count($params) == 0){

       $data['msg'] = 'invalid input';
        echo json_encode($data);
        exit;
    }

    $q = "
        DELETE FROM products
        WHERE id = ?
    ";
    $res = runQuery($q, [$params[0]['id']]);

    if($res == 0){
        echo json_encode( [ "msg"=>"cannot delete, record not found !"] );
    }
    else{
        echo json_encode( [ "msg"=>"record deleted successfully !"] );
    }

}
?>