<div class="app-content">
    <div class="container-fluid pt-3">
       <div class="row">
           <div class="col-md-12 animate-element">
                <div class="card">
                    <div class="header">
                            <h2>Update Global Settings</h2>
                    </div>
                    <div class="body">
                    <?php $this->load->view('admin/alert'); ?>
                        <?php echo form_open('admin/save_settings');?>
                            <div class="form-group row">
                                <label for="date_format" class="col-sm-2 col-form-label">Date format</label>
                                 <div class="col-sm-10">
                                    <?php
                                        $FormatList = array(
                                            0 => 'Y-m-d',
                                            1 => 'Y/m/d',
                                            2 => 'Y.m.d',
                                            3 => 'm-d-Y',
                                            4 => 'm/d/Y',
                                            5 => 'm.d.Y',
                                            6 => 'd-m-Y',
                                            7 => 'd/m/Y',
                                            8 => 'd.m.Y'
                                        );
                                    ?>
                                   <select name="date_format" id="date_format" class="form-control">
                                        <?php foreach($FormatList as $key => $value):?>
                                            <?php
                                                if($value == $this->config_manager->config['date_format']){
                                                    $selected = 'selected';
                                                }else{
                                                    $selected = "";
                                                }
                                            ?>
                                            <option <?php echo $selected; ?> value="<?=$value;?>"><?=ucfirst($value);?></option>
                                        <?php endforeach;?>
                                    </select>
                                    <?php echo form_error('date_format'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="time_format" class="col-sm-2 col-form-label">Time format</label>
                                 <div class="col-sm-10">
                                    <?php
                                        $TimeFormatList = array(
                                            0 => 'G:i',
                                            1 => 'H:i',
                                            2 => 'h:i a',
                                            3 => 'h:i A',
                                            4 => 'g:i a',
                                            5 => 'g:i A'
                                        );
                                    ?>
                                   <select name="time_format" id="time_format" class="form-control">
                                        <?php foreach($TimeFormatList as $key => $value):?>
                                            <?php
                                                if($value == $this->config_manager->config['time_format']){
                                                    $selected = 'selected';
                                                }else{
                                                    $selected = "";
                                                }
                                            ?>
                                            <option <?php echo $selected; ?> value="<?=$value;?>"><?=ucfirst($value);?></option>
                                        <?php endforeach;?>
                                    </select>
                                    <?php echo form_error('time_format'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="rent_interval" class="col-sm-2 col-form-label">Block Interval</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="rent_interval" id="rent_interval" autocomplete="off" value="<?php echo $this->config_manager->config['rent_interval'];?>">
                                    <?php echo form_error('rent_interval'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="calculate_type" class="col-sm-2 col-form-label">Price Calculation</label>
                                 <div class="col-sm-10">
                                    <?php
                                        $calculateList = array(
                                            0 => 'perday',
                                            1 => 'perhour',
                                            2 => 'both'
                                        );
                                    ?>
                                   <select name="calculate_type" id="calculate_type" class="form-control">
                                        <?php foreach($calculateList as $key => $value):?>
                                            <?php
                                                if($value == $this->config_manager->config['calculate_type']){
                                                    $selected = 'selected';
                                                }else{
                                                    $selected = "";
                                                }
                                            ?>
                                            <option <?php echo $selected; ?> value="<?=$value;?>"><?=ucfirst($value);?></option>
                                        <?php endforeach;?>
                                    </select>
                                    <?php echo form_error('calculate_type'); ?>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="currency_symbol" class="col-sm-2 col-form-label">Currency symbol</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="currency_symbol" id="currency_symbol" autocomplete="off" value="<?php echo $this->config_manager->config['currency_symbol'];?>">
                                    <?php echo form_error('currency_symbol'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="deposit" class="col-sm-2 col-form-label">Deposit</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="deposit" id="deposit" autocomplete="off" value="<?php echo $this->config_manager->config['deposit'];?>">
                                    <?php echo form_error('deposit'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="deposit_type" class="col-sm-2 col-form-label">Deposit type</label>
                                 <div class="col-sm-10">
                                    <?php
                                        $depositTypeList = array(
                                            0 => 'price',
                                            1 => 'percent'
                                        );
                                    ?>
                                   <select name="deposit_type" id="deposit_type" class="form-control">
                                        <?php foreach($depositTypeList as $key => $value):?>
                                            <?php
                                                if($value == $this->config_manager->config['deposit_type']){
                                                    $selected = 'selected';
                                                }else{
                                                    $selected = "";
                                                }
                                            ?>
                                            <option <?php echo $selected; ?> value="<?=$value;?>"><?=ucfirst($value);?></option>
                                        <?php endforeach;?>
                                    </select>
                                    <?php echo form_error('deposit_type'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="tax" class="col-sm-2 col-form-label">Tax</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="tax" id="tax" autocomplete="off" value="<?php echo $this->config_manager->config['tax'];?>">
                                    <?php echo form_error('tax'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="tax_type" class="col-sm-2 col-form-label">Tax type</label>
                                 <div class="col-sm-10">
                                    <?php
                                        $taxTypeList = array(
                                            0 => 'price',
                                            1 => 'percent'
                                        );
                                    ?>
                                   <select name="tax_type" id="tax_type" class="form-control">
                                        <?php foreach($taxTypeList as $key => $value):?>
                                            <?php
                                                if($value == $this->config_manager->config['tax_type']){
                                                    $selected = 'selected';
                                                }else{
                                                    $selected = "";
                                                }
                                            ?>
                                            <option <?php echo $selected; ?> value="<?=$value;?>"><?=ucfirst($value);?></option>
                                        <?php endforeach;?>
                                    </select>
                                    <?php echo form_error('tax_type'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="age_tax" class="col-sm-2 col-form-label">Age tax</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="age_tax" id="age_tax" autocomplete="off" value="<?php echo $this->config_manager->config['age_tax'];?>">
                                    <?php echo form_error('age_tax'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="age_tax_type" class="col-sm-2 col-form-label">Age tax type</label>
                                 <div class="col-sm-10">
                                    <?php
                                        $ageTaxList = array(
                                            0 => 'price',
                                            1 => 'percent'
                                        );
                                    ?>
                                   <select name="age_tax_type" id="age_tax_type" class="form-control">
                                        <?php foreach($ageTaxList as $key => $value):?>
                                            <?php
                                                if($value == $this->config_manager->config['age_tax_type']){
                                                    $selected = 'selected';
                                                }else{
                                                    $selected = "";
                                                }
                                            ?>
                                            <option <?php echo $selected; ?> value="<?=$value;?>"><?=ucfirst($value);?></option>
                                        <?php endforeach;?>
                                    </select>
                                    <?php echo form_error('age_tax_type'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="age_for_tax" class="col-sm-2 col-form-label">Age for tax</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="age_for_tax" id="age_for_tax" autocomplete="off" value="<?php echo $this->config_manager->config['age_for_tax'];?>">
                                    <?php echo form_error('age_for_tax'); ?>
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