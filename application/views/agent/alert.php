<?php if($this->session->flashdata('success')): ?>
    <div class="alert alert-primary  alert-dismissible fade show" role="alert">
        <?php echo  $this->session->flashdata('success');?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
   </button>
    </div>
<?php endif; ?>
<?php if($this->session->flashdata('warning')): ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <?php echo  $this->session->flashdata('warning');?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    </div>
<?php endif; ?>
<?php if($this->session->flashdata('danger')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?php echo  $this->session->flashdata('danger');?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
       <span aria-hidden="true">&times;</span>
    </button>
    </div>
<?php endif; ?>

