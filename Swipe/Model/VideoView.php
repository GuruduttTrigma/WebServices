<?php
class VideoView extends AppModel
{
	public $name = 'VideoView';
	public $actAs = array('Containable');
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