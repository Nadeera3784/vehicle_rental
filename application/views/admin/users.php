<div class="app-content">
    <div class="container-fluid pt-3">
       <div class="row">
           <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h2>Users</h2>
                        <div class="header-toolbox">
                            <a href="<?php echo base_url();?>admin/add_user" class="btn btn-sm btn-primary text-white"><i class="mdi mdi-plus mdi-light"></i> New</a>
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
                                    <th>First name</th>
                                    <th>Last name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Membership</th>
                                    <th>Manage</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($users as  $user):?>
                                    <tr>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="selected_id[]" class="custom-control-input" id="selected_id_<?php echo $user->id;?>" value="<?php echo $user->id;?>">
                                                <label class="custom-control-label" for="selected_id_<?php echo $user->id;?>"></label>
                                            </div>
                                        </td>
                                        <td><?php echo $user->first_name;?></td>
                                        <td><?php echo $user->last_name;?></td>
                                        <td><?php echo $user->email;?></td>
                                        <td>
                                           <span class="badge badge-<?php echo ($user->active == "1")? "primary" : "default";?>"><?php echo ($user->active == "1")? "Active" : "Disabled";?></span>
                                        </td>
                                        <td>
                                        <?php
                                           echo $membership_id[$user->membership_id]->title; 
                                        ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo base_url();?>admin/update_user/<?php echo $this->hasher->encrypt($user->id);?>" class="btn btn-sm btn-primary">Edit</a>
                                            <button type="button" class="btn btn- btn-sm btn-light" id="user_delete" data-id="<?php echo $this->hasher->encrypt($user->id);?>">Delete</button>
                                            <button type="button"  id="change_membership" data-id="<?php echo $this->hasher->encrypt($user->id);?>" class="btn btn- btn-sm btn-white">Membership</button>
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
                            <button type="button" id="bulk_delete_users" class="btn btn-primary btn-sm">Delete</button>
                            <button type="button" id="close-select-tool" class="btn btn-primary btn-sm">Close</button>
                           </div>
                        </div>
                    </div>
                </div>
           </div>

            <div class="modal fade slide-right" id="modalSlideLeft" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content-wrapper">
                        <div class="modal-content">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                            <div class="container-xs-height full-height mt-5">
                                <div class="row-xs-height">
                                    <div class="modal-body col-xs-height pb-5">
                                         <?php foreach($memberships as $key => $membership):?>
                                            <div class="membership-wrapper"> 
                                                <div class="radio radio-primary">
                                                    <input type="radio" name="membership" id="membership_<?php echo $key;?>" value="<?php echo $membership->membership_id;?>">
                                                    <label for="membership_<?php echo $key;?>">
                                                        <?php echo $membership->title;?>
                                                    </label>
                                                </div>
                                            </div>
                                         <?php endforeach;?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                    <input  type="hidden" id="update_id" name="update_id"/>
                                    <button type="button" id="update_membership" class="btn btn-primary btn-block">Save</button>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                    <button type="button" class="btn btn-default btn-block" data-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


       </div>
    </div>
</div>