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
 * @package       Cake.View.Errors
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<?php //echo $this->element('top-header'); ?>
<br/><br/><br/><br/>
<div class="container-fluid">
<div class="row-fluid">
<div  class="span12">
<div style="background-color:black;width:40%;color:white;margin-left:30%;box-shadow:15px 15px 15px #58595B;border-radius:10px;">
<br/><br/><br/>
<?php echo $this->Html->image('error.png',array('style'=>'margin-left:30%')); ?>
<br/><br/><br/>
<h1 style="text-align:center;"><?php echo "404 Page Not Found";//$name; ?></h1>
<p class="error" align="center">
	<strong><?php echo __d('cake', 'Error'); ?>: </strong>
	<?php printf(
		__d('cake', 'The requested address %s was not found on this server.'),
		"<strong>'{$url}'</strong>"
	); ?>
</p>
<div align="center">
<?php
if (Configure::read('debug') > 0 ):
	echo $this->element('exception_stack_trace');
endif;
?>
</div>
</div>
</div>
</div>
</div>

<br/><br/><br/><br/>

<?php //echo $this->element('footer'); ?>
