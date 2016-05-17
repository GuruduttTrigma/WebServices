<?php echo $this->element("admin_header"); ?>
<?php // echo $this->element("admin_topright"); ?>
<?php // echo $this->element("admin_nav"); ?>
<?php echo $this->element("admin_sidebar"); ?> 
<?php echo $this->element("admin_rightsidebar"); ?> 
		<!-- Start right content -->
        <div class="content-page">
			<!-- ============================================================== -->
			<!-- Start Content here -->
			<!-- ============================================================== -->
            <div class="content">
            					<!-- Page Heading Start -->
				<div class="page-heading">
            		<h1><i class='glyphicon glyphicon-user'></i> Administrator Profile</h1>
            		<h3>Dashboard <i class='icon-right-open-2'></i>Administrator Profile<i class='icon-right-open-2'></i>Change Password</h3> 
					<?php $x=$this->Session->flash(); ?>
                    <?php if($x){ ?>					
					<div class="alert alert-danger alert-dismissable" style="text-align:center">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<?php echo $x; ?><a href="#" class="alert-link"></a>.
					</div>	
                   <?php } ?>					
				</div>
            	<!-- Page Heading End-->
				<div class="row">
					<div class="col-sm-12 portlets">
						<div class="widget">
							<div class="widget-header transparent">
								<h2><strong>Change</strong>Password</h2>
								<div class="additional-btn">
									<a href="#" class="hidden reload"><i class="icon-ccw-1"></i></a>
									<a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
									<a href="#" class="widget-close"><i class="icon-cancel-3"></i></a>
								</div>
							</div>
							<div class="widget-content padding">
								<?php echo $this->Form->create('User',array('action'=>'admin_changepass','id'=>'validate')); ?>
								<form role="form" id="registerForm">
								  <div class="form-group">
									<label>Old Password</label>
									<?php echo $this->Form->input('opass', array('label'=>"",'type'=>'text','class'=>'form-control','Placeholder'=>'Old Password...','type'=>'password','required'));?>
								  </div>
								  <div class="form-group">
									<label>New Password</label>
									<?php echo $this->Form->input('password', array('label'=>"",'type'=>'text','class'=>'form-control','Placeholder'=>'New Password...','type'=>'password','required'));?>
								  </div>
								  <div class="form-group">
									<label>Confirm Password</label>
									<?php echo $this->Form->input('cpass', array('label'=>"",'type'=>'text','class'=>'form-control','Placeholder'=>'Confirm Password...','type'=>'password','required'));?>
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