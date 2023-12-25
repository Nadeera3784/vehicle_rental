<div class="app-content">
    <div class="container-fluid pt-3">
		<div class="row">
			<div class="col-6 col-sm-3 col-xxl-2">
				<a class="element-box widget-box" href="javascript::void">
					<div class="label">Users</div>
					<div class="value"><?php echo count($users);?></div>
					<div class="trending trending-down-basic"><span>9%</span><i class="mdi mdi-arrow-down"></i></div>
				</a>
			</div>
			<div class="col-6 col-sm-3 col-xxl-2">
				<a class="element-box widget-box" href="javascript::void">
					<div class="label">Booking</div>
					<div class="value"><?php echo $totalbookings;?></div>
					<div class="trending trending-up-basic"><span>88%</span><i class="mdi mdi-arrow-up"></i></div>
				</a>
			</div>
			<div class="col-6 col-sm-3 col-xxl-2">
				<a class="element-box widget-box" href="javascript::void">
					<div class="label">Vehicles</div>
					<div class="value"><?php echo $totalvehicles;?></div>
					<div class="trending trending-up-basic"><span>73%</span><i class="mdi mdi-arrow-up"></i></div>
				</a>
			</div>
			<div class="col-6 col-sm-3 col-xxl-2">
				<a class="element-box widget-box" href="javascript::void">
					<div class="label">Revenue</div>
					<div class="value"><?php echo $this->config_manager->config['currency_symbol'];?><?php echo $totalrevenue->total;?></div>
				</a>
			</div>

			<div class="col-md-12 animate-element">
                <div class="card">
                    <div class="header">
                        <h2>Revenue</h2>
                    </div>
                    <div class="body">
					   <div id="revenue_chart"></div>
                    </div>
                </div>
           </div>
		</div>
    </div>
</div>