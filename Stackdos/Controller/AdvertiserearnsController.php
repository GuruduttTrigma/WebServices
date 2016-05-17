<?php
App::uses('AppController', 'Controller');
/**
 * Albums Controller
 *
 * @property Album $Album
 */
class AdvertiserearnsController extends AppController {  
// public $components = array('ImageResize');
/**
 * index method
 *
 * @return void
 */
   
public function beforeFilter() {
 parent::beforeFilter();
 $this->Auth->allow(array('test'));
}


public function admin_index() {
    if($this->request->is('post')){              
            @$keyword = $this->request->data['keyword'];			
               if($keyword){
                    $adsearn = $this->AdvertiserEarn->find('all',array('conditions'=>array('OR'=>array('AdvertiserEarn.no_of_friends LIKE'=>"%$keyword%",'AdvertiserEarn.potential LIKE'=>"%$keyword%"))));

               }
               if(empty($adsearn)){
                         $this->Session->setFlash(__("Please try again,We didn't get your query."));
                 }		
               $this->Set('adsearns',$adsearn);
        }else{
            //   $this->AdvertiserEarn->recursive = 0;
               $this->paginate = array('order' => array('AdvertiserEarn.id' => 'desc'),'limit' =>10);
                $this->set('adsearns', $this->paginate());					
        }
            // $this->Set('ads',$this->AdvertiserEarn->find('all'));
}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
public function admin_view($id = null) {
        $this->AdvertiserEarn->id = $id;
        if (!$this->AdvertiserEarn->exists()) {
                throw new AdvertiserEarn(__('Invalid Advertisement Cost'));
        }
        $this->set('ads', $this->AdvertiserEarn->read(null, $id));

}

/**
 * admin_add method
 *
 * @return void
 */
  public function admin_add() {
    if ($this->request->is('post')) {
      $this->Advertisercost->create();
	  $this->request->data['Advertisercost']['status'] =1;
      if ($this->Advertisercost->save($this->request->data)) {
			$this->Session->setFlash(__('The Advertiser Cost has been saved'));
			$this->redirect(array('action' => 'index'));
      } else {
			$this->Session->setFlash(__('The Advertiser Cost could not be saved. Please, try again.'));
      }
    }
  }

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
 
 public function admin_edit($id = null) {
        $this->Advertiserearn->id = $id;
        if (!$this->Advertiserearn->exists()) {
                throw new NotFoundException(__('Invalid Image'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
				 $this->request->data['Advertiserearn']['status'] =1;
                if ($this->Advertiserearn->save($this->request->data)) {
                        $this->Session->setFlash(__('The Advertiser Earn has been saved'));
                        $this->redirect(array('action' => 'index'));
                } else {
                        $this->Session->setFlash(__('The Advertiser Earn could not be saved. Please, try again.'));
                }
        } else {
                $this->request->data = $this->Advertiserearn->read(null, $id);
        }
        $this->set('advertisement', $this->Advertiserearn->read(null, $id));		
}


/**
 * admin_delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
public function admin_delete($id = null) {
        if (!$this->request->is('post')) {
                throw new MethodNotAllowedException();
        }
        $this->Advertisement->id = $id;
        if (!$this->Advertisement->exists()) {
                throw new NotFoundException(__('Invalid song'));
        }
        if ($this->Advertisement->delete($id,true)) {
                $this->Session->setFlash(__('Advertisement deleted'));
                $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Advertisement was not deleted'));
        $this->redirect(array('action' => 'index'));
}
	
	
public function admin_deleteall($id = null){
if (!$this->request->is('post')) {
    throw new MethodNotAllowedException();
}
foreach ($this->request['data']['Advertisement'] as $k) {
    $this->Advertisement->id = (int) $k;
    if ($this->Advertisement->exists()) {
        $this->Advertisement->delete($k,true);
    }            
}        
$this->Session->setFlash(__('Selected Advertisement were removed.'));
                $this->redirect(array('action' => 'index'));
}
	
	
	
public function admin_activate($id = null) {  
$this->Advertisement->id = $id;
if ($this->Advertisement->exists()) {
    $x = $this->Advertisement->save(array(
        'Advertisement' => array(
            'status' => '1'
        )
    ));
    $this->Session->setFlash("Advertisement activated successfully.");
    $this->redirect(array(
        'action' => 'index'
    ));
} else {
    $this->Session->setFlash("Unable to activate Advertisement.");
    $this->redirect(array(
        'action' => 'index'
    ));
}        
}
    
    
public function admin_block($id = null) {
    $this->Advertisement->id = $id;
    if ($this->Advertisement->exists()) {
        $x = $this->Advertisement->save(array(
            'Advertisement' => array(
                'status' => '0'
            )
        ));
        $this->Session->setFlash("Advertisement blocked successfully.");
        $this->redirect(array(
            'action' => 'index'
        ));
    } else {
        $this->Session->setFlash("Unable to block Advertisement.");
        $this->redirect(array(
            'action' => 'index'
        ));
    }        
}
	
	
	
	
	
public function admin_activateall($id = null){
if (!$this->request->is('post')) {
throw new MethodNotAllowedException();
}        
//debug($this->request);exit;
foreach ($this->request['data']['Advertisement'] as $k => $v) {	
if($k == $v){
        $this->Advertisement->id = $v;
        if ($this->Advertisement->exists()) {
                $x = $this->Advertisement->save(array(
                        'Advertisement' => array(
                                'status' => "1"
                        )					
                ));
	$this->Session->setFlash(__('Selected Advertisement Activated.', true));					
        } else {
                $this->Session->setFlash("Unable to Activate Advertisement.");
        }
}            
}
 $this->redirect(array(
'action' => 'index'
));
}
	
	
		
public function admin_deactivateall($id = null){
        if (!$this->request->is('post')) {
    throw new MethodNotAllowedException();
}        
foreach ($this->request['data']['Advertisement'] as $k => $v) {	
        if($k == $v){
                $this->Advertisement->id = $v;
                if ($this->Advertisement->exists()) {
                        $x = $this->Advertisement->save(array(
                                'Advertisement' => array(
                                        'status' => "0"
                                )					
                        ));
				$this->Session->setFlash(__('Selected Advertisement Deactivated.', true));					
                } else {
                        $this->Session->setFlash("Unable to Deactivated Advertisement.");
                }
        }
}
         $this->redirect(array(
        'action' => 'index'
    ));
}


}?>
