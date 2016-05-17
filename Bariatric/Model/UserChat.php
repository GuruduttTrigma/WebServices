<?php
class UserChat extends AppModel {
	public $actsAs = array('Containable');	
	public $belongsTo = array (
		'Sender' => array (
			'className' => 'User',
			'foreignKey' => 'sender_id',
		),
		'Receiver' => array (
			'className' => 'User',
			'foreignKey' => 'receiver_id',
		)	
	);
}
?>