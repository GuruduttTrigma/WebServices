<?php
	App::uses('AppController', 'Controller');
	class CategoriesController extends AppController 
	{
		public $a	=	'50';
		public $b	=	'40';
		public function beforeFilter() 
		{
			parent::beforeFilter();
			$this->Auth->allow(array('global_var','global_var1'));
		}
		
		public function global_var () 
		{
			$user = $this->a + $this->b;
			return $user;
		}
		
		public function global_var1 ()
		{
			echo $this->global_var();die;
		}
	}