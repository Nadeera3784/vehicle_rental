<div class="app-content">
    <div class="container-fluid pt-3">
       <div class="row">
           <div class="col-md-12">
                <div class="card">
                    <div class="header">
                            <h2>Vehicle Types</h2>
                            <div class="header-toolbox">
                                <a href="<?php echo base_url();?>admin/add_vehicle_type" class="btn btn-sm btn-primary text-white"><i class="mdi mdi-plus mdi-light"></i> New</a>
                            </div>
                    </div>
                    <div class="body">
                       <?php $this->load->view('admin/alert'); ?>
                       <table class="table table-padded" id="dataTBLElement">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="selectAll" class="custom-control-input" id="selectAll">
                                            <label class="custom-control-label" for="selectAll"></label>
                                        </div>
                                    </th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Manage</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($vehicle_type as  $vt):?>
                                    <tr>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="selected_id[]" class="custom-control-input" id="selected_id_<?php echo $vt->vehicle_type_id;?>" value="<?php echo $vt->vehicle_type_id;?>">
                                                <label class="custom-control-label" for="selected_id_<?php echo $vt->vehicle_type_id;?>"></label>
                                            </div>
                                        </td>
                                        <td><?php echo $vt->title;?></td>
                                        <td><?php echo $vt->description;?></td>
                                        <td>
                                            <a href="<?php echo base_url();?>admin/update_vehicle_type/<?php echo $this->hasher->encrypt($vt->vehicle_type_id);?>" class="btn btn-sm btn-primary">Edit</a>
                                            <button type="button" class="btn btn- btn-sm btn-light" id="vehicle_type_delete" data-id="<?php echo $this->hasher->encrypt($vt->vehicle_type_id);?>">Delete</button>
                                        </td>
                                    </tr>                     
                                <?php endforeach;?>                                                                          
                            </tbody>
                        </table>
                        <div class="table-multi-select-tool">
                           <div class="select-counter-container">
                               <p class="select-counter"><span id="selected-items"></span></p>
                           </div>
                           <div class="select-option-container">
                            <button type="button" id="bulk_delete_vehicle_type" class="btn btn-primary btn-sm">Delete</button>
                            <button type="button" id="close-select-tool" class="btn btn-primary btn-sm">Close</button>
                           </div>
                        </div>
                    </div>
                </div>
           </div>
       </div>
    </div>
</div>