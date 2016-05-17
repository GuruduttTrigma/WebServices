<?php
	echo $this->Html->css(array('bootstrap','elfinder','fancybox','font','fullcalendar','ie','plugins','reset','styles','ui_custom','jquery.jqChart','toltip'));
		echo $this->Html->script(array('jquery.form.wizard','jquery.validate','jquery.form','jquery-1.7.1.min','jquery.jqChart.min','jquery.ui.core','jquery.ui.widget','jquery.ui.datepicker','jquery.ui.tooltip','jquery.tipTip','customcheckall','jquery.cycle.all','jcarousellite_1.0.1c4'));
?>
<div id="top" style='background:#000 url("<?php echo $this->webroot; ?>img/backgrounds/top.jpg") repeat fixed !important;'>
<div class="wrapper">
    	<?php echo $this->Html->image('http://au3.engine.flamingtext.com/netfu/tmp28025/coollogo_com-261971621.png',array('style'=>'height:50px;width:200px;margin-left:-20px;')); ?>
   
</div>
</div>


<script type="text/javascript">
    $(document).ready(function() {
        $('#flash').live('click', function() {
            $('#flash').fadeOut(3000);
        });
    });
</script>

<div class="loginWrapper" style='margin-top: -100px;'>

    <?php echo $this->Form->create('User',array('method'=>'post')); ?>
    <div class="loginPic">
        <a href="#" title=""><img src="/img/logo.png" alt="" /></a> 
    </div> 
    <h3>Reset Password</h3>
    <?php $x=$this->Session->flash(); ?>
    <?php if($x){ ?>
    <div class="nNote nSuccess" id="flash">
        <div class="" style="text-align:center" > <?php echo $x; ?></div>
    </div>
    <?php } ?>

<?php echo $this->Form->input('password',array("type"=>"password",'label' => false,'div'=>'false',"name"=>"data[User][password]",'placeholder'=>"Password..." ,'id'=>'pass','class'=>'loginPassword')); ?>

<?php echo $this->Form->input('password_confirm',array("type"=>"password",'label' => false,'div'=>'false',"name"=>"data[User][password_confirm]" , 'placeholder'=>'Confirm Password...','class'=>'loginPassword')); ?>


    <div class="logControl">
        <div style="float:left;margin-left:80px;">
            <input type="submit" name="submit" value="Save" class="buttonM bBlue" />
        </div>

    </div>
</form>
</div>
