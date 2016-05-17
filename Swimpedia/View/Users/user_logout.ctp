<?php echo $this->element('top-header'); ?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span8" style="background-color:white;">
            <div class="span12">
                    <?php $x=$this->Session->flash(); ?>
                    <?php if($x){ ?>
                     <div class="alert alert-block" style="margin-left:10px; margin-top:5px; width:88%;">                
                       <strong><?php echo $x; ?></strong>
                   </div>
                   <?php }?>

        </div>
        
        <div class="span4">
<!--            <div id="academatch_add"></div>-->
<?php  foreach($ads as $ad){ ?>
<div><?php echo $this->Html->image('../files/addimage/'.$ad['AdVariant']['id'].$ad['AdVariant']['image'],array('align'=>'left','hspace'=>'5','style'=>'height:50px;width:50px;')); ?><p><?php echo $ad['Ad']['title']; ?><?php echo substr($ad['Ad']['description'],0,50); ?></p></div>
<?php } ?>
        </div>
    </div>
</div>
</div>    
<?php echo $this->element('footer'); ?>
<!--<script type="text/javascript">
   
    function pplumk(){
        $.get('<?php echo $this->webroot; ?>/Users/user_logout',function(d){
            $('#academatch_add').children('div').slideUp();
            $('#academatch_add').html('');
            d = JSON.parse(d);
            var x = '';
            for(i = 0; i<d.length;i++){
                x += '<div style="min-height:65px;" class="well well-small">';
                x += '<img style="height:60px; width:60px" src="/files/profileimage/'+d[i].AdVariant.image+'" align="left" hspace="5" />'
                x += '<a href="'+d[i].AdVariant.web_url+'">'+d[i].Ad.title + ' '+d[i].Ad.description+'</a><br />' ;                
                x += '</div>';
            }
            $('#academatch_add').html(x);
        });
        
    }
    </script>-->