<div class="app-content">
    <div class="container-fluid pt-3">
       <div class="row">
           <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h2>Vehicle Blocking</h2>
                        <div class="header-toolbox">
                            <a href="<?php echo base_url();?>admin/add_blocking" class="btn btn-sm btn-primary text-white"><i class="mdi mdi-plus mdi-light"></i> New</a>
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
                                    <th>Vehicle ID</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Manage</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($vehicle_blocking as  $vb):?>
                                    <tr>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="selected_id[]" class="custom-control-input" id="selected_id_<?php echo $vb->vehicle_bloking_id;?>" value="<?php echo $vb->vehicle_bloking_id;?>">
                                                <label class="custom-control-label" for="selected_id_<?php echo $vb->vehicle_bloking_id;?>"></label>
                                            </div>
                                        </td>
                                        <td><?php echo $vb->vehicle_id;?></td>
                                        <td><?php echo date($this->config_manager->config['date_format'], $vb->from_date);?></td>
                                        <td><?php echo date($this->config_manager->config['date_format'], $vb->to_date);?></td>
                                        <td>
                                            <a href="<?php echo base_url();?>admin/update_blocking/<?php echo $this->hasher->encrypt($vb->vehicle_bloking_id);?>" class="btn btn-sm btn-primary">Edit</a>
                                            <button type="button" class="btn btn- btn-sm btn-light" id="blocking_delete" data-id="<?php echo $this->hasher->encrypt($vb->vehicle_bloking_id);?>">Delete</button>
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
                            <button type="button" id="bulk_delete_blocking" class="btn btn-primary btn-sm">Delete</button>
                            <button type="button" id="close-select-tool" class="btn btn-primary btn-sm">Close</button>
                           </div>
                        </div>
                    </div>
                </div>
           </div>
       </div>
    </div>
</div>