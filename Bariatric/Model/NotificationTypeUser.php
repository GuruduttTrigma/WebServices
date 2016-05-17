<?php
class NotificationTypeUser extends AppModel  {
	public $actsAs = array('Containable');	
	public $belongsTo = array(
		'NotificationType' => array(
			'className' => 'NotificationType',
			'foreignKey' => 'notification_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),	
		'Sender' => array(
			'className' => 'User',
			'foreignKey' => 'sender_id',
			'conditions' => '',
			'fields' => array('id','name','profile_image','registertype'),
			'order' => ''
		),		
		'Receiver' => array(
			'className' => 'User',
			'foreignKey' => 'receiver_id',
			'conditions' => '',
			'fields' => array('id','name','profile_image','registertype'),
			'order' => ''
		),		
		'Post' => array(
			'className' => 'Post',
			'foreignKey' => 'post_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),		
		'UserChat' => array(
			'className' => 'UserChat',
			'foreignKey' => 'user_chat_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),				
	);
}
