<?php echo $this->element('top-header'); ?>
<!-- -------------------------- -->
<script type="text/javascript">
$(document).ready(function() {
	
<?php if(@$r = $this->Session->flash()){?>	
   alert(<?php echo $r; ?>);
<?php } ?>   
});
</script>
<!-- --------------------------------- -->
<style>
.img:hover {box-shadow:2px 2px 2px;}
</style>
<div class="row-fluid" style="margin-bottom:100px;">
  
           
   <div class="span8" style="background-color:white;">
       <div class="span12">
                    <?php $x=$this->Session->flash(); ?>
                    <?php if($x){ ?>
                     <div class="alert alert-block" style="margin-left:10px; margin-top:5px; width:88%;background-color:#5DA150;color:white;">
<button type="button" class="close" data-dismiss="alert">&times;</button>                
                    <strong><?php echo $x; ?></strong>
                   </div>
                   <?php }?> 
                    </div>
       <div class="top">
       <h6>Groups You May Like</h6><hr/>
       <?php foreach($user_group as $group): if($group['UserGroup']['user_id'] != $user_id){ ?>
       <div style="margin-top:10px;">
      <a href="<?php echo $this->Html->url(array('controller'=>'UserGroups','action'=>'home_group',$group['UserGroup']['group_name'])); ?>" style="text-decoration:none;"> 
 <?php echo $this->Html->image('/files/grouplogo/'.$group['UserGroup']['logo'],array('style'=>'height:75px;width:75px;','hspace'=>'5','class'=>'img')); ?></a>
<span style="margin-left:10%;" class="callback"><b><?php echo $group['UserGroup']['group_name']; ?></b><b>-</b></span>
<span style="margin-left:1%;"><?php echo substr($group['UserGroup']['description'],0,60)."....."; ?></span>
<span style="float:right"><a href="<?php echo $this->Html->url(array('controller'=>'UserGroups','action'=>'home_group',$group['UserGroup']['group_name'])); ?>" style="text-decoration:none;" class="btn btn-mini btn-primary">View</span></a>
</div>
<script type="text/javascript">
$(document).ready(function () {
    
    var hoverHTMLDemoCallback = '<p><b>';
    hoverHTMLDemoCallback +=  '<?php echo $group['UserGroup']['group_name'];  ?>';
    hoverHTMLDemoCallback +=  '</b><br/><?php echo $this->Html->image('/files/grouplogo/'.$group['UserGroup']['logo'],array('style'=>'height:50px;width:50px;','hspace'=>'5')); ?>';
    hoverHTMLDemoCallback +=  '<?php echo substr($group['UserGroup']['description'],0,100)."....."; ?>.<p>';

    $(".callback").hovercard({
        detailsHTML: hoverHTMLDemoCallback,
        width: 350,
        cardImgSrc: '',
        onHoverIn: function () {
        	 $.notify('We see you just hovered over the label! <br/>Callback function <strong>"onHoverIn"</strong>. ', {
                     background: '#ffffbb',
                     autoHide: true,
                     autoHideDelay: 1000,
                     clickAnywhereToClose: true,
                     position: "bottom-right",
                     width: 100
                 });

        }
    });
});
</script>
       <?php } endforeach; ?>
       
<?php echo $this->Html->script(array('jquery.hovercard')); ?>
   
       </div>
   </div>    
				 
     <div class="span4">
   <br/><br/>
   <div>
   <?php echo $this->Form->create('UserGroup',array('type'=>'post', 'action'=>'group_search','id'=>'com_post','class'=>"form-search")); ?>
<input type="text" class="input-medium search-query" name="search" placeholder="Enter Group Name..." style="margin-left:3px;">
<button type="submit" class="btn">Search</button>
</form>
<span style="margin-left:100px;">
<h5>What conversation would <br/>you like to have?</h5><br/>
<a href="<?php echo $this->Html->url(array('controller'=>'UserGroups','action'=>'group_add')) ?>" class="btn btn-success">Create a Group</a>
   </span>
   </div>
   </div>
</div>
<?php  echo $this->element('footer');
 ?>