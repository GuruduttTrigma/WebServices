<?php echo $this->element('top-header'); ?>
<style>
.top-div{
border:1px solid #D4D0C8;height:300px; margin-left:75px;
}
.img-con{
float:left;height:80%;width:30%;margin-left:75px;margin-top:50px;
}
.name-con{
float:left;margin-left:20px;margin-top:50px;width:30%;
}
.background{
loat:left;border:1px solid #D4D0C8;margin-left:75px;margin-top:10px;
}
.recomand{
font-size:23px;height:60px;border:1px solid #D4D0C8;width:100%;background-color:white;margin-top:20px;cursor:pointer;
}
</style>
<div class="row-fluid" style="margin-top:5px;">
 <div class="span8" style="background-color:white;">
 <div class="top">
 <!-- ------------sharing-------------- -->
 <div class="top-div">
 <a href="#edit" style="float: right; padding:5px; " role="button" data-toggle="modal" style="cursor:pointer;" title="Edit"><i class="icon-pencil"></i></a>
 <div class="img-con">
 <?php if($profile['User']['profile_image']==NULL || $profile['User']['profile_image']== '0'){
 echo $this->Html->image('profile.png',array('height'=>'150px','width'=>'150px'));
}else{
 echo $this->Html->image('../files/profileimage/'.$profile['User']['profile_image'],array('style'=>'height: 200px; width:170px; margin-top:26px;'));
} ?>
 </div>
 <div class="name-con">
 <h1>
 <?php echo ucwords($profile['User']['first_name']); ?>
<?php echo ucwords($profile['User']['last_name']); ?>
 </h1>   

 <span style="font-size:20px;"><?php echo ucwords($profile['User']['exp_title']); ?><br/>
 <?php echo ucwords($profile['User']['exp_company_name']); ?>
 </span><br/>
 <span style="font-size:20px;"><?php echo ucwords($profile['User']['edu_degree']); ?><br/>
 <?php echo ucwords($profile['User']['edu_school']); ?><br/>
 <?php echo ucwords($profile['User']['edu_fieldofstudy']); ?>
 </span>
 </div>  
 </div>
 
 <!-- ------------activity--------------------- -->
 <div style="margin-top:5px;  margin-left:75px; box-shadow:5px 5px 5px; font-size:23px;">
     <div style="background-color:#5A595A; color:white; padding:10px;"><b>Activity</b>
     <span style="float:right; margin:8px;"><a id="activity" class=" icon-pencil" style="margin-bottom:3px;cursor:pointer;"></a></span></div>
   <div id="editactivity" style="display:none;">
    Your Activities will display here.
    <button id="act_cancel" class="btn">Cancel</button>
    </div>
 </div>
  <!-- --------background------------------- -->
   <div class="background">   
    <div style="margin-top:5px; height:40px;  background-color:#5A595A;color:white;font-size:23px;padding-top:5px;padding-left:10px;"><b>Background</b><span class="upPRc" style="color:green;font-size:10px;"></span></div>
    <!-- ------------------summary-------------------- -->
   <div  style="margin-top:30px;">
   <span style="font-size:23px;"><?php echo $this->Html->image('summary.png',array('height'=>'50px','width'=>'50px')); ?>Summary </span>
   <i class="icon-pencil" id="summary" style="cursor:pointer; float:right; margin:8px;" title="Edit Summary"></i></div>
   <div id="showsummary">
   <p align="justify" class="well"><?php echo $profile['User']['summary']; ?></p>
   </div>
   <div id="editsummary" style="display:none;">
   <?php echo $this->Form->create('User',array('action'=>'edit','method'=>'post','class'=>'form-horizontal edit')); ?>
   <div class="control-group">
   <?php echo $this->Form->input('user_id',array("label" => "",'type'=>'hidden','value'=>$user_id)); ?>
     <label class="control-label">Summary:</label>
	  <div class="controls">
		<?php echo $this->Form->input('summary',array('label'=>"",'type'=>'textarea','value'=>$profile['User']['summary'])); ?>
	  </div>
  </div><br/><br/><br/><br/><br/>
  <div class="control-group">
	  <div class="controls">
		<button type="submit" name="save" id="update" class="btn btn-primary save" style="margin-left:40px;">Save</button>
     <button id="sum_cancel" class="btn">Cancel</button>
	  </div>
  </div>
   
   </form>
   </div>
   <!-- --------------------experiance---------------- -->
   <div  style="margin-top:30px;">
   <span style="font-size:23px;"><?php echo $this->Html->image('experiance.png',array('height'=>'50px','width'=>'50px')); ?>Experiance </span>
   <i class="icon-pencil" id="experiance" style="cursor:pointer; float:right; margin:8px;" title="Edit Experiance"></i>
<div id="ajax"><img src="img/ajax-loader.gif"/></div></div>
   <div id="showexperiance" class="well">
   <a href="<?php echo $this->Html->url(array('controller'=>'companies','action'=>'view',$profile['User']['exp_company_name'])); ?>">
   <?php echo "<b>".$profile['User']['exp_company_name']."</b>" ; ?></a><br/>
<?php echo $profile['User']['exp_title'].",".$profile['User']['exp_location']."<br/>".
 $profile['User']['exp_time_from']."-".$profile['User']['exp_time_to'];?><br/>
 <p align="justify" class="well"><?php echo $profile['User']['exp_description']; ?></p>
 </div>
   <div id="editexperiance"  style="display:none;">
   <?php echo $this->Form->create('User',array('action'=>'edit','method'=>'post','class'=>'form-horizontal edit')); ?>
   <?php echo $this->Form->input('user_id',array("label" => "",'type'=>'hidden','value'=>$user_id)); ?>
   <div class="control-group">
     <label class="control-label">Company Name:</label>
	  <div class="controls">
		<?php echo $this->Form->input('exp_company_name',array('label'=>"",'value'=>$profile['User']['exp_company_name'],'id'=>'tags')); ?>
	  </div>
  </div>
  <div class="control-group">
    <label class="control-label">Title:</label>
	<div class="controls">
		<?php  echo $this->Form->input('exp_title',array('label'=>"",'value'=>$profile['User']['exp_title']));?>
	</div>
  </div>
  <div class="control-group">
    <label class="control-label">Location:</label>
	<div class="controls">
		<?php  echo $this->Form->input('exp_location',array('label'=>"",'value'=>$profile['User']['exp_location']));?>
	</div>
  </div>
  <div class="control-group">
    <label class="control-label">Time Period  From:</label>
	<div class="controls">
	<?php  echo $this->Form->input('exp_time_from',array('label'=>"",'id'=>"from",'value'=>$profile['User']['exp_time_from']));?>to
	<?php  echo $this->Form->input('exp_time_to',array('label'=>"",'value'=>$profile['User']['exp_time_to']));?>
	</div>
  </div>
  <div class="control-group">
    <label class="control-label">Description:</label>
	<div class="controls">
		<?php  echo $this->Form->input('exp_description',array('label'=>"",'value'=>$profile['User']['exp_description']));?>
	</div>
  </div>
  <br/><br/><br/><br/><br/>
  <div class="form-actions">
     <button type="submit" name="save" id="update" class="btn btn-primary save" style="margin-left:40px;">Save</button>
     <button id="exp_cancel" class="btn">Cancel</button>
</div>
</form>
   </div>
   <!-- ---------------------education----------------- -->
     <div  style="margin-top:30px;">
     <span style="font-size:23px;"><?php echo $this->Html->image('education.png',array('height'=>'50px','width'=>'50px')); ?>Education </span>
     <i class="icon-pencil" id="education" style="cursor:pointer; float:right; margin:8px;" title="Edit education"></i></div>
  <div id="showeducation" class="well">
  <?php echo "<b>".$profile['User']['edu_school']."</b><br/>,".$profile['User']['edu_degree'].",".$profile['User']['edu_fieldofstudy'].",".$profile['User']['edu_grade'].",<br/>".$profile['User']['edu_activities']; ?>

  </div>
   <div id="editeducation"  style="display:none;">
   <?php echo $this->Form->create('User',array('action'=>'edit','method'=>'post','class'=>'form-horizontal edit')); ?>
   <?php echo $this->Form->input('user_id',array("label" => "",'type'=>'hidden','value'=>$user_id)); ?>
   <div class="control-group">
     <label class="control-label">School:</label>
	  <div class="controls">
		<?php echo $this->Form->input('edu_school',array('label'=>"",'value'=>$profile['User']['edu_school'])); ?>
	  </div>
  </div>
  <div class="control-group">
    <label class="control-label">Degree:</label>
	<div class="controls">
		<?php  echo $this->Form->input('edu_degree',array('label'=>"",'value'=>$profile['User']['edu_degree']));?>
	</div>
  </div>
  <div class="control-group">
    <label class="control-label">Field of Study:</label>
	<div class="controls">
		<?php  echo $this->Form->input('edu_fieldofstudy',array('label'=>"",'value'=>$profile['User']['edu_fieldofstudy']));?>
	</div>
  </div>
  <div class="control-group">
    <label class="control-label">Grade:</label>
	<div class="controls">
	<?php  echo $this->Form->input('edu_grade',array('label'=>"",'value'=>$profile['User']['edu_grade']));?>
		</div>
  </div>
  <div class="control-group">
    <label class="control-label">Activities & Societies:</label>
	<div class="controls">
		<?php  echo $this->Form->input('edu_activities',array('label'=>"",'value'=>$profile['User']['edu_activities']));?>
	</div>
  </div>
  <br/><br/><br/><br/><br/>
  <div class="form-actions">
     <button type="submit" name="save" id="update" class="btn btn-primary save" style="margin-left:40px;">Save</button>
     <button id="edu_cancel" class="btn">Cancel</button>
</div>
</form>
   </div>
   
   
   </div>
 <!-- ----------updates--------------- -->
 <div>
 </div></div>
</div>
<div class="span4" style="margin-left:5px;">
<legend><span style="font-size:25px;"><b>Recommended for you</b></span></legend>
<div id="activity" class="recomand">
<?php echo $this->Html->image('experiance.png',array('height'=>'50px','width'=>'50px')); ?>Activity <i class="icon-pencil" style="float: right; margin:10px;" title="Edit Activity"></i></div>
<div id="summary" class="recomand"><?php echo $this->Html->image('summary.png',array('height'=>'50px','width'=>'50px')); ?>Summary<i class="icon-pencil" style="float: right; margin:10px;" title="Edit Summary"></i></div>
<div id="experiance" class="recomand"><?php echo $this->Html->image('experiance.png',array('height'=>'50px','width'=>'50px')); ?>Experiance<i class="icon-pencil" style="float: right; margin:10px;" title="Edit Experiance"></i></div>
<div id="education" class="recomand"><?php echo $this->Html->image('education.png',array('height'=>'50px','width'=>'50px')); ?>Education<i class="icon-pencil" style="float: right; margin:10px;" title="Edit Education"></i></div>




<div style="margin-top:20px;">
<p>You Can Also add...</p>
<p><i class="icon-plus"></i>Projects</p>
<p><i class="icon-plus"></i>Languages</p>
<p><i class="icon-plus"></i>Organizations</p>
</div>
</div>

</div>  <!-- Fluid Close -->

</div></div>

<script>
$(document).ready(function(){
	$('#from').datepicker();
	$('#to').datepicker();
	 //$('.firstname').editable();
	 //$('.lastname').editable();
	 $('#summary').live('click',function(){
		 $('#editsummary').toggle('show');
		 $('#showsummary').toggle('hide');
	 })
	  $('#sum_cancel').live('click',function(){
		 $('#editsummary').toggle('hide');
	 })
	  $('#education').live('click',function(){
		 $('#editeducation').show('slow');
		 $('#showeducation').toggle('hide');
	 })
	  $('#edu_cancel').live('click',function(){
		 $('#editeducation').hide('slow');
	 })
	  $('#experiance').live('click',function(){
		 $('#editexperiance').show('slow');
		 $('#showexperiance').toggle('hide');
	 })
	  $('#exp_cancel').live('click',function(){
		 $('#editexperiance').hide('slow');
	 })
	  $('#activity').live('click',function(){
		 $('#editactivity').show('slow');
		 $('#showactivity').toggle('hide');
	 })
	  $('#act_cancel').live('click',function(){
		 $('#editactivity').hide('slow');
	 })
	 $('.save').live('click',function(){
		 $('#editsummary').hide('slow');
		 $('#editeducation').hide('slow');
		 $('#editexperiance').hide('slow');
		 $('#editactivity').hide('slow');
	 })
	 
	 //$('.upPRc').hide('8000');
	 
	 
})
</script>

<div class="modal hide fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:570px;">
 <?php echo $this->Form->create("User",array('action'=>'img_edit','type' =>'file','id'=>'frmpic'),$type = 'post'); ?>
    <div class="modal-header">
    <button type="button" id="xbx-close" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h2 id="myModalLabel">Update your profile</h2>
    </div>
    <div class="modal-body">   
    <?php echo $this->Form->input('user_id',array("label" => "",'type'=>'hidden','value'=>$user_id)); ?>
       <div class="row-fluid">
            <div class="span4">First Name</div>
            <div class="span4"><?php echo $this->Form->input('first_name',array("label" => "",'value'=>$profile['User']['first_name'])); ?></div>
        </div>
        <div class="row-fluid">
            <div class="span4">Last Name</div>
            <div class="span4"><?php echo $this->Form->input('last_name',array("label" => "",'value'=>$profile['User']['last_name'])); ?></div>
        </div>
        <div class="row-fluid">
            <div class="span4">Profile Image</div>
            <div class="span4"><?php echo $this->Form->input('profile_image',array("label" => "",'type'=>'file','id'=>'ajaxupload')); ?></div>
        </div>        
   </div>
        <div class="modal-footer">
             <button class="btn btn-primary" type="submit">Save</button>
             <span id="upPRc" style="color:green;"></span>
             </div>
      </form>
  </div>      
        
         <?php echo $this->Html->script(array('jquery.form')); ?>
                        <script type="text/javascript">
                        <!-------------------edit profilepic-------------------->
                            $(document).ready(function(e){
                                $('#frmpic').ajaxForm({
                                    uploadProgress: function(event, position, total, percentComplete) {
                                        $('#upPRc').html(percentComplete + '%');
                                        
                                    },
                                    complete: function(xhr) {
                                        $('#upPRc').html('Uploaded...');
                                    },
                                    success: function(data){
                                        //alert(data);
                                        d = JSON.parse(data);
                                        console.log(d);
                                        if(d.error == 1){
                                            $('.fileupError').html(d.message);
                                            $('.fileupErrordetection').html(d.detection);
                                        }else if(d.error == 0){
                                           // $('.fileupError').html('');
                                           // $('.fileupErrordetection').html('');
										   //$('.img-con').after('<div style="float:left;height:150px;width:200px;margin-left:15px;"><img alt="" src="'+ d.src +'"></div>');
                                            $('.fileupSuccess').html(d.message);
											$('#xbx-close').trigger('click');
                                        }
                                    }
                                });
                            <!--------------------------------edit profile-------------------------------->
                            $('.edit').ajaxForm({
                                uploadProgress: function(event, position, total, percentComplete) {
                                    $('#ajax').html();
                                    
                                },
                                complete: function(xhr) {
                                    $('.upPRc').html('Updated...');
                                },
                                success: function(data){
                                    console.log(data);
                                    d = JSON.parse(data);
                                    console.log(d);
                                    if(d.error == 1){
                                        $('.upPRc').html(d.message);
                                        $('.upPRc').html(d.detection);
                                    }else if(d.error == 0){
                                       // $('.fileupError').html('');
                                       // $('.fileupErrordetection').html('');
									   //$('.img-con').after('<div style="float:left;height:150px;width:200px;margin-left:15px;"><img alt="" src="'+ d.src +'"></div>');
                                        $('.upPRc').html(d.message);
										//$('#xbx-close').trigger('click');
                                    }
                                }
                            });
                            });
                            </script>   
                       