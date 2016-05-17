<?php echo $this->element('top-header'); ?>
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
                     <div class="alert alert-block" style="margin-left:10px; margin-top:5px; width:88%;background-color:#5DA150;color:white;">
<button type="button" class="close" data-dismiss="alert">&times;</button>                
                    <strong><?php echo $x; ?></strong>
                   </div>
                   <?php }?> 
                    </div>
                <div class="span12">
                    <div class="upr" style="color:green;text-align: center;"></div>
                    <div class="row" style="margin-left:10px; padding-top:10px;">
                          <div style="padding-top:10px;">
                              <h4><a href="#" class="atag" style="margin-left:20px;"><?php echo $group_detail['UserGroup']['group_name']; ?></a> </h4>
                              <?php if(@!$iscomment){ ?>
                                  <div style="float:right;margin-right: 75px;"> 
                                  <?php echo $this->Form->create('Groupjoin',array('controller'=>'Groupjoins','action'=>'add','class'=>'join'),$type = 'post'); ?> 
                                        <input type="hidden" name="data[Groupjoin][user_id]" value="<?php echo $user_id; ?>"/>
                                        <input type="hidden" name="data[Groupjoin][user_group_id]" value="<?php echo $group_detail['UserGroup']['id']; ?>"/>
                                        <input type="hidden" name="url" value="http://acadm.apnaphp.com<?php echo $_SERVER["REQUEST_URI"]; ?>"/>
                                        <button class="btn" type="submit">Join Group</button>
                                    </form>  
                                  </div>
                                  <?php }else{ ?>
                                <div style="float:right;margin-right: 75px;">
                                    <?php echo $this->Form->postLink('Unsubscribe',array('controller'=>'Groupjoins','action'=>'delete',$group_detail['UserGroup']['id'],$user_id),array('escape'=>false,'class'=>'tablectrl_small bDefault tipS tool-tip','title'=>'Delete'));?>     
                                </div>
                                  <?php }?>
                          </div> 
                          <div class="span11">
                              <?php echo $this->Html->image('../files/grouplogo/'.$group_detail['UserGroup']['logo'],array('style'=>'height:200px;width:60%;margin-left:20px;')); ?><br/>
                               <p class="well" align="justify"><?php echo $group_detail['UserGroup']['description']; ?> </p>
                          </div>
                    </div>
		</div>

    </div>
    <div class="span6" id="hide">
        <br/><br/>
            <?php if(@$iscomment){ ?>
               <a href="javascript:void(0)" style="margin-right:56%;"><b>Discussion</b></a><i class="icon icon-comment"></i><span> <?php echo count($countcomment); ?> Comments</span>                                                        
               <hr/>  
             <?php } ?>
               <div class="row-fluid">                                   
                    <div id="groupcomment" class="row-fluid" style="">

                    </div>
               </div>
        <div style="width:100%;"> 
            <div class="wait" align="center"></div> 
                <div class="well-small">
                      <?php if(@$iscomment){ ?>
                            <div class="span10" style="margin:8px;margin-left:100px;">
                             <div class="span2">
                                 <?php if($user_detail['User']['profile_image']){
                                     echo $this->Html->image('../files/profileimage/'.$user_detail['User']['profile_image'],array('style'=>'width:70px;border-radius:10px;'));
                                      }else{
                                          echo $this->Html->image('homme.gif',array('style'=>'width:70px;border-radius:10px;'));                 
                                      } ?><br/><a href="#" class="atag"><?php echo $first_name; ?></a>
                             </div>
                                <div class="span10">              
                          <?php echo $this->Form->create('Groupcomment',array('controller'=>'Groupcomments','action'=>'add','id'=>'comment'),$type = 'post'); ?>    
                             <input type="hidden" name="data[Groupcomment][user_id]" value="<?php echo $user_id ?>"/>
                             <input type="hidden" name="data[Groupcomment][user_group_id]" value="<?php echo $group_detail['UserGroup']['id']; ?>"/>
                             <input type="hidden" name="data[Groupcomment][date]" value="<?php echo date("l dd/mm/Y H:i:s"); ?>"/>
                             <textarea style="height:80px;width:80%;" name="data[Groupcomment][comment]"></textarea><br/><br/>
                             <button class="btn btn-mini btn-primary" type="submit" style="float:right;">Comment</button> 
                       </form>
                                </div> 
                            </div>  
                           <?php }else{ ?>
                             <div style="color:blue;text-align: center;"><b>Please Join Group to discuss with us.</b></div>
                           <?php } ?>
                </div> 
        </div>      

    </div>
	</div>
	<?php echo $this->element('footer'); ?>
<script type="text/javascript">

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
    
    $("#comment").ajaxForm({        
           beforeSend: function() {
                     $('.wait').html('<img src="/img/ajax-loader-1.gif"/>');
                  },             
        success: function(data){
             $('.wait').html('');
            d = JSON.parse(data);
            if(d.error == 1){
                //$('.upr').html(d.message).fadeOut(10000);
               // $('.upr').html(d.detection).fadeOut(10000);
            }else if(d.error == 0){
                //$('.upr').html(d.message).fadeOut(10000);                   
            }
        }
    });
 
  
function groupcomments(){
         var user_id = <?php echo $user_id; ?>;
         var group_owner_id = <?php echo $group_detail['User']['id']; ?>;
        $.get('/Groupcomments/groupcomment',{'id':<?php echo $group_detail['UserGroup']['id']; ?>},function(d){            
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
        
   $('.del').live("click",function(){
    var id = $(this).attr('rel');
   $.post('/Groupcomments/delete',{'id':id},function(d){                   
            obj= JSON.parse(d);
            if(obj.error == 1){
            }else if(obj.error == 0){
                $('.upr').html(obj.message).fadeOut(10000);                   
            }
        });
    });
    });
   
   
    </script>        