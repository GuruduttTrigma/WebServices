<?php echo $this->element('top-header'); ?>
<div class="row-fluid" style="margin-top:25px;">
<div class="span8" style="background-color:white;">
<div class="span" style="margin-left:25px;">
<legend><span style="font-size:22px;"><b>See Who You Already Know on Academatch<hr></b></span></legend>
</div>
    <style type="text/css">
  .jai a:hover {
        height: 75px;width:120px;float: left;
	border: 1px solid #23639C ;
        background-color: #CECFCE;
        z-index:500;
}</style>
    <ul class="nav nav-tabs" id="myTab" >
                        <li class="active"><div style="height: 75px;width:120px;float: left;margin-left: 25px;border: 1px solid #CCCCCC;" class="jai"><a href="#gmail" data-toggle="tab" style="text-decoration: none;" ><div style="text-align: center;margin-top: 10px;"><?php echo $this->Html->image('social_10.png',array('height'=>'40px','width'=>'40px')); ?><br></div><div style="text-align: center;margin-top:14px ;">Gmail</div></a></div></li>
                        <li><div style="height: 75px;width:120px;float: left;margin-left: 7px;border: 1px solid #CCCCCC;" class="jai"><a href="#outlook" data-toggle="tab" style="text-decoration: none;"><div style="text-align: center;margin-top: 10px;"><?php echo $this->Html->image('social_03.png',array('height'=>'40px','width'=>'40px')); ?><br></div><div style="text-align: center;margin-top: 10px;">Outlook</div></a></div></li>
                        <li><div style="height: 75px;width:120px;float: left;margin-left: 7px;border: 1px solid #CCCCCC;" class="jai"><a href="#yahoo" data-toggle="tab" style="text-decoration: none;"><div style="text-align: center;margin-top: 10px;"><?php echo $this->Html->image('social_18.png',array('height'=>'40px','width'=>'40px')); ?><br></div><div style="text-align: center;margin-top: 7px;">Yahoo!Mail</div></a></div></li>   
                        <li><div style="height: 75px;width:120px;float: left;margin-left: 7px;border: 1px solid #CCCCCC;" class="jai"><a href="#hotmail" data-toggle="tab" style="text-decoration: none;"><div style="text-align: center;margin-top: 10px;"><?php echo $this->Html->image('social_22.png',array('height'=>'40px','width'=>'40px')); ?><br></div><div style="text-align: center;margin-top: 14px;">Hotmail</div></a></div></li>
                        <li><div style="height: 75px;width:120px;float: left;margin-left: 7px;border: 1px solid #CCCCCC;" class="jai"><a href="#anymail" data-toggle="tab" style="text-decoration: none;"><div style="text-align: center;margin-top: 10px;"><?php echo $this->Html->image('social_07.png',array('height'=>'40px','width'=>'40px')); ?><br></div><div style="text-align: center;margin-top: 12px;">Any Mail</div></a></div></li>
                    </ul>
    
    <div class="tab-content" style="margin-bottom:50px;" >
                    <div class="tab-pane active" id="gmail" style="width: 80%;">
                  <div class="span" style="margin-left:25px;">
<legend><span style="font-size:20px;"><b>Get started by adding your email address.</b></span></legend>
</div>      
                        
     <div class="span" style="margin-left:25px;">
<legend><span style="font-size:20px;">Your email</span></legend>
</div>
   <div class="span12" style="margin-left:25px;margin-top: -15px;">
	        <?php echo $this->Form->create('User',array('type'=>'post', )); ?>
<input type="email" class="span" id="appendedDropdownButton" name="search" >
<div class="span" style="margin-left:25px;margin-top: -9px;">
 <div class="form-actions span2">
     <button type="submit" name="save" id="update" class="btn btn-primary save" style="margin-left:-45px;">Continue</button>
</div>
  <div class="span10" style="margin-top:35px;" >
     <?php echo $this->Html->image('loc.png',array('height'=>'20px','width'=>'20px')); ?><span style="font-size:17px;"> <b>Your contacts are safe with us!</b></span><br>
   We'll import your address book to suggest connections and help you manage your contacts. And we won't store your password or email anyone without your permission.<a href="#" > <span data-toggle="modal" data-target="#myModal1">Learn More</span></a> 
    
</div>  
</form>
  </div>
</div>
   </div>
                    <div class="tab-pane" id="outlook" style="width: 80%;">
                         <div class="span" style="margin-left:25px;">
<legend><span style="font-size:20px;"><b>Get started by adding your email address.</b></span></legend>
</div>
                        <div class="span12" style="margin-left:25px;">
	        <?php echo $this->Form->create('User',array('type'=>'post', )); ?>
                          
       <legend><span style="font-size:20px; ">Your work email </span></legend> 
       <div style="margin-top:-15px;">
<input type="email" class="span" id="appendedDropdownButton" name="search" >
</div>
                            
<legend><span style="font-size:20px;">Outlook email password  </span></legend>
  <div style="margin-top:-15px;">
<input type="password" class="span" id="appendedDropdownButton" name="search" >
</div>
<div class="span" style="margin-left:25px;margin-top: -9px;">
 <div class="form-actions span2">
     <button type="submit" name="save" id="update" class="btn btn-primary save" style="margin-left:-45px;">Continue</button>
</div>
  <div class="span10" style="margin-top:35px;" >
     <?php echo $this->Html->image('loc.png',array('height'=>'20px','width'=>'20px')); ?><span style="font-size:17px;"> <b>Your contacts are safe with us!</b></span><br>
   We'll import your address book to suggest connections and help you manage your contacts. And we won't store your password or email anyone without your permission.<a href="#" > <span data-toggle="modal" data-target="#myModal1">Learn More</span></a> 
    
</div>  
</form>
  </div>
</div> </div>
                
                     <div class="tab-pane" id="yahoo" style="width: 80%;">
                      <div class="span" style="margin-left:25px;">
<legend><span style="font-size:20px;"><b>Get started by adding your email address.</b></span></legend>
</div>
                        <div class="span12" style="margin-left:25px;">
                            
	        <?php echo $this->Form->create('User',array('type'=>'post', )); ?>
                          
       <legend><span style="font-size:20px;">Your email </span></legend>    
         <div style="margin-top:-15px;">
<input type="email" class="span" id="appendedDropdownButton" name="search" >
</div>
                            

<div class="span" style="margin-left:25px;margin-top: -9px;">
 <div class="form-actions span2">
     <button type="submit" name="save" id="update" class="btn btn-primary save" style="margin-left:-45px;">Continue</button>
</div>
  <div class="span10" style="margin-top:35px;" >
     <?php echo $this->Html->image('loc.png',array('height'=>'20px','width'=>'20px')); ?><span style="font-size:17px;"> <b>Your contacts are safe with us!</b></span><br>
   We'll import your address book to suggest connections and help you manage your contacts. And we won't store your password or email anyone without your permission.<a href="#" > <span data-toggle="modal" data-target="#myModal1">Learn More</span></a> 
    
</div>  
</form>
  </div>
</div> 
                    </div>
                     <div class="tab-pane" id="hotmail" style="width: 80%;">
                      <div class="span" style="margin-left:25px;">
<legend><span style="font-size:20px;"><b>Get started by adding your email address.</b></span></legend>
</div>
                        <div class="span12" style="margin-left:25px;">
	        <?php echo $this->Form->create('User',array('type'=>'post', )); ?>
                          
       <legend><span style="font-size:20px;">Your email </span></legend> 
         <div style="margin-top:-15px;">
<input type="email" class="span" id="appendedDropdownButton" name="search" >

              </div>              

<div class="span" style="margin-left:25px;margin-top: -9px;">
 <div class="form-actions span2">
     <button type="submit" name="save" id="update" class="btn btn-primary save" style="margin-left:-45px;">Continue</button>
</div>
  <div class="span10" style="margin-top:35px;" >
     <?php echo $this->Html->image('loc.png',array('height'=>'20px','width'=>'20px')); ?><span style="font-size:17px;"> <b>Your contacts are safe with us!</b></span><br>
   We'll import your address book to suggest connections and help you manage your contacts. And we won't store your password or email anyone without your permission.<a href="#" ><span data-toggle="modal" data-target="#myModal1">Learn More</span></a> 
    
</div>  
</form>
  </div>
</div> </div>
                   
                     <div class="tab-pane" id="anymail" style="width: 80%;">
                         <div class="span12" style="margin-left:25px;">
<legend><span style="font-size:20px;"><b>Have you found everyone you know on Academatch? Search your email contacts to see.</b></span></legend>
</div>
                      <div class="span12" style="margin-left:25px;">
	        <?php echo $this->Form->create('User',array('type'=>'post', )); ?>
                          
       <legend><span style="font-size:20px;">Your email </span></legend> 
         <div style="margin-top:-15px;">
<input type="email" class="span" id="appendedDropdownButton" name="search" >
</div>
                            
<legend><span style="font-size:20px;">Email password  </span></legend>
  <div style="margin-top:-15px;">
<input type="password" class="span" id="appendedDropdownButton" name="search" >
</div>
<div class="span" style="margin-left:25px;margin-top: -9px;">
 <div class="form-actions span2">
     <button type="submit" name="save" id="update" class="btn btn-primary save" style="margin-left:-45px;">Continue</button>
</div>
  <div class="span10" style="margin-top:35px;" >
     <?php echo $this->Html->image('loc.png',array('height'=>'20px','width'=>'20px')); ?><span style="font-size:17px;"> <b>Your contacts are safe with us!</b></span><br>
   We'll import your address book to suggest connections and help you manage your contacts. And we won't store your password or email anyone without your permission.<a href="#" > <span data-toggle="modal" data-target="#myModal1">Learn More</span></a> 
    
</div>  
</form>
  </div>

 
</div>
                         <div class="span12" style="margin-top:25px;">
    <div style="height: 150px;width: 150px;float: left;">
        <?php echo $this->Html->image('social_28.png',array('height'=>'90px','width'=>'90px')); ?>
    </div>
    <div style="height: 150px;width: 150px;float: left;">
        <?php echo $this->Html->image('social_31.png',array('height'=>'90px','width'=>'90px')); ?>
    </div>
    <div style="height: 150px;width: 150px;float: left;">
        <?php echo $this->Html->image('social_34.png',array('height'=>'90px','width'=>'90px')); ?>
    </div>
    <div style="height: 150px;width: 150px;float: left;">
        <?php echo $this->Html->image('social_45.png',array('height'=>'90px','width'=>'90px')); ?>
        
    </div>
    <div style="height: 150px;width: 150px;float: left;cursor: pointer;">
   <span data-toggle="modal" data-target="#myModal">See All<p>Options>></span>
    </div>
    
   </div>
                    </div>
    </div>
    </div>
    
 
<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">Ã—</button>
<h3 id="myModalLabel">Supported Web Email Addresses</h3>
</div>
<div class="modal-body">
<span style="font-size: 17px;"><p><b>We can import web email contacts from the following domains:</b></p></span>
</div>
<div style="margin-left:30px;margin-bottom: 20px;">
    <span style="font-size: 15px;">163.com</span><br>
     <span style="font-size: 15px;">aol.com</span><br>
     <span style="font-size: 15px;">att.net</span><br>
    <span style="font-size: 15px;"> bol.com.br</span><br>
     <span style="font-size: 15px;">comcast.net</span><br>
     <span style="font-size: 15px;">earthlink.net</span><br>
     <span style="font-size: 15px;">email.it</span><br>
     <span style="font-size: 15px;">gmail.com</span><br>
     <span style="font-size: 15px;">gmx.at</span><br>
     
    <span style="font-size: 15px;"> googlemail.com</span><br>
     <span style="font-size: 15px;">hotmail.com</span><br>
     <span style="font-size: 15px;">ig.com.br</span><br>
     <span style="font-size: 15px;">indiatimes.com</span><br>
     <span style="font-size: 15px;">interia.pl</span><br>
     <span style="font-size: 15px;">libero.it</span><br>
     <span style="font-size: 15px;">live.com</span>
</div>
</div>
<div id="myModal1" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">Ã—</button>
<h4 id="myModalLabel">How Academatch Use Your Data</h4>
</div>
<div class="modal-body">
<span style="font-size: 17px;"><p class="well" align="justify">This feature uploads your address book to Academatch's servers including detailed contact information for all your contacts. We'll use this information to suggest relevant connections for you and also to help you browse, search, and organize your contacts on Academatch. We will not invite or email any of your contacts without your permission.</p></span>
</div>

</div>
</div>
<script>
    $(function () {                        
         $('#myTab a').click(function (e) {
        e.preventDefault();
         $(this).tab('show');
          })
         $('#myTab a:first').tab('show');
         })
                    </script>
<?php  echo $this->element('footer');
 ?>
    