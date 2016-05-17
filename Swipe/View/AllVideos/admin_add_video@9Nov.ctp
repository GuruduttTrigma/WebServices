<?php echo $this->element("admin_header"); ?>
<?php echo $this->element("admin_topright"); ?>
<?php echo $this->element("admin_nav"); ?>
<?php echo $this->element("admin_sidebar"); ?> 
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">
<script>
	$(function() {
		$( "#slider-range" ).slider({
			range: true,
			min: 0,
			max: Math.floor(vid.duration),
			values: [ 0, 30 ],
			slide: function( event, ui ) {
				var startVal = ui.values[ 0 ];
				var lastVal = ui.values[ 1 ];
				//var endVal = startVal + lastVal;
				//console.log(startVal);
				//console.log(endVal);
				$( "#amount" ).val( startVal + " - to" + lastVal );
				vid.currentTime = startVal;
			}
		});
		$( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
		" - $" + $( "#slider-range" ).slider( "values", 1 ) );
	});
</script>
<script type="text/javascript">
   $(document).ready(function(){
       $('#validate').validate();
	     $('#fuPhoto').change(
            function () {
                var fileExtension = ['mov','mp4',];
                if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                    $('#myLabel').html("Only  '.mov','.mp4' formats are allowed.");
                }
                else {
                    $('#myLabel').html(" ");
                } 
            })  
   });
</script>
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
        <div id="dyn" class="hiddenpars">
             <?php echo $this->Form->create('AllVideos',array('action'=>'admin_add_video','type'=>'file','id'=>'validate')); ?>
                <div class="formRow">
                    <div class="grid3"><label>User Name :</label></div>
                    <div class="grid9">
					 <?php 	
						echo $this->Form->input('username', array(
						'id'      => 'id',
						'label'	=> false,	
						'type'    => 'select',
						'options' => $user,
						'empty'   => 'Choose Types',
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
						'empty'   => 'Choose Types',
						'required'=>true
						));
					?>
                    </div>
                </div>          
                <div class="formRow">
                    <div class="grid3"><label>Video Title:</label></div>
                    <div class="grid9">
                    <?php echo $this->Form->input('title',array('label'=>'','required'));?>
                    </div>
                </div>           
				<div class="formRow">
                    <div class="grid3"><label>Video Description:</label></div>
                    <div class="grid9">
                    <?php echo $this->Form->input('description',array('label'=>'','required','type'=>'textarea'));?>
                    </div>
                </div> 
                <div class="formRow">
                    <div class="grid3"><label>Upload Video:<em class="astresik">*</em></label></div>
                    <div class="grid9">
                    <?php echo $this->Form->input('video', array('label'=>"",'type'=>'file','class'=>'validate[required]','id'=>'fuPhoto','required'));?>
					<p><div id="myLabel" style="color:red;"></div></p>
                    </div>
                </div> 	
					<div class="formRow">
                    <div class="grid3"><label>Uploaded Video:<em class="astresik">*</em></label></div>
						<div class="grid9">
							<video id="myVideo" width="320" height="176" controls>
								<source src="" type="video/mp4">
								<source src="http://dev414.trigma.us/N-166/files/full_videos/1446831540full_video.mov" type="video/ogg">
								Your browser does not support HTML5 video.
							</video>
							<div>
								<b>Seeked position to thumbnail:</b> <span id="demo"></span>
							</div>

					<script>
						// Get the video element with id="myVideo"
						var vid = document.getElementById("myVideo");
						
						// Attach a seeking event to the video element, and execute a function if a seek operation begins
						vid.addEventListener("seeking", myFunction);
						//document.getElementById("demo1").innerHTML = Math.floor(vid.duration);
						function myFunction() {
							// Display the current position of the video in a p element with id="demo"
							document.getElementById("demo").innerHTML = Math.floor(vid.currentTime);
							//document.getElementById("demo1").innerHTML = Math.floor(vid.duration);
						}
					</script>
			<!--  ------------------------- ->
			
			
			<!-- range video -->
			
			
			
			
		
			<!-- range ends -->
			
			
                    </div>
					<p>
<label for="amount">Crop Video:</label>
<input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
</p>
<div id="slider-range"></div>
                </div> 					
             
                <div class="formRow">
                    <div class="grid3"><label></label></div>
                    <div class="grid2">
                    <button type="submit" name="Save" id="update" class="buttonS bLightBlue" >Save</button>
                    </div>
					<div class="grid2">
                    <a href="<?php echo $this->webroot; ?>admin/categories/index" class="buttonS bLightBlue" >Cancel</a>
                    </div>
                </div>
           </form>
     
        </div>  
          
        </div>        
    </div>
</div>     
