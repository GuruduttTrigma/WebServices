
<script>
 $(document).ready(function(){
     console.log("Hello");
	 $(".columns").equalHeights();
 });
</script>
<div class="container-fluid">
           <div class="row-fluid">
			         <div class="span8 columns" id="bgcolor" style="margin-left:5px;">
	<table width="100%" id="bgcolor" height="167">
		<tr>
			<td width="50%" align="right"> <a href="http://linked.apnaphp.com"><span class="logo"><?php echo $this->Html->image('ss_44.png'); ?></span></a></td>
			<td width="50%"  >
				<div style="padding-top:60px;" class="hidden-phone" id="login" >
				
				  <p>MATCHING ACADEMICS</p>
				  <p>WITH COMPANIES AND</p>
				  <p>LIKEMINDED PEOPLE</p>
			   </div>
			</td>
		</tr>
	</table>

	</div>
					 <div class="span4 columns" style="margin-left:5px">
	     <div class="loginbg">
		     <div class="login">
			  <?php if(!$user_id){ ?>
			   <b>ALREADY A MEMBER</b><br>
				<a href="<?php echo $this->Html->url(array('controller'=>'users','action'=>'loggedin')); ?>"><b class="righttext2">SIGN IN HERE</b></a> or<br>
				<a href="http://linked.apnaphp.com"><b class="righttext2">SIGN UP HERE</b></a>
                <br />
              
               
				
				<?php } ?>
				<?php echo $this->Form->create('User',array('type'=>'post', 'action'=>'profile_search','id'=>'com_post','class'=>"form-search")); ?>
        <b>Search People</b><input type="text" class="input-medium search-query" name="search" placeholder="Enter name or username....." style="margin-left:3px;">
    <button type="submit" class="btn">Search</button>
    </form>
				 				  <div>
				      <!-- <table width="40%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><a href="#"><img src="img/socialico03_09.png" width="25" height="27" /></a></td>
    <td><a href="#"><img src="img/socialico03_07.png" width="25" height="27" /></a></td>
    <td><a href="#"><img src="img/socialico03_14.png" width="25" height="27" /></a></td>
    <td><a href="#"><img src="img/socialico03_03.png" width="25" height="27" /></a></td>
  </tr>
</table>-->

				  </div> 
			 </p>			 
			 </div>
		 
	
		 </div>
	
	</div>
<!--second section -->
<div class="row-fluid">
			         <div class="span12" style="margin-left:5px; margin-top:5px;">
						<div id="bg2" style="background-color:white;border:1px solid #D4D0C8;width:45%;margin-left:25%;margin-top:100px;">
<?php echo $this->Form->create('User', array('controller'=>'Users','action' => 'login','id'=>'frmlogin','class'=>'form-horizontal')); ?>
						<!-- <form class="form-horizontal" id="registerHere" method='post' action=''>-->
<fieldset>

<legend class="pad" style="padding-left:20px;"><font color="#595A5C">Login</font></legend>

<div class="control-group">
   <label class="control-label" style="padding-top:20px;">Username</label>
   <div class="controls">
     <?php echo $this->Form->input('username', array('label' => "",'div'=>'false','type'=>'text','class'=>'inpp','placeholder'=>'Enter Username'));  ?>
   </div>
</div>

<div class="control-group">
   <label class="control-label"  style="padding-top:5px;">Password</label>
    <div class="controls" style="margin-left:180px;">
      <?php echo $this->Form->password('password', array('label' => "",'div'=>'false','type'=>'password','class'=>'inpp','placeholder'=>'Enter Password'));?>
    </div>
</div>

<div class="control-group">
    <label class="control-label"></label>
  <div class="controls">
<button type="submit" class="btn btn-success">Login</button>
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
					 <!-- <div class="span4" style="margin-left:5px; margin-top:5px;">
	     				<div id="bg2"></div>
	
					</div>-->
</div>