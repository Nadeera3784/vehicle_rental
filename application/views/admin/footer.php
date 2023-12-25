    <script src="<?php echo base_url();?>backend/js/jquery.js"></script>
    <script src="<?php echo base_url();?>backend/js/popper.js"></script>
    <script src="<?php echo base_url();?>backend/js/bootstrap.js"></script>
    <script src="<?php echo base_url();?>backend/js/jquery.scrollbar.min.js"></script>
    <script src="<?php echo base_url();?>backend/js/moment.js"></script>
    <?php
        if(isset($js)){
            $arrlength = count($js);
            for($x = 0; $x < $arrlength; $x++) {
                echo "<script type=\"text/javascript\" src=\"".base_url(). $js[$x]."\"></script>\n";
            }
        } 
    ?>
    <script src="<?php echo base_url();?>backend/js/plugins.js"></script>
    <script> 
        var App_url = "<?php echo base_url();?>";
        var App_date_format = "<?php echo $this->config_manager->config['date_format'];?>";
        var CSRF_NAME = "<?php echo $this->security->get_csrf_token_name(); ?>";
        var CSRF_HASH = "<?php echo $this->security->get_csrf_hash() ?>";
        var ajax_data        = {};
        ajax_data[CSRF_NAME] = CSRF_HASH;
   </script>
</body>
</html>