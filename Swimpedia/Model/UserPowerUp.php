<?php
class UserPowerUp extends AppModel 
{
	public $displayField = 'email';
	public $actsAs = array('Containable');

	public function beforeSave($options = array())
	{
		if (isset($this->data[$this->alias]['password'])){
			$this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
		}
		return true;
	}
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'PowerUp' => array (
			'className' => 'PowerUp',
			'foreignKey' => 'power_up_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)		
	);
}
