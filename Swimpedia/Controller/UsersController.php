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
 * @var array
 */
	public $components = array ('Session', 'Auth','Paginator');
	public function beforeFilter ()	{
		parent::beforeFilter ();
		$this->Auth->allow(array('admin_admin','add','admin_login','login','confirm','loggedin','profile_search','profile_view','view','admin_forget','admin_reset','forgetpassword','resetpassword','admin_add','mobileuserlogin','reset','forgot','admin_right_answer','admin_wrong_answer'));
		$this->Paginator->settings=array(
              'limit'=>15
		);		
	}
/**
 * logout method
 *
 * @return void  
 */
    public function admin_login(){ 
	 $this->layout = 'default3';
		 if ($this->request->is('post')) {
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
            	} else {
            		$this->Session->write('admin',true);
            		$this->Session->setFlash('Successfuly signed in');
            		$this->redirect(array('controller' => 'Users', 'action' => 'admin_dashboard'));
            	}         
            }else{
            	$this->Session->setFlash("You don't have Administrator authorities.");
            	$this->redirect($this->Auth->redirect("/"));
            }
            
            
        }
	}    
	
	 public function admin_logout()
    {
        $this->Auth->logout();
        $this->Session->setFlash('Logged out.');
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
    	$this->User->recursive = 0;
    	$x = $this->User->find('all',array(    				
    					'group' => 'User.register_date',
    					'fields' => array('register_date','(count(User.id)) AS graphs'),
						"order"=>"User.id ASC"
    				));
        
    	$this->set("users", $x);
		
		$y = $this->User->find('all');
    	$this->set("use_count", $y);
		
		
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$conditions	= array ();
		if	($this->request->is('post'))	{
			$keyword = trim($this->request->data['keyword']);
			if	($keyword != '')	{
				$conditions	=	array(
						"OR" => array(
							"User.email LIKE" => "%$keyword%" , 
							"User.username LIKE" => "%keyword%",
							"User.first_name LIKE" => "%keyword%",
							"User.last_name LIKE" => "%keyword%"
						)
				);
				$this->paginate = array(
					'conditions' => $conditions
				);
				$data = $this->paginate('User');
				$this->set('users',$data);
				if	(empty($data))		{
					$this->Session->setFlash("No Record found with this keyword please use another one.");
				}
			}	else	{
				$this->User->recursive = 0;
				$this->set('users', $this->paginate('User'));
				$this->Session->setFlash("Pls Choose some keywords to search..");
			}
		}	else	{
			$this->User->recursive = 0;
			$user_data = $this->paginate('User') ;
			//pr($user_data);die;
			$this->set('users',$user_data);
		}
		$this->Session->write ('user_csv',$conditions);
	}
	function admin_user_csv()
	{
		$this->loadModel ('User');
		$this->autoRender = false;		
		$cond	=	$this->Session->read ('user_csv');
		//pr($cond);die;
		@$info123 = $this->User->find('all',array ('conditions'=>$cond));
		//echo "<pre>";print_r($info123);die;
		$data = "Sr. No,User Name,Email,\n";
		$name = 'User';
		$filename = "User.csv";
		$i = 1;
		foreach($info123 as $info)
		{ 
			$data .= $i."," ;
			$data .=$info['User']['username'].",";
			$data .=$info['User']['email'].","."\n";
			$i++;
		}
		$fp = fopen('files/UserReport/'.$filename,"w");
		if($fp)
		{
			fwrite($fp,$data);
		 	header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream'); 
			header('Content-Disposition: attachment; filename='.$name.'_Report_'.date("d/m/Y").".csv");
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Pragma: public'); 
			header('Content-Length: ' . filesize('files/UserReport/'.$filename));
			/* ob_clean(); */
			readfile('files/UserReport/'.$filename);
			unlink('files/UserReport/'.$filename); 
			fclose($fp);
			flush();
			exit;	
		}
		
	}
/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->set('user', $this->User->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
                       
			$this->request->data['User']['usertype_id'] = 3 ;
			$this->request->data['User']['status'] = '1' ;
			$this->User->create();
			if ($this->User->save ($this->request->data)) {
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
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The new Admin has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The admin could not be saved. Please, try again.'));
			}
		}
	}

 // public function admin_forget(){
//  	if ($this->request->is('post')) {
//		debug($this->request->data['User']['username']);exit;
//  $this->Session->setFlash(__('tankyou'));
//  
//	}
//  }
/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$data =	$this->User->find ('first',array('conditions'=>array('User.id'=>$id)));
		$this->set ('data',$data);
		//pr($data);die;
		$this->User->id = $id;              
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			//pr($this->request->data);die;
			// Start Image Upload
			if($this->request->data['User']['profile_image']['name']!="") {
				$file_exts = array("jpg", "bmp", "jpeg", "gif", "png");
				$upload_ext = explode(".", $this->request->data['User']["profile_image"]["name"]);
				$upload_exts = $upload_ext['1'];
				if ((($this->request->data['User']["profile_image"]["type"] == "image/gif")
					|| ($this->request->data['User']["profile_image"]["type"] == "image/jpeg")
					|| ($this->request->data['User']["profile_image"]["type"] == "image/png")
					|| ($this->request->data['User']["profile_image"]["type"] == "image/pjpeg"))
					&& ($this->request->data['User']["profile_image"]["size"] < 2000000)
					&& in_array($upload_exts, $file_exts))
				{
					$pth = 'files' . DS . 'profileimage' . DS .time().'_'.$this->request->data['User']["profile_image"]["name"];
					move_uploaded_file($this->request->data['User']["profile_image"]["tmp_name"], $pth); 
					$this->request->data['User']['profile_image'] = time().'_'.$this->request->data['User']['profile_image']['name'];  					
				}
				else
				{
						$this->Session->setFlash(__('Invalid file.'));
						$this->redirect(array('action' => 'index'));
				}
			} 
			else 
			{
				$this->request->data['User']['profile_image'] = $data['User']['profile_image'];
			}
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}			
			// End Image Upload
		} else {
			$this->request->data = $this->User->read(null, $id);
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
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->User->delete()) {
			$this->Session->setFlash(__('User deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('User was not deleted'));
		$this->redirect(array('action' => 'index'));
	}	
	public function admin_detail($id = null) {
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
		$users	= $this->User->find('first',array('conditions'=>array('User.id'=>$id)));
		$status	= $users['User']['status'];
        $this->User->id = $id;
        if ($this->User->exists()) {
			if($status == 1) {
				$x = $this->User->save(array(
					'User' => array(
						'status' => '0'
					)
				));
			} else {
				$x = $this->User->save(array(
					'User' => array(
						'status' => '1'
					)
				));
			}
            $this->Session->setFlash("User Updated successfully.");
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
        if (empty($_POST)) {
            throw new MethodNotAllowedException();
        }
        foreach ($_POST['User'] as $info) {
            $this->User->id = $info;
            if ($this->User->exists()) {
                $this->User->delete();
            }            
        }
		echo "done.";
        $this->Session->setFlash(__('Selected Users were removed.'));
        die;
    }
		
	public function admin_activateall($id = null){
		if (empty($_POST)) {
            throw new MethodNotAllowedException();
        }
        foreach ($_POST['User'] as $info) {
		if($info != ''){
			$this->User->id = $info;
			if ($this->User->exists()) {
				$x = $this->User->save(array(
					'User' => array(
						'status' => "1"
					)
					
				));
	
			$this->Session->setFlash(__('Selected Users Activated.', true));					
			} else {
				$this->Session->setFlash("Unable to Activate Users.");
			}
		}
            
        }
		die;
    }
		
		
	public function admin_deactivateall($id = null){
		if (empty($_POST)) {
            throw new MethodNotAllowedException();
        }
        foreach ($_POST['User'] as $info) {	
		if($info != ''){
			$this->User->id = $info;
			if ($this->User->exists()) {
				$x = $this->User->save(array(
					'User' => array(
						'status' => "0"
					)
				));
			
			$this->Session->setFlash(__('Selected Users Deactivated.', true));			
			} else {
				$this->Session->setFlash("Unable to Deactivate user.");
			}
		}
            
        }
		die;
	}
	
	
	public function admin_profile(){
		$id = $this->Auth->User('id');
		$this->set('profile',$this->User->find('first',array('conditions'=>array('User.id'=>$id))));
		
	}
	
	public function admin_profileedit($id=null) {
		$id = $this->Auth->User('id');
		$this->set('profile',$this->User->find('first',array('conditions'=>array('User.id'=>$id))));
                 $x= $this->User->find('first',array('conditions'=>array('User.id'=>$id)));
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if($this->request->data['User']['profile_image']){
				$im = $this->User->find('first',array('conditions'=>array('User.id'=>$id)));
				$old='files/profileimage/'.time().'_'.$im['User']['profile_image'];
				unlink($old);
				//debug($old);exit;
			}
			$one = $this->request->data['User']['profile_image'];
                         if($this->request->data['User']['profile_image']['name']!=""){
              $this->request->data['User']['profile_image'] = time().'_'.$one['name'];  
              }else{
               $this->request->data['User']['profile_image'] = time().'_'.$x['User']['profile_image'];
              }
                        
			//$this->request->data['User']['profile_image']=$one['name'];
			if ($this->User->save($this->request->data)) {
			if ($one['error'] == 0) {
                    $pth = 'files' . DS . 'profileimage' . DS .time().'_'.$one['name'];
                    move_uploaded_file($one['tmp_name'], $pth);                   
                }
				$this->Session->setFlash(__('The Profile has been updated'));
				$this->redirect(array('action' => 'admin_profile'));
			} else {
				$this->Session->setFlash(__('The Profile could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->User->read(null, $id);
		}
	}
	public function admin_profile_edit($id=null) {
		$id = $this->Auth->User('id');
		$profile = $this->User->find('first',array('conditions'=>array('User.id'=>$id)));
		$this->set('profile',$profile);
		$x= $this->User->find('first',array('conditions'=>array('User.id'=>$id)));
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if($this->request->data['User']['profile_image']){
				$im = $this->User->find('first',array('conditions'=>array('User.id'=>$id)));
				@$old='files/profileimage/'.$im['User']['profile_image'];
				//unlink(@$old);
			}
			$one = $this->request->data['User']['profile_image'];
            if($this->request->data['User']['profile_image']['name']!=""){
              $this->request->data['User']['profile_image'] = time().'_'.$one['name'];  
              }else{
               $this->request->data['User']['profile_image'] = $x['User']['profile_image'];
              }
			//  echo "<pre>";print_r($this->request->data);exit;
			if ($this->User->save($this->request->data)) {
			if ($one['error'] == 0) {
                    $pth = 'files' . DS . 'profileimage' . DS .time().'_'.$one['name'];
                    move_uploaded_file($one['tmp_name'], $pth);                   
                }
				$this->Session->setFlash(__('The Profile has been updated'));
				$this->redirect(array('action' => 'admin_profile'));
			} else {
				$this->Session->setFlash(__('The Profile could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->User->read(null, $id);
		}			
				    
			
		}
	public function admin_userprofile($id=null) {
		$this->User->id = $id;
		$this->set('profile',$this->User->find('first',array('conditions'=>array('User.id'=>$id))));
	}

	 public function admin_forget() {
		$this->layout = 'default3';
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
						$url = Router::url( array('controller'=>'Users','action'=>'admin_reset'), true ).'/'.$key.'#'.$hash;
						$ms="<p>Hello ,<br/>".$fu['User']['first_name']."&nbsp;".$fu['User']['last_name']."<br/><a href=".$url.">Click Here</a> to reset your password.</p><br /> ";
						$fu['User']['token']=$key;
						$this->User->id=$fu['User']['id'];
						if($this->User->saveField('token',$fu['User']['token'])){
							$l = new CakeEmail('smtp');
							$l->config('smtp')->emailFormat('html')->template('signup', 'fancy')->subject('Reset Your Password')->to($fu['User']['email'])->send($ms);
							$this->set('smtp_errors', "none");
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
	public function admin_reset($token=null) {
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
							$this->redirect(array('controller'=>'Users','action'=>'admin_login'));
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
			$this->Session->setFlash('Token Corrupted, Please Retry.the reset link <a style="cursor: pointer; color: rgb(0, 102, 0); text-decoration: none; background: url("http://files.adbrite.com/mb/images/green-double-underline-006600.gif") repeat-x scroll center bottom transparent; margin-bottom: -2px; padding-bottom: 2px;" name="AdBriteInlineAd_work" id="AdBriteInlineAd_work" target="_top">work</a> only for once.');
			}
		}
		else{
		$this->Session->setFlash('Pls try again...');
		$this->redirect(array('controller' => 'Users','action' => 'admin_login'));
		}
	}
	
	
	//////////////////////////////////////////////////////////////////////////// mobile webservices////////////////////////////////////////////////////////
	
	  public function mobileuserlogin($u = null , $p = null) {
     //  Configure::write("debug",2);	    
  // if ($this->request->is('post')) {
//print_r($_REQUEST);
   // echo $u; echo $p; exit;
		    $this->request->data['User']['username'] =  $_REQUEST['username'];
		    $this->request->data['User']['password'] =  $_REQUEST['password'];
            $usern = $this->request->data['User']['username'];
            $us = $this->User->find("first", array("conditions" => array("User.email" => $usern)));			 
            if ($us) {
			         if($us['UserType']['group_name'] == 'users'){        
                if ($us['User']['status'] == '1') { 
                    App::Import('Utility', 'Validation');               
							if (isset($this->data['User']['username']) && Validation::email($this->data['User']['username'])){
								$this->request->data['User']['email'] = $this->data['User']['username'];
								$this->Auth->authenticate['Form']     = array(
									'fields' => array(
										'userModel' => 'User',
										'username' => 'email'
									)
								);							
							} else {
								$this->Auth->authenticate['Form'] = array(
									'fields' => array(
										'userModel' => 'User',
										'username' => 'username'
									)
								); 							 
							}

                    if (!$this->Auth->login()) {
                        echo "0/Please try again";
                        exit;
                    } else {
                        $uid = $this->Auth->User("id");
                        $un = $this->Auth->User("username");
                        echo "1/ You have successfully loggedin/".$uid;
                        exit;
                    }
                } else {
                    echo "2/Your account has been blocked by Administrator";
                    exit;
                }
            } else {
                echo "0/Invalid username and password";
                exit;
            }
			}else{
			    echo "0/Invalid username and password";
                exit;
			}
   //   }
    }
	
	
	public function add($u=null,$e=null,$p=null,$r=null,$d=null) {
     //   if ($this->request->is('post')) 
	 //print_r($_REQUEST); exit;
		    $this->request->data['User']['username'] = $_REQUEST['username'];
			$this->request->data['User']['email']  =  $_REQUEST['email'];
			if($_REQUEST['password'] == null){
			      $this->request->data['User']['fbpassword'] =  base64encode($_REQUEST['email']);
			}else{
			      $this->request->data['User']['password'] =  $_REQUEST['password'];
			}
			$this->request->data['User']['registertype'] =  $_REQUEST['registertype'];
			$this->request->data['User']['devicetype'] =  $_REQUEST['devicetype'];
		    
            $x = $this->request->data['User']['username'];
            $e = $this->request->data['User']['email'];
			//  $e = $this->request->data['User']['username'];
            $exist = $this->User->find("first", array("conditions" => array("User.username" => $x)));
            if (empty($exist)) {
                $emailexist = $this->User->find("first", array("conditions" => array("User.email" => $e)));
                if (empty($emailexist)) {
                    $this->request->data['User']['status'] = 1;
                    $this->request->data['User']['usertype_id'] = '6';
                    $this->request->data['User']['register_date'] = date("d/m/Y");
                    $this->User->create();
                    if ($this->User->save($this->request->data)) {
                     $user_id    = $this->User->getLastInsertID();
//                $id= base64_encode($user_id);
                //$url  = "http://example.com/Users/confirmation/".$id;                
                        echo '1/You have successfully registered/'.$user_id;
//                 $admin = $this->User->find("all",array("conditions"=>array("User.user_group !"=>3)));               
//                 $mailformat = "A new prospect has been registered on Katann.Please login admin end for providing better services to him";
//                 $subject    = 'A new prospect registered on Katann.';
//                    foreach($admin as $adm){
//                        $to = $adm['User']['email'];
//                       $l = new CakeEmail('smtp');
//                       $l->config('smtp')->emailFormat('html')->template('signup', 'fancy')->subject($subject)->to($email)->send($mailformat);                              
//                       $this->set('smtp_errors', "none");
//                    }
                        exit;
                    } else {
                        echo '0/Please try again';
                        exit;
                    }
                } else {
				    if($exist['User']['registertype']=="facebook"){
                        echo "3/Email id exist, please try another email/".$exist['User']['id'];
					}else{
					      echo "3/Email id exist, please try another email";
					}
                    exit;
                }
            } else {
			       if($exist['User']['registertype']=="facebook"){
                            echo "2/Username exist, please try another username/".$exist['User']['id'];
				    }else{
                             echo "2/Username exist, please try another username";
                     }					 
                exit;
            }
     //   }
    }
	
	
	
	
	/*    public function forgot($u = null) {
//        Configure::write('debug', 2);
        $this->User->recursive = -1;
        if (!empty($this->data)) { 
            if (empty($_REQUEST['username'])) {
                echo "0/Please enter your email";
                exit;
            } else { 
                $email = $_REQUEST['username'];
                $fu = $this->User->find('first', array('conditions' => array('User.email' => $email)));
                if ($fu) {
                    if ($fu['User']['status'] == "1") {
                        $key = Security::hash(String::uuid(), 'sha512', true);
                        $hash = sha1($fu['User']['email'] . rand(0, 100));
                        $url = Router::url(array('controller' => 'Users', 'action' => 'reset'), true) . '/' . $key . '#' . $hash;
                        $ms = "<p>Click the Link below to reset your password.</p><br /> " . $url;
                        $fu['User']['token'] = $key;
                        $this->User->id = $fu['User']['id'];
                        if ($this->User->saveField('token', $fu['User']['token'])) {
                            $l = new CakeEmail('smtp');
                            $l->config('smtp')->emailFormat('html')->template('signup', 'fancy')->subject('Reset Your Password')->to($email)->send($ms);
                            $this->set('smtp_errors', "none");
                            echo "1/Check Your Email To Reset your password";
                            exit;
                        } else {
                            echo "0/Please try again";
                            exit;
                        }
                    } else {
                        echo "2/Your account has been blocked by Administrator";
                        exit;
                    }
                } else {
                    echo "0/Email does not exist.";
                    exit;
                }
            }
        }
    }*/
	
	
	 public function forgot($u = null) {
       //  Configure::write('debug', 2);
        $this->User->recursive = -1;
                $email = $_REQUEST['username'];
                $fu = $this->User->find('first', array('conditions' => array('User.email' => $email)));
                if ($fu) {
                    if ($fu['User']['status'] == "1") {
                        $key = Security::hash(String::uuid(), 'sha512', true);
                        $hash = sha1($fu['User']['email'] . rand(0, 100));
                        $url = Router::url(array('controller' => 'Users', 'action' => 'reset'), true) . '/' . $key . '#' . $hash;
                        $ms = "<p>Hi <br/>".$fu['User']['first_name']."&nbsp;".$fu['User']['last_name'].",<br/><a href=".$url.">Click here</a> to reset your password.</p><br /> ";
                        $fu['User']['token'] = $key;
                        $this->User->id = $fu['User']['id'];
                        if ($this->User->saveField('token', $fu['User']['token'])) {
						    if($fu['User']['registertype']=="facebook"){
							      echo "1/You are not authorised to reset password , because you have registered with facebook account.";							
                                  exit;
							}else{
								$l = new CakeEmail('smtp');
								$l->config('smtp')->emailFormat('html')->template('signup', 'fancy')->subject('Reset Your Password')->to($email)->send($ms);
								$this->set('smtp_errors', "none");
								echo "1/Check Your Email To Reset your password";							
								exit;
							}
                        } else {
                            echo "0/Please try again";
                            exit;
                        }
                    } else {
                        echo "2/Your account has been blocked by Administrator";
                        exit;
                    }
                } else {
                    echo "0/Email does not exist.";
                    exit;
                }
    }
	
	
	
	public function reset($token = null) {
        $this->User->recursive = -1;
        if (!empty($token)) {
            $u = $this->User->findBytoken($token);
            if ($u) {
                $this->User->id = $u['User']['id'];
                if (!empty($this->data)) {
                    if ($this->data['User']['password'] != $this->data['User']['password_confirm']) {
                        $this->Session->setFlash("Both the passwords are not matching...");
                        return;
                    }
                    $this->User->data = $this->data;
                    $this->User->data['User']['username'] = $u['User']['username'];
                    $new_hash = sha1($u['User']['username'] . rand(0, 100)); //created token
                    $this->User->data['User']['token'] = $new_hash;
                    if ($this->User->validates(array('fieldList' => array('password', 'password_confirm')))) {
                        //	if($this->request->data['User']['password'] == $this->request->data['User']['confirm_password'] ){
                        if ($this->User->save($this->User->data)) {
                            echo "Your password has been updated";
                            exit;
                        }
                    } else {
                        $this->set('errors', $this->User->invalidFields());
                    }
                }
            } else {
                $this->Session->setFlash('Token Corrupted, Please Retry.the reset link <a style="cursor: pointer; color: rgb(0, 102, 0); text-decoration: none; background: url("http://files.adbrite.com/mb/images/green-double-underline-006600.gif") repeat-x scroll center bottom transparent; margin-bottom: -2px; padding-bottom: 2px;" name="AdBriteInlineAd_work" id="AdBriteInlineAd_work" target="_top">work</a> only for once.');
            }
        }
    }
	
	public function admin_right_answer ($id = Null,$topicId = Null) {
		$this->loadModel ('QuestionAnswer');		
		$data  =  $this->QuestionAnswer->find (
			'all',array(
				'contain'=>array(
					'User','Topic','Question'=>array(
						'Answer'
					)
				),
				'conditions'=>array(
					'QuestionAnswer.user_id' =>$id,
					'QuestionAnswer.topic_id' =>$topicId,
					'QuestionAnswer.answer_status' =>1	
				)
			)
		);
		$this->set ('data',$data);
		//pr($data);die;
	}	
	public function admin_wrong_answer ($id = Null,$topicId =null) {
		$this->loadModel ('QuestionAnswer');		
		$data  =  $this->QuestionAnswer->find (
			'all',array(
				'contain'=>array(
					'User','Topic','Question'=>array(
						'Answer'
					)
				),
				'conditions'=>array(
					'QuestionAnswer.user_id' =>$id,
					'QuestionAnswer.topic_id' =>$topicId,
					'QuestionAnswer.answer_status' =>0	
				)
			)
		);
		$this->set ('data',$data);
		//pr($data);die;
	}	
	public function admin_check_answer ($id = Null) {
		$this->loadModel ('Topic');
		$this->Topic->virtualFields = array(
			'wrong_answer' => 'SELECT count(id) FROM question_answers where Topic.id =question_answers.topic_id and question_answers.answer_status = 0 and question_answers.user_id ='.$id.'',
			'right_answer' => 'SELECT count(id) FROM question_answers where Topic.id =question_answers.topic_id and question_answers.answer_status = 1 and question_answers.skip_status = 0 and question_answers.user_id ='.$id.'',
			'total' => 'SELECT count(id) FROM questions where Topic.id =questions.topic_id',
			'skip_answer' => 'SELECT count(id) FROM question_answers where Topic.id =question_answers.topic_id and question_answers.answer_status = 1 and question_answers.skip_status = 1 and question_answers.user_id ='.$id.''
			);
		$this->set ('user_id',$id);
		if	($this->request->is('post'))	{
			$keyword = trim($this->request->data['keyword']);
			if	($keyword != '')	{
				$this->paginate = array(
					'conditions' => array(
							"OR" => array(
								"User.email LIKE" => "%$keyword%" , 
								"User.username LIKE" => "%keyword%",
								"User.first_name LIKE" => "%keyword%",
								"User.last_name LIKE" => "%keyword%"
							)
					)
				);
				$data = $this->paginate('User');
				$this->set('users',$data);
				if	(empty($data))		{
					$this->Session->setFlash("No Record found with this keyword please use another one.");
				}
			}	else	{
				$this->User->recursive = 0;
				$this->set('users', $this->paginate('User'));
				$this->Session->setFlash("Pls Choose some keywords to search..");
			}
		}	else	{
			$user_data = $this->paginate('Topic') ;
			//pr($user_data);die;
			$this->set('users',$user_data);
		}
		//pr($data);die;
	}
	function admin_download_csv () 
	{
		$this->loadModel ('Topic');
		$data	=	$this->Topic->find ('all');
		Configure::write('debug',0);
		App::import('Vendor', 'tcpdf',array('file' => 'tcpdf/tcpdf.php'));
		$time = time();
		$tcpdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$tcpdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$tcpdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$tcpdf->setPrintFooter(false);
		$tcpdf->setPrintHeader(false);
		$tcpdf->SetAutoPageBreak(true);
		$tcpdf->AddPage();
		$image = 'http://dev414.trigma.us/N-110BB/app/webroot/img/profile_image/1epgUO0.jpg';
		foreach ($data as $info) 
		{
			$html  .=  '<b>'.$info['Topic']['name'].'</b><img height="100" width="300" src="'.$image.'">';
		}
		$bMargin = $tcpdf->getBreakMargin();
		$auto_page_break = $tcpdf->getAutoPageBreak();
		$tcpdf->SetAutoPageBreak(false);
		$tcpdf->SetAutoPageBreak($auto_page_break, $bMargin);
		$tcpdf->setPageMark();	
		$tcpdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$tcpdf->SetHeaderMargin(0);
		$tcpdf->SetFooterMargin(0);
		$tcpdf->setImageScale(PDF_IMAGE_SCALE_RATIO); 
		$tcpdf->writeHTML($html, true, false, true, false, '');	
		$name = time ();
		$pdfName = $name.'.pdf';
		$pdf = $tcpdf->Output('../webroot/voucher_pdf/'.$pdfName, 'F');
		$file = HTTP_ROOT.'pdf/label/'.$pdfName;  // path of pdf
		echo  $pdfName;die;
	}
}
