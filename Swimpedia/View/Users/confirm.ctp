<?php echo $this->element('top-header'); ?>
 <div class="content-2" style="margin:100px 400px;height:250px;">
 <legend style="margin:25px;">Account Confirmation</legend>
<div style="float:left;margin:5px;"><?php echo $this->Html->image('green.png'); ?></div>        
<div  style="float:left;margin-left:10px;"><?php 
    if($x = $this->Session->flash()){
     echo $x;
     } ?>
</div><br/><br/><br/><br/>
 <div align="center">
      <a class="btn btn-primary" align="center" href="<?php echo $this->Html->url(array('controller'=>'users','action'=>'loggedin')); ?>">Login</a>
 </div>
 </div>
 </div> </div>
<?php echo $this->element('footer');   ?> 