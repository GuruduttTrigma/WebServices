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
                 <li class="current"><a href="javascript:void:(0)">Crop Video</a></li>
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
			<div class="whead"><h6>Crop Video</h6></div>
				<div id="dyn" class="hiddenpars">
				<?php echo $this->Form->create('AllVideos',array('url'=>'crop_video/'.$info['AllVideo']['id'],'type'=>'file','id'=>'validate')); ?>    
					<div class="formRow">
						<div class="grid3"><label>Uploaded Video:<em class="astresik">*</em></label></div>
						<div class="grid9">
							<video id="myVideo" class="rrr" width="320" height="176" controls>
								<source src="<?php echo $this->webroot.'files'.DS.'full_videos'.DS.$info['AllVideo']['full_video'];?>" type="video/mp4">
								<source src="<?php echo $this->webroot.'files'.DS.'full_videos'.DS.$info['AllVideo']['full_video'];?>" type="video/ogg">
								Your browser does not support HTML5 video.
							</video>
							<div>
								<b>Seeked position:</b> <span id="demo"></span>
								<input type="hidden" id="cropVideoStart" name="data[cropVideoStart]" value="0">
								<input type="hidden" id="cropVideoEnd" name="data[cropVideoEnd]" value="30">
							</div>
							<script>
								// Get the video element with id="myVideo"
								var vid = document.getElementById("myVideo");	
								var vid1 = document.getElementById("myVideo");	
								// Attach a seeking event to the video element, and execute a function if a seek operation begins
								vid.addEventListener("seeking", myFunction);
								//document.getElementById("demo1").innerHTML = Math.floor(vid.duration);
								function myFunction() {
									// Display the current position of the video in a p element with id="demo"
									document.getElementById("demo").innerHTML = Math.floor(vid.currentTime);
									$("#cutvideo").val(Math.floor(vid.currentTime));
									//document.getElementById("demo1").innerHTML = Math.floor(vid.duration);
								}
							</script>
						</div>
						<?php if ($info['AllVideo']['duration'] >=30) {?>
						<div class="grid9">
						<p>
							<label for="amount">Crop Video:</label>
							<input type="text" id="amount" name="videoCropTime" readonly style="border:0; color:#f6931f; font-weight:bold;">
							<div id="slider-range"></div>
						</p>
						</div>
						<?php } else {?>
						<div class="grid9">
						<p>
							<label for="amount">Video duration is <?php echo $info['AllVideo']['duration'];  ?> no need to crop.</label>
						</p>
						</div>
						<?php } ?>
						<div class="grid9">
							<label for="amount">Cut Thumbnail:</label>
								<input type="text" id="cutvideo" name="data[thumbnailTime]" value="1" readonly>
							<div id="slider"></div>
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
				</form>    
			</div>            
        </div>        
    </div>
</div>
<script>
$(document).ready(function(){
		var vid = document.getElementById("myVideo");
		var video_duration =vid.duration;		
   });
</script>
<script>
	$(function() {
		$( "#slider-range" ).slider({
			range: true,
			min: 1,
			max: <?php echo $info['AllVideo']['duration']; ?>,
			values: [ 0, 30 ],
			slide: function( event, ui ) {
				var startVal = ui.values[ 0 ];
				var lastVal = ui.values[ 1 ];
				//var endVal = startVal + lastVal;
				//console.log(startVal);
				//console.log(endVal);
				$( "#amount" ).val( startVal + " - to" + lastVal );
				vid.currentTime = startVal;
				$( "#cropVideoStart" ).val( startVal);
				$( "#cropVideoEnd" ).val( lastVal);
			}
		});
		$( "#amount" ).val( $( "#slider-range" ).slider( "values", 0 ) +
		" - to" + $( "#slider-range" ).slider( "values", 1 ) );	
		
	});
</script>
<script>
	$(function() {
		$( "#slider" ).slider({
			range: false,
			min: 1,
			max: <?php echo $info['AllVideo']['duration']; ?>,
			values: [ 0],
			slide: function( event, ui ) {
				var startVal = ui.values[ 0 ];
				$( "#amount1" ).val( startVal);
				$( "#demo12" ).val( startVal);
				vid1.currentTime = startVal;
			}
		});
		$( "#amount1" ).val( "$" + $( "#slider" ).slider( "values", 0 ) ) ;
	});
</script>
<style>
 body {

	font-family: "Trebuchet MS", "Helvetica", "Arial",  "Verdana", "sans-serif";

	font-size: 62.5%;

}
</style>


