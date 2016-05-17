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
            		<h1><i class='glyphicon glyphicon-user'></i> Account Settings</h1>
            		<h3>Dashboard <i class='icon-right-open-2'></i>Account Settings</h3> 
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
					<div class="col-md-12">
						<div class="widget">
							<div class="widget-header transparent">
								<h2><strong> Account </strong> Settings </h2>
								<div class="additional-btn">
									<a href="#" class="hidden reload"><i class="icon-ccw-1"></i></a>
									<a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
									<a href="#" class="widget-close"><i class="icon-cancel-3"></i></a>
								</div>
							</div>
							<div class="widget-content">
								<div class="table-responsive">
								<?php  echo $this->Form->create('Sitesetting',array("action" => "",'id' => 'mbc')); ?>
									<table data-sortable class="table table-hover table-striped">
										<thead>
											<tr>
												<!--th style="width: 30px" data-sortable="false"><input type="checkbox" class="rows-check"></th-->
												<th></th>
												<th><?php echo $this->Paginator->sort('title'); ?></th>
												<th><?php echo $this->Paginator->sort('web_url'); ?></th>
												<th><?php echo $this->Paginator->sort('keywords'); ?></th>
												<th><?php echo $this->Paginator->sort('facebook_url'); ?></th>
												<th><?php echo $this->Paginator->sort('twitter_url'); ?></th>
												<th><?php echo $this->Paginator->sort('site_email'); ?></th>
												<th data-sortable="false">Option</th>
											</tr>
										</thead>
										
										<tbody>
								            <?php foreach ($sitesettings as $sitesetting):?>		
											<tr>
												<td><?php // echo $this->Form->checkbox("use"+$sitesetting['sitesettings']['id'],array('value' => $sitesetting['Sitesetting']['id'],'class'=>'rows-check')); ?></td>
												<td><strong><?php echo h($sitesetting['Sitesetting']['title']); ?></strong></td>
												<td><strong><?php echo h($sitesetting['Sitesetting']['web_url']); ?></strong></td>
												<td><strong><?php echo h($sitesetting['Sitesetting']['keywords']); ?></strong></td>
												<td><strong><?php echo h($sitesetting['Sitesetting']['facebook_url']); ?></strong></td>
												<td><strong><?php echo h($sitesetting['Sitesetting']['twitter_url']); ?></strong></td>
												<td><strong><?php echo h($sitesetting['Sitesetting']['site_email']); ?></strong></td>
												<td>
												<form></form>
													<div class="btn-group btn-group-xs">
														<a href="<?php echo $this->Html->url(array('action' => 'edit', $sitesetting['Sitesetting']['id'])); ?>"data-toggle="tooltip" title="Edit" class="btn btn-default"><i class="fa fa-edit"></i></a>
													</div>
												</td>
											</tr>
											<?php endforeach; ?>
										</tbody>
									</table>
								</div>
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
      