<?php echo $this->element('top-header'); ?>
<?php echo $this->Html->script(array('jquery.hovercard')); ?>
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
<div class="row-fluid">
   <div class="span5" style="margin-left:20px;">  
   <div class="well-small well">
     <h4 style="margin-left:2px;">My Groups</h4>
<?php 
//$all = $grupjoin;
if($grupjoin){
 foreach($grupjoin as $group): 
    //if($group['UserGroup']['group_name']==NULL){echo "You are not a member of any Groups.";} ?>  
<div class="well well-small tio_news">
            <a href="<?php echo $this->Html->url(array('controller'=>'UserGroups','action'=>'home_group',$group['UserGroup']['group_name'])); ?>">
            <?php if($group['UserGroup']['logo']){?>
             <?php    echo $this->Html->image('/files/grouplogo/'.$group['UserGroup']['logo'],array('style'=>'height:100px;width:250px;'));} ?>
<!--                        <img style="height:100px; width:250px;margin-bottom:10px;" src="/img/joblogo.png"/>-->
            <?php  ?>
            </a>
            <p>
                <a href="<?php echo $this->Html->url(array('controller'=>'UserGroups','action'=>'home_group',$group['UserGroup']['group_name'])); ?>" style="text-decoration:none;">
                   <?php echo $group['UserGroup']['group_name']; ?>
               </a>
            </p>
           <p align="justify"><?php echo substr($group['UserGroup']['description'],0,250); ?></p><br/><br/>
                          
</div>
<?php  endforeach;}else{ ?>
 <p align="justify">You are not a member of any Groups  </p>
<?php } ?>  
   </div>
   </div>
           
   <div class="span6" style="background-color:white;margin-right:20px;">
      <div class="top">
          <?php if($mayjoin){ ?>
<div class="well-small well">
   <h4>Groups I might like to join</h4> 
<?php foreach($mayjoin as $group):  foreach($grupjoin as $grou){ if($group['UserGroup']['user_id']!= $grou['Groupjoin']['user_id']){ ?>    
<div class="well well-small tio_news">
            <a href="<?php echo $this->Html->url(array('controller'=>'UserGroups','action'=>'home_group',$group['UserGroup']['group_name'])); ?>">
            <?php if($group['UserGroup']['logo']){?>
             <?php    echo $this->Html->image('/files/grouplogo/'.$group['UserGroup']['logo'],array('style'=>'height:100px;width:250px;'));}else{ ?>
                        <img style="height:100px; width:250px;margin-bottom:10px;" src="/img/joblogo.png"/>
            <?php } ?>
            </a>
            <p>
                <a href="<?php echo $this->Html->url(array('controller'=>'UserGroups','action'=>'home_group',$group['UserGroup']['group_name'])); ?>" style="text-decoration:none;">
                   <?php echo $group['UserGroup']['group_name']; ?>
               </a>
            </p>
           <p align="justify"><?php echo substr($group['UserGroup']['description'],0,250); ?></p><br/><br/>
                          
        </div> 
<?php break; }} endforeach; ?>  
</div>
          <?php } ?>
              <div class="well" style="margin-top:15px;">
                <h4>Search for Groups</h4>   <br/>           
	          <div class="input-append" style="">
                       <?php echo $this->Form->create('UserGroup',array('type'=>'post', 'action'=>'group_search','id'=>'com_post','class'=>"form-search")); ?>
         <input type="text" class="span7" name="search" placeholder="Enter Group Name...">
         <button type="submit" class="btn btn-primary">Search</button>
         </form>
                    <?php //echo $this->Form->create('UserGroup',array('type'=>'post', 'action'=>'group_search','id'=>'com_post','class'=>"form-search")); ?>
<!--                      <input type="text" class="span7" name="search" placeholder="Keywords">
                    <div class="btn-group">
                        <button class="btn btn-primary" type="submit">Search</button>                        
                    </div>
                   </form>                   -->
                 </div>      	
                </div>
      </div>
   </div>    
				 
    
</div>
<br/><br/><br/><br/>
<?php  echo $this->element('footer'); ?>
 <!-- <a href="somelink" data-hovercard="barackobama" class="hoverme" > Barack Obama </a>. 
  <div  class="demo-basic">
  </div>                      
   
<script type="text/javascript">
$(document).ready(function () {
	$(".hoverme").hovercard({ showTwitterCard: true });	
    var hoverHTMLDemoBasic = '<p>' +
        'John Resig is an application developer at Khan Academy.
            He was a ' +
        'JavaScript tool developer for the Mozilla Corporation.
            He is also the' +
        'creator and lead developer of the jQuery JavaScript
            library.<p>';

    $(".demo-basic").hovercard({
        detailsHTML: hoverHTMLDemoBasic,
        width: 400,
        cardImgSrc: 'http://ejohn.org/files/short.sm.jpg'
    });
});
</script>	-->	   