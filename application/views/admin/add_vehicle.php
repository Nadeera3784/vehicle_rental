<div class="app-content">
    <div class="container-fluid pt-3">
       <div class="row">
           <div class="col-md-12 animate-element">
                <div class="card">
                    <div class="header">
                            <h2>Add Vehicle</h2>
                            <div class="header-toolbox">
                                <a href="<?php echo base_url();?>admin/vehicles" class="btn btn-sm btn-primary text-white"><i class="mdi mdi-arrow-left mdi-light"></i> Back</a>
                            </div>
                    </div>
                    <div class="body">
                        <?php echo form_open_multipart('admin/add_vehicle');?>

                            <div class="form-group row">
                                <label for="location" class="col-sm-2 col-form-label">Location</label>
                                <div class="col-sm-10">
                                    <select name="location" id="location" class="form-control select">
                                        <option value="0">--Select Location--</option>
                                        <?php foreach($locations as $location):?>
                                         <option value="<?php echo $location->location_id;?>"><?php echo $location->name;?></option>
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
                                         <option value="<?php echo $vt->vehicle_type_id;?>"><?php echo $vt->title;?></option>
                                        <?php endforeach;?>
                                    </select>
                                    <?php echo form_error('type'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="year" class="col-sm-2 col-form-label">Year</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="year" name="year" value="<?php echo $this->form_validation->set_value('year');?>">
                                    <?php echo form_error('year'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="registration_number" class="col-sm-2 col-form-label">Registration Number</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="registration_number" name="registration_number" value="<?php echo $this->form_validation->set_value('registration_number');?>">
                                    <?php echo form_error('registration_number'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="mileage" class="col-sm-2 col-form-label">Mileage</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="mileage" name="mileage" value="<?php echo $this->form_validation->set_value('mileage');?>">
                                    <?php echo form_error('mileage'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="fuel" class="col-sm-2 col-form-label">Fuel</label>
                                <div class="col-sm-10">
                                   <select name="fuel" id="fuel" class="form-control">
                                        <option value="0">--Select Fuel Type--</option>
                                        <option value="diesel">Diesel</option>
                                        <option value="petrol">Petrol</option>
                                        <option value="gas">Gas</option>
                                        <option value="hybrid">Hybrid</option>
                                        <option value="electric">Electric</option>
                                    </select>
                                    <?php echo form_error('fuel'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="passengers" class="col-sm-2 col-form-label">Passengers</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="passengers" name="passengers" value="<?php echo $this->form_validation->set_value('passengers');?>">
                                    <?php echo form_error('passengers'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="bags" class="col-sm-2 col-form-label">Bags</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="bags" name="bags" value="<?php echo $this->form_validation->set_value('bags');?>">
                                    <?php echo form_error('bags'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="doors" class="col-sm-2 col-form-label">Doors</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="doors" name="doors" value="<?php echo $this->form_validation->set_value('doors');?>">
                                    <?php echo form_error('doors'); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="transmission" class="col-sm-2 col-form-label">Transmission</label>
                                <div class="col-sm-10">
                                   <select name="transmission" id="transmission" class="form-control">
                                        <option value="0">--Select Transmission--</option>
                                        <option value="manual">Manual</option>
                                        <option value="automatic">Automatic</option>
                                        <option value="semi-automatic">Semi-Automatic</option>
                                    </select>
                                    <?php echo form_error('transmission'); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="aircon" class="col-sm-2 col-form-label">Air conditioning:</label>
                                <div class="col-sm-10">
                                    <div class="d-flex">
                                        <div class="radio radio-primary">
                                            <input type="radio" id="aircon_yes" value="T" name="aircon" checked="">
                                            <label for="aircon_yes"> Yes </label>
                                        </div>
                                        <div class="radio">
                                            <input type="radio" id="aircon_no" value="F" name="aircon">
                                            <label for="aircon_no"> No </label>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="image" class="col-sm-2 col-form-label">Image:</label>
                                <div class="col-sm-10">
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
                                    <input type="text" class="form-control" id="make" name="make" value="<?php echo $this->form_validation->set_value('make');?>">
                                    <?php echo form_error('make'); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="model" class="col-sm-2 col-form-label">Model</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="model" name="model" value="<?php echo $this->form_validation->set_value('model');?>">
                                    <?php echo form_error('model'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-sm-2 col-form-label"> Description</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" type="text" name="description" id="description" autocomplete="off"><?php echo $this->form_validation->set_value('description');?></textarea>
                                    <?php echo form_error('description'); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="price" class="col-sm-2 col-form-label"> Price</label>
                                <div class="col-sm-10">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                        <input type="number" class="form-control" name="price_per_day" id="price_per_day" value="<?php echo $this->form_validation->set_value('price_per_day');?>" placeholder="Per Day">
                                        <?php echo form_error('price_per_day'); ?>
                                        </div>
                                        <div class="form-group col-md-6">
                                        <input type="number" class="form-control" name="price_per_hour" id="price_per_hour" value="<?php echo $this->form_validation->set_value('price_per_hour');?>" placeholder="Per Hour">
                                        <?php echo form_error('price_per_hour'); ?>
                                        </div>
                                        <div class="form-group col-md-6">
                                        <input type="number" class="form-control" name="limit_mileage" id="limit_mileage" value="<?php echo $this->form_validation->set_value('limit_mileage');?>"  placeholder="Limit Mileage">
                                        <?php echo form_error('limit_mileage'); ?>
                                        </div>
                                        <div class="form-group col-md-6">
                                        <input type="number" class="form-control" name="extra_mileage_price" id="extra_mileage_price" value="<?php echo $this->form_validation->set_value('extra_mileage_price');?>"  placeholder="Extra Mileage Price">
                                        <?php echo form_error('extra_mileage_price'); ?>
                                        </div>
                                        <div class="form-group col-md-12">
                                        <input type="number" class="form-control" name="extra_hour_price" id="extra_hour_price" value="<?php echo $this->form_validation->set_value('extra_hour_price');?>" placeholder="Extra Hour Price">
                                        <?php echo form_error('extra_hour_price'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-10 offset-sm-2">
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