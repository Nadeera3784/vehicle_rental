<div class="app-content">
    <div class="container-fluid pt-3">
       <div class="row">
           <div class="col-md-12 animate-element">
                <div class="card">
                    <div class="header">
                        <h2>Add Extra Price</h2>
                        <div class="header-toolbox">
                            <a href="<?php echo base_url();?>admin/extra" class="btn btn-sm btn-primary text-white"><i class="mdi mdi-arrow-left mdi-light"></i> Back</a>
                        </div>
                    </div>
                    <div class="body">
                        <?php echo form_open('admin/save_extra');?>
                            <div class="form-group row">
                                <label for="vehicles" class="col-sm-2 col-form-label">Vehicles</label>
                                <div class="col-sm-10">

                                    <select name="vehicles[]" id="vehicles" class="form-control select select-block select-bordered select2-hidden-accessible"  multiple="multiple">
                                       <?php foreach($vehicles as $vehicle):?>
                                        <option value="<?php echo $vehicle->vehicle_id; ?>" <?php echo !empty($vehicle_id) && array_key_exists($vehicle->vehicle_id, $vehicle_id) ? 'selected=selected' : ''; ?>>
                                        <?php echo $vehicle->make;?> <?php echo $vehicle->model;?></option>
                                       <?php endforeach;?>
                                    </select>
                                    <?php echo form_error('vehicles[]'); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="title" class="col-sm-2 col-form-label">Title</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="title" id="title" autocomplete="off" value="<?php echo $extra->title;?>">
                                    <?php echo form_error('title'); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="col-sm-2 col-form-label">Description</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" type="text" name="description" id="description" autocomplete="off"><?php echo $extra->description;?></textarea>
                                    <?php echo form_error('description'); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="price" class="col-sm-2 col-form-label">Price</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" name="price" id="price" autocomplete="off" value="<?php echo $extra->price;?>">
                                    <?php echo form_error('price'); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="type" class="col-sm-2 col-form-label">Type</label>
                                <div class="col-sm-10">
                                    <?php
                                        $TypeList = array(
                                            0 => 'percent',
                                            1 => 'perdaycount',
                                            2 => 'percount',
                                            3 => 'perday'
                                        );
                                    ?>

                                   <select name="type" id="type" class="form-control">
                                     <?php foreach($TypeList as $key => $value):?>
                                           <?php
                                                if($value == $extra->type){
                                                    $selected = 'selected';
                                                }else{
                                                    $selected = "";
                                                }
                                            ?>

                                         <option <?php echo $selected; ?> value="<?php echo $value;?>"><?php echo ucfirst($value);?></option>
                                     <?php endforeach;?>
                                    </select>
                                    <?php echo form_error('type'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="calculate" class="col-sm-2 col-form-label">Calculate</label>
                                <div class="col-sm-10">
                                   <select name="calculate" id="calculate" class="form-control">
                                   <?php
                                        $CalculateList = array(
                                            0 => 'percent',
                                            1 => 'price'
                                        );
                                    ?>
                                     <?php foreach($CalculateList as $key => $value):?>
                                        <?php
                                                if($value == $extra->calculate){
                                                    $selected = 'selected';
                                                }else{
                                                    $selected = "";
                                                }
                                            ?>

                                        <option <?php echo $selected; ?> value="<?php echo $value;?>"><?php echo ucfirst($value);?></option>
                                     <?php endforeach;?>
                                    </select>
                                    <?php echo form_error('calculate'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-10 offset-sm-2">
                                    <input type="hidden"  name="id" id="id"  value="<?php echo $this->hasher->encrypt($extra->extra_id);?>">
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