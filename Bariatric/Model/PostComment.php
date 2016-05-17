<?php
App::uses('AppModel', 'Model');
class PostComment extends AppModel
{
	public $name 	= 'PostComment';
	public $actsAs = array('Containable');
	
	public $belongsTo = array (
		'User'	=> 	array  (
			'className'	=> 'User',
			'foreignKey' 	=> 'user_id',
		),
		'Post'	=> 	array  (
			'className'	=> 'Post',
			'foreignKey' 	=> 'post_id',
		)
	);
	
	
}
?>