<div class="container dashboard-wrapper">
    <div class="card content-area">
        <div class="card-innr">
        <div class="card-head d-flex justify-content-between align-items-center">
               <h4 class="card-title mb-0">Extra Options</h4>
               <a href="<?php echo base_url();?>agent/listing" class="btn btn-sm btn-auto btn-primary d-sm-block d-none"><em class="mdi mdi-arrow-left mr-3"></em>Back</a>
               <a href="<?php echo base_url();?>agent/listing" class="btn btn-icon btn-sm btn-primary d-sm-none"><em class="mdi mdi-arrow-left"></em></a>
        </div>
           <?php $this->load->view('agent/alert'); ?>
                <div class="data-details d-md-flex mb-5">
                    <div class="fake-class">
                      <span class="data-details-title">Registration Number</span>
                      <span class="data-details-info"><?php echo $vehicle->registration_number;?></span>
                    </div>
                    <div class="fake-class">
                        <span class="data-details-title">Status</span>
                        <span class="data-details-info"><?php echo ($vehicle->status == "1")? "Active" : "Pending";?></span>
                    </div>
                    <div class="fake-class">
                        <span class="data-details-title">Make</span>
                        <span class="data-details-info"><?php echo $vehicle->make;?> </span>
                    </div>
                    <div class="fake-class">
                       <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#vehilcePriceModal"><i class="mdi mdi-plus-circle-outline"></i> Add Extra Options</button>  
                       <div class="modal fade" id="vehilcePriceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog model-center" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add extra options</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                            <div class="AjaxErrorHandler"></div>
                            <div class="form-group row">
                                <label for="title" class="col-sm-4 col-form-label">Title</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="title" id="title" autocomplete="off" value="<?php echo $this->form_validation->set_value('title');?>">
                                    <?php echo form_error('title'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-sm-4 col-form-label">Description</label>
                                <div class="col-sm-8">
                                    <textarea class="form-control" type="text" name="description" id="description" autocomplete="off"><?php echo $this->form_validation->set_value('description');?></textarea>
                                    <?php echo form_error('description'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="price" class="col-sm-4 col-form-label">Price</label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control" name="price" id="price" autocomplete="off" value="<?php echo $this->form_validation->set_value('price');?>">
                                    <?php echo form_error('price'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="type" class="col-sm-4 col-form-label">Type</label>
                                <div class="col-sm-8">
                                   <select name="type" id="type" class="form-control">
                                        <option value="percent">Per booking</option>
                                        <option value="perdaycount">Per day per unit</option>
                                        <option value="percount">Per unit</option>
                                        <option value="perday">Per day</option>
                                    </select>
                                    <?php echo form_error('type'); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="calculate" class="col-sm-4 col-form-label">Calculate</label>
                                <div class="col-sm-8">
                                   <select name="calculate" id="calculate" class="form-control">
                                        <option value="percent">Percent</option>
                                        <option value="price">Price</option>
                                    </select>
                                    <?php echo form_error('calculate'); ?>
                                </div>
                            </div>
                                                
                            </div>
                            <div class="modal-footer">
                                <input type="hidden"  name="vehicle_id" id="vehicle_id"  value="<?php echo $vehicle_id;?>">
                                <button type="button" class="btn btn-sm btn-white" data-dismiss="modal">Close</button>
                                <button type="button" id="add-extra-options" class="btn btn-sm btn-primary">Save changes</button>
                            </div>
                            </div>
                        </div>
                        </div>     
                    </div>
                </div>

                <table class="table table-padded DataTableTypes">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Price(<?php echo $this->config_manager->config['currency_symbol'];?>)</th>
                        <th>Created</th>
                        <th>Manage</th>
                    </tr>
                </thead>
                <tbody>
                     <?php foreach($extra_options as $extra):?>
                        <tr>
                           <td><?php echo $extra->extra_id;?></td>
                           <td><?php echo $extra->title;?></td>
                           <td><?php echo $extra->price;?></td>
                           <td><?php echo nice_date($extra->created_date, 'Y-m-d');?></td>
                           <td>
                              <a href="<?php echo base_url();?>agent/update_extra_options/<?php echo $this->hasher->encrypt($extra->extra_id);?>" class="btn btn-sm btn-primary text-white"><i class="mdi mdi-pencil"></i> Edit</a>
                              <button type="button" class="btn btn-sm btn-white" data-id="<?php echo $this->hasher->encrypt($extra->extra_id);?>" id="deleteExtraOptions"><i class="mdi mdi-delete"></i> Delete</button>
                           </td>
                        </tr>
                     <?php endforeach;?>
                </tbody>
            </table>

        </div>
    </div>
</div>

