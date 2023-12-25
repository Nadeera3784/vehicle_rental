<div class="container ui-vehicle-list-wrapper">
    <div class="row">
        <div class="col-md-3">
            <div class="vehicle-filter accordion vehicle_filter_onliy_side mb-5  d-sm-block d-xs-block d-md-none d-lg-none d-xl-none">
                <button type="button" class="btn btn-light btn-block mt-3" id="ui_model__icon">Filter  Vehicles <i class="mdi mdi-tune"></i></button>
            </div>

            <div id="filterContainer" class="vehicle-filter accordion vehicle_filter_onliy_side d-none d-md-block d-lg-block">
                <h3>Filter Vehicles</h3>
                <hr>
                <?php $attribute = array('id' => 'filter-form');?>
                <?php echo form_open('', $attribute);?>
                    <input type="hidden" name="return_to_pickup_location" value="">
                    <input type="hidden" name="pickup_date" value="<?php echo $cached_data['pickup_date'];?>">
                    <input type="hidden" name="pickup_time" value="<?php echo $cached_data['pickup_time'];?>">
                    <input type="hidden" name="drop_date" value="<?php echo $cached_data['drop_date'];?>">
                    <input type="hidden" name="drop_time" value="<?php echo $cached_data['drop_time'];?>">
                    <input type="hidden" name="promo_code" value="<?php echo $cached_data['promo_code'];?>">
                    <input type="hidden" name="pickup_location" value="<?php echo $cached_data['pickup_location'];?>">
                    <input type="hidden" name="drop_location" value="<?php echo $cached_data['drop_location'];?>">
                    <input type="hidden" name="driving_age" value="<?php echo $cached_data['driving_age'];?>">

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h5 class="panel-title"> Vehicle Type </h5>
                        </div>
                        <div class="panel-body">
                            <?php foreach($vehicle_type as $vt):?>
                            <div class="filter-wrapper">
                                <label class="custom-control custom-checkbox">
                                    <input value="<?php echo $vt->vehicle_type_id; ?>" name="type[<?php echo $vt->vehicle_type_id; ?>]" data-id="<?php echo $vt->vehicle_type_id; ?>" type="checkbox" class="custom-control-input checkbox-filter">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description"><?php echo $vt->title;?></span>
                                </label>
                            </div>
                            <?php endforeach;?>
                        </div>
                    </div>
                    <hr>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h5 class="panel-title"> Passengers </h5>
                        </div>
                        <div class="panel-body">
                            <?php for ($i = 1; $i <= 4; $i++): ?>
                            <div class="filter-wrapper">
                                <label class="custom-control custom-checkbox">
                                    <input value="<?php echo $i; ?>" name="passengers[<?php echo $i; ?>]" data-id="<?php echo $i; ?>" type="checkbox" class="custom-control-input checkbox-filter">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description"><?php echo $i;?></span>
                                </label>
                            </div>
                            <?php endfor;?>
                            <div class="filter-wrapper">
                                <label class="custom-control custom-checkbox">
                                    <input value="<?php echo 5; ?>" name="passengers[<?php echo 5; ?>]" data-id="<?php echo 5; ?>" type="checkbox" class="custom-control-input checkbox-filter">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">4+</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <hr>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h5 class="panel-title"> Transmission </h5>
                        </div>
                        <div class="panel-body">
                            <?php
                                $TransmissionList = array(
                                    0 => 'manual',
                                    1 => 'automatic',
                                    2 => 'semi-automatic'
                                );
                            ?>
                            <?php foreach($TransmissionList as $key => $value):?>
                            <div class="filter-wrapper">
                                <label class="custom-control custom-checkbox">
                                    <input value="<?=$value;?>" name="transmission[<?=$value;?>]" data-id="<?=$value;?>" type="checkbox" class="custom-control-input checkbox-filter">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description"><?=ucfirst($value);?></span>
                                </label>
                            </div>
                            <?php endforeach;?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12  d-none d-md-block d-lg-block">
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
                                                        if (!empty($_POST['drop_location']) && $_POST['drop_location'] != " ") {
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
                                                    <label for="validationCustom04"></label>
                                                    <button name="submit" class="btn btn-block btn-primary mt-2 text-light" type="submit">Search Vehicle</button>
                                                </div>
                                                </div>
                                        <?php echo form_close();?> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" id="vehicle-loop">
                            <div class="row">
                               <div class="col" id="itemContainer">
                                <?php if(isset($vehicle)):?>
                                  <?php foreach($vehicle as $key => $value):?>
                                    <div class="col-md-12">
                                       <?php echo form_open('app/booking_details');?>
                                        <input type="hidden" name="return_to_pickup_location" value="">
                                        <input type="hidden" name="pickup_date" value="<?php echo $cached_data['pickup_date'];?>">
                                        <input type="hidden" name="pickup_time" value="<?php echo $cached_data['pickup_time'];?>">
                                        <input type="hidden" name="drop_date" value="<?php echo $cached_data['drop_date'];?>">
                                        <input type="hidden" name="drop_time" value="<?php echo $cached_data['drop_time'];?>">
                                        <input type="hidden" name="promo_code" value="<?php echo $cached_data['promo_code'];?>">
                                        <input type="hidden" name="pickup_location" value="<?php echo $cached_data['pickup_location'];?>">
                                        <input type="hidden" name="drop_location" value="<?php echo $cached_data['drop_location'];?>">
                                        <input type="hidden" name="driving_age" value="<?php echo $cached_data['driving_age'];?>">
                                        <input type="hidden" id="vehicle_id" name="vehicle_id" value="<?php echo $value->vehicle_id;?>">
                                        <input type="hidden" id="total_price" name="total_price" value="<?php echo $value->prices[0]->price;?>">
                                        <?php foreach($value->prices as $price):?>
                                        <input id="vehicle_selected_price" name="vehicle_selected_price" value="<?php echo $price->vehicle_price_id;?>" type="hidden">
                                        <?php endforeach;?>
                                        <div class="ui-vehicle-list stm-invisible-<?php echo $key;?>" id="product-<?php echo $key;?>">
                                            <div class="vehicle-visible-block">
                                                <div class="vehicle-info-wrap">
                                                    <div class="vehicle-info-top">
                                                        <div class="vehicle-preview-img">
                                                            <div class="image">
                                                                <?php
                                                                $vehicle_array = explode(",",  $value->images);
                                                                ?>
                                                                <img src="<?php echo base_url();?>frontend/images/test/mcr-audi.png" class="img-responsive" alt="<?php echo $vehicle_array[0];?>"  width="347px" height="104px">                   
                                                            </div>
                                                            </div>
                                                            <div class="vehicle-data">
                                                                <div class="vehicle-class-wrap">
                                                                    <div class="vehicle-class">
                                                                        <p><?php echo $value->type->description;?></p>
                                                                    </div>
                                                                </div>
                                                                <h3><?php echo $value->make ." ". $value->model;?></h3>
                                                                <div class="stm-mcr-similat-text">or similar</div>
                                                        </div>
                                                    </div>
                                                    <div class="vehicle-info-middle">
                                                    </div>
                                                    <div class="vehicle-info-bottom">
                                                        <ul>
                                                            <li>
                                                                <div class="attr-img">
                                                                    <img src="<?php echo base_url();?>frontend/images/icons/mcr-fuel-type.svg">
                                                                </div>
                                                                <div class="attr-value">
                                                                    <p><?php echo ucfirst($value->fuel);?></p>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="attr-img">
                                                                    <img src="<?php echo base_url();?>frontend/images/icons/mcr-gear-type.svg">
                                                                </div>
                                                                <div class="attr-value">
                                                                    <p><?php echo ucfirst($value->transmission);?></p>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="attr-img">
                                                                    <img src="<?php echo base_url();?>frontend/images/icons/mcr-persons.svg">
                                                                </div>
                                                                <div class="attr-value">
                                                                    <p><?php echo $value->passengers;?> Persons</p>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="attr-img">
                                                                    <img src="<?php echo base_url();?>frontend/images/icons/mcr-body-type.svg">
                                                                </div>
                                                                <div class="attr-value">
                                                                    <p><?php echo $value->doors;?> Doors</p>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="attr-img">
                                                                    <img src="<?php echo base_url();?>frontend/images/icons/mcr-suitcase.svg">
                                                                </div>
                                                                <div class="attr-value">
                                                                    <p><?php echo $value->bags;?> Bags</p>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="attr-img">
                                                                    <img src="<?php echo base_url();?>frontend/images/icons/mcr-snowflake.svg">
                                                                </div>
                                                                <div class="attr-value">
                                                                    <p><?php echo ($value->air_conditioning == "T")? "Yes" : "No" ;?></p>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="vehicle-price-wrap">
                                                    <div class="stm_price_info">
                                                            <div class="total_days">
                                                             <?php
                                                               echo $duration->d. " Days";  
                                                             ?>
                                                            </div>
                                                            <div class="total_price">
                                                            <div class="stm-mcr-price-view">
                                                                <span class="currency"><?php echo $this->config_manager->config['currency_symbol'];?></span>
                                                                <span class="price-big"><?php echo $value->prices[0]->price;?></span>
                                                            </div>        
                                                    </div>
                                                    <div class="daily_price">
                                                        <div class="stm-mcr-price-view">
                                                            <span class="currency"><?php echo $this->config_manager->config['currency_symbol'];?></span>
                                                            <span class="price-big"><?php echo $value->daily->price_per_day;?></span>
                                                        </div>/Daily        
                                                    </div>
                                                </div>
                                                <div class="rent-btn-wrap">
                                                    <button type="submit" name="submit" class="rent-now">Rent It</button>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                        </form>
                                    </div>
                                  <?php endforeach;?>
                                  <?php else :?>
                                    <div class="col-md-12 text-center pt-5">
                                        <h2>Sorry, No matching data found in selection</h2>
                                        </div>
                                    <?php endif;?>
                                </div>
                                </div>
                            <div class="holder text-center"></div>                               
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ui_model__popup -->
        <div class="ui_model__popup">
            <div class="ui_model__close"></div>
            <div class="ui_model__inner">
                <div class="ui_model__inner_container">
                    <div id="filterContainer" class="vehicle-filter accordion vehicle_filter_onliy_side">
                        <h3 class="text-center">Filter Vehicles</h3>
                        <hr>
                        <?php $attribute = array('id' => 'filter-form');?>
                            <?php echo form_open('', $attribute);?>
                            <input type="hidden" name="return_to_pickup_location" value="">
                            <input type="hidden" name="pickup_date" value="<?php echo $cached_data['pickup_date'];?>">
                            <input type="hidden" name="pickup_time" value="<?php echo $cached_data['pickup_time'];?>">
                            <input type="hidden" name="drop_date" value="<?php echo $cached_data['drop_date'];?>">
                            <input type="hidden" name="drop_time" value="<?php echo $cached_data['drop_time'];?>">
                            <input type="hidden" name="promo_code" value="<?php echo $cached_data['promo_code'];?>">
                            <input type="hidden" name="pickup_location" value="<?php echo $cached_data['pickup_location'];?>">
                            <input type="hidden" name="drop_location" value="<?php echo $cached_data['drop_location'];?>">
                            <input type="hidden" name="age" value="<?php echo $cached_data['driving_age'];?>">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5 class="panel-title"> <a data-toggle="collapse" href="#collapseOne" class="collapse"> Vehicle Type</a></h5>
                                </div>
                                <div id="collapseOne" class="collapse show">
                                    <div class="panel-body">
                                        <?php foreach($vehicle_type as $vt):?>
                                        <div class="filter-wrapper">
                                            <label class="custom-control custom-checkbox">
                                                <input value="<?php echo $vt->vehicle_type_id; ?>" name="type[<?php echo $vt->vehicle_type_id; ?>]" data-id="<?php echo $vt->vehicle_type_id; ?>" type="checkbox" class="custom-control-input checkbox-filter">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description"><?php echo $vt->title;?></span>
                                            </label>
                                        </div>
                                        <?php endforeach;?>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5 class="panel-title"> <a data-toggle="collapse" href="#collapseTwo" class="collapse"> Passengers</a></h5>
                                </div>
                                <div id="collapseTwo" class="collapse">
                                    <div class="panel-body">
                                        <?php for ($i = 1; $i <= 4; $i++): ?>
                                        <div class="filter-wrapper">
                                            <label class="custom-control custom-checkbox">
                                                <input value="<?php echo $i; ?>" name="passengers[<?php echo $i; ?>]" data-id="<?php echo $i; ?>" type="checkbox" class="custom-control-input checkbox-filter">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description"><?php echo $i;?></span>
                                            </label>
                                        </div>
                                        <?php endfor;?>
                                        <div class="filter-wrapper">
                                            <label class="custom-control custom-checkbox">
                                                <input value="<?php echo 5; ?>" name="passengers[<?php echo 5; ?>]" data-id="<?php echo 5; ?>" type="checkbox" class="custom-control-input checkbox-filter">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">4+</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5 class="panel-title"> <a data-toggle="collapse" href="#collapseThree" class="collapse"> Transmission</a></h5>
                                </div>
                                <div id="collapseThree" class="collapse">
                                    <div class="panel-body">
                                        <?php
                                            $TransmissionList = array(
                                                0 => 'manual',
                                                1 => 'automatic',
                                                2 => 'semi-automatic'
                                            );
                                        ?>
                                        <?php foreach($TransmissionList as $key => $value):?>
                                        <div class="filter-wrapper">
                                            <label class="custom-control custom-checkbox">
                                                <input value="<?=$value;?>" name="transmission[<?=$value;?>]" data-id="<?=$value;?>" type="checkbox" class="custom-control-input checkbox-filter">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description"><?=ucfirst($value);?></span>
                                            </label>
                                        </div>
                                        <?php endforeach;?>
                                    </div>
                                </div>
                            </div>
                        <?php echo form_close();?>
                    </div>
                </div>
            </div>
        </div>
        <!-- ui_model__popup -->
    </div>
</div>
