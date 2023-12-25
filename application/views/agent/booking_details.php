<div class="container dashboard-wrapper">
    <div class="card content-area">
        <div class="card-innr">
        <div class="card-head d-flex justify-content-between align-items-center">
               <h4 class="card-title mb-0">Booking Details - <?php echo $booking_details->booking_number;?></h4>
               <a href="<?php echo base_url();?>agent/booking" class="btn btn-sm btn-auto btn-primary d-sm-block d-none"><em class="mdi mdi-arrow-left mr-3"></em>Back</a>
               <a href="<?php echo base_url();?>agent/booking" class="btn btn-icon btn-sm btn-primary d-sm-none"><em class="mdi mdi-arrow-left"></em></a>
        </div>
           <?php $this->load->view('agent/alert'); ?>
           <div class="row">
               <div class="col-md-12  bg-white">
                    <ul class="nav nav-tabs ui-vehicle-summary-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="booking-tab" data-toggle="tab" href="#booking" role="tab" aria-controls="One" aria-selected="true">Booking</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="client-tab" data-toggle="tab" href="#client" role="tab" aria-controls="Two" aria-selected="false">Client</a>
                        </li>
                        <?php if (!empty($extras) && count($extras) > 0):?>
                        <li class="nav-item">
                            <a class="nav-link" id="extra-tab" data-toggle="tab" href="#extra" role="tab" aria-controls="Three" aria-selected="false">Extra</a>
                        </li>
                        <?php endif;?>
                    </ul>

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active p-3" id="booking" role="tabpanel" aria-labelledby="booking-tab">
                            <ul class="data-details-list">
                                <li>
                                    <div class="data-details-head">Booked Date Rage</div>
                                    <div class="data-details-des">
                                        <strong>
                                        <?php echo date($this->config_manager->config['date_format'] . ' ' . $this->config_manager->config['time_format'], $booking_details->start_time); ?> 
                                        <?php echo  $pickup_location->name;?> >
                                        <?php echo date($this->config_manager->config['date_format'] . ' ' . $this->config_manager->config['time_format'], $booking_details->end_time); ?>
                                        <?php echo  $drop_location->name;?>
                                        </strong>
                                    </div>
                                </li>
                                <li>
                                    <div class="data-details-head">Vehicle</div>
                                    <div class="data-details-des">
                                        <span>
                                            <?php echo $vehicle_details->make . " " . $vehicle_details->model . " " . $vehicle_details->year;?>
                                        </span>
                                    </div>
                                </li>
                                <li>
                                    <div class="data-details-head">Pickup Location</div>
                                    <div class="data-details-des"><span><?php echo  $pickup_location->name;?></span></div>
                                </li>
                                <li>
                                    <div class="data-details-head">Drop Off Location</div>
                                    <div class="data-details-des"><span><?php echo  $drop_location->name;?></span></div>
                                </li>
                                <li>
                                    <div class="data-details-head">Payment Method</div>
                                    <div class="data-details-des"><span><?php echo ucfirst($booking_details->payment_method);?></span> <span></span></div>
                                </li>
                                <li>
                                    <div class="data-details-head">Deposit(<?php echo $this->config_manager->config['currency_symbol'];?>) </div>
                                    <div class="data-details-des"><?php echo  number_format($booking_details->deposit, 2);?></div>
                                </li>
                                <li>
                                    <div class="data-details-head">Tax(<?php echo $this->config_manager->config['currency_symbol'];?>) </div>
                                    <div class="data-details-des"><?php echo  number_format($booking_details->tax, 2);?></div>
                                </li>
                                <li>
                                    <div class="data-details-head">Total(<?php echo $this->config_manager->config['currency_symbol'];?>) </div>
                                    <div class="data-details-des"><?php echo  number_format($booking_details->total, 2);?></div>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-pane fade p-3" id="client" role="tabpanel" aria-labelledby="client-tab">
                           <ul class="data-details-list">
                                <li>
                                    <div class="data-details-head">Full name</div>
                                    <div class="data-details-des">
                                        <span>
                                        <?php echo  $booking_details->first_name . " " . $booking_details->second_name ;?>
                                        </span>
                                    </div>
                                </li>
                                <li>
                                    <div class="data-details-head">Gender</div>
                                    <div class="data-details-des"><span><?php echo  ucfirst($booking_details->male);?></span></div>
                                </li>
                                <li>
                                    <div class="data-details-head">Age</div>
                                    <div class="data-details-des"><span><?php echo  $booking_details->age;?></span></div>
                                </li>
                                <li>
                                    <div class="data-details-head">Phone</div>
                                    <div class="data-details-des">
                                        <span>
                                            <?php echo $booking_details->phone;?>
                                        </span>
                                    </div>
                                </li>
                                <li>
                                    <div class="data-details-head">Email</div>
                                    <div class="data-details-des"><span><?php echo  $booking_details->email;?></span></div>
                                </li>
                                <li>
                                    <div class="data-details-head">City</div>
                                    <div class="data-details-des"><span><?php echo  $booking_details->city;?></span></div>
                                </li>
                                <li>
                                    <div class="data-details-head">Postcode </div>
                                    <div class="data-details-des"><span><?php echo $booking_details->postcode;?></span> <span></span></div>
                                </li>
                                <li>
                                    <div class="data-details-head">Address</div>
                                    <div class="data-details-des"><?php echo  $booking_details->address;?></div>
                                </li>
                                <li>
                                    <div class="data-details-head">Company </div>
                                    <div class="data-details-des"><?php echo ($booking_details->company) ? $booking_details->company : "-";?></div>
                                </li>
                                <li>
                                    <div class="data-details-head">Additional Request</div>
                                    <div class="data-details-des"><?php echo ($booking_details->additional)? $booking_details->additional: "-" ;?></div>
                                </li>
                            </ul>
                        </div>
                        <?php if (!empty($extras) && count($extras) > 0):?>
                        <div class="tab-pane fade p-3" id="extra" role="tabpanel" aria-labelledby="extra-tab">
                         <div class="row">
                            <?php foreach ($extras as $extra) :?>
                            <div class="col-md-6">
                                <div class="ui-extra-wrapper mb-3 <?php echo !empty($booking_extra) && array_key_exists($extra->extra_id, $booking_extra) ? 'acitve' : '';?>">
                                    <div class="media">
                                        <div class="media-body">
                                            <h4><?php echo $extra->title;?></h4>
                                            <p><?php echo $extra->description;?></p>
                                        </div>
                                        <div class="d-inline text-center" id="option-add">
                                        <h3><?php echo $this->config_manager->config['currency_symbol'];?> <?php echo $extra->price;?></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach;?>
                           </div>
                        </div>
                        <?php endif;?>
                    </div>
                </div>
           </div>
        </div>
    </div>
</div>

