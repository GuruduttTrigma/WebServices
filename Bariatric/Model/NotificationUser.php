<?php
class NotificationUser extends AppModel	{
	
	public $actsAs = array('Containable');
	
	public $belongsTo = array(
		'Notification' => array(
			'className' => 'Notification',
			'foreignKey' => 'notification_id'
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id'
		),
	);
}
?>