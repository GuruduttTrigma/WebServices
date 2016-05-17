<?php echo $this->element("admin_header"); ?>
<?php // echo $this->element("admin_topright"); ?>
<?php // echo $this->element("admin_nav"); ?>
<?php echo $this->element("admin_sidebar"); ?> 
<?php echo $this->element("admin_rightsidebar"); ?> 
		<!-- Start right content -->
        <div class="content-page">
			<!-- Start Content here -->
            <div class="content">
            					<!-- Page Heading Start -->
				<div class="page-heading">
            		<h1><i class='glyphicon glyphicon-user'></i> Account Settings</h1>
            		<h3>Dashboard <i class='icon-right-open-2'></i>Account Settings<i class='icon-right-open-2'></i>Edit Account</h3> 				
				</div>
            	<!-- Page Heading End-->
				<div class="row">
					<div class="col-sm-12 portlets">
						<div class="widget">
							<div class="widget-header transparent">
								<h2><strong> Edit </strong> Account </h2>
								<div class="additional-btn">
									<a href="#" class="hidden reload"><i class="icon-ccw-1"></i></a>
									<a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
									<a href="#" class="widget-close"><i class="icon-cancel-3"></i></a>
								</div>
							</div>
							<div class="widget-content padding">
								<?php echo $this->Form->create('Sitesetting'); ?>
								<!--form role="form" id="registerForm"-->
								  <div class="form-group">
									<label> Title </label>
									<?php echo $this->Form->input('title',array('label'=>"",'class'=>'form-control','title'=>'Enter Site Title')); ?>
				                    					
								  </div>
								  <div class="form-group">
									<label>Web URL</label>
				                    <?php echo $this->Form->input('web_url',array('label'=>"",'class'=>'form-control','title'=>'Enter Site Title')); ?>					
								  </div>	
								  <div class="form-group">
									<label> Keywords </label>
									<?php echo $this->Form->input('keywords',array('label'=>"",'class'=>'form-control','title'=>'Enter Site Title')); ?>											
								  </div>
								  <div class="form-group">
									<label> Site Email</label>
									<?php echo $this->Form->input('site_email',array('label'=>"",'class'=>'form-control','title'=>'Enter Site Title')); ?>					
								  </div>	
								  <div class="form-group">
									<label> Facebook URL </label>
									<?php echo $this->Form->input('facebook_url',array('label'=>"",'class'=>'form-control','title'=>'Enter Site Title')); ?>					
								  </div>
								  <div class="form-group">
									<label> Twitter URL </label>
									<?php echo $this->Form->input('twitter_url',array('label'=>"",'class'=>'form-control','title'=>'Enter Site Title')); ?>					
								  </div>
								  <div class="form-group">
									<label> Google URL </label>
									<?php echo $this->Form->input('googleplus',array('label'=>"",'class'=>'form-control','title'=>'Enter Site Title')); ?>					
								  </div>
								  <div class="form-group">
									<label> Site Description</label>
									<?php echo $this->Form->input('site_desc',array('label'=>"",'class'=>'form-control','type'=>'textarea','title'=>'Enter Site Title')); ?>					
								  </div>
								  <div class="form-group">
									<label> Site Address </label>
									<?php echo $this->Form->input('site_address',array('label'=>"",'class'=>'form-control','type'=>'textarea','title'=>'Enter Site Title')); ?>					
								  </div>							  
								  <button type="submit" name="Save" id="update" class="btn btn-primary">Save</button>
								  <!--button type="submit" class="btn btn-primary">Cancel</button-->
								</form>
							</div>
						</div>
						
					</div>
				</div>
				
				            <!-- Footer Start -->
            <footer>
                Huban Creative &copy; 2014
                <div class="footer-links pull-right">
                	<a href="#">About</a><a href="#">Support</a><a href="#">Terms of Service</a><a href="#">Legal</a><a href="#">Help</a><a href="#">Contact Us</a>
                </div>
            </footer>
            <!-- Footer End -->			
            </div>
			<!-- ============================================================== -->
			<!-- End content here -->
			<!-- ============================================================== -->

        </div>
		<!-- End right content -->

	</div>
	<!-- End of page -->
		<!-- the overlay modal element -->
	<div class="md-overlay"></div>
	<!-- End of eoverlay modal -->
	<script>
		var resizefunc = [];
	</script>