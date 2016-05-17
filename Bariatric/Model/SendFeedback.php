<?php
class SendFeedback extends AppModel {
	public $actsAs = array('Containable');	
	public $belongsTo = array (
		'User' => array (
			'className' => 'User',
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
	);
}