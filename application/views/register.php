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
                      <h6 class="h3">Create account</h6>
                      <p class="text-muted mb-0">Sign in to your account to continue.</p>
                    </div>
                    <span class="clearfix"></span>
                    <?php
                        if(isset($message)){
                          echo $message;
                        }
                     ?>
                    <?php $attribute = array('role' => "form");?>
                    <?php echo form_open("app/register", $attribute);?>

                      <div class="form-group">
                        <label class="form-control-label">First name</label>
                          <input type="text" class="form-control" name="first_name" id="first_name" value="<?php echo set_value('first_name');?>">
                          <?php echo form_error('first_name'); ?>
                      </div>
                      <div class="form-group">
                        <label class="form-control-label">Last name</label>
                          <input type="text" class="form-control" name="last_name" id="last_name" value="<?php echo set_value('last_name');?>">
                          <?php echo form_error('last_name'); ?>
                      </div>

                      <div class="form-group">
                        <label class="form-control-label">Email address</label>
                          <input type="email" class="form-control" name="email" id="email" value="<?php echo set_value('email');?>">
                          <?php echo form_error('email'); ?>
                      </div>
                      <div class="form-group mb-4">
                        <label class="form-control-label">Password</label>
                          <input type="password" class="form-control" name="password" id="password">
                          <?php echo form_error('password'); ?>
                      </div>
                      <div class="form-group mb-4">
                        <label class="form-control-label">Confirm Password</label>
                          <input type="password" class="form-control" name="password_confirm" id="password_confirm">
                          <?php echo form_error('password_confirm'); ?>
                      </div>
                      <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Create my account<i class="mdi mdi-arrow-right"></i></button>
                      </div>
                    <?php echo form_close();?>
                  </div>
                  <div class="card-footer px-md-5"><small>Already have an acocunt?</small>
                    <a href="<?php echo base_url();?>auth/login" class="small font-weight-bold"> Sign in</a></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>
</body>
</html>