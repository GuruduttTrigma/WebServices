<?php echo $this->element('top-header'); ?>
<style>
 .may:hover { box-shadow:2px 2px 2px;margin-bottom:5px;}
</style>
<div class="container-fluid"> 
<div class="row-fluid">       
	  <div class="span12" style="background-color:white;">
      <!--------msg----------->
               <div class="span12">
                    <?php $x=$this->Session->flash(); ?>
                    <?php if($x){ ?>
                     <div class="alert alert-block" style="margin-left:150px;width:50%;text-align:center;margin-top:5px;background-color:#E6F8DD;">
                           <button type="button" class="close" data-dismiss="alert" style="cursor:pointer;" align="right">&times;</button>               
                           <strong>  <?php echo $x; ?></strong> 
                     </div>
                   <?php } ?>
                </div>
      <!-------------------->
      <p style="margin-left:50px;"><h4>People You May Know</h4></p><hr/>
      <?php foreach($people as $peo): if($peo['User']['id'] != $user_id){ if($peo['User']['first_name'] != NULL){ ?>
         <div class="may" style="float:left;border:1px solid #D1D1D1;height:170px;width:25%;margin-left:50px;margin-top:25px;margin-bottom:25px;">
            <div>
			<?php echo $this->Html->image('../files/profileimage/'.$peo['User']['profile_image'],array('style'=>'height:100px;width:100px;margin:30px 10px 5px 10px;','hspace'=>'10','align'=>'left'));  ?><br/>
            <p><h5><?php echo $peo['User']['first_name']."&nbsp;&nbsp;".$peo['User']['last_name']; ?></h5></p>
            <p><?php foreach($experiance as $exp):
  if($exp['UserWorkSince']['user_id'] == $peo['User']['id']){
	  echo ucwords($exp['UserWorkSince']['exp_title'])."<br/>".ucwords($exp['UserWorkSince']['exp_company_name']);
	   } break; endforeach; ?></p>
        <p><?php echo $peo['User']['home_town']; ?></p> 
      </div>   <br/> <br/>
        <hr/>
         <a href="#connect_<?php echo $peo['User']['id'] ?>" data-toggle="modal" role="button"><i class="icon-plus"></i>Connect</a>     
        </div> 
        <!---------model------------>
    <div id="connect_<?php echo $peo['User']['id'] ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     <?php echo $this->Form->create('Connection',array('controller'=>'connections','action'=>'add')); ?>
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel">&nbsp;&nbsp;<?php echo $this->Html->image("msg.png"); ?>Invite to connect on Academatch</h3>
</div>
<div class="modal-body">
<input type="hidden" name="data[Connection][user_id]" value="<?php echo $user_id ?>" />
<input type="hidden" name="data[Connection][connectedwith]" value="<?php echo $peo['User']['id']; ?>" />
<input type="hidden" name="data[Connection][status]" value="1" />
        <div class="row-fluid">
            <div class="span4">How do you know him?</div>
            <div class="span4">
            <table>
            <tr><td><input type="radio" name="data[Connection][relation]" value="Colleague"/></td><td width="200">Colleague</td></tr>
             <tr><td><input type="radio" name="data[Connection][relation]" value="Classmate" /></td><td width="200">Classmate</td></tr>
              <tr><td><input type="radio" name="data[Connection][relation]" value="We've done business together"/></td><td width="200">We've done business together</td></tr>
               <tr><td><input type="radio" name="data[Connection][relation]"  value="Friend"/></td><td width="200">Friend</td></tr>
                <tr><td><input type="radio" name="data[Connection][relation]" value="Other"/></td><td width="200"> Other</td></tr>
                 <tr><td><input type="radio" name="data[Connection][relation]" value=" I don't know ashish"/></td><td width="200"> I don't know him</td></tr>
            </table></div>
        </div>
        <div class="row-fluid">
        <div class="span4">Include a personal note: (optional)</div>
           <div class="span4">           
             <textarea  name="data[Connection][notes]" rows="5" cols="10"></textarea>
           </div>
        </div>
       <span style="color:maroon;margin-left:75px;">Important:</span> Only invite people you know well and who know you. 
        
</div>
<div class="modal-footer">
<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
<button class="btn btn-primary" type="submit">Save changes</button>
</div>
</form>
</div>
    <!--------------------------->
        <?php } } endforeach; ?>        
      </div>
     <!-- <div class="span4">
      </div>-->
</div>  
<br/><br/><br/><br/><br/>   
</div> 
<?php echo $this->element('footer'); ?>