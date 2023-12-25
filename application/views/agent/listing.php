<div class="container dashboard-wrapper">
    <div class="card content-area">
        <div class="card-innr">
            <div class="card-head d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Listing</h4>
                <a href="<?php echo base_url();?>agent/add_vehicle" class="btn btn-sm btn-auto btn-primary d-sm-block d-none"><em class="mdi mdi-plus-circle-outline mr-3"></em>Add Vehicle</a>
                <a href="<?php echo base_url();?>agent/add_vehicle" class="btn btn-icon btn-sm btn-primary d-sm-none"><em class="mdi mdi-plus-circle-outline"></em></a>
            </div>
           <?php $this->load->view('agent/alert'); ?>
            <table class="table table-padded DataTableVehicle">
                <thead>
                    <tr>
                    <th>Image</th>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>(R)Number</th>
                    <th>Status</th>
                    <th>Manage</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($vehicles as $vehicle):?>
                    <?php 
                    $split_images = explode(',', $vehicle->images);
                    ?>
                    <tr>
                    <td>
                        <img alt="<?php echo trim($split_images[0]);?>" src="<?php echo base_url();?>frontend/images/vehicles/<?php echo trim($split_images[0]);?>"  class="rounded" style="width:35px">
                    </td>
                        <td><?php echo $vehicle->make;?></td>
                        <td><?php echo $vehicle->model;?></td>
                        <td>
                            <span class="registration-number">
                               <?php echo $vehicle->registration_number ;?>
                            <span>
                        </td>
                        <td>
                          <span class="badge badge-md badge-<?php echo ($vehicle->status == "1")? "primary" : "lighter";?>"><?php echo ($vehicle->status == "1")? "Active" : "Pending";?></span>
                        </td>
                        <td>
                            <a href="<?php echo base_url();?>agent/update_vehicle/<?php echo $this->hasher->encrypt($vehicle->vehicle_id);?>" class="btn btn-sm btn-primary text-white"><i class="mdi mdi-pencil"></i> Edit</a>
                            <a href="<?php echo base_url();?>agent/vehicle_price/<?php echo $this->hasher->encrypt($vehicle->vehicle_id);?>" class="btn btn-outline btn-sm btn-secondary"><i class="mdi mdi-cash-multiple"></i>  Price</a>
                            <a href="<?php echo base_url();?>agent/vehicle_extra_options/<?php echo $this->hasher->encrypt($vehicle->vehicle_id);?>" class="btn btn-sm btn-primary"><i class="mdi mdi-palette-swatch"></i>  Extra</a>
                            <button type="button" class="btn btn-sm btn-white" data-id="<?php echo $this->hasher->encrypt($vehicle->vehicle_id);?>" id="deleteVehicle"><i class="mdi mdi-delete"></i> Delete</button>
                        </td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>

