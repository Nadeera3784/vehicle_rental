<div class="container ui-vehicle-list-wrapper">
    <div class="row">
        <div class="col-md-3 mb-5">
           <div class="vehicle-filter accordion vehicle_filter_onliy_side">
                    <div class="panel panel-default">
                        <div class="panel-body">
                           <div class="slider1">
                               <?php $split_images = explode(',',$vehicle->images);?>
                               <?php foreach($split_images as $key => $img):?>
                                <figure>
                                   <img src="<?php echo base_url() . $this->config->item('app_frontend_asset_root')."/images/vehicles/".space_remover($img);?>" class="img-responsive" alt="38647.png" width="347px" height="104px">
                                </figure>
                               <?php endforeach;?>
                           </div>
                        </div>
                        <div class="title">
                            <h4><?php echo $vehicle->make . " " . $vehicle->model;?></h4>
                            <div class="subtitle heading-font"></div>
                        </div>
                    </div>
                    <hr>
                    <div class="panel panel-default  d-none d-md-block d-lg-block">
                        <div class="panel-heading">
                            <h5 class="panel-title">Rental Location</h5>
                        </div>
                        <div class="panel-body">
                            <div class="ui_vehicle_filter_date">
                                <ul>
                                    <li><?php echo $cached_data['pickup_date'];?> <?php echo $cached_data['pickup_time'];?></li>
                                    <li><?php echo $pickup_location->name . " " . ", Sri Lanka";?></li>
                                </ul>
                            </div>
                            <div class="ui_vehicle_filter_date">
                                <ul>
                                    <li><?php echo $cached_data['drop_date'];?> <?php echo $cached_data['drop_time'];?></li>
                                    <li><?php echo $drop_location->name . " " . ", Sri Lanka";?></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <hr class="d-none d-md-block d-lg-block">

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h5 class="panel-title">Price Details</h5>
                        </div>
                        <div class="panel-body">
                            <div class="ui_vehicle_filter_date">
                              <ul class="price-detauls">
                                 <li>Price<span id="price"><?php echo $calculation['formated_car_price'];?></span></li>
                                 <li>Tax<span id="tax"><?php echo $calculation['formated_tax'];?></span></li>
                                 <li>Discount<span id="discount"><?php echo $calculation['formated_discount'];?></span></li>
                                 <li>Extra Features<span id="extra"><?php echo $calculation['formated_extra_price'];?></span></li>
                                 <li>Total<span id="total"><?php echo $calculation['formated_total'];?></span></li>
                              </ul>
                            </div>
                        </div>
                    </div>
                    <hr>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h5 class="panel-title">Extra Features</h5>
                        </div>
                        <div class="panel-body">
                            <div class="ui_vehicle_filter_date">
                                <ul class="extra-feautures">
                                </ul>
                            </div>
                        </div>
                    </div>
                    <hr>


                    <div class="ui-rent-total heading-font d-none d-md-block d-lg-block">
                        <div class="total-title">Estimated total</div>
                        <div class="total-price">
                            <div class="stm-mcr-price-view">
                                 <span class="currency"><?php echo $this->config_manager->config['currency_symbol'];?></span>
                                 <span class="price-big"><?php echo $calculation['total'];?></span>
                            </div>
                        </div>
                    </div>
    
            </div>
        </div>
        <div class="col-md-9 mb-5">
            <div class="row">
                <div class="col-md-12 bg-white d-none d-md-block d-lg-block">
                    <div class="ui-selected-booking">
                     <div class="row">
                        <div class="col-md-3 col-sm-2">
                            <div class="ui-block">
                                <span class="ui-selected-booking-title"><?php echo $pickup_location->name;?></span>
                                <span class="ui-selected-booking-value bonus-on-sale"><?php echo $cached_data['pickup_date'];?> <?php echo $cached_data['pickup_time'];?></span>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-2">
                            <div class="ui-block">
                                <span class="ui-selected-booking-title"><?php echo $drop_location->name;?></span>
                                <span class="ui-selected-booking-value"><?php echo $cached_data['drop_date'];?> <?php echo $cached_data['drop_time'];?></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="ui-block">
                                <span class="ui-selected-booking-title font-bold">Rental Period</span>
                                <span class="ui-selected-booking-value"><?php echo $duration->d. " Days";?></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="ui-block">
                              <button type="button" class="btn btn-light btn-block btn-sm" data-toggle="collapse" data-target="#searchElement" aria-expanded="false" aria-controls="searchElement">Change Date</button>
                            </div>
                        </div>
                        <div class="col-md-12 collapse" id="searchElement">
                           <?php $attribute = array('id' => 'searchForm');?>
                            <?php echo form_open('search', $attribute);?>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                    <label for="pickup_location">Pickup Location</label>
                                    <select name="pickup_location" id="pickup_location" class="form-control nice-select required">
                                        <option value="0">--Select Location--</option>
                                        <?php foreach($locations as $location):?>
                                            <?php
                                                if($location->location_id == $cached_data['pickup_location']){
                                                    $selected = 'selected';
                                                }else{
                                                    $selected = "";
                                                }
                                            ?>
                                            <option <?php echo $selected; ?> value="<?php echo $location->location_id;?>"><?php echo $location->name;?></option>
                                        <?php endforeach;?>
                                    </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                    <label for="pickup_date">Date</label>
                                    <input type="text" class="form-control required" id="pickup_date" name="pickup_date" value="<?php echo $cached_data['pickup_date'];?>"  required>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                    <label for="pickup_time">Time</label>
                                    <input type="text" class="form-control required" id="pickup_time" name="pickup_time" value="<?php echo $cached_data['pickup_time'];?>" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                    <label for="drop_location">Drop Location</label>
                                    <select name="drop_location" id="drop_location" class="form-control nice-select">
                                        <option value="0">--Select Location--</option>
                                        <?php
                                        if (!empty($_POST['drop_location']) && $_POST['drop_location'] !=  " ") {
                                            $drop_locaton =  $cached_data['drop_location'];
                                        }else{
                                            $drop_locaton =  $cached_data['pickup_location'];
                                        }
                                        ?>
                                        <?php foreach($locations as $location):?>
                                            <?php
                                                if($location->location_id == $drop_locaton){
                                                    $selected = 'selected';
                                                }else{
                                                    $selected = "";
                                                }
                                            ?>
                                            <option <?php echo $selected; ?> value="<?php echo $location->location_id;?>"><?php echo $location->name;?></option>
                                        <?php endforeach;?>
                                    </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                    <label for="drop_date">Date</label>
                                    <input type="text" class="form-control required" id="drop_date" name="drop_date" data-defaultDate="<?php echo $cached_data['drop_date'];?>" value="<?php echo $cached_data['drop_date'];?>"  required>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                    <label for="drop_time">Time</label>
                                    <input type="text" class="form-control required" id="drop_time" name="drop_time" value="<?php echo $cached_data['drop_time'];?>"  required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="promo_code">Promo code</label>
                                        <input type="text" class="form-control" name="promo_code" id="promo_code">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="driving_age">Driving Age </label>
                                        <select name="driving_age" id="driving_age" class="form-control required">
                                            <?php for ($i = 18; $i < 30; $i++):?>
                                                <option  value="<?php echo $i ?>"><?php echo ($i < 10) ? '0' . $i : $i; ?></option>
                                            <?php endfor;?>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="submit"></label>
                                        <button name="submit" class="btn btn-block btn-primary mt-2 text-light" type="submit">Search Vehicle</button>
                                    </div>
                                    </div>
                            <?php echo form_close();?> 
                        </div>
                      </div>
                    </div>
                </div>
                <div class="col-md-12  bg-white">
                        <ul class="nav nav-tabs ui-vehicle-summary-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="descripiton-tab" data-toggle="tab" href="#descripiton" role="tab" aria-controls="One" aria-selected="true">Desciption</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="specifications-tab" data-toggle="tab" href="#specifications" role="tab" aria-controls="Two" aria-selected="false">Specifications</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="gallery-tab" data-toggle="tab" href="#gallery" role="tab" aria-controls="Three" aria-selected="false">Gallery</a>
                            </li>
                        </ul>
                    

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active p-3" id="descripiton" role="tabpanel" aria-labelledby="descripiton-tab">
                            <p><?php echo $vehicle->description;?></p>
                        </div>
                        <div class="tab-pane fade" id="specifications" role="tabpanel" aria-labelledby="specifications-tab">
                            <div class="ui-vehicle-specifications">
                                    <div class="car-spec-item">
                                        <div class="img">
                                            <img src="<?php echo base_url();?>frontend/images/icons/mcr-fuel-type.svg">
                                        </div>
                                        <div class="type">
                                            <span>Fuel Type</span>
                                        </div>
                                        <div class="value">
                                            <span><p><?php echo ucfirst($vehicle->fuel);?></p></span>
                                        </div>
                                    </div>
                                    <div class="car-spec-item">
                                        <div class="img">
                                            <img src="<?php echo base_url();?>frontend/images/icons/mcr-gear-type.svg">
                                        </div>
                                        <div class="type">
                                            <span>Gear type</span>
                                        </div>
                                        <div class="value">
                                            <span><p><?php echo ucfirst($vehicle->transmission);?></p></span>
                                        </div>
                                    </div>
                                    <div class="car-spec-item">
                                        <div class="img">
                                            <img src="<?php echo base_url();?>frontend/images/icons/mcr-persons.svg">
                                        </div>
                                        <div class="type">
                                            <span>Seats</span>
                                        </div>
                                        <div class="value">
                                            <span><p><?php echo $vehicle->passengers;?> Persons</p></span>
                                        </div>
                                    </div>
                                    <div class="car-spec-item">
                                        <div class="img">
                                            <img src="<?php echo base_url();?>frontend/images/icons/mcr-body-type.svg">
                                        </div>
                                        <div class="type">
                                            <span>Doors </span>
                                        </div>
                                        <div class="value">
                                            <span><p><?php echo $vehicle->doors ;?></p></span>
                                        </div>
                                    </div>
                                    <div class="car-spec-item">
                                        <div class="img">
                                            <img src="<?php echo base_url();?>frontend/images/icons/mcr-snowflake.svg">
                                        </div>
                                        <div class="type">
                                            <span>A/C</span>
                                        </div>
                                        <div class="value">
                                            <span><p><?php echo ($vehicle->air_conditioning == "T")? "Yes" : "No" ;?></p></span>
                                        </div>
                                    </div>
                                    <div class="car-spec-item">
                                        <div class="img">
                                            <img src="<?php echo base_url();?>frontend/images/icons/mcr-suitcase.svg">
                                        </div>
                                        <div class="type">
                                            <span>Suitcases</span>
                                        </div>
                                        <div class="value">
                                            <span><p><?php echo $vehicle->bags ;?></p></span>
                                        </div>
                                    </div>
                            </div>             
                        </div>
                        <div class="tab-pane fade p-3" id="gallery" role="tabpanel" aria-labelledby="gallery-tab">
                                <div class="vehicle-gallery">
                                        <?php $split_images = explode(',',$vehicle->images);?>
                                        <?php foreach($split_images as $key => $img):?>
                                        <figure>
                                            <img src="<?php echo base_url() . $this->config->item('app_frontend_asset_root')."/images/vehicles/".space_remover($img);?>" class="img-responsive" alt="<?php echo $img;?>">
                                        </figure>
                                        <?php endforeach;?>
                                </div>
                        </div>                            
                    </div>
                </div>
                <?php if($extra_options):?>
                <div class="col-md-12 billing-fields mb-3">
                    <h4>Extra Options</h4>
                    <?php echo form_open('', array('id' => "option_form"));?>
                    <div class="row" id="extra_options">
                       <input type="hidden" id="return_to_pickup_locationFS" name="return_to_pickup_location" value="">
                        <input type="hidden" id="pickup_dateFS" name="pickup_date" value="<?php echo $cached_data['pickup_date'];?>">
                        <input type="hidden" id="pickup_timeFS" name="pickup_time" value="<?php echo $cached_data['pickup_time'];?>">
                        <input type="hidden" id="drop_dateFS" name="drop_date" value="<?php echo $cached_data['drop_date'];?>">
                        <input type="hidden" id="drop_timeFS" name="drop_time" value="<?php echo $cached_data['drop_time'];?>">
                        <input type="hidden" id="promo_codeFS" name="promo_code" value="<?php echo $cached_data['promo_code'];?>">
                        <input type="hidden" id="pickup_locationFS" name="pickup_location" value="<?php echo $cached_data['pickup_location'];?>">
                        <input type="hidden" id="drop_locationFS" name="drop_location" value="<?php echo $cached_data['drop_location'];?>">
                        <input type="hidden" id="driving_ageFS" name="driving_age" value="<?php echo $cached_data['driving_age'];?>">
                        <input type="hidden" id="vehicle_idFS" name="vehicle_id" value="<?php echo $cached_data['vehicle_id'];?>">
                        <input type="hidden" id="vehicle_selected_priceFS" name="vehicle_selected_price" value="<?php echo $cached_data['vehicle_selected_price'];?>">
                        <?php foreach($extra_options as $key => $eo):?>
                        <div class="col-md-6">
                            <div class="ui-extra-wrapper mb-3" data-id="<?php echo $key;?>">
                                <div class="media">
                                    <div class="media-body">
                                        <h4><?php echo $eo->title;?></h4>
                                        <p><?php echo $eo->description;?></p>
                                    </div>
                                    <div class="d-inline text-center" id="option-add">
                                       <h3><?php echo $this->config_manager->config['currency_symbol'];?><?php echo $eo->price;?></h3>
                                       <input class="custom-checkbox" type="checkbox" value="<?php echo $eo->extra_id;?>" name="extra_id[<?php echo $eo->extra_id;?>]" id="<?php echo $key;?>" data-id="<?php echo $eo->extra_id;?>" data-title="<?php echo $eo->title;?>" data-price="<?php echo $eo->price;?>">
                                       <label  for="<?php echo $key;?>"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach;?>
                    </div>
                    </form>
                </div>
                <?php endif;?>
                <div class="col-md-12 billing-fields">
                    <h4>Billing details</h4>
                    <?php $attribute = array('id' => 'paymentForm');?>
                    <?php echo form_open('pay', $attribute);?>
                        <input type="hidden" id="return_to_pickup_locationFS" name="return_to_pickup_location" value="">
                        <input type="hidden" id="pickup_dateFS" name="pickup_date" value="<?php echo $cached_data['pickup_date'];?>">
                        <input type="hidden" id="pickup_timeFS" name="pickup_time" value="<?php echo $cached_data['pickup_time'];?>">
                        <input type="hidden" id="drop_dateFS" name="drop_date" value="<?php echo $cached_data['drop_date'];?>">
                        <input type="hidden" id="drop_timeFS" name="drop_time" value="<?php echo $cached_data['drop_time'];?>">
                        <input type="hidden" id="promo_codeFS" name="promo_code" value="<?php echo $cached_data['promo_code'];?>">
                        <input type="hidden" id="pickup_locationFS" name="pickup_location" value="<?php echo $cached_data['pickup_location'];?>">
                        <input type="hidden" id="drop_locationFS" name="drop_location" value="<?php echo $cached_data['drop_location'];?>">
                        <input type="hidden" id="driving_ageFS" name="driving_age" value="<?php echo $cached_data['driving_age'];?>">
                        <input type="hidden" id="vehicle_idFS" name="vehicle_id" value="<?php echo $cached_data['vehicle_id'];?>">
                        <input type="hidden" id="vehicle_selected_priceFS" name="vehicle_selected_price" value="<?php echo $cached_data['vehicle_selected_price'];?>">
                        <input type="hidden" class="totalamount" name="totalamount" value="<?php echo $calculation['total'];?>">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="first_name">First name</label>
                                <input type="text" class="form-control required" id="first_name" name="first_name" value="<?php echo set_value('first_name');?>">
                                <?php echo form_error('first_name'); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="last_name">Last name</label>
                                <input type="text" class="form-control required" id="last_name" name="last_name" value="<?php echo set_value('last_name');?>">
                                <?php echo form_error('last_name'); ?>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="gender">Gender</label>
                                     <select name="gender" id="gender" class="form-control nice-select required">
                                        <option value="">--Select Gender--</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                    <?php echo form_error('gender'); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="phone">Phone:</label>
                                <input type="text" class="form-control required" id="phone" name="phone" value="<?php echo set_value('phone');?>">
                                <?php echo form_error('phone'); ?>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="email">Email</label>
                                <input type="email" class="form-control required" id="email" name="email" value="<?php echo set_value('email');?>">
                                <?php echo form_error('email'); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="company_name">Company name(optional)</label>
                                <input type="text" class="form-control" id="company_name" name="company_name" value="<?php echo set_value('company_name');?>">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="city">City</label>
                                <input type="text" class="form-control required" id="city" name="city" value="<?php echo set_value('city');?>">
                                <?php echo form_error('city'); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="postcode">Postcode</label>
                                <input type="text" class="form-control required" id="postcode" name="postcode" value="<?php echo set_value('postcode');?>">
                                <?php echo form_error('postcode'); ?>
                            </div>
                        </div>
                        <div class="form-group pb-4">
                            <label for="address">Address</label>
                            <input type="text" class="form-control required" id="address" name="address" placeholder="1234 Main St" value="<?php echo set_value('address');?>">
                            <?php echo form_error('address'); ?>
                        </div>
                        <ul class="extra-options">
                        </ul>
                        <h3>Additional information</h3>
                        <div class="form-group pb-4">
                            <label for="order_notes">Order notes (optional)</label>
                            <textarea class="form-control" id="order_notes" name="order_notes" rows="3" cols="5" placeholder="Notes about your order, e.g. special notes for delivery."><?php echo set_value('order_notes');?></textarea>
                        </div>
                        <h3>Payment</h3>
                        <div class="row guttar-15px mt-4">
                            <div class="col-6">
                                <div class="pay-option">
                                  <input class="pay-option-check required" type="radio" id="paypal" value="paypal" name="payment_option">
                                  <label class="pay-option-label" for="paypal">
                                    <span class="pay-title"><em class="pay-icon mdi mdi-paypal"></em>
                                        <span class="pay-cur">Paypal</span>
                                    </span>
                                    <span class="pay-amount price-big"><?php echo $calculation['formated_total'];?></span>
                                  </label>
                                </div>       
                            </div>
                            <div class="col-6">
                                <div class="pay-option">
                                    <input class="pay-option-check required" type="radio" id="offline" value="offline" name="payment_option">
                                    <label class="pay-option-label" for="offline">
                                        <span class="pay-title"><em class="pay-icon mdi mdi-cash"></em>
                                            <span class="pay-cur">Offline</span>
                                        </span>
                                        <span class="pay-amount price-big"><?php echo $calculation['formated_total'];?></span>
                                    </label>
                                </div>     
                            </div>
                            <div class="col-md-12">
                                <button type="submit" name="submit" class="btn btn-primary">Place order </button>
                            </div>  
                        </div>
                    <?php echo form_close();?> 
                </div>
            </div>
        </div>

 
    </div>
</div>
