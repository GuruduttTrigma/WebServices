<?php echo $this->element('top-header');   ?>
<style>
atag
{
color:#d6de23;
list-style:none;
}

</style>
<div class="row-fluid" style=" border-bottom: 5px solid #FFFFFF;">
    <div class="span6">
        <div class="span12">
                    <?php $x=$this->Session->flash(); ?>
                    <?php if($x){ ?>
                     <div class="alert alert-block" style="margin-left:10px; margin-top:5px; width:88%;background-color:green;color:white;">
<button type="button" class="close" data-dismiss="alert">&times;</button>                
                    <strong><?php echo $x; ?></strong>
                   </div>
                   <?php }?> 
                    </div>
                <div class="span12">
                    <div class="upr" style="color:black;text-align: center;"></div>
                    <div class="row" style="margin-left:10px; padding-top:10px;" >
                          <div style="padding-top:10px;"  >
                              <h4><span style="margin-left:35px;"><?php echo $group_detail['UserGroup']['group_name']; ?></span> </h4>
                              <?php if(@!$iscomment){ ?>
                                  <div style="float:right;margin-right: 75px;margin-top:-30px;"> 
                                  <?php echo $this->Form->create('Groupjoin',array('controller'=>'Groupjoins','action'=>'add','class'=>'join'),$type = 'post'); ?> 
                                        <input type="hidden" name="data[Groupjoin][user_id]" value="<?php echo $user_id; ?>"/>
                                        <input type="hidden" name="data[Groupjoin][user_group_id]" value="<?php echo $group_detail['UserGroup']['id']; ?>"/>
                                        <input type="hidden" name="url" value="http://academatch.net<?php echo $_SERVER["REQUEST_URI"]; ?>"/>
                                        <button class="btn" type="submit">Join Group</button>
                                    </form>  
                                  </div>
                                  <?php }else{ ?>
                                <div style="float:right;margin-right: 75px;margin-top:-30px;color:black">
                                    <?php echo $this->Form->postLink('Unsubscribe from this group',array('controller'=>'Groupjoins','action'=>'delete',$group_detail['UserGroup']['id'],$user_id),array('escape'=>false,'class'=>'tablectrl_small bDefault tipS tool-tip','title'=>'Unsubscribe','style'=>'color:black;'));?>     
                                </div>
                                  <?php }?>
                          </div> 
                          <div class="span11">
                              <?php echo $this->Html->image('../files/grouplogo/'.$group_detail['UserGroup']['logo'],array('style'=>'height:100px;width:250px;margin-left:20px;')); ?><br/><br/>
                               <p align="justify" style="margin-left:20px;"><?php echo $group_detail['UserGroup']['description']; ?> </p>
                          </div>
                    </div>
		</div>

    </div>
    <div class="span6" id="hide" style="margin-top:-60px;">
        <br/><br/>
            <?php if(@$iscomment){ ?>
<!--               <a href="javascript:void(0)" style="margin-right:56%;"><b>Discussion</b></a>                                        -->
<!--               <hr/>  -->
             <?php } ?>
<!--               <div class="row-fluid">                                   
                    <div id="groupcomment" class="row-fluid" style="">

                    </div>
               </div>-->
        <div style="width:100%;"> 
            <div class="wait" align="center" style="color:green;"></div> 
                <div class="well-small">
                      <?php if(@$iscomment){ ?>
                            
                    <!--------------------------------------->
                            <div id="col-bottom">
            <div class="row-fluid" style="background:#FFF;">
                <table width="100%" align="center">
                    <tr>
                        <td>
<?php echo $this->Form->create('Comment', array('type' => 'post', 'action' => 'add', 'id' => 'com_post')); ?>
<?php echo $this->Form->hidden('user_group_id', array('value' => $group_detail['UserGroup']['id'])); ?>
<?php echo $this->Form->hidden('status', array('value' => 1)); ?>
                            <input type="hidden" id="p_id" name="data[Comment][parent_id]" value="" />
                            <div style="padding:4px;">
<?php
  $_SESSION['ui'] = $user_id;
   $_SESSION['gui']= $group_detail['UserGroup']['user_id'];
function renderCom($com) {
    @$a = $user_id;
    @$gid = $group_detail['UserGroup']['user_id'];
    echo '<div style=" font-size:13px;"><a href="/users/profile_view/'.$com['User']['id'].'">';
     if($com['User']['profile_image']){
         echo '<img style="height:70px;width:70px;border-radius:10px;margin-bottom:10px;" src="/files/profileimage/'.$com['User']['profile_image'].'" align="left" hspace="5"/>';
     }else{
          echo '<img style="width:70px;border-radius:10px;" src="/img/homme.gif" align="left" hspace="5"/>';
     }
        echo '<b>' . $com['User']['username'] . '</b></a></div>';
        echo '<span style="font-size:16px;">' . $com['Comment']['comment'] . '</span>';  
        //debug($com['Comment']['user_id']);
       // debug($_SESSION['ui']); exit;      
        if($_SESSION['gui']==$_SESSION['ui']){ 
             echo '<img src="/img/clear.png" alt="delete" rel="'.$com['Comment']['id'].'" class="del" style="cursor:pointer;"/>' ;     
           }
    foreach ($com['children'] as $cm) {
        echo '<table class="well well-small" width="100%"><tr>';
        echo '<td style="width:50px;"></td><td>';
        renderCom($cm);
        echo '</td></tr></table>';
    }
    echo '<div align="right"><button type="button" class="cmnt-bt btn btn-small" onclick="javascript: if($(this).html() == \'Post\'){$(\'#main_a_d\').attr({\'name\':\'xyz\'}); $(\'#com_post\').submit();}else{ $(\'.a_dvfx321\').remove(); $(\'.cmnt-bt\').html(\'Comment\'); $(this).before(\'<textarea name=data[Comment][comment] class=a_dvfx321 style=width:80% />\').before(\'<br class=a_dvfx321 />\'); $(this).parent().find(\'textarea\').focus(); $(\'#p_id\').val(' . $com['Comment']['id'] . '); $(this).html(\'Post\'); return false;} ">Comment</button><br/></div>';
}
?>
  <?php if(@$iscomment){ ?>
                                <h6>Post Discussion</h6> 
<!--                                <input type="hidden" name="data[groupname]" id="groupname" value="<?php //echo $group_detail['UserGroup']['group_name']; ?>"-->
                                <textarea name=data[Comment][comment] id="main_a_d" class=a_d style=width:99%></textarea>
                                <div align="right" style="padding-bottom:10px;"><button onclick="javascript: $('.a_dvfx321').remove(); $('#p_id').val(''); $('#main_a_d').attr({'name':'data[Comment][comment]'}); $('#com_post').submit();" type="button" class="btn btn-small">Post</button></div>    
  <?php } ?>
<?php foreach ($comments as $com) { ?>
                                    <div class="well well-small">
    <?php renderCom($com); ?>
                                    </div>
<?php } ?>

                            </div>
                            </form>
                        </td>
                    </tr>
                </table>
            </div>

            <div id="bottom-976"> &nbsp; </div>											
        </div>
                    <!------------------------------------------>
                           <?php }else{ ?>
<!--                             <div style="color:blue;text-align: center;"><b>Please Join Group to discuss with us.</b></div>-->
                           <?php } ?>
                </div> 
        </div>      

    </div>
	</div>
	<?php echo $this->element('footer'); ?>
<script type="text/javascript">
     $(document).ready(function(){
var grp = '<?php echo $group_detail['UserGroup']['group_name']; ?>';
    $(".join").ajaxForm({
        success: function(data){
            d = JSON.parse(data);
            if(d.error == 1){
                $('.upr').html(d.message).fadeOut(10000);
                $('.upr').html(d.detection).fadeOut(10000);
            }else if(d.error == 0){
                $('.upr').html(d.message).fadeOut(10000);
                    window.location = d.redirect;
            }
        }
    }); 
    
 $("#com_post").ajaxForm({        
           beforeSend: function() {
                     $('.wait').html('<img src="/img/ajax-loader-1.gif"/>');
                  },             
        success: function(data){
             $('.wait').html('');
            d = JSON.parse(data);
            if(d.error == 1){
                //$('.upr').html(d.message).fadeOut(10000);
               $('.wait').html(d.message).fadeOut(10000);
            }else if(d.error == 0){
                 $('.wait').html(d.message).fadeOut(10000);
                window.location ="/user_groups/home_group/"+grp;             
            }
        }
    });
    
 
 $('.del').live("click",function(){
    var id = $(this).attr('rel');
   $.post('/Comments/delete',{'id':id},function(d){                   
            obj= JSON.parse(d);
            if(obj.error == 1){
            }else if(obj.error == 0){
                $('.wait').html(obj.message).fadeOut(10000);     
                 window.location ="/user_groups/home_group/"+grp;   
            }
        });
    });
 });
  
/*function groupcomments(){
         var user_id = <?php //echo $user_id; ?>;
         var group_owner_id = <?php //echo $group_detail['User']['id']; ?>;
        $.get('/Groupcomments/groupcomment',{'id':<?php //echo $group_detail['UserGroup']['id']; ?>},function(d){            
            d = JSON.parse(d);  
            var x = '';
            for(var i = 0; i < d.length;i++){
                x += '<div class="span10" style="margin-left:100px;"><div class="span2">';
                if(d[i].User.profile_image){
                  x += '<img style="width:70px;border-radius:10px;" src="/files/profileimage/'+d[i].User.profile_image+'" align="left" />';
                }else{
                  x += '<img style="width:70px;border-radius:10px;" src="/img/homme.gif" align="left" />';
                }
                x +=  '<a href="/users/profile_view/'+d[i].User.id+'" class="atag">'+d[i].User.first_name +'</a></div>' ;
                x += '<div class="span9">'+d[i].Groupcomment.comment+'</div>';
                if((d[i].User.id == user_id)||(group_owner_id == user_id)){       
                x += '<img src="/img/clear.png" alt="delete" rel="'+d[i].Groupcomment.id+'" class="del" style="cursor:pointer;"/>' ;             
                }
                   x+='</div>';
            }
                $('#groupcomment').html(x); 
        });
          
    }    
        $(document).ready(function(){
        groupcomments();
        groupcomment = setInterval('groupcomments()',1000);
        
   
    });*/
   
   
    </script>        