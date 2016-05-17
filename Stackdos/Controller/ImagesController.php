<?php
App::uses('AppController', 'Controller');
/**
 * Albums Controller
 *
 * @property Album $Album
 */
class ImagesController extends AppController {  
public $components = array('ImageResize');
/**
 * index method
 *
 * @return void
 */
   
public function beforeFilter() {
 parent::beforeFilter();
 $this->Auth->allow(array('imagelist','categoryimage','like','popularimage','winnerlist','add','userLike','userUploadedImage','userReport'));
 	//configure::write('debug',2);
}


public function admin_index() {
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
                $this->paginate = array('order' => array('Image.id' => 'desc'),'limit' =>10);
                $this->set('songs', $this->paginate());					
        }
                $this->loadModel('Category');
                $this->Set('cates',$this->Category->find('all'));
                $this->Set('sngs',$this->Image->find('all'));
}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
public function admin_view($id = null) {
        $this->Image->id = $id;
        if (!$this->Image->exists()) {
                throw new NotFoundException(__('Invalid Image'));
        }
        $this->set('songs', $this->Image->read(null, $id));

}

/**
 * admin_add method
 *
 * @return void
 */
public function admin_add() {
    //Configure::write('debug',2);
        if ($this->request->is('post')) {
			   $this->request->data['Image']['status']=1;
               $this->request->data['Image']['user_id']=$this->data['user_id'];
               foreach($this->request->data['Image']['image'] as $image){
                  $once = $image;
				  //$id = $this->Image->getLastInsertId();
                  $this->request->data['Image']['image'] = str_replace("?", "@", $image['name']);  
                  $this->Image->create();
                  $this->Image->save($this->request->data);
                  $id = $this->Image->getLastInsertId();
				  if($id){
				  $this->request->data['Image']['image'] = $id.$this->request->data['Image']['image'];
                  $this->Image->save($this->request->data);				   
                   if ($once['error'] == 0) {                      
                          $pth1 = 'files' . DS . 'images' . DS .$id.str_replace("?", "@", $once['name']);                                                     
                          $pth2 = 'files' . DS . 'smallimages' . DS.$id.str_replace("?", "@", $once['name']);   
                          //echo $pth1."---".$pth2;exit;
                           move_uploaded_file($once['tmp_name'], $pth1);                               
						  copy($pth1, $pth2);
                          $this->ImageResize->resize($pth2,141, 141);
                      }
				 } 
                 }
                $this->Session->setFlash(__('The Images has been saved'));
                $this->redirect(array('action' => 'index'));           
        }
        $this->loadModel('Category');
        $this->Set('cates',$this->Category->find('all'));        
		$id = $this->Auth->User('id');
		$this->set('user',$this->User->find('first',array('conditions'=>array('User.id'=>$id))));
}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
 
 public function admin_edit($id = null) {
        $this->Image->id = $id;
        if (!$this->Image->exists()) {
                throw new NotFoundException(__('Invalid Image'));
        }
        @$Image = $this->Image->find('first',array('conditions'=>array('Image.id'=>$id)));
		//debug($Image); exit;
        if ($this->request->is('post') || $this->request->is('put')) {
             $once = $this->request->data['Image']['image'];   
			if($once['name']){
				$this->request->data['Image']['image'] = $id.$once['name'];
            }else{
                $this->request->data['Image']['image'] = $Image['Image']['image']; 
            }
                if ($this->Image->save($this->request->data)) {
                      if($this->request->data['Image']['image']){
                            if ($once['error'] == 0) {
                                $pth = 'files' . DS . 'images' . DS .$id.$once['name'];
                                move_uploaded_file($once['tmp_name'], $pth);      
                            }                     
                      }
                        $this->Session->setFlash(__('The image has been saved'));
                        $this->redirect(array('action' => 'index'));
                } else {
                        $this->Session->setFlash(__('The image could not be saved. Please, try again.'));
                }
        } else {
                $this->request->data = $this->Image->read(null, $id);
        }
      
      // $this->set('song',$song);
        $this->loadModel('Category');
      //  $this->Set('cates',$this->Category->find('all'));
		$Categories =  $this->Category->find('list', array('fields' => array('Category.name')));	
        $this->set('image', $this->Image->read(null, $id));		
		$this->set('Categories',$Categories);	
		$id = $this->Auth->User('id');
		$this->set('user',$this->User->find('first',array('conditions'=>array('User.id'=>$id))));
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
	
	
    public function admin_albumBycategory(){
            if ($this->request->is('post')) {
                 $cate_id =  $this->request->data['category'];
                 $this->loadModel('Album');
                 $response = $this->Album->find('all',array('conditions'=>array('Album.category_id'=>$cate_id)));				   
                 $this->set('response',$response);
                 $this->render('ajax', 'ajax');
            }        
    }
	
	
    
    public function imagelist($p=null){
         $page = $_REQUEST['page'];
         $pa = ($page-1)*10;
        $image = $this->Image->find('all',array('fields'=>array('id','image'),'conditions'=>array('Image.status'=>1),'order'=>"Image.id DESC","limit"=>10,'offset'=>$pa ));       
        
                foreach($image as $img){
                    $small  = FULL_BASE_URL.  $this->webroot.'files/smallimages/'.$img['Image']['image'];
                    $large  = FULL_BASE_URL.  $this->webroot.'files/images/'.$img['Image']['image'];
                    $title = explode(".",$img['Image']['image']);
                      $abc[] = array('id'=> $img['Image']['id'],'small'=>$small,'large'=>$large,'title'=>  ucfirst(str_replace("@", "?", $title[0])));
                }
           $response = $abc;
           $this->set('response',$response);
           $this->render('ajax', 'ajax');
    }
    
    
     public function categoryimage($c = null, $p=null,$user_id=null){
         $page = $_REQUEST['page'];
         $cate = $_REQUEST['category'];
		 $user_id = $_REQUEST['user_id'];
         $pa = ($page-1)*10;
		 $this->loadModel('Like');
		 $this->loadModel('Favourite');
		// $like = $this->Like->find('all',array('condition'=>array('Like.image_id'=>$_REQUEST['image_id'])));
         $image = $this->Image->find('all',array('fields'=>array('id','image'),'conditions'=>array('AND'=>array('Image.status'=>1,'Image.category_id'=>$cate)),'order'=>"Image.id DESC",'offset'=>$pa ));       
		
		 //debug($image);exit;
	  

					foreach($image as $img){
						$like = $this->Like->find('count',array('conditions'=>array('Like.image_id'=> $img['Image']['id'],'Like.user_id'=>$user_id )));
						$likec = $this->Like->find('count',array('conditions'=>array('Like.image_id'=> $img['Image']['id'])));
						// debug($like);exit;
						if($like==0){
							$favo = $this->Favourite->find('count',array('conditions'=>array('Favourite.image_id'=> $img['Image']['id'])));
							if($favo=='0'){
							  $favo = 0;	
							} else {
								$favo = 1;	
							}
							$small  = FULL_BASE_URL.  $this->webroot.'files/smallimages/'.$img['Image']['image'];
							$large  = FULL_BASE_URL.  $this->webroot.'files/images/'.$img['Image']['image'];
							$title = explode(".",$img['Image']['image']);
							 @$abc[] = array('id'=> $img['Image']['id'],'like'=>$likec,'favourite'=>$favo,'small'=>$small,'large'=>$large,'title'=>ucfirst(str_replace("@", "?", $title[0])));
						 }
					}

		  // $response['status'] = 0;	
           $response = @$abc;
           $this->set('response',$response);
           $this->render('ajax', 'ajax');
    }
	
	public function like($image_id = null,$user_id = null,$like_id=null){
			$this->loadModel('Like');
			$like_id = $_REQUEST['like_id'];
			$response=  array();			
			$like = $this->Like->find('first',array('conditions'=>array('Like.user_id'=>$_REQUEST['user_id'],'Like.image_id'=>$_REQUEST['image_id'])));
			if(empty($like)){
					
						$this->request->data['Like']['user_id'] = $_REQUEST['user_id'];
						$this->request->data['Like']['status'] = $like_id;
						$this->request->data['Like']['image_id'] = $_REQUEST['image_id'];
						$this->Like->create();
						$this->Like->save($this->request->data);			
						$response['status'] = 1;
						$this->set('response',$response);
						$this->render('ajax','ajax');

			}
			else if($like_id ==0){
					$like1 = $this->Like->find('first',array('conditions'=>array('Like.user_id'=>$_REQUEST['user_id'],'Like.image_id'=>$_REQUEST['image_id'])));
					if(!empty($like1)){
						$this->request->data['status'] = 0;
						$this->request->data['id'] = $like1['Like']['id'];
						$this->Like->save($this->request->data);		
						$response['status'] = 0;
						$this->set('response',$response);
						$this->render('ajax','ajax');	
					}
			}
			
			else if($like_id ==1){
					$like1 = $this->Like->find('first',array('conditions'=>array('Like.user_id'=>$_REQUEST['user_id'],'Like.image_id'=>$_REQUEST['image_id'])));
					if(!empty($like1)){
						$this->request->data['status'] = 1;
						$this->request->data['id'] = $like1['Like']['id'];
						$this->Like->save($this->request->data);		
						$response['status'] = 1;
						$this->set('response',$response);
						$this->render('ajax','ajax');
					}
			}
			

			$this->autoRender = false;
	}
	
   public function userLike(){
		$this->loadModel('Like');
		$this->loadModel('Image');
		$user_id=$_REQUEST['user_id'];
		$likes=$this->Like->find('all',  array('conditions'=>  array('Like.user_id'=>$user_id,'Like.status'=>1)));
		if($likes){
		foreach ($likes as $key => $value){
			$images=$this->Image->find('first',  array('conditions'=>  array('Image.id'=>$value['Like']['image_id'])));
			@$imageData[]=  array('image'=>FULL_BASE_URL.  $this->webroot.'files/images/'.$images['Image']['image'],'image_category'=>$images['Image']['category_id'],'image_id'=>$images['Image']['image'],'status'=>1);
		} 
		} else {
		@$imageData[] = array('status' => 0);
		}
		   $response = @$imageData;
           $this->set('response',$response);
           $this->render('ajax', 'ajax');
	}  

	public function userUploadedImage(){
		$this->loadModel('Like');
		$this->loadModel('User');
	    $this->loadModel('Image');
		$user_id = $_REQUEST['user_id'];
		$image = $this->Image->find('all',array('conditions'=>array('Image.user_id'=>$user_id,'Image.status'=>1),'order'=>"Image.id DESC"));
		//debug($image); exit;
		if(@$image) {
		foreach($image as $img) {
			$imageData[] = array('image'=>FULL_BASE_URL.$this->webroot.'files/images/'.$img['Image']['image'],'image_category'=>$img['Image']['category_id'],'name'=>$img['Image']['image'],'status'=>1);
			}
		} else {
			$imageData[] = array('status' =>0);
		}
		$response = @$imageData;
		$this->set('response',$response);
		$this->render('ajax','ajax');
	}
	
    public function userReport(){
		 $this->request->data['Report']['user_id'] = $_REQUEST['user_id'];
		 $this->request->data['Report']['image_id'] = $_REQUEST['image_id'];
		 $this->request->data['Report']['message'] = $_REQUEST['message'];
		 $this->loadModel('Report');
		 $this->loadModel('User');
		 $this->loadModel('Sitesetting');
		 $user = $this->Sitesetting->find('all');
		//debug($user); exit;
		 $image = $this->Image->find('all',array('conditions'=>array('Image.status'=>1,'Image.id'=>$_REQUEST['image_id'])));
		// debug($image); exit;
		 $this->Report->create();
			 if($this->Report->save($this->request->data)) {
					$user = $this->Sitesetting->find('all');
					//$l = new CakeEmail('smtp');
					//$l->config('smtp')->emailFormat('html')->template('signup', 'fancy')->subject('Report to admin')->to($user[0]['Sitesetting']['site_email'])->send($_REQUEST['message']);
					//$this->set('smtp_errors', "none");
						$Email = new CakeEmail('smtp');
						//$Email->from(array("lavkush.ramtripathi@trigma.in" => 'Bad wolf syndicate'));
						//$Email->from(array($image[0]['User']['email'] => $image[0]['User']['first_name']));
						$Email->config('smtp')->template('report', 'fancy')
														->emailFormat('html')
														->subject('Report to admin ')
														->viewVars(array('user_id'=> $_REQUEST['user_id'],
														'user_name'=>@$image['0']['User']['first_name'],
														'message'=>@$_REQUEST['message'],
																				))
														->to($user[0]['Sitesetting']['site_email'])
														->send();
					 $this->set('smtp_errors', "none");					
					$response = array('status'=>"Successfully Saved !!!!");
					echo json_encode($response);
					exit;
			} else {
					$response = array('status'=>"Could not save, Please try again !!!!");
					echo json_encode($response);
					exit;	
			}
	} 
	
	public function addfavourite($image_id = null, $user_id = null){
			$this->loadModel('Favourite');
			$response=  array();
			$favo = $this->Favourite->find('first',array('conditions'=>array('Favourite.user_id'=>$_REQUEST['user_id'],'Favourite.image_id'=>$_REQUEST['image_id'])));
			if($favo){
				 $this->Favourite->query('delete from `favourites` where  `id`='.$favo['Favourite']['id']);
				    $response['status'] = 0;
                    $this->set('response',$response);
                    $this->render('ajax','ajax');
			} else {
				  $this->request->data['Favourite']['user_id'] = $_REQUEST['user_id'];
					$this->request->data['Favourite']['status'] = 1;
					$this->request->data['Favourite']['image_id'] = $_REQUEST['image_id'];
					$this->Favourite->create();
					$this->Favourite->save($this->request->data);			
                    $response['status'] = 1;
                    $this->set('response',$response);
                    $this->render('ajax','ajax');					
			}
	}
	
	public function popularimage() {
		$this->loadModel('Like');
		//$response = array();	
		$image = $this->Image->find('all',array('fields'=>array('id','image'),'conditions'=>array('AND'=>array('Image.status'=>1))));
		//echo "<pre>"; print_r($image); exit;
	   foreach($image as $img) {
			 $like = $this->Like->find('count',array('conditions'=>array('Like.status'=> 1,'Like.image_id'=>$img['Image']['id'])));
			 @$abc[] = array('id'=> $img['Image']['id'],'image'=>FULL_BASE_URL.  $this->webroot.'files/images/'.$img['Image']['image'],'likes'=>$like);
		} 
		$response =@$abc ;
		$this->set('response',$response);
		$this->render('ajax','ajax');
	}  
	
	
	public function winnerlist() {
		$this->loadModel('User');
		$this->loadModel('Like');
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
		$this->set('response',$response);
		$this->render('ajax','ajax');

	} 
	
	/*public function showwinnerList(){
		$this->loadModel('User');
		$this->loadModel('Like');	
		$image = $this->Image->find('all',array('conditions'=>array('AND'=>array('Image.status'=>1))));		
		// debug($image);
		$this->set('image',$image);
	} */
	public function add(){
			
					//$id=$_REQUEST['id'];
					$this->request->data['Image']['status'] = '0' ;
					$this->request->data['Image']['category_id'] = $_REQUEST['category_id'] ;
					$this->request->data['Image']['user_id'] = $_REQUEST['user_id'] ;
					$this->request->data['Image']['image'] = $_REQUEST['image'] ;		
					$this->Image->create();
						if ($this->Image->save($this->request->data)) {
								$id=$this->Image->getLastInsertId();	
								$dname= $id."image.png";
								$this->Image->saveField('image',$dname);
								// $d_t="'".$_REQUEST['date']."'";                           
								@$_REQUEST['image']= str_replace('data:image/png;base64,', '', $_REQUEST['image']);
								$_REQUEST['image'] = str_replace(' ', '+',$_REQUEST['image']);
								$unencodedData=base64_decode($_REQUEST['image']);
								$pth3 = WWW_ROOT.'files' . DS . 'images'. DS .$dname;
								$pth4 = WWW_ROOT.'files' . DS . 'smallimages'. DS .$dname;
								file_put_contents($pth3, $unencodedData);                                     
								copy($pth3, $pth4);
								$this->ImageResize->resize($pth4,141, 141);								
								$response = array('status'=>"Successfully Saved !!!!");
								echo json_encode($response);
								exit;
						} else{
								$response = array('status'=>"Could not save, Please try again !!!!");
								echo json_encode($response);
								exit;				
						}
		          
	}
}?>
