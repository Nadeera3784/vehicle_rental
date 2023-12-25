<div class="container dashboard-wrapper">
    <div class="card content-area">
        <div class="card-innr">
            <div class="card-head d-flex justify-content-between align-items-center">
               <h4 class="card-title mb-0">Bookings</h4>
               <a href="<?php echo base_url();?>agent/booking_calendar" class="btn btn-sm btn-auto btn-primary d-sm-block d-none"><em class="mdi mdi-calendar mr-3"></em>Booking Calendar</a>
            </div>
           <?php $this->load->view('agent/alert'); ?>
            <table class="table table-padded DataTableTypes">
                <thead>
                    <tr>
                    <th>Booking ID</th>
                    <th>Vehicle</th>
                    <th>Date</th>
                    <th>Amount(<?php echo $this->config_manager->config['currency_symbol'];?>)</th>
                    <th>Status</th>
                    <th>Manage</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($booking as $key => $ab):?>
                        <tr>
                        <td>
                            <span class="registration-number">
                               <?php echo $ab->booking_number ;?>
                            <span>
                        </td>
                        <td><?php echo $ab->vehicle_details->make . " " . $ab->vehicle_details->model ;?></td>
                        <td>
                            <?php echo date($this->config_manager->config['date_format'] . ' ' . $this->config_manager->config['time_format'], $ab->start_time); ?> 
                            <?php echo  $ab->pickup_location->name;?>
                            <br>
                            <?php echo date($this->config_manager->config['date_format'] . ' ' . $this->config_manager->config['time_format'], $ab->end_time); ?>
                            <?php echo  $ab->drop_location->name;?>
                        </td>
                        <td><?php echo $ab->amount ;?></td>
                        <td>
                            <span class="badge badge-md badge-<?php echo ($ab->status == "confirmed")? "primary" : "lighter";?>"><?php echo ucfirst($ab->status) ;?></span>
                        </td>
                        <td>
                            <a href="<?php echo base_url();?>agent/booking_details/<?php echo $this->hasher->encrypt($ab->vehicle_booking_id);?>" class="btn btn-sm btn-primary text-white"> View</a>
                            <button type="button" class="btn btn-sm btn-white" data-id="<?php echo $this->hasher->encrypt($ab->vehicle_booking_id);?>" id="updateBooking"> Update</button>
                        </td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>

