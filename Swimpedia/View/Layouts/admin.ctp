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

$cakeDescription = __d('Academatch', 'Academatch');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>SwimPedia</title>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css(array('jqueryui/ui-lightness/jquery-ui-1.10.4.custom.min','bootstrap/css/bootstrap.min','font-awesome/css/font-awesome.min','fontello/css/fontello','animate-css/animate.min','nifty-modal/css/component','magnific-popup/magnific-popup','ios7-switch/ios7-switch','pace/pace','sortable/sortable-theme-bootstrap','bootstrap-datepicker/css/datepicker','jquery-icheck/skins/all','prettify/github','rickshaw/rickshaw.min','morrischart/morris','jquery-jvectormap/css/jquery-jvectormap-1.2.2','jquery-clock/clock','bootstrap-calendar/css/bic_calendar','sortable/sortable-theme-bootstrap','jquery-weather/simpleweather','bootstrap-xeditable/css/bootstrap-editable','style.css','style-responsive'));
		echo $this->Html->script(array('jquery/jquery-1.11.1.min','bootstrap/js/bootstrap.min','jqueryui/jquery-ui-1.10.4.custom.min','jquery-ui-touch/jquery.ui.touch-punch.min','jquery-detectmobile/detect','jquery-animate-numbers/jquery.animateNumbers','ios7-switch/ios7.switch','fastclick/fastclick','jquery-blockui/jquery.blockUI','bootstrap-bootbox/bootbox.min','jquery-slimscroll/jquery.slimscroll','jquery-sparkline/jquery-sparkline','nifty-modal/js/classie','nifty-modal/js/modalEffects','sortable/sortable.min','bootstrap-fileinput/bootstrap.file-input','bootstrap-select/bootstrap-select.min','bootstrap-select2/select2.min','magnific-popup/jquery.magnific-popup.min','pace/pace.min','bootstrap-datepicker/js/bootstrap-datepicker','jquery-icheck/icheck.min','prettify/prettify','init','d3/d3.v3','rickshaw/rickshaw.min','raphael/raphael-min','jquery-knob/jquery.knob','jquery-jvectormap/js/jquery-jvectormap-1.2.2.min','jquery-jvectormap/js/jquery-jvectormap-us-aea-en','jquery-clock/clock','jquery-easypiechart/jquery.easypiechart.min','jquery-weather/jquery.simpleWeather-2.6.min','bootstrap-xeditable/js/bootstrap-editable.min','bootstrap-calendar/js/bic_calendar.min','apps/calculator','apps/todo','apps/notes'));
		// echo $this->Html->script(array('jquery-1.7.1.min','jquery.validate','jquery.form','jquery.tipTip','customcheckall'));

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
	
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
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
<body class="fixed-left">	
<?php echo $this->Session->flash(); ?>
<?php if((@$authority ==NULL)||(@$authority == 5)){  
 echo $this->fetch('content');
}else{
  ?>
<div align="center" style="margin:100px;">
<img src="/img/permission.jpeg"/>
<h2>Sorry !!!! Permissions denied because you are not using the authority that is assigned to you.</h2>
</div>
  <?php //echo $this->element('foot'); 
 } ?> 
</body>
</html> 
