<?php
#Project : N-162
class WebsController extends AppController 
{
	public $uses	=	array('About','Faq','Group','GroupUser','PostInspirede','Post','PostComment','PostPhoto','PostBeforeAfter','PostText','PostQuote','SendFeedback','TermService','User');
	public function beforeFilter() 
	{
		parent::beforeFilter();
		$this->Auth->allow(array('signup','login','forgot','admin_reset','changepass','myProfile','profile_edit','all_users','add_follower','user_follower','user_following','faqs','terms_services','about_us','send_feedback','customerFeedback','groups_users','groups','group_joined_leave','group_description','photo_post','before_after_post','text_post','quote_post','browse_post','post_inspiredes','post_comments','comments_of_post','comment_remove'));
	}	
	//http://dev414.trigma.us/N-162/Webservices/signup?name=gurudutt1&email=gurudutt.sharma@trigma.in&usertype_id=2&register_type=manual&password=123456&contact=123&fb_id=12134
	public function signup() 
	{
		$data['User']['name']				=	isset ($_REQUEST['name']) ? $_REQUEST['name'] : '';
		$data['User']['profile_image']	=	isset ($_REQUEST['image']) ? $_REQUEST['image'] : '';
		$data['User']['email']				=	isset ($_REQUEST['email']) ? $_REQUEST['email'] : '';
		$data['User']['contact']			=	isset ($_REQUEST['contact']) ? $_REQUEST['contact'] : '';
		$data['User']['registertype']		=	isset ($_REQUEST['register_type']) ? $_REQUEST['register_type'] : '';		
		$data['User']['status'] 				=	1;
		$data['User']['register_date'] 	= 	date ("d-M-Y"); 
		$data['User']['usertype_id']  	=  2;
		
		if ($_REQUEST['register_type']	==	"facebook")  {				
			if (!isset($_REQUEST['fb_id']))  {
				$response						= 	array('success'=>0,'message'=>'Facebook id is required.');
				echo json_encode($response);die;
			}
			
			$emailexist1 						= 	$this->User->find('first',array('conditions'=>array('AND'=>array('User.email'=>$data['User']['email']))));
		
			if (empty($emailexist1))  {
				$data['User']['fb_id']  		=  $_REQUEST['fb_id'];		
				$getFbIDStatus 				=  $this->User->find('first',array('conditions'=>array('User.fb_id'=>$_REQUEST['fb_id'])));
			
				if (empty($getFbIDStatus))  {
					$fbexist 					= 	$this->User->find('first',array('conditions'=>array('AND'=>array('User.fb_id'=>$_REQUEST['fb_id']))));
					
					if (empty($fbexist))  {						
						$this->User->create();               
						
						if ($this->User->save($data)) {
							$user_id  			= 	$this->User->getLastInsertID();
							$this->User->query ("update users set password= '' where id = '".$user_id."'");
							$response			= 	array ('success'=>1,'message'=>'User Register Successfully with facebook');
							$response['data']		=	array ('user_id'=>$user_id);
							echo json_encode($response);die;
						}  else  {
							$response			= 	array('success'=>0,'message'=>'Please try again');
							echo json_encode($response);die;
						}
					}  else  {
						$response				= 	array('success'=>3,'message'=>'Facebook id exist, please try another email');
						echo json_encode($response);die;
					} 			
				}  else  {
					$response 				= 	array('success'=>3,'message'=>'facebook id  already exist, please try another user');
					echo json_encode($response);die;
				}
			}  else {
				$response						= 	array('success'=>3,'message'=>'Email id exist, please try another email');
				echo json_encode($response);die;
			}
		}  	else if($_REQUEST['register_type']== "manual")  {					
			$data['User']['password']  	=  AuthComponent::password($_REQUEST['password']);
			$emailexist 						= 	$this->User->find('first',array('conditions'=>array('AND'=>array('User.email'=>$data['User']['email']))));
			
			if (empty($emailexist))  {
				$this->User->create();            
				
				if ($this->User->save($data)) {
					$user_id    		=  $this->User->getLastInsertID();							
					$usertype_id		=	isset ($isf['User']['usertype_id']) ? $isf['User']['usertype_id'] : '';	
					
					$response			= 	array ('success'=>1,'message'=>'User Register Successfully');
					$response['data']		=	array (
						'user_id'		=> $user_id,
						'usertype_id'	=> 2
					);
					echo json_encode($response);die;
				}  else  {
					$response			= 	array('success'=>0,'message'=>'Please try again');
					echo json_encode($response);die;
				}
			}  else  {
				$response						= 	array('success'=>3,'message'=>'Email id exist, please try another email');
				echo json_encode($response);die;
			} 				
		}
		exit;					
	}
	
	//http://dev414.trigma.us/N-162/Webservices/login?email=gurudutt.sharma@trigma.in&password=123456&usertype_id=2 
	public function login ($u = null,$p = null)	
	{
		$usern 				= 	$_REQUEST['email'];
		$us 					= 	$this->User->find("first", array("conditions" => array("User.email"=>$usern)));
		
		if (empty($us))  {
			$response 	=	array('message'=>"Invalid username and password",'success' =>0);
			echo json_encode($response);exit; 				
		}
		
		if ($us['User']['status'] != '1') { 
			$response 	=	array('message'=>"Your account has been blocked by Administrator",'success' =>0);
			echo json_encode($response);exit; 
		}
		
		App::Import('Utility', 'Validation'); 
		$pass 				=	AuthComponent::password($_REQUEST['password']); 
		$isf 					= 	$this->User->find(
			'first', array(
				'conditions' 	=> array(
					'AND' 		=> array(
						'OR'=>array(
							'User.email' 		=> $usern,
						), 
						'User.password' => $pass
					)
				)
			)
		);
		
		if (!$isf) {
			$response = 	array ('success'=>0,'message'=>'invalid Password');
			echo json_encode($response);exit; 					
		} 
		
		$resp 				= 	"You have successfully logged-In";
		$type 				=	$isf['User']['usertype_id'];						
			
		$user_id			=	!empty ($isf['User']['id']) ? $isf['User']['id'] : '';
		$name				=	!empty ($isf['User']['name']) ? $isf['User']['name'] : '';
		$email				=	!empty ($isf['User']['email']) ? $isf['User']['email'] : '';
		$contact			=	!empty ($isf['User']['contact']) ? $isf['User']['contact'] : '';
		$profile_image	=	!empty ($isf['User']['profile_image']) ? FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$isf['User']['profile_image'] : '';
		
		if ($isf['User']['registertype'] == 'facebook')  {
			$profile_image = $value['User']['profile_image'];
		}
	
		$response				=	array ('success'=>1,'message'=>$resp);
		$response['data']	=	array (
			'user_id' 			=> $user_id,
			'email'				=> $email,
			'contact'			=> $contact,
			'profile_image'	=> $profile_image,
		);
		echo json_encode($response);exit; 
	}	
	
	//http://dev414.trigma.us/N-162/Webservices/forgot?email=gurudutt.sharma@trigma.in
	public function forgot () 
	{	
		$email 			= 	$_REQUEST['email'];
		$fu 				= 	$this->User->find('first', array('conditions' => array('User.email' => $email)));
		if (empty($fu)) {  
			$response	= array('success'=>0,'message'=>"Email does not exist");
			echo json_encode($response);exit;		
		}
	
		if ($fu['User']['status'] != "1") {
			$response	= array('success'=>0,'message'=>"Your account has been blocked by Administrator");
			echo json_encode($response);exit;
		}
		
		$name = $fu['User']['email'];
		if  ($fu['User']['name'] != '')  {
			$name 		= $fu['User']['name'];
		} 
		
		$key 			=	Security::hash(String::uuid(), 'sha512', true);
		$hash 			= 	sha1($fu['User']['email'] . rand(0, 100));
		$url 				= 	Router::url(array('controller' => 'admin/users', 'action' => 'reset'), true) . '/' . $key . '#' . $hash;
		$ms 				= 	"<p>Hi".' '.$name.",<br/><a href=".$url.">Click here</a> to reset your password.</p><br /> ";
		$fu['User']['token'] 		= $key;
		$this->User->id 		= $fu['User']['id'];
		if ($this->User->saveField('token', $fu['User']['token'])) {
			$l 				= new CakeEmail();
			$l->emailFormat ('html')->template ('forgot', 'fancy')->subject ('Reset Your Password')->to ($email)->from ('gurudutt.sharma@trigma.in')->send($ms);
			$response	= array('success'=>1,'message'=>"Check Your Email To Reset your password");
			echo json_encode($response);
			exit;
		} 	else {				
			$response = array('success'=>0,'message'=>"Please try again");
			echo json_encode($response);
			exit;                                
		}		
	}
	
	//http://dev414.trigma.us/N-110BB/Webservices/reset?email=gurudutt.sharma@trigma.in
	public function admin_reset($token = null) 
	{
		$this->User->recursive = -1;
		
		if (!empty($token)) {
			$u = $this->User->findBytoken($token);
			if ($u) {
				$this->User->id = $u['User']['id'];
				if (!empty($this->data)) {
					if ($this->data['User']['password'] != '') {
						if ($this->data['User']['password_confirm'] != '') {
							if ($this->data['User']['password'] != $this->data['User']['password_confirm']) {
								$this->Session->setFlash("Both the passwords are not matching...");
								return;
							}
							$this->User->data = $this->data;
							$this->User->data['User']['username'] = $u['User']['username'];
							$this->User->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
							$new_hash = sha1($u['User']['username'] . rand(0, 100)); //created token
							$this->User->data['User']['token'] = $new_hash;
							if ($this->User->validates(array('fieldList' => array('password', 'password_confirm')))) {
									// if($this->request->data['User']['password'] == $this->request->data['User']['confirm_password'] ){
								if ($this->User->save($this->User->data)) {
									echo "Your password has been updated";
									exit;
								}
							} else {
								$this->set('errors', $this->User->invalidFields());
							}
						} else {
							$this->Session->setFlash("Both fields are required...");
							return;
						}
					} 
						$this->Session->setFlash("Both fields are required...");
						return;
				}
			} 
			$this->Session->setFlash('Token Corrupted, Please Retry.the reset link <a style="cursor: pointer; color: rgb(0, 102, 0); text-decoration: none; background: url("http://files.adbrite.com/mb/images/green-double-underline-006600.gif") repeat-x scroll center bottom transparent; margin-bottom: -2px; padding-bottom: 2px;" name="AdBriteInlineAd_work" id="AdBriteInlineAd_work" target="_top">work</a> only for once.');
		}
	}

	//http://dev414.trigma.us/N-162/webservices/changepass?id=28&opass=123456&cpass=gurudutt&newpass=gurudutt
	public function changepass () 
	{         
		$password 	=	AuthComponent::password($_REQUEST['opass']);
		$em				=	$_REQUEST['id'];
		$pass			=	$this->User->find('first',array('conditions'=>array('User.id' => $em)));

		if (!empty($pass))  {
			if($pass['User']['password']==$password) {
				if($_REQUEST['newpass'] != $_REQUEST['cpass'] ) {
					$result 	=	array('message'=>"New password and Confirm password field do not match",'success' =>0);
					echo json_encode($result);  exit;
				}  else  {
					$_REQUEST['opass'] 	= $_REQUEST['newpass'];
					$this->User->id 			= $pass['User']['id'];
					if($this->User->exists())	{
						$pass	= array('User'=>array ('password'=>AuthComponent::password($_REQUEST['newpass'])));
						if($this->User->save($pass)) {
							$result 				=	array ('message'=>"Password updated",'success' =>1);
							$result['data'] 	=	array ('user_id'=>$em);
							echo json_encode ($result);  exit;
						}
					}
				}
			}	else {
				$result 	=	array('message'=>"Your old password did not match.",'success' =>0);
				echo json_encode($result);  exit;
			}        
		}  
		$result 	=	array('message'=>"User does not exist.",'success' =>0);
		echo json_encode($result);  exit;
	}
	
	//http://dev414.trigma.us/N-162/webservices/myProfile?id=207
	public function myProfile() 
	{  
		$id	=	$_REQUEST['id'];
		$this->User->id	=	$id;
		if($this->User->exists())  {    
			$this->User->virtualFields = array(
				'followers'	=>  'SELECT count(*) FROM user_followers WHERE User.id=user_followers.user_id ',
				'followings'	=>  'SELECT count(*) FROM user_followers WHERE User.id=user_followers.follower_id ',
			);
			$user	=	$this->User->find('all',array('conditions'=>  array('User.id'=>$id)));
			
			foreach ($user as $key => $isf) {
				
				if (isset($isf['User']['id']))					{  $user_id		=	$isf['User']['id']; 					}  	else  {	$user_id	=	''; 		}
				if (isset($isf['User']['usertype_id'])) 		{  $usertype_id	=	$isf['User']['usertype_id'];	} 	else  {  	$usertype_id	=	''; 	}
				if (isset($isf['User']['name'])) 				{  $name			=	$isf['User']['name']; 			} 	else  {  	$name	=	''; 			}
				if (isset($isf['User']['email'])) 				{  $email			=	$isf['User']['email']; 			} 	else  {  	$email	=	''; 			}
				if (isset($isf['User']['contact'])) 			{  $contact		=	$isf['User']['contact']; 			} 	else	{  	$contact	=	''; 		}
				if (isset($isf['User']['username'])) 		{  $username		=	$isf['User']['username']; 		} 	else	{  	$username	=	''; 	}
				if (isset($isf['User']['starting_wt'])) 		{  $starting_wt	=	$isf['User']['starting_wt']; 	} 	else	{  	$starting_wt	=	''; 	}
				if (isset($isf['User']['current_wt'])) 		{  $current_wt	=	$isf['User']['current_wt']; 	} 	else	{  	$current_wt	=	''; 	}
				if (isset($isf['User']['goal_wt'])) 			{  $goal_wt		=	$isf['User']['goal_wt']; 			} 	else	{  	$goal_wt	=	''; 		}	
				if (isset($isf['User']['birthday'])) 			{  $birthday		=	$isf['User']['birthday']; 		} 	else	{  	$birthday	=	''; 		}
				if (isset($isf['User']['height'])) 				{  $height			=	$isf['User']['height']; 			} 	else	{  	$height	=	''; 			}
				if (isset($isf['User']['gender'])) 			{  $gender			=	$isf['User']['gender']; 			} 	else	{  	$gender	=	''; 		}
				if (isset($isf['User']['about'])) 				{  $about			=	$isf['User']['about']; 			} 	else	{  	$about	=	''; 			}
				if ($isf['User']['followers'] != 0) 			{  $followers		=	$isf['User']['followers']; 		} 	else	{  	$followers	=	0; 	}
				if ($isf['User']['followings'] != 0) 			{  $followings		=	$isf['User']['followings']; 		} 	else	{  	$followings	=	0; }				
				if (isset($isf['User']['profile_image'])) 	{  $image			=	FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$isf['User']['profile_image'];	} 	else  	{  	$image	=	''; 	}
				
				$response		= 	array('success'=>1,'message'=>'Successfully Register.');
				$response['data'] = array (
					'user_id' 			=> $user_id,
					'email'				=> $email,
					'name'				=> $name,
					'username'		=> $username,
					'profile_image'	=> $image,
					'birthday'			=> $birthday,
					'height'				=> $height,
					'gender'				=> $gender,
					'followers'			=> $followers,
					'followings'			=> $followings,
					'inspired'			=> 0,
					'start_weight'		=> $starting_wt,
					'current_weight'	=> $current_wt,
					'goal_weight'		=>$goal_wt,
					'contact'			=> $contact,
					'usertype_id'		=> $usertype_id,							
					'about'				=> $about							
				);
			}        
			echo json_encode($response);exit;
		} 
		$response = array('success'=>0,'message'=>'Invalid User');
		echo json_encode($response);exit;
	}
	
	//http://dev414.trigma.us/N-162/webservices/profile_edit?id=4&profile_image=php.png&current_wt=54&goal_wt=234&starting_wt=45&gender=Male&height=34&birthday=12-02-1991&username=guru
	public function profile_edit() 
	{
		$this->User->id 	= $_REQUEST['id'];
		$id = $_REQUEST['id'];

		if (!$this->User->exists())  {
			//throw new NotFoundException(__('Invalid user'));
			$response			= 	array('success'=>0,'message'=>'User not exist.');
			echo json_encode($response);exit;
		}

		if (!empty($_REQUEST['username']))  {   
			$this->request->data['User']['username']=$_REQUEST['username'];
		}  else  {
			$this->request->data['User']['username']='';
		}		
		if (!empty($_REQUEST['birthday']))  {
			$this->request->data['User']['birthday']=$_REQUEST['birthday'];
		}  else  {
			$this->request->data['User']['birthday']='';
		}
		if (!empty($_REQUEST['height']))  {
			$this->request->data['User']['height']=$_REQUEST['height'];
		}  else  {
			$this->request->data['User']['height']='';
		}
		if (!empty($_REQUEST['gender']))  {
			$this->request->data['User']['gender']=$_REQUEST['gender'];
		}  else  {
			$this->request->data['User']['gender']='';
		}
		if (!empty($_REQUEST['about']))  {
			$this->request->data['User']['about']=$_REQUEST['about'];
		}  else  {
			$this->request->data['User']['about']='';
		}
		if (!empty($_REQUEST['profile_image']))  {
			$this->request->data['User']['profile_image']=$_REQUEST['profile_image'];
		}  

		if (!empty($_REQUEST['starting_wt']))  {
			$this->request->data['User']['starting_wt']=$_REQUEST['starting_wt'];
		}  else  {
			 $this->request->data['User']['starting_wt']='';
		}	
		if (!empty($_REQUEST['current_wt']))  {
			$this->request->data['User']['current_wt']=$_REQUEST['current_wt'];
		}  else  {
			 $this->request->data['User']['current_wt']='';
		}	
		if (!empty($_REQUEST['goal_wt']))  {
			$this->request->data['User']['goal_wt']=$_REQUEST['goal_wt'];
		}  else  {
			 $this->request->data['User']['goal_wt']='';
		}	
		//pr ($this->request->data);die;
		if ($this->User->save($this->request->data)) {
			if (isset($_REQUEST['profile_image']) && !empty($_REQUEST['profile_image']))  {
				$ti			=	date('Y-m-d-g:i:s');
				$dname= 	$ti.$id."image.png";
				$this->User->saveField('profile_image',$dname);
				@$_REQUEST['profile_image']	=	str_replace('data:image/png;base64,', '', $_REQUEST['profile_image']);
				$_REQUEST['profile_image'] 		=	str_replace(' ', '+',$_REQUEST['profile_image']);
				$unencodedData						=	base64_decode($_REQUEST['profile_image']);
				$pth3 	= WWW_ROOT.'files' . DS . 'profileimage'. DS .$dname;
				file_put_contents($pth3, $unencodedData);
			} 
			$user	=	$this->User->find('first',array('conditions'=>  array('User.id'=>$id)));	
			if (!empty($user['User']['profile_image']))  {
				$profileImage = FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$user['User']['profile_image'];
			} else {
				$profileImage = '';
			}
			if ($user['User']['usertype_id']	!= '')  {
				$user['User']['usertype_id'] 	=	$user['User']['usertype_id'];
			}  else  {
				$user['User']['usertype_id'] 	=	'';
			}
			
			if ($user['User']['birthday'] 	!= '')  {
				$user['User']['birthday']	=	$user['User']['birthday'];
			}  else  {
				$user['User']['birthday']	='';
			}	
			
			if ($user['User']['height'] 	!= '')  {
				$user['User']['height']	=	$user['User']['height'];
			}  else  {
				$user['User']['height']	='';
			}	
			
			if ($user['User']['gender'] 	!= '')  {
				$user['User']['gender']	=	$user['User']['gender'];
			}  else  {
				$user['User']['gender']	='';
			}
			
			if ($user['User']['username'] 	!= '')  {
				$user['User']['username']	=	$user['User']['username'];
			}  else  {
				$user['User']['username']	='';
			}	
			if ($user['User']['name'] 	!= '')  {
				$user['User']['name']	=	$user['User']['name'];
			}  else  {
				$user['User']['name']	='';
			}	
			if ($user['User']['contact'] != '')  {
				$user['User']['contact']	=	$user['User']['contact'];
			} else {
				$user['User']['contact']	='';
			}	
			if ($user['User']['starting_wt'] != '')  {
				$user['User']['starting_wt']	=	$user['User']['starting_wt'];
			} else {
				$user['User']['starting_wt']	='';
			}	
			if ($user['User']['current_wt'] != '')  {
				$user['User']['current_wt']	=	$user['User']['current_wt'];
			} else {
				$user['User']['current_wt']	='';
			}	
			if ($user['User']['goal_wt'] != '')  {
				$user['User']['goal_wt']	=	$user['User']['goal_wt'];
			} else {
				$user['User']['goal_wt']	='';
			}	
			if ($user['User']['about'] != '')  {
				$user['User']['about']	=	$user['User']['about'];
			} else {
				$user['User']['about']	='';
			}	
			$response			= 	array('success'=>1,'message'=>'The details has been updated.');
			$response['data'] = array (
				'user_id'		=> $user['User']['id'],
				'name'			=> $user['User']['name'],
				'username'	=> $user['User']['username'],
				'starting_wt'	=> $user['User']['starting_wt'],
				'current_wt'	=> $user['User']['current_wt'],
				'goal_wt'		=> $user['User']['goal_wt'],
				'contact'		=> $user['User']['contact'],
				'birthday'		=> $user['User']['birthday'],
				'height'			=> $user['User']['height'],
				'gender'			=> $user['User']['gender'],
				'usertype_id'	=> $user['User']['usertype_id'],						
				'about'			=> $user['User']['about']						
			);
			echo json_encode($response);exit;
		}  else {
			$response			= 	array('success'=>0,'message'=>'The details could not be saved. Please, try again.');
		}
		echo json_encode($response);
		exit();
	}		
	
	//http://dev414.trigma.us/N-162/webservices/all_users?user_id=207
	public function all_users() 
	{
		$user_id	=	$_REQUEST['user_id'];

		$users		=	$this->User->find (
			'all',array (
				'conditions' => array (
					"NOT" => array (
						"User.id" => array ($user_id,1) 
					)
				),
				'fields'=>array (
					'id','username','name','profile_image','age','gender','location','current_wt'
				),
				'contain'=>array ()
			)
		);

		if (empty($users))  {
			$response = array ('success'=>0,'message'=>'data not found.');
			echo json_encode($response);exit;
		}
		
		$response = array ('success'=>1,'message'=>'success.');
		foreach ($users as $info)  {
			if ($info['User']['id'] != '')  {
				
				/*  Handel Null Values Start */
				
				if ($info['User']['username'] 		== '')  {  $username 		= '';	}  else  {  $username 	=  $info['User']['username'];  }
				if ($info['User']['name']				== '')  {  $name 				= '';  	}  else  {  $name  			=	$info['User']['name'];  }
				if ($info['User']['age']					== '')  {  $age 				= '';  	}  else  {  $age  			=	$info['User']['age'];  }
				if ($info['User']['gender']				== '')  {  $gender 			= '';  	}  else  {  $gender  		=	$info['User']['gender'];  }
				if ($info['User']['username'] 		== '')  {  $username = ''; 		}  else  {  $username		=  $info['User']['username'];  }
				
				if ($info['User']['profile_image'] 	== '')  {  
					$profile_image 	= '';	
				}  else  {  
					$profile_image	=  FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$info['User']['profile_image'];  
				} 
				
				/*  Handel Null Values End */
					
				$response['data'][]	=	array(
					'user_id'			=> $info['User']['id'],
					'username'		=> $username,
					'name'				=> $name,
					'profile_image'	=> $profile_image,
					'age'					=> $age,
					'gender'				=> $gender,
				);
			} 			
		}		
		echo json_encode ($response);exit;
	}	
	
	/*  ----------------------------------------------- Follower Module Start ------------------------------------------------------------------ */
	
	//http://dev414.trigma.us/N-162/Webservices/add_follower?user_id=2260&follower_id=3236
	public function add_follower () 
	{
		$this->loadModel ('UserFollower');
		$user_id					=	$_REQUEST['user_id'];
		$follower_id			=	$_REQUEST['follower_id'];
		$data['UserFollower']['user_id']				=	$_REQUEST['user_id'];
		$data['UserFollower']['follower_id']			=	$_REQUEST['follower_id'];
		$data['UserFollower']['date']				=	date('Y-m-d');
		
		$user_follower 	= $this->UserFollower->find ('count',array('conditions'=>array('UserFollower.user_id'=>$user_id,'UserFollower.follower_id'=>$follower_id)));
		
		if ($user_follower == 0)  {
			if ($this->UserFollower->save($data))  {
				$response			= 	array('success'=>1,'message'=>'success.');
				echo json_encode ($response);exit;
			}  else  {
				$response = array('success'=>0,'message'=>'error.');
				echo json_encode ($response);exit;
			}
		} else  {
			if ($this->UserFollower->deleteAll (array('UserFollower.follower_id' => $_REQUEST['follower_id'],'UserFollower.user_id' => $_REQUEST['user_id'])))  {
					$response = array('success'=>2,'message'=>'User unfollow successfully.');
					echo json_encode ($response);exit;
			}  else  {
				$response = array('success'=>0,'message'=>'error.');
				echo json_encode ($response);exit;
			}
		}
	}
	
	//http://dev414.trigma.us/N-162/Webservices/user_follower?user_id=1
	public function user_follower ()
	{
		$data 	= 	$this->User->find (
			'first',
			array(
				'conditions'	=> array(
					'User.id'	=> $_REQUEST['user_id']
				),
				'fields'	=> array(
					'id','name','email','usertype_id','register_date','contact'
				),
				'contain'		=> array (
					'Following'	=> array ('User'	=> array ('id','name','email','usertype_id','register_date','contact')),
					'Follower'	=> array (
						'User'		=> array (
							'id','name','email','usertype_id','register_date','contact'
						),
						'Follower1' => array (
							'id','name','email','usertype_id','register_date','contact'
						)
					)
				)
			)
		);		
		if (empty($data)) {
			$response = array('success'=>0,'message'=>'no follower found.');
			echo json_encode ($response);exit;
		}	
		
		if (empty($data['Follower'])) {
			$response = array('success'=>0,'message'=>'no follower found.');
			echo json_encode ($response);exit;
		}	
		$id 					= $data['User']['id'];
		$name			= $data['User']['name'];	
		
		$response = array('success'=>1,'message'=>'success.');
		foreach($data['Follower'] as $key=>$value) {
			$response['data']			=	array(
				'id'					=> $id,
				'name'				=> $name,										
				'follower_id'		=> $value['Follower1']['id'],										
				'follower_name'	=> $value['Follower1']['name'],										
				'followers_email'	=> $value['Follower1']['email'],										
			);
		}
		echo json_encode($response);exit;					
	}
	
	//http://dev414.trigma.us/N-162/Webservices/user_following?user_id=1
	public function user_following ()
	{
		$data 	= 	$this->User->find (
			'first',
			array(
				'conditions'	=> array(
					'User.id'	=> $_REQUEST['user_id']
				),
				'fields'	=> array(
					'id','name','email','usertype_id','register_date','contact'
				),
				'contain'		=> array (
					'Following'	=> array ('User'	=> array ('id','name','email','usertype_id','register_date','contact')),
					'Follower'	=> array (
						'User'		=> array (
							'id','name','email','usertype_id','register_date','contact'
						),
						'Follower1' => array (
							'id','name','email','usertype_id','register_date','contact'
						)
					)
				)
			)
		);
		
		if (empty($data)) {
			$response = array('success'=>0,'message'=>'no following found.');
			echo json_encode ($response);exit;
		}	
		
		if (empty($data['Following'])) {
			$response = array('success'=>0,'message'=>'no following found.');
			echo json_encode ($response);exit;
		}	
		$id 					= $data['User']['id'];
		$name				= $data['User']['name'];	
		
		$response = array('success'=>1,'message'=>'success.');
		foreach($data['Following'] as $key=>$value) {	
			$response['data'][]			=	array(
				'id'					=> $id,
				'name'				=> $name,										
				'following_id'		=> $value['User']['id'],										
				'following_name'	=> $value['User']['name'],										
				'following_email'	=> $value['User']['email'],										
			);
		}
		echo json_encode($response);exit;								
	}
	
	/* ============================= Follower Module End =========================================== */	
	/*  ----------------------------------------------- Static Page Module Start ------------------------------------------------------------------- */
	
	//http://dev414.trigma.us/N-162/webservices/faqs
	public function faqs() 
	{
		$faqs		=	$this->Faq->find ('all');
		//pr ($faqs);die;
		$response = array ('success'=>1,'message'=>'success.');
		if (!empty($faqs))  {
			foreach($faqs as $info) {
				$response['data'][]	=	array(
					'faq_id'			=> $info['Faq']['id'],
					'title'				=> $info['Faq']['title'],
					'description'	=> @$info['Faq']['description'],
					'date'				=> @$info['Faq']['date'],
				);
			}
			echo json_encode ($response);exit;
		}
		$response = array ('success'=>0,'message'=>'data not found.');
		echo json_encode($response);exit;
	}	
	
	 //http://dev414.trigma.us/N-162/webservices/terms_services
	public function terms_services() 
	{
		$faqs		=	$this->TermService->find ('all');
		//pr ($faqs);die;
		$response = array ('success'=>1,'message'=>'success.');
		if (!empty($faqs))  {
			foreach($faqs as $info) {
				$response['data'][]	=	array(
					'faq_id'			=> $info['TermService']['id'],
					'title'				=> $info['TermService']['title'],
					'description'	=> $info['TermService']['description'],
					'date'				=> $info['TermService']['date'],
				);
			}
			echo json_encode ($response);exit;
		}
		$response = array ('success'=>0,'message'=>'data not found.');
		echo json_encode($response);exit;
	}

	//http://dev414.trigma.us/N-162/webservices/about_us
	public function about_us() 
	{
		$info		=	$this->About->find ('first');
		$response = array ('success'=>1,'message'=>'success.');
		if (!empty($info))  {
			$response['data']	=	array(
				'about_id'		=> $info['About']['id'],
				'title'				=> $info['About']['title'],
				'description'	=> $info['About']['description'],
				'date'				=> $info['About']['date'],
			);
			echo json_encode ($response);exit;
		}
		$response = array ('success'=>0,'message'=>'data not found.');
		echo json_encode($response);exit;
	}
	
	//http://dev414.trigma.us/N-162/Webservices/send_feedback?user_id=4&subject=PHP info &description=hellohello
	public function send_feedback()
	{
		$this->User->id 	= $_REQUEST['user_id'];
		if (!$this->User->exists())  {
			$response			= 	array('success'=>0,'message'=>'User not exist.');
			echo json_encode($response);exit;
		}
		
		$data['SendFeedback']['user_id'] 		= $_REQUEST['user_id'];
		$data['SendFeedback']['subject'] 		= $_REQUEST['subject'];
		$data['SendFeedback']['description'] 	= $_REQUEST['description'];
		$data['SendFeedback']['date'] 			= date('Y-m-d');
		
		$info 	= $this->User->find('first',array('conditions' =>array('User.id' =>$_REQUEST['user_id']),'fields'=>array('id','email'),'contain'=>array()));
		$admin = $this->User->find('first',array('conditions' =>array('User.id' =>1),'fields'=>array('id','email','username'),'contain'=>array()));
		
		if ($this->SendFeedback->save($data)) {
			$l = new CakeEmail();
			$ms 	= 	"<p>Hi".' '.$admin['User']['username'].",<br/>".$_REQUEST['description']."</p>";
			$l->emailFormat('html')->template('send_feedback', 'fancy')->subject($_REQUEST['subject'])->to($admin['User']['email'])->from($info['User']['email'])->send($ms);
			$response[] = array('status'=>1,'message'=>"You Feedback Send Successfully.?");
			echo json_encode($response);
			exit;
		 } 	else {
			$response[] = array('status'=>0,'message'=>"error");
			echo json_encode($response);
			exit;
		}
	}
	
	// http://dev414.trigma.us/N-162/Webservices/customerFeedback?user_id=2&message=gurudutt sharma&employer_id=2285&job_id=9
	public function customerFeedback () 
	{
		$this->loadModel ('Feedback');
		if (@$_REQUEST['user_id'] != '' && @$_REQUEST['message'] != '' && @$_REQUEST['employer_id'] != '' && @$_REQUEST['job_id'] != '') {
			$data['Feedback']['employer_id']	=	@$_REQUEST['employer_id'];
			$data['Feedback']['job_id']			=	@$_REQUEST['job_id'];
			$data['Feedback']['user_id']		=	@$_REQUEST['user_id'];
			$data['Feedback']['message']		=	@$_REQUEST['message'];
			$data['Feedback']['date']				=	date('Y-m-d');
			if ($this->Feedback->save($data))  {
				$response[] = array('success'=>1,'msg'=>'success.');
				echo json_encode($response);exit;
			}
		}  else  {
			$response[] = array('success'=>0,'msg'=>'error.');
			echo json_encode ($response);exit;
		}
	}
	
	/* ============================  Static Page Module Start ========================================== */
	/* ----------------------------------------------- Group Module Start  ---------------------------------------------------------------------------- */
	
	//http://dev414.trigma.us/N-162/webservices/groups_users?user_id=27
	public function groups_users() 
	{
		$user_id =	$_REQUEST['user_id'];
		$this->GroupUser->virtualFields = array (
			'members'	=>'select count(*) from group_users as gu where GroupUser.group_id = gu.group_id',
		);
		$groups		=	$this->GroupUser->find (
			'all',array(
				'conditions'  => array(
					'GroupUser.user_id' =>$user_id
				)
			)
		);
		//pr ($groups);die;
		$response 	= array ('success'=>1,'message'=>'success.');
		if (!empty($groups))  {
			foreach($groups as $info) {
				$group_image	=	!empty ($info['Group']['group_image']) ? FULL_BASE_URL.$this->webroot.'files' . DS . 'Group'. DS .$info['Group']['group_image'] : '';
				
				$response['data'][]	=	array(
					'group_id'		=> $info['Group']['id'],
					'group_name'	=> $info['Group']['group_name'],
					'description'	=> $info['Group']['description'],
					'rule'				=> $info['Group']['role'],
					'members' 	=> $info['GroupUser']['members'],
					'group_image' 		=> $group_image,
					'date'				=> $info['Group']['date'],
				 );
			}
			echo json_encode ($response);exit;
		}
		$response = array ('success'=>0,'message'=>'data not found.');
		echo json_encode($response);exit;
	}	
	
	//http://dev414.trigma.us/N-162/webservices/groups?user_id=27
	public function groups() 
	{
		$this->Group->virtualFields = array (
			'members'	=>'select count(*) from group_users as gu where Group.id = gu.group_id',
			'joined'		=>'select count(*) from group_users as gu where Group.id = gu.group_id and gu.user_id ='.$_REQUEST['user_id']
		);
		$groups		=	$this->Group->find ('all',array('contain'=>array('GroupUser')));
		$response 	= array ('success'=>1,'message'=>'success.');
		if (!empty($groups))  {
			foreach($groups as $info) {
				$group_image	=	!empty ($info['Group']['group_image']) ? FULL_BASE_URL.$this->webroot.'files' . DS . 'Group'. DS .$info['Group']['group_image'] : '';
				$joined				=	$info['Group']['joined'] ;
				if ($joined == 0) {
					$join = 'No';
				}  else {
					$join = 'Yes';
				}
				$response['data'][]	=	array(
					'group_id'		=> $info['Group']['id'],
					'group_name'	=> $info['Group']['group_name'],
					'description'	=> $info['Group']['description'],
					'rule'				=> $info['Group']['role'],
					'members' 	=> $info['Group']['members'],
					'group_image' 		=> $group_image,
					'joined' 			=> $join,
					'date'				=> $info['Group']['date'],
				 );
			}
			echo json_encode ($response);exit;
		}
		$response = array ('success'=>0,'message'=>'data not found.');
		echo json_encode($response);exit;
	}	
	
	//http://dev414.trigma.us/N-162/Webservices/group_joined_leave?user_id=41&group_id=2	
	public function group_joined_leave()
	{
		$data['GroupUser']['user_id']	=	$_REQUEST['user_id'];
		$data['GroupUser']['group_id']	=	$_REQUEST['group_id'];
		$data['GroupUser']['status']	=	"1";
		$data['GroupUser']['date']	=	date('Y-m-d');
		$group		=	$this->GroupUser->find ('count',array('conditions' =>array('GroupUser.user_id'=>$_REQUEST['user_id'],'GroupUser.group_id'=>$_REQUEST['group_id'])));
		if ($group == 0)  {
			if ($this->GroupUser->save($data))  {
				$response = array('success'=>1,'msg'=>'success.');
				echo json_encode($response);exit;
			}  else  {
				$response = array('success'=>0,'msg'=>'error.');
				echo json_encode ($response);exit;
			}  
		}  else {
			if($this->GroupUser->deleteAll(array('GroupUser.user_id'=>$_REQUEST['user_id'],'GroupUser.group_id'=>$_REQUEST['group_id'])))  {
				$response = array ('success'=>1,'message'=>'Group leave successfully.');
				echo json_encode($response);exit;
			}  else  {
				$response = array('success'=>0,'msg'=>'error.');
				echo json_encode ($response);exit;
			}  
		}
	}
	
	//http://dev414.trigma.us/N-162/webservices/group_description?group_id=4	
	public function group_description()
	{
		$id=	$_REQUEST['group_id'];
		$this->Group->virtualFields = array ('members'=>'select count(*) from group_users as gu where Group.id = gu.group_id');
		$description		=	$this->Group->find (
			'first',array (
				'conditions' =>array (
					'Group.id' =>$id
				),
				'contain'=>array (
					'GroupUser' =>array (
						'User'=>array ('fields'=>
							array ('User.id','User.username','User.name','User.profile_image')
						)
					)
				)
			)
		);
		//pr ($description);die;
		if(!empty($description))  {
			foreach($description['GroupUser']as $key => $val)  {
				$data [] = array(
					'id' 		=> $val['User']['id'],
					'name' 	=> $val['User']['name'],
					'image'	=> FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$val['User']['profile_image']
				);
			} 
			if (empty($data))  {
				$data = '';
			}
			$response		= 	array('success'=>1,'message'=>'success.');
			$response['data']	=	array(
				'group_id'		=> $description['Group']['id'],
				'group_name'	=> $description['Group']['group_name'],
				'description'	=> $description['Group']['description'],
				'rule'				=> $description['Group']['role'],
				'members'		=> $description['Group']['members'],
				'deatils' 			=>$data,
				'group_users'	=>$data,
				'date'				=> $description['Group']['date'],
			);
			pr ($response);die;
			echo json_encode($response);exit;
		}  else {
			$response = array ('success'=>0,'message'=>'No any blog found.');
			echo json_encode($response);exit;
		}
		exit;
	}
	
	/* =========================== Group Module End ================================================= */	
	/* ---------------------------------------------  Post Module Start ---------------------------------------------------------------------------------- */
	
	//http://dev414.trigma.us/N-162/Webservices/photo_post?user_id=4444&post_status=Public&photo=photo.png&description=sdafsfaf
	public function photo_post ()  {
		if ($_REQUEST['user_id'] == '' or  $_REQUEST['photo'] == '' or  $_REQUEST['post_status'] == '')  {
			$response[] = array('success'=>0,'msg'=>'Wrong request.');
			echo json_encode ($response);exit;
		}
		
		/* ----------------------- Post Table Data Start(User Id , Post Status, Post Date, Post Type is saving in Post table)----------------------- */
		
		$data['Post']['user_id']		=	$_REQUEST['user_id'];
		$data['Post']['status']			=	$_REQUEST['post_status'];
		$data['Post']['post_type_id']	=	1;
		$data['Post']['date']				=	date('Y-m-d');
		
		/* ----------------------- Post Table Data End ----------------------- */
		
		
		if ($this->Post->save($data))  {
			
			/* ----------------------- PostPhoto Table Data Start(User Id , Post Id, Post Date, Post Status is saving in PostPhoto table)----------------------- */
			
			$post_id  								= 	$this->Post->getLastInsertID();
			$photo['PostPhoto']['user_id']	=	$_REQUEST['user_id'];
			$photo['PostPhoto']['post_id']	=	$post_id;
			$photo['PostPhoto']['status']		=	$_REQUEST['post_status'];
			$photo['PostPhoto']['description']		=	$_REQUEST['description'];
			$photo['PostPhoto']['date']		=	date('Y-m-d');
			$post_photo							=	$_REQUEST['photo'];
			
			/* ----------------------- PostPhoto Table Data End ----------------------- */
			
			if ($this->PostPhoto->save($photo))  {
				if(@$post_photo!='') {  
					$name						=  time().'_'."post_photo.png";
					$this->PostPhoto->saveField('photo',$name);
					@$post_photo			=  str_replace('data:image/png;base64,', '', @$post_photo);
					$post_photo				=  str_replace(' ', '+',$post_photo);
					$unencodedData		=  base64_decode($post_photo);
					$pth 							=  WWW_ROOT.'files' . DS . 'PostPhoto' . DS .$name;
					file_put_contents($pth, $unencodedData);
				}
			}
			$response[] = array('success'=>1,'msg'=>'Success.');
			echo json_encode ($response);exit;
		}		
	}
	
	//http://dev414.trigma.us/N-162/Webservices/before_after_post?user_id=4444&post_status=Private&photo_before=photo_before.png&description=3423424dsg&photo_after=photo_after.png
	public function before_after_post ()  {
		if ($_REQUEST['user_id'] == '' or $_REQUEST['photo_before'] 	== '' or  $_REQUEST['photo_after'] == '' or  $_REQUEST['post_status'] == '')  {
			$response[] = array('success'=>0,'msg'=>'Wrong request.');
			echo json_encode ($response);exit;
		}
		
		/* ----------------------- Post Table Data Start(User Id , Post Status, Post Date, Post Type is saving in Post table)----------------------- */
		
		$data['Post']['user_id']		=	$_REQUEST['user_id'];
		$data['Post']['status']			=	$_REQUEST['post_status'];
		$data['Post']['post_type_id']	=	2;
		$data['Post']['date']				=	date('Y-m-d');
		
		/* ----------------------- Post Table Data End ----------------------- */
		
		
		if ($this->Post->save($data))  {
			
			/* ----------------------- PostBeforeAfter Table Data Start(User Id , Post Id, Post Date, Post Status is saving in PostBeforeAfter table)----------------------- */
			
			$post_id  										= 	$this->Post->getLastInsertID();
			$photo['PostBeforeAfter']['user_id']			=	$_REQUEST['user_id'];
			$photo['PostBeforeAfter']['post_id']			=	$post_id;
			$photo['PostBeforeAfter']['status']			=	$_REQUEST['post_status'];
			//$photo['PostBeforeAfter']['wt_before']		=	$_REQUEST['wt_before'];
			//$photo['PostBeforeAfter']['wt_after']			=	$_REQUEST['wt_after'];
			$photo['PostBeforeAfter']['description']		=	$_REQUEST['description'];
			$photo['PostBeforeAfter']['date']				=	date('Y-m-d');
			$photo_before										=	$_REQUEST['photo_before'];
			$photo_after											=	$_REQUEST['photo_after'];
			
			/* ----------------------- PostBeforeAfter Table Data End ----------------------- */
			
			if ($this->PostBeforeAfter->save($photo))  {
				if(@$photo_before !='') {  
					$name	=  time()."photo_before.png";
					$this->PostBeforeAfter->saveField('photo_before',$name);
					@$photo_before		=  str_replace('data:image/png;base64,','',@$photo_before);
					$photo_before			=  str_replace(' ', '+',$photo_before);
					$unencodedData		=  base64_decode($photo_before);
					$pth_photo_before		=  WWW_ROOT.'files'.DS.'PostBeforeAfter'.DS.'Before'.DS.$name;
					file_put_contents($pth_photo_before, $unencodedData);
				}
				if(@$photo_after !='') {  
					$name1	=  time()."photo_after.png";
					$this->PostBeforeAfter->saveField('photo_after',$name1);
					@$photo_after			=  str_replace('data:image/png;base64,', '', @$photo_after);
					$photo_after				=  str_replace(' ', '+',$photo_after);
					$unencodedData1		=  base64_decode($photo_after);
					$pth_photo_after		=  WWW_ROOT.'files'.DS.'PostBeforeAfter'.DS.'After'.DS.$name1;
					file_put_contents($pth_photo_after, $unencodedData1);
				}
			}
			$response[] = array('success'=>1,'msg'=>'Success.');
			echo json_encode ($response);exit;
		}	
	}
	
	//http://dev414.trigma.us/N-162/Webservices/text_post?user_id=4444&post_status=Public&text=photodddd
	public function text_post ()  {
		if ($_REQUEST['user_id'] == '' or  $_REQUEST['text'] == '' or  $_REQUEST['post_status'] == '')  {
			$response[] = array('success'=>0,'msg'=>'Wrong request.');
			echo json_encode ($response);exit;
		}
		
		/* ----------------------- Post Table Data Start(User Id , Post Status, Post Date, Post Type is saving in Post table)----------------------- */
		
		$data['Post']['user_id']		=	$_REQUEST['user_id'];
		$data['Post']['status']			=	$_REQUEST['post_status'];
		$data['Post']['post_type_id']	=	3;
		$data['Post']['date']				=	date('Y-m-d');
		
		/* ----------------------- Post Table Data End ----------------------- */
		
		
		if ($this->Post->save($data))  {
			
			/* ----------------------- PostText Table Data Start(User Id , Post Id, Post Date, Post Status is saving in PostText table)----------------------- */
			
			$post_id  							= 	$this->Post->getLastInsertID();
			$photo['PostText']['user_id']	=	$_REQUEST['user_id'];
			$photo['PostText']['post_id']	=	$post_id;
			$photo['PostText']['text']		=	$_REQUEST['text'];			
			$photo['PostText']['status']	=	$_REQUEST['post_status'];
			$photo['PostText']['date']		=	date('Y-m-d');
			
			/* ----------------------- PostText Table Data End ----------------------- */
			
			if ($this->PostText->save($photo))  {
				$response[] = array('success'=>1,'msg'=>'Success.');
				echo json_encode ($response);exit;
			}			
		}		
	}	
	
	//http://dev414.trigma.us/N-162/Webservices/quote_post?user_id=4444&post_status=Public&quote=photodddd
	public function quote_post ()  {
		if ($_REQUEST['user_id'] == '' or  $_REQUEST['quote'] == '' or  $_REQUEST['post_status'] == '')  {
			$response[] = array('success'=>0,'msg'=>'Wrong request.');
			echo json_encode ($response);exit;
		}
		
		/* ----------------------- Post Table Data Start(User Id , Post Status, Post Date, Post Type is saving in Post table)----------------------- */
		
		$data['Post']['user_id']		=	$_REQUEST['user_id'];
		$data['Post']['status']			=	$_REQUEST['post_status'];
		$data['Post']['post_type_id']	=	4;
		$data['Post']['date']				=	date('Y-m-d');
		
		/* ----------------------- Post Table Data End ----------------------- */
		
		
		if ($this->Post->save($data))  {
			
			/* ----------------------- PostQuote Table Data Start(User Id , Post Id, Post Date, Post Status is saving in PostQuote table)----------------------- */
			
			$post_id  								= 	$this->Post->getLastInsertID();
			$photo['PostQuote']['user_id']	=	$_REQUEST['user_id'];
			$photo['PostQuote']['post_id']	=	$post_id;
			$photo['PostQuote']['quote']		=	$_REQUEST['quote'];			
			$photo['PostQuote']['status']	=	$_REQUEST['post_status'];
			$photo['PostQuote']['date']		=	date('Y-m-d');
			
			/* ----------------------- PostQuote Table Data End ----------------------- */
			
			if ($this->PostQuote->save($photo))  {
				$response[] = array('success'=>1,'msg'=>'Success.');
				echo json_encode ($response);exit;
			}			
		}		
	}
		
	//http://dev414.trigma.us/N-162/Webservices/browse_post?user_id=27
	public function browse_post ()  {
		$user_id	=	$_REQUEST['user_id'];
		$this->Post->virtualFields = array (
			'inspired' 		=> 'SELECT count(*) FROM post_inspiredes WHERE Post.id=post_inspiredes.post_id',
			'comments' 	=> 'SELECT count(*) FROM post_comments WHERE Post.id=post_comments.post_id',
			'like_status'	=>'SELECT count(*) FROM post_inspiredes WHERE Post.id =post_inspiredes.post_id and post_inspiredes.user_id='.$user_id.''
		);
		
		$posts	=	$this->Post->find (
			'all',array(
				'contain'  =>  array (
					'PostPhoto'  => array (
						'User'	  => array (
							'fields' => array (
								'User.id','User.username','User.name','User.email','User.location','User.gender','User.age','User.height','User.profile_image','User.starting_wt','User.current_wt','User.goal_wt',
							)
						),
						'Post'
					),
					'PostBeforeAfter'  => array (
						'User'	  => array (
							'fields' => array (
								'User.id','User.username','User.name','User.email','User.location','User.gender','User.age','User.height','User.profile_image','User.starting_wt','User.current_wt','User.goal_wt',
							)
						),
						'Post'
					),
					'PostText'  => array (
						'User'	  => array (
							'fields' => array (
								'User.id','User.username','User.name','User.email','User.location','User.gender','User.age','User.height','User.profile_image','User.starting_wt','User.current_wt','User.goal_wt',
							)
						),
						'Post'
					),
					'PostQuote'  => array (
						'User'	  => array (
							'fields' => array (
								'User.id','User.username','User.name','User.email','User.location','User.gender','User.age','User.height','User.profile_image','User.starting_wt','User.current_wt','User.goal_wt',
							)
						),
						'Post'
					),
					'PostGroup'	=> array ('Group'=>array('GroupUser'))
				),
				'order'	=> array ('Post.id desc')
			)
		);
		//pr ($posts);die;
		
		$response = array('success'=>1,'msg'=>'success.');
		foreach ($posts as $post)  {
			if ($post['Post']['like_status'] ==0 )  {
				$like_status = 'NoLike';
			}  else  {
				$like_status = 'Liked';
			}
			
			if ($post['PostGroup']['id'] != '')  {
				$group_users_id = array_column($post['PostGroup']['Group']['GroupUser'], 'user_id');
			}  else  {
				$group_users_id = array ();
			}
			
			// if (in_array ($user_id,$group_users_id) or 
				// $post['PostPhoto']['status'] == 'Public' or 
				// ($post['Post']['status'] == 'Private' and $post['PostPhoto']['user_id'] == $user_id)
			// ) {
				if ($post['Post']['post_type_id'] == 1 and $post['PostPhoto']['id'] != '')  {

					$profile_image		=	!empty ($post['PostPhoto']['User']['profile_image']) ? FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$post['PostPhoto']['User']['profile_image'] : '';
					$post_photo			=	!empty ($post['PostPhoto']['photo']) ? FULL_BASE_URL.$this->webroot.'files' . DS . 'PostPhoto'. DS .$post['PostPhoto']['photo'] : '';
					
					$response['data'][]	=	array (
						'post_type_id'	=> $post['PostPhoto']['Post']['post_type_id'],
						'user_id'			=> $post['PostPhoto']['User']['id'],
						'profile_image'	=> $profile_image,
						'name'				=> $post['PostPhoto']['User']['name'],
						'email'				=> $post['PostPhoto']['User']['email'],
						'location'			=> $post['PostPhoto']['User']['location'],
						'gender'				=> $post['PostPhoto']['User']['gender'],
						'age'					=> $post['PostPhoto']['User']['age'],
						'height'				=> $post['PostPhoto']['User']['height'],
						'starting_wt'		=> $post['PostPhoto']['User']['starting_wt'],
						'current_wt'		=> $post['PostPhoto']['User']['current_wt'],
						'goal_wt'			=> $post['PostPhoto']['User']['goal_wt'],
						'post_id'			=> $post['PostPhoto']['post_id'],					
						'inspired'			=> $post['PostPhoto']['Post']['inspired'],
						'comments'		=> $post['PostPhoto']['Post']['comments'],
						'like_status'		=> $like_status,
						'post_photo'		=> $post_photo,
						'description'		=> $post['PostPhoto']['description'],
						'status'				=> $post['PostPhoto']['status'],
						'date'					=> date('d M Y ',strtotime($post['PostPhoto']['date']))
					);
					
				}  else if ($post['Post']['post_type_id'] == 2 and $post['PostBeforeAfter']['id'] != '')  {
					
					$profile_image		=	!empty ($post['PostBeforeAfter']['User']['profile_image']) ? FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$post['PostBeforeAfter']['User']['profile_image'] : '';
					$photo_before		=	!empty ($post['PostBeforeAfter']['photo_before']) ? FULL_BASE_URL.$this->webroot.'files' . DS . 'PostBeforeAfter'. DS .'Before'.DS.$post['PostBeforeAfter']['photo_before'] : '';
				
					$photo_after			=	!empty ($post['PostBeforeAfter']['photo_after']) ? FULL_BASE_URL.$this->webroot.'files' . DS . 'PostBeforeAfter'. DS .'After'.DS.$post['PostBeforeAfter']['photo_after'] : '';
					
					$response['data'][]	=	array (
						'post_type_id'	=> $post['PostBeforeAfter']['Post']['post_type_id'],
						'user_id'			=> $post['PostBeforeAfter']['User']['id'],
						'profile_image'	=> $profile_image,
						'name'				=> $post['PostBeforeAfter']['User']['name'],
						'email'				=> $post['PostBeforeAfter']['User']['email'],
						'location'			=> $post['PostBeforeAfter']['User']['location'],
						'gender'				=> $post['PostBeforeAfter']['User']['gender'],
						'age'					=> $post['PostBeforeAfter']['User']['age'],
						'height'				=> $post['PostBeforeAfter']['User']['height'],
						'starting_wt'		=> $post['PostBeforeAfter']['User']['starting_wt'],
						'current_wt'		=> $post['PostBeforeAfter']['User']['current_wt'],
						'goal_wt'			=> $post['PostBeforeAfter']['User']['goal_wt'],
						'post_id'			=> $post['PostBeforeAfter']['post_id'],					
						'inspired'			=> $post['PostBeforeAfter']['Post']['inspired'],
						'comments'		=> $post['PostBeforeAfter']['Post']['comments'],
						'like_status'		=> $like_status,
						'photo_before'	=> $photo_before,
						'photo_after'		=> $photo_after,
						'description'		=> $post['PostBeforeAfter']['description'],
						'status'				=> $post['PostBeforeAfter']['status'],
						'date'					=> date('d M Y ',strtotime($post['PostBeforeAfter']['date']))
					);
					
				}  else if ($post['Post']['post_type_id'] == 3 and $post['PostText']['id'] != '')  {
					
					$profile_image		=	!empty ($post['PostText']['User']['profile_image']) ? FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$post['PostText']['User']['profile_image'] : '';
					
					$response['data'][]	=	array (
						'post_type_id'	=> $post['PostText']['Post']['post_type_id'],
						'user_id'			=> $post['PostText']['User']['id'],
						'profile_image'	=> $profile_image,
						'name'				=> $post['PostText']['User']['name'],
						'email'				=> $post['PostText']['User']['email'],
						'location'			=> $post['PostText']['User']['location'],
						'gender'				=> $post['PostText']['User']['gender'],
						'age'					=> $post['PostText']['User']['age'],
						'height'				=> $post['PostText']['User']['height'],
						'starting_wt'		=> $post['PostText']['User']['starting_wt'],
						'current_wt'		=> $post['PostText']['User']['current_wt'],
						'goal_wt'			=> $post['PostText']['User']['goal_wt'],
						'post_id'			=> $post['PostText']['post_id'],					
						'inspired'			=> $post['PostText']['Post']['inspired'],
						'comments'		=> $post['PostText']['Post']['comments'],
						'like_status'		=> $like_status,
						'description'		=> $post['PostText']['text'],
						'status'				=> $post['PostText']['status'],
						'date'					=> date('d M Y ',strtotime($post['PostText']['date']))
					);				
					
				}  else if ($post['Post']['post_type_id'] == 4 and $post['PostQuote']['id'] != '')  {
					
					$profile_image		=	!empty ($post['PostQuote']['User']['profile_image']) ? FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$post['PostQuote']['User']['profile_image'] : '';
					
					$response['data'][]	=	array (
						'post_type_id'	=> $post['PostQuote']['Post']['post_type_id'],
						'user_id'			=> $post['PostQuote']['User']['id'],
						'profile_image'	=> $profile_image,
						'name'				=> $post['PostQuote']['User']['name'],
						'email'				=> $post['PostQuote']['User']['email'],
						'location'			=> $post['PostQuote']['User']['location'],
						'gender'				=> $post['PostQuote']['User']['gender'],
						'age'					=> $post['PostQuote']['User']['age'],
						'height'				=> $post['PostQuote']['User']['height'],
						'starting_wt'		=> $post['PostQuote']['User']['starting_wt'],
						'current_wt'		=> $post['PostQuote']['User']['current_wt'],
						'goal_wt'			=> $post['PostQuote']['User']['goal_wt'],
						'post_id'			=> $post['PostQuote']['post_id'],
						'inspired'			=> $post['PostQuote']['Post']['inspired'],
						'comments'		=> $post['PostQuote']['Post']['comments'],
						'like_status'		=> $like_status,
						'description'		=> $post['PostQuote']['quote'],
						'status'				=> $post['PostQuote']['status'],
						'date'					=> date('d M Y ',strtotime($post['PostQuote']['date']))
					);				
					
				}
			//}
		}		
		
		if (empty($response))  {
			$response = array('success'=>0,'msg'=>'No post found.');
		}
		echo json_encode ($response);exit;
	}
	
	//http://dev414.trigma.us/N-162/Webservices/post_inspiredes?user_id=27&post_id=50
	public function post_inspiredes ()  {
		$user_id	=	$_REQUEST['user_id'];
		$post_id	=	$_REQUEST['post_id'];
		
		if ($post_id == '' or $user_id == '')  {
			$response[] = array('success'=>0,'msg'=>'Wrong request.');
			echo json_encode ($response);exit;		
		}
		$count 	= 	$this->PostInspirede->find ('count',array('conditions'=>array('PostInspirede.post_id'=>$post_id,'PostInspirede.user_id'=>$user_id)));
		if ($count == 0)  {
			$data['PostInspirede']['user_id']		=	$_REQUEST['user_id'];
			$data['PostInspirede']['post_id']			=	$_REQUEST['post_id'];
			$data['PostInspirede']['date']				=	date('Y-m-d');
		
			if ($this->PostInspirede->save($data))  {			
				$response = array('success'=>1,'msg'=>'Success.');
				echo json_encode ($response);exit;			
			}				  	
		}  else {
			if ($this->PostInspirede->deleteAll (array('PostInspirede.user_id' => $user_id,'PostInspirede.post_id' => $post_id)))  {
				$response = array('success'=>1,'msg'=>'Success.');
				echo json_encode ($response);exit;	
			}
		} 
	
		$response = array('success'=>0,'msg'=>'Error.');
		echo json_encode ($response);exit;		
	}
	
	//http://dev414.trigma.us/N-162/Webservices/post_comments?user_id=27&post_id=50&comment=djsdgkjdfkj
	public function post_comments ()  {
		$user_id	=	$_REQUEST['user_id'];
		$post_id	=	$_REQUEST['post_id'];
		$comment	=	$_REQUEST['comment'];
		
		if ($post_id == '' or $user_id == '' or $comment == '')  {
			$response[] = array('success'=>0,'msg'=>'Wrong request.');
			echo json_encode ($response);exit;		
		}
		
		$data['PostComment']['user_id']		=	$_REQUEST['user_id'];
		$data['PostComment']['post_id']		=	$_REQUEST['post_id'];
		$data['PostComment']['comment']	=	$_REQUEST['comment'];
		$data['PostComment']['date']				=	date('Y-m-d');
		
		if ($this->PostComment->save($data))  {			
			$response = array('success'=>1,'msg'=>'Success.');
			echo json_encode ($response);exit;			
		}	
		$response = array('success'=>0,'msg'=>'Error.');
		echo json_encode ($response);exit;		
	}
	
	//http://dev414.trigma.us/N-162/Webservices/comments_of_post?post_id=1
	public function comments_of_post ()
	{
		$data 	= 	$this->PostComment->find ('all',array('conditions'=>array('PostComment.post_id'=>$_REQUEST['post_id']),'order'=>array('PostComment.id desc')));
		//pr ($data);die; 
		if (empty($data)) {
			$response = array('success'=>0,'message'=>'no post found.');
			echo json_encode ($response);exit;
		}	
		$response = array('success'=>1,'message'=>'no   found.');
		foreach($data as $key=>$value) {
			$profile_image	=	isset ($value['User']['profile_image']) ? FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$value['User']['profile_image'] : '';
			
			if ($value['User']['profile_image'] == '')  {
				$profile_image = FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .'person-icon.png';
			}
			if ($value['User']['registertype'] == 'facebook')  {
				$profile_image = $value['User']['profile_image'];
			}
			$response['data'][]	=	array(
				'success'			=> 1,
				'id'					=> $value['PostComment']['id'],
				'user_id'			=> $value['PostComment']['user_id'],										
				'post_id'			=> $value['PostComment']['post_id'],										
				'comment'			=> $value['PostComment']['comment'],										
				'date_uploads'	=> $value['PostComment']['date'],										
				'username'		=> $value['User']['username'],										
				'username_profile'	=> $profile_image,																		
			);
		}
		if (empty($response))  {
			$response = array('success'=>0,'message'=>'no   found.');
			echo json_encode ($response);exit;
		}
		echo json_encode($response);exit;					
	}
	
	//http://dev414.trigma.us/N-162/Webservices/comment_remove?comment_id=1
	public function comment_remove ()
	{
		$id	=	$_REQUEST['comment_id'];
		if ($this->PostComment->deleteAll (array('PostComment.id' => $id)))  {
			$response = array('success'=>1,'message'=>'Success.');
			echo json_encode ($response);exit;	
		}		
		$response = array('success'=>0,'message'=>'no   found.');
		echo json_encode($response);exit;					
	}
}