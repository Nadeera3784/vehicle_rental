<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Test App</title>
    <link href="<?php echo base_url();?>frontend/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url();?>frontend/css/materialdesignicons.css" rel="stylesheet">
    <?php
	if(isset($css)){
		$arrlength = count($css);
		for($x = 0; $x < $arrlength; $x++) {
			echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"".base_url().$css[$x]."\">\n";
		}
	}
	?>
    <link href="<?php echo base_url();?>frontend/css/app.css" rel="stylesheet">
</head>
<body class="application application-offset ready">
<div class="container-fluid container-application">
    <div class="main-content position-relative">
      <div class="page-content">
        <div class="min-vh-100 py-5 d-flex align-items-center">
          <div class="w-100">
            <div class="row justify-content-center">
              <div class="col-sm-8 col-lg-4">
                <div class="card shadow zindex-100 mb-0">
                  <div class="card-body px-md-5 py-5">
                    <div class="mb-5">
                      <h6 class="h3">Login</h6>
                      <p class="text-muted mb-0">Sign in to your account to continue.</p>
                    </div>
                    <span class="clearfix"></span>
                    <?php
                        if(isset($message)){
                          echo $message;
                        }
                     ?>
                    <?php $attribute = array('role' => "form");?>
                    <?php echo form_open("auth/login", $attribute);?>
                      <div class="form-group">
                        <label class="form-control-label">Email address</label>
                        <div class="input-group">
                          <input type="email" class="form-control" name="identity" id="identity" placeholder="name@example.com">
                        </div>
                      </div>
                      <div class="form-group mb-4">
                        <div class="d-flex align-items-center justify-content-between">
                          <div>
                            <label class="form-control-label">Password</label>
                          </div>
                          <div class="mb-2">
                            <a href="login.html#!" class="small text-muted text-underline--dashed border-primary">Lost password?</a>
                          </div>
                        </div>
                        <div class="input-group">
                          <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                          <input name="remember" value="1" id="remember" type="hidden">
                        </div>
                      </div>
                      <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Sign in<i class="mdi mdi-arrow-right"></i></button>
                      </div>
                    <?php echo form_close();?>
                  </div>
                  <div class="card-footer px-md-5"><small>Not registered?</small>
                    <a href="<?php echo base_url();?>register" class="small font-weight-bold">Create account</a></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>
</body>
</html>