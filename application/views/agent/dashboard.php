<div class="container dashboard-wrapper animate-element">
    <div class="row">
      <div class="col-md-3">
        <div class="card widget">
            <div class="card-body">
              <div class="row align-items-center">
                  <div class="col">
                    <h6 class="text-uppercase mb-2 label">Vehicles</h6>
                    <span class="value mb-0"><?php echo ($numberofvehicles->count)? $numberofvehicles->count : "0";?></span>
                  </div>
                  <div class="col-auto">
                      <div class="widget-icon">
                        <i class="mdi mdi-car mdi-24px"></i>
                      </div>
                  </div>
              </div> 
            </div>
          </div>
      </div>
      <div class="col-md-3">
        <div class="card widget">
            <div class="card-body">
              <div class="row align-items-center">
                  <div class="col">
                    <h6 class="text-uppercase mb-2 label">Bookings</h6>
                    <span class="value mb-0"><?php echo ($numberofbooking->total)? $numberofbooking->total : "0";?></span>
                  </div>
                  <div class="col-auto">
                      <div class="widget-icon">
                        <i class="mdi mdi-calendar mdi-24px"></i>
                      </div>
                  </div>
              </div> 
            </div>
          </div>
      </div>
      <div class="col-md-3">
        <div class="card widget">
            <div class="card-body">
              <div class="row align-items-center">
                  <div class="col">
                    <h6 class="text-uppercase mb-2 label">Earnings</h6>
                    <span class="value mb-0"><?php echo $this->config_manager->config['currency_symbol'];?><?php echo ($current_month_earning->earning)? $current_month_earning->earning : "0";?></span>
                  </div>
              </div> 
            </div>
          </div>
      </div>
      <div class="col-md-3">
        <div class="card widget">
            <div class="card-body">
              <div class="row align-items-center">
                  <div class="col">
                    <h6 class="text-uppercase mb-2 label">Revenue</h6>
                    <span class="value mb-0"><?php echo $this->config_manager->config['currency_symbol'];?><?php echo ($current_year_earning->earningy)? $current_year_earning->earningy : "0";?></span>
                  </div>
              </div> 
            </div>
          </div>
      </div>
    </div>
    <div class="card content-area">
        <div class="card-innr">
        <div class="card-head d-flex justify-content-between align-items-center">
               <h4 class="card-title mb-0">Earnings Chart</h4>
        </div>    
           <div class="row">
               <div class="col-md-12  bg-white">
                    <ul class="nav nav-tabs ui-vehicle-summary-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="earningsW-tab" data-toggle="tab" href="#earningsW" role="tab" aria-controls="One" aria-selected="true">Weekly</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="earningsM-tab" data-toggle="tab" href="#earningsM" role="tab" aria-controls="Two" aria-selected="false">Monthly</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="earningsY-tab" data-toggle="tab" href="#earningsY" role="tab" aria-controls="Three" aria-selected="false">Yearly</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active p-3" id="earningsW" role="tabpanel" aria-labelledby="earningsW-tab">
                           <div id="earnings_weekchart"></div>
                        </div>
                        <div class="tab-pane fade p-3" id="earningsM" role="tabpanel" aria-labelledby="earningsM-tab">
                          <div id="earnings_monthchart"></div>
                        </div>
                        <div class="tab-pane fade p-3" id="earningsY" role="tabpanel" aria-labelledby="earningsY-tab">
                          <div id="earnings_yearchart"></div>
                        </div>
                    </div>
                </div>
           </div>              
        </div>
    </div>
</div>

