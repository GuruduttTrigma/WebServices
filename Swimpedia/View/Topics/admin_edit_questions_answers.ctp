<?php 	echo $this->Html->script(array('jquery-1.7.1.min.js')); ?>
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
            		<h1><i class='glyphicon glyphicon-user'></i> Questions Answers Management </h1>
            		<h3>Dashboard <i class='icon-right-open-2'></i>Questions Answers Management<i class='icon-right-open-2'></i>Edit Questions Answers</h3> 				
				</div>
            	<!-- Page Heading End-->
				<div class="row">
					<div class="col-sm-12 portlets">
						<div class="widget">
							<div class="widget-header transparent">
								<h2><strong> Edit </strong> Questions Answers </h2>
								<div class="additional-btn">
									<a href="#" class="hidden reload"><i class="icon-ccw-1"></i></a>
									<a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
									<a href="#" class="widget-close"><i class="icon-cancel-3"></i></a>
								</div>
							</div>
							
							<div class="widget-content padding">
								 <?php echo $this->Form->create('Question'); ?>
								<!--form role="form" id="registerForm"-->
								  <div class="form-group">
									<label> Select Topic </label>
									<select class="form-control required" name="data[Question][topic_id]">
										<?php foreach($data as $info) {  ?>
										<option value="<?php echo $info['Topic']['id']; ?>" <?php if($info['Topic']['id'] == $question['Topic']['id']) { echo "selected='selected'"; } ?> ><?php echo $info['Topic']['name']; ?></option>
										<?php  } ?>
									</select>
								  </div>
								  <div class="form-group">
									<label> Question </label>
				                    <?php echo $this->Form->input('question', array('label'=>"",'type'=>'text','value'=> $question['Question']['question'],'class'=>'form-control','required'));?>					
								  </div>	
								 <div class="form-group input_fields_wrap">
									<label> Answer First </label>
									 <button class="add_field_button">Add More Fields</button>
				                    <?php echo $this->Form->input('answer1', array('label'=>"",'type'=>'text','value'=> $question['Answer']['answer1'],'class'=>'form-control','required'));?>					
				                    <?php echo $this->Form->input('answer_id', array('label'=>"",'type'=>'hidden','value'=> $question['Answer']['id']));?>					
								  </div>		
								  <div class="form-group">
									<label> Right Answer </label>
									<select class="form-control" name="data[Question][right_question]">
										<option value="answer1" <?php if($question['Answer']['right_question'] == 'answer1') { echo "selected='selected'"; } ?>>Answer First </option>
										<option value="answer2" <?php if($question['Answer']['right_question'] == 'answer2') { echo "selected='selected'"; } ?>>Answer Second </option>
										<option value="answer3" <?php if($question['Answer']['right_question'] == 'answer3') { echo "selected='selected'"; } ?>>Answer Third</option>
										<option value="answer4" <?php if($question['Answer']['right_question'] == 'answer4') { echo "selected='selected'"; } ?>>Answer Fouth</option>										
									</select>
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
	<script>
	$(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
   
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div class="form-group" ><input type="text" class="form-control" name="mytext[]"/><a href="#" class="remove_field">Remove</a></div>'); //add input box
        }
    });
   
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
});
	</script>