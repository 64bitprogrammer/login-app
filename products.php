<?php

require_once 'includes/connect.php';
require_once 'includes/session_check.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/script.js"></script>
</head>
<body>

<div class='container ' style= 'margin-top: 20%;'>

    <div class='row'>
        <div class='col-md-2'>
            <a href='users.php'>Users</a><br/>
            <a href='logout.php'>Logout</a>
        </div>
        <div class='col-md-8'>

            <div class='container'>
                <h4> Products </h4>
                <button class='btn btn-sm btn-primary' data-toggle="modal" data-target="#createProduct">Add product</button>
                <table class='table table-bordered'>
                    <thead>
                        <th>ID </th>
                        <th> Name </th>
                        <th> Description </th>
                        <th> Price </th>
                        <th> Action </th>
                    </thead>
                    <tbody id='table-body'>

                    </tbody>
                </table>
            </div>

        </div>
        <div class='col-md-2'></div>
    </div>

        <!-- update product modal -->
    <div class="modal" id="myModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            
                <!-- Modal Header -->
                <div class="modal-header">
                <h4 class="modal-title">Edit product</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body">
                    <div class='row'>
                        <div class='col-md-12'>
                            <div class='form-group'>
                                <input class='form-control' placeholder="name" id='name' id='name' type='text'/>
                            </div>
                        </div>
                        <div class='col-md-12'>
                            <div class='form-group'>
                                <input class='form-control' placeholder="description"  id='description' id='description' type='text'/>
                            </div>
                        </div>
                        <div class='col-md-12'>
                            <div class='form-group'>
                                <input class='form-control'  placeholder="price" id='price' id='price' type='price'/>
                            </div>
                        </div>
                        <div class='col-md-12'>
                            <button class='btn btn-primary' onclick='updateProductDetails()'>Update</button>
                        </div>
                    </div>
                </div>
                
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
                
            </div>
        </div>
    </div> <!-- end of update product modal -->



    <!-- create product modal -->
    <div class="modal" id="createProduct">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            
                <!-- Modal Header -->
                <div class="modal-header">
                <h4 class="modal-title"> Create Product</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body">
                    <div class='row'>
                        <div class='col-md-12'>
                            <div class='form-group'>
                                <input class='form-control' placeholder="name"  id='new_name' id='new_name' type='text' placeholder="product name"/>
                            </div>
                        </div>
                        <div class='col-md-12'>
                            <div class='form-group'>
                                <input class='form-control' placeholder="description"  id='new_description' id='new_description' type='text' placeholder="product description"/>
                            </div>
                        </div>
                        <div class='col-md-12'>
                            <div class='form-group'>
                                <input class='form-control' placeholder="price"   id='new_price' id='new_price' type='price' placeholder="price"/>
                            </div>
                        </div>
                        <div class='col-md-12'>
                            <button class='btn btn-primary' onclick='createProduct()'>Create</button>
                        </div>
                    </div>
                </div>
                
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
                
            </div>
        </div>
    </div> <!-- end of create product modal -->
</div>

<script>
    var operation = 'fetch-all-products';
    var products_list = [];
    var current_product = -1;
    const table_body = document.getElementById('table-body');

    document.addEventListener("DOMContentLoaded", function () {
        loadAllProducts();
    });

    async function createProduct(){
        const data = {
            operation: 'create-product',
            name: document.getElementById('new_name').value,
            description: document.getElementById('new_description').value,
            price: document.getElementById('new_price').value,
        };

        const result = await postRequest(data, 'ajax/ajax_products.php');
        console.log(result);
        const response =  JSON.parse(result);

        if(response.status == 'success'){
            alert(response.status + ": "+ response.msg );
            $('#createProduct').modal('hide');
            document.getElementById('new_name').value = "";
            document.getElementById('new_description').value = "";
            document.getElementById('new_price').value = "";
            loadAllProducts();
        }
        else{
            alert(response.status + ": "+ response.msg );
        }
    }

    async function updateProductDetails(){

        const new_name = document.getElementById('name');
        const new_description = document.getElementById('description');
        const new_price = document.getElementById('price');

        const data = {
            operation: 'update-product',
            new_name: new_name.value,
            new_description: new_description.value,
            new_price: new_price.value,
            product_id : current_product
        };

        const result = await postRequest(data, 'ajax/ajax_products.php');
        console.log(result);
        const response = JSON.parse(result);
        if(response.status == 'success'){
            alert(response.status + ": "+ response.msg );
            $('#myModal').modal('hide');
            loadAllProducts();
        }
        else{
             alert(response.status + ": "+ response.msg );
        }
        
    }

    function editProduct(product_id){
        current_product = product_id;
        fetchProductDetails(product_id);
    }

    function fetchProductDetails(product_id){

        document.getElementById('description').value = products_list[product_id]['description'];
        document.getElementById('name').value = products_list[product_id]['name'];
        document.getElementById('price').value = products_list[product_id]['price'];
    }

    async function loadAllProducts(){
        const data = {
            operation : 'fetch-all-products'
        };
        const result = await postRequest(data,'ajax/ajax_products.php');
        console.log(result);
        const response = JSON.parse(result);

        if(response.status == 'success'){
            table_body.innerHTML = response.html;
            products_list = response.product_list;
            console.log(products_list);
        }
        else{
            alert(response.status + ": "+ response.msg );
        }
        
    }

    async function deleteProduct(id){

        const data = {
            operation: 'delete-product',
            product_id: id
        };
        const result = await postRequest(data, 'ajax/ajax_products.php');
        console.log(result);
        const response = JSON.parse(result);

        alert(response.status + ": "+ response.msg );

        loadAllProducts();
    }
</script>
</body>
</html>


