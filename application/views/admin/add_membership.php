<div class="app-content">
    <div class="container-fluid pt-3">
       <div class="row">
           <div class="col-md-12 animate-element">
                <div class="card">
                    <div class="header">
                        <h2>Add Membership</h2>
                        <div class="header-toolbox">
                            <a href="<?php echo base_url();?>admin/memberships" class="btn btn-sm btn-primary text-white"><i class="mdi mdi-arrow-left mdi-light"></i> Back</a>
                        </div>
                    </div>
                    <div class="body">
                        <?php echo form_open('admin/add_membership');?>
                            <div class="form-group row">
                                <label for="title" class="col-sm-2 col-form-label">Title</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="title" id="title" autocomplete="off" value="<?php echo $this->form_validation->set_value('title');?>">
                                    <?php echo form_error('title'); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="col-sm-2 col-form-label">Description</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" type="text" name="description" id="description" autocomplete="off"><?php echo $this->form_validation->set_value('description');?></textarea>
                                    <?php echo form_error('description'); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="price" class="col-sm-2 col-form-label">Price</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" name="price" id="price" autocomplete="off" value="<?php echo $this->form_validation->set_value('price');?>">
                                    <?php echo form_error('price'); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="limitation" class="col-sm-2 col-form-label">Limitation</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" name="limitation" id="limitation" autocomplete="off" value="<?php echo $this->form_validation->set_value('limitation');?>">
                                    <?php echo form_error('limitation'); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="duration" class="col-sm-2 col-form-label">Duration</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" name="duration" id="duration" autocomplete="off" value="<?php echo $this->form_validation->set_value('duration');?>">
                                    <?php echo form_error('duration'); ?>
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