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
            		<h1><i class='glyphicon glyphicon-user'></i> Questions Management  </h1>
            		<h3>Dashboard <i class='icon-right-open-2'></i>Questions Management <i class='icon-right-open-2'></i>Upload Questions Answers</h3> 				
				</div>
            	<!-- Page Heading End-->
				<div class="row">
					<div class="col-sm-12 portlets">
						<div class="widget">
							<div class="widget-header transparent">
								<h2><strong> Upload </strong> Questions Answers</h2>
								<div class="additional-btn">
									<a href="#" class="hidden reload"><i class="icon-ccw-1"></i></a>
									<a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
									<a href="#" class="widget-close"><i class="icon-cancel-3"></i></a>
								</div>
							</div>
							
							<div class="widget-content padding">
								 <?php echo $this->Form->create('Question', array('type' => 'file')); ?>
								<!--form role="form" id="registerForm"-->
								  <div class="form-group">
									<label> Select Topic </label>
									<select class="form-control required" name="data[Question][topic_id]">
										<option value="">Select</option>
										<?php foreach($data as $info) {  ?>
										<option value="<?php echo $info['Topic']['id']; ?>"><?php echo $info['Topic']['name']; ?></option>
										<?php  } ?>
									</select>
								  </div>
								  <div class="form-group">
									<label> CSV File </label>
									<input type="file" name="data[Question][profile_image]" class="form-control required">
								  </div>	
								  <input type="submit" id="update" class="btn btn-primary" value="Save">
								  <!--button type="submit" class="btn btn-primary">Cancel</button-->
								</form>
							</div>
						</div>						
					</div>
				</div>				
				            <!-- Footer Start -->
            <footer>
                SwimPedia; 2015
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
	<script>
	$(document).ready(function() 
	{
		var max_fields      = 15; //maximum input boxes allowed
		var wrapper         = $(".input_fields_wrap"); //Fields wrapper
		var wrapper1         = $(".select_fields_wrap"); //Fields wrapper
		var add_button      = $(".add_field_button"); //Add button ID
   
		var x = 1; //initlal text box count
		$(add_button).click(function(e)
		{ //on add input button click
			e.preventDefault();
			if(x < max_fields)
			{ //max input box allowed
				x++; //text box increment
				$(wrapper).append('<div class="form-group" ><input type="text" class="form-control" name="Answer[0][]"/><a href="#" class="remove_field">Remove</a></div>'); //add input box
				$(wrapper1).append('<option value="'+(x-1)+'">Answer'+x+'</option>');
			}
		});   
		$(wrapper).on("click",".remove_field", function(e)
		{ //user click on remove text
			e.preventDefault(); 
			$(this).parent('div').remove(); 
			$(".select_fields_wrap option:last").remove();
			x--;
		})
	});
	</script>