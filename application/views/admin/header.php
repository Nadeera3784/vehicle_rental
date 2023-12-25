<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Dashboard">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Ethon</title>
    <link rel="stylesheet" href="<?php echo base_url();?>backend/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url();?>backend/css/materialdesignicons.css">
    <link rel="stylesheet" href="<?php echo base_url();?>backend/css/jquery.scrollbar.css">
    <?php
	if(isset($css)){
		$arrlength = count($css);
		for($x = 0; $x < $arrlength; $x++) {
			echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"".base_url().$css[$x]."\">\n";
		}
	}
	?>
    <link rel="stylesheet" href="<?php echo base_url();?>backend/css/app.css">
</head>

<body>
    <nav class="navbar navbar-expand-md navbar-light bg-light fixed-top top-nav">
        <div class="logo">
            <div class="toggle-side-nav navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
            </div>
           <!-- <img src="assets/images/logo.png" alt="">-->
			<svg xmlns="http://www.w3.org/2000/svg" width="46" height="38" viewBox="0 0 46 38">
				<g fill="#1d40bb" fill-rule="evenodd">
					<path d="M17.343 15L31.485.858 45.627 15 31.485 29.142z" opacity=".7"></path>
					<path d="M.373 15L14.515.858l22.627 22.627L23 37.627z"></path>
				</g>
			</svg>
			<h5>Rental <span class="badge badge-default">V1.0.1</span></h5>
        </div>
        <div class="account">
            <div class="notifications">
                <div class="notifications-tray">
                    <a href="home.html#" class="show-notifs"><i class="mdi mdi-bell"></i><small>2</small></a>
                    <div class="notifications-box">
                        <div class="notifs-top">
                            <i class="mdi mdi-bell"></i>
                            <strong>Notifications</strong>
                            <i class="mdi mdi-settings-outline"></i>
                        </div>
                        <ul class="list-unstyled notifs-list">
                            <li>
                                <a href="home.html#" class="active">
                                    <div class="notif-img"><img src="<?php echo base_url();?>backend/images/avatar.jpg" alt=""></div>
                                    <div class="notif-info">
                                        <strong>Millie Kim <small>commented on your photo</small></strong>
                                    </div>
                                    <span class="user-status"><i class="mdi mdi-close-circle-outline text-success"></i></span>
                                </a>
                            </li>
                            <li>
                                <a href="home.html#">
                                    <div class="notif-img"><img src="<?php echo base_url();?>backend/images/avatar.jpg" alt=""></div>
                                    <div class="notif-info">
                                        <strong>Millie Kim <small>commented on your photo</small></strong>
                                    </div>
                                    <span class="user-status"><i class="mdi mdi-close-circle-outline text-success"></i></span>
                                </a>
                            </li>
                            <li>
                                <a href="home.html#">
                                    <div class="notif-img"><img src="<?php echo base_url();?>backend/images/avatar.jpg" alt=""></div>
                                    <div class="notif-info">
                                        <strong>Millie Kim <small>commented on your photo</small></strong>
                                    </div>
                                    <span class="user-status"><i class="mdi mdi-close-circle-outline text-success"></i></span>
                                </a>
                            </li>
                        </ul>
                        <div class="notifs-bt"><a href="home.html#"><strong class="text-success">See all notifictions</strong></a></div>
                    </div>
                </div>
 
            </div>
            <div class="drop-link">
                <img src="<?php echo base_url();?>backend/images/avatar.jpg" class="dropdown-trigger" alt="">
                <i class="mdi mdi-chevron-down"></i>
                <div class="drop-menu custom-dropdown user-menu">
                    <div class="row box justify-content-between my-4">
                        <div class="col">
                            <a href="panel-page-dashboard6.html#">
                                <i class="mdi mdi-apps mdi-light app-icon  r-5"></i>
                                <div class="pt-1">Apps</div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="panel-page-dashboard6.html#">
                                <i class="mdi mdi-account mdi-light lighten-1 app-icon  r-5"></i>
                                <div class="pt-1">Profile</div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="panel-page-dashboard6.html#">
                                <i class="mdi mdi-settings mdi-light lighten-2 app-icon  r-5"></i>
                                <div class="pt-1">Settings</div>
                            </a>
                        </div>
                    </div>
                    <div class="row box justify-content-between my-4">
                        <div class="col">
                            <a href="panel-page-dashboard6.html#">
                                <i class="mdi mdi-star mdi-light app-icon  r-5"></i>
                                <div class="pt-1">Favourites</div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="panel-page-dashboard6.html#">
                                <i class="mdi mdi-floppy mdi-light app-icon  r-5"></i>
                                <div class="pt-1">Saved</div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="<?php echo base_url();?>auth/logout">
                                <i class="mdi mdi-power mdi-light app-icon  r-5"></i>
                                <div class="pt-1">Logout</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </nav>

    <div class="side-nav">
        <div class="scrollbar-macosx">
            <div class="sidebar">
                <ul class="nav">
                    <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url();?>admin/index">
                        <i class="mdi mdi-home menu-icon"></i>
                        <span class="menu-title">Dashboard</span>
                    </a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link collapse" data-toggle="collapse" href="#finance" aria-expanded="false" aria-controls="finance">
                        <i class="mdi mdi-wallet menu-icon"></i>
                        <span class="menu-title">Finance</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="finance">
                        <ul class="nav flex-column sub-menu">
                        <li class="nav-item d-none d-lg-block"> <a class="nav-link" href="<?php echo base_url();?>admin/discount">Discount</a></li>
                        <li class="nav-item"> <a class="nav-link" href="<?php echo base_url();?>admin/extra">Extra</a></li>
                        <li class="nav-item d-none d-lg-block"> <a class="nav-link" href="<?php echo base_url();?>admin/price_plan">Price Plan</a></li>
                        </ul>
                    </div>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#vehicles" aria-expanded="false" aria-controls="vehicles">
                        <i class="mdi  mdi-car menu-icon"></i>
                        <span class="menu-title">Vehicles</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="vehicles">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="<?php echo base_url();?>admin/vehicles">List</a></li>
                            <li class="nav-item"> <a class="nav-link" href="<?php echo base_url();?>admin/vehicle_types">Types</a></li>
                            <li class="nav-item"> <a class="nav-link" href="<?php echo base_url();?>admin/locations">Locations</a></li>
                            <li class="nav-item"> <a class="nav-link" href="<?php echo base_url();?>admin/blocking">Blocking</a></li>
                        </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url();?>admin/users">
                            <i class="mdi mdi-account-circle menu-icon"></i>
                            <span class="menu-title">Users</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url();?>admin/booking">
                            <i class="mdi mdi-calendar-check menu-icon"></i>
                            <span class="menu-title">Booking</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url();?>admin/memberships">
                            <i class="mdi mdi-cube-outline menu-icon"></i>
                            <span class="menu-title">Membership</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url();?>admin/settings">
                            <i class="mdi mdi-settings menu-icon"></i>
                            <span class="menu-title">Settings</span>
                        </a>
                    </li>

                </ul>
        </div>
        </div>
    </div>