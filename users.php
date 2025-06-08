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
            <a href='products.php'>Products</a><br/>
            <a href='logout.php'>Logout</a>
        </div>
        <div class='col-md-8'>

            <div class='container'>
                <h4> Users </h4>
                <button class='btn btn-sm btn-primary' data-toggle="modal" data-target="#createUser">Create User</button>
                <table class='table table-bordered'>
                    <thead>
                        <th>ID </th>
                        <th> Name </th>
                        <th> Email </th>
                        <th> Action </th>
                    </thead>
                    <tbody id='table-body'>

                    </tbody>
                </table>
            </div>

        </div>
        <div class='col-md-2'></div>
    </div>

        <!-- update user modal -->
    <div class="modal" id="myModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            
                <!-- Modal Header -->
                <div class="modal-header">
                <h4 class="modal-title">Edit User</h4>
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
                                <input class='form-control' placeholder="email" id='email' id='email' type='text'/>
                            </div>
                        </div>
                        <div class='col-md-12'>
                            <div class='form-group'>
                                <input class='form-control' placeholder="password" id='password' id='password' type='password'/>
                            </div>
                        </div>
                        <div class='col-md-12'>
                            <button class='btn btn-primary' onclick='updateUserDetails()'>Update</button>
                        </div>
                    </div>
                </div>
                
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
                
            </div>
        </div>
    </div> <!-- end of update user modal -->



    <!-- create user modal -->
    <div class="modal" id="createUser">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            
                <!-- Modal Header -->
                <div class="modal-header">
                <h4 class="modal-title"> Create User</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body">
                    <div class='row'>
                        <div class='col-md-12'>
                            <div class='form-group'>
                                <input class='form-control' placeholder="name" id='new_name' id='new_name' type='text'/>
                            </div>
                        </div>
                        <div class='col-md-12'>
                            <div class='form-group'>
                                <input class='form-control' placeholder="email" id='new_email' id='new_email' type='text'/>
                            </div>
                        </div>
                        <div class='col-md-12'>
                            <div class='form-group'>
                                <input class='form-control' placeholder="password" id='new_password' id='new_password' type='password'/>
                            </div>
                        </div>
                        <div class='col-md-12'>
                            <button class='btn btn-primary' onclick='createUser()'>Create</button>
                        </div>
                    </div>
                </div>
                
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
                
            </div>
        </div>
    </div> <!-- end of create user modal -->
</div>

<script>
    var operation = 'fetch-all-users';
    var users_list = [];
    var current_user = -1;
    const table_body = document.getElementById('table-body');

    document.addEventListener("DOMContentLoaded", function () {
        loadAllUsers();
    });

    async function createUser(){
        const data = {
            operation: 'create-user',
            name: document.getElementById('new_name').value,
            email: document.getElementById('new_email').value,
            password: document.getElementById('new_password').value,
        };

        const result = await postRequest(data, 'ajax/ajax_users.php');
        console.log(result);
        const response =  JSON.parse(result);

        if(response.status == 'success'){
            alert(response.status + ": "+ response.msg );
            $('#createUser').modal('hide');
            document.getElementById('new_name').value = "";
            document.getElementById('new_email').value = "";
            document.getElementById('new_password').value = "";
            loadAllUsers();
        }
        else{
            alert(response.status + ": "+ response.msg );
        }
    }

    async function updateUserDetails(){

        const new_name = document.getElementById('name');
        const new_email = document.getElementById('email');
        const new_password = document.getElementById('password');

        const data = {
            operation: 'update-user',
            new_name: new_name.value,
            new_email: new_email.value,
            new_password: new_password.value,
            user_id : current_user
        };

        const result = await postRequest(data, 'ajax/ajax_users.php');
        console.log(result);
        const response = JSON.parse(result);
        if(response.status == 'success'){
            alert(response.status + ": "+ response.msg );
            $('#myModal').modal('hide');
            loadAllUsers();
        }
        else{
             alert(response.status + ": "+ response.msg );
        }
        
    }

    function editUser(user_id){
        current_user = user_id;
        fetchUserDetails(user_id);
    }

    function fetchUserDetails(user_id){

        document.getElementById('email').value = users_list[user_id]['email'];
        document.getElementById('name').value = users_list[user_id]['name'];
    }

    async function loadAllUsers(){
        const data = {
            operation : 'fetch-all-users'
        };
        const result = await postRequest(data,'ajax/ajax_users.php');
        console.log(result);
        const response = JSON.parse(result);

        if(response.status == 'success'){
            table_body.innerHTML = response.html;
            users_list = response.user_list;
            console.log(users_list);
        }
        else{
            alert(response.status + ": "+ response.msg );
        }
        
    }

    async function deleteUser(id){

        const data = {
            operation: 'delete-user',
            user_id: id
        };
        const result = await postRequest(data, 'ajax/ajax_users.php');
        console.log(result);
        const response = JSON.parse(result);

        alert(response.status + ": "+ response.msg );

        loadAllUsers();
    }
</script>
</body>
</html>


