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
class FaqsController extends AppController {

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
		 $this->loadModel('Faq');
		$info = $this->Faq->find('all');
		$this->set('users', $this->paginate('Faq'));
	}
	
	public function admin_add_faq()
	{
		 $this->loadModel('Faq');
		if(!empty($this->data))
		{
			$this->Faq->create();
			if ($this->Faq->save($this->data)) {
			
				$this->Session->setFlash(__('The Faq has been saved'));
				$this->redirect(array('action' => 'admin_index'));
			}
		}
	}
	
	public function admin_faq_edit($id =null)
	{
		$this->loadModel('Faq');
		$this->Faq->id = $id;
        $use = $this->Faq->find('first',array('conditions' =>array('Faq.id' =>$id)));
		$this->set('use',$use);
		if(!empty($this->request->data))
		{
			if ($this->Faq->save($this->data)) {
			
				$this->Session->setFlash(__('The Faq has been saved'));
				$this->redirect(array('action' => 'admin_index'));
			}
		}
	}
	
	public function admin_delete($id = null)
	{
		$this->loadModel('Faq');
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
				$this->Faq->id = $id;
		if (!$this->Faq->exists()) {
			throw new NotFoundException(__('Invalid Faq'));
		}
		if ($this->Faq->delete($id,true)) {
			$this->Session->setFlash(__('Faq deleted'));
			$this->redirect(array('action' => 'admin_index'));
		}
		$this->Session->setFlash(__('Faq was not deleted'));
		$this->redirect(array('action' => 'admin_index'));
	}
	
	public function admin_add_term_services()
	{
		$this->loadModel('TermService');
		if(!empty($this->data))
		{ 
			$this->TermService->create();
			if ($this->TermService->save($this->data)) {		
				$this->Session->setFlash(__('The TermService has been saved'));
				$this->redirect(array('action' => 'admin_term_services'));
			}
		}
	}
	
	public function admin_term_services()
	{
		$this->loadModel('TermService');
		$info = $this->TermService->find('all');
		$this->set('users', $this->paginate('TermService'));
	}
	
	public function admin_about_us()
	{
		$this->loadModel('About');
		$info = $this->About->find('all');
		$this->set('users', $this->paginate('About'));
	}
	
	public function admin_add_about_us()
	{
		$this->loadModel('About');
		if(!empty($this->data))
		{
			$this->About->create();
			if ($this->About->save($this->data)) {
			
				$this->Session->setFlash(__('The About has been saved'));
				$this->redirect(array('action' => 'admin_about_us'));
			}
		}
	}
	
	
	public function admin_edit_about_us($id = null)
	{
		$this->loadModel('About');
		$this->About->id = $id;
        $use = $this->About->find('first',array('conditions' =>array('About.id' =>$id)));
		$this->set('use',$use);
		if(!empty($this->data))
		{
			$this->About->create();
			if ($this->About->save($this->data)) {
			
				$this->Session->setFlash(__('The About has been saved'));
				$this->redirect(array('action' => 'admin_about_us'));
			}
		}
	}
	
	public function admin_send_feedback()
	{
		$this->loadModel('SendFeedback');
		$info = $this->SendFeedback->find('all');
		$this->set('info', $this->paginate('SendFeedback'));
	}
	
	public function admin_send_feedbackdelete($id = null)
	{
		$this->loadModel('SendFeedback');
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
				$this->SendFeedback->id = $id;
		if (!$this->SendFeedback->exists()) {
			throw new NotFoundException(__('Invalid SendFeedback'));
		}
		if ($this->SendFeedback->delete($id,true)) {
			$this->Session->setFlash(__('SendFeedback deleted'));
			$this->redirect(array('action' => 'admin_send_feedback'));
		}
		$this->Session->setFlash(__('SendFeedback was not deleted'));
		$this->redirect(array('action' => 'admin_send_feedback'));
	}

	
}

?>
