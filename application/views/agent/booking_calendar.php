<div class="container dashboard-wrapper">
    <div class="card content-area">
        <div class="card-innr">
        <div class="card-head d-flex justify-content-between align-items-center">
               <h4 class="card-title mb-0">Booking Calendar</h4>
               <a href="<?php echo base_url();?>agent/booking" class="btn btn-sm btn-auto btn-primary d-sm-block d-none"><em class="mdi mdi-arrow-left mr-3"></em>Back</a>
               <a href="<?php echo base_url();?>agent/booking" class="btn btn-icon btn-sm btn-primary d-sm-none"><em class="mdi mdi-arrow-left"></em></a>
        </div>
           <?php $this->load->view('agent/alert'); ?>
             <div class="row">
                 <div class="col-md-12">
                <div class="calendar-nav">
                 <?php
                    $requYear = substr($requYMD,0,4);
                    $requMonth = substr($requYMD,5,2);
                    $monthr = $requMonth<7 ? 1 : 7;
                    $timestamp = $requYear.'-'.$monthr;
                    
                    $monthOut = array();
                    $c = 0;
                    $monthOut[$c][0] = date('Y-m', strtotime($timestamp));
                    $monthOut[$c++][1] = strftime('%b %Y', strtotime($timestamp));
                    $monthOut[$c][0] = date('Y-m', strtotime($timestamp.' +1 month')); // next month
                    $monthOut[$c++][1] = strftime('%b %Y', strtotime($timestamp.' +1 month'));
                    $monthOut[$c][0] = date('Y-m', strtotime($timestamp.' +2 month'));
                    $monthOut[$c++][1] = strftime('%b %Y', strtotime($timestamp.' +2 month'));
                    $monthOut[$c][0] = date('Y-m', strtotime($timestamp.' +3 month'));
                    $monthOut[$c++][1] = strftime('%b %Y', strtotime($timestamp.' +3 month'));
                    $monthOut[$c][0] = date('Y-m', strtotime($timestamp.' +4 month'));
                    $monthOut[$c++][1] = strftime('%b %Y', strtotime($timestamp.' +4 month'));
                    $monthOut[$c][0] = date('Y-m', strtotime($timestamp.' +5 month'));
                    $monthOut[$c++][1] = strftime('%b %Y', strtotime($timestamp.' +5 month'));
                    $c_out = 0;
                ?>
                    <a class="navpre" title="previous month" href="?m=<?php echo date('Y-m', strtotime($requYMD.' -1 month')); ?>"><i class="mdi mdi-arrow-left"></i> Previous</a> 
                    <a class="<?php echo (substr($requYMD,0,7)==$monthOut[$c_out][0])? 'active' : '' ?>" href="?m=<?php echo $monthOut[$c_out][0]; ?>"><?php echo $monthOut[$c_out++][1]; ?></a> 
                    <a class="<?php echo (substr($requYMD,0,7)==$monthOut[$c_out][0])? 'active' : '' ?>"  href="?m=<?php echo $monthOut[$c_out][0]; ?>"><?php echo $monthOut[$c_out++][1]; ?></a> 
                    <a class="<?php echo (substr($requYMD,0,7)==$monthOut[$c_out][0])? 'active' : '' ?>" href="?m=<?php echo $monthOut[$c_out][0]; ?>"><?php echo $monthOut[$c_out++][1]; ?></a> 
                    <a class="<?php echo (substr($requYMD,0,7)==$monthOut[$c_out][0])? 'active' : '' ?>" href="?m=<?php echo $monthOut[$c_out][0]; ?>"><?php echo $monthOut[$c_out++][1]; ?></a> 
                    <a class="<?php echo (substr($requYMD,0,7)==$monthOut[$c_out][0])? 'active' : '' ?>" href="?m=<?php echo $monthOut[$c_out][0]; ?>"><?php echo $monthOut[$c_out++][1]; ?></a> 
                    <a class="<?php echo (substr($requYMD,0,7)==$monthOut[$c_out][0])? 'active' : '' ?>" href="?m=<?php echo $monthOut[$c_out][0]; ?>"><?php echo $monthOut[$c_out++][1]; ?></a> 
                    <a class="pull-right" title="next month" href="?m=<?php echo date('Y-m', strtotime($requYMD.' +1 month')); ?>"> Next <i class="mdi mdi-arrow-right"></i></a> 
                  </div>
                     <div class="booking-calendar">
                       <?php echo $calendar;?>
                     </div>
                 </div>
             </div>
        </div>
    </div>
</div>

