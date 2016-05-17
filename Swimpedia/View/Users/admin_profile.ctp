<?php echo $this->element("admin_header"); ?>
<?php // echo $this->element("admin_topright"); ?>
<?php //echo $this->element("admin_nav"); ?>
<?php echo $this->element("admin_sidebar"); ?> 
<?php echo $this->element("admin_rightsidebar"); ?>
<?php echo $this->Html->script('jqueryValidate.js'); ?>
		<!-- Start right content -->
        <div class="content-page">
			<!-- Start Content here -->
			<div class="profile-banner" style="background-image: url(<?php echo $this->webroot; ?>images/stock/1epgUO0.jpg);">
				<div class="col-sm-3 avatar-container">
				    <?php 
                    if ($profile['User']['profile_image'] ==  NULL || $profile['User']['profile_image']=='0')	{
						echo $this->Html->image('default-user.png',array('class'=>'img-circle profile-avatar'));
                     }	else	{ 	echo $this->Html->image('/files/profileimage/'.$profile['User']['profile_image'],array('class'=>'img-circle profile-avatar'));} ?>
					<!--img src="<?php // echo $this->webroot; ?>images/users/user-256.jpg" class="img-circle profile-avatar" alt="User avatar"-->
				</div>
				<div class="col-sm-12 profile-actions text-right">
					<button type="button" class="btn btn-success btn-sm " data-toggle="modal" data-target="#edit_profile" data-whatever="@mdo"><i class="fa fa-check"></i> Edit Profile</button>
					<!--<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#change_password" data-whatever="@mdo"><i class="fa fa-envelope"></i> Change Password</button>-->
				</div>				
			</div>
            <div class="content">

				<div class="row">
					<div class="col-sm-3">
						<!-- Begin user profile -->
						<div class="text-center user-profile-2">
							<h4><?php echo ucfirst($profile['User']['first_name']);?>, <b><?php echo ucfirst($profile['User']['last_name']);?></b></h4>
							
							<h5>Administrator</h5>
							<ul class="list-group">
							  <li class="list-group-item">
								<span class="badge"><?php echo $profile['User']['username'];?></span>
								User Name
							  </li>
							  <li class="list-group-item">
								Contact No
								<span class="badge"><?php echo $profile['User']['contact'];?></span>
							  </li>
							</ul>								
								<!-- User button -->
						</div><!-- End div .box-info -->
						<!-- Begin user profile -->
					</div><!-- End div .col-sm-4 -->
					
					<div class="col-sm-9">
						<div class="widget widget-tabbed">
							<!-- Nav tab -->
							<ul class="nav nav-tabs nav-justified">
							  <li  class="active"><a href="#about" data-toggle="tab"><i class="fa fa-user"></i> About</a></li>
							</ul>
							<!-- End nav tab -->
							<!-- Tab panes -->
							<div class="tab-content">
							<!-- Tab about -->
								<div class="tab-pane active animated fadeInRight" id="about">
									<div class="user-profile-content">
										<h5><strong>ABOUT</strong> ME</h5>										
										<hr />
										<div class="row">
											<div class="col-sm-6">
												<h5><strong>My</strong> INFO</h5>
													<address>
														<strong>User Name</strong><br>
														<abbr title="Phone"><?php echo $profile['User']['username'];?></abbr>
													</address>
													<address>
														<strong>Email</strong><br>
														<a href="mailto:#"><?php echo $profile['User']['email']; ?></a>
													</address> 
																							
												<h5><strong>CONTACT</strong> ME</h5>
													<address>
														<strong>Phone</strong><br>
														<abbr title="Phone"><?php if($profile['User']['contact']== NULL || $profile['User']['contact']=='0'){echo "Not Mentioned";}else{ echo $profile['User']['contact']; }?></abbr>
													</address>
													<address>
														<strong>Email</strong><br>
														<a href="mailto:#"><?php echo $profile['User']['email']; ?></a>
													</address> 
										
											</div>
											<div class="col-sm-6">
												<h5><strong>My</strong> INFO</h5>
													<address>
														<strong>Phone</strong><br>
														<abbr title="Phone"><?php if($profile['User']['contact']== NULL || $profile['User']['contact']=='0'){echo "Not Mentioned";}else{ echo $profile['User']['contact']; }?></abbr>
													</address>
													<address>
														<strong>Email</strong><br>
														<a href="mailto:#"><?php echo $profile['User']['email']; ?></a>
													</address> 
													
																							
												<h5><strong>CONTACT</strong> ME</h5>
													<address>
														<strong>Phone</strong><br>
														<abbr title="Phone"><?php if($profile['User']['contact']== NULL || $profile['User']['contact']=='0'){echo "Not Mentioned";}else{ echo $profile['User']['contact']; }?></abbr>
													</address>
													<address>
														<strong>Email</strong><br>
														<a href="mailto:#"><?php echo $profile['User']['email']; ?></a>
													</address> 
											
											</div>
										</div><!-- End div .row -->
									</div><!-- End div .user-profile-content -->
								</div><!-- End div .tab-pane -->
								<!-- End Tab about -->
							</div><!-- End div .tab-content -->
						</div><!-- End div .box-info -->
					</div>
				</div>		
				<!--                                                        POP UP Edit Profile Start                   -->
				<div class="modal fade" id="edit_profile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					 <div class="modal-dialog">
					 <?php echo $this->Form->create('User',array('enctype'=>'multipart/form-data','id'=>'profile_update','url'=>array('controller'=>'Users','action'=>'profile_edit')));?>
								<?php echo $this->Form->input('id',array("type" =>"hidden",'value' =>$profile['User']['id']));?>
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="exampleModalLabel">Edit Profile</h4>
							</div>
							<div class="modal-body">
								
									<div class="form-group">
										<label for="recipient-name" class="control-label">User Name:</label>
									<?php echo $this->Form->input('username', array('label'=>"",'type'=>'text','value'=>$profile['User']['username'],'required'=>true, 'class'=>"form-control"));?>
									</div>
									<div class="form-group">
										<label for="recipient-name" class="control-label">First Name:</label>
									<?php echo $this->Form->input('first_name', array('label'=>"",'type'=>'text','value'=>$profile['User']['first_name'],'required'=>true, 'class'=>"form-control"));?>
									</div>
									<div class="form-group">
										<label for="recipient-name" class="control-label">Last Name:</label>
										<?php echo $this->Form->input('last_name', array('label'=>"",'type'=>'text','value'=>$profile['User']['last_name'],'required'=>true, 'class'=>"form-control"));?>
									</div>
									<div class="form-group">
										<label for="recipient-name" class="control-label">Email:</label>
										<?php echo $this->Form->input('email', array('label'=>"",'type'=>'text','value'=>$profile['User']['email'],'required'=>true, 'class'=>"form-control"));?>
									</div>
									<div class="form-group">
										<label for="recipient-name" class="control-label">Contact:</label>
											<?php echo $this->Form->input('contact', array('label'=>"",'type'=>'text','value'=>$profile['User']['contact'],'required'=>true, 'class'=>"form-control"));?>
									</div>
									<div class="form-group">
										<label for="recipient-name" class="control-label">Image:</label>
										<?php echo $this->Form->input('User.profile_image', array('label'=>"",'type'=>'file')); ?>
											<?php 
											if($profile['User']['profile_image']== NULL || $profile['User']['profile_image']==''){
											   echo $this->Html->image('admin.png',array('height'=>'auto','width'=>'100px'));
											 }else{ echo $this->Html->image('/files/profileimage/'.$profile['User']['id'].$profile['User']['profile_image'],array('height'=>'auto','width'=>'100px'));} ?>
									</div>
								
						  </div>
						  <div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								<button type="submit" value="Save" class="btn btn-primary">Save</button>
						  </div>
						</div>
						<?php echo $this->Form->end(); ?>
					</div>
					
				</div>
		<!--                                                        POP UP Edit Profile End                   -->
		<!--                                                        POP UP Change Password Start                   -->
				<div class="modal fade" id="change_password" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					 <div class="modal-dialog">
					 <?php echo $this->Form->create('User',array('id'=>'profile_update','url'=>array('controller'=>'Users','action'=>'changepass')));?>
								<?php echo $this->Form->input('id',array("type" =>"hidden",'value' =>$profile['User']['id']));?>
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="exampleModalLabel">Change Password</h4>
							</div>
							<div class="modal-body">
								<form>
									<div class="form-group">
										<label for="recipient-name" class="control-label">Old Password:</label>
										<?php echo $this->Form->input('opass', array('label'=>"",'type'=>'text','class'=>'form-control','Placeholder'=>'Old Password...','type'=>'password','required'));?>
									</div>
									<div class="form-group">
										<label for="recipient-name" class="control-label">New Password:</label>
										<?php echo $this->Form->input('password', array('label'=>"",'type'=>'text','class'=>'form-control','Placeholder'=>'New Password...','type'=>'password','required'));?>
									</div>
									<div class="form-group">
										<label for="recipient-name" class="control-label">Confirm Password:</label>
											<?php echo $this->Form->input('cpass', array('label'=>"",'type'=>'text','class'=>'form-control','Placeholder'=>'Confirm Password...','type'=>'password','required'));?>
									</div>
								</form>
						  </div>
						  <div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								<button type="submit" value="save" class="btn btn-primary">Save</button>
						  </div>
						</div>
						<?php echo $this->Form->end(); ?>
					</div>
				</div>
		<!--                                                        POP UP Change Password End                   -->
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
<script>
$(function() {
		
		
		$('#image').bind('change',function(){
		
				var imagePath = $('#image').val();//document.FormTwo.picFile.value;
				var pathLength = imagePath.length;
				var lastDot = imagePath.lastIndexOf(".");
				var fileType = imagePath.substring(lastDot,pathLength);	
				var fileType = fileType.toLowerCase();
				
				$('#file_hidden').val(imagePath); 

				
			});
		
	});

</script>    

<script type="text/javascript">


</script>
<style>
.errors
{
	color:red;
}
</style>