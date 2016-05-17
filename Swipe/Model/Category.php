<?php
class Category extends AppModel 
{
	public $actsAs = array('Containable');
	public $displayField = 'email';
	public $validate 		= array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Your custom message here',
				//'allowEmpty' => false,
				'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'alphaNumeric' => array(
                'rule' => 'alphaNumeric',
                'required' => true,
                'message' => 'Letters and numbers only'
            ),
		),
	);
	public function beforeSave($options = array())
	{
		if (isset($this->data[$this->alias]['password']))  {
			$this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
		}
		return true;
	}
	
}
?>