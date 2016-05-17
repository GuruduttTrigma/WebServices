<?php 	echo $this->Html->script(array('customcheckall')); ?>
<?php echo $this->element("admin_header"); ?>
<?php // echo $this->element("admin_topright"); ?>
<?php // echo $this->element("admin_nav"); ?>
<?php echo $this->element("admin_sidebar"); ?> 
<?php echo $this->element("admin_rightsidebar"); ?> 
        <div class="content-page">
            <div class="content">
            	<!-- Page Heading Start -->
				<div class="page-heading">
            		<h1><i class='glyphicon glyphicon-user'></i>Customer Questions Management <?php //pr($this->Math->add()); ?></h1>
            		<h3>Dashboard <i class='icon-right-open-2'></i>Customer Questions Management</h3> 
					<?php $x=$this->Session->flash(); ?>
                    <?php if($x){ ?>					
					<div class="alert alert-danger alert-dismissable" style="text-align:center">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
						<?php echo $x; ?><a href="#" class="alert-link"></a>
					</div>	
                   <?php } ?>					
				</div>
            	<!-- Page Heading End-->	
				<div class="row">
					<div class="col-md-12">
						<div class="widget">
							<div class="widget-header transparent">
								<h2><strong>Customer Questions </strong> Management </h2>
								<div class="additional-btn">
									<a href="#" class="hidden reload"><i class="icon-ccw-1"></i></a>
									<a href="#" class="widget-toggle"><i class="icon-down-open-2"></i></a>
									<a href="#" class="widget-close"><i class="icon-cancel-3"></i></a>
								</div>
							</div>
							<div class="widget-content">
																
								<div class="table-responsive">
								<?php  echo $this->Form->create('User',array('id' => 'mbc')); ?>
									<table data-sortable class="table table-hover table-striped  tDefault tMedia">
										<thead>
											<tr>
												<!--<th style="width: 30px" data-sortable="false"><input title="Select All" class="tool-tip" id="titleCheck" name="titleCheck" type="checkbox"></th>-->
												<th>No</th>
												<th>Question</th> 
												<th>Right Answer</th> 
												<th data-sortable="false">Option</th>
											</tr>
										</thead>
										
										<tbody>
										<?php if(!empty($contents))  { ?>
								            <?php 
											$i =1 ;	foreach ($contents as $user): ?>		
											<tr>
												<!--<td><?php echo $this->Form->checkbox("use"+$user['Question']['id'],array('value' => $user['Question']['id'],'class'=>'checkAll')); ?></td>-->
												<td><?php echo $i; ?></td>
												<td><strong><?php echo h($user['CustomerQuestion']['question']); ?></strong></td>
												<td>
													<strong>
													<?php 
													foreach ($user['CustomerQuestionAnswer'] as $info) {
														if($info['right_question'] == 1) {
															echo $info['answer'];
														}
													}
													?>
													</strong>
												</td>
												<td>
												<form></form>
													<div class="btn-group btn-group-xs">
														<a href="<?php echo $this->Html->url(array('action' => 'view_customer_answer', $user['CustomerQuestion']['id'])); ?>"data-toggle="tooltip" title="View" class="btn btn-default"><i class="fa fa-eye"></i></a>
														<a href="<?php echo $this->Html->url(array('action' => 'customer_question_delete', $user['CustomerQuestion']['id'])); ?>" data-toggle="tooltip" title="Delete" class="btn btn-default"><i class="fa fa-remove"></i></a>
														<a href="<?php echo $this->Html->url(array('action' => 'select_topic', $user['CustomerQuestion']['id'])); ?>"data-toggle="tooltip" title="Select Topic" class="btn btn-default"><i class="fa fa-paper-plane"></i></a>
													</div>
												</td>
											</tr>
											<?php $i++; endforeach; ?>
											<?php } else { ?>
											<tr>
												<td>No record found</td>
											<tr>
											<?php } ?>
										</tbody>
									</table>
								</div>
									
								<div class="data-table-toolbar">
									<ul class="pagination">
										<li><?php if($this->Paginator->hasPrev()){ echo $this->Paginator->prev(__('Previous'), array('tag' => false)); } ?></li>
										<li><?php echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li' ,'currentClass' => 'active', 'currentTag' => 'a' , 'escape' => false)); ?></li>
										<li><?php if($this->Paginator->hasNext()){ echo $this->Paginator->next(__('Next'), array('tag' => false)); } ?></li>   
									</ul>
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
	<script>
		$(function(){
			$(".stausChange").click(function(){
			var arr = $(this).next().val();
			if(confirm("Are you sure you want to Update status?")){
					$.ajax({
								type:'POST',
								dataType: 'json',
								url:'<?php echo Router::url(array('controller'=>'Topics','action'=>'admin_activate_ajax')); ?>',
								 data: {'User':arr},
								success:function(result){
									window.location.reload();
								}
							});		
					return false;
				}
			});
		});
	</script>

<script type="text/javascript">
function deleteAll() {
    var anyBoxesChecked = false;
	var arr = new Array();
	$('#mbc input[type="checkbox"]').each(function() {
        if ($(this).is(":checked")) {
			arr.push($(this).val());
			anyBoxesChecked = true;
        }
    });
    if (anyBoxesChecked == false) {
		alert('Please select at least one checkbox to delete User.');
		return false;
    } else {				
		if(confirm("Are you sure you want to delete seleted User?")){
			$.ajax({
						type:'POST',
						dataType: 'json',
						url:'<?php echo Router::url(array('controller'=>'Topic','action'=>'admin_deleteall')); ?>',
						 data: {'User':arr},
						success:function(result){
                             $('.checkAll').attr("checked", false);
							$('#titleCheck').attr("checked", false);
							window.location.reload();
						}
					});		
					return false;
		}	
			return false;
	} 
}
//end of func deleteAll//

function activateAll() {
    var anyBoxesChecked = false;
	var arr = new Array();
	$('#mbc input[type="checkbox"]').each(function() {
        if ($(this).is(":checked")) {
			arr.push($(this).val());
			anyBoxesChecked = true;
        }
    });
    if (anyBoxesChecked == false) {
		alert('Please select at least one checkbox to activate User.');
		return false;
    } else {
		if(confirm("Are you sure you want to activate selected User?")){
				$.ajax({
					type:'POST',
					dataType: 'json',
					url:'<?php echo Router::url(array('controller'=>'Topic','action'=>'admin_activateall')); ?>',
					 data: {'User':arr},
					success:function(result){
						$('.checkAll').attr("checked", false);
						$('#titleCheck').attr("checked", false);
						window.location.reload();
					}
				});
				return true;
		}	
	}	
}//end of func activateAll//
function deactiveAll() {
    var anyBoxesChecked = false;
	var arr = new Array();
	$('#mbc input[type="checkbox"]').each(function() {
        if ($(this).is(":checked")) {
			arr.push($(this).val());
			anyBoxesChecked = true;
        }
    });

    if (anyBoxesChecked == false) {
		alert('Please select at least one checkbox to deactivate User.');
		return false;
    } else {
		if(confirm("Are you sure you want to deactivate the seleted User?")){
			$.ajax({
				type:'POST',
				dataType: 'json',
				url:'<?php echo Router::url(array('controller'=>'Topic','action'=>'admin_deactivateall')); ?>',
				 data: {'User':arr},
				success:function(result){
					$('.checkAll').attr("checked", false);
					$('#titleCheck').attr("checked", false);
					window.location.reload();
				}					
			});
			return false;
		}	
		return false;
	}
}
//end of func deactiveAll//
</script>