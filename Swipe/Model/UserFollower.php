<?php
class UserFollower extends AppModel 
{
	public $name 	= 'UserFollower';
	public $actsAs = array('Containable');
	public $displayField = 'email';
	
	public $belongsTo = array (
		'User'	=> array (
			'className'	=> 'User',
			'foreignKey' 	=> 'user_id',
		),
		'Follower1'	=> array (
			'className'	=> 'User',
			'foreignKey' 	=> 'follower_id',
		)
	);
	
	
}