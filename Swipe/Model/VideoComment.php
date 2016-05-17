<?php
App::uses('AppModel', 'Model');
class VideoComment extends AppModel
{
	public $name 	= 'VideoComment';
	public $actsAs = array('Containable');
	
	public $belongsTo = array (
		'User'	=> 	array  (
			'className'	=> 'User',
			'foreignKey' 	=> 'user_id',
		),
		'AllVideo'	=> 	array  (
			'className'	=> 'AllVideo',
			'foreignKey' 	=> 'all_video_id',
		)
	);
	
	
}
?>