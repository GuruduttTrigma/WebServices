<?php 
 echo $this->element('top-header');
 ?>
	<div class="row-fluid" style="border-bottom:5px solid white;">
    
         <div class="span12">
     <div id="bg2" style="background-color:white;border:1px solid #D4D0C8;width:45%;margin-left:25%;margin-top:100px;margin-bottom:100px;">
<?php echo $this->Form->create('User', array('controller'=>'Users','action' => 'forgetpassword','class'=>'form-horizontal')); ?>
						<!-- <form class="form-horizontal" id="registerHere" method='post' action=''>-->
<fieldset>

<legend class="pad" style="padding-left:20px;"><font color="#595A5C">Reset Password</font></legend>
<?php $x=$this->Session->flash(); ?>
                    <?php if($x){ ?>
                     <div class="alert alert-block" style="margin-left:10px; margin-top:5px; width:500px;background-color:#FCF;">
<button type="button" class="close" data-dismiss="alert">&times;</button>                
                    <strong><?php echo $x; ?></strong>
                   </div>
                   <?php }?> 
<div class="control-group" >
   <label class="control-label" style="padding-top:8px;">Email</label>
   <div class="controls" >
     <?php echo $this->Form->input('email', array('label' => "",'div'=>'false','type'=>'text','class'=>'inpp','placeholder'=>'Enter email..'));  ?>
   </div>
</div>



<div class="control-group" >

    <label class="control-label"></label>
  <div class="controls"  >
<button type="submit" class="btn btn-success">Send</button>
<div class="lfileupErrordetection" style="color:red;"></div>
<div class="lfileupSuccess" style="color:green;"></div>
<div style="float:right; margin-right:65px;margin-top:-10px;">
 <a href="<?php echo $this->Html->url(array('controller'=>'Users','action'=>'loggedin')); ?>"><?php echo "<<";?>&nbsp;Back</a>

</div>

</div>
</div>

</fieldset>
</form>
						 </div>
	  
	     </div>
	</div>
<?php  echo $this->element('footer');
 ?>