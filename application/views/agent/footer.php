<footer>
        <?php if($footer_bottom == TRUE):?>
        <div class="footer_head">
           <div class="dot dot-three"></div>
			<div class="dot dot-one"></div>
            <div class="contain mb-5">
				<div class="dot dot-two"></div>
                <h1>Are you looking for renting your vehicle?</h1>
                <p class="p-large" data-parallax="{&quot;y&quot; : 25}">
                    Morbi mollis vestibulum sollicitudin. Nunc in eros a justo facilisis rutrum. Aenean id ullamcorper libero 
                </p>
                <div class="header-switcher">
                    <a href="#" class="btn btn_green"> CREATE ACCOUNT</a>
                    <span></span>
                    <a href="#" class="btn btn_grey">CONTACT SALES</a>
                </div>
            </div>
			<div class="dot dot-four"></div>
			<section class="waves">
					<svg viewBox="0 0 100 25">
						<path fill="#ffffff" d="M0 30 V12 Q30 17 55 12 T100 11 V30z"></path>
					</svg>
			</section>
        </div>
        <?php endif;?>
        <div class="container">
            <div class="footer_content">
                <nav class="footer_nav">
                    <ul class="links">
                        <li>
						<h6>Sitemap</h6></li>
						<li><a href="<?php echo base_url();?>">Home</a></li>
                        <li><a href="#">About</a></li>
                        <li><a href="#">Contact</a></li>
						<li><a href="<?php echo base_url();?>terms">Terms</a></li>
                    </ul>
                    <ul class="links">
                        <li>
						<h6>Support</h6></li>
						<li><a href="#">Help</a></li>
						<li><a href="#">FAQ</a></li>
						<li><a href="#">Tracking</a></li>
                    </ul>
                    <ul class="links">
                        <li>
						<h6>Socials </h6></li>
						<li><a href="#">Facebook</a></li>
						<li><a href="#">Twitter</a></li>
						<li><a href="#">Linkedin</a></li>
                    </ul>
                    <ul class="links">
                        <li>
                        <h6>Reach Us </h6>
                    </li>
                    <div class="footer_contact">
                        <div class="address">
                            <p>7900 E. Union Ave., 
                                <br> Ste 1100
                                Denver, 80237</p>
                        </div>
                        <div class="phone">
                            <p>444-444-4444</p>
                        </div>
                        <div class="phone">
                            <p>Example@info.com</p>
                        </div>
                    </div>
                    </ul>

                </nav>
            </div>
            <div class="footer_info">
                <div class="copyright">
                <h5><img src="<?php echo base_url();?>frontend/images/logo5.png" width="30">© <?php echo date("Y");?> App</h5>
                </div>
                <ul class="footer_links">
                    <li><a href="<?php echo base_url();?>privacy-policy">Privacy Policy</a></li>
                    <li><a href="<?php echo base_url();?>terms">Terms</a></li>
                    <li><a href="#">Acceptable Use Policy</a></li>
                </ul>
            </div>
        </div>
    </footer>

    <script src="<?php echo base_url();?>frontend/js/jquery.js"></script>
    <script src="<?php echo base_url();?>frontend/js/popper.min.js"></script>
    <script src="<?php echo base_url();?>frontend/js/bootstrap.js"></script>
    <?php
        if(isset($js)){
            $arrlength = count($js);
            for($x = 0; $x < $arrlength; $x++) {
                echo "<script type=\"text/javascript\" src=\"".base_url(). $js[$x]."\"></script>\n";
            }
        }
    ?>
    <script> 
        var App_url = "<?php echo base_url()?>";
        var App_date_format = "<?php echo $this->config_manager->config['date_format'];?>";
        var App_time_format = "<?php echo $this->config_manager->config['time_format'];?>";
        var CSRF_NAME = "<?php echo $this->security->get_csrf_token_name(); ?>";
        var CSRF_HASH = "<?php echo $this->security->get_csrf_hash() ?>";
        var ajax_data        = {};
        ajax_data[CSRF_NAME] = CSRF_HASH;
    </script>
</body>
</html>