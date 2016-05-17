<?php echo $this->element("admin_header"); ?>
<?php echo $this->element("admin_topright"); ?>
<?php echo $this->element("admin_nav"); ?>
<?php echo $this->element("admin_sidebar"); ?> 
<style type="text/css">
.grid2 a{text-decoration:none;}
.grid2 a : hover{text-decoration:none; color:white}
</style>
<!--------------------------->
<script>
$(document).ready(function(){
    $("#genrate_link").click(function(){
		$.ajax({
		        type:"POST",
				url : "http://dev414.trigma.us/N-166/admin/users/genrate_url/"+<?php echo $id; ?>,
		        success:function(result)
		        {
					$("#link").val(result);
				}
		    });
    });
}); 
</script>
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
                 <li class="current"><a href="javascript:void:(0)">Send Password <?php if($use['User']['usertype_id']==6){ echo "User";}else if($use['User']['usertype_id']==5){echo "Admin";} ?></a></li>
            </ul>
        </div>
    </div>
    
    <!-- Main content -->
    <div class="wrapper">

    
    	<!-- Chart -->
 
            
         <div class="widget fluid">
        <div class="whead"><h6>Send Link <?php if($use['User']['usertype_id']==6){ echo "User";}else if($use['User']['usertype_id']==5){echo "Admin";} ?></h6></div>
        <div id="dyn" class="hiddenpars">
             <?php echo $this->Form->create('User',array('id'=>'validate')); ?>
                <input type="hidden" value="<?php echo $use['User']['id'] ?>" name="edt_id" />
                <div class="formRow">
                    <div class="grid3"><label>Email:<em style="color:red;">*</em></label></div>
                    <div class="grid9">
                    <?php echo $this->Form->input('email', array('label'=>"",'type'=>'email','required'));?>
					
                    </div>
                </div>
				<div class="formRow">
                    <div class="grid3"><label></label></div>
                    <div class="save_but">
                               <button type="submit" name="Save" id="update" class="buttonS bLightBlue" >Send</button>
                    </div>
					 <div class="grid2">
                               <a  href="<?php echo $this->webroot; ?>admin/users" class="buttonS bLightBlue" >Cancel</a>
                    </div>
                </div>
				<div class="formRow">
                    <div class="grid3"><label></label></div>
                    <div class="save_but">
                              <h6 style="color:red;margin-left:30px;">OR</h6>
                    </div>
                </div>
				<div class="formRow">
                    <div class="grid3"><label>Genrate Link to send to User:<em style="color:red;">*</em></label></div>
                    <div class="grid9">
                    <textarea name="data[User][link]" id="link"></textarea>
					<a type="submit" id="genrate_link" class="buttonS bLightBlue">Click to Genrate</a>
                    </div>				
                </div>
				
           </form>
     
        </div>  
          
        </div>        
    </div>
</div>
      