<?php echo $this->element('top-header'); ?>
<div class="row-fluid"> 
    <style>
        .error{
            color: red;
        }
    </style>
   <div class="span11" id="" style="background-color:white;margin:5px 10px 10px 10px;">
       <div class="span12">
                    <?php $x=$this->Session->flash(); ?>
                    <?php if($x){ ?>
                     <div class="alert alert-block" style="margin-left:10px; margin-top:5px; width:88%;background-color:#5DA150;color:white;">
<button type="button" class="close" data-dismiss="alert">&times;</button>                
                    <strong><?php echo $x; ?></strong>
                   </div>
                   <?php }?> 
                    </div>
      <div class="top" >
          

      <div style="margin-left:20%;margin-top:20px;">
     <?php echo $this->Form->create('UserGroup',array('action'=>'add','method'=>'post','class'=>'form-horizontal alu','type'=>'file','id'=>'create_group')); ?>
   <?php echo $this->Form->input('user_id',array("label" => "",'type'=>'hidden','value'=>$user_id)); ?>
   <div class="control-group">
     <label class="control-label"><b>Group Logo:</b></label>
	  <div class="controls">
		<?php echo $this->Form->input('logo',array('label'=>"",'div'=>'false','type'=>'file'));?>
	  </div>
	  <div class="controls">
		<span style="font-size:10px;">Note: PNG, JPEG, or GIF only; max size 100 KB.</span> <br/>
		Your logo will appear in the Groups Directory and on your group pages.
	  </div>
	  <div class="controls">
		<input type="checkbox"/>
  * I acknowledge and agree that the logo/image I am uploading does not infringe upon any third party copyrights,<br/>
    trademarks, or other proprietary rights or otherwise violate the User Agreement. 
	  </div>
  </div>
  <div class="control-group">
    <label class="control-label"><b>Group Name:</b></label>
	<div class="controls">
		<?php echo $this->Form->input('group_name',array('label'=>"",'div'=>'false','required')); ?>
		<span style="font-size:10px;">Note: "Academatch" is not allowed to be used in your group name.</span>
	</div>
  </div>
  <div class="control-group">
    <label class="control-label"><b>Group Type:</b></label>
	<div class="controls">
	<select name="data[UserGroup][group_type]">
	<?php foreach($grp as $g): ?>
		<option><?php echo $g['GroupType']['group_name']; ?></option>
		<?php endforeach; ?>
		</select>
	</div>
  </div>
  <div class="control-group">
    <label class="control-label"><b>Summary:</b></label>
	<div class="controls">
	<?php echo $this->Form->input('summary',array('label'=>"",'div'=>'false','type'=>'textarea','required')); ?>
	<span style="font-size:10px;">
	Enter a brief description about your group and its purpose. Your summary about this group will appear in the Groups Directory.</span>
	</div>
  </div>
  <div class="control-group">
    <label class="control-label"><b>Description:</b></label>
	<div class="controls">
		<?php  echo $this->Form->input('description',array('label'=>"",'type'=>'textarea','div'=>'false','required'));?>
		<span style="font-size:10px;">
		Your full description of this group will appear on your group pages.
		</span>
	</div>
  </div>
<!--  <div class="control-group">
      <label class="control-label"><b>Website</b><span style="font-size:10px;">(Optional)</span>:</label>
	<div class="controls">
	<?php //echo $this->Form->input('website',array('label'=>"",'div'=>'false','type'=>'text')); ?>
	</div>
  </div>-->
  <div class="control-group">
    <label class="control-label"><b>Group Owner Email:</b></label>
	<div class="controls">
		<?php echo $this->Form->input('group_owner_email',array('label'=>"",'div'=>'false','type'=>'email','value'=>$email,'required email')); ?>
	</div>
  </div>
<!--  <div class="control-group">
    <label class="control-label"><b>Approval:</b></label>
	<div class="controls">
	<input type="checkbox" name="data[UserGroup][auto_join]" value="1"/><b>Auto-Join:</b>&nbsp;&nbsp;Any Academatch member may join this group without requiring approval from a manager.<br/> 
	</div>
  </div>
  <div class="control-group">
    <label class="control-label"></label>
	<div class="controls">
	<input type="checkbox" name="data[UserGroup][request_for_join]" value="1"/><b>Request to Join:</b>&nbsp;&nbsp;Users must request to join this group and be approved by a manager. <br/> 
	</div>
  </div>-->
<!--  <div class="control-group">
    <label class="control-label"></label>
	<div class="controls">
	<input type="checkbox" name="data[UserGroup][logo allow]" value="1"/>Display this group in the Groups Directory.<br/> 
	</div>
  </div>-->
<!--  <div class="control-group">
    <label class="control-label"></label>
	<div class="controls">
	<input type="checkbox" name="data[UserGroup][invite_others]" value="1"/>Allow members to display the logo on their profiles. Also, send your connections a Network Update that you have created this group.<br/> 
	</div>
  </div>-->
  <div class="control-group">
    <label class="control-label"></label>
	<div class="controls">
	<span style="font-size:10px;">Pre-approve members with the following email domain(s):</span>
		<?php echo $this->Form->input('pre_approve',array('label'=>"",'div'=>'false','type'=>'textarea')); ?> 
	</div>
  </div>
<!--  <div class="control-group">
    <label class="control-label"><b>Location:</b></label>
	<div class="controls">
		<input type="checkbox" name="data[UserGroup][location]" value="1"/>
		This group is based in a single geographic location. 
	</div>
  </div>-->
  <div class="control-group">
    <label class="control-label"><b>Agreement:</b></label>
	<div class="controls">
		<input type="checkbox" name="data[UserGroup][agreement]" value="1"/>
		Check to confirm you have read and accept the Terms of Service.
	</div>
  </div>
  <?php echo $this->Form->input('status',array('label'=>"",'div'=>'false','type'=>'hidden','value'=>'Active')); ?>
  <br/>
  <div class="form-actions">
     <button type="submit" name="save" id="update" class="btn btn-primary save" style="margin-left:40px;">Save</button>
</div>
<div class="message"></div>			
<div class="fileupError"></div>	
</form>
      </div>
   </div>  </div>
   </div>  

<?php  echo $this->element('footer');
 ?>
 <?php //echo $this->Html->script(array('jquery.form')); ?>
 <!-- <script type="text/javascript">
                            $(document).ready(function(e){
                                $('#create_group').ajaxForm({
                                    uploadProgress: function(event, position, total, percentComplete) {
                                        $('#upPRc').html(percentComplete + '%');
                                        
                                    },
                                    complete: function(xhr) {
                                        //$('#upPRc').html('Uploaded...');
                                    },
                                    success: function(data){
                                        //alert(data);
                                        d = JSON.parse(data);
                                        console.log(d);
                                        if(d.error == 1){
                                            $('.message').html(d.message);
                                            $('.fileupErrordetection').html(d.detection);
                                        }else if(d.error == 0){						
                                            $('.message').html(d.message);
                                            window.location = d.redirect;
											
                                        }
                                    }
                                });
                            });
</script>    -->




