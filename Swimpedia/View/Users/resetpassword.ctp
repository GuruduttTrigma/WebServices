<?php 
 echo $this->element('top-header');
 ?>
	<div class="row-fluid" style="border-bottom:5px solid white;">
    
         <div class="span12">
     <div id="bg2" style="background-color:white;border:1px solid #D4D0C8;width:45%;margin-left:25%;margin-top:100px;margin-bottom:100px;">
<?php echo $this->Form->create('User', array('method'=>'post','class'=>'form-horizontal')); ?>
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
<div class="control-group">
   <label class="control-label" style="padding-top:20px;">Password</label>
   <div class="controls">
     <?php echo $this->Form->input('password', array('label' => "",'div'=>'false','type'=>'password','class'=>'inpp','placeholder'=>'Password..'));  ?>
   </div>
</div>
<div class="control-group">
   <label class="control-label" style="padding-top:20px;">Confirm Password</label>
   <div class="controls">
     <?php echo $this->Form->input('cpassword', array('label' => "",'div'=>'false','type'=>'password','class'=>'inpp','placeholder'=>'Confirm Password..'));  ?>
   </div>
</div>



<div class="control-group">
    <label class="control-label"></label>
  <div class="controls">
<button type="submit" class="btn btn-success">Submit</button>
<div class="lfileupErrordetection" style="color:red;"></div>
<div class="lfileupSuccess" style="color:green;"></div>



<?php echo $this->Html->script(array('jquery.form')); ?>
                        <script type="text/javascript">
                            $(document).ready(function(e){
                                $('#frmlogin').ajaxForm({
                                    before: function(event, position, total, percentComplete) {
                                        $('#lupPRc').html('<img src="https://www.caritas.us/sites/default/files/images/misc/loading.gif"/>');
                                        
                                    },
                                    complete: function(xhr) {
                                        
                                    },
                                    success: function(data){
                                        console.log(data);
                                        $('#lupPRc').html("");
                                        d = JSON.parse(data);
                                        console.log(d);
                                        if(d.error == 1){
                                            //$('.fileupError').html(d.message);
                                            $('.lfileupErrordetection').html(d.message);
                                        }else if(d.error == 0){
                                            $('.lfileupSuccess').html(d.message);
                                           window.location = d.redirect;
                                        }
                                    }
                                });
								
                            });
                        </script>

</div>
</div>

</fieldset>
</form>
						 </div>
	  
	     </div>
	</div>
<?php  echo $this->element('footer');
 ?>