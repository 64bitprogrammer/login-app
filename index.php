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
            
            <form method='post' onsubmit='return submitForm()'>
                <div class="container" style='margin-top:10%;'>
                    <h3> login </h3>
                    <div class="row">
                        <div class="col-md-12">
                            <div class='form-group'>
                                <input class='form-control' value='admin@abc.com' type='email' required id='email' name='email' placeholder='Email' />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class='form-group'>
                                <input class='form-control' value='admin' type='password' id='password' name='password' placeholder='Password' />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <a href='forgot-password.php'> Forgot Password </a>
                        </div>
                        <div class="col-md-12">
                            <input type='submit'  class='btn btn-primary' value='Login'>
                        </div>
                        
                        <div class="col-md-12">
                            <a class='btn btn-info' href='signup.php'> Sign-up </a>
                        </div>
                    </div>
                </div>
            </form>

        </div>
        <div class="col-md-4"></div>
    </div>

</div>

<script>
    const email = document.getElementById('email');
    const password = document.getElementById('password');

     function submitForm(){

        const data = {
            'email': email.value,
            'password': password.value
        };
        // validate here
        postForm(data);

        // always false
        return false;
    }

    async function postForm(data){

        const result = await postRequest(data,'ajax/ajax_login.php');

        const response = JSON.parse(result);

        if(response.status == 'success'){
            alert(response.msg);
            window.location.href = 'users.php';
        }
        else{
            alert(response.status + ': ' +response.msg);
        }
    }
</script>

</body>
</html>
