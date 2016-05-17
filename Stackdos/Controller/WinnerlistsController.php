<?php
App::uses('AppController', 'Controller');
/**
 * Albums Controller
 *
 * @property Album $Album
 */
class WinnerlistsController extends AppController {  
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
		$this->loadModel('Category');
		$this->Set('cates',$this->Category->find('all'));
		$this->Set('rpt',$this->Winnerlist->find('all'));
		$this->Set('sngs',$this->Image->find('all'));				
		$this->loadModel('User');
		$this->loadModel('Like');
		$this->Image->contain(array('Like','User'));
		$image = $this->Image->find('all',array('conditions'=>array('AND'=>array('Image.status'=>1))));
		
		foreach($image  as $key => $img) {					
			$totalImageLike = count($img['Like']);
			$image[$key]['Image']['total_like'] = $totalImageLike;
			unset($image[$key]['Like']);
		}
		function sortByOrder($a, $b) {
			return $a['Image']['total_like'] - $b['Image']['total_like'];
		}
		usort($image, 'sortByOrder');
		krsort($image);
		$i = 0;
		$finalArr = array();
		foreach($image as $img){
			$finalArr[] = $img;	
			$i++; if($i>4){ break;}			
		}		
		$this->set('winnerlist',$finalArr);		
	} 				
	
 /* public function admin_index() {
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
                $this->Image->recursive = 0;
                $this->paginate = array('limit' =>10);
                $this->set('winnerlist', $this->paginate());			
        }  
                $this->loadModel('Category');
                $this->Set('cates',$this->Category->find('all'));
                $this->Set('rpt',$this->Winnerlist->find('all'));
                $this->Set('sngs',$this->Image->find('all'));				
				$this->loadModel('User');
				$this->loadModel('Like');
				$this->Image->contain(array('Like'));
				$image = $this->Image->find('all',array('conditions'=>array('AND'=>array('Image.status'=>1))));
			    //debug($image); exit;
				$a=0;
				$ab = array();
				foreach($image  as $img) {
				//	$like = $this->Like->find('count',array('conditions'=>array('Like.status'=> 1,'Like.image_id'=>$img['Image']['id'])));
					
					$ab[$a]= count($img['Like']);
					$a++;
					$lik = rsort($ab);
					
						

					if($img['User']['profile_image']){
						$pictu =  FULL_BASE_URL.  $this->webroot.'files/profileimage/'.$img['User']['profile_image'];
					 }else{
						 $pictu = "https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcTBqEn3JJeetwgw0rWwELHl3XwbIxFLeoKvSwmIWw-HbU-Az8OQ";
					 }
					 
				  $image  = FULL_BASE_URL.  $this->webroot.'files/images/'.$img['Image']['image'];
				  $profile_image  =  $pictu;
				@$abc[] = array('id'=> $img['Image']['id'],'image'=>$image,'likes'=>$like,'user_id'=>$img['Image']['user_id'],'username'=>$img['User']['username'],'first_name'=>$img['User']['first_name'],'last_name'=>$img['User']['last_name'],'profile_image'=>$profile_image);
				}													
				$ac = array_slice($ab, 0, 3);
				print_r($ac);
				
			   $response =@$abc ;
				$this->set('winnerlist',$response);		
	} 	  */
	
	
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
$this->loadModel('Winnerlist');
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

/*	public function winnerlist() {
		$this->loadModel('User');
		$this->loadModel('Like');
		$this->loadModel('Image');
		$image = $this->Image->find('all',array('conditions'=>array('AND'=>array('Image.status'=>1))));
		//debug($image); exit;
		foreach($image  as $img) {
			$like = $this->Like->find('count',array('conditions'=>array('Like.status'=> 1,'Like.image_id'=>$img['Image']['id'])));
			//debug($like); exit;
            if($img['User']['profile_image']){
                $pictu =  FULL_BASE_URL.  $this->webroot.'files/profileimage/'.$img['User']['profile_image'];
             }else{
                 $pictu = "https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcTBqEn3JJeetwgw0rWwELHl3XwbIxFLeoKvSwmIWw-HbU-Az8OQ";
             }
			  $image  = FULL_BASE_URL.  $this->webroot.'files/images/'.$img['Image']['image'];
			  $profile_image  =  $pictu;
			@$abc[] = array('id'=> $img['Image']['id'],'image'=>$image,'likes'=>$like,'user_id'=>$img['Image']['user_id'],'username'=>$img['User']['username'],'first_name'=>$img['User']['first_name'],'last_name'=>$img['User']['last_name'],'profile_image'=>$profile_image);
		}
	   $response =@$abc ;
        //   debug($response) ;  
     $this->set('winnerlist',$response);		

	} */
	

}?>
