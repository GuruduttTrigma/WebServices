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
            		<h1><i class='glyphicon glyphicon-user'></i>Customer Questions Management </h1>
            		<h3>Dashboard <i class='icon-right-open-2'></i>Customer Questions Management<i class='icon-right-open-2'></i>Select Topic</h3> 				
				</div>
            	<!-- Page Heading End-->
				<div class="row">
					<div class="col-sm-12 portlets">
						<div class="widget">
							<div class="widget-header transparent">
								<h2><strong> Select </strong> Topic </h2>
								<div class="additional-btn">
									<a href="#" class="hidden reload"><i class="icon-ccw-1"></i></a>
									<a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
									<a href="#" class="widget-close"><i class="icon-cancel-3"></i></a>
								</div>
							</div>
							<div class="widget-content padding">
								 <?php echo $this->Form->create('Topic', array('action' => 'admin_select_topic')); ?>
								<!--form method="post"-->
								  <div class="form-group">
									<label> Select Topic </label>
									<select class="form-control required" name="data[CustomerQuestion][topic_id]">
										<?php foreach($data as $info) {  ?>
										<option value="<?php echo $info['Topic']['id']; ?>"><?php echo $info['Topic']['name']; ?></option>
										<?php  } ?>
									</select>
									<input type="hidden" name="data[CustomerQuestion][question_id]" value="<?php echo $question_id; ?>">
									</div>						  
								  <button type="submit" id="update" class="btn btn-primary">Save</button>
								  <!--button type="submit" class="btn btn-primary">Cancel</button-->
								</form>
							</div>
						</div>
						
					</div>
				</div>
				
				            <!-- Footer Start -->
            <footer>
              SwimPedia &copy; 2015
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