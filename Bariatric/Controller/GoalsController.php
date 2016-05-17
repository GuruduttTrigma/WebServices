<?php
App::uses('AppController', 'Controller');
#project : Crowd Career
/**
 * Users Controller
 *
 *
 * @property User $User
 * @property SessionComponent $Session
 * @property AuthComponent $Auth
 */
class GoalsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	//public $components = array('Session', 'Auth');
	
	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow(array('admin_index'));
	}
	
	
	public function admin_index()
	{
		 $this->loadModel('GoalsWeight');
		$info = $this->GoalsWeight->find('all');
		$this->set('users', $this->paginate('GoalsWeight'));
	}
	
	public function admin_goal_activity($id =null)
	{
		 $this->loadModel('GoalActivityUser');
		 $this->loadModel('User');
		  $this->loadModel('GoalSleep');
		$this->User->id = $id;
        $user = $this->User->find('first',array('conditions' =>array('User.id' =>$id),'contain'=>array('GoalActivityUser'=>array('GoalActivity'),'GoalFoodUser' =>array('GoalFood'),'GoalSupplementUser'=>array('GoalSupplement'))));
	$info = $this->GoalSleep->find('first',array('conditions' =>array('GoalSleep.user_id' =>$id)));
	//echo "<pre>";print_r($user);exit;
		$this->set(compact('user','info'));		
	}
	
	
}

?>
