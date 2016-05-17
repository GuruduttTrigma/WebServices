<?php echo $this->element('top-header'); ?>
<div class="row-fluid" > 
			   <div class="span8" >
                   <ul class="nav nav-tabs" id="myTab">
                        <li><a href="#messages">Change Password</a></li>
                        <li><a href="#settings">Account Settings</a></li>
                        <li><a href="#privacy">Privacy</a></li>
                    </ul>
                               
                    <div class="span12">
                    <?php $x=$this->Session->flash(); ?>
                    <?php if($x){ ?>
                     <div class="alert alert-block" style="margin-left:10px; margin-top:5px; width:88%;background-color:#5DA150;color:white;">
<button type="button" class="close" data-dismiss="alert">&times;</button>                
                    <strong><?php echo $x; ?></strong>
                   </div>
                   <?php }?> 
                    </div>
               <div class="tab-content">
                    <div class="tab-pane" id="messages">
                    <?php echo $this->Form->create('User',array('action'=>'setting','method'=>'post','class'=>'form-horizontal add_exp')); ?>
                    
     <div class="control-group">
    <label class="control-label">Old Password:</label>
	<div class="controls">
		<?php  echo $this->Form->input('password',array('label'=>"",'div'=>'false','placeholder'=>'Old Password...','type'=>'password'));?>
	</div>
  </div>
   <div class="control-group">
    <label class="control-label">New Password:</label>
	<div class="controls">
		<?php  echo $this->Form->input('npassword',array('label'=>"",'div'=>'false','placeholder'=>'New Password...','type'=>'password'));?>
	</div>
  </div>
   <div class="control-group">
    <label class="control-label">Confirm Password:</label>
	<div class="controls">
		<?php  echo $this->Form->input('cpassword',array('label'=>"",'div'=>'false','placeholder'=>'Confirm Password...','type'=>'password'));?>
	</div>
  </div>
  <div class="control-group">
	  <div class="controls">
		<button type="submit" name="save" id="update" class="btn btn-primary save" >Save</button>
    
	  </div>
           </div>
           </form>
                   </div>
                   
                    <div class="tab-pane" id="settings">
                     <?php echo $this->Form->create('User',array('action'=>'accountsetting','method'=>'post','class'=>'form-horizontal add_exp')); ?>
                <?php  echo $this->Form->input('id',array('label'=>"",'div'=>'false','type'=>'hidden','value'=>$user_id));?>
                       <div class="control-group">
    <label class="control-label">User Name:</label>
	<div class="controls">
		<?php  echo $this->Form->input('username',array('label'=>"",'div'=>'false','type'=>'text','value'=>$account['User']['username']));?>
	</div>
  </div>
   <div class="control-group">
    <label class="control-label">First Name:</label>
	<div class="controls">
		<?php  echo $this->Form->input('first_name',array('label'=>"",'div'=>'false','type'=>'text','value'=>$account['User']['first_name']));?>
	</div>
  </div>
   <div class="control-group">
    <label class="control-label">Last Name:</label>
	<div class="controls">
		<?php  echo $this->Form->input('last_name',array('label'=>"",'div'=>'false','type'=>'text','value'=>$account['User']['last_name']));?>
	</div>
  </div>
   <div class="control-group">
    <label class="control-label">Email:</label>
	<div class="controls">
		<?php  echo $this->Form->input('email',array('label'=>"",'div'=>'false','type'=>'text','value'=>$account['User']['email']));?>
	</div>
  </div>
   <div class="control-group">
    <label class="control-label">Contact Number:</label>
	<div class="controls">
		<?php  echo $this->Form->input('contact',array('label'=>"",'div'=>'false','type'=>'text','value'=>$account['User']['contact']));?>
	</div>
  </div>
   <div class="control-group">
    <label class="control-label">Home Town:</label>
	<div class="controls">
		<?php  echo $this->Form->input('home_town',array('label'=>"",'div'=>'false','type'=>'text','value'=>$account['User']['home_town']));?>
	</div>
  </div>
  <div class="control-group">
	  <div class="controls">
		<button type="submit" name="save" id="update" class="btn btn-primary save" >Save</button>
    
	  </div>
           </div>
           </form>
  </div>
   <div class="tab-pane" id="privacy">
    <?php echo $this->Form->create('User',array('action'=>'privacyset','method'=>'post','class'=>'form-horizontal add_exp')); ?>
    <?php  echo $this->Form->input('id',array('label'=>"",'div'=>'false','type'=>'hidden','value'=>$user_id));?>
    <div class="control-group" style="margin-left:100px;">
    <label class="control-label">Account Privacy:</label>
    <?php  //debug($privacy);exit;?>
   <div class="controls" >
		<button type="submit" name="save" id="update" class="btn btn-inverse save" ><?php if($account['User']['status'] == 'Active'){?>Deactive<?php }else{?>Active<?php }?></button>
	</div>
    
  </div>
 
   </form>
   </div>
                </div>
     
    <script>
    $(function () {
    $('#myTab a:first').tab('show');
	    $('#myTab a').click(function (e) {
    e.preventDefault();
    $(this).tab('show');
    })
    })
    </script>
               </div>
                <div class="span4">
                </div>
 </div>               
<?php  echo $this->element('footer');
 ?>