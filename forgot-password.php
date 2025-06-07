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
            
            <form method='post' id='form1' onsubmit='return resetPassword()'>
                <div class="container" style='margin-top:10%;' id='div1'>
                    <h3> password reset </h3>
                    <div class="row">

                        <div class="col-md-12">
                            <div class='form-group'>
                                <input class='form-control' value='admin@abc.com' required type='email' id='email' name='email' placeholder='Email' />
                            </div>
                        </div>

                        
                        <div class="col-md-12">
                            <button type='submit' class='btn btn-primary' > Reset password </button>
                        </div>

                        <div class="col-md-12">
                            <a href='index.php' type='' class='btn btn-info' >Login</a>
                        </div>
                    </div>
                </div>
            </form>

            <form method='post' id='form2' onsubmit='return verifyOTP()'>
                <div class="container" style='margin-top:10%;display:none;' id='div2'>
                    <h3> password reset </h3>
                    <div class="row">

                        <div class="col-md-12">
                            <div class='form-group'>
                                <input class='form-control' value='1111' maxlength='4' inputmode='numeric' pattern='[0-9]{4}' required type='text' id='otp' name='otp' placeholder='OTP' />

                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class='form-group'>
                                <input class='form-control' value='admin321' required type='password' id='password' name='password' placeholder='password' />
                            </div>
                        </div>

                        
                        <div class="col-md-12">
                            <button type='submit' class='btn btn-primary'> Verify </button>
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
    const email = document.getElementById('email');
    const otp = document.getElementById('otp');
    const new_password = document.getElementById('password');
    const div1 = document.getElementById('div1');
    const div2 = document.getElementById('div2');

    function resetPassword(){
        console.log(email.value);
        
        div1.style.display = 'none';
        div2.style.display = 'block';

        return false;
    }

    function verifyOTP(){

        verifyAndUpdatePassword();
        return false;
    }

    async function verifyAndUpdatePassword(){

        const data = {
            otp: otp.value,
            email: email.value,
            password: new_password.value,
            operation: 'reset-password'
        };

        const result = await postRequest(data, 'ajax/ajax_users.php');
        console.log(result);
        const response = JSON.parse(result);

        alert(response.status + ": "+ response.msg );

        if(response.status == 'success'){
            window.location.href = 'index.php';
        }

        return false;
    }
</script>

</body>
</html>
