<?php
App::uses('AppModel', 'Model');
/**
 * Question Model
 *
 */
class Question extends AppModel {

	public $actsAs = array('Containable');
	public $displayField = 'email';
/**
 * method called beforeSave
 */	
	public function beforeSave($options = array()){
		if(isset($this->data[$this->alias]['password'])){
			$this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
		}
		return true;
	}

	public $hasMany = array(
		'Answer' => array(
			'className' => 'Answer',
			'foreignKey' => 'question_id',
		)
	);

	public $belongsTo = array(
		'Topic' => array(
			'className' => 'Topic',
			'foreignKey' => 'topic_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		
	);
}
?>