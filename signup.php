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
</head>
<body>

  
<div class="container">
  
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            
            <form method='post'>
                <div class="container" style='margin-top:10%;'>
                    <h3> sign-up </h3>
                    <div class="row">
                        <div class="col-md-12">
                            <div class='form-group'>
                                <input class='form-control' id='name' name='name' placeholder='Name' />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class='form-group'>
                                <input class='form-control' id='email' name='email' placeholder='Email' />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class='form-group'>
                                <input class='form-control' id='password' name='password' placeholder='Password' />
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <a class='btn btn-primary' href='signup.php'> Sign-up </a>
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

</body>
</html>
