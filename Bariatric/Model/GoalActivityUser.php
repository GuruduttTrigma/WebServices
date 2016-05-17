<?php
App::uses('AppModel', 'Model');
/**
 * Answer Model
 *
 */
class GoalActivityUser extends AppModel {

	public $actsAs = array('Containable');

 	 public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'GoalActivity' => array(
			'className' => 'GoalActivity',
			'foreignKey' => 'id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	); 
}
?>