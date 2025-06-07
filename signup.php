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

  
<div class="container">
  
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            
            <form method='post' onsubmit='return submitForm()' id='signup-form'>
                <div class="container" style='margin-top:10%;'>
                    <h3> sign-up </h3>
                    <div class="row">
                        <div class="col-md-12">
                            <div class='form-group'>
                                <input type='text' class='form-control' id='name' value='abc' name='name' placeholder='Name' required/>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class='form-group'>
                                <input  type='email' class='form-control' id='email' value='admin@abc.com' name='email' placeholder='Email' required/>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class='form-group'>
                                <input  type='password' class='form-control' id='password' value='admin' name='password' placeholder='Password' required/>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <button class='btn btn-primary' type='submit'> Sign-up </a>
                        </div>

                        <div class="col-md-12">
                            <a href='index.php'  class='btn btn-info' >Login</a>
                        </div>
                    </div>
                </div>
            </form>

        </div>
        <div class="col-md-4"></div>
    </div>

</div>

<script> 

    const txtName = document.getElementById('name');
    const txtEmail = document.getElementById('email');
    const pwdPassword = document.getElementById('password');

    function submitForm(){

// validate here

        postForm();

        return false;
    }

    async function postForm(){

        const data = {
            name: txtName.value,
            email:txtEmail.value,
            password: pwdPassword.value
        };
        console.log(data);
        const response = await postRequest(data, 'ajax/ajax_signup.php');

        const result = JSON.parse(response);
        alert(result.status + " " + result.msg );

        if(result.status=='success'){
            window.location.href = 'index.php';
        }
    }

</script>
</body>
</html>
