<div class="userGroups view">
<h2><?php  echo __('User Group'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($userGroup['UserGroup']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($userGroup['User']['email'], array('controller' => 'users', 'action' => 'view', $userGroup['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Group Name'); ?></dt>
		<dd>
			<?php echo h($userGroup['UserGroup']['group_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Group Type'); ?></dt>
		<dd>
			<?php echo h($userGroup['UserGroup']['group_type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Logo'); ?></dt>
		<dd>
			<?php echo h($userGroup['UserGroup']['logo']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Summary'); ?></dt>
		<dd>
			<?php echo h($userGroup['UserGroup']['summary']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($userGroup['UserGroup']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Website'); ?></dt>
		<dd>
			<?php echo h($userGroup['UserGroup']['website']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Group Owner Email'); ?></dt>
		<dd>
			<?php echo h($userGroup['UserGroup']['group_owner_email']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Auto Join'); ?></dt>
		<dd>
			<?php echo h($userGroup['UserGroup']['auto_join']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Request For Join'); ?></dt>
		<dd>
			<?php echo h($userGroup['UserGroup']['request_for_join']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Logo Allow'); ?></dt>
		<dd>
			<?php echo h($userGroup['UserGroup']['logo allow']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Invite Others'); ?></dt>
		<dd>
			<?php echo h($userGroup['UserGroup']['invite_others']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Pre Approve'); ?></dt>
		<dd>
			<?php echo h($userGroup['UserGroup']['pre_approve']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Location'); ?></dt>
		<dd>
			<?php echo h($userGroup['UserGroup']['location']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Aggrement'); ?></dt>
		<dd>
			<?php echo h($userGroup['UserGroup']['aggrement']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($userGroup['UserGroup']['status']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit User Group'), array('action' => 'edit', $userGroup['UserGroup']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete User Group'), array('action' => 'delete', $userGroup['UserGroup']['id']), null, __('Are you sure you want to delete # %s?', $userGroup['UserGroup']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List User Groups'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User Group'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
