<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
$cakeAdmin= __d('linkedap', 'linkedap');
?>  
<!DOCTYPE html>
<html lang="en">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>Music App</title>
	<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>-->
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css(array('jqueryui/ui-lightness/jquery-ui-1.10.4.custom.min','bootstrap/css/bootstrap.min','font-awesome/css/font-awesome.min','fontello/css/fontello','animate-css/animate.min','nifty-modal/css/component','magnific-popup/magnific-popup','ios7-switch/ios7-switch','pace/pace','sortable/sortable-theme-bootstrap','bootstrap-datepicker/css/datepicker','jquery-icheck/skins/all','prettify/github','rickshaw/rickshaw.min','morrischart/morris','jquery-jvectormap/css/jquery-jvectormap-1.2.2','jquery-clock/clock','bootstrap-calendar/css/bic_calendar','sortable/sortable-theme-bootstrap','jquery-weather/simpleweather','bootstrap-xeditable/css/bootstrap-editable','style.css','style-responsive'));
		echo $this->Html->script(array('jquery/jquery-1.11.1.min','bootstrap/js/bootstrap.min','jqueryui/jquery-ui-1.10.4.custom.min','jquery-ui-touch/jquery.ui.touch-punch.min','jquery-detectmobile/detect','jquery-animate-numbers/jquery.animateNumbers','ios7-switch/ios7.switch','fastclick/fastclick','jquery-blockui/jquery.blockUI','bootstrap-bootbox/bootbox.min','jquery-slimscroll/jquery.slimscroll','jquery-sparkline/jquery-sparkline','nifty-modal/js/classie','nifty-modal/js/modalEffects','sortable/sortable.min','bootstrap-fileinput/bootstrap.file-input','bootstrap-select/bootstrap-select.min','bootstrap-select2/select2.min','magnific-popup/jquery.magnific-popup.min','pace/pace.min','bootstrap-datepicker/js/bootstrap-datepicker','jquery-icheck/icheck.min','prettify/prettify','init','d3/d3.v3','rickshaw/rickshaw.min','raphael/raphael-min','morrischart/morris.min','jquery-knob/jquery.knob','jquery-jvectormap/js/jquery-jvectormap-1.2.2.min','jquery-jvectormap/js/jquery-jvectormap-us-aea-en','jquery-clock/clock','jquery-easypiechart/jquery.easypiechart.min','jquery-weather/jquery.simpleWeather-2.6.min','bootstrap-xeditable/js/bootstrap-editable.min','bootstrap-calendar/js/bic_calendar.min','apps/calculator','apps/todo','apps/notes','pages/index'));

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
	    <link rel="shortcut icon" href="<?php echo $this->webroot; ?>assets/img/favicon.ico">
        <link rel="apple-touch-icon" href="<?php echo $this->webroot; ?>assets/img/apple-touch-icon.png" />
        <link rel="apple-touch-icon" sizes="57x57" href="<?php echo $this->webroot; ?>assets/img/apple-touch-icon-57x57.png" />
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo $this->webroot; ?>assets/img/apple-touch-icon-72x72.png" />
        <link rel="apple-touch-icon" sizes="76x76" href="<?php echo $this->webroot; ?>assets/img/apple-touch-icon-76x76.png" />
        <link rel="apple-touch-icon" sizes="114x114" href="<?php echo $this->webroot; ?>assets/img/apple-touch-icon-114x114.png" />
        <link rel="apple-touch-icon" sizes="120x120" href="<?php echo $this->webroot; ?>assets/img/apple-touch-icon-120x120.png" />
        <link rel="apple-touch-icon" sizes="144x144" href="<?php echo $this->webroot; ?>assets/img/apple-touch-icon-144x144.png" />
        <link rel="apple-touch-icon" sizes="152x152" href="<?php echo $this->webroot; ?>assets/img/apple-touch-icon-152x152.png" />
</head>
<body class="fixed-left login-page">
<!----Session Flash Pop Up---------->
<?php //echo $this->Session->flash(); ?>

<!----Session Flash Pop Up Over---->
<?php //if(($authority ==NULL)||($authority == "3")){ ?>
<?php echo $this->fetch('content');  ?>
</body>
<!--<script type="text/javascript">
$(document).ready(function(){ 
$('#pgLoader').hide(1000,function(){$('body').fadeIn(1000);});
});
</script>-->
</html>
