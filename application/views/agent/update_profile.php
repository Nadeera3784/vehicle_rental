<div class="container dashboard-wrapper animate-element">
    <div class="card content-area">
        <div class="card-innr">
        <div class="card-head d-flex justify-content-between align-items-center">
               <h4 class="card-title mb-0">Update Profile</h4>
               <a href="<?php echo base_url();?>agent/listing" class="btn btn-sm btn-auto btn-primary d-sm-block d-none"><em class="mdi mdi-arrow-left mr-3"></em>Back</a>
               <a href="<?php echo base_url();?>agent/listing" class="btn btn-icon btn-sm btn-primary d-sm-none"><em class="mdi mdi-arrow-left"></em></a>
        </div>
           <?php $this->load->view('agent/alert'); ?>
           <?php echo form_open_multipart('agent/save_profile');?>

                <div class="form-group row">
                    <label for="first_name" class="col-sm-2 col-form-label">First name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $user->first_name;?>">
                        <?php echo form_error('first_name'); ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="last_name" class="col-sm-2 col-form-label">Last name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $user->last_name;?>">
                        <?php echo form_error('last_name'); ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="phone" name="phone" value="<?php echo $user->phone;?>">
                        <?php echo form_error('phone'); ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="image" class="col-sm-2 col-form-label">Image:</label>
                    <div class="col-sm-10">
                        <img src="<?php echo base_url();?>frontend/images/profile/<?php echo $user->avatar;?>"  class="rounded" style="width:35px">
                        <input type="file" name="image">
                        <?php echo form_error('image'); ?>
                    </div>
                </div> 

                <div class="form-group row">
                    <label for="password" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="password" name="password" placeholder="if changing password">
                        <?php echo form_error('password'); ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password_confirm" class="col-sm-2 col-form-label">Password Confirm</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="password_confirm" name="password_confirm" placeholder="if changing password">
                        <?php echo form_error('password_confirm'); ?>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-2">
                        <input type="hidden"  id="id" name="id" value="<?php echo $user->id;?>">
                        <button type="reset" name="reset" class="btn btn-sm btn-light">Clear </button>
                        <button type="submit" name="submit" class="btn btn-sm btn-primary">Save Changes</button>
                    </div>
                </div>
                
                <?php echo form_close();?>            
        </div>
    </div>
</div>

