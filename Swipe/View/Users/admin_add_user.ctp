<?php echo $this->element("admin_header"); ?>
<?php echo $this->element("admin_topright"); ?>
<?php echo $this->element("admin_nav"); ?>
<?php echo $this->element("admin_sidebar"); ?> 
<!--------------------------->
<div id="content">
    <div class="contentTop">
        <span class="pageTitle"><span class="icon-screen"></span>User Management</span>
    </div>
     <!-- Breadcrumbs line -->
    <div class="breadLine">
        <div class="bc">
            <ul id="breadcrumbs" class="breadcrumbs">
                <li><a href="<?php echo $this->Html->url(array('controller'=>'Users','action'=>'admin_dashboard')); ?>">Dashboard</a></li>
                <li><a href="<?php echo $this->Html->url(array('controller'=>'Users','action'=>'admin_index')); ?>">User Management</a></li>
                 <li class="current"><a href="javascript:void:(0)">Add New User</a></li>
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
        <div class="whead"><h6>Add User</h6></div>
        <div id="dyn" class="hiddenpars">
             <?php //echo $this->Form->create('User',array('action'=>'admin_add_user','id'=>'validate','class'=>'form')); ?>
			  <form action="<?php $this->HTML->url(array('controllers'=>'users','action'=>'admin_add_user')); ?>" id='validate' class="form1" method="post" enctype="multipart/form-data">
                <div class="formRow">
                    <div class="grid3"><label>User Name:<em class="astresik">*</em></label></div>
                    <div class="grid9">
					<input type="text" name="data[User][username]" class="required" required>
                    </div>
                </div>
				 <div class="formRow">
                    <div class="grid3"><label>First Name:<em class="astresik">*</em></label></div>
                    <div class="grid9">
					<input type="text" name="data[User][first_name]" class="required" required >
                    </div>
                </div>
				 <div class="formRow">
                    <div class="grid3"><label>Last Name:<em class="astresik">*</em></label></div>
                    <div class="grid9">
					<input type="text" name="data[User][last_name]" class="required" required >
                    </div>
                </div>
                
                <div class="formRow">
                    <div class="grid3"><label>Email:<em class="astresik">*</em></label></div>
                    <div class="grid9">
                   <input type="text" name="data[User][email]" class="required" required >
                    </div>
                </div> 
                
                <div class="formRow">
                    <div class="grid3"><label>Password:<em class="astresik">*</em></label></div>
                    <div class="grid9">
                    <input type="password" name="data[User][password]" required class="pwd1" minlength=1>
					
                    </div>
                </div>  
				   <div class="formRow">
                    <div class="grid3"><label>Confirm Password:<em class="astresik">*</em></label></div>
                    <div class="grid9">
					<input type="password" name="data[User][con_password]" required class="conPwd" minlength=1 equalto = ".pwd1" >      </div>
					<div id="er_pl" class="astresik"></div>
                </div> 
				 <div class="formRow">
                    <div class="grid3"><label>Profile Image:</label></div>
                    <div class="grid9">
					<input type="file" name="data[User][profile_image]">
                    </div>
                </div> 
  
                <div class="formRow">
                    <div class="grid3"><label></label></div>
                    <div class="save_but">
                    <button type="submit" id="update" class="buttonS bLightBlue" >Save</button>
                    </div>
					<div class="grid2">
                    <a href="<?php echo $this->webroot; ?>admin/users/index" class="buttonS bLightBlue" >Cancel</a>
                    </div>
                </div>
           </form>
     
        </div>  
          
        </div>        
    </div>
</div>
<script type="text/javascript">
	var specialKeys = new Array();
	specialKeys.push(8); //Backspace
	$(function () {
		$(".numeric").bind("keypress", function (e) {
			var keyCode = e.which ? e.which : e.keyCode
			var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
			$(".error").css("display", ret ? "none" : "inline");
			return ret;
		});
		$(".numeric").bind("paste", function (e) {
			return false;
		});
		$(".numeric").bind("drop", function (e) {
			return false;
		});
	});
   $('#validate').validate();
</script>
 <script type="text/javascript">
                  $("#fname").keypress(function(e) {
    if(e.which < 97 /* a */ || e.which > 122 /* z */) {
        e.preventDefault();
	//return false;
   }
});
            $("#lname").keypress(function(e) {
    if(e.which < 97 /* a */ || e.which > 122 /* z */) {
        e.preventDefault();
    }
});

 </script>
<script type="text/javascript">
   $(document).ready(function(){
       
	   jQuery.validator.addMethod("phoneUS", function(phone_number, element) {
    phone_number = phone_number.replace(/\s+/g, "");
    return this.optional(element) || phone_number.length > 9 &&
        phone_number.match(/\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/);
		}, "Please specify a valid phone number");
	
	   $('#validate').validate();
	  
   });
</script>
      
