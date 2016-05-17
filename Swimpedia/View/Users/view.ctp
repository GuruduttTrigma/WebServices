<div class="users view">
<h2><?php  echo __('User'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($user['User']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Username'); ?></dt>
		<dd>
			<?php echo h($user['User']['username']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Password'); ?></dt>
		<dd>
			<?php echo h($user['User']['password']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Email'); ?></dt>
		<dd>
			<?php echo h($user['User']['email']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Token'); ?></dt>
		<dd>
			<?php echo h($user['User']['token']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit User'), array('action' => 'edit', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete User'), array('action' => 'delete', $user['User']['id']), null, __('Are you sure you want to delete # %s?', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('action' => 'add')); ?> </li>
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
<div class="related">
	<h3><?php echo __('Related Access Tokens'); ?></h3>
	<?php if (!empty($user['AccessToken'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Oauth Token'); ?></th>
		<th><?php echo __('Client Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Expires'); ?></th>
		<th><?php echo __('Scope'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['AccessToken'] as $accessToken): ?>
		<tr>
			<td><?php echo $accessToken['oauth_token']; ?></td>
			<td><?php echo $accessToken['client_id']; ?></td>
			<td><?php echo $accessToken['user_id']; ?></td>
			<td><?php echo $accessToken['expires']; ?></td>
			<td><?php echo $accessToken['scope']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'access_tokens', 'action' => 'view', $accessToken['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'access_tokens', 'action' => 'edit', $accessToken['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'access_tokens', 'action' => 'delete', $accessToken['id']), null, __('Are you sure you want to delete # %s?', $accessToken['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Access Token'), array('controller' => 'access_tokens', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Auth Codes'); ?></h3>
	<?php if (!empty($user['AuthCode'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Code'); ?></th>
		<th><?php echo __('Client Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Redirect Uri'); ?></th>
		<th><?php echo __('Expires'); ?></th>
		<th><?php echo __('Scope'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['AuthCode'] as $authCode): ?>
		<tr>
			<td><?php echo $authCode['code']; ?></td>
			<td><?php echo $authCode['client_id']; ?></td>
			<td><?php echo $authCode['user_id']; ?></td>
			<td><?php echo $authCode['redirect_uri']; ?></td>
			<td><?php echo $authCode['expires']; ?></td>
			<td><?php echo $authCode['scope']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'auth_codes', 'action' => 'view', $authCode['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'auth_codes', 'action' => 'edit', $authCode['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'auth_codes', 'action' => 'delete', $authCode['id']), null, __('Are you sure you want to delete # %s?', $authCode['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Auth Code'), array('controller' => 'auth_codes', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Clients'); ?></h3>
	<?php if (!empty($user['Client'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Client Id'); ?></th>
		<th><?php echo __('Client Secret'); ?></th>
		<th><?php echo __('Redirect Uri'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['Client'] as $client): ?>
		<tr>
			<td><?php echo $client['client_id']; ?></td>
			<td><?php echo $client['client_secret']; ?></td>
			<td><?php echo $client['redirect_uri']; ?></td>
			<td><?php echo $client['user_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'clients', 'action' => 'view', $client['client_id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'clients', 'action' => 'edit', $client['client_id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'clients', 'action' => 'delete', $client['client_id']), null, __('Are you sure you want to delete # %s?', $client['client_id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Client'), array('controller' => 'clients', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Refresh Tokens'); ?></h3>
	<?php if (!empty($user['RefreshToken'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Refresh Token'); ?></th>
		<th><?php echo __('Client Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Expires'); ?></th>
		<th><?php echo __('Scope'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['RefreshToken'] as $refreshToken): ?>
		<tr>
			<td><?php echo $refreshToken['refresh_token']; ?></td>
			<td><?php echo $refreshToken['client_id']; ?></td>
			<td><?php echo $refreshToken['user_id']; ?></td>
			<td><?php echo $refreshToken['expires']; ?></td>
			<td><?php echo $refreshToken['scope']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'refresh_tokens', 'action' => 'view', $refreshToken['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'refresh_tokens', 'action' => 'edit', $refreshToken['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'refresh_tokens', 'action' => 'delete', $refreshToken['id']), null, __('Are you sure you want to delete # %s?', $refreshToken['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Refresh Token'), array('controller' => 'refresh_tokens', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
