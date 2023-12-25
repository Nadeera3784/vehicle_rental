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

<body class="sidebar-collapse">
    <nav class="navbar navbar-expand-lg <?php echo $navigation_class;?> fixed-top">
        <div class="container">
            <div class="navbar-translate">
                <a class="navbar-brand" href="<?php echo base_url();?>">
                   <img src="<?php echo base_url();?>frontend/images/logo5.png" width="60" alt="logo.png">
                </a>

                <?php if($this->ion_auth->logged_in()):?>
                <a class="nav-link btn btn-primary d-sm-block d-xs-block d-md-none d-lg-none d-xl-none"  href="<?php echo base_url();?>agent/index">
                        <i class="mdi mdi-vector-combine"></i>
                        <p>Dashboard</p>
                </a>
                <?php endif;?>
                <button class="navbar-toggler navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-bar bar1"></span>
                    <span class="navbar-toggler-bar bar2"></span>
                    <span class="navbar-toggler-bar bar3"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse justify-content-end">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url();?>">
                            <p>Home</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" target="_blank">
                            <p>About</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" target="_blank">
                            <p>Contact</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url();?>terms">
                            <p>Terms</p>
                        </a>
                    </li>
                </ul>

                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#" target="_blank">
                            <p>Tracking</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn-add-vehicle" href="<?php echo base_url();?>app/add_vehicle">
                            <p>Add Your Vehicle</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>