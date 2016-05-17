<!-- Left Sidebar Start -->
<div class="left side-menu">
	<div class="sidebar-inner slimscrollleft">
		<div class="clearfix"></div>
		<!--- Profile -->
		<div class="profile-info">
			<div class="col-xs-4">
			  <a href="<?php echo $this->Html->url(array('controller'=>'Users','action'=>'admin_profile')); ?>" class="rounded-image profile-image"><img src="<?php echo $this->webroot.'files' . DS . 'profileimage' . DS . $profile_image; ?>"></a>
			</div>
			<div class="col-xs-8">
				<div class="profile-text">Welcome <b><?php  echo $this->Session->read('Auth.User.first_name'); ?></b></div>
				<div class="profile-buttons">
				  <a href="javascript:;"><i class="fa fa-envelope-o pulse"></i></a>
				  <!--<a href="#connect" class="open-right"><i class="fa fa-comments"></i></a>-->
				<a href="<?php echo $this->Html->url(array('controller'=>'Users','action'=>'admin_logout')); ?>" title="Sign Out"><i class="fa fa-power-off text-red-1"></i></a>
				</div>
			</div>
		</div>
		<!--- Divider -->
		<div class="clearfix"></div>
			<hr class="divider" />
				<div class="clearfix"></div>
					<!--- Divider -->
					<div id="sidebar-menu">
						<ul>
							<li>
								<a href='<?php echo $this->Html->url(array('controller'=>'users','action'=>'admin_dashboard')); ?>' class='active'>
									<i class='icon-home-3'></i>
									<span>Dashboard</span> 
								</a>
							</li>
							<li class='has_sub'>
								<a href='javascript:void(0);'>
									<i class='fa fa-user'></i>
									<span>User Management</span> 
									<span class="pull-right">
										<i class="fa fa-angle-down"></i>
									</span>
								</a>
								<ul>
									<li>
										<a href='<?php echo $this->Html->url(array('controller'=>'Users','action'=>'admin_add')); ?>'>
											<span>Add User</span>
										</a>
									</li>
									<!--<li>
										<a href='<?php echo $this->Html->url(array('controller'=>'Users','action'=>'admin_add')); ?>'>
											<span>Add Admin</span>
										</a>
									</li>	-->								
									<li>
										<a href='<?php echo $this->Html->url(array('controller'=>'Users','action'=>'admin_index')); ?>'>
											<span>Manage Users</span>
										</a>
									</li>
								</ul>
							</li>		
							<li class='has_sub'>
								<a href='javascript:void(0);'>
									<i class='fa fa-magnet'></i>
									<span>Topic Management</span> 
									<span class="pull-right">
										<i class="fa fa-angle-down"></i>
									</span>
								</a>
								<ul>
									<li>
										<a href='<?php echo $this->Html->url(array('controller'=>'Topics','action'=>'admin_add')); ?>'>
											<span>Add Topic</span>
										</a>
									</li>
									<li>
										<a href='<?php echo $this->Html->url(array('controller'=>'Topics','action'=>'admin_index')); ?>'>
											<span>Manage Topics</span>
										</a>
									</li>
								</ul>
							</li>	
							<li class='has_sub'>
								<a href='javascript:void(0);'>
									<i class='fa fa-exchange'></i>
									<span>Question Management</span> 
									<span class="pull-right">
										<i class="fa fa-angle-down"></i>
									</span>
								</a>
								<ul>
									<li>
										<a href='<?php echo $this->Html->url(array('controller'=>'Topics','action'=>'admin_add_question_csv')); ?>'>
											<span>Add Question </span>
										</a>
									</li>
									<li>
										<a href='<?php echo $this->Html->url(array('controller'=>'Topics','action'=>'admin_questions_answers')); ?>'>
											<span>Manage Question </span>
										</a>
									</li>
								</ul>
							</li>	
							<li class='has_sub'>
								<a href='javascript:void(0);'>
									<i class='fa fa-exchange'></i>
									<span>Power Ups Management</span> 
									<span class="pull-right">
										<i class="fa fa-angle-down"></i>
									</span>
								</a>
								<ul>
									<li>
										<a href='<?php echo $this->Html->url(array('controller'=>'Topics','action'=>'admin_add_power_ups')); ?>'>
											<span>Add Power Ups </span>
										</a>
									</li>
									<li>
										<a href='<?php echo $this->Html->url(array('controller'=>'Topics','action'=>'admin_power_ups')); ?>'>
											<span>Manage Power Ups </span>
										</a>
									</li>
								</ul>
							</li>	
							<li class='has_sub'>
								<a href='javascript:void(0);'>
									<i class='fa fa-child'></i>
									<span>Customer Question Management</span> 
									<span class="pull-right">
										<i class="fa fa-angle-down"></i>
									</span>
								</a>
								<ul>
									<li>
										<a href='<?php echo $this->Html->url(array('controller'=>'Topics','action'=>'admin_customer_question')); ?>'>
											<span>Manage Customer Question </span>
										</a>
									</li>
								</ul>
							</li>
							<li class='has_sub'>
								<a href='javascript:void(0);'>
									<i class='fa fa-cog'></i>
									<span>Account Settings</span> 
									<span class="pull-right">
										<i class="fa fa-angle-down"></i>
									</span>
								</a>
								<ul>
									<li>
										<a href='<?php echo $this->Html->url(array('controller'=>'Sitesettings','action'=>'admin_index')); ?>'>
											<span>Manage Account</span>
										</a>
									</li>
								</ul>
							</li>
						</ul>
						<div class="clearfix"></div>
					</div>
					<div class="clearfix"></div>
					<div class="clearfix"></div><br><br><br>
					</div>
					<div class="left-footer">
						<div class="progress progress-xs">
						  <div class="progress-bar bg-green-1" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
							<span class="progress-precentage">80%</span>
						  </div>
						  
						  <a data-toggle="tooltip" title="See task progress" class="btn btn-default md-trigger" data-modal="task-progress"><i class="fa fa-inbox"></i></a>
						</div>
					</div>
		</div>
<?php 	// echo $this->Html->script(array('jquery-1.7.1.min','jquery.validate','jquery.form','jquery.tipTip','customcheckall')); ?>		
<!-- Left Sidebar End -->