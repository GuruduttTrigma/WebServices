<?php
class Like extends AppModel
{
	public $actsAs = array('Containable');
	public $displayField = 'email';
	
	public function beforeSave ($options = array())
	{
		if (isset($this->data[$this->alias]['password']))  {
			$this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
		}
		return true;
	}
	
	public $belongsTo = array(
		'User'	=> 	array  (
			'className'	=> 'User',
			'foreignKey' 	=> 'user_id',
			'conditions' 	=> '',
			'fields' 			=> array('id','username','email','status','register_date','profile_image','contact'),
			'order' 			=> ''
		),
		'AllVideo'	=> 	array  (
			'className'	=> 'AllVideo',
			'foreignKey' 	=> 'all_video_id',
			'conditions' 	=> '',
			'fields' 			=> '',
			'order' 			=> ''
		)
	);
}
?>