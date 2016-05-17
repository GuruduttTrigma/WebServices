<?php

App::uses('AppHelper', 'View/Helper');
App::uses('CakeResponse', 'Network');
App::import("Model", "User");  

class MathHelper extends AppHelper {


	public function add () 
	{
		$model = new User();  
		$c = $model->find("all"); 
		return $c;
	}	
	



}
