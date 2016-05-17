<?php
App::uses('AppModel', 'Model');
class User extends AppModel 
{
	public $name 	= 'User';
	public $actsAs = 	array('Containable');
	public $displayField = 'email';
	
	public $belongsTo = array (
		'UserType'	=> array (
			'className'	=> 'UserType',
			'foreignKey' 	=> 'usertype_id',
		)
	);
	
	public $hasMany = array (
		'AccessToken'	=> array(
			'className' 	=> 'AccessToken',
			'foreignKey' 	=> 'user_id',
			'dependent' 	=> false,
		),
		'AuthCode' => array(
			'className'	=> 'AuthCode',
			'foreignKey' 	=> 'user_id',
			'dependent' 	=> false,
		),
		'AllVideo' => array(
			'className'	=> 'AllVideo',
			'foreignKey' 	=> 'user_id',
			'dependent' 	=> false,
		),
		'Following'	=> array (
			'className' 	=> 'UserFollower',
			'foreignKey' 	=> 'follower_id',
		),
		'Follower'	=> array (
			'className' 	=> 'UserFollower',
			'foreignKey' 	=> 'user_id',
		),
			'VideoView'	=> array (
			'className' 	=> 'VideoView',
			'foreignKey' 	=> 'user_id',
		)
	);
}