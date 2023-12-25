<div class="app-content">
    <div class="container-fluid pt-3">
       <div class="row">
           <div class="col-md-12 animate-element">
                <div class="card">
                    <div class="header">
                            <h2>Update Location</h2>
                            <div class="header-toolbox">
                                <a href="<?php echo base_url();?>admin/locations" class="btn btn-sm btn-primary text-white"><i class="mdi mdi-arrow-left mdi-light"></i> Back</a>
                            </div>
                    </div>
                    <div class="body">
                        <?php echo form_open('admin/save_location');?>
                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="name" id="name" autocomplete="off" value="<?php echo $location->name;?>">
                                    <?php echo form_error('name'); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="latitude" class="col-sm-2 col-form-label">Latitude</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="latitude" id="latitude" autocomplete="off" value="<?php echo $location->latitude;?>">
                                    <?php echo form_error('latitude'); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="longitude" class="col-sm-2 col-form-label">Longitude</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="longitude" id="longitude" autocomplete="off" value="<?php echo $location->longitude;?>">
                                    <?php echo form_error('longitude'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-10 offset-sm-2">
                                        <input type="hidden" name="id" id="id"  value="<?php echo  $this->hasher->encrypt($location->location_id) ;?>">
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