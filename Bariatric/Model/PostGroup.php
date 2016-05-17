<?php
class PostGroup extends AppModel {
	public $actsAs = array('Containable');
	
	public $belongsTo = array (
		'Group' => array (
			'className' => 'Group',
			'foreignKey' => 'group_id',
		),
		'Post' => array (
			'className' => 'Post',
			'foreignKey' => 'post_id',
		)	
	);
}
?>