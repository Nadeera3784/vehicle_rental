<div class="app-content">
    <div class="container-fluid pt-3">
       <div class="row">
           <div class="col-md-12 animate-element">
                <div class="card">
                    <div class="header">
                        <h2>Update User</h2>
                        <div class="header-toolbox">
                            <a href="<?php echo base_url();?>admin/users" class="btn btn-sm btn-primary text-white"><i class="mdi mdi-arrow-left mdi-light"></i> Back</a>
                        </div>
                    </div>
                    <div class="body">
                        <?php echo form_open_multipart('admin/save_user');?>
                            <div class="form-group row">
                                <label for="first_name" class="col-sm-2 col-form-label">First Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="first_name" id="first_name" autocomplete="off" value="<?php echo $user->first_name;?>">
                                    <?php echo form_error('first_name'); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="last_name" class="col-sm-2 col-form-label">Last Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="last_name" id="last_name" autocomplete="off" value="<?php echo $user->last_name;?>">
                                    <?php echo form_error('last_name'); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="phone" id="phone" autocomplete="off" value="<?php echo $user->phone;?>">
                                    <?php echo form_error('phone'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" name="email" id="email" autocomplete="off" placeholder="<?php echo $user->email;?>">
                                    <?php echo form_error('email'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-sm-2 col-form-label">Password</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" name="password" id="password" autocomplete="off">
                                    <?php echo form_error('password'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password_confirm" class="col-sm-2 col-form-label">Password Confirm</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" name="password_confirm" id="password_confirm" autocomplete="off">
                                    <?php echo form_error('password_confirm'); ?>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="avatar" class="col-sm-2 col-form-label">Avatar </label>
                                <div class="col-sm-6">
                                   <div class="imageupload">
                                        <div class="file-tab" style="display: block;">
                                            <label class="btn btn-sm btn-light btn-file">
                                            <i class="mdi mdi-cloud-upload"></i> <span>Browse</span>
                                                <input type="file" name="avatar">
                                            </label>
                                            <button type="button" class="btn btn-sm btn-primary" style="display: none;">Delete image</button>
                                        </div>
                                    </div>
                                    <?php echo form_error('avatar'); ?>
                                </div>
                                <div class="col-sm-4">
                                    <img src="<?php echo base_url();?>frontend/images/profile/<?php echo ($user->avatar != "0")? $user->avatar : "default.png";?>"  class="avatar  rounded-circle">
                               </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-sm-2" for="active">Active:</label>
                                <div class="col-sm-10">                                    
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="active" class="custom-control-input" id="active"  <?php echo ($user->active == 1) ? "checked" : ""; ?>>
                                        <label class="custom-control-label" for="active"> <?php echo ($user->active == 1) ? "Yes" : "No"; ?></label>
                                    </div>
                                </div>
                            </div> 

                            <div class="form-group row">
                                <div class="col-sm-10 offset-sm-2">
                                    <input type="hidden" name="id" id="id"  value="<?php echo  $this->hasher->encrypt($user->id) ;?>">
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