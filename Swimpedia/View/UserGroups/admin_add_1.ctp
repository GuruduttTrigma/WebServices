<?php echo $this->element("admin_header"); ?>
<?php echo $this->element("admin_topright"); ?>
<?php echo $this->element("admin_nav"); ?>
<?php echo $this->element("admin_sidebar"); ?> 
<?php echo $this->Html->script(array('tiny_mce/tiny_mce'))?>
<script type="text/javascript">
jQuery(document).ready(function(){
tinyMCE.init({
theme: "advanced",
plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
// Theme options
theme_advanced_buttons1 : ",justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
theme_advanced_buttons2 : "cut,copy,paste|,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,image,cleanup,code,|,forecolor,backcolor",
theme_advanced_buttons3 : "tablecontrols,|sub,sup,|,charmap,emotions,iespell,media,advhr,|,fullscreen",
theme_advanced_buttons4 : "bold,italic,underline,strikethrough,|styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,|,insertimage",
theme_advanced_toolbar_location : "top",
theme_advanced_toolbar_align : "left",
theme_advanced_statusbar_location : "bottom",
theme_advanced_resizing : true,
mode: "exact",
elements: "message",
body_id: "message"
});
});
</script>
<!--------------------------->
<div id="content">
    <div class="contentTop">
        <span class="pageTitle"><span class="icon-screen"></span>Group Management</span>
        <ul class="quickStats">
            <li>
                <a href="" class="blueImg"><img src="../../images/icons/quickstats/plus.png" alt="" /></a>
                <div class="floatR"><strong class="blue"></strong><span>Groups</span></div>
            </li>
        </ul>
    </div>
     <!-- Breadcrumbs line -->
    <div class="breadLine">
        <div class="bc">
            <ul id="breadcrumbs" class="breadcrumbs">
                <li><a href="<?php  echo $this->Html->url(array('controller'=>'Users','action'=>'admin_dashboard')); ?>">Dashboard</a></li>
                <li><a href="<?php echo $this->Html->url(array('controller'=>'NewsArticles','action'=>'admin_groups')); ?>">Group Management</a></li>
                 <li class="current"><a href="javascript:void:(0)">Add News Group</a></li>
            </ul>
        </div>
    </div>
    <script>
	$(function() {
		$( "#datepicker" ).datepicker();
	});
	</script>

    <div class="wrapper">
         <div class="widget fluid">
        <div class="whead"><h6>Add Group</h6></div>
        <div id="dyn" class="hiddenpars">
             <?php echo $this->Form->create('UserGroup',array('method'=>'Post','type'=>'file')); ?>
                
                <div class="formRow">
                    <div class="grid3"><label>Title:</label></div>
                    <div class="grid9">
                    <?php echo $this->Form->input('title', array('label'=>"",'type'=>'text'));?>
                    </div>
                </div> 
                </div>
              <div class="formRow">
                    <div class="grid3"><label></label></div>
                    <div class="grid9">
                    <button type="submit" name="Save" id="update" class="buttonS bLightBlue" >Save</button>
                    </div>
                </div>
           </form>
     
        </div>  
          
        </div>        
    </div>
