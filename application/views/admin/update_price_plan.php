<div class="app-content">
    <div class="container-fluid pt-3">
       <div class="row">
           <div class="col-md-12 animate-element">
                <div class="card">
                    <div class="header">
                        <h2>Update Price Plan</h2>
                        <div class="header-toolbox">
                            <a href="<?php echo base_url();?>admin/price_plan" class="btn btn-sm btn-primary text-white"><i class="mdi mdi-arrow-left mdi-light"></i> Back</a>
                        </div>
                    </div>
                    <div class="body">
                        <?php echo form_open('admin/save_price_plan');?>
                            <div class="form-group row">
                                <label for="type" class="col-sm-2 col-form-label">Type</label>
                                <div class="col-sm-10">
                                   <select name="type" id="type" class="form-control rvehicle typeUpdate">
                                        <option value="0">--Select Type--</option>
                                        <?php foreach($vehicle_type as $vt):?>
                                            <?php
                                                if($vt->vehicle_type_id == $vehicle_price->type_id){
                                                    $selected = 'selected';
                                                }else{
                                                    $selected = "";
                                                }
                                            ?>
                                         <option <?php echo $selected; ?> value="<?php echo $vt->vehicle_type_id;?>"><?php echo $vt->title;?></option>
                                        <?php endforeach;?>
                                    </select>
                                    <?php echo form_error('type'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="vehicle" class="col-sm-2 col-form-label">Vehicle</label>
                                <div class="col-sm-10">
                                   <select name="vehicle" id="vehicle" class="form-control select">
                                        <option value="0">--Select Vehicle--</option>
                                    </select>
                                    <?php echo form_error('vehicle'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="price_per_day" class="col-sm-2 col-form-label">Price per day</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" name="price_per_day" id="price_per_day" autocomplete="off" value="<?php echo $vehicle_price->price_per_day;?>">
                                    <?php echo form_error('price_per_day'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="price_per_hour" class="col-sm-2 col-form-label">Price per hour</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" name="price_per_hour" id="price_per_hour" autocomplete="off" value="<?php echo $vehicle_price->price_per_hour;?>">
                                    <?php echo form_error('price_per_hour'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="limit_mileage" class="col-sm-2 col-form-label">Limit mileage</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" name="limit_mileage" id="limit_mileage" autocomplete="off" value="<?php echo $vehicle_price->limit_mileage;?>">
                                    <?php echo form_error('limit_mileage'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="price_for_extra_mileage" class="col-sm-2 col-form-label">Price for extra mileage</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" name="price_for_extra_mileage" id="price_for_extra_mileage" autocomplete="off" value="<?php echo $vehicle_price->extra_mileage_price;?>">
                                    <?php echo form_error('price_for_extra_mileage'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="extra_hour_price" class="col-sm-2 col-form-label">Extra hour price</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" name="extra_hour_price" id="extra_hour_price" autocomplete="off" value="<?php echo $vehicle_price->extra_hour_price;?>">
                                    <?php echo form_error('extra_hour_price'); ?>
                                </div>
                            </div>


                            <div class="form-group row">
                                <div class="col-sm-10 offset-sm-2">
                                    <input type="hidden"  name="id"  value="<?php echo $this->hasher->encrypt($vehicle_price->vehicle_price_id);?>">
                                    <button type="reset" name="reset" class="btn btn-sm btn-light">Clear </button>
                                    <button type="submit" name="submit" class="btn btn-sm btn-primary">Save Changes</button>
                                </div>
                            </div>
                        <?php echo form_close();?> 
                    </div>
                </div>
           </div>
       </div>
    </div>
</div>