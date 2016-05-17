<?php
class GoalFood extends AppModel {

	public $actsAs = array('Containable');

	public $hasMany = array(
		'FoodBreakfast' => array(
			'className' => 'FoodBreakfast',
			'foreignKey' => 'goal_food_id',
		),
		'FoodLunch' => array(
			'className' => 'FoodLunch',
			'foreignKey' => 'goal_food_id',
		),
		'FoodDinner' => array(
			'className' => 'FoodDinner',
			'foreignKey' => 'goal_food_id',
		),
		'FoodSnack' => array(
			'className' => 'FoodSnack',
			'foreignKey' => 'goal_food_id',
		),
		'FoodWater' => array(
			'className' => 'FoodWater',
			'foreignKey' => 'goal_food_id',
		),
		'FoodMyRecipe' => array(
			'className' => 'FoodMyRecipe',
			'foreignKey' => 'goal_food_id',
		)
	);
}
?>