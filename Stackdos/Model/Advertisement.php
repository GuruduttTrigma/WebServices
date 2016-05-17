<?php
App::uses('AppModel', 'Model');
/**
 * Category Model
 *
 * @property Category $ParentCategory
 * @property Category $ChildCategory
 */
class Advertisement extends AppModel {
	var $actsAs=array('Containable');
/**
 * Display field
 *
 * @var string
 */
//	public $displayField = 'name';

/**
 * Validation rules
 *
 * @var array
 */
/*	public $validate = array(
		'id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'status' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	); */

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

    public $hasMany = array(
		'Share' => array(
			'className' => 'Share',
			'foreignKey' => 'post_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => ''
		),	
		'PostShow' => array(
			'className' => 'PostShow',
			'foreignKey' => 'post_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => ''
		)
	);	
	
        
 /*       public $hasMany = array(
		'Image' => array(
			'className' => 'Image',
			'foreignKey' => 'category_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	); */

 

}
