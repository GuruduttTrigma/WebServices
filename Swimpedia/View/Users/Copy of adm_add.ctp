<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Admin Add User'); ?></legend>
	<?php
		echo $this->Form->input('username');
		echo $this->Form->input('password');
		echo $this->Form->input('email');
		echo $this->Form->input('token');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Access Tokens'), array('controller' => 'access_tokens', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Access Token'), array('controller' => 'access_tokens', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Auth Codes'), array('controller' => 'auth_codes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Auth Code'), array('controller' => 'auth_codes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Clients'), array('controller' => 'clients', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Client'), array('controller' => 'clients', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Refresh Tokens'), array('controller' => 'refresh_tokens', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Refresh Token'), array('controller' => 'refresh_tokens', 'action' => 'add')); ?> </li>
	</ul>
</div>
