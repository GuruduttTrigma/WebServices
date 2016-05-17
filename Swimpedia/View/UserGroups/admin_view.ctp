<?php echo $this->element("admin_header"); ?>
<?php echo $this->element("admin_topright"); ?>
<?php echo $this->element("admin_nav"); ?>
<?php echo $this->element("admin_sidebar"); ?>
<div id="content">
    <div class="contentTop">
        <span class="pageTitle"><span class="icon-screen"></span>User Group Management</span>
       
    </div>
    <!-- Breadcrumbs line -->
    <div class="breadLine">
        <div class="bc">
            <ul id="breadcrumbs" class="breadcrumbs">
                <li><a href="<?php echo $this->Html->url(array('controller'=>'Users','action'=>'admin_dashboard')); ?>">Dashboard</a></li>
                <li ><a href="<?php echo $this->Html->url(array('controller'=>'UserGroups','action'=>'admin_index')); ?>">User Group Management</a></li>
                 <li class="current"><a href="<?php echo $this->Html->url(array('controller'=>'UserGroups','action'=>'admin_view',$userGroup['UserGroup']['id'])); ?>">User Group View</a></li>
            </ul>
        </div>
    </div>
    <div class="wrapper">
      <div class="widget fluid">
        <div class="whead"><h5>Group Details</h5></div>
        <div id="dyn" class="hiddenpars">
        <div class="formRow">
                    <div class="grid3"></div>
                    
 <div class="grid9">
  <div style="height:120px;width:125px;border:1px solid;margin-left:25px;">
 <?php  echo $this->Html->image('/files/grouplogo/'.$userGroup['UserGroup']['logo'],array('style'=>'height:120px;width:125px;')); ?></div></div>
 </div>
<div class="formRow">
                    <div class="grid3"><label><b>Group Name:</b>&nbsp;</label></div>
<div class="grid9"><?php  echo $userGroup['UserGroup']['group_name'];?> </div>
</div>
<div class="formRow">
                    <div class="grid3"><label><b>Group Type:</b>&nbsp;</label></div>
<div class="grid9"><?php  echo $userGroup['UserGroup']['group_type'];?> </div>
</div>
<div class="formRow">
                    <div class="grid3"><label><b>Summary:</b>&nbsp;</label></div>
<div class="grid9"><?php  echo substr($userGroup['UserGroup']['summary'],0,50);?> </div>
</div>
<div class="formRow">
                    <div class="grid3"><label><b>Description:</b>&nbsp;</label></div>
<div class="grid9" align="justify"><?php  echo $userGroup['UserGroup']['description'];?> </div>
</div>
<div class="formRow">
                    <div class="grid3"><label><b>Website:</b>&nbsp;</label></div>
<div class="grid9"><?php  echo $userGroup['UserGroup']['website'];?> </div>
</div>
<div class="formRow">
                    <div class="grid3"><label><b>Group Owner Email:</b>&nbsp;</label></div>
<div class="grid9"><?php  echo $userGroup['UserGroup']['group_owner_email'];?> </div>
</div>

<div class="formRow">
                    <div class="grid3"><label><b>Auto Join:</b>&nbsp;</label></div>
<div class="grid9"><?php  $c1=$userGroup['UserGroup']['auto_join'];
if($c1==1){
	echo "Yes";
}else{
	echo "No";
}

?> </div>
</div>
<div class="formRow">
                    <div class="grid3"><label><b>Request For Join:</b>&nbsp;</label></div>
<div class="grid9"><?php  $c1=$userGroup['UserGroup']['request_for_join'];
if($c1==1){
	echo "Yes";
}else{
	echo "No";
}

?> </div>
</div>
<div class="formRow">
                    <div class="grid3"><label><b>Logo Allow:</b>&nbsp;</label></div>
<div class="grid9"><?php  $c1=$userGroup['UserGroup']['logo allow'];
if($c1==1){
	echo "Yes";
}else{
	echo "No";
}

?> </div>
</div>
<div class="formRow">
                    <div class="grid3"><label><b>Invite Others:</b>&nbsp;</label></div>
<div class="grid9"><?php  $c1=$userGroup['UserGroup']['invite_others'];
if($c1==1){
	echo "Yes";
}else{
	echo "No";
}

?> </div>
</div>
<div class="formRow">
                    <div class="grid3"><label><b>Pre Approve:</b>&nbsp;</label></div>
<div class="grid9"><?php  $c1=$userGroup['UserGroup']['pre_approve'];
if($c1==1){
	echo "Yes";
}else{
	echo "No";
}

?> </div>
</div>
<div class="formRow">
                    <div class="grid3"><label><b>Location:</b>&nbsp;</label></div>
<div class="grid9"><?php  $c1=$userGroup['UserGroup']['location'];
if($c1==1){
	echo "Yes";
}else{
	echo "No";
}

?> </div>
</div>
<div class="formRow">
                    <div class="grid3"><label><b>Aggrement:</b>&nbsp;</label></div>
<div class="grid9"><?php  $c1=$userGroup['UserGroup']['aggrement'];
if($c1==1){
	echo "Yes";
}else{
	echo "No";
}

?> </div>
</div>
<div class="formRow">
                    <div class="grid3"><label><b>Status:</b>&nbsp;</label></div>
<div class="grid9"><?php  echo $userGroup['UserGroup']['status'];?> </div>
</div>
		
</div>
</div>
</div>
</div>
</div>