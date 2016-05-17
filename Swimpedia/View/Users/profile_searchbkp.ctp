<?php echo $this->element('top-header'); ?>
<style>
.img:hover{box-shadow:2px 2px 2px;}
</style>
<div class="row-fluid">
			   <div class="span8" id="top">
			     <div class="top">
				 <strong>"<?php echo count($search); ?>" Results Found.<?php if(count($search) == '0'){echo "Please Search another people.";} ?></strong>
				 <hr />
                 <?php foreach($search as $sea): ?>
				     <div class="row" style="margin-top:20px;">
					 <div id="top2"><a href="<?php echo $this->Html->url(array('controller'=>'users','action'=>'profile_view',$sea['User']['id'])); ?>">
<?php if($sea['User']['profile_image']==NULL){
echo $this->Html->image('admin.png',array('height'=>'100px','width'=>'100px'));
}else{ ?>
<?php echo $this->Html->image('../files/profileimage/'.$sea['User']['profile_image'],array('height'=>'100px','width'=>'100px','class'=>'img')); } ?></a></div>
    <div class="span1" id="top2"><a href="<?php echo $this->Html->url(array('controller'=>'users','action'=>'profile_view',$sea['User']['id'])); ?>" style="text-decoration:none;">
		<?php if($sea['User']['first_name']==NULL){}else{
  echo $sea['User']['first_name']."&nbsp;&nbsp;".$sea['User']['last_name']; }?></a></div><br/>
    <div class="span5" id="top2"><p><?php foreach($work as $wk): if($wk['UserWorkSince']['user_id'] ==$sea['User']['id']){echo $wk['UserWorkSince']['exp_title']."-".$wk['UserWorkSince']['exp_company_name'];}?><br/><?php  endforeach;?></p></div>
	<div class="span3"></div>
	<div class="span2" style="float:right;">
		 <a href="#sea_<?php echo $sea['User']['id']; ?>" data-toggle="modal" role="button"><button class="btn btn-mini btn-primary">Join</button></a>
		<!--<button class="btn btn-mini" type="button">Share</button>--></div>
    </div>
    <hr />
    <!---------model------------>
    <div id="sea_<?php echo $sea['User']['id'] ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     <?php echo $this->Form->create('Connection',array('controller'=>'connections','action'=>'add')); ?>
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel">&nbsp;&nbsp;<?php echo $this->Html->image("msg.png"); ?>Invite to connect on Academatch</h3>
</div>
<div class="modal-body">
<input type="hidden" name="data[Connection][user_id]" value="<?php echo $user_id ?>" />
<input type="hidden" name="data[Connection][connectedwith]" value="<?php echo $sea['User']['id']; ?>" />
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
     <?php endforeach; ?>
    				</div>
				
	
	
	    <div class="btn-toolbar">
    <div class="btn-group">
    <button class="btn">&laquo;</button>
	<button class="btn">1</button>
	<button class="btn">&raquo;</button>
    </div>
    </div>
     </div>
     <!------------------left-------------->
<div class="span4" id="top">
 <p><h5>People You May Know</h5></p><hr/>
			<?php foreach($srch as $all): if($all['User']['id'] != $user_id){ ?>
    <div style="width:100%;">
       <a href="<?php echo $this->Html->url(array('controller'=>'users','action'=>'profile_view',$all['User']['id'])); ?>" class="callback_<?php echo $all['User']['id']; ?>">
        <?php echo $this->Html->image('/files/profileimage/'.$all['User']['profile_image'],array('style'=>'height:50px;width:50px','align'=>'left','hspace'=>'10','class'=>'img')); ?>
        </a>
        <p><b><?php echo $all['User']['first_name']; ?>&nbsp;&nbsp;<?php echo $all['User']['last_name']; ?></b></p>
        <p><?php foreach($work as $wk): if($wk['UserWorkSince']['user_id'] == $all['User']['id']){echo $wk['UserWorkSince']['exp_title']."-".$wk['UserWorkSince']['exp_company_name'];} endforeach;?></p>
    </div><hr/>
  <script type="text/javascript">
$(document).ready(function () {
    
    var hoverHTMLDemoCallback = '<p><b>';
    hoverHTMLDemoCallback +=  '<?php echo $all['User']['first_name']; ?>&nbsp;&nbsp;<?php echo $all['User']['last_name']; ?>';
    hoverHTMLDemoCallback +=  '</b><br/> <?php echo $this->Html->image('/files/profileimage/'.$all['User']['profile_image'],array('height'=>'75px','width'=>'75px','align'=>'left','hspace'=>'5')); ?>';
    hoverHTMLDemoCallback +=  '<?php echo substr($all['User']['summary'],0,150)."....."; ?>';
	hoverHTMLDemoCallback +=  '<br/><a href="<?php echo $this->Html->url(array('controller'=>'users','action'=>'profile_view',$all['User']['id'])); ?>">View Profile</a>&nbsp;|&nbsp; <a href="#connect_<?php echo $all['User']['id']; ?>" data-toggle="modal" role="button">Invite to connect</a><p>';

    $(".callback_<?php echo $all['User']['id']; ?>").hovercard({
        detailsHTML: hoverHTMLDemoCallback,
        width: 350,
        cardImgSrc: '',
        onHoverIn: function () {
        	 $.notify('We see you just hovered over the label! <br/>Callback function <strong>"onHoverIn"</strong>. ', {
                     background: '#ffffbb',
                     autoHide: true,
                     autoHideDelay: 1000,
                     clickAnywhereToClose: true,
                     position: "bottom-right",
                     width: 100
                 });

        }
    });
});
</script>
 <!---------model------------>
    <div id="connect_<?php echo $all['User']['id'] ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     <?php echo $this->Form->create('Connection',array('controller'=>'connections','action'=>'add')); ?>
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel">&nbsp;&nbsp;<?php echo $this->Html->image("msg.png"); ?>Invite to connect on Academatch</h3>
</div>
<div class="modal-body">
<input type="hidden" name="data[Connection][user_id]" value="<?php echo $user_id ?>" />
<input type="hidden" name="data[Connection][connectedwith]" value="<?php echo $all['User']['id']; ?>" />
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
       <?php } endforeach; ?>
        <i class="icon-hand-right"></i>&nbsp;&nbsp;<a href="<?php echo $this->Html->url(array('controller'=>'users','action'=>'other_people')); ?>">See More</a>
       
<?php echo $this->Html->script(array('jquery.hovercard')); ?>
   <!--------------banner---------------->
<br/><br/><br/>
			<p><h5>ADS BY ACADEMATCH MEMBERS</h5></p><hr/>
<div style="width:100%;">
       <a href="<?php echo $banner['Banner']['link']; ?>">
        <?php echo $this->Html->image('/files/bannerimage/'.$banner['Banner']['id'].$banner['Banner']['image'],array('height'=>'100px','width'=>'100px','align'=>'left','hspace'=>'5')); ?>
        </a>
        <p><?php echo $banner['Banner']['title']; ?></p>
    </div>
			  <br/><br/>
       <!-----------------------------------> 
			   </div>
     <!------------------end-------->          
				 
			   </div>
			  
				 </div>
	<?php  echo $this->element('footer');
 ?>
  