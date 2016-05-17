<?php
App::uses('AppController', 'Controller');
/**
 * Albums Controller
 *
 * @property Album $Album
 */
class ReportsController extends AppController {  
//public $components = array('ImageResize');
/**
 * index method
 *
 * @return void
 */
 //var  $uses=array('Image','Report');
   
public function beforeFilter() {
 parent::beforeFilter();
 $this->Auth->allow();
 //$this->Auth->allow(array('imagelist','categoryimage','like','popularimage','winnerlist','add','userLike'));
 	//configure::write('debug',2);
}


public function admin_index() {
  $this->loadModel('Image');
    if($this->request->is('post')){              
            @$keyword = $this->request->data['keyword'];		
            @$category_id =  $this->request->data['category'];			
               if($keyword){
                    $song = $this->Image->find('all',array('conditions'=>array('OR'=>array('Image.artist LIKE'=>"%$keyword%",'Image.singer LIKE'=>"%$keyword%",'Image.song_name LIKE'=>"%$keyword%",'Image.type LIKE'=>"%$keyword%"))));
                    if(empty($song)){
                        $this->loadModel('Album');
                        $alb = $this->Album->find('all',array('conditions'=>array('Album.album_name LIKE'=>"%$keyword%"),"fields"=>array('id')));
                        $song = $this->Image->find('all',array('conditions'=>array('Image.album_id'=>$alb[0]['Album']['id'])));				 
                    }
               }else if(!empty($album_id)){
                         $song = $this->Image->find('all',array('conditions'=>array('Image.album_id'=>$album_id)));
               }
               if(empty($song)){
                         $this->Session->setFlash(__("Please try again,We didn't get your query."));
                 }		
               $this->Set('songs',$song);
        }else{
                $this->Report->recursive = 0;
                $this->paginate = array('limit' =>10);
				// echo "<pre>"; print_r($this->paginate());
                $this->set('reports', $this->paginate());					
        }
                $this->loadModel('Category');
                $this->Set('cates',$this->Category->find('all'));
                $this->Set('rpt',$this->Report->find('all'));
}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
public function admin_view($id = null) {
        $this->Report->id = $id;
        if (!$this->Report->exists()) {
                throw new NotFoundException(__('Invalid Image'));
        }
        $this->set('report', $this->Report->read(null, $id));

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
$this->loadModel('Image');
        if (!$this->request->is('post')) {
                throw new MethodNotAllowedException();
        }
        $this->Image->id = $id;
        if (!$this->Image->exists()) {
                throw new NotFoundException(__('Invalid song'));
        }
        if ($this->Image->delete($id,true)) {
                $this->Session->setFlash(__('Image deleted'));
                $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Image was not deleted'));
        $this->redirect(array('action' => 'index'));
}
	
	
public function admin_deleteall($id = null){
if (!$this->request->is('post')) {
    throw new MethodNotAllowedException();
}
foreach ($this->request['data']['Image'] as $k) {
    $this->Image->id = (int) $k;
    if ($this->Image->exists()) {
        $this->Image->delete($k,true);
    }            
}        
$this->Session->setFlash(__('Selected Images were removed.'));
                $this->redirect(array('action' => 'index'));
}
	
	
	
public function admin_activate($id = null) {  
$this->loadModel('Image');
$this->Image->id = $id;
if ($this->Image->exists()) {
    $x = $this->Image->save(array(
        'Image' => array(
            'status' => '1'
        )
    ));
    $this->Session->setFlash("Image activated successfully.");
    $this->redirect(array(
        'action' => 'index'
    ));
} else {
    $this->Session->setFlash("Unable to activate Image.");
    $this->redirect(array(
        'action' => 'index'
    ));
}        
}
    
    
public function admin_block($id = null) {
$this->loadModel('Image');
    $this->Image->id = $id;
    if ($this->Image->exists()) {
        $x = $this->Image->save(array(
            'Image' => array(
                'status' => '0'
            )
        ));
        $this->Session->setFlash("Image blocked successfully.");
        $this->redirect(array(
            'action' => 'index'
        ));
    } else {
        $this->Session->setFlash("Unable to block Image.");
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
foreach ($this->request['data']['Image'] as $k => $v) {	
if($k == $v){
        $this->Image->id = $v;
        if ($this->Image->exists()) {
                $x = $this->Image->save(array(
                        'Image' => array(
                                'status' => "1"
                        )					
                ));
$this->Session->setFlash(__('Selected Image Activated.', true));					
        } else {
                $this->Session->setFlash("Unable to Activate Image.");
        }
}            
}
 $this->redirect(array(
'action' => 'index'
));
}
	
	
		
public function admin_deactivateall($id = null){
	$this->loadModel('Image');
	if (!$this->request->is('post')) {
		throw new MethodNotAllowedException();
	}        
foreach ($this->request['data']['Image'] as $k => $v) {	
        if($k == $v){
                $this->Image->id = $v;
                if ($this->Image->exists()) {
                        $x = $this->Image->save(array(
                                'Image' => array(
                                        'status' => "0"
                                )					
                        ));
        $this->Session->setFlash(__('Selected Image Deactivated.', true));					
                } else {
                        $this->Session->setFlash("Unable to Deactivated Image.");
                }
        }
}
         $this->redirect(array(
        'action' => 'index'
    ));
}
	
	

}?>
