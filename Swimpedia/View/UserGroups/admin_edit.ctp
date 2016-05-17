<div class="userGroups form">
<?php echo $this->Form->create('UserGroup'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit User Group'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('group_name');
		echo $this->Form->input('group_type');
		echo $this->Form->input('logo');
		echo $this->Form->input('summary');
		echo $this->Form->input('description');
		echo $this->Form->input('website');
		echo $this->Form->input('group_owner_email');
		echo $this->Form->input('auto_join');
		echo $this->Form->input('request_for_join');
		echo $this->Form->input('logo allow');
		echo $this->Form->input('invite_others');
		echo $this->Form->input('pre_approve');
		echo $this->Form->input('location');
		echo $this->Form->input('aggrement');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('UserGroup.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('UserGroup.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List User Groups'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
