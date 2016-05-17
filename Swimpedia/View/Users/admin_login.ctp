<!-- Modal Start -->

<!-- Modal Task Progress -->	

	<div class="md-modal md-3d-flip-vertical" id="task-progress">

		<div class="md-content">

			<h3><strong>Task Progress</strong> Information</h3>

			<div>

				<p>CLEANING BUGS</p>

				<div class="progress progress-xs for-modal">

				  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">

					<span class="sr-only">80&#37; Complete</span>

				  </div>

				</div>

				<p>POSTING SOME STUFF</p>

				<div class="progress progress-xs for-modal">

				  <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 65%">

					<span class="sr-only">65&#37; Complete</span>

				  </div>

				</div>

				<p>BACKUP DATA FROM SERVER</p>

				<div class="progress progress-xs for-modal">

				  <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 95%">

					<span class="sr-only">95&#37; Complete</span>

				  </div>

				</div>

				<p>RE-DESIGNING WEB APPLICATION</p>

				<div class="progress progress-xs for-modal">

				  <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 100%">

					<span class="sr-only">100&#37; Complete</span>

				  </div>

				</div>

				<p class="text-center">

				<button class="btn btn-danger btn-sm md-close">Close</button>

				</p>

			</div>

		</div>

	</div>

		

	<!-- Modal Logout -->

	<div class="md-modal md-just-me" id="logout-modal">

		<div class="md-content">

			<h3><strong>Logout</strong> Confirmation</h3>

			<div>

				<p class="text-center">Are you sure want to logout from this awesome system?</p>

				<p class="text-center">

				<button class="btn btn-danger md-close">Nope!</button>

				<a href="login.html" class="btn btn-success md-close">Yeah, I'm sure</a>

				</p>

			</div>

		</div>

	</div>        <!-- Modal End -->

	<!-- Begin page -->

	<div class="container">

		<div class="full-content-center">

			<p class="text-center"><a href="#"> <img src="<?php echo $this->webroot; ?>assets/img/login-logo.png" alt="Logo"></a></p>

			<?php $x=$this->Session->flash(); ?>

			<?php if($x){ ?>					

			<div class="alert alert-danger alert-dismissable" style="text-align:center">

				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

				<?php echo $x; ?><a href="#" class="alert-link"></a>

			</div>	

		   <?php } ?>	

			<div class="login-wrap animated flipInX">

				<div class="login-block">

					<div class="profile-img" style="width:150px height:100%;" ><img src="<?php echo $this->webroot; ?>images/users/swimpedia.png" class="img-circle not-logged-avatar"></div>

					<?php echo $this->Form->create('User',array('method'=>'post','id'=>'validate')); ?>

						<div class="form-group login-input">

						<i class="fa fa-user overlay"></i>

						<?php echo $this->Form->input('username',array('label'=>"",'placeholder'=>'Username','class'=>'form-control text-input','type'=>'text','required')); ?>

						<!--input type="text" class="form-control text-input" placeholder="Username"-->

						</div>

						<div class="form-group login-input">

						<i class="fa fa-key overlay"></i>

						<?php echo $this->Form->password('password',array('label'=>"",'placeholder'=>'********','class'=>'form-control text-input','type'=>'password','required')); ?>

						<!--input type="password" class="form-control text-input" placeholder="********"-->

						</div>

						

						<div class="row">

							<div class="col-sm-6">

							<button type="submit" class="btn btn-success btn-block">LOGIN</button>

							</div>

							<div class="col-sm-6">

							<a href="<?php echo $this->Html->Url(array('controller'=>'Users','action'=>'forget'));?>" class="btn btn-default btn-block">Forget Password</a>

							</div>

						</div>

					</form>

				</div>

			</div>

			

		</div>

	</div>

	<!-- the overlay modal element -->

	<div class="md-overlay"></div>

	<!-- End of eoverlay modal -->

	<script>

		var resizefunc = [];

	</script>