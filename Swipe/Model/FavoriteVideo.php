<?php
App::uses('AppModel', 'Model');
class FavoriteVideo extends AppModel
{
	public $name = 'FavoriteVideo';
	public $actsAs = array('Containable');
	public $displayField = 'email';
	
	public $belongsTo = array (
		'User'	=> 	array  (
			'className'	=> 'User',
			'foreignKey' 	=> 'user_id',
		),
		'AllVideo'	=> 	array  (
			'className'	=> 'AllVideo',
			'foreignKey' 	=> 'all_video_id ',
		)
	);
	
	
}
?>