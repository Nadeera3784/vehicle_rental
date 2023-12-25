
<div class="row">
    <div  class="col" id="itemContainer">
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