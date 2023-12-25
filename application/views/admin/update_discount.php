<div class="app-content">
    <div class="container-fluid pt-3">
       <div class="row">
           <div class="col-md-12 animate-element">
                <div class="card">
                    <div class="header">
                        <h2>Update Discount</h2>
                        <div class="header-toolbox">
                            <a href="<?php echo base_url();?>admin/discount" class="btn btn-sm btn-primary text-white"><i class="mdi mdi-arrow-left mdi-light"></i> Back</a>
                        </div>
                    </div>
                    <div class="body">
                        <?php echo form_open('admin/save_discount');?>
                            <div class="form-group row">
                                <label for="title" class="col-sm-2 col-form-label">Title</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control" name="title" id="title" autocomplete="off" value="<?php echo $discount->title;?>">
                                    <?php echo form_error('title'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="from" class="col-sm-2 col-form-label">From</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="from" id="from" autocomplete="off" value="<?php echo date($this->config_manager->config['date_format'], $discount->from_date);?>">
                                    <?php echo form_error('from'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="to" class="col-sm-2 col-form-label">To</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="to" id="to" autocomplete="off" value="<?php echo date($this->config_manager->config['date_format'], $discount->to_date);?>">
                                    <?php echo form_error('to'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="limit" class="col-sm-2 col-form-label">Limit</label>
                                <div class="col-sm-10">
                                <input type="number" class="form-control" name="limit" id="limit" autocomplete="off" value="<?php echo $discount->dlimit;?>">
                                    <?php echo form_error('limit'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="pcode" class="col-sm-2 col-form-label">Promo code</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control" name="pcode" id="pcode" autocomplete="off" value="<?php echo $discount->promo_code;?>">
                                    <?php echo form_error('pcode'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="discount" class="col-sm-2 col-form-label">Discount(%)</label>
                                <div class="col-sm-10">
                                <input type="number" class="form-control" name="discount" id="discount" autocomplete="off" value="<?php echo $discount->discount;?>">
                                    <?php echo form_error('discount'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="type" class="col-sm-2 col-form-label">Type</label>
                                <div class="col-sm-10">
                                   <?php
                                        $TypeList = array(
                                            0 => 'percent',
                                            1 => 'price'
                                        );
                                    ?>
                                   <select name="type" id="type" class="form-control">
                                       <?php foreach($TypeList as $key => $value):?>
                                        <?php
                                                if($value == $discount->type){
                                                    $selected = 'selected';
                                                }else{
                                                    $selected = "";
                                                }
                                            ?>
                                           <option <?php echo $selected; ?> value="<?=$value;?>"><?=ucfirst($value);?></option>
                                        <?php endforeach;?>
                                    </select>
                                    <?php echo form_error('type'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-10 offset-sm-2">
                                    <input type="hidden"  name="id" id="id" value="<?php echo $this->hasher->encrypt($discount->discount_id);?>">
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