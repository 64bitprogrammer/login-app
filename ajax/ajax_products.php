<?php
require_once '../includes/connect.php';
require_once '../includes/session_check.php';

$response['status'] = 'NA';
$data = $_POST['data'];

switch($data['operation']){

    case 'fetch-all-products':
        fetchAllproducts();
        break;
    
    case 'delete-product':
        $product_id = $data['product_id'];
        deleteproduct($product_id);
        break;
    
    case 'update-product':
        updateproduct();
        break;
    
    case 'create-product':
        createproduct();
        break;
       
    default:
        $response['status'] = 'error';
        $response['msg'] = 'Invalid operation';
        echo json_encode($response);
        exit;
}


function createproduct(){

    global $data;
    $name = $data['name'];
    $description = $data['description'];
    $price = intval($data['price']);

    $q = "
        INSERT INTO products
        (name, description, price)
        values
        (?,?,?)
    ";
    $params = [$name, $description, $price];

    $result  = runQuery($q, $params);

    if($result > 0){
        $response['status'] = 'success';
        $response['msg'] = " new product added succesfully";
    }
    else{
        $response['status'] = 'error';
        $response['msg'] = " error adding new product !";
    }
    echo json_encode($response);
    exit;

}

function updateproduct(){
    
    global $data;
    $new_name = $data['new_name'];
    $new_description = $data['new_description'];
    $new_price = intval($data['new_price']);
    $product_id = $data['product_id'];
    
    if($new_price == ""){
        $q = "
            UPDATE products
            set name = ?, description = ?
            WHERE id = ?
        ";
        $params = [$new_name, $new_description, $product_id];
    }
    else{
        $q = "
            UPDATE products
            set name = ?, description = ?, price = ?
            WHERE id = ?
        ";
        $params = [$new_name, $new_description, $new_price, $product_id];
    }

    $result = runQuery($q, $params);
    
    if($result > 0){
        $response['status'] = 'success';
        $response['msg'] = " product with id $product_id updated successfully !";
    }
    else{
        $response['status'] = 'error';
        $response['msg'] = " cannot update product !";
    }

    echo json_encode($response);
    exit;
}


function deleteproduct($product_id){

    //<todo> avoid deleting all products

    $q = "
        DELETE FROM products
        WHERE id = ?
    ";
    $product_id = intval($product_id);

    $arr = [$product_id];

    $result = runQuery($q,$arr);

    if($result > 0){
        $response['status'] = 'success';
        $response['msg'] = " product with id $product_id deleted successfully !";
    }
    else{
        $response['status'] = 'error';
        $response['msg'] = " cannot delete product !";
    }

    echo json_encode($response);
}


function fetchAllproducts(){
    global $response;
    $html = "";
    $q = "
        SELECT id, name, description, price
        FROM products
    ";

    $result = runQuery($q,[]);

    // no products available
    if(mysqli_num_rows($result)==0){
        $html = "
            <tr style='text-align:center;'>
                <td colspan='4'> No products Available </td>
            </tr>
        ";

        $response['status'] = 'success';
        $response['msg'] = 'no products available';
        $response['html'] = $html;

        echo json_encode($response,JSON_UNESCAPED_SLASHES);
        exit;
    }

    while($row = mysqli_fetch_assoc($result)){

        $product_list[$row['id']]['name'] = $row['name'];
        $product_list[$row['id']]['description'] = $row['description'];
        $product_list[$row['id']]['price'] = $row['price'];

        $html .= "
            <tr>
                <td> ".$row['id']." </td>
                <td> ".$row['name']." </td>
                <td> ".$row['description']." </td>
                <td> ".$row['price']." </td>
                <td>
                    <button class='btn btn-sm btn-primary' data-toggle='modal' data-target='#myModal' onclick='editProduct(\"".$row['id']."\")'> Edit </button>
                    <button class='btn btn-sm btn-danger' onclick='deleteProduct(\"".$row['id']."\")'> Delete </button>
                </td>
            </tr>
        ";
    }

    $response['status'] = 'success';
    $response['msg'] = mysqli_num_rows($result) . ' products found ';
    $response['html'] = $html;
    $response['product_list'] = $product_list;

    echo json_encode($response);
    exit;
}

