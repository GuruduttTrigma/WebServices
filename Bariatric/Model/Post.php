<?php
class Post extends AppModel {
	public $actsAs = array('Containable');
	
	public $belongsTo = array (
		'PostType' => array (
			'className' => 'PostType',
			'foreignKey' => 'post_type_id',
		)		
	);
	
	public $hasOne = array (
		'PostPhoto' => array (
			'className' => 'PostPhoto',
			'foreignKey' => 'post_id',
		),	
		'PostBeforeAfter' => array (
			'className' => 'PostBeforeAfter',
			'foreignKey' => 'post_id',
			'dependent' => false,
		),
		'PostText' => array(
			'className' => 'PostText',
			'foreignKey' => 'post_id',
			'dependent' => false,
		),
		'PostQuote' => array(
			'className' => 'PostQuote',
			'foreignKey' => 'post_id',
			'dependent' => false,
		),
		'PostGroup' => array(
			'className' => 'PostGroup',
			'foreignKey' => 'post_id',
			'dependent' => false,
		),
	);
}
?>