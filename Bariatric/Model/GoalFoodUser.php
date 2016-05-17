<?php
App::uses('AppModel', 'Model');
class GoalFoodUser extends AppModel 	{

	public $actsAs = array('Containable');

 	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'GoalFood' => array(
			'className' => 'GoalFood',
			'foreignKey' => 'goal_food_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Phase' => array(
			'className' => 'Phase',
			'foreignKey' => 'phase_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	); 
	/*public $hasOne = array(
		'GoalFoodBreakfast' => array(
			'className' => 'GoalFoodBreakfast',
			'foreignKey' => 'goal_food_user_id',
		),
		'GoalFoodLunch' => array(
			'className' => 'GoalFoodLunch',
			'foreignKey' => 'goal_food_user_id'
		),
		'GoalFoodDinner' => array(
			'className' => 'GoalFoodDinner',
			'foreignKey' => 'goal_food_user_id'
		),
		'GoalFoodSnack' => array(
			'className' => 'GoalFoodSnack',
			'foreignKey' => 'goal_food_user_id'
		),
		'GoalFoodWater' => array(
			'className' => 'GoalFoodWater',
			'foreignKey' => 'goal_food_user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'GoalFoodMyRecipes' => array(
			'className' => 'GoalFoodMyRecipes',
			'foreignKey' => 'goal_food_user_id'
		)
	); */
}
?>