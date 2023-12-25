<div class="app-content">
    <div class="container-fluid pt-3">
       <div class="row">
           <div class="col-md-12">
                <div class="card">
                    <div class="header">
                            <h2>Vehicles</h2>
                            <div class="header-toolbox">
                                <a href="<?php echo base_url();?>admin/add_vehicle" class="btn btn-sm btn-primary text-white"><i class="mdi mdi-plus mdi-light"></i> New</a>
                                <button type="button" class="btn btn-sm btn-light" data-toggle="collapse" data-target="#filterElement" aria-expanded="false" aria-controls="filterElement"><i class="mdi mdi-filter"></i> Filter</button>
                            </div>
                    </div>
                    <div class="body">
                       <?php $this->load->view('admin/alert'); ?>
                       <div class="form-inline mb-5 collapse" id="filterElement">
                            <div class="form-group mr-4">
                                <select name="location_id" id="location_id" class="form-control required">
                                        <option value="">---Select Location---</option>
                                        <?php foreach($locations as  $lc):?>
                                           <option value="<?php echo $lc->location_id;?>"><?php echo ucfirst($lc->name);?></option>
                                        <?php endforeach;?>     
                                </select>  
                            </div>
                            <div class="form-group mr-4">
                                <input type="text" class="form-control" id="start_date" name="start_date" placeholder="From">
                            </div>
                            <div class="form-group mr-4">
                                <input type="text" class="form-control" id="end_date" name="end_date" placeholder="To">
                            </div>	
                            <div class="form-group mr-3">
                                    <button type="button" name="applyVehicles" id="applyVehicles" class="btn btn-sm btn-primary">Apply</button>
                            </div>
                            <div class="form-group mr-3">
                                    <button type="button" name="resetVehicles" id="resetVehicles" class="btn btn-sm btn-light">Clear</button>
                            </div>
                            <hr>
                        </div>

                       <table class="table table-padded" id="DTVehicles">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="selectAll" class="custom-control-input" id="selectAll">
                                            <label class="custom-control-label" for="selectAll"></label>
                                        </div>
                                    </th>
                                    <th>Image</th>
                                    <th>Location</th>
                                    <th>R/Number</th>
                                    <th>Status</th>
                                    <th>Manage</th>
                                </tr>
                            </thead>
                            <tbody>
 
                            </tbody>
                        </table>
                        <div class="table-multi-select-tool">
                           <div class="select-counter-container">
                               <p class="select-counter"><span id="selected-items"></span></p>
                           </div>
                           <div class="select-option-container">
                            <button type="button" id="bulk_delete_vehicle" class="btn btn-primary btn-sm">Delete</button>
                            <button type="button" id="close-select-tool" class="btn btn-primary btn-sm">Close</button>
                           </div>
                        </div>
                    </div>
                </div>
           </div>
       </div>
    </div>
</div>