<div id="top">
	<div class="wrapper">
    	<?php echo $this->Html->image('ss_44.png',array('style'=>'height:50px;width:200px;margin-left:-20px;')); ?>
        
        <!-- Right top nav -->
       <!-- <div class="topNav">
            <ul class="userNav">
                <li><a href="#" title="" class="screen"></a></li>
                <li><a href="#" title="" class="settings"></a></li>
                <li><a href="#" title="" class="logout"></a></li>
            </ul>
        </div>-->
    </div>
</div>
<!-- Top line ends -->

<script type="text/javascript">
		$(document).ready(function(){
			$('#flash').live('click',function(){
				$('#flash').fadeOut(3000);
				});
		});        
        </script>
        
<!-- Login wrapper begins -->
<div class="loginWrapper">

	<!-- Current user form -->
   <?php echo $this->Form->create('User',array('method'=>'post')); ?>
        <div class="loginPic">
           <!-- <a href="#" title=""><img src="../images/userLogin.png" alt="" /></a>-->
      <span>Reset Password</span>
         <?php $x=$this->Session->flash(); if($x){ ?>
          <div class="nNote nSuccess" id="flash">
              <div class="alert alert-success" style="text-align:center;color:red;" ><?php echo $x; ?></div>
          </div><?php } ?>
            <!--<div class="loginActions">
                <div><a href="#" title="Change user" class="logleft flip"></a></div>
                <div><a href="#" title="Forgot password?" class="logright"></a></div>
            </div>-->
        </div>
      <?php echo $this->Form->input('password',array("type"=>"password",'label' => false,"name"=>"data[User][password]",'placeholder'=>"Password..." ,'id'=>'pass','class'=>'loginPassword')); ?>
         <?php echo $this->Form->input('password_confirm',array("type"=>"password",'label' => false,"name"=>"data[User][password_confirm]" , 'placeholder'=>'Confirm Password...','class'=>'loginPassword')); ?>
 
      
        <div class="logControl">
        <div style="float:left;margin-left:80px;">
        <input type="submit" name="submit" value="Save" class="buttonM bBlue" /></div>
        
        </div>
    </form>
    
    
    <!-- New user form -->
   <!-- <form action="index.html" id="recover">
        <div class="loginPic">
            <a href="#" title=""><img src="images/userLogin2.png" alt="" /></a>
            <div class="loginActions">
                <div><a href="#" title="" class="logback flip"></a></div>
                <div><a href="#" title="Forgot password?" class="logright"></a></div>
            </div>
        </div>
            
        <input type="text" name="login" placeholder="Your username" class="loginUsername" />
        <input type="password" name="password" placeholder="Password" class="loginPassword" />
        
        <div class="logControl">
            <div class="memory"><input type="checkbox" checked="checked" class="check" id="remember2" /><label for="remember2">Remember me</label></div>
            <input type="submit" name="submit" value="Login" class="buttonM bBlue" />
        </div>
    </form>-->

</div>