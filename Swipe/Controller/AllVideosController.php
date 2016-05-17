<?php
class AllVideosController extends AppController 
{
	public $uses = array('Category','AllVideo','VideoComment','VideoLike','VideoDislike','VideoView','User','UserFollower','FavoriteVideo','SiteSetting');
	public function beforeFilter() 
	{
		parent::beforeFilter();
		$this->Auth->allow(array('categorylist','post_category'));
	}
    
    public function company_category() 
	{
        $this->set("categories",$this->Category->find("all",array('conditions'=>array("Category.status"=>"1"))));
    }
    public function post_category() 
	{
        $this->set("categories",$this->Category->find("all",array('conditions'=>array("Category.status"=>"1"))));
    }
	public function view($id = null) 
	{
		$this->Category->id = $id;
		if (!$this->Category->exists()) {
			throw new NotFoundException(__('Invalid category'));
		}
		$this->set('category', $this->Category->read(null, $id));
	}
	public function add() 
	{
		if ($this->request->is('post')) {
			$this->Category->create();
			if ($this->Category->save($this->request->data)) {
				$this->Session->setFlash(__('The category has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The category could not be saved. Please, try again.'));
			}
		}
		$parentCategories = $this->Category->ParentCategory->find('list');
		$this->set(compact('parentCategories'));
	}
	public function edit($id = null) 
	{
		$this->Category->id = $id;
		if (!$this->Category->exists()) {
			throw new NotFoundException(__('Invalid category'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Category->save($this->request->data)) {
				$this->Session->setFlash(__('The category has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The category could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Category->read(null, $id);
		}
		$parentCategories = $this->Category->ParentCategory->find('list');
		$this->set(compact('parentCategories'));
	}
	public function delete($id = null) 
	{
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Category->id = $id;
		if (!$this->Category->exists()) {
			throw new NotFoundException(__('Invalid category'));
		}
		if ($this->Category->delete()) {
			$this->Session->setFlash(__('Category deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Category was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
        public function admin_main() {}
	public function admin_index() {
		if($this->request->is('post')){
			$keyword = trim($this->request->data['keyword']);
            $this->set('videos',$this->AllVideo->find('all',array('conditions'=>array("AllVideo.description LIKE"=>"%$keyword%"),'order'=>'AllVideo.id DESC')));
	}else{

		$this->AllVideo->recursive = 0;
		$this->paginate = array('limit' =>10, 'order'=>'AllVideo.id DESC');
		//pr ($this->paginate('AllVideo'));die;		
		$this->set('videos', $this->paginate('AllVideo'));
	}
	 $this->set('cates',$this->AllVideo->find('all'));
	}
	public function admin_view($id = null) {
		$this->Category->id = $id;
		if (!$this->Category->exists()) {
			throw new NotFoundException(__('Invalid category'));
		}
		$this->set('category', $this->Category->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
				$this->Category->Validates();
				$this->request->data['Category']['status'] = 1;	
				$categoryName = $this->request->data['Category']['name'];		
				$categoryExist = $this->Category->find('first',array('conditions'=>array('Category.name'=>$categoryName)));
				if(empty($categoryExist)){
					$this->Category->create();
					if ($this->Category->save($this->request->data)) {				
							$this->Session->setFlash(__('The category has been saved'));
							$this->redirect(array('action' => 'index'));
					} else {
							$this->Session->setFlash(__('The category could not be saved. Please, try again.'));
					}
				}  else {
					$this->Session->setFlash(__('This Category is already exist.plz try another category.'));
				}
		}
	}

	public function admin_add_video() {
		$this->loadModel('Category');
		$this->loadModel('User');
		$this->User->recursive=-1;
		ini_set('max_execution_time', 50000);
		ini_set('memory_limit', '900M');		
		ini_set('post_max_size', '900M');		
		//echo "<pre>";print_r ($_SERVER['HTTP_HOST']);die;
		//$url	=  $_SERVER['HTTP_HOST'].'/admin/AllVideos/add_video';
		//echo $url;die; 
		if ($this->request->is('post')) {
            $data['AllVideo']['user_id']				=	$this->request->data['AllVideo']['username'];
			$data['AllVideo']['category_id']		=	$this->request->data['AllVideo']['Category_name'];
			$data['AllVideo']['title']						=	'title';
			$data['AllVideo']['description']			=	$this->request->data['AllVideo']['description'];			
			$data['AllVideo']['total_likes']			=	0;
			$data['AllVideo']['total_dislikes']		=	0;
			$data['AllVideo']['total_comments']	=	0;
			$data['AllVideo']['total_views']			=	0;
			$data['AllVideo']['uploaded_by']		=	'Admin';
			$data['AllVideo']['date']					=	date("Y-m-d H:i:s");
			/*  */
			$one = $this->request->data['AllVideo']['video'];
			
			if ($one['name'])  {
				$profileImage = str_replace(' ','_',$one['name']);
				$name=  time()."video.mov"; 
				$nameImg= time()."image.png";
			}	
			
			if ($one['error'] == 0) {
				$pth 	= WWW_ROOT.'files/full_videos' . DS .$name;
				$pth1 	= WWW_ROOT.'files/small_videos' . DS .$name;
				move_uploaded_file($one['tmp_name'], $pth);                   
				move_uploaded_file($one['tmp_name'], $pth1);                   
			}		
			
			$data['AllVideo']['full_video']			=	$name;
			//echo $pth;die;		
			/*  */
			if ($this->AllVideo->save($data)) {
				$last    = $this->AllVideo->getLastInsertID();			
					$imagefile = WWW_ROOT.'files' . DS . 'thumbnail_images/'.$nameImg;
					exec('ffmpeg  -i ' . $pth . ' -f mjpeg -vframes 1 -s 320x270 -an ' . $imagefile . '');
					$xyz = shell_exec("ffmpeg -i \"{$pth}\" 2>&1");
					$search='/Duration: (.*?),/';
					preg_match($search, $xyz, $matches);
					$explode = explode(':', $matches[1]);
					//echo 'Hour: ' . $explode[0];
					//echo 'Minute: ' . $explode[1];
					//echo 'Seconds: ' . $explode[2];
					$duration = floor(60*$explode[1] + $explode[2]); 
					$this->AllVideo->saveField('duration',$duration);
					
				$this->Session->setFlash(__('Video Uploaded. Please crop video.'));
				$this->redirect(array('action' => 'crop_video','controller' =>'AllVideos',$last));
			} else {
				$this->Session->setFlash(__('Video Uploaded.'));
			}
		}
		$user = $this->User->find('list',array('fields'=>array('username')));
		$Category = $this->Category->find('list',array('fields'=>array('name')));
		$this->set(compact('user','Category'));

	}
	
	public function admin_crop_video($id) {
		$data	=	$this->AllVideo->find ('first',array('conditions'=>array('AllVideo.id'=>$id)));
		//echo "<pre>";print_r ($data);die;
		$category_id				=	$data['AllVideo']['category_id'];
		$full_video_name 	= $data['AllVideo']['full_video'];
		$allvideo_id = $id; 
		$this->set ('info',$data);
		if ($this->request->is('post')) {
			if (!empty($this->request->data)) {				
				$full_video_starting 	= 	$this->request->data['cropVideoStart'];		
				$full_video_ending 	= 	$this->request->data['cropVideoEnd'];
				$thumnail_time 			=	$this->request->data['thumbnailTime'];
				$video_duration		=	$full_video_ending - $full_video_starting;
				if ($video_duration <= 30  OR ($category_id == 6 && $video_duration  <=360 ))  {
					$last    			= $allvideo_id;
					$one 				= $full_video_name;
					$name			=  $last."video.mov"; 
					$time				=	time();
					$smViName	=	$time."small_video.mov";	
					$nameImg		= 	$time."image.png";	

					$this->User->query ("update all_videos set small_video= '".$smViName."' where id = '".$last."'");
					$this->User->query ("update all_videos set thumbnail_images= '".$nameImg."' where id = '".$last."'");					
				
					$fullVideo		=  WWW_ROOT.'files' . DS . 'full_videos' . DS .$one;					
					$imagefile		= 	WWW_ROOT.'files' . DS . 'thumbnail_images' . DS .$nameImg;												
					$smallVideo	= 	WWW_ROOT.'files' . DS . 'small_videos' . DS .$smViName;
					
					exec("ffmpeg  -i $fullVideo -f mjpeg -ss $thumnail_time -vframes 1 -s 320x270 -an $imagefile");				
					exec("ffmpeg -i $fullVideo -ss $full_video_starting -t $full_video_ending -async 1 -crf 1 $smallVideo");
														
					$this->Session->setFlash(__('Video crop successfully.'));
					$this->redirect(array('action' => 'add_video','controller' =>'AllVideos'));
				}  else  {
					if ($category_id != 6) {
						$this->Session->setFlash(__('<h6 style="color:red">Please crop 30 second video.</h6>'));
					}  else  {
						$this->Session->setFlash(__('<h6 style="color:red">Please crop 360 second video.</h6>'));
					}
				}
			} 	else {
				$this->Session->setFlash(__('Video Uploaded.'));
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
        $this->Category->id = $id;
		$x= $this->Category->find('first',array('conditions'=>array('Category.id'=>$id)));
        if (!$this->Category->exists()) {
                throw new NotFoundException(__('Invalid category'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {           
			if ($this->Category->save($this->request->data)) {		
				$this->Session->setFlash(__('The category has been updated successfully.'));
				$this->redirect(array('action' => 'index'));
			} else {
					$this->Session->setFlash(__('The category could not be saved. Please, try again.'));
			}
        } else {
                $this->request->data = $this->Category->read(null, $id);
        }
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
		$this->AllVideo->id = $id;
		if (!$this->AllVideo->exists()) {
			throw new NotFoundException(__('Invalid Video'));
		}
		if ($this->AllVideo->delete($id,true)) {
			
			$this->FavoriteVideo->deleteAll(array('FavoriteVideo.all_video_id'=>$id));
			$this->VideoComment->deleteAll(array('VideoComment.all_video_id'=>$id));
			$this->VideoLike->deleteAll(array('VideoLike.all_video_id'=>$id));
			$this->VideoView->deleteAll(array('VideoView.all_video_id'=>$id));
			
			$this->Session->setFlash(__('Video deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Video was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
	public function admin_activate($id = null)
    {
        $this->AllVideo->id = $id;
        if ($this->AllVideo->exists()) {
            $x = $this->AllVideo->save(array(
                'AllVideo' => array(
                    'status' => 'Yes'
                )
            ));
            $this->Session->setFlash("Video activated successfully.");
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            $this->Session->setFlash("Unable to activate Video.");
            $this->redirect(array(
                'action' => 'index'
            ));
        }
        
    }
    
    
    public function admin_block($id = null)
    {
        $this->AllVideo->id = $id;
		$data	=	$this->AllVideo->find ('first',array('conditions'=>array('AllVideo.id'=>$id),'contain'=>array()));
		//echo "<pre>";print_r($data);die;
        if (!empty($data)) {
			if ($data['AllVideo']['status']  == 'Yes')  {
				$x = $this->AllVideo->save(array(
					'AllVideo' => array(
						'status' => 'No'
					)
				));
				$this->Session->setFlash("Video blocked successfully.");
				$this->redirect(array(
					'action' => 'index'
				));
			}  else  {
				$x = $this->AllVideo->save(array(
					'AllVideo' => array(
						'status' => 'Yes'
					)
				));
				$this->Session->setFlash("Video activate successfully.");
				$this->redirect(array(
					'action' => 'index'
				));
			}
        } else {			
            $this->Session->setFlash("Unable to block Video.");
            $this->redirect(array(
                'action' => 'index'
            ));
        }
        
    }
	public function admin_deleteall($id = null){
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        foreach ($this->request['data']['AllVideo'] as $k) {
            $this->AllVideo->id = (int) $k;
            if ($this->AllVideo->exists()) {
                if ($this->AllVideo->delete($k,true)) {					
					$this->FavoriteVideo->deleteAll(array('FavoriteVideo.all_video_id'=>$k));
					$this->VideoComment->deleteAll(array('VideoComment.all_video_id'=>$k));
					$this->VideoLike->deleteAll(array('VideoLike.all_video_id'=>$k));
					$this->VideoView->deleteAll(array('VideoView.all_video_id'=>$k));
				}
            }
            
        }
        
        $this->Session->setFlash(__('Selected Video were removed.'));
      //  $this->redirect($this->data['currentloc']);
	  $this->redirect(array(
                'action' => 'index'
            ));
    }
	public function admin_activateall($id = null){
		if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        
        foreach ($this->request['data']['AllVideo'] as $k => $v) {	
		if($k == $v){
			$this->AllVideo->id = $v;
			if ($this->AllVideo->exists()) {
				$x = $this->AllVideo->save(array(
					'AllVideo' => array(
						'status' => "1"
					)
					
				));
	        $this->Session->setFlash(__('Selected Video Activated.', true));					
			} else {
				$this->Session->setFlash("Unable to Activate Video.");
			}
		}
            
        }
		$this->Session->setFlash("Please select atleast one video.");
		$this->redirect($this->data['currentloc']);
    }
		
	public function admin_deactivateall($id = null){
		if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        
        foreach ($this->request['data']['AllVideo'] as $k => $v) {	
		if($k == $v){
			$this->AllVideo->id = $v;
			if ($this->AllVideo->exists()) {
				$x = $this->AllVideo->save(array(
					'AllVideo' => array(
						'status' => "0"
					)
					
				));
	        $this->Session->setFlash(__('Selected Video Deactivated.', true));					
			} else {
				$this->Session->setFlash("Unable to Deactivated Video.");
			}
		}
            
        }
		$this->Session->setFlash("Please select atleast one video.");
		$this->redirect($this->data['currentloc']);
    }
	
	
	
	     public function categorylist() {   
           
                        $resp =  $this->Category->find('all',array("field"=>array("id","name"),'conditions'=>array('Category.status'=>1),'order'=>"Category.name ASC"));         
						$this->loadModel('Image');                
                        foreach ($resp as $re){
								$im = $this->Image->find('first',array('conditions'=>array('Image.status'=>1,'Image.category_id'=>$re['Category']['id']),'order'=>"Image.id DESC")); 
                                                                if(!empty($im['Image']['image'])){
                                                                    $img = FULL_BASE_URL.  $this->webroot.'files/images/'.$im['Image']['image'];
                                                                }
                                                                else{
                                                                    $img=FULL_BASE_URL.  $this->webroot.'files/images/No_Image.png';
                                                                }
								
								$abc[] = array('id'=> $re['Category']['id'],'name'=>$re['Category']['name'],'image'=>$img);
                        }
                        $response = $abc;
                        $this->set('response',$response);
                        $this->render('ajax','ajax');
                   
                  }
					
	public function browse_video()
{
$this->loadModel('Video');
if($this->request->is('ajax'))
{
$user_id=$this->Auth->User('id');
$countVideo= $this->Video->find('count',array('conditions'=>array('Video.user_id'=>$user_id)));
if($countVideo >= 3)
{
	echo 'You cannot upload more than 3 video';
}
/* else
{
	echo 'ok';
} */

}

$this->autoRender=false;
	
}				
				
			
	
	
	
}
