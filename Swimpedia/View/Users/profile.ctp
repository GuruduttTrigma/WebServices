<?php echo $this->element('top-header'); ?>
 <?php echo $this->Html->script(array('jquery.form')); ?>
<?php echo $this->Html->script(array('tiny_mce/tiny_mce'))?>
<!------------------------------------------------------------------->
<script type="text/javascript">
jQuery(document).ready(function(){
tinyMCE.init({
theme: "advanced",
plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
// Theme options
theme_advanced_buttons1 : ",justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
theme_advanced_buttons2 : "cut,copy,paste|,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,image,cleanup,code,|,forecolor,backcolor",
theme_advanced_buttons3 : "tablecontrols,|sub,sup,|,charmap,emotions,iespell,media,advhr,|,fullscreen",
theme_advanced_buttons4 : "bold,italic,underline,strikethrough,|styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,|,insertimage",
theme_advanced_toolbar_location : "top",
theme_advanced_toolbar_align : "left",
theme_advanced_statusbar_location : "bottom",
theme_advanced_resizing : true,
mode: "exact",
elements: "desc",
body_id: "desc"
});
});
</script>
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
font-size:23px;height:40px;border:1px solid #D4D0C8;width:100%;background-color:white;margin-top:20px;cursor:pointer;
}
</style>

    <div class="row-fluid  span12">
                    <?php $x=$this->Session->flash(); ?>
                    <?php if($x){ ?>
                     <div class="alert alert-block" style="margin-left:10px; margin-top:5px; width:88%;background-color:#5DA150;color:white;">
<button type="button" class="close" data-dismiss="alert">&times;</button>                
                    <strong><?php echo $x; ?></strong>
                   </div>
                   <?php }?> 
    </div>

<div class="row-fluid" style="margin-top:5px;">
     
 <div class="span8" style="background-color:white;">    
 <div class="top">
 <!-- ------------sharing-------------- -->
 <div class="top-div">
 <a href="#edit" style="float: right; padding:5px; " role="button" data-toggle="modal" style="cursor:pointer;" title="Edit"><i class="icon-edit"></i></a>
 <div class="img-con" style="border-radius:10px;padding-bottom: 75px;">
 <?php if($profile['User']['profile_image']==NULL || $profile['User']['profile_image']== '0'){
 echo $this->Html->image('profile.png',array('height'=>'150px','width'=>'150px',"class"=>"img-polaroid"));
}else{
 echo $this->Html->image('../files/profileimage/'.$profile['User']['profile_image'],array('style'=>'height: 200px; width:170px; margin-top:0px;',"class"=>"img-polaroid"));
} ?>
 </div>
 <div class="name-con">
 <h1>
 <?php echo ucwords($profile['User']['first_name']); ?>&nbsp;&nbsp;<?php echo ucwords($profile['User']['last_name']); ?>
 </h1>   

 <span style="font-size:20px;">
 <?php foreach($experiance as $exp):
  if($exp['UserWorkSince']['user_id'] == $profile['User']['id']){
	  echo ucwords($exp['UserWorkSince']['exp_title'])."<br/>".ucwords($exp['UserWorkSince']['exp_company_name']);
	 break; }  endforeach; ?><br/>
 </span><br/>
 <span style="font-size:20px;">
 <?php foreach($education as $exp):
  if($exp['UserEducation']['user_id'] == $profile['User']['id']){ 
 echo ucwords($exp['UserEducation']['edu_degree'])."<br/>". ucwords($exp['UserEducation']['edu_school'])."<br/>".ucwords($exp['UserEducation']['edu_fieldofstudy']); 
 break;  } endforeach; ?><br/>
 </span>
 </div>  
 </div>
 
 <!-- ------------activity--------------------- -->
<!-- <div style="margin-top:5px;  margin-left:75px; box-shadow:5px 5px 5px; font-size:23px;">
     <div style="background-color:#5A595A; color:white; padding:10px;"><b>Activity</b>
     <span style="float:right; margin:8px;"><a id="activity" class=" icon-pencil" style="margin-bottom:3px;cursor:pointer;"></a></span></div>
   <div id="editactivity" style="display:none;">
    Your Activities will display here.
    <button id="act_cancel" class="btn">Cancel</button>
    </div>
 </div>-->
  <!-- --------background------------------- -->
   <div class="background">              
    <div style="margin-top:5px; height:40px;  background-color:#5A595A;color:white;font-size:23px;padding-top:5px;padding-left:10px;"><b>Background</b><span class="upPRc" style="color:green;font-size:10px;"></span></div>
    <!-- ------------------summary-------------------- -->
   <div  style="margin-top:30px;">
   <span style="font-size:23px;"><?php //echo $this->Html->image('summary.png',array('height'=>'25px','width'=>'25px')); ?><h4>Summary </h4></span>
   <i class="icon-plus" id="summary" style="cursor:pointer; float:right; margin:8px;" title="Edit Summary"></i></div>
   <div id="showsummary">
   <p align="justify" class="well"><?php echo $profile['User']['summary']; ?></p>
   </div>
   <div id="editsummary" style="display:none;">
   <?php echo $this->Form->create('User',array('action'=>'edit','method'=>'post','class'=>'form-horizontal edit')); ?>
   <div class="control-group">
   <?php echo $this->Form->input('user_id',array("label" => "",'type'=>'hidden','value'=>$user_id)); ?>
	  <div class="" style="height:150px;width:100%;margin-left:75px;">
		<?php echo $this->Form->input('summary',array('label'=>"",'type'=>'textarea','value'=>$profile['User']['summary'],"id"=>"desc","style"=>"height:150px;width:100%;")); ?>
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
   <!-- --------------------experience---------------- -->
   <div  style="margin-top:30px;">
   <span style="font-size:23px;"><?php //echo $this->Html->image('experiance.png',array('height'=>'25px','width'=>'25px')); ?><h4>Experience</h4> </span>
   <i class="icon-plus" id="addexpbtn" style="cursor:pointer; float:right; margin:8px;" title="Add Experience"></i>
<div id="ajax">
<!--<img src="/img/ajax-loader.gif"/>-->
</div>
</div>
   <div id="showexperiance" class="well">
   <?php foreach($experiance as $exp): ?>
   <div id="exp_single_data">
  <a href="#exp_model_<?php echo $exp['UserWorkSince']['id']; ?>" style="float: right; padding:5px; " role="button" data-toggle="modal" style="cursor:pointer;" title="Edit"><i class="icon-edit"></i></a>
   <a href="<?php echo $this->Html->url(array('controller'=>'companies','action'=>'view',$exp['UserWorkSince']['exp_company_name'])); ?>">   
   <?php echo "<b>".$exp['UserWorkSince']['exp_company_name']."</b>" ; ?></a><br/>
<?php echo $exp['UserWorkSince']['exp_title'].",".$exp['UserWorkSince']['exp_location']."<br/>"?>
<?php echo $exp['UserWorkSince']['exp_time_from']."-".$exp['UserWorkSince']['exp_time_to']; ?>
(<?php if($exp['UserWorkSince']['exp_time_to']=='present' || $exp['UserWorkSince']['exp_time_to'] == 'Present'){
$var = strtotime(date('d/m/Y'))- strtotime($exp['UserWorkSince']['exp_time_from']); echo ceil($var/(60*60*30*24))."months";
}else{ ?>
 <?php $var = strtotime($exp['UserWorkSince']['exp_time_to'])- strtotime($exp['UserWorkSince']['exp_time_from']); echo ceil($var/(60*60*30*24))."months"; } ?>)<br/>
 <p align="justify" class="well"><?php echo $exp['UserWorkSince']['exp_description']; ?></p>
 </div>
 <!-- ---------------------model window for experience updation ----------------------->
<div class="modal hide fade" id="exp_model_<?php echo $exp['UserWorkSince']['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:600px;height:600px;">
 <?php echo $this->Form->create("UserWorkSince",array('controller'=>'UserWorkSinces','action'=>'edit','id'=>'frmexp_'.$exp['UserWorkSince']['id']),$type = 'post'); ?>
    <div class="modal-header">
    <button type="button" id="xbx-close_<?php echo $exp['UserWorkSince']['id']; ?>" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h2 id="myModalLabel">Update your Experience profile</h2>
    </div>
    <div class="modal-body" style="max-height:700px;"> 
    <?php echo $this->Form->input('id',array("label" => "",'type'=>'hidden','value'=>$exp['UserWorkSince']['id'])); ?>  
    <?php echo $this->Form->input('user_id',array("label" => "",'type'=>'hidden','value'=>$user_id)); ?>
       <div class="row-fluid">
            <div class="span4">Company Name</div>
            <div class="span4"><?php echo $this->Form->input('exp_company_name',array("label" => "",'div'=>'false','value'=>$exp['UserWorkSince']['exp_company_name'])); ?></div>
        </div>
        <div class="row-fluid">
            <div class="span4">Title</div>
            <div class="span4"><?php echo $this->Form->input('exp_title',array("label" => "",'div'=>'false','value'=>$exp['UserWorkSince']['exp_title'])); ?></div>
        </div>
        <div class="row-fluid">
            <div class="span4">Location</div>
            <div class="span4"><?php echo $this->Form->input('exp_location',array("label" => "",'div'=>'false','value'=>$exp['UserWorkSince']['exp_location'])); ?></div>
        </div>
        <div class="row-fluid">
            <div class="span4">Time From</div>
            <div class="span4"><?php echo $this->Form->input('exp_time_from',array("label" => "",'div'=>'false','value'=>$exp['UserWorkSince']['exp_time_from'],'class'=>'from')); ?></div>
        </div>
        <div class="row-fluid">
            <div class="span4">To</div>
            <div class="span4"><?php echo $this->Form->input('exp_time_to',array("label" => "",'div'=>'false','value'=>$exp['UserWorkSince']['exp_time_to'],'class'=>'from')); ?></div>
        </div>
        <div class="row-fluid">
            <div class="span4">Description</div>
            <div class="span4"><?php echo $this->Form->input('exp_description',array("label" => "",'div'=>'false','type'=>'textarea','value'=>$exp['UserWorkSince']['exp_description'])); ?></div>
        </div>       
   </div>
        <div class="modal-footer">
             <button class="btn btn-primary" type="submit">Save</button>
             <?php //echo $this->Form->postLink('<span class="icon-trash" data-icon="&#xe136;"></span>Remove',array('controller'=>'UserWorkSinces','action'=>'delete',$exp['UserWorkSince']['id'],$user_id),array('escape'=>false,'class'=>'btn btn-small','title'=>'Remove'));?>
             <a href="<?php echo $this->Html->url(array('controller'=>'UserWorkSinces','action' => 'delete',$exp['UserWorkSince']['id'],$user_id)); ?>" class="btn tool-tip" title="Remove"><i class="icon icon-trash"></i>Remove</a>
             <span class="upPRc" style="color:green;"></span>
         </div>
      </form>
  </div>   
 <!-- <script type="text/javascript">
                            $("#frmexp_<?php echo $exp['UserWorkSince']['id']; ?>").ajaxForm({
                                success: function(data){
                                    d = JSON.parse(data);
                                    if(d.error == 1){
                                        $('.upPRc').html(d.message).fadeOut(10000);
                                        //$('.upPRc').html(d.redirect);
                                    }else if(d.error == 0){
                                       // $('.fileupError').html('');
                                       // $('.fileupErrordetection').html('');
									   //$('.img-con').after('<div style="float:left;height:150px;width:200px;margin-left:15px;"><img alt="" src="'+ d.src +'"></div>');
                                        $('.upPRc').html(d.message).fadeOut(10000);
					$("#xbx-close_<?php echo $exp['UserWorkSince']['id']; ?>").trigger('click');
                                          window.location = d.redirect;
                                    }
                                }
                            });  
                            </script>     -->               
   <!-- ------------------------------end-------------------------------------- --> 
<?php endforeach; ?>
 </div>
   <div id="addexperiance"  style="display:none;">
   <?php echo $this->Form->create('UserWorkSince',array('action'=>'add','method'=>'post','class'=>'form-horizontal add_exp')); ?>
   <?php echo $this->Form->input('user_id',array("label" => "",'type'=>'hidden','value'=>$user_id)); ?>
   <div class="control-group">
     <label class="control-label">Company Name:</label>
	  <div class="controls">
		<?php echo $this->Form->input('exp_company_name',array('label'=>"",'div'=>'false')); ?>
	  </div>
  </div>
  <div class="control-group">
    <label class="control-label">Title:</label>
	<div class="controls">
		<?php  echo $this->Form->input('exp_title',array('label'=>"",'div'=>'false'));?>
	</div>
  </div>
  <div class="control-group">
    <label class="control-label">Location:</label>
	<div class="controls">
		<?php  echo $this->Form->input('exp_location',array('label'=>"",'div'=>'false'));?>
	</div>
  </div>
  <div class="control-group">
    <label class="control-label">Time Period  From:</label>
	<div class="controls">
	<?php  echo $this->Form->input('exp_time_from',array('label'=>"",'class'=>"from",'div'=>'false'));?>to
	<?php  echo $this->Form->input('exp_time_to',array('label'=>"",'div'=>'false','class'=>"from"));?>
	</div>
  </div>
  <div class="control-group">
    <label class="control-label">Description:</label>
	<div class="controls">
		<?php  echo $this->Form->input('exp_description',array('label'=>"",'div'=>'false','style'=>'width:250px'));?>
	</div>
  </div>
  <div class="form-actions">
     <button type="submit" name="save" id="add_exp" class="btn btn-primary save" style="margin-left:40px;">Save</button>
     <button id="exp_cancel" class="btn">Cancel</button>
</div>
</form>
   </div>
   <!-- ---------------------education----------------- -->
     <div  style="margin-top:30px;">
     <span style="font-size:23px;"><?php //echo $this->Html->image('education.png',array('height'=>'25px','width'=>'25px')); ?><h4>Education </h4></span>
     <i class="icon-plus" id="addedubtn" style="cursor:pointer; float:right; margin:8px;" title="Add education"></i></div>
  <div id="showeducation" class="well">
  <?php foreach($education as $edu): ?>
  <div>
  <!-- <a href="<?php echo $this->Html->url(array('controller'=>'UserEducations','action'=>'delete',$edu['UserEducation']['id'])); ?>" style="float:right;"><i class="icon-remove"></i></a>-->
    <a href="#edu_model_<?php echo $edu['UserEducation']['id']; ?>" rel="<?php echo $edu['UserEducation']['id']; ?>" style="float: right; padding:5px; " role="button" data-toggle="modal" style="cursor:pointer;" title="Edit"><i class="icon-edit"></i></a>
  <?php echo "<b>".$edu['UserEducation']['edu_school']."</b><br/>,".$edu['UserEducation']['edu_degree'].",".
$edu['UserEducation']['edu_fieldofstudy'].",".$edu['UserEducation']['edu_grade'].",<br/>".$edu['UserEducation']['edu_activities']; ?>
</div>
<br />
 <!-- ---------------------model window for education updation ----------------------->
<div class="modal hide fade" id="edu_model_<?php echo $edu['UserEducation']['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:600px;">
 <?php echo $this->Form->create("UserEducation",array('controller'=>'UserEducations','action'=>'edit','id'=>'frmedu_'.$edu['UserEducation']['id']),$type = 'post'); ?>
    <div class="modal-header">
    <button type="button" id="xbx-close_<?php echo $edu['UserEducation']['id']; ?>" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h2 id="myModalLabel">Update your Educational profile</h2>
    </div>
    <div class="modal-body" style="height:700px;"> 
    <?php echo $this->Form->input('id',array("label" => "",'type'=>'hidden','value'=>$edu['UserEducation']['id'])); ?>  
    <?php echo $this->Form->input('user_id',array("label" => "",'type'=>'hidden','value'=>$user_id)); ?>
       <div class="row-fluid">
            <div class="span4">School</div>
            <div class="span4"><?php echo $this->Form->input('edu_school',array("label" => "",'div'=>'false','value'=>$edu['UserEducation']['edu_school'])); ?></div>
        </div>
        <div class="row-fluid">
            <div class="span4">degree</div>
            <div class="span4"><?php echo $this->Form->input('edu_degree',array("label" => "",'div'=>'false','value'=>$edu['UserEducation']['edu_degree'])); ?></div>
        </div>
        <div class="row-fluid">
            <div class="span4">Field of study</div>
            <div class="span4"><?php echo $this->Form->input('edu_fieldofstudy',array("label" => "",'div'=>'false','value'=>$edu['UserEducation']['edu_fieldofstudy'])); ?></div>
        </div>
        <div class="row-fluid">
            <div class="span4">Grade</div>
            <div class="span4"><?php echo $this->Form->input('edu_grade',array("label" => "",'div'=>'false','value'=>$edu['UserEducation']['edu_grade'])); ?></div>
        </div>
        <div class="row-fluid">
            <div class="span4">Activities & Societies</div>
            <div class="span4"><?php echo $this->Form->input('edu_activities',array("label" => "",'div'=>'false','value'=>$edu['UserEducation']['edu_activities'])); ?></div>
        </div>       
   </div>
        <div class="modal-footer">
             <button class="btn btn-primary" type="submit">Save</button>
              <a href="<?php echo $this->Html->url(array('controller'=>'UserEducations','action' => 'delete',$edu['UserEducation']['id'],$user_id)); ?>" class="btn tool-tip" title="Remove"><i class="icon icon-trash"></i>Remove</a>
             <span class="upPRc" style="color:green;"></span>
             </div>
      </form>
  </div>   
 <!-- <script type="text/javascript">
                            $('#frmedu_<?php echo $edu['UserEducation']['id']; ?>').ajaxForm({
                                success: function(data){
                                    console.log(data);
                                    d = JSON.parse(data);
                                    console.log(d);
                                    if(d.error == 1){
                                        $('.upPRc').html(d.message).fadeOut(10000);
                                       // $('.upPRc').html(d.redirect);
                                    }else if(d.error == 0){
                                       // $('.fileupError').html('');
                                       // $('.fileupErrordetection').html('');
									   //$('.img-con').after('<div style="float:left;height:150px;width:200px;margin-left:15px;"><img alt="" src="'+ d.src +'"></div>');
                                        $(".upPRc").html(d.message).fadeOut(10000);
					$("#xbx-close_<?php echo $edu['UserEducation']['id']; ?>").trigger('click');
                                           window.location = d.redirect;
                                    }
                                }
                            });  
                            </script>   -->                 
   <!-- ------------------------------end-------------------------------------- --> 
<?php endforeach; ?>
  </div>
   <div id="addeducation"  style="display:none;">
   <?php echo $this->Form->create('UserEducation',array('action'=>'add','method'=>'post','class'=>'form-horizontal add_edu')); ?>
   <?php echo $this->Form->input('user_id',array("label" => "",'type'=>'hidden','value'=>$user_id)); ?>
   <div class="control-group">
     <label class="control-label">School:</label>
	  <div class="controls">
		<?php echo $this->Form->input('edu_school',array('label'=>"",'div'=>'false')); ?>
	  </div>
  </div>
  <div class="control-group">
    <label class="control-label">Degree:</label>
	<div class="controls">
		<?php  echo $this->Form->input('edu_degree',array('label'=>"",'div'=>'false'));?>
	</div>
  </div>
  <div class="control-group">
    <label class="control-label">Field of Study:</label>
	<div class="controls">
		<?php  echo $this->Form->input('edu_fieldofstudy',array('label'=>"",'div'=>'false'));?>
	</div>
  </div>
  <div class="control-group">
    <label class="control-label">Grade:</label>
	<div class="controls">
	<?php  echo $this->Form->input('edu_grade',array('label'=>"",'div'=>'false'));?>
		</div>
  </div>
  <div class="control-group">
    <label class="control-label">Activities & Societies:</label>
	<div class="controls">
		<?php  echo $this->Form->input('edu_activities',array('label'=>"",'div'=>'false'));?>
	</div>
  </div>
  <br/>
  <div class="form-actions">
     <button type="submit" name="save" id="add_edu" class="btn btn-primary save" style="margin-left:40px;">Save</button>
     <button id="edu_cancel" class="btn">Cancel</button>
</div>
</form>
   </div>
   <!-------------------------------------skills---------------------------------------------->
    <div  style="margin-top:30px;">
          <span style="font-size:23px;"><?php //echo $this->Html->image('skills.png',array('height'=>'25px','width'=>'25px')); ?><h4>Skills & Expertise </h4></span>
            <i class="icon-plus" id="addskillbtn" style="cursor:pointer; float:right; margin:8px;" title="Add Your Skills"></i>
    </div>
     <div id="showskill" class="well">
  <?php foreach($skills as $skill): ?>
  <div class="row-fluid">
  <!-- <a href="<?php echo $this->Html->url(array('controller'=>'Skills','action'=>'delete',$skill['Skill']['id'])); ?>" style="float:right;"><i class="icon-remove"></i></a>-->
    <a href="#skill_model_<?php echo $skill['Skill']['id']; ?>" rel="<?php echo $skill['Skill']['id']; ?>" style="float: right; padding:5px; " role="button" data-toggle="modal" style="cursor:pointer;" title="Edit"><i class="icon-edit"></i></a>
  <?php echo $skill['Skill']['skills']; ?>
</div>
<div class="modal hide fade" id="skill_model_<?php echo $skill['Skill']['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 <?php echo $this->Form->create("Skill",array('controller'=>'Skills','action'=>'edit','id'=>'frmskill_'.$skill['Skill']['id']),$type = 'post'); ?>
    <div class="modal-header">
    <button type="button" id="xbx-close_<?php echo $skill['Skill']['id']; ?>" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h2 id="myModalLabel">Update your Skills and Expertise</h2>
    </div>
    <div class="modal-body"> 
    <?php echo $this->Form->input('id',array("label" => "",'type'=>'hidden','value'=>$skill['Skill']['id'])); ?>  
    <?php echo $this->Form->input('user_id',array("label" => "",'type'=>'hidden','value'=>$user_id)); ?>
       <div class="row-fluid">
            <div class="span4">Skill</div>
            <div class="span4"><input type="text" value="<?php echo $skill['Skill']['skills']; ?>" name="data[Skill][skills]"/></div>
        </div>       
   </div>
        <div class="modal-footer">
             <button class="btn btn-primary" type="submit">Save</button>
              <a href="<?php echo $this->Html->url(array('controller'=>'Skills','action' => 'delete',$skill['Skill']['id'],$user_id)); ?>" class="btn tool-tip" title="Remove"><i class="icon icon-trash"></i>Remove</a>
             <span class="upPRc" style="color:green;"></span>
             </div>
      </form>
  </div>   
                <script type="text/javascript">
                            $('#frmskill_<?php echo $skill['Skill']['id']; ?>').ajaxForm({
                                success: function(data){
                                    d = JSON.parse(data);
                                    if(d.error == 1){
                                        $('.upPRc').html(d.message).fadeOut(10000);
                                        //$('.upPRc').html(d.redirect);
                                    }else if(d.error == 0){			
                                        $(".upPRc").html(d.message).fadeOut(10000);
					$("#xbx-close_<?php echo $skill['Skill']['id']; ?>").trigger('click');
                                          window.location = d.redirect;
                                    }
                                }
                            });  
               </script>   
         <?php endforeach; ?>
     </div>
<br />
<div id="addskill"  style="display:none;">
   <?php echo $this->Form->create('Skill',array('action'=>'add','method'=>'post','class'=>'form-horizontal add_skill')); ?>
   <?php echo $this->Form->input('user_id',array("label" => "",'type'=>'hidden','value'=>$user_id)); ?>
   <div class="control-group">
     <label class="control-label">Skill:</label>
	  <div class="controls">
		 <input type="text" name="data[Skill][skills]"/>
	  </div>
  </div>
  <br/>
  <div class="form-actions">
     <button type="submit" name="save" id="add_skill" class="btn btn-primary save" style="margin-left:40px;">Save</button>
     <button id="skill_cancel" class="btn">Cancel</button>
</div>
</form>
   </div>
   <!--------------------------------------end------------------start group---------------------------------->
     <!-- ---------------------Groups----------------- -->
      <div  style="margin-top:30px;">
         <span style="font-size:23px;"><?php echo $this->Html->image('grup.png',array('height'=>'25px','width'=>'25px')); ?><h4>Groups</h4> </span>
      </div>
      <div>          
	  <?php if($groups){ foreach($groups as $grup): if($grup['UserGroup']['user_id'] == $profile['User']['id']){?>   
      <div style="float:left;margin:15px;width: 150px;"> 
          <?php echo $this->Form->postLink('',array('controller'=>'user_groups','action'=>'delete',$grup['UserGroup']['id']),array('escape'=>false,'class'=>'tablectrl_small bDefault tipS tool-tip','title'=>'Delete'));?>    
	<a href="<?php echo $this->Html->url(array('controller'=>'UserGroups','action'=>'home_group',$grup['UserGroup']['group_name'])) ?>" >
            <?php echo $this->Html->image('../files/grouplogo/'.$grup['UserGroup']['logo'],array('style'=>'height:100px;width:250px;','hspace'=>'10','align'=>'left')); ?>
        </a>        
      </div>
          <?php } endforeach;}else{ ?>
          <p>There is no group created by you.</p>
          <?php } ?>
   </div>    
   <!------------------------------------------>
   </div>
 <!-- ----------updates--------------- -->
 <div>
 </div>

 </div>
</div>
<div class="span4" style="margin-left:5px;">                
<legend><span style="font-size:25px;"><h4>Recommended for you</h4></span></legend>
<!--<div id="activity" class="recomand">
<?php //echo $this->Html->image('experiance.png',array('height'=>'50px','width'=>'50px')); ?>Activity <i class="icon-edit" style="float: right; margin:10px;" title="Edit Activity"></i></div>-->
<div id="summary" class="recomand" style="padding-top:20px;"><?php //echo $this->Html->image('summary.png',array('height'=>'25px','width'=>'25px')); ?>&nbsp;Summary<i class="icon-plus" style="float: right; margin:10px;" title="Edit Summary"></i></div> 
<div id="addexpbtn" class="recomand" style="padding-top:20px;"><?php //echo $this->Html->image('experiance.png',array('height'=>'25px','width'=>'25px')); ?>&nbsp;Experience<a href="#addexperiance" style="float: right; margin:10px;"  title="Add Experiance"><i class="icon-plus"></i></a></div>
<div id="addedubtn" class="recomand" style="padding-top:20px;"><?php //echo $this->Html->image('education.png',array('height'=>'25px','width'=>'25px')); ?>&nbsp;Education<a href="#addeducation" style="float: right;margin:10px;" title="Add Education"><i class="icon-plus"></i></a></div>




<!--<div style="margin-top:20px;">
<p>You Can Also add...</p>
<p><i class="icon-plus"></i>Projects</p>
<p><i class="icon-plus"></i>Languages</p>
<p><i class="icon-plus"></i>Organizations</p>
</div>-->
</div>

</div>  <!-- Fluid Close -->

<?php  echo $this->element('footer');
 ?>

<script>
/*$(document).ready(function(){
	//$('#from').datepicker();
	//$('.from').datepicker();
	//$('#to').datepicker();
	//$('#addfrom').datepicker();
	 //$('.firstname').editable();
	 //$('.lastname').editable();
	 $('#summary').live('click',function(){
		 $('#editsummary').toggle('show');
		 $('#showsummary').toggle('hide');
	 })
	  $('#sum_cancel').live('click',function(){
		 $('#editsummary').toggle('hide');
	 })
	 //--------------------------------------------experiance
	 $('#addexpbtn').live('click',function(){
		 $('#addexperiance').toggle('slow');
		 //$('#editexperiance').toggle('hide');
		 $('#showexperiance').toggle('hide');
	 })
	 $('#add_exp').live('click',function(){
		 $('#addexperiance').toggle('hide');
		 //$('#editexperiance').toggle('hide');
		 $('#showexperiance').toggle('show');
	 })
	 $('#exp_cancel').live('click',function(){
		 $('#addexperiance').toggle('hide');
		 //$('#editexperiance').toggle('hide');
		 $('#showexperiance').toggle('show');
	 })
	 //--------------------------------------------education
	  $('#addedubtn').live('click',function(){
		 $('#addeducation').toggle('slow');
		 //$('#editeducation').toggle('hide');
		 $('#showeducation').toggle('hide');
	 })
	 $('#add_edu').live('click',function(){
		 $('#addeducation').toggle('hide');
		// $('#editeducation').toggle('hide');
		 $('#showeducation').toggle('show');
	 })
	 $('#edu_cancel').live('click',function(){
		 $('#addeducation').toggle('hide');
		 //$('#editexperiance').toggle('hide');
		 $('#showeducation').toggle('show');
	 })
	 //------------------------------activity
	 $('#activity').live('click',function(){		 
		 $('#editactivity').toggle('show');
	 })
         //-------------------------------------skills
         $('#addskillbtn').live('click',function(){
		 $('#addskill').toggle('slow');
		 $('#showskill').toggle('hide');
	 });
          $('#add_skill').live('click',function(){
		 $('#addskill').toggle('hide');
		 $('#showskill').toggle('show');
	 });
	 $('#skill_cancel').live('click',function(){
		 $('#addskill').toggle('hide');
		 $('#showskill').toggle('show');
	 });
	 
})*/
</script>
<!-- ---------------------model window for profile updation ----------------------->
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
             <span id="imgupPRc" style="color:green;"></span>
             </div>
      </form>
  </div> 
<?php echo $this->Html->css(array("http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css")); ?>
        <?php  echo $this->Html->script(array("http://code.jquery.com/ui/1.10.3/jquery-ui.js")); ?>
                        <script type="text/javascript">
                        //<!-------------------edit profilepic-------------------->                         
                            $(document).ready(function(){  
                                //alert("dgfgh");
                               /* $('#frmpic').ajaxForm({
                                    uploadProgress: function(event, position, total, percentComplete) {
                                        $('#imgupPRc').html(percentComplete + '%');                                        
                                    },
                                    complete: function(xhr) {
                                        $('#imgupPRc').html('Uploaded...');
                                    },
                                    success: function(data){
                                       $('.imgupPRc').html('Saved');
                                       $('#edit').modal('hide');
                                        console.log(d);
                                        if(d.error == 1){                                            
                                            //$('.fileupError').html(d.message).fadeOut(10000);
                                            $('.fileupError').html(d.message).delay(10000).fadeOut('slow');
                                             $('#edit').modal('hide');
                                             window.location = d.redirect;
                                          } 
                                        else if (d.error == 0){					   
                                            $('.fileupSuccess').html(d.message).delay(10000).fadeOut('slow');
					      $('#edit').modal('hide');
                                                 window.location = d.redirect;
                                        }
                                    }
                                });*/
                                //<!--------------------------------edit summary-------------------------------->
                              /*  $('.edit').ajaxForm({
                                    success: function(data){
                                        console.log(data);
                                        d = JSON.parse(data);
                                        console.log(d);
                                        if(d.error == 1){
                                            $('.upPRc').html(d.message).fadeOut(10000);
                                            //$('.upPRc').html(d.redirect);
                                        }else if(d.error == 0){
                                             $('.upPRc').html(d.message).fadeOut(10000);
                                            // window.location = d.redirect;    										//$('#xbx-close').trigger('click');
                                        }
                                    }    
                                    
                                });*/
                            
                            //<!------------------------------add education--------------------------->
                          /*  $('.add_edu').ajaxForm({
                                success: function(data){
                                    console.log(data);
                                    d = JSON.parse(data);
                                    console.log(d);
                                    if(d.error == 1){
                                        $('.upPRc').html(d.message).fadeOut(10000);
                                        //$('.upPRc').html(d.redirect);
                                    }else if(d.error == 0){
                                         $('.upPRc').html(d.message).fadeOut(10000);
                                          window.location = d.redirect;
										//$('#xbx-close').trigger('click');
                                    }
                                }
                            });*/
                            //<!------------------------------add experiance--------------------------->
                         /*   $('.add_exp').ajaxForm({
                                success: function(data){
                                    console.log(data);
                                    d = JSON.parse(data);
                                    console.log(d);
                                    if(d.error == 1){
                                        $('.upPRc').html(d.message).fadeOut(10000);
                                       // $('.upPRc').html(d.redirect);
                                    }else if(d.error == 0){
                                         $('.upPRc').html(d.message).fadeOut(10000);
                                          window.location = d.redirect;
										//$('#xbx-close').trigger('click');
                                    }
                                }
                            });*/
                            //<!------------------------------------------Add skill--------------------------->
                            $('.add_skill').ajaxForm({
                                success: function(data){
                                    d = JSON.parse(data);
                                    if(d.error == 1){
                                        $('.upPRc').html(d.message).fadeOut(10000);
                                       // $('.upPRc').html(d.redirect);
                                    }else if(d.error == 0){
                                            $('.upPRc').html(d.message).fadeOut(10000);
                                               window.location = d.redirect;
                                    }
                                }
                            });
                            ///////////////////////sliding layout/////////////
         $('.from').datepicker();                   
         $('#summary').live('click',function(){
		 $('#editsummary').toggle('show');
		 $('#showsummary').toggle('hide');
	 })
	  $('#sum_cancel').live('click',function(){
		 $('#editsummary').toggle('hide');
	 })
	 //--------------------------------------------experiance
	 $('#addexpbtn').live('click',function(){
		 $('#addexperiance').toggle('slow');
		 //$('#editexperiance').toggle('hide');
		 $('#showexperiance').toggle('hide');
	 })
	 $('#add_exp').live('click',function(){
		 $('#addexperiance').toggle('hide');
		 //$('#editexperiance').toggle('hide');
		 $('#showexperiance').toggle('show');
	 })
	 $('#exp_cancel').live('click',function(){
		 $('#addexperiance').toggle('hide');
		 //$('#editexperiance').toggle('hide');
		 $('#showexperiance').toggle('show');
	 })
	 //--------------------------------------------education
	  $('#addedubtn').live('click',function(){
		 $('#addeducation').toggle('slow');
		 //$('#editeducation').toggle('hide');
		 $('#showeducation').toggle('hide');
	 })
	 $('#add_edu').live('click',function(){
		 $('#addeducation').toggle('hide');
		// $('#editeducation').toggle('hide');
		 $('#showeducation').toggle('show');
	 })
	 $('#edu_cancel').live('click',function(){
		 $('#addeducation').toggle('hide');
		 //$('#editexperiance').toggle('hide');
		 $('#showeducation').toggle('show');
	 })
	 //------------------------------activity
	 $('#activity').live('click',function(){		 
		 $('#editactivity').toggle('show');
	 })
         //-------------------------------------skills
         $('#addskillbtn').live('click',function(){
		 $('#addskill').toggle('slow');
		 $('#showskill').toggle('hide');
	 });
          $('#add_skill').live('click',function(){
		 $('#addskill').toggle('hide');
		 $('#showskill').toggle('show');
	 });
	 $('#skill_cancel').live('click',function(){
		 $('#addskill').toggle('hide');
		 $('#showskill').toggle('show');
	 });
         
  });
                            </script>   
                       