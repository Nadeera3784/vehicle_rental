<div class="app-content">
    <div class="container-fluid pt-3">
       <div class="row">
           <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h2>Extra Price</h2>
                        <div class="header-toolbox">
                            <a href="<?php echo base_url();?>admin/add_extra" class="btn btn-sm btn-primary text-white"><i class="mdi mdi-plus mdi-light"></i> New</a>
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
                                    <th>Price(LKR)</th>
                                    <th>Type</th>
                                    <th>Created</th>
                                    <th>Manage</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($extra as  $xt):?>
                                    <tr>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="selected_id[]" class="custom-control-input" id="selected_id_<?php echo $xt->extra_id;?>" value="<?php echo $xt->extra_id;?>">
                                                <label class="custom-control-label" for="selected_id_<?php echo $xt->extra_id;?>"></label>
                                            </div>
                                        </td>
                                        <td><?php echo word_limiter($xt->title, 3);?></td>
                                        <td><?php echo $xt->price;?></td>
                                        <td><?php echo ucfirst($xt->type);?></td>
                                        <td><?php echo  nice_date($xt->created_date, 'Y-m-d');?></td>
                                        <td>
                                            <a href="<?php echo base_url();?>admin/update_extra/<?php echo $this->hasher->encrypt($xt->extra_id);?>" class="btn btn-sm btn-primary">Edit</a>
                                            <button type="button" class="btn btn- btn-sm btn-light" id="extra_delete" data-id="<?php echo $this->hasher->encrypt($xt->extra_id);?>">Delete</button>
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
                            <button type="button" id="bulk_delete_extra" class="btn btn-primary btn-sm">Delete</button>
                            <button type="button" id="close-select-tool" class="btn btn-primary btn-sm">Close</button>
                           </div>
                        </div>
                    </div>
                </div>
           </div>
       </div>
    </div>
</div>