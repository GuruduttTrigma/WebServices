<div class="userGroups index">
	<h2><?php echo __('User Groups'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('group_name'); ?></th>
			<th><?php echo $this->Paginator->sort('group_type'); ?></th>
			<th><?php echo $this->Paginator->sort('logo'); ?></th>
			<th><?php echo $this->Paginator->sort('summary'); ?></th>
			<th><?php echo $this->Paginator->sort('description'); ?></th>
			<th><?php echo $this->Paginator->sort('website'); ?></th>
			<th><?php echo $this->Paginator->sort('group_owner_email'); ?></th>
			<th><?php echo $this->Paginator->sort('auto_join'); ?></th>
			<th><?php echo $this->Paginator->sort('request_for_join'); ?></th>
			<th><?php echo $this->Paginator->sort('logo allow'); ?></th>
			<th><?php echo $this->Paginator->sort('invite_others'); ?></th>
			<th><?php echo $this->Paginator->sort('pre_approve'); ?></th>
			<th><?php echo $this->Paginator->sort('location'); ?></th>
			<th><?php echo $this->Paginator->sort('aggrement'); ?></th>
			<th><?php echo $this->Paginator->sort('status'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($userGroups as $userGroup): ?>
	<tr>
		<td><?php echo h($userGroup['UserGroup']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($userGroup['User']['email'], array('controller' => 'users', 'action' => 'view', $userGroup['User']['id'])); ?>
		</td>
		<td><?php echo h($userGroup['UserGroup']['group_name']); ?>&nbsp;</td>
		<td><?php echo h($userGroup['UserGroup']['group_type']); ?>&nbsp;</td>
		<td><?php echo h($userGroup['UserGroup']['logo']); ?>&nbsp;</td>
		<td><?php echo h($userGroup['UserGroup']['summary']); ?>&nbsp;</td>
		<td><?php echo h($userGroup['UserGroup']['description']); ?>&nbsp;</td>
		<td><?php echo h($userGroup['UserGroup']['website']); ?>&nbsp;</td>
		<td><?php echo h($userGroup['UserGroup']['group_owner_email']); ?>&nbsp;</td>
		<td><?php echo h($userGroup['UserGroup']['auto_join']); ?>&nbsp;</td>
		<td><?php echo h($userGroup['UserGroup']['request_for_join']); ?>&nbsp;</td>
		<td><?php echo h($userGroup['UserGroup']['logo allow']); ?>&nbsp;</td>
		<td><?php echo h($userGroup['UserGroup']['invite_others']); ?>&nbsp;</td>
		<td><?php echo h($userGroup['UserGroup']['pre_approve']); ?>&nbsp;</td>
		<td><?php echo h($userGroup['UserGroup']['location']); ?>&nbsp;</td>
		<td><?php echo h($userGroup['UserGroup']['aggrement']); ?>&nbsp;</td>
		<td><?php echo h($userGroup['UserGroup']['status']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $userGroup['UserGroup']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $userGroup['UserGroup']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $userGroup['UserGroup']['id']), null, __('Are you sure you want to delete # %s?', $userGroup['UserGroup']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New User Group'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
