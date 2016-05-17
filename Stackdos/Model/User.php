<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 * @property AccessToken $AccessToken
 * @property AuthCode $AuthCode
 * @property Client $Client
 * @property RefreshToken $RefreshToken
 */
class User extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'email';
	public $actsAs = array('Containable');
/**
 * method called beforeSave
 */	
	public function beforeSave($options = array()){
		if(isset($this->data[$this->alias]['password'])){
			$this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
		}
		return true;
	}

/**
 * Validation rules
 *
 * @var array
 */
 
	public $validate = array(
		/*'username' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'password' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'token' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),*/
		/*'profile_image' => array(
			'rule'    => array(
			    'extension',
			    array('gif', 'jpeg', 'png', 'jpg')
			),
			'message' => 'Only jpeg,jpg,png,gif formats are allowed.'
		    ),*/
	);



	public $belongsTo = array(
		'UserType' => array(
			'className' => 'UserType',
			'foreignKey' => 'usertype_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
             'dependent'=>true
		)
	);

    public $hasMany = array(
		'Advertisement' => array(
			'className' => 'Advertisement',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => ''
		),
		'Share' => array(
			'className' => 'Share',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => ''
		),
		'Affiliateearn' => array(
			'className' => 'Affiliateearn',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => ''
		),
	);	
	

}
