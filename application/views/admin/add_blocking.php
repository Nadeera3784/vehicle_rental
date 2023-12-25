<div class="app-content">
    <div class="container-fluid pt-3">
       <div class="row">
           <div class="col-md-12 animate-element">
                <div class="card">
                    <div class="header">
                            <h2>Add Vehicle Blocking</h2>
                            <div class="header-toolbox">
                                <a href="<?php echo base_url();?>admin/blocking" class="btn btn-sm btn-primary text-white"><i class="mdi mdi-arrow-left mdi-light"></i> Back</a>
                            </div>
                    </div>
                    <div class="body">
                        <?php echo form_open('admin/add_blocking');?>
                            <div class="form-group row">
                                <label for="vehicle" class="col-sm-2 col-form-label">Vehicle</label>
                                <div class="col-sm-10">
                                   <select name="vehicle" id="vehicle" class="form-control select select-block select-bordered">
                                        <option value="0">--Select Vehicle--</option>
                                        <?php foreach($vehicles as $vehicle):?>
                                         <option value="<?php echo $vehicle->vehicle_id;?>"><?php echo $vehicle->make . " " . $vehicle->model ;?></option>
                                        <?php endforeach;?>
                                    </select>
                                    <?php echo form_error('vehicle'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="from" class="col-sm-2 col-form-label">From</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="from" id="from" autocomplete="off" value="<?php echo $this->form_validation->set_value('from');?>">
                                    <?php echo form_error('from'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="to" class="col-sm-2 col-form-label">To</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="to" id="to" autocomplete="off" value="<?php echo $this->form_validation->set_value('to');?>">
                                    <?php echo form_error('to'); ?>
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