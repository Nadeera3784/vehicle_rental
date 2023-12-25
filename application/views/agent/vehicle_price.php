<div class="container dashboard-wrapper">
    <div class="card content-area">
        <div class="card-innr">
        <div class="card-head d-flex justify-content-between align-items-center">
               <h4 class="card-title mb-0">Vehicle Price</h4>
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
                        <span class="data-details-title">Type</span>
                        <span class="data-details-info"><?php echo $vehicle_type->title;?> </span>
                    </div>
                    <div class="fake-class">
                    <span class="data-details-title">Model </span>
                        <span class="data-details-info"><?php echo $vehicle->model;?> </span>       
                    </div>
                </div>

                <table class="table table-padded DataTableTypes">
                <thead>
                    <tr>
                    <th>#</th>
                    <th>Day(per)</th>
                    <th>Hour(per)</th>
                    <th>Mileage(KM)</th>
                    <th>Extra mileage</th>
                    <th>Extra hour</th>
                    <th>Manage</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($prices as $price):?>
                    <tr>
                    <td>
                      <?php echo $price->vehicle_price_id;?>
                    </td>
                        <td><?php echo $price->price_per_day;?></td>
                        <td>
                            <?php echo $price->price_per_hour;?>
                        </td>
                        <td>
                          <?php echo $price->limit_mileage;?>
                        </td>
                        <td>
                          <?php echo $price->extra_mileage_price;?>
                        </td>
                        <td>
                          <?php echo $price->extra_hour_price;?>
                        </td>
                        <td>
                            <a href="<?php echo base_url();?>agent/update_vehicle_price/<?php echo $this->hasher->encrypt($price->vehicle_price_id);?>" class="btn btn-sm btn-primary text-white"><i class="mdi mdi-pencil"></i> Edit</a>
                        </td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>

        </div>
    </div>
</div>

