<?php
class GroupUser extends AppModel {

	public $displayField = 'email';
	public $actsAs = array('Containable');

	public function beforeSave ($options = array())  {
		if(isset($this->data[$this->alias]['password'])){
			$this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
		}
		return true;
	}
	
	public $belongsTo = array (
		'Group' => array (
			'className' => 'Group',
			'foreignKey' => 'group_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
	);
}