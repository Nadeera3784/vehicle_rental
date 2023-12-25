<div class="container dashboard-wrapper">
    <div class="card content-area">
        <div class="card-innr">
        <div class="card-head d-flex justify-content-between align-items-center">
               <h4 class="card-title mb-0">Subscription</h4>
               <a href="<?php echo base_url();?>agent/listing" class="btn btn-sm btn-auto btn-primary d-sm-block d-none"><em class="mdi mdi-arrow-left mr-3"></em>Back</a>
               <a href="<?php echo base_url();?>agent/listing" class="btn btn-icon btn-sm btn-primary d-sm-none"><em class="mdi mdi-arrow-left"></em></a>
        </div>
           <?php $this->load->view('agent/alert'); ?>
           <section class="pricing py-5">
            <div class="container">
                <div class="row">
                    <?php foreach($memberships as $membership):?>
                        <div class="col-lg-4">
                            <div class="card mb-5 mb-lg-0 <?php echo ($membership->membership_id == $user_membership_id)? "active" : "" ;?>">
                                <div class="card-body">
                                    <h5 class="card-title text-muted text-uppercase text-center"><?php echo $membership->title;?></h5>
                                    <h6 class="card-price text-center"><?php echo $this->config_manager->config['currency_symbol'];?><?php echo $membership->price;?><span class="period">/month</span></h6>
                                    <hr>
                                    <ul class="fa-ul">
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span><?php echo $membership->limitation;?> Vehicle for month</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>live for  <?php echo $membership->duration ;?> days</li>
                                    </ul>
                                    <a href="#" class="btn btn-block btn-primary text-uppercase  <?php echo ($membership->membership_id == $user_membership_id)? "disabled" : "" ;?>"><?php echo ($membership->membership_id == $user_membership_id)? "Acivated" : "Upgrade" ;?></a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;?>
                    </div>
                 </div>
            </section>


        </div>
    </div>
</div>

