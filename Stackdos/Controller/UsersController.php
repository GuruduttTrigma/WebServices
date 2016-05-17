<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 *
 * @property User $User
 * @property SessionComponent $Session
 * @property AuthComponent $Auth
 */
class UsersController extends AppController {

/**
 * Components
 *
 * @var array
 */
	//public $components = array('Session', 'Auth');
	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow(array('changeUserImage','mobileownerlogin','admin_admin','add','register','admin_login','user_logout','login','confirm','loggedin','profile_search','profile_view','view','admin_forget','admin_reset','forgetpassword','resetpassword','admin_add','mobileuserlogin','reset','mobileuserforgot','forget','changepass','profile_edit','getUserDetails','mobilemanagerlogin','remove_user_token'));
	}
/**
 * logout method
 *
 * @return void  
 
 */
	
	public function profile_view($id = null) {
            $id=$this->User->id = $_REQUEST['id'];
            $data=$this->User->find('first',  array('conditions'=>  array('User.id'=>$id)));
           //echo '<pre>';print_r($data);exit;
            $usertype=$data['UserType']['group_name'];
            
                
                $profile[]=  array('id'=>$id,
                                   'username'=>$data['User']['username'],
                                   'email'=>$data['User']['email'],
                                   'profile_image'=>FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$data['User']['profile_image'],
                                   'usertype'=>$usertype,
                                   'register_date'=>$data['User']['register_date'],
                                   'name'=>$data['User']['first_name']
                        );
          
             echo json_encode($profile);exit;
    }	 
	public function changeUserImage($u = null,$i = null){
	
		$id = $this->User->id = $_REQUEST['user_id'];
		$image = $this->request->data['User']['profile_image']  = $_REQUEST['image'];
		$this->request->data['User']['status'] = 1;
		if(!empty($_REQUEST['image'])){
				$im = $this->User->find('first',array('conditions'=>array('User.id'=>$id)));
					if(!empty($im['User']['profile_image'])){
						$old = WWW_ROOT.'files' . DS . 'profileimage' . DS .$im['User']['profile_image'];
						if(file_exists($old)){
							unlink($old);
						}
					}
		}		
		 //$time = date("Y-m-d");  
		 $time=time();
		if($this->User->save($this->request->data)) {
                        if(@$image){
                        $name=$id.$time."profileImage.png";
                        $this->User->saveField('profile_image',$name);
                        @$_REQUEST['profile_image']= str_replace('data:image/png;base64,', '', @$_REQUEST['image']);
                        $_REQUEST['profile_image'] = str_replace(' ', '+',$_REQUEST['profile_image']);
                        $unencodedData=base64_decode($_REQUEST['profile_image']);
                        $pth = WWW_ROOT.'files' . DS . 'profileimage' . DS .$name;
                        file_put_contents($pth, $unencodedData);
						$response = array('image'=>FULL_BASE_URL.  $this->webroot.'files/profileimage/'.$name,'status'=>"Successfully User Image Saved !!!!");
						echo json_encode($response);
						exit;
                    } 		 
		 } 
		else {
						$response = array('status'=>"Could not save User Image, Please try again !!!!");
						echo json_encode($response);
						exit;			 
		}
	}

	
	public function admin_login(){ 
	
		 if ($this->request->is('post')) {
		 //debug(AuthComponent::password($this->request->data['User']['password']));exit;
		$xcv = $this->User->find('first',array('conditions' => array('username' => $this->data['User']['username'])));
			if(!empty($xcv)){
				if($xcv['User']['username'] && $xcv['User']['status']== 0 ){
				$this->Session->setFlash('Your status is not active.');
									$this->redirect(array('controller' => 'Users', 'action' => 'admin_login'));
				}
           App::Import('Utility', 'Validation');
            if (isset($this->data['User']['username']) && Validation::email($this->data['User']['username'])){
                $this->request->data['User']['email'] = $this->data['User']['username'];
                $this->Auth->authenticate['Form']     = array(
                    'fields' => array(
		             	'userModel' => 'User',
                        'username' => 'email'
                    )
                );
                $x = $this->User->find('first',array('conditions' => array('email' => $this->data['User']['username'])));
            } else {
                $this->Auth->authenticate['Form'] = array(
                    'fields' => array(
		             	'userModel' => 'User',
                        'username' => 'username'
                    )
                ); 
                $x = $this->User->find('first',array('conditions' => array('username' => $this->data['User']['username'])));
            }
           if($x['UserType']['group_name'] == 'Administrators'){       
            	if (!$this->Auth->login()) { 
            		$this->Session->setFlash('Please check your password.');
            		$this->redirect(array('controller' => 'Users', 'action' => 'admin_login'));
            	}else {
            		$this->Session->write('admin',true);
            		//$this->Session->setFlash('Successfuly signed in');
					            //	$this->redirect($this->Auth->redirect("/"));
            		$this->redirect(array('controller' => 'Users', 'action' => 'admin_dashboard'));
            	}        
            }else{
            	//$this->Session->setFlash("You don't have Administrator authorities.");
				$this->Session->setFlash("The username or password you entered is incorrect.");
            	//$this->redirect($this->Auth->redirect("/"));
				$this->redirect(array('controller' => 'Users', 'action' => 'admin_login'));
            }
            } else {
            	$this->Session->setFlash("The username or password you entered is incorrect.");
            	$this->redirect(array('controller' => 'Users', 'action' => 'admin_login'));
            }
            
        }
	}
	
	

  
        
        
	
	 public function admin_logout()
    {
        $this->Auth->logout();
       // $this->Session->setFlash('Logged out.');
        $this->redirect(array('controller'=>'Users','action'=>'admin_login'));
    }
	
    
	
	public function admin_changepass(){
		 if ($this->request->is('post')) {
			 $password =AuthComponent::password($this->data['User']['opass']);
                   $em= $this->Auth->user('email');
			 $pass=$this->User->find('first',array('conditions'=>array('AND'=>array('User.password'=>$password,'User.email' => $em))));
		if($pass){
        if($this->data['User']['password'] != $this->data['User']['cpass'] ){
       $this->Session->setFlash("New password and Confirm password field do not match");
              }
             else {
       $this->User->data['User']['opass'] = $this->data['User']['password'];
        $this->User->id = $pass['User']['id'];
		  if($this->User->exists()){
        $pass= array('User'=>array('password'=>$this->request->data['User']['password']));
		    if($this->User->save($pass)) {
          $this->Session->setFlash("Password updated");
           $this->redirect(array('controller'=>'Users','action' => 'admin_profile'));
            }
           }
          }
		  
             }
			 else{
             $this->Session->setFlash("Your old password did not match.");
               }        
              }
			   
                  }
				  
				  
	public function admin_dashboard(){
	
		$this->loadModel('Advertisement');
    	$this->User->recursive = 0;
    	$x = $this->User->find('all',array(    				
    					'group' => 'User.register_date',
    					'fields' => array('register_date','(count(User.id)) AS graphs'),
						"order"=>"User.id ASC"
    				));
        
    	$this->set("users", $x);
		
        $y = $this->User->find('all');
    	$this->set("use_count", $y);
        $ads = $this->Advertisement->find('all');
    	$this->set("ads", $ads);		

	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() { 
		//echo "<pre>";print_r($this->User->find('all'));die;
		if($this->request->is('post')){
		$keyword = trim($this->request->data['keyword']);
                @$type =  $this->request->data['type'];
		if(!empty($keyword)){
                     $records = $this->User->find('all', array('conditions' => array("OR" => array("User.email LIKE" => "%$keyword%" , "User.username LIKE" => "%$keyword%","User.first_name LIKE" => "%$keyword%","User.post_code LIKE" => "%$keyword%"))));
                }else if(!empty($type)){
                      $records = $this->User->find('all', array('conditions' =>array("User.usertype_id" => $type)));
                }
				
                $this->set("users",$records,$this->paginate());
                $this->set("users_count",$records);
		if(count($records) == 0){
			$this->Session->setFlash("No Record found with this keyword please use another one.");
		}
		
		if(empty($keyword)&&empty($type)){
			  $this->User->recursive = 2;
	          $this->set('users', $this->paginate());
			  $this->Session->setFlash("Please choose some keywords to search..");
		}
	}else{
		$this->User->recursive = 2;

		$this->paginate = array('order' => array('User.id' => 'desc'),'limit' =>10);
		$this->set('users', $this->paginate());
	}
		$this->set('usr_user',$this->User->find('all',array('conditions' =>array("User.usertype_id" =>6,"User.status" =>1))));	
		$this->set('usr_admin',$this->User->find('all',array('conditions' =>array("User.usertype_id" =>5,"User.status" =>1))));	
	
		//$AllUser=$this->User->find('all');
		

	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
        public function admin_verify($id = null){
            
		 $this->User->id = $id;
                if ($this->User->exists()) {
                    $x = $this->User->save(array(
                        'User' => array(
                            'verify' => '1'
                        )
                    ));
                    //echo '<pre>';print_r($x);die;
                    if($x['User']['verify']==1)
                    {
                        $this->redirect(array(
                        'action' => 'index'
                    ));
                    }
                } else {
                    $this->Session->setFlash("This user does not exist");
                    $this->redirect(array(
                        'action' => 'index'
                    ));
                }
       }
       
	public function admin_view($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->set('user', $this->User->read(null, $id));
		$this->set('usr_admin',$this->User->find('all',array('conditions' =>array("User.status" =>1))));	
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
                       
			$this->request->data['User']['usertype_id'] = 6 ;
			$this->request->data['User']['status'] = '1' ;
			$email = $this->request->data['User']['email'] ;
			$x=$this->User->query("SELECT email,username from users where email='".$email."' OR username='".$this->request->data['User']['username']."'");

			if($x){
			   	$this->Session->setFlash(__('This Username/Email id is already exist with us.Please try another'));
				$this->redirect(array('action' => 'add'));
			}
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
	}
	
	
	public function admin_admin() {
		if ($this->request->is('post')) {
			$this->request->data['User']['usertype_id'] = 5 ;
			$this->request->data['User']['status'] = '1' ;
			$email = $this->request->data['User']['email'] ;
			$x=$this->User->query("SELECT email,username from users where email='".$email."' OR username='".$this->request->data['User']['username']."'");
			if($x){
			   	$this->Session->setFlash(__('This Username/Email id is already exist with us.Please try another'));
				$this->redirect(array('action' => 'admin'));
			}
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The new Admin has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The admin could not be saved. Please, try again.'));
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
	public function admin_edit($id = null) { //echo $_SESSION['Auth']['User']['email'];
		$this->User->id = $id;
              
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
		
			 $email = $this->request->data['User']['email'] ;
		
			 $id = $this->request->data['edt_id'] ;

			$x = $this->User->find('first',array('conditions'=>array('User.id'=>$id),'fields'=>"User.email"));
			
			if($x['User']['email']==$this->request->data['User']['email']){
					
					if ($this->User->save($this->request->data)) {
					$this->Session->setFlash(__('The details has been saved'));
					$this->redirect(array('action' => 'index'));
					} 
					else {
					$this->Session->setFlash(__('The details could not be saved. Please, try again.'));
					}
			
			}
		
		else{
		
			$x = $this->User->find('count',array('conditions'=>array('User.email'=>$email)));
			
				if($x<0){
				
				
				$this->Session->setFlash(__('This email id is already exist with us .Please try another'));
				$this->redirect(array('action' => 'index'));
				
				
				}else{
				
				
					if ($this->User->save($this->request->data)) {
					$this->Session->setFlash(__('The details has been saved'));
					$this->redirect(array('action' => 'index'));
				
					}

				}		
		}
		
		

		} 


		else {
			$this->request->data = $this->User->read(null, $id);
		}
		$this->set('use',$this->User->find('first',array('conditions'=>array("User.id"=>$id))));
	}

/**
 * admin_delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	//http://52.32.74.106/users/profile_edit?id=66&first_name=guru&last_name=sharma&gender=Male&profile_image=&post_code=G64
    public function profile_edit()  { 
		$this->loadModel ('Advertisement');
		$this->loadModel('PostShow');
		$this->User->id = $_REQUEST['id'];
		$user_id				=	$_REQUEST['id'];
		$result=  array();
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if (isset($_REQUEST['first_name'])&&!empty($_REQUEST['first_name'])) {
			$this->request->data['User']['first_name']=$_REQUEST['first_name'];
		}
		if (isset($_REQUEST['last_name'])&&!empty($_REQUEST['last_name'])) {
			$this->request->data['User']['last_name']=$_REQUEST['last_name'];
		}					 
		if (isset($_REQUEST['post_code'])&&!empty($_REQUEST['post_code'])){
			$location = $_REQUEST['post_code'];
			if (!empty($location)) {
				$prepAddr = str_replace(' ','+',$location);

				$geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
				$output= json_decode($geocode);

				$lat = $output->results[0]->geometry->location->lat;
				$long = $output->results[0]->geometry->location->lng;
				$this->request->data['User']['lat']=$lat;
				$this->request->data['User']['long']=$long;
			} 	
			$this->request->data['User']['post_code']=$_REQUEST['post_code'];	 	
		}
		if (isset($_REQUEST['gender'])&&!empty($_REQUEST['gender'])){
			$this->request->data['User']['gender']=$_REQUEST['gender'];
		}		
		/*	 if(isset($_REQUEST['registertype'])&&!empty($_REQUEST['registertype'])){
			 $this->request->data['User']['registertype']=$_REQUEST['registertype'];
		}		*/					 
		
		if ($_REQUEST['post_code']  != '')  {
				$posts	=	$this->Advertisement->find ('list',array('conditions'=>array('Advertisement.post_code'=>$_REQUEST['post_code'])));
				if (!empty($posts))  {
					foreach($posts as $key=>$toshowpost)  {
						$this->request->data['PostShow']['user_id'] = $user_id;
						$this->request->data['PostShow']['post_id'] = $key;
						$this->request->data['PostShow']['status'] = 1;
						$this->PostShow->create();
						$this->PostShow->save($this->request->data);
					}			
				}
		}
		
		//$this->request->data['User']['registertype']= 'manual';
				
		$id = $_REQUEST['id'];	
		if ($this->User->save($this->request->data)) {
			if (isset($_REQUEST['profile_image'])&&!empty($_REQUEST['profile_image']))  {
				$ti=date('Y-m-d-g:i:s');
				$dname= $ti.$id."image.png";
				$this->User->saveField('registertype','manual');
				$this->User->saveField('profile_image',$dname);
				@$_REQUEST['profile_image']= str_replace('data:image/png;base64,', '', $_REQUEST['profile_image']);
				$_REQUEST['profile_image'] = str_replace(' ', '+',$_REQUEST['profile_image']);
				$unencodedData=base64_decode($_REQUEST['profile_image']);
				$pth3 = WWW_ROOT.'files' . DS . 'profileimage'. DS .$dname;
				file_put_contents($pth3, $unencodedData);
			}						
			$result['message']= 'The details has been saved';   
		} 	else  {
			$result['message']= 'The details could not be saved. Please, try again.';    
		}
		echo json_encode($result);
		exit();	
	}
	
	public function admin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->User->delete($id,true)) {
			$this->Session->setFlash(__('User deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('User was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
	public function admin_detail($id = null){
	 $this->User->id = $id;
	  $this->set('detail',$this->User->find('first',array('conditions'=>array('User.id'=>$id))));
	   $this->loadModel('UserEducation');
	    $x = $this->UserEducation->find('all',array('conditions'=>array('UserEducation.user_id'=>$id)));
	     $this->set('edu',$x);
		 
	   $this->loadModel('UserWorkSince');
	    $x1 = $this->UserWorkSince->find('all',array('conditions'=>array('UserWorkSince.user_id'=>$id)));
	     $this->set('exp',$x1);
                    }
	
	
	 public function admin_activate($id = null)
    {
        $this->User->id = $id;
        if ($this->User->exists()) {
            $x = $this->User->save(array(
                'User' => array(
                    'status' => '1'
                )
            ));
            $this->Session->setFlash("User activated successfully.");
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            $this->Session->setFlash("Unable to activate user.");
            $this->redirect(array(
                'action' => 'index'
            ));
        }
        
    }
    
    
    public function admin_block($id = null)
    {
        $this->User->id = $id;
        if ($this->User->exists()) {
            $x = $this->User->save(array(
                'User' => array(
                    'status' => '0'
                )
            ));
            $this->Session->setFlash("User blocked successfully.");
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            $this->Session->setFlash("Unable to block user.");
            $this->redirect(array(
                'action' => 'index'
            ));
        }
        
    }
	
	
	
	 public function admin_deleteall($id = null){
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
       
		if(isset($this->request['data']['User'])){	
			foreach ($this->request['data']['User'] as $k) {
				 if($k != 0){
				  $abc[] = $k;
				 }
			}
			@$ab = $abc;
			if(@$ab == null){
					$this->Session->setFlash(__('Please select at least one user.'));		
					$this->redirect(array('action' => 'index'));
			}
			else{
			foreach ($this->request['data']['User'] as $k) {
				$this->User->id = (int) $k;
				if ($this->User->exists()) {
					$this->User->delete();
			  
				}
			}
				$this->Session->setFlash(__('Selected Users were removed.')); 
				$this->redirect(array('action' => 'index'));		  
			} 
        
        }
		$this->redirect(array('action' => 'index'));
    }
	
	
	public function admin_activateall($id = null){
		if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
       
		if(isset($this->request['data']['User'])){	
			foreach ($this->request['data']['User'] as $k) {
				if($k != 0){
				$abc[] = $k;
				}
			}
			@$ab = $abc;
			if(@$ab == null){
		        $this->Session->setFlash(__('Please select at least one user.'));		
				$this->redirect(array('action' => 'index'));
			}else{
				foreach ($this->request['data']['User'] as $k) {
					$this->User->id = (int) $k;
					if ($this->User->exists()) {
						$x = $this->User->save(array(
							'User' => array(
								'status' => "1"
							)
							
						));		           
					}            
				}  
                 $this->Session->setFlash(__('Selected users were activated.'));		
				$this->redirect(array('action' => 'index'));
			}
			
		}	
		$this->redirect(array('action' => 'index'));	
    }
		
		
	public function admin_deactivateall($id = null){ 
		if (!$this->request->is('post')) { 
            throw new MethodNotAllowedException();
        }
      
		if(isset($this->request['data']['User'])){		
			foreach ($this->request['data']['User'] as $k) {
					 if($k != 0){
					  $abc[] = $k;
					 }
				}
				@$ab = $abc;
				if(@$ab == null){
						$this->Session->setFlash(__('Please select at least one user.'));		
						$this->redirect(array('action' => 'index'));
				}else{
					foreach ($this->request['data']['User'] as $k) {
						$this->User->id = (int) $k;
						if ($this->User->exists()) {
							$x = $this->User->save(array(
								'User' => array(
									'status' => "0"
								)
								
							));		           
						}            
					}  
						 $this->Session->setFlash(__('Selected users were deactivated.'));		
						$this->redirect(array('action' => 'index'));
				}
			
		}
	
	}
	
	
	public function admin_profile(){
		$id = $this->Auth->User('id');
		$this->set('profile',$this->User->find('first',array('conditions'=>array('User.id'=>$id))));
		
	}
	
	public function admin_profileedit($id=null) {  //print_r($this->data);exit;
		$id = $this->Auth->User('id');
		$this->set('profile',$this->User->find('first',array('conditions'=>array('User.id'=>$id))));
                 $x= $this->User->find('first',array('conditions'=>array('User.id'=>$id)));
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if(!empty($this->request->data['User']['profile_image']['name'])){
				$im = $this->User->find('first',array('conditions'=>array('User.id'=>$id)));
					if(!empty($im['User']['profile_image'])){
					$old='files/profileimage/'.$im['User']['profile_image'];
					unlink($old);
					}
				//debug($old);exit;
			}
			$one = $this->request->data['User']['profile_image'];
                         if($this->request->data['User']['profile_image']['name']!=""){
              $this->request->data['User']['profile_image'] = $one['name'];  
              }else{
               $this->request->data['User']['profile_image'] = $x['User']['profile_image'];
              }
                        
			//$this->request->data['User']['profile_image']=$one['name'];
			if ($this->User->save($this->request->data)) {
			if ($one['error'] == 0) {
                    $pth = 'files' . DS . 'profileimage' . DS .$one['name'];
                    move_uploaded_file($one['tmp_name'], $pth);                   
                }
				$this->Session->setFlash(__('The Profile has been updated'));
				$this->redirect(array('action' => 'admin_profile'));
			} else {
				$this->Session->setFlash(__('The Profile could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->User->read(null, $id);
			$this->set("userDetail",$this->request->data );
		
		
		}
	}
	public function admin_userprofile($id=null) {
		$this->User->id = $id;
		$this->set('profile',$this->User->find('first',array('conditions'=>array('User.id'=>$id))));
	}
 
  public function forget() {   
        $result=  array();
		
			if(empty($_REQUEST['email']))
			{
				$result['message']='Please provide email address';
			}
			else
			{
				$email=$_REQUEST['email'];
				$fu=$this->User->find('first',array('conditions'=>array('User.email'=>$email)));
				if($fu){
					if($fu['User']['status']=="1"){
						$key = Security::hash(String::uuid(),'sha512',true);
						$hash=sha1($fu['User']['username'].rand(0,100));
                                                $url=FULL_BASE_URL.'admin/users/reset/'.$key.'#'.$hash;
						//$url = Router::url( array('controller'=>'Users','action'=>'reset'), true ).'/'.$key.'#'.$hash;
						$ms="<p>Hello ,<br/>".$fu['User']['first_name']."&nbsp;".$fu['User']['last_name']."<br/><a href=".$url.">Click Here</a> to reset your password.</p><br /> ";
						$fu['User']['token']=$key;
						$this->User->id=$fu['User']['id'];
						if($this->User->saveField('token',$fu['User']['token'])){
								 $l = new CakeEmail();
								 $l->emailFormat('html')->template('signup', 'fancy')->subject('Welcome to Stack Dosh')->to($email)->from('stackdosh@gmail.com')->send($ms);
							$result['message']='Check Your Email To Reset your password';
	                    }
						else{
							
                                                        $result['message']='Error Generating Reset link';
						}
					}
					else{
						
                                                $result['message']='This Account is Blocked. Please Contact to Administrator...';
					}
				}
				else{
					
                                        $result['message']='Email does Not Exist';
				}
			}
		echo json_encode($result);
                exit();
	}       
	 public function admin_forget() {   
        $this->User->recursive=-1;
		if(!empty($this->data))
		{
			if(empty($this->data['User']['email']))
			{
				$this->Session->setFlash('Please Provide Your Email Address that You used to Register with Us');
			}
			else
			{
				$email=$this->data['User']['email'];
				$fu=$this->User->find('first',array('conditions'=>array('User.email'=>$email)));
				if($fu){
					if($fu['User']['status']=="1"){
						$key = Security::hash(String::uuid(),'sha512',true);
						$hash=sha1($fu['User']['username'].rand(0,100));
						$url = Router::url( array('controller'=>'Users','action'=>'reset'), true ).'/'.$key.'#'.$hash;
						$ms="<tr><td>Hello ".$fu['User']['first_name']."&nbsp;".$fu['User']['last_name']."</td></tr><tr><td><a href=".$url.">Click Here</a> to reset your password.</td></tr> ";
						$fu['User']['token']=$key;
						$this->User->id=$fu['User']['id'];
						if($this->User->saveField('token',$fu['User']['token'])){
							 $l = new CakeEmail();
							 $l->emailFormat('html')->template('signup', 'fancy')->subject('Welcome to Stack Dosh')->to($email)->from('stackdosh@gmail.com')->send($ms);
							$this->Session->setFlash(__('Check Your Email To Reset your password', true));
							$this->redirect(array('controller' => 'Users','action' => 'admin_login'));
	                    }
						else{
							$this->Session->setFlash("Error Generating Reset link");
						}
					}
					else{
						$this->Session->setFlash('This Account is Blocked. Please Contact to Administrator...');
					}
				}
				else{
					$this->Session->setFlash('Email does Not Exist');
				}
			}
		}
	}
        public function reset($token=null) {
            Configure::write('debug',2);
		$this->User->recursive=-1;
		if(!empty($token)){
			$u=$this->User->findBytoken($token);
			if($u){
				$this->User->id=$u['User']['id'];
				if(!empty($this->data)){
					if($this->data['User']['password'] != $this->data['User']['password_confirm']){
							$this->Session->setFlash("Both the passwords are not matching...");
							return;
                    }
					$this->User->data=$this->data;
					$this->User->data['User']['username']=$u['User']['username'];
					$new_hash=sha1($u['User']['username'].rand(0,100));//created token
					$this->User->data['User']['token']=$new_hash;
					if($this->User->validates(array('fieldList'=>array('password','password_confirm')))){
						//	if($this->request->data['User']['password'] == $this->request->data['User']['confirm_password'] ){
						if($this->User->save($this->User->data))
						{
							$this->Session->setFlash('Password Has been Updated');
							
						//}
						}
					}
					else{
					$this->set('errors',$this->User->invalidFields());
					}
				}
			}
			else
			{
			/*$this->Session->setFlash('Token Corrupted, Please Retry.the reset link <a style="cursor: pointer; color: rgb(0, 102, 0); text-decoration: none; background: url("http://files.adbrite.com/mb/images/green-double-underline-006600.gif") repeat-x scroll center bottom transparent; margin-bottom: -2px; padding-bottom: 2px;" name="AdBriteInlineAd_work" id="AdBriteInlineAd_work" target="_top">work</a> only for once.');*/
$this->Session->setFlash('you already reset your password');
			}
		}
		else{
		$this->Session->setFlash('Pls try again...');
		//$this->redirect(array('controller' => 'Users','action' => 'admin_login'));
		}
	}
	public function admin_reset($token=null) {
		$this->User->recursive=-1;
		if(!empty($token)){
			$u=$this->User->findBytoken($token);
			if($u){
				$this->User->id=$u['User']['id'];
                                $user_type=$u['User']['usertype_id'];
				if(!empty($this->data)){
					if($this->data['User']['password'] != $this->data['User']['password_confirm']){
							$this->Session->setFlash("Both the passwords are not matching...");
							return;
                    }
					$this->User->data=$this->data;
					$this->User->data['User']['username']=$u['User']['username'];
					$new_hash=sha1($u['User']['username'].rand(0,100));//created token
					$this->User->data['User']['token']=$new_hash;
					if($this->User->validates(array('fieldList'=>array('password','password_confirm')))){
						//	if($this->request->data['User']['password'] == $this->request->data['User']['confirm_password'] ){
						if($this->User->save($this->User->data))
						{
							$this->Session->setFlash('Password Has been Updated');
                                                        if($user_type==5)
                                                        {
                                                            $this->redirect(array('controller'=>'Users','action'=>'admin_login'));
                                                        }
						//}
						}
					}
					else{
					$this->set('errors',$this->User->invalidFields());
					}
				}
			}
			else
			{
			/*$this->Session->setFlash('Token Corrupted, Please Retry.the reset link <a style="cursor: pointer; color: rgb(0, 102, 0); text-decoration: none; background: url("http://files.adbrite.com/mb/images/green-double-underline-006600.gif") repeat-x scroll center bottom transparent; margin-bottom: -2px; padding-bottom: 2px;" name="AdBriteInlineAd_work" id="AdBriteInlineAd_work" target="_top">work</a> only for once.');*/
$this->Session->setFlash('you already reset your password');
			}
		}
		else{
		$this->Session->setFlash('Pls try again...');
		$this->redirect(array('controller' => 'Users','action' => 'admin_login'));
		}
	}
	
	
	///////////////////// Mobile Web Services /////////////////////////
		public function add() {   
			configure::write('debug',0);      
            $this->request->data['User']['first_name']  =  @$_REQUEST['firstname'];
            $this->request->data['User']['last_name']  =  @$_REQUEST['lastname'];
			$this->request->data['User']['location']  =  @$_REQUEST['location'];  
			$date  =  @$_REQUEST['dob'];
			$this->request->data['User']['dob'] = date('Y-m-d ',$date);  
            $this->request->data['User']['gender']  =  @$_REQUEST['gender'];  			
            $this->request->data['User']['usertype_id']  = 6;             
            $this->request->data['User']['registertype'] =  @$_REQUEST['registertype'];	
			
			
			$getEmail = $this->User->findByemail($this->request->data['User']['email']);
			if(!empty($getEmail)){
				 $response = array('status'=>0,'message'=>'Email already exist, please try another email');
				 echo json_encode($response);
				 exit;  
			} 
			
			else {
			
				if(@$_REQUEST['password'] == null){
					  $this->request->data['User']['fbpassword'] =  @$_REQUEST['email'];
				}
				else{
					  $this->request->data['User']['password'] =  @$_REQUEST['password'];
				}
						
				$x = @$this->request->data['User']['username'];
				$e = $this->request->data['User']['email'];
				
				$exist = $this->User->find("first", array("conditions" => array("User.username" => $x)));
				if (empty($exist)) {
					$emailexist =  $this->User->find('first',array('conditions'=>array('AND'=>array('User.email'=>$this->request->data['User']['email'],'User.usertype_id'=>$this->request->data['User']['usertype_id']))));
					if (empty($emailexist)) {
						$this->request->data['User']['status'] = 1;
						$this->request->data['User']['register_date'] = date("Y-m-d");  
						$this->User->create();               
						if ($this->User->save($this->request->data)) {
							$user_id    = $this->User->getLastInsertID();
							 if(@$_REQUEST['image']){  
							$name= $user_id."profileImage.png";
							$this->User->saveField('profile_image',$name);
							@$_REQUEST['profile_image']= str_replace('data:image/png;base64,', '', @$_REQUEST['image']);
							$_REQUEST['profile_image'] = str_replace(' ', '+',$_REQUEST['profile_image']);
							$unencodedData=base64_decode($_REQUEST['profile_image']);
							$pth = WWW_ROOT.'files' . DS . 'profileimage' . DS .$name;
							file_put_contents($pth, $unencodedData);
							 }   
							 if(@$this->request->data['User']['usertype_id'] == 7){
									$response = array('status'=>1,'message'=>'You have successfully registered as owner','user_id'=>$user_id);
							   }else if(@$this->request->data['User']['usertype_id'] == 6){
									$response = array('status'=>1,'message'=>'You have successfully registered as user','user_id'=>$user_id);         
							   }
							 
							 
							 
							 $ms="<p>Hello ,<br/>". @$this->request->data['User']['username']." <br/> You have been registered successfully  with Bad Wolf Syndicate.<br /> ";
							 $l = new CakeEmail('smtp');
							 $l->config('smtp')->emailFormat('html')->template('signup', 'fancy')->subject('Welcome to Bar App')->to($this->request->data['User']['email'])->send($ms);
							 $this->set('smtp_errors', "none");                       
							echo json_encode($response);
							 exit;
						} else {
							 $response = array('status'=>0,'message'=>'Please try again');
							 echo json_encode($response);
							 exit;
						}
					} else {
					if($exist['User']['registertype']=="facebook"){                      
							 $response = array('status'=>3,'message'=>'Email id exist, please try another email','existuserid'=>$exist['User']['id']);
							 $this->set('response',$response);
							 $this->render('ajax','ajax');	
						}else{
							 $response = array('status'=>3,'message'=>'Email id exist, please try another email');
							 echo json_encode($response);
							 exit;		    
						} 
					}
				} 
				else {
					   if($exist['User']['registertype']=="facebook"){
							 $response = array('status'=>2,'message'=>'Username exist, please try another username','existuserid'=>$exist['User']['id']);
							 echo json_encode($response);
							 exit;                       
						}
						else{
								 $response = array('status'=>2,'message'=>'Username exist, please try another username');
							 echo json_encode($response);
							 exit;           
								 
						}					 
				}
			}
    }
    
	//http://pay-us.co/payusadmin/users/register?firstname=guru&lastname=sharma&email=guru@gmail.com&registertype=facebook&gender=male&fb_id=53453&location=newyork&fb_friend=400&image=guru.png&token=34356345&devicetype=Android
    public function register() {      
            $this->request->data['User']['first_name']  =  @$_REQUEST['firstname'];	
			$this->request->data['User']['last_name']  =  @$_REQUEST['lastname'];	
			$this->request->data['User']['email']  			=  @$_REQUEST['email'];  
            $this->request->data['User']['usertype_id']  = 6;      
            $this->request->data['User']['devicetype']  	= isset ($_REQUEST['devicetype']) ? $_REQUEST['devicetype'] : 'Iphone';
			$this->request->data['User']['status']  = 1;      
			$this->request->data['User']['register_date']  = date('Y-m-d'); 			
			$this->request->data['User']['affiliate_code']   = time().rand(1,9999);
            //$this->request->data['User']['registertype'] =  @$_REQUEST['registertype'];		
            $this->request->data['User']['registertype'] =  'facebook';		
			$this->request->data['User']['gender'] =  @$_REQUEST['gender'];	
			if($_REQUEST['registertype']=="facebook")  {			
				$this->request->data['User']['fb_id']  =  $_REQUEST['fb_id'];	
				$getFbIDStatus =  $this->User->find('first',array('conditions'=>array('User.fb_id'=>$_REQUEST['fb_id'])));
				if (empty($getFbIDStatus))  {
					$location = $_REQUEST['location'];
					if(!empty($location)){
						$prepAddr = str_replace(' ','+',$location);

						$geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');

						$output= json_decode($geocode);

						$lat = $output->results[0]->geometry->location->lat;
						$long = $output->results[0]->geometry->location->lng;
						$this->request->data['User']['lat'] =  $lat;	
						$this->request->data['User']['long'] =  $long;	
						 $this->request->data['User']['location'] =  $_REQUEST['location'];	
					} 				
					$this->request->data['User']['password']  =  '';
					$this->request->data['User']['fb_friend'] =  @$_REQUEST['fb_friend'];
					$this->request->data['User']['profile_image'] 	=  @$_REQUEST['image'];
					$this->request->data['User']['token']  	=  @$_REQUEST['token'];	
					$this->User->create();               
					if ($this->User->save($this->request->data)) {
						$user_id    = $this->User->getLastInsertID();
						/*$ms="<p>Hello ,<br/>". @$this->request->data['User']['first_name']." <br/> You have been registered successfully  with Stack dosh.<br /> ";
						 $l = new CakeEmail();
						 $l->emailFormat('html')->template('signup', 'fancy')->subject('Welcome to Stack Dosh')->to($this->request->data['User']['email'])->from('stackdosh@gmail.com')->send($ms);*/
						$userId =  $this->User->find('first',array('conditions'=>array('User.id'=>$user_id)));
						if(isset($userId['User']['post_code']) && $userId['User']['post_code']!=''){
							$postcode = $userId['User']['post_code'];
						} else { 
							$postcode = '';
						}
						if ($postcode ==Null)  {
							$postcode ='';
						}
						$response = array('status'=>1,'message'=>'You have successfully registered as user','user_id'=>$user_id,'post_code'=>$postcode); 
						echo json_encode($response);exit;
					} 
				}
				
				else{
						
						$request['User']['id']  				=  $getFbIDStatus['User']['id'];	
						$request['User']['token']  			=  @$_REQUEST['token'];	
						$request['User']['first_name']  	=  @$_REQUEST['firstname'];	
						$request['User']['last_name']  	=  @$_REQUEST['lastname'];	
						$request['User']['gender']  		=  @$_REQUEST['gender'];	
						$request['User']['fb_friend']  	=  @$_REQUEST['fb_friend'];	
						$request['User']['fb_id']  			=  @$_REQUEST['fb_id'];	
						$this->User->create();               
						$this->User->save($request);	
						
						$userId =  $this->User->find('first',array('conditions'=>array('User.fb_id'=>$_REQUEST['fb_id'])));
						if(isset($userId['User']['post_code']) && $userId['User']['post_code']!=''){
							$postcode = $userId['User']['post_code'];
						} else {
							$postcode = '';
						}
						$response = array('status'=>2,'message'=>'You have already registered with this facebook id','user_id'=>$userId['User']['id'],'post_code'=>$postcode); 
						echo json_encode($response);exit;
				}
			}
			else{
				  $this->request->data['User']['password'] =  @$_REQUEST['password'];
				  $this->request->data['User']['last_name']  =  @$_REQUEST['lastname'];
				  $this->request->data['User']['location']  =  @$_REQUEST['location'];  				  
				  $getEmail = $this->User->findByemail($this->request->data['User']['email']);
					if(!empty($getEmail)){
						 $response = array('status'=>0,'message'=>'Email already exist, please try another email');
						 echo json_encode($response);
						 exit;  
					} 
					else{
						$this->User->create();               
						if ($this->User->save($this->request->data)) {
							$user_id    = $this->User->getLastInsertID();
							if (@$_REQUEST['image'])  {  
								$name= $user_id."profileImage.png";
								$this->User->saveField('profile_image',$name);
								@$_REQUEST['profile_image']	= str_replace('data:image/png;base64,', '', @$_REQUEST['image']);
								$_REQUEST['profile_image'] 	= str_replace(' ', '+',$_REQUEST['profile_image']);
								$unencodedData							= base64_decode($_REQUEST['profile_image']);
								$pth = WWW_ROOT.'files' . DS . 'profileimage' . DS .$name;
								file_put_contents($pth, $unencodedData);
							}   
							/* Send Mail Start*/
							$ms="<p>Hello ,<br/>". @$this->request->data['User']['first_name']." <br/> You have been registered successfully  with Pay Us.<br /> ";
							$l = new CakeEmail();
							$l->emailFormat('html')->template('signup', 'fancy')->subject('Welcome to Pay Us')->to($this->request->data['User']['email'])->from('PayUs@gmail.com')->send($ms);
							/* Send Mail End */ 
							$response = array('status'=>1,'message'=>'You have successfully registered as user','user_id'=>$user_id); 
							echo json_encode($response);
							exit;
						} 
					}
			}
			exit;
			$this->autoRender = false;
    }
   

	
	

	 public function mobileuserlogin($u = null,$p = null){
		//if ($this->request->is('post')) {
		    $this->request->data['User']['username'] =  $_REQUEST['username'];
		    $this->request->data['User']['password'] =  $_REQUEST['password'];              
			$usern = $this->request->data['User']['username'];
			$us = $this->User->find("first", array("conditions" => array('OR'=>array("User.email" => $usern,'User.username'=>$usern))));
                    
            if($us){
		      if($us['UserType']['group_name'] == 'users'){        
                          if ($us['User']['status'] == '1') {                                     
                                   $pass = AuthComponent::password($this->data['User']['password']);             
                                   $user = $this->data['User']['username'];
								   
                                   $isf = $this->User->find("first", array("conditions" =>array('AND' => array("User.password"=>$pass),'OR'=>array("User.email" => $user, "User.username" => $user))));	 
                    if (!$isf) {   
                            $response = array('message'=>"Invalid Password",'status' =>0);
                            $this->set('response',$response);
                            $this->render('ajax','ajax');
                    } else {
                            $resp = "You have successfully logged-In";
                            $type =$isf['User']['usertype_id'];
                            if($type == 6){$ty = "User";}else{$ty = "Owner";}
                            $response = array(
                                'message'=> $resp,
                                'user_type' => $ty,
                                'user_id' => $isf['User']['id'],
								'status' => 1
                            );
                            
                            $this->set('response',$response);
                            $this->render('ajax','ajax');
                    }
                 } else {
                           $response = array('message'=>"Your account has been blocked by Administrator",'status' =>0);
                             $this->set('response',$response);
                            $this->render('ajax','ajax');
                 }
                }else{
                            $response =array('message'=>"Invalid username and password",'status' =>0);
                            $this->set('response',$response);
                            $this->render('ajax','ajax');				
                }
                }else{
                   // die('dcd');
                             $response=array('message'=>"Invalid username and password",'status' =>0);
                             $this->set('response',$response);
                             $this->render('ajax','ajax');
                }
		//}
		
    }
    
    
    
    
    public function mobileownerlogin($u = null,$p = null){
		//if ($this->request->is('post')) {
                    $this->loadModel('Bar');
                    if($_REQUEST['usertype']=='manager')
                    {
                        $username=$_REQUEST['username'];
                        $us = $this->User->find("first", array("conditions" => array("User.username" => $username)));
                    }
                    elseif($_REQUEST['usertype']=='owner')
                    {
                        $email=$_REQUEST['username'];
                        $us = $this->User->find("first", array("conditions" => array("User.email" => $email)));
                        $bar=$this->Bar->find('all',  array('conditions'=>  array('Bar.email'=>$email)));
                    }
		    //$this->request->data['User']['username'] =  $_REQUEST['username'];
		    $this->request->data['User']['password'] =  $_REQUEST['password'];                   
                   // $usern = $this->request->data['User']['username'];
                    		 
                 if($us){
                     
		      if($us['UserType']['group_name'] == 'owner'){        
                          if ($us['User']['status'] == '1') { 
                                   App::Import('Utility', 'Validation'); 
                             $pass = AuthComponent::password($this->data['User']['password']); 
                             
                     $isf = $this->User->find("first", array("conditions" =>array('AND' => array("User.email" => $email,"User.password"=>$pass))));	                 
                     
                     if($isf['User']['verify']==1)
                     {
                         $verify='verified';
                     }
                     else{
                         $verify='not verified';
                     }
                          }
                          else {
                           $response = array('message'=>"Your account has been blocked by Administrator");
                             $this->set('response',$response);
                            $this->render('ajax','ajax');
                 }
                      }
                      elseif($us['UserType']['group_name'] == 'manager'){        
                          if ($us['User']['status'] == '1') { 
                                   App::Import('Utility', 'Validation'); 
                             $pass = AuthComponent::password($this->data['User']['password']); 
                     
                     $isf = $this->User->find("first", array("conditions" =>array('AND' => array("User.username" => $username,"User.password"=>$pass))));	                 
                     $bar=$this->Bar->find('all',  array('conditions'=>  array('Bar.manager_id'=>$isf['User']['id']),'fields'=>'Bar.id'));
                     //echo '<pre>';print_r($bar);exit;
                          } 
                          else {
                           $response = array('message'=>"Your account has been blocked by Administrator");
                             $this->set('response',$response);
                            $this->render('ajax','ajax');
                            }
                      }
                      else{
                            $response =array('message'=>"Invalid username and password");
                            $this->set('response',$response);
                            $this->render('ajax','ajax');				
                          }
                    if (!$isf) {   
                            $response = array('message'=>"Please try again");
                            $this->set('response',$response);
                            $this->render('ajax','ajax');
                    } else {
                            $resp = "You have successfully logged-In as ".$isf['UserType']['group_name'];
                            $type = $isf['User']['usertype_id'];
                            if($us['UserType']['group_name'] == 'manager')
                            {
                                $response = array(
                                'message'=> $resp,
                                'user_type' => $isf['UserType']['group_name'],
                                'user_id'=> $isf['User']['id'],
                                'bar_id'=>$bar[0]['Bar']['id']
                            );
                            }
                            elseif ($us['UserType']['group_name'] == 'owner') {
                                $response = array(
                                'message'=> $resp,
                                'user_type' => $isf['UserType']['group_name'],
                                'user_id'=> $isf['User']['id'],
                                'verify'=> $verify,
                                'bar_name'=>  $bar[0]['Bar']['name'],
                                'bar_address'=>$bar[0]['Bar']['address'],
                                'email'=>$bar[0]['Bar']['email'],
                                'contactname'=>$bar[0]['Bar']['contactname'],
                                'phone'=>$bar[0]['Bar']['phone'],
                                'description'=>$bar[0]['Bar']['description'],
                                'bar_id'=>$bar[0]['Bar']['id'],
                                'image'=> FULL_BASE_URL.$this->webroot."files/barimages/".$bar[0]['Bar']['image'],
                                'latitude'=>$bar[0]['Bar']['latitude'],
                                'longitude'=>$bar[0]['Bar']['longitude'],
                                'recently_updated'=>$bar[0]['Bar']['recent']    
                                
                            );
                            }
                            
                            //debug($response);exit;
                            $this->set('response',$response);
                            $this->render('ajax','ajax');
                    }
                 } 
                
                else{
                             $response=array('message'=>"Invalid username and password");
                             $this->set('response',$response);
                             $this->render('ajax','ajax');
                }
		//}
		
    }
    
 	public function changepass(){         
                $result=  array();
                $password =AuthComponent::password($_REQUEST['opass']);
                $em= $_REQUEST['email'];
                $pass=$this->User->find('first',array('conditions'=>array('OR'=>array('User.username'=>$em,'User.email' => $em))));
                if($pass['User']['password']==$password){
                     if($_REQUEST['password'] != $_REQUEST['cpass'] ){
                           $result['message']="New password and Confirm password field do not match";                          
                    }else {
                         $_REQUEST['opass'] = $_REQUEST['password'];
                         $this->User->id = $pass['User']['id'];
                         if($this->User->exists()){
                                $pass= array('User'=>array('password'=>$_REQUEST['password']));
                            if($this->User->save($pass)) {
                               $result['message']="Password updated";                              
                            }
                         }
                     }
                 }else{
                           $result['message']="Your old password did not match.";                             
                   }        
                    echo json_encode($result);
                    exit;
    }   
    
	public function mobilemanagerlogin($u = null,$p = null){
		//if ($this->request->is('post')) {
		    $this->request->data['User']['username'] =  $_REQUEST['username'];
		    $this->request->data['User']['password'] =  $_REQUEST['password'];                   
                    $usern = $this->request->data['User']['username'];
                    $us = $this->User->find("first", array("conditions" => array("User.username" => $usern)));			
                 if($us){
		      if($us['UserType']['group_name'] == 'Administrators'){        
                          if ($us['User']['status'] == '1') { 
                                   App::Import('Utility', 'Validation'); 
                             $pass = AuthComponent::password($this->data['User']['password']); 
                             $user = $this->data['User']['username'];
                     $isf = $this->User->find("first", array("conditions" =>array('AND' => array("User.username" => $user,"User.password"=>$pass))));	                 
                    if (!$isf) {   
                            $response = array('message'=>"Please try again");
                            $this->set('response',$response);
                            $this->render('ajax','ajax');
                    } else {
                            $resp = "You have successfully logged-In";
                            $type = $isf['User']['usertype_id'];
                            
                            
                            $response = array(
                                'message'=> $resp,
                                'user_type' => 'Administrators',
                                'user_id'=> $isf['User']['id']
                            );
                            //debug($response);exit;
                            $this->set('response',$response);
                            $this->render('ajax','ajax');
                    }
                 } else {
                           $response = array('message'=>"Your account has been blocked by Administrator");
                             $this->set('response',$response);
                            $this->render('ajax','ajax');
                 }
                }else{
                            $response =array('message'=>"Invalid username and password");
                            $this->set('response',$response);
                            $this->render('ajax','ajax');				
                }
                }else{
                             $response=array('message'=>"Invalid username and password");
                             $this->set('response',$response);
                             $this->render('ajax','ajax');
                }
		//}
		
    }
	
	 public function mobileuserforgot($u = null) {
            $this->User->recursive = -1;
            $email = $_REQUEST['username'];
            $fu = $this->User->find('first', array('conditions' => array('User.email' => $email)));
                if ($fu) {
                    if ($fu['User']['status'] == "1") {
                        $key = Security::hash(String::uuid(), 'sha512', true);
                        $hash = sha1($fu['User']['email'] . rand(0, 100));
                        $url = Router::url(array('controller' => 'admin/users', 'action' => 'reset'), true) . '/' . $key . '#' . $hash;
                        $ms = "<p>Hi <br/>".$fu['User']['first_name']."&nbsp;".$fu['User']['last_name'].",<br/><a href=".$url.">Click here</a> to reset your password.</p><br /> ";
                        $fu['User']['token'] = $key;
                        $this->User->id = $fu['User']['id'];
                                if ($this->User->saveField('token', $fu['User']['token'])) {

                                $l = new CakeEmail('smtp');
                                $l->config('smtp')->emailFormat('html')->template('signup', 'fancy')->subject('Reset Your Password')->to($email)->send($ms);
                                $this->set('smtp_errors', "none");
                                
                                $response = array('message'=>"Check Your Email To Reset your password");
                                $this->set('response',$response);
                                $this->render('ajax','ajax');	
                                } else {				
                                $response = array('message'=>"Please try again");
                                $this->set('response',$response);
                                $this->render('ajax','ajax');									
                                }
                        } else {                             
                                $response = array('message'=>"Your account has been blocked by Administrator");
                                $this->set('response',$response);
                                $this->render('ajax','ajax');	
                         }
                } else {				
				 $response = array('message'=>"Email does not exist");
                                $this->set('response',$response);
                                $this->render('ajax','ajax');
					
                }
    }
	

	public function admin_mobilereset($token = null) { 
		$message=array();
        $this->User->recursive = -1;
        if (!empty($token)) {
            $u = $this->User->findBytoken($token);
            if ($u) {
                $this->User->id = $u['User']['id'];
                if (!empty($this->data)) {
                    if ($this->data['User']['password'] != $this->data['User']['password_confirm']) {
                       
						echo "Both the passwords are not matching...";
						exit;
                       
                    }
                    $this->User->data = $this->data;
                    $this->User->data['User']['username'] = $u['User']['username'];
                    $new_hash = sha1($u['User']['username'] . rand(0, 100)); //created token
                    $this->User->data['User']['token'] = $new_hash;
                    if ($this->User->validates(array('fieldList' => array('password', 'password_confirm')))) {
                        //	if($this->request->data['User']['password'] == $this->request->data['User']['confirm_password'] ){
                        if ($this->User->save($this->User->data)) { 
							
							
							//$message['status']="Your password has been updated";
							echo "Your password has been updated successfully";
							exit;
                        }
                    } else {
                        $this->set('errors', $this->User->invalidFields());
                    }
                }
            } else {
				//$message['status']='Token Corrupted, Please Retry.the reset link';
				echo "Token Corrupted, Please Retry.the reset link";
				exit;
			}
        }
    }

        public function mobileuserdetail($id = null) {		
               $user_id = $_REQUEST['user_id']; 
               $this->User->recursive = -1;
               $response = $this->User->find('first',array('conditions'=>array('User.id'=>$user_id)));
               $this->set('response',$response);
               $this->render('ajax','ajax'); 
        }
	
	
	public function mobileuseredit($id = null) { 
		$this->User->id = $_REQUEST['user_id'];              
		if (!$this->User->exists()) {
		                $response ="Invalid User.";
                                $this->set('response',$response);
                                $this->render('ajax','ajax'); 
		}
		if ($this->request->is('post') || $this->request->is('put')) {	
                            if ($this->User->save($this->request->data)) {
                                $response ="Successfully Saved !!!!";
                                $this->set('response',$response);
                                $this->render('ajax','ajax'); 
                            }      
		}
                exit;
	}

	public function getUserDetails() { 
		 
		$id=$_REQUEST['id'];
		$this->User->id=$id;
		if($this->User->exists())
		{    
			$user=$this->User->find('all',
			array('conditions'=>  array(
				'User.id'=>$id
			)));


			foreach ($user as $key => $value) {
					$data=  array(
						'id'=>$value['User']['id'],
						'email'=>$value['User']['email'],
						'profile_image'=>FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$value['User']['profile_image'],
						'contact'=>$value['User']['contact'],
						'home_town'=>$value['User']['home_town'],
						'name'=>$value['User']['first_name'],
						'gender'=>$value['User']['gender'],
						'date of birth'=>$value['User']['dob']
						);
			}
			
			echo json_encode($data);exit;
		}    
	}
	
	
}

?>
