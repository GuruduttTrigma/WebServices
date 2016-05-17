<?php echo $this->element("admin_header"); ?>
<?php echo $this->element("admin_topright"); ?>
<?php echo $this->element("admin_nav"); ?>
<?php echo $this->element("admin_sidebar"); ?> 
<div id="content">
    <div class="contentTop">
        <span class="pageTitle"><span class="icon-screen"></span>User Group Management</span>
        <ul class="quickStats">
            <li>
                <a href="" class="blueImg"><?php echo $this->Html->Image('../images/icons/quickstats/user.png'); ?></a>
                <div class="floatR"><strong class="blue"><?php echo count($userGroups);?></strong><span>User Group</span></div>
            </li>
        </ul>
    </div>
    <!-- Breadcrumbs line -->
    <div class="breadLine">
        <div class="bc">
            <ul id="breadcrumbs" class="breadcrumbs">
                <li><a href="<?php echo $this->Html->url(array('controller'=>'Users','action'=>'admin_dashboard')); ?>">Dashboard</a></li>
                <li class="current"><a href="<?php echo $this->Html->url(array('controller'=>'UserGroups','action'=>'admin_index')); ?>">User Group Management</a></li>
            </ul>
        </div>
    </div>
    <div class="wrapper">
    <?php $x=$this->Session->flash(); ?>
     <?php if($x){ ?>
     <div class="nNote nSuccess" id="flash">
       <div class="alert alert-success" style="text-align:center" ><?php echo $x; ?></div>
     </div><?php } ?>
        <ul class="middleNavA">
            <li><a href="<?php echo $this->Html->url(array('controller'=>'UserGroups','action'=>'admin_add')); ?>" title="Add User Group"  class="tool-tip"><img src="../images/icons/color/hire-me.png" alt="" /><span>Add User Group</span></a></li>
            
        </ul>  
    <div class="widget check grid6">
        <div class="whead">
        <!--<span class="titleIcon"><div id="uniform-titleCheck" class="checker">--><span class="titleIcon">
        <input title="Select All" class="tool-tip" id="titleCheck" name="titleCheck" type="checkbox"></span>
        <!--</div></span>--><h6>User Group Management</h6>
        
		 <?php echo $this->Form->create('UserGroup', array('controller'=>'UserGroups','action'=>'index')); ?>
		<div style="margin-top:2px;">
		<?php echo $this->Form->select('listing',array("All"=>"All","Groupname"=>"Groupname","Grouptype"=>"Grouptype","Active"=>"Active","Deactive"=>"Deactive"),array('style'=>'width:90px;margin-left:80px;margin-top:3px;','class'=>'styled'));?>
		<span id="search" style="margin-right:70px; display:block; background:none; top:-6px;" class="topSearch">
		<input placeholder="search..." class="tool-tip"  style="width:100px !important;" title="" name="keyword" type="text">
       <input value="" type="submit" name="search">
		</span></div>
         <?php echo $this->Form->end();?>
        </div>
        <div id="dyn" class="hiddenpars">
            <a class="tOptions"><img src="../images/icons/options" alt="" /></a>
             <?php  echo $this->Form->create('UserGroup',array("action" => "deleteall",'id' => 'mbc')); ?>
            <table cellpadding="0" cellspacing="0" class="tDefault checkAll tMedia" id="checkAll" width="100%">
            <thead>
            <tr>
            <th></th>
            <th><?php echo $this->Paginator->sort('user_name'); ?></span></th>
            <th><?php echo $this->Paginator->sort('group_name'); ?></th>
           <th><?php echo $this->Paginator->sort('group_type'); ?></th>
           <th><?php echo $this->Paginator->sort('status'); ?></th>
            <th>Action</th>
            </tr>
             </thead>
            <tbody>
            <?php //debug($userGroups);exit; ?>
            <?php  foreach (@$userGroups as $userGroup): ?>
            
            <tr class="gradeX">
             <td><?php echo $this->Form->checkbox("use"+$userGroup['UserGroup']['id'],array('value' => $userGroup['UserGroup']['id'],'class'=>'checkAll')); ?></td>
            
            <td><?php  echo h($userGroup['User']['first_name']); ?></td>
            <td><?php echo h($userGroup['UserGroup']['group_name']); ?></td>
             <td><?php echo h($userGroup['UserGroup']['group_type']); ?></td>
              <td><?php echo h($userGroup['UserGroup']['status']); ?></td>
            
            <td class="center">
             <form></form>
            
             <?php echo $this->Form->postLink('<span class="iconb" data-icon="&#xe136;"></span>',array('controller'=>'UserGroups','action'=>'delete',$userGroup['UserGroup']['id']),array('escape'=>false,'class'=>'tablectrl_small bDefault tipS tool-tip','title'=>'Delete'));?>    
             <?php if ($userGroup['UserGroup']['status']=='Deactive'){?>
			<?php echo $this->Form->postLink('<span class="iconb" data-icon="&#xe1bf;"></span>', array('action' => 'activate', $userGroup['UserGroup']['id']),array('escape'=>false,'class'=>'tablectrl_small bDefault tipS tool-tip','title'=>'Active'));?><?php }else { ?>
 <?php echo $this->Form->postLink('<span class="iconb" data-icon="&#xe1c1;"></span>', array('action' => 'block', $userGroup['UserGroup']['id']), array('escape'=>false,'class'=>'tablectrl_small bDefault tipS tool-tip','title'=>'Block')); ?><?php }?>
 <?php echo $this->Form->postLink('<span class="iconb" data-icon="&#xe067;"></span>',array('controller'=>'UserGroups','action'=>'view',$userGroup['UserGroup']['id']),array('escape'=>false,'class'=>'tablectrl_small bDefault tipS tool-tip','title'=>'View'));?>         
			
			
            </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
            </table> 
            <br/><br/>
            <button onclick="$('#mbc').submit();" value="Delete" class="buttonS bRed" style="margin-left:20px"> Delete All</button>
<button class="buttonS bGreen" style="margin-left:40px" name="delete" value="Activate" onclick=" $('#mbc').attr({'action':'UserGroups/activateall'}); $('#mbc').submit();">Activate</button>
<button class="buttonS bBlue" style="margin-left:40px" name="delete" value="Activate" onclick=" $('#mbc').attr({'action':'UserGroups/deactivateall'}); $('#mbc').submit();">Deactive</button>    

           <div class="tPages">
              <ul class="pages">
               <!--<li class="prev"><?php //echo $this->Paginator->prev('' ,null, null, array('class' => 'icon-arrow-14'));?></li>-->
               <li><?php echo $this->Paginator->numbers(); ?>&nbsp;&nbsp;</li>
               <!--<li class="next"><?php //echo $this->Paginator->next('', null, null, array('class' => 'icon-arrow-17'));?></li>-->
               <!-- prints X of Y, where X is current page and Y is number of pages -->
               <?php //echo $this->Paginator->counter(); ?>
              </ul>
            </div>
		      <?php //debug($this->Paginator->numbers()); ?>
              <div style="margin-top:10px;"></div>
           </form>
             </div>  
        </div>        
    </div>
</div>
</div>


