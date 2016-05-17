<script>
if (window.chrome)
    $("[type=video\\\/mp4]").each(function()
    {
        $(this).attr('src', $(this).attr('src').replace(".mp4", "_c.mp4"));
    });
</script>
<?php echo $this->element("admin_header"); ?>
<?php echo $this->element("admin_topright"); ?>
<?php echo $this->element("admin_nav"); ?>
<?php echo $this->element("admin_sidebar");
?> 
<script type="text/javascript">
$(document).ready(function(){
$(".fancybox").fancybox();
});
</script>
<style>
.modalPopLite-mask
{
  position:fixed;
  z-index:9994;
  background-color:#000;
  display:none;
  top:0px;
  left:0px;
  width:100%;
}
.modalPopLite-wrapper
{
    position:fixed;
    z-index:9995;
    /*display:none;*/
    /*left:-10000px;*/
    -webkit-border-radius: .5em; 
	-moz-border-radius: .5em;
	border-radius: .5em;
	-webkit-box-shadow: 0 0px 25px rgba(0,0,0,.9);
	-moz-box-shadow: 0 0px 25px rgba(0,0,0,.9);
	box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.4);    
    border: 5px solid #335805;
    
}

/* popup */
.popBox-holder 
{
     display:none;
     position: absolute;
     left: 0px;
     top: 0px;
     width:100%;
     height:100%;
     text-align:center;
     z-index: 999;
     background-color:#000;
     filter:alpha(opacity=40);
     opacity:0.5;
     
}

.popBox-container 
{
     display:none;
     background-color: #fff;
     border:4px solid #000;
     padding:10px;
     text-align:center;
     z-index: 1000;
     	-webkit-border-radius: .5em; 
	-moz-border-radius: .5em;
	border-radius: .5em;
	-webkit-box-shadow: 0 1px 2px rgba(0,0,0,.2);
	-moz-box-shadow: 0 1px 2px rgba(0,0,0,.2);
	box-shadow: 0 1px 2px rgba(0,0,0,.2);
}

.popBox-container .done-button
{
    margin-top:10px;
}

.popBox-container .button {
	display: inline-block;
	zoom: 1; /* zoom and *display = ie7 hack for display:inline-block */
	*display: inline;
	vertical-align: baseline;
	margin: 0 2px;
	outline: none;
	cursor: pointer;
	text-align: center;
	text-decoration: none;
	font: 14px/100% Arial, Helvetica, sans-serif;
	padding: .5em 2em .55em;
	text-shadow: 0 1px 1px rgba(0,0,0,.3);
	-webkit-border-radius: .5em; 
	-moz-border-radius: .5em;
	border-radius: .5em;
	-webkit-box-shadow: 0 1px 2px rgba(0,0,0,.2);
	-moz-box-shadow: 0 1px 2px rgba(0,0,0,.2);
	box-shadow: 0 1px 2px rgba(0,0,0,.2);
}
.popBox-container .button:hover {
	text-decoration: none;
}
.popBox-container .button:active {
	position: relative;
	top: 1px;
}

.popBox-container .small {
	font-size: 11px;
	padding: .2em 1em .275em;
}
.popBox-container .blue {
	color: #d9eef7;
	border: solid 1px #0076a3;
	background: #0095cd;
	background: -webkit-gradient(linear, left top, left bottom, from(#00adee), to(#0078a5));
	background: -moz-linear-gradient(top,  #00adee,  #0078a5);
	filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#00adee', endColorstr='#0078a5');
}
.popBox-container .blue:hover {
	background: #007ead;
	background: -webkit-gradient(linear, left top, left bottom, from(#0095cc), to(#00678e));
	background: -moz-linear-gradient(top,  #0095cc,  #00678e);
	filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#0095cc', endColorstr='#00678e');
}
.popBox-container .blue:active {
	color: #80bed6;
	background: -webkit-gradient(linear, left top, left bottom, from(#0078a5), to(#00adee));
	background: -moz-linear-gradient(top,  #0078a5,  #00adee);
	filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#0078a5', endColorstr='#00adee');
}

.popBox-ajax-progress
{
     position: fixed;
	 left: 0px;
	 top: 0px;
	 width:100%;
	 height:100%;
	 text-align:center;
	 z-index: 99999;
	 background-color:#000;
	 filter:alpha(opacity=40);
	 opacity:0.5;
	 background-image: url('ajax-loader.gif');
	 background-repeat:no-repeat;
	 background-position:center center;
}
/* end popup */


</style>
<script>
/*
* jQuery modalPopLite
* Copyright (c) 2012 Simon Hibbard
* 
* Permission is hereby granted, free of charge, to any person
* obtaining a copy of this software and associated documentation
* files (the "Software"), to deal in the Software without
* restriction, including without limitation the rights to use,
* copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the
* Software is furnished to do so, subject to the following
* conditions:

* The above copyright notice and this permission notice shall be
* included in all copies or substantial portions of the Software.
* 
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
* EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
* OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
* NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
* HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
* WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
* FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
* OTHER DEALINGS IN THE SOFTWARE. 
*/

/*
* Version: V1.3.1
* Release: 19-07-2012
* Based on jQuery 1.7.2
*/

(function ($) {
    var popID = 0;
    $.fn.modalPopLite = function (options) {
        var options = $.extend({}, { openButton: "modalPopLite-open-btn", closeButton: "modalPopLite-close-btn", isModal: false, callBack: null }, options);

        return this.each(function () {
            popID++;
            var thisPopID = popID;
            var isOpen = false;

            obj = $(this);
            triggerObj = options.openButton;
            closeObj = options.closeButton;
            isReallyModel = options.isModal;

            //alert("winH: " + winH + "top: " + top + "objH: " + objH);
            obj.before('<div id="modalPopLite-mask' + thisPopID + '" style="width:100%" class="modalPopLite-mask" />');
            obj.wrap('<div id="modalPopLite-wrapper' + thisPopID + '" style="left: -10000px;" class="modalPopLite-wrapper" />');
            obj.addClass('modalPopLite-child-' + thisPopID);

            $(triggerObj).live("click", function (e) {
                e.preventDefault();
                var winW = $(window).width();
                var winH = $(window).height();
                var objW = $('.modalPopLite-child-' + thisPopID).outerWidth();
                var objH = $('.modalPopLite-child-' + thisPopID).outerHeight();
                var left = (winW / 2) - (objW / 2);
                var top = (winH / 2) - (objH / 2);

                $('#modalPopLite-mask' + thisPopID).css('height', winH + "px");
                $('#modalPopLite-mask' + thisPopID).fadeTo('slow', 0.6);
                //$('#modalPopLite-wrapper' + thisPopID).hide();
                $('#modalPopLite-wrapper' + thisPopID).css({ 'left': left + "px", 'top': top });
                $('#modalPopLite-wrapper' + thisPopID).fadeIn('slow');
                isOpen = true;
            });

            $(closeObj).live("click", function (e) {
                e.preventDefault();
                $('#modalPopLite-mask' + thisPopID).hide();
                //$('#modalPopLite-wrapper' + thisPopID).hide();
                $('#modalPopLite-wrapper' + thisPopID).css('left', "-10000px");
                isOpen = false;
                if (options.callBack != null) {
                    options.callBack.call(this);
                }
            });

            //if mask is clicked
            if (!isReallyModel) {
                $('#modalPopLite-mask' + thisPopID).click(function (e) {
                    e.preventDefault();
                    $(this).hide();
                    //$('#modalPopLite-wrapper' + thisPopID).hide();
                    $('#modalPopLite-wrapper' + thisPopID).css('left', "-10000px");
                    isOpen = false;
                    if (options.callBack != null) {
                        options.callBack.call(this);
                    }
                });
            }
            $(window).resize(function () {
                if (isOpen) {
                    var winW = $(window).width();
                    var winH = $(window).height();
                    var objW = $('.modalPopLite-child-' + thisPopID).outerWidth();
                    var objH = $('.modalPopLite-child-' + thisPopID).outerHeight();
                    var left = (winW / 2) - (objW / 2);
                    var top = (winH / 2) - (objH / 2);
                    $('#modalPopLite-wrapper' + thisPopID).css({ 'left': left + "px", 'top': top });
                }
            });
        });

    };

    $.fn.modalPopLite.Close = function (id) {
        $('#modalPopLite-mask' + id).hide();
        //$('#modalPopLite-wrapper' + id).hide();
        $('#modalPopLite-wrapper' + thisPopID).css('left', "-10000px");
        if (options.callBack != null) {
            options.callBack.call(this);
        }
    };

    $.fn.modalPopLite.ShowProgress = function () {
        $('<div class="popBox-ajax-progress"></div>').appendTo("body")
    };

    $.fn.modalPopLite.HideProgress = function () {
        $('.popBox-ajax-progress').remove();
    };

})(jQuery);

</script>
<script>
$(document).ready (function(){
	$('.clicker').click(function (){
		var href = $(this).attr('href');
		$("#myVideoTag > source").attr("src", href)
	});
});
</script>
<script>
$(document).ready(function(){
			$('.clicker').click(function (){
				var video_id=$(this).attr('rel');
		     	$.ajax({
		      	type:'GET',		      	
		      	url:'http://admin.talentswipe.com/Webservices/getvideo/'+video_id,
		        success:function(resp) 
		        {
		         	if(resp)
		         	{
						//console.log ('guru');return false;
		         		$('.model_pop_up').html(resp);			         	
		         	}		         
		        }
	        });
        });
});
</script>
<script type="text/javascript">
$(function () {	
    $('#popup-wrapper').modalPopLite({ openButton: '.clicker', closeButton: '#close-btn' });
});
</script> 
<div id="content">
    <div class="contentTop">
        <span class="pageTitle"><span class="icon-screen"></span>Video Management</span>
		
        <ul class="quickStats">
            <li>
                <div class="floatR"><strong class="blue"><?php echo count($cates);?></strong><span>Videos</span></div>
            </li>
        </ul>
    </div>
	
     <!-- Breadcrumbs line -->
    <div class="breadLine">
        <div class="bc">
            <ul id="breadcrumbs" class="breadcrumbs">
                <li><a href="<?php echo $this->Html->url(array('controller'=>'Users','action'=>'admin_dashboard')); ?>">Dashboard</a></li>
                <li class="current"><a href="javascript:void:(0)">Video Management</a></li>
				<div id="popup-wrapper" class= "model_pop_up" style="background-color: black;width:400px;height:300px;" >					
						
				</div> 				
			</ul>
    </div>
       <!-- Main content -->
    <div class="wrapper">
     <?php $x=$this->Session->flash();if($x){ ?>
     <div class="nNote nSuccess" id="flash">
       <div class="" style="text-align:center" ><?php echo $x; ?></div>
     </div><?php } ?>
                   
     <ul class="middleNavA">
            <li><a href="<?php echo $this->Html->url(array('controller'=>'AllVideos','action'=>'admin_add_video')); ?>" title="Add Video"  class="tool-tip"><?php echo $this->Html->image('/images/icons/color/order-149.png'); ?><span>Add Video</span></a></li>
        </ul> 
    	<!-- Chart -->
      <div class="widget check grid6">
        <div class="whead">
			<span class="titleIcon">
				<input title="Select All" class="tool-tip" id="titleCheck" name="titleCheck" type="checkbox">
			</span>
			<h6>Video Management</h6>
			<div  style="float:right;">
			   <?php echo $this->Form->create('AllVideo', array('controller'=>'AllVideos','action'=>'index')); ?>
				<div style="margin-top:5px;">			
					<input  type="text" name="keyword" placeholder="Search keyword..." class="tipS tool-tip" title="Enter the keywords like description etc..." autocomplete="off">
					 <input value="" type="submit" name="search">
					 <input type="image" src="<?php echo $this->webroot;?>img/Search.png" alt="Submit"  class="search_img" />
				</div>
					<?php echo $this->Form->end();?>
			</div>
        </div>
        <div id="dyn" class="hiddenpars">
        
             <?php  echo $this->Form->create('AllVideo',array("action" => "deleteall",'id' => 'mbc')); ?>
             <table cellpadding="0" cellspacing="0" width="100%" class="tDefault checkAll tMedia" id="checkAll">
            <thead>
            <tr>
            <th></th>
			 
			 <th><?php echo('Thumbnail Image'); ?></th>
			<!-- <th><?php //echo('Video'); ?></th>
			 <th><?php //echo('Crop Video'); ?></th>-->
			 <th><?php echo('Description'); ?></th>
            <th><?php echo ('Category Name'); ?></th>	
            <th><?php echo ('Video By'); ?></th>	
            <th><?php echo ('Uploaded By'); ?></th>	
            <th><?php echo ('Status'); ?></th>
            <th style="width:10%">Action</th>
            </tr>
            </thead>
            <tbody id="itemContainer">
            <?php foreach (@$videos as $video):?>
            <tr class="gradeX">
            <td><?php echo $this->Form->checkbox("allvideo"+$video['AllVideo']['id'],array('value' => $video['AllVideo']['id'],'class'=>'checkAll')); ?></td>
			<td>
					<!--<img src ="<?php  echo FULL_BASE_URL.$this->webroot.'files'.DS.'thumbnail_images'.'/'. $video['AllVideo']['thumbnail_images']; ?>" height="200px" width="50px" alt="">	-->
					<a rel="<?php echo $video['AllVideo']['id'];   ?>" class="clicker" title="Basic dialog">
						<img src ="<?php  echo FULL_BASE_URL.$this->webroot.'files'.DS.'thumbnail_images'.'/'. $video['AllVideo']['thumbnail_images']; ?>" height="200px" width="100px" alt="">
					</a>
			</td>			
			<!--<td>
			<video controls style="width:150px;height:200px;">
						<source src="<?php  //echo FULL_BASE_URL.$this->webroot.'files'.DS.'full_videos'.'/'. $video['AllVideo']['full_video']; ?>" type="video/mp4">	
			</video>
			</td>
			<td>
			<video controls style="width:150px;height:200px;">
						<source src=" <?php  //echo FULL_BASE_URL.$this->webroot.'files'.DS.'small_videos'.'/'. $video['AllVideo']['small_video']; ?>" type="video/mp4">	
			</video>
			</td>-->
			<td><?php echo h($video['AllVideo']['description']); ?></td>		
            <td><?php echo h($video['Category']['name']); ?></td>		
            <td><?php echo h($video['AllVideo']['uploaded_by']); ?></td>		
            <td><a title="View User Profile" href="<?php echo FULL_BASE_URL.DS.'N-166/admin/users/view/'.$video['User']['id'];?>"><?php echo ucfirst(h($video['User']['username'])); ?></a></td>		
            <td><?php if($video['AllVideo']['status']=='Yes'){echo"Activate";}else{echo"Blocked";} ?></td>
            <td class="center">
             <form></form>
             <?php echo $this->Form->postLink(
				'<span class="iconb" data-icon="&#xe136;"></span>',
				array('controller'=>'AllVideos','action'=>'delete',$video['AllVideo']['id']),
				array('escape'=>false,'class'=>'tablectrl_small bDefault tipS tool-tip','title'=>'Delete'),
				__('Are you sure you want to delete this video?', $video['AllVideo']['title']));?>        
			<?php if ($video['AllVideo']['status']=='No')  {  ?>
				<?php echo $this->Form->postLink('<span class="iconb" data-icon="&#xe1bf;"></span>', array('action' => 'activate', $video['AllVideo']['id']),array('escape'=>false,'class'=>'tablectrl_small bDefault tipS tool-tip','title'=>'Active Now'));?><?php }else { ?>
				<?php echo $this->Form->postLink('<span class="iconb" data-icon="&#xe1c1;"></span>', array('action' => 'block', $video['AllVideo']['id']), array('escape'=>false,'class'=>'tablectrl_small bDefault tipS tool-tip','title'=>'Block Now')); ?><?php }?>
				<?php echo $this->Form->postLink('<span class="viewpdf-icn" data-icon="&#xe1c1;"></span>', 
				array('action' => 'crop_video', $video['AllVideo']['id']),
				array('escape'=>false,'class'=>'tablectrl_small bDefault tipS tool-tip','title'=>'Crop Video'));?>
            </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
            </table> 
            <br/><br/>
            <?php  $url = explode('/',$this->request->url);//print_r($url);?>
                <button onclick="$('#mbc').submit();" value="Delete" class="buttonS bRed" style="margin-left:20px"> Delete All</button>
                <button class="buttonS bGreen" style="margin-left:40px" name="delete" value="Activate" onclick=" <?php if(@$url[2]=='index'){?> $('#mbc').attr({'action':'../activateall'});<?php }else{ ?>$('#mbc').attr({'action':'AllVideos/activateall'});<?php }?> $('#mbc').submit();">Activate</button>
                <button class="buttonS bBlue" style="margin-left:40px" name="delete" value="Deactivate" onclick=" <?php if(@$url[2]=='index'){?> $('#mbc').attr({'action':'../deactivateall'});<?php }else{?>$('#mbc').attr({'action':'AllVideos/deactivateall'});<?php }?> $('#mbc').submit();">Deactive</button>
            <div class="tPages">
              <ul class="pages">
            <!--<li class="prev"><?php //echo $this->Paginator->prev('' ,null, null, array('class' => 'icon-arrow-14'));?></li>-->
                <li><?php echo @$this->Paginator->numbers(); ?></li>
                <!--<li class="next"><?php //echo $this->Paginator->next('', null, null, array('class' => 'icon-arrow-17'));?></li>-->
                <!-- prints X of Y, where X is current page and Y is number of pages -->
                <?php //echo $this->Paginator->counter(); ?>
              </ul>
            </div>
		      <?php //debug($this->request->url); ?>
              <div style="margin-top:10px;"></div>
              <input type="hidden" id="currentloc96" name="currentloc" value="" />
              <script type="text/javascript">
			  	$('#currentloc96').val(window.location);
			  </script>
                  <?php echo $this->Form->end(); ?>
               </div>  
         </div>        
    </div>
</div>

      
