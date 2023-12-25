<div class="app-content">
    <div class="container-fluid pt-3">
       <div class="row">
           <div class="col-md-12 animate-element">
                <div class="card">
                    <div class="header">
                            <h2>Update Vehicle</h2>
                            <div class="header-toolbox">
                                <a href="<?php echo base_url();?>admin/vehicles" class="btn btn-sm btn-primary text-white"><i class="mdi mdi-arrow-left mdi-light"></i> Back</a>
                            </div>
                    </div>
                    <div class="body">
                        <?php echo form_open_multipart('admin/save_vehicle');?>

                            <div class="form-group row">
                                <label for="location" class="col-sm-2 col-form-label">Location</label>
                                <div class="col-sm-10">
                                    <select name="location" id="location" class="form-control">
                                        <option value="0">--Select Location--</option>
                                        <?php foreach($locations as $location):?>
                                        <?php
                                            if($location->location_id == $vehicle->location_id){
                                                $selected = 'selected';
                                            }else{
                                                $selected = "";
                                            }
                                        ?>
                                         <option <?php echo $selected; ?> value="<?php echo $location->location_id;?>"><?php echo $location->name;?></option>
                                        <?php endforeach;?>
                                    </select>
                                    <?php echo form_error('location'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="type" class="col-sm-2 col-form-label">Type</label>
                                <div class="col-sm-10">
                                    <select name="type" id="type" class="form-control">
                                        <option value="0">--Select Type--</option>
                                        <?php foreach($vehicle_type as $vt):?>
                                            <?php
                                                if($vt->vehicle_type_id == $vehicle->vehicle_type_id){
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
                                <label for="year" class="col-sm-2 col-form-label">Year</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="year" name="year" value="<?php echo $vehicle->year;?>">
                                    <?php echo form_error('year'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="registration_number" class="col-sm-2 col-form-label">Registration Number</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="registration_number" name="registration_number" value="<?php echo  $vehicle->registration_number;?>">
                                    <?php echo form_error('registration_number'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="mileage" class="col-sm-2 col-form-label">Mileage</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="mileage" name="mileage" value="<?php echo  $vehicle->mileage;?>">
                                    <?php echo form_error('mileage'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="fuel" class="col-sm-2 col-form-label">Fuel</label>
                                <div class="col-sm-10">
                                    <?php
                                        $FuelList = array(
                                            0 => 'diesel',
                                            1 => 'petrol',
                                            2 => 'gas',
                                            3 => 'electric',
                                            4 => 'hybrid'
                                        );
                                    ?>
                                   <select name="fuel" id="fuel" class="form-control">
                                        <option value="0">--Select Fuel Type--</option>
                                        <?php foreach($FuelList as $key => $value):?>
                                            <?php
                                                if($value == $vehicle->fuel){
                                                    $selected = 'selected';
                                                }else{
                                                    $selected = "";
                                                }
                                            ?>
                                           <option <?php echo $selected; ?> value="<?=$value;?>"><?=ucfirst($value);?></option>
                                        <?php endforeach;?>
                                    </select>
                                    <?php echo form_error('fuel'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="passengers" class="col-sm-2 col-form-label">Passengers</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="passengers" name="passengers" value="<?php echo  $vehicle->passengers;?>">
                                    <?php echo form_error('passengers'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="bags" class="col-sm-2 col-form-label">Bags</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="bags" name="bags" value="<?php echo  $vehicle->bags;?>">
                                    <?php echo form_error('bags'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="doors" class="col-sm-2 col-form-label">Doors</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="doors" name="doors" value="<?php echo  $vehicle->doors;?>">
                                    <?php echo form_error('doors'); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="transmission" class="col-sm-2 col-form-label">Transmission</label>
                                <div class="col-sm-10">
                                    <?php
                                        $TransmissionList = array(
                                            0 => 'manual',
                                            1 => 'automatic',
                                            2 => 'semi-automatic'
                                        );
                                    ?>
                                   <select name="transmission" id="transmission" class="form-control">
                                        <option value="0">--Select Transmission--</option>
                                        <?php foreach($TransmissionList as $key => $value):?>
                                            <?php
                                                if($value == $vehicle->transmission){
                                                    $selected = 'selected';
                                                }else{
                                                    $selected = "";
                                                }
                                            ?>
                                            <option <?php echo $selected; ?> value="<?=$value;?>"><?=ucfirst($value);?></option>
                                        <?php endforeach;?>
                                    </select>
                                    <?php echo form_error('transmission'); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="aircon" class="col-sm-2 col-form-label">Air conditioning:</label>
                                <div class="col-sm-10">
                                    <div class="d-flex">
                                        <div class="radio radio-primary">
                                            <input type="radio" id="aircon_yes" value="T" name="aircon" <?=($vehicle->air_conditioning == "T")? "checked" : "";?>>
                                            <label for="aircon_yes"> Yes </label>
                                        </div>
                                        <div class="radio">
                                            <input type="radio" id="aircon_no" value="F" name="aircon" <?=($vehicle->air_conditioning == "F")? "checked" : "";?>>
                                            <label for="aircon_no"> No </label>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="image" class="col-sm-2 col-form-label">Image:</label>
                                <div class="col-sm-10">
                                    <div class="uploaderwrapper image-container">
                                       <?php $split_images = explode(',',$vehicle->images);?>
                                       <?php foreach($split_images as $key => $img):?>
                                            <div class="uploaderbox" data-file-name="<?php echo $img;?>">
                                                <div class="uploaderbox-image" style="background-image: url('<?php echo base_url() . $this->config->item('app_frontend_asset_root')."/images/vehicles/".space_remover($img);?>')"></div>
                                                <div class="uploaderbox-text"><?php echo $img;?></div>
                                                <?php if($key != "0"):?>
                                                 <div class="uploaderbox-close" id="delete_vehicle_images" data-image="<?php echo space_remover($img);?>" data-id="<?php echo  $this->hasher->encrypt($vehicle->vehicle_id);?>">×</div>
                                                <?php endif;?>
                                            </div>
                                        <?php endforeach;?>
                                    </div>

                                    <hr>
                                    <div id="append">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <img class="img rounded">
                                                <input type="file" name="image[]"  class="imageselector">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="imageError"></div>
                                    <?php echo form_error('image'); ?>
                                </div>
                            </div> 
                            <div class="form-group row">
                                <div class="col-sm-10 offset-sm-2">
                                    <button type="button" class="btn btn-sm btn-primary" id="add-file-but">Add</button> 
                                    <button type="button" class="btn btn-sm btn-white" id="remove-file-but">Remove </button> 
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="make" class="col-sm-2 col-form-label">Make</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="make" name="make" value="<?php echo  $vehicle->make;?>">
                                    <?php echo form_error('make'); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="model" class="col-sm-2 col-form-label">Model</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="model" name="model" value="<?php echo  $vehicle->model;?>">
                                    <?php echo form_error('model'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-sm-2 col-form-label"> Description</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" type="text" name="description" id="description" autocomplete="off"><?php echo $vehicle->description;?></textarea>
                                    <?php echo form_error('description'); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-10 offset-sm-2">
                                    <input type="hidden" id="vehicle_id" name="vehicle_id" value="<?php echo  $this->hasher->encrypt($vehicle->vehicle_id);?>">
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