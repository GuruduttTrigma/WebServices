<?php echo $this->element('top-header'); ?>
<style>
.img:hover{box-shadow:2px 2px 2px;}
</style>
<div class="row-fluid">       
			  <div class="span8" style="background-color:white;">
       <div class="top">
<div class="well-small well">
  &nbsp;<strong>"<?php echo count($search); ?>" Results Found.<?php if(count($search) == '0'){echo "Please Search another group.";} ?></strong>
      <?php foreach($search as $group): ?>
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
           <p align="justify"><?php echo substr($group['UserGroup']['description'],0,250)."....."; ?></p><br/><br/>
                          
        </div>
       <?php  endforeach; ?>
</div>   
<?php echo $this->Html->script(array('jquery.hovercard')); ?>   
   </div></div>
		<!------------------left-------------->
<div class="span4 well" style="margin-bottom:100px;">
   <div style="padding-left:60px;padding-top:20px;">
            <?php echo $this->Form->create('UserGroup',array('type'=>'post', 'action'=>'group_search','id'=>'com_post','class'=>"form-search")); ?>
         <input type="text" class="input-medium search-query" name="search" placeholder="Enter Group Name..." style="margin-left:0px;">
         <button type="submit" class="btn">Search</button>
         </form>
         <span style="margin-left:100px;">
         <h5>What conversation would you like to have?</h5><br/>
         <a href="<?php echo $this->Html->url(array('controller'=>'UserGroups','action'=>'group_add')) ?>" class="btn btn-primary">Create a Group</a>
            </span>
   </div>
			

			   </div>
     <!------------------end-------->  		 
			   </div>
			  
				 </div>
	<?php  echo $this->element('footer');
 ?>
  