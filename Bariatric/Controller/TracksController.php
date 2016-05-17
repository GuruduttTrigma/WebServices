<?php
App::uses('AppController', 'Controller');
class TracksController extends AppController 
{
	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow(array('admin_add_track_type'));
	}
		
	public function admin_add_track_type()
	{
		$this->loadModel('TrackType');
		if ($this->request->is('post'))  {             
			$this->request->data['TrackType']['date'] = date('y-m-d') ;
			$this->TrackType->create();
			if ($this->TrackType->save($this->request->data)) {
				$this->Session->setFlash(__('The TrackType has been saved'));
				$this->redirect(array('action' => 'admin_track_type'));
			}  else  {
				$this->Session->setFlash(__('The TrackType could not be saved. Please, try again.'));
			}
		}
	}
	
	public function admin_track_type()
	{
		$this->loadModel('TrackType');
		$info = $this->TrackType->find('all');
		$this->set('users', $this->paginate('TrackType'));
	}
	
	public function admin_track_type_edit($id =null)
	{
		$this->loadModel('TrackType');
		$this->TrackType->id = $id;
        $use = $this->TrackType->find('first',array('conditions' =>array('TrackType.id' =>$id)));
		$this->set('use',$use);	
		if (!empty($this->data))  {
			$this->TrackType->create();
			if ($this->TrackType->save($this->request->data)) {
				$this->Session->setFlash(__('The TrackType has been saved'));
				$this->redirect(array('action' => 'admin_track_type'));
			}
		}
	}
	
	public function admin_track_type_delete($id =null)
	{
		$this->loadModel('TrackType');
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
				$this->TrackType->id = $id;
		if (!$this->TrackType->exists()) {
			throw new NotFoundException(__('Invalid TrackType'));
		}
		if ($this->TrackType->delete($id,true)) {
			$this->Session->setFlash(__('TrackType deleted'));
			$this->redirect(array('action' => 'admin_track_type'));
		}
		$this->Session->setFlash(__('TrackType was not deleted'));
		$this->redirect(array('action' => 'admin_track_type'));
	}
		
	public function admin_add_track()
	{
		$this->loadModel('Track');
		$this->loadModel('TrackType');
		$info = $this->TrackType->find('all');
		$this->set('info',$info);
		if ($this->request->is('post')) {
			//echo "<pre>";print_r($this->request->data);exit;
			$one = $this->request->data['Track']['image'];
			if(!empty($one['name'])){
				$profileImage = str_replace(' ','_',$one['name']);
				$this->request->data['Track']['image'] = $profileImage;
			}	
			else{
				$this->request->data['Track']['image'] = "";
			}			
			$this->Track->create();
			if ($this->Track->save($this->request->data)) {
					if ($one['error'] == 0) {
						$pth = 'files' . DS . 'Track' . DS .$one['name'];
						move_uploaded_file($one['tmp_name'], $pth);                   
					}				
				$this->Session->setFlash(__('The Track has been saved'));
				$this->redirect(array('action' => 'admin_track'));
			} else {
				$this->Session->setFlash(__('The Track could not be saved. Please, try again.'));
			}
		}
	}
	
	public function admin_track() { 
		$this->loadModel('Track');
	$info = $this->Track->find('all',array('order'=>'Track.name DESC'));
	$this->paginate = array('order'=>'TrackType.name ASC');
	$this->set('users', $this->paginate('Track'));
	}
	
	public function admin_track_edit($id =null)
	{
		$this->loadModel('Track');
		$this->Track->id = $id;
        $use = $this->Track->find('first',array('conditions' =>array('Track.id' =>$id)));
		$this->set('use',$use);
		$this->loadModel('TrackType');
		$info = $this->TrackType->find('all');
		$this->set('info',$info);		
		if (!$this->Track->exists()) {
			throw new NotFoundException(__('Invalid Track'));
		}
		//$this->User->id = $id;
		$this->set('profile',$this->Track->find('first',array('conditions'=>array('Track.id'=>$id))));
        $x= $this->Track->find('first',array('conditions'=>array('Track.id'=>$id)));
		$this->Track->id = $id;
		if (!$this->Track->exists()) {
			throw new NotFoundException(__('Invalid Track'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if(!empty($this->request->data['Track']['image']['name'])){
				$im = $this->Track->find('first',array('conditions'=>array('Track.id'=>$id)));
					if(!empty($im['Track']['image'])){
					$old='files/Track/'.$im['Track']['image'];
					unlink($old);
					}
			}
			$one = $this->request->data['Track']['image'];
          if($this->request->data['Track']['image']['name']!=""){
              $this->request->data['Track']['image'] = $one['name'];  
              }else{
               $this->request->data['Track']['image'] = $x['Track']['image'];
              }
                        
			//$this->request->data['User']['profile_image']=$one['name'];
			if ($this->Track->save($this->request->data)) {
			if ($one['error'] == 0) {
                    $pth = 'files' . DS . 'Track' . DS .$one['name'];
                    move_uploaded_file($one['tmp_name'], $pth);                   
                }
				$this->Session->setFlash(__('The Track has been updated'));
				$this->redirect(array('action' => 'admin_track'));
			} else {
				$this->Session->setFlash(__('The Track could not be saved. Please, try again.'));
			}
		} 
		else {
			$this->request->data = $this->Track->read(null, $id);
		}
	}
		
	public function admin_track_view($id =null)
	{
		$this->loadModel('Track');
		$this->Track->id = $id;
        $user = $this->Track->find('first',array('conditions' =>array('Track.id' =>$id)));
		$this->set('user',$user);		
	}
	
	public function admin_track_delete($id = null)
	{
		$this->loadModel('Track');
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
				$this->Track->id = $id;
		if (!$this->Track->exists()) {
			throw new NotFoundException(__('Invalid Track'));
		}
		if ($this->Track->delete($id,true)) {
			$this->Session->setFlash(__('Track deleted'));
			$this->redirect(array('action' => 'admin_track'));
		}
		$this->Session->setFlash(__('Track was not deleted'));
		$this->redirect(array('action' => 'admin_track'));
	}	
}
?>
