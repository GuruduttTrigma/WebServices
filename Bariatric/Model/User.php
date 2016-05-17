<?php
class User extends AppModel  {
	public $displayField = 'email';
	public $actsAs = array('Containable');
	
	public $belongsTo = array(
		'UserType' => array(
			'className' => 'UserType',
			'foreignKey' => 'usertype_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		
		
	);
	
	public $hasMany = array(
		'AccessToken' => array(
			'className' => 'AccessToken',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'AuthCode' => array(
			'className' => 'AuthCode',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'GoalActivityUser' => array(
			'className' => 'GoalActivityUser',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'GoalFoodUser' => array(
			'className' => 'GoalFoodUser',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'GoalSupplementUser' => array(
			'className' => 'GoalSupplementUser',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Following'	=> array (
			'className' 	=> 'UserFollower',
			'foreignKey' 	=> 'follower_id',
		),
		'Follower'	=> array (
			'className' 	=> 'UserFollower',
			'foreignKey' 	=> 'user_id',
		),
		'NotificationUser'	=> array (
			'className' 	=> 'NotificationUser',
			'foreignKey' 	=> 'user_id',
		),
	);
}
