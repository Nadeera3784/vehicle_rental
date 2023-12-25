<div class="app-content">
    <div class="container-fluid pt-3">
       <div class="row">
           <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h2>Booking Details - <?php echo $booking_details->booking_number;?></h2>
                        <div class="header-toolbox">
                            <a href="<?php echo base_url();?>admin/booking" class="btn btn-sm btn-primary text-white"><i class="mdi mdi-arrow-left mdi-light"></i> Back</a>
                        </div>
                    </div>
                    <div class="body">
                       <?php $this->load->view('admin/alert'); ?>

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

                                <a class="element-box widget-box <?php echo !empty($booking_extra) && array_key_exists($extra->extra_id, $booking_extra) ? 'acitve' : '';?>" href="#">
									<div class="label"><?php echo $extra->title;?></div>
									<div class="value"><?php echo $this->config_manager->config['currency_symbol'];?><?php echo $extra->price;?></div>
								</a>

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
</div>