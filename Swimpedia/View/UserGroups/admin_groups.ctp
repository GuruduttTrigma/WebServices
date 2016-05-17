<?php echo $this->element("admin_header"); ?>
<?php echo $this->element("admin_topright"); ?>
<?php echo $this->element("admin_nav"); ?>
<?php echo $this->element("admin_sidebar"); ?> 
<div id="content">
    <div class="contentTop">
        <span class="pageTitle"><span class="icon-screen"></span>Group Management</span>
        <ul class="quickStats">
            <li>
                <a href="" class="blueImg"><?php echo $this->Html->Image('../images/icons/quickstats/user.png'); ?></a>
                <div class="floatR"><strong class="blue"><?php echo count($userGroups);?></strong><span>Group</span></div>
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
    <div class="widget check grid6">
        <div class="whead">
            <span class="titleIcon">
        <input title="Select All" class="tool-tip" id="titleCheck" name="titleCheck" type="checkbox"></span>
      <h6>Group Management</h6>
        </div>
        <div id="dyn" class="hiddenpars">
            <a class="tOptions"><img src="../images/icons/options" alt="" /></a>
             <?php  echo $this->Form->create('UserGroup',array("action" => "delall",'id' => 'mbc')); ?>
            <table cellpadding="0" cellspacing="0" class="tDefault checkAll tMedia" id="checkAll" width="100%">
            <thead>
            <tr>
            <th></th>
            <th><?php echo $this->Paginator->sort('user_name'); ?></span></th>
            <th><?php echo $this->Paginator->sort('group_name'); ?></th>
           <th><?php echo $this->Paginator->sort('group_type'); ?></th>
           <th><?php echo $this->Paginator->sort('status'); ?></th>
            </tr>
             </thead>
            <tbody>
            <?php  foreach (@$userGroups as $userGroup): ?>
            
            <tr class="gradeX">
             <td><?php echo $this->Form->checkbox("use"+$userGroup['UserGroup']['id'],array('value' => $userGroup['UserGroup']['id'],'class'=>'checkAll')); ?></td>
            
            <td><?php  echo h($userGroup['User']['first_name']); ?></td>
            <td><?php echo h($userGroup['UserGroup']['group_name']); ?></td>
             <td><?php echo h($userGroup['UserGroup']['group_type']); ?></td>
              <td><?php echo h($userGroup['UserGroup']['status']); ?></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
            </table> 
            <br/><br/>
            <button onclick="$('#mbc').submit();" value="Delete" class="buttonS bRed" style="margin-left:20px"> Delete All</button>
          <div class="tPages">
              <ul class="pages">
               <li><?php echo $this->Paginator->numbers(); ?>&nbsp;&nbsp;</li>
              </ul>
            </div>
              <div style="margin-top:10px;"></div>
           </form>
             </div>  
        </div>        
    </div>
</div>
</div>


