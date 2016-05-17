<?php
class PostPhoto extends AppModel {
	public $actsAs = array('Containable');
	
	public $belongsTo = array (
		'User' => array (
			'className' => 'User',
			'foreignKey' => 'user_id',
		),
		'Post' => array (
			'className' => 'Post',
			'foreignKey' => 'post_id',
		)	
	);
}
?>