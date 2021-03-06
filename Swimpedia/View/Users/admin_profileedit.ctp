<?php echo $this->element("admin_header"); ?>
<?php echo $this->element("admin_topright"); ?>
<?php echo $this->element("admin_nav"); ?>
<?php echo $this->element("admin_sidebar"); ?> 

<!--------------------------->
<div id="content">
    <div class="contentTop">
        <span class="pageTitle"><span class="icon-screen"></span>Administrator Profile</span>
      
    </div>
     <!-- Breadcrumbs line -->
    <div class="breadLine">
        <div class="bc">
            <ul id="breadcrumbs" class="breadcrumbs">
                <li><a href="<?php echo $this->Html->url(array('controller'=>'Users','action'=>'admin_dashboard')); ?>">Dashboard</a></li>
                <li><a href="<?php echo $this->Html->url(array('controller'=>'Users','action'=>'admin_profile')); ?>">Administrator Profile</a></li>
                 <li class="current"><a href="javascript:void:(0)">Edit Administrator Profile</a></li>
            </ul>
        </div>
    </div>
    
    <!-- Main content -->
    <div class="wrapper">
    <?php $x=$this->Session->flash();if($x){ ?>
    <div class="nNote nSuccess" id="flash">
       <div class="alert alert-success" style="text-align:center" ><?php echo $x; ?></div>
     </div><?php } ?>
    	<!-- Chart -->
     <div class="widget fluid">
        <div class="whead"><h6>Edit</h6></div>
        <div id="dyn" class="hiddenpars">
             <?php echo $this->Form->create('User',array('action'=>'admin_profileedit','type'=>'file')); ?>
                <div class="formRow">
                    <div class="grid3"><label>Username:</label></div>
                    <div class="grid9">
                    <?php echo $this->Form->input('username', array('label'=>"",'type'=>'text','value'=>$profile['User']['username']));?>
                    </div>
                </div>
                 <div class="formRow">
                    <div class="grid3"><label>First Name:</label></div>
                    <div class="grid9">
                    <?php echo $this->Form->input('first_name', array('label'=>"",'type'=>'text'));?>
                    </div>
                </div>
            
             <div class="formRow">
                    <div class="grid3"><label>Last Name:</label></div>
                    <div class="grid9">
                    <?php echo $this->Form->input('last_name', array('label'=>"",'type'=>'text'));?>
                    </div>
                </div>
                <div class="formRow">
                    <div class="grid3"><label>Email:</label></div>
                    <div class="grid9">
                    <?php echo $this->Form->input('email', array('label'=>"",'type'=>'email','value'=>$profile['User']['email']));?>
                    </div>
                </div>                
                   
                <div class="formRow">
                    <div class="grid3"><label>Profile Image:</label></div>
                    <div class="grid9">
                    <?php echo $this->Form->input('profile_image', array('label'=>"",'type'=>'file')); ?>
                    </div>
                </div> 
                <div class="formRow">
                    <div class="grid3"><label>Contact No:</label></div>
                    <div class="grid9">
                    <?php echo $this->Form->input('contact', array('label'=>"",'type'=>'text','value'=>$profile['User']['contact']));?>
                    </div>
                </div>
                <div class="formRow">
                    <div class="grid3"><label>Home Town:</label></div>
                    <div class="grid9">
                    <?php echo $this->Form->input('home_town', array('label'=>"",'type'=>'text','value'=>$profile['User']['home_town']));?>
                    </div>
                </div>
               
                <div class="formRow">
                    <div class="grid3"><label></label></div>
                    <div class="grid9">
                    <button type="submit" name="Save" id="update" class="buttonS bLightBlue" >Save</button>
                    </div>
                </div>
           </form>
     
        </div>  
          
        </div>        
    </div>
</div>

      