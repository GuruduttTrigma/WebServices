<?php echo $this->element("admin_header"); ?>
<?php echo $this->element("admin_topright"); ?>
<?php echo $this->element("admin_nav"); ?>
<?php echo $this->element("admin_sidebar"); ?> 

<div id="content">
    <div class="contentTop">
        <span class="pageTitle"><span class="icon-screen"></span>Video Management</span>
        <ul class="quickStats">
            <li>
                <a href="" class="blueImg"><img src="images/icons/quickstats/plus.png" alt="" /></a>
                <div class="floatR"></div>
            </li>
        </ul>
    </div>
     <!-- Breadcrumbs line --> 
    <div class="breadLine">
        <div class="bc">
            <ul id="breadcrumbs" class="breadcrumbs">
                <li><a href="<?php echo $this->Html->url(array('controller'=>'Users','action'=>'admin_dashboard')); ?>">Dashboard</a></li>
				       <li><a href="<?php echo $this->Html->url(array('controller'=>'Categories','action'=>'admin_index')); ?>">Video Management</a></li>
                 <li class="current"><a href="javascript:void:(0)">Add New Video</a></li>
            </ul>
        </div>
    </div>
    
    <!-- Main content -->
    <div class="wrapper">
     <?php $x=$this->Session->flash(); ?>
     <?php 
	 if($x){ ?>
     <div class="nNote nSuccess" id="flash">
       <div class="alert alert-success" style="text-align:center" ><?php echo $x; ?></div>
     </div><?php } ?>
      <div class="widget fluid">
        <div class="whead"><h6>Add Video</h6></div>
		   <?php  //echo $this->Form->create('AllVideo', array('url' => array('controller' => 'AllVideos', 'action' => 'add_video','admin' => true)),array('type' => 'file', 'enctype' => 'multipart/form-data')); ?>
			<?php echo $this->Form->create('AllVideo',array('enctype' => 'multipart/form-data', 'id' => 'validate', 'url'=>array('controller'=>'AllVideos','action'=>'add_video','admin'=>true) ) );  ?>
			<div id="dyn" class="hiddenpars">          
                <div class="formRow">
                    <div class="grid3"><label>User Name :</label></div>
                    <div class="grid9">
					 <?php 	
						echo $this->Form->input('username', array(
						'id'      => 'id',
						'label'	=> false,	
						'type'    => 'select',
						'options' => $user,
						'empty'   => 'Select User',
						'required'=>true
						));
					?> 
                    </div>
                </div>         
				<div class="formRow">
                    <div class="grid3"><label>Category Name :</label></div>
                    <div class="grid9">
					<?php 	
						echo $this->Form->input('Category_name', array(
						'id'      => 'Category_id',
						'label'	=> false,	
						'type'    => 'select',
						'options' => $Category,
						'empty'   => 'Select Category',
						'required'=>true
						));
					?>
                    </div>
                </div>                  
				<div class="formRow">
                    <div class="grid3"><label>Video Description:</label></div>
                    <div class="grid9">
                    <?php echo $this->Form->input('description',array('label'=>'','required','type'=>'textarea'));?>
                    </div>
                </div> 
                <div class="formRow">
                    <div class="grid3"><label>Video:<em class="astresik">*</em></label></div>
                    <div class="grid9">
                    <?php echo $this->Form->input('video', array('label'=>"",'type'=>'file','class'=>'validate1[required]','id'=>'fuPhoto1','required'));?>
					<p><div id="myLabel" style="color:red;"></div></p>
                    </div>
                </div> 			
                
                <div class="formRow">
                    <div class="grid3"><label></label></div>
                    <div class="grid2">
                    <button type="submit" id="update" class="buttonS bLightBlue" >Save</button>
                    </div>
					<div class="grid2">
                    <a href="<?php echo $this->webroot; ?>admin/categories/index" class="buttonS bLightBlue" >Cancel</a>
                    </div>
                </div>        
        </div>  
          </form>
        </div>        
    </div>
</div>
<script type="text/javascript">
   $(document).ready(function(){
       $('#validate').validate();
	     $('#fuPhoto').change(
            function () {
                var fileExtension = ['jpeg', 'jpg','mov','mp4',];
                if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                    $('#myLabel').html("Only '.jpeg','.jpg','.mp4' formats are allowed.");
                }
                else {
                    $('#myLabel').html(" ");
                } 
            })  
   });
</script>