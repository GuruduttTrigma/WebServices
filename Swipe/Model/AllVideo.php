<?php
	App::uses('AppModel', 'Model');
	class AllVideo extends AppModel 
	{
		public $name 			= 'AllVideo';
		public $actsAs 			=	array('Containable');
		public $displayField	= 'email';
		
		public $belongsTo 	= array(
			'User' => array(
				'className' => 'User',
				'foreignKey' => 'user_id',
				'conditions' => '',
				'fields' => '',
				'order' => ''
			),
			'Category' => array(
				'className' => 'Category',
				'foreignKey' => 'category_id',
				'conditions' => '',
				'fields' => '',
				'order' => ''
			)
		);
		
		public $hasMany 	= array(
			'VideoComment' => array(
				'className' => 'VideoComment',
				'foreignKey' => 'all_video_id',
				'conditions' => '',
				'fields' => '',
				'order' => ''
			),
		'VideoLike' => array(
				'className' => 'VideoLike',
				'foreignKey' => 'all_video_id',
				'conditions' => '',
				'fields' => '',
				'order' => ''
			),
		'VideoView' => array(
				'className' => 'VideoView',
				'foreignKey' => 'all_video_id',
				'conditions' => '',
				'fields' => '',
				'order' => ''
			),
		);
}

