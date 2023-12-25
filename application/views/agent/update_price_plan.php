<div class="container dashboard-wrapper animate-element">
    <div class="card content-area">
        <div class="card-innr">
        <div class="card-head d-flex justify-content-between align-items-center">
               <h4 class="card-title mb-0">Update Vehicle Price</h4>
               <a href="<?php echo base_url();?>agent/listing" class="btn btn-sm btn-auto btn-primary d-sm-block d-none"><em class="mdi mdi-arrow-left mr-3"></em>Back</a>
               <a href="<?php echo base_url();?>agent/listing" class="btn btn-icon btn-sm btn-primary d-sm-none"><em class="mdi mdi-arrow-left"></em></a>
        </div>
           <?php $this->load->view('agent/alert'); ?>
           
            <?php echo form_open('agent/save_price_plan');?>

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
                    <input type="hidden"  name="vehicle_id"  value="<?php echo $this->hasher->encrypt($vehicle_price->vehicle_id);?>">
                    <button type="reset" name="reset" class="btn btn-sm btn-light">Clear </button>
                    <button type="submit" name="submit" class="btn btn-sm btn-primary">Save Changes</button>
                </div>
            </div>
        <?php echo form_close();?> 

        </div>
    </div>
</div>

