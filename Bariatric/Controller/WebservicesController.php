<?php
#Project : N-162
class WebservicesController extends AppController 
{
	public $uses	= array('About','Faq','FoodBreakfast','FoodDinner','FoodLunch','FoodSnack','FoodWater','GoalActivityUser','GoalFood','GoalFoodBreakfast','GoalFoodDinner','GoalFoodLunch','GoalFoodUser','GoalFoodSnack','GoalFoodWater','GoalFoodMyRecipes','GoalSleep','GoalProteinShakeUser','GoalSupplementUser','GoalsWeight','Group','GroupUser','PostInspirede','Post','PostComment','PostPhoto','PostBeforeAfter','PostText','PostQuote','Notification','NotificationLike','NotificationUser','SendFeedback','TermService','User','UserDoctor','UserFollower','UserChat');
	public function beforeFilter () 
	{
		parent::beforeFilter();
		$this->Auth->allow(array('PushChat','array_sort_by_column','signup','signout','login','forgot','admin_reset','changepass','myProfile','profile_edit','all_users','send_message','user_chats','users','add_follower','user_follower','user_following','faqs','terms_services','about_us','send_feedback','customerFeedback','groups_users','group_members','groups','group_joined_leave','group_description','photo_post','before_after_post','text_post','quote_post','browse_post','private_browse_post','post_inspiredes','post_comments','comments_of_post','comment_remove','my_goals','user_weight','track_weight','user_sleep','track_sleep','foods','foods_details','user_food','track_food','user_supplement','track_supplement','user_protein_shakes','track_protein_shakes','user_activity','track_activity','add_doctor','main_notification_set','like_notifications_list','notifications_list','comment_notifications_list','daily_reminders','water_reminders_five_minutes','water_reminders_thirty_minutes','water_reminders_every_hours','protein_reminders_weight_loss','protein_reminders_back_on_track','protein_reminders_maintenance','vetamin_medication_reminder','morning_weight_reminder','sleep_reminder','reminders_user','reminders_set','all_reminders','send_notification','userss'));
	}	
	
	public function get_location ($user_id=Null)  {
		$user_data_post = $this->User->find('first',array('conditions' =>array('User.id' =>$user_id)));
		$url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($user_data_post['User']['lat']).','.trim($user_data_post['User']['long']).'&sensor=false';
		$json = @file_get_contents($url);
		$data=json_decode($json);
		$status = $data->status;
		if($status=="OK")  {
		   $data_post = $data->results[0]->formatted_address;
		}  else  {
		   $data_post = 'Not Mention';
		}
		return $data_post;exit;
	}
	
	public function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) 
	{
		$sort_col = array();
		foreach ($arr as $key=> $row) {
			$sort_col[$key] = $row[$col];
		}
		array_multisort($sort_col, $dir, $arr);
	}
	
	/*  -------------------------------------------------------------------- User Module Start ---------------------------------------------------------------------- */
	//http://dev414.trigma.us/N-162/Webservices/signup?name=gurudutt1&email=gurudutt.sharma@trigma.in&usertype_id=2&register_type=manual&password=123456&contact=123&fb_id=12134&device_token=123&lat=aa&long=delhi
	public function signup() 
	{
		$data['User']['name']					=	isset ($_REQUEST['name']) ? $_REQUEST['name'] : '';
		$data['User']['profile_image']	=	isset ($_REQUEST['image']) ? $_REQUEST['image'] : '';
		$data['User']['email']					=	isset ($_REQUEST['email']) ? $_REQUEST['email'] : '';
		$data['User']['contact']				=	isset ($_REQUEST['contact']) ? $_REQUEST['contact'] : '';
		$data['User']['registertype']		=	isset ($_REQUEST['register_type']) ? $_REQUEST['register_type'] : '';		
		$data['User']['status'] 				=	1;
		$data['User']['register_date'] 	= 	date ("d-M-Y"); 
		$data['User']['usertype_id']  	=  isset ($_REQUEST['usertype_id']) ? $_REQUEST['usertype_id'] : '';
		$data['User']['device_token']  	=  $_REQUEST['device_token'];
		$data['User']['lat']  	=  $_REQUEST['lat'];
		$data['User']['long']  	=  $_REQUEST['long'];
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
	
	//http://dev414.trigma.us/N-162/Webservices/signout
	public function signout ($u = null,$p = null)	
	{
		 
		 $this->loadModel('User');
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
		$name			=	!empty ($isf['User']['name']) ? $isf['User']['name'] : '';
		$email			=	!empty ($isf['User']['email']) ? $isf['User']['email'] : '';
		$contact			=	!empty ($isf['User']['contact']) ? $isf['User']['contact'] : '';
		$profile_image	=	!empty ($isf['User']['profile_image']) ? FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$isf['User']['profile_image'] : '';
		
		if ($isf['User']['registertype'] == 'facebook')  {
			$profile_image = $value['User']['profile_image'];
		}
		
		/* Update Lat Long Start */
		if ($_REQUEST['lat']  != '' and $_REQUEST['long']  != '')  {
			$this->User->query("UPDATE users set `lat` = '".$_REQUEST['lat']."' , `long` ='".$_REQUEST['long']."' where id = '".$us['User']['id']."'  ");
		}
		/* Update Lat Long End */
		
		$response				=	array ('success'=>1,'message'=>$resp);
		$response['data']	=	array (
			'user_id' 			=> $user_id,
			'email'				=> $email,
			'contact'			=> $contact,
			'profile_image'	=> $profile_image,
		);
		echo json_encode($response);exit; 
	}	
	
	//http://dev414.trigma.us/N-162/Webservices/login?email=gduddrrudutt.sharma@trigma.in&password=123456&usertype_id=2&lat=30.75&long=76.78
	public function login ($u = null,$p = null)	
	{
		 
		 $this->loadModel('User');
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
		$name			=	!empty ($isf['User']['name']) ? $isf['User']['name'] : '';
		$email			=	!empty ($isf['User']['email']) ? $isf['User']['email'] : '';
		$contact			=	!empty ($isf['User']['contact']) ? $isf['User']['contact'] : '';
		$profile_image	=	!empty ($isf['User']['profile_image']) ? FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$isf['User']['profile_image'] : '';
		
		if ($isf['User']['registertype'] == 'facebook')  {
			$profile_image = $value['User']['profile_image'];
		}
		
		/* Update Lat Long Start */
		if ($_REQUEST['lat']  != '' and $_REQUEST['long']  != '' and $_REQUEST['lat']  != Null and $_REQUEST['long']  != Null and $_REQUEST['device_token']  != '' and $_REQUEST['device_token']  != Null )  {
			$data['User']['id']						=	$us['User']['id'];
			$data['User']['device_token']	=	$_REQUEST['device_token'];
			$data['User']['lat']						=	$_REQUEST['lat'];
			$data['User']['long']					=	$_REQUEST['long'];
			$this->User->create();            				
			$this->User->save($data);
		}
		/* Update Lat Long End */
		
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
	
	//http://dev414.trigma.us/N-162/webservices/myProfile?follower_id=207&id=23
	public function myProfile() 
	{  
		$id	=	@$_REQUEST['follower_id'];
		if (@$_REQUEST['id'] != '') {
			$follower_id	=	@$_REQUEST['id'];
		}  else {
			$follower_id	=	0;
		}		
		
		$this->User->id	=	$id;
		if($this->User->exists())  {    
			$this->User->virtualFields = array(
				'followers'	=>  'SELECT count(*) FROM user_followers WHERE User.id=user_followers.user_id ',
				'followings'	=>  'SELECT count(*) FROM user_followers WHERE User.id=user_followers.follower_id ',
				'follower_status'	=>  'SELECT count(*) FROM user_followers WHERE user_followers.follower_id='.$id.' and user_followers.user_id='.$follower_id.'',
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
				if ($isf['User']['follower_status']  !=0) {
					$follower_status  = 1;
				}  else {
					$follower_status  = 0;
				} 
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
					'about'				=> $about,
					'follower_status'				=> $follower_status					
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
	
	//http://dev414.trigma.us/N-162/Webservices/send_message?sender_id=27&receiver_id=34&message=messagemessage
	public function send_message () 
	{
		$this->loadModel('NotificationTypeUser');
		$sender_id			=	$_REQUEST['sender_id'];
		$receiver_id			=	$_REQUEST['receiver_id'];
		$message				=	$_REQUEST['message'];
		
		$data['UserChat']['sender_id']		=	$sender_id;
		$data['UserChat']['receiver_id']	=	$receiver_id;
		$data['UserChat']['message']		=	$message;
		$data['UserChat']['date']				=	date('Y-m-d');
		
		$senderExist			=	$this->User->find ('count',array('conditions'=>array('User.id'=>$sender_id)));		
		if ($senderExist == 0) {
			$response = array('success'=>0,'message'=>'Sender not exist.');
			echo json_encode ($response);exit;
		}
		
		$receiverExist			=	$this->User->find ('count',array('conditions'=>array('User.id'=>$receiver_id)));		
		if ($receiverExist == 0) {
			$response = array('success'=>0,'message'=>'Receiver not exist.');
			echo json_encode ($response);exit;
		}
		
		if ($this->UserChat->save($data))  {
			$user_chat_id  			= 	$this->UserChat->getLastInsertID();
			/* NotificationTypeUser */
				$typeUser['NotificationTypeUser']['user_chat_id']				=	$user_chat_id;
				$typeUser['NotificationTypeUser']['post_id']							=	0;
				$typeUser['NotificationTypeUser']['receiver_id']					=	$receiver_id;
				$typeUser['NotificationTypeUser']['sender_id']						=	$sender_id;
				$typeUser['NotificationTypeUser']['notification_type_id']		=	4;
				$typeUser['NotificationTypeUser']['date']								=	date('Y-m-d');	
				$this->NotificationTypeUser->save($typeUser);
			/*  NotificationTypeUser */
			/* Notification code Start*/
			$path 					= WWW_ROOT.'ck.pem';				
			$receiver			=	$this->User->find ('first',array('conditions'=>array('User.id'=>$_REQUEST['receiver_id']),'contain'=>array(),'fields'=>array('id','name','device_token','user_notification')));
			$sender				=	$this->User->find ('first',array('conditions'=>array('User.id'=>$_REQUEST['sender_id']),'contain'=>array(),'fields'=>array('id','name')));
			//echo "<pre>";print_r ($receiver);die;
			if ($receiver['User']['user_notification']  == 'Yes')  {
				
				$message		=	$sender['User']['name'].' send message to you.';
				$passphrase 	= '123456';
				
				if (@$receiver['User']['device_token'] != '') {
					$deviceToken	=	$receiver['User']['device_token'];
				}  else  {
					$deviceToken	=	'';
				}
				//$deviceToken	=	'a3afe7ab458c454306eae1e1f5bcf1080ebe775931258f5a6a10d14d29e0a6e8';
				
				// Create a Stream
				$ctx = stream_context_create();
				// Define the certificate to use 
				stream_context_set_option($ctx, 'ssl', 'local_cert',$path);	
				// Passphrase to the certificate
				stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);	
				
				// Open a connection to the APNS server
				$fp 	= stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT,$ctx);
				//echo $fp;die;
				// Check that we've connected
				if (!$fp) {
					exit("Failed to connect: $err $errstr" . PHP_EOL);
				} 
				
				$body['aps'] 	= array ('alert' => $message,'type' =>  'text','sound' => 'default');
				$name1			= 'Daily Reminders Notification';
				$body['data'] 	= array ('id' => 123,'name' => $name1,'status'=>1,'user_id'=>$sender['User']['id'],'user_name'=>$sender['User']['name']);

				$payload = json_encode($body);
				$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
				
				// Send it to the server
				$result = fwrite($fp, $msg, strlen($msg));
				
				if (!$result) {	
					//return 0; 
					$response 	= array('success'=>0,'msg'=>'Error in notification.');
					echo json_encode ($response);exit;	
					fclose ($fp);						
				}  else  {
					//return 1;					
					fclose($fp);
				}	
			}
			/* Notification code End*/
			$response			= 	array('success'=>1,'message'=>'success.');
			echo json_encode ($response);exit;
		}  else  {
			$response = array('success'=>0,'message'=>'error.');
			echo json_encode ($response);exit;
		}
	}
	
	//http://dev414.trigma.us/N-162/Webservices/user_chats?sender_id=27&receiver_id=34
	public function user_chats () 
	{
		$sender_id			=	$_REQUEST['sender_id'];
		$receiver_id			=	$_REQUEST['receiver_id'];
		
		/* --------------- Check Sender Receiver exist (Start)---------- */
		
		$senderExist			=	$this->User->find ('count',array('conditions'=>array('User.id'=>$sender_id),'contain'=>array()));		
		if ($senderExist == 0) {
			$response = array('success'=>0,'message'=>'Sender not exist.');
			echo json_encode ($response);exit;
		}
		
		$receiverExist			=	$this->User->find ('count',array('conditions'=>array('User.id'=>$receiver_id),'contain'=>array()));		
		if ($receiverExist == 0) {
			$response = array('success'=>0,'message'=>'Receiver not exist.');
			echo json_encode ($response);exit;
		}
		
		/* --------------- Check Sender Receiver exist (End) ---------- */
		/* --------------- Get Message of sender and receiver --------*/
		
		$messages		=	$this->UserChat->find (
			'all',array (
				'conditions' => array (
					'OR' => array (
						array(
							'AND' => array(
								array('UserChat.sender_id' => $sender_id),
								array('UserChat.receiver_id' => $receiver_id)
							)
						),
						array(
							'AND' => array(
								array('UserChat.sender_id' => $receiver_id),
								array('UserChat.receiver_id' => $sender_id)
							)
						)
					)
				),
				'order'		=> array ('UserChat.id'),
				'contain'	=> array (
					'Sender'=>array(
						'fields'=>array (
							'Sender.id','Sender.username','Sender.name','Sender.profile_image','Sender.registertype'
						)
					),
					'Receiver'=>array(
						'fields'=>array (
							'Receiver.id','Receiver.username','Receiver.name','Receiver.profile_image','Receiver.registertype'
						)
					)
				)
			)
		);
		
		if (empty($messages))  {
			$response = array ('success'=>0,'message'=>'data not found.');
			echo json_encode($response);exit;
		}
		
		$response = array ('success'=>1,'message'=>'success.');
		foreach ($messages as $message)  {
			//echo "<pre>";print_r($message);
			if ($message['Sender']['id'] == $sender_id)  {
				$chatUser = 'In';
			}  else  {
				$chatUser = 'Out';
			}
	
			$user_pic	=	!empty ($message['Sender']['profile_image']) ? FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$message['Sender']['profile_image']: '';
		
			if ($message['Sender']['registertype'] == 'facebook')  {
				$user_pic = $message['Sender']['profile_image'];
			}
			$response['data'][]	=	array(
				'chat_id'				=> $message['UserChat']['id'],
				'sender_id'			=> $message['Sender']['id'],
				'receiver_id'		=> $message['Receiver']['id'],
				'message'			=> $message['UserChat']['message'],
				'date'					=> $message['UserChat']['date'],
				'name'					=> $message['Sender']['name'],
				'user_pic'			=>  $user_pic,
				'chatUser'			=> $chatUser,
			);

		}	
		//echo "<pre>";print_r ($response);die;
		echo json_encode ($response);exit;
	}
	
	//http://dev414.trigma.us/N-162/Webservices/add_doctor?clinic_id=23&name=gurudutt1&email=gurudutt.sharma@trigma.in&password=123456&contact=123
	public function add_doctor() 
	{
		$clinic_id									=	$_REQUEST['clinic_id'];
		$data['User']['name']					=	isset ($_REQUEST['name']) ? $_REQUEST['name'] : '';
		$data['User']['profile_image']	=	isset ($_REQUEST['image']) ? $_REQUEST['image'] : '';
		$data['User']['email']					=	isset ($_REQUEST['email']) ? $_REQUEST['email'] : '';
		$data['User']['contact']				=	isset ($_REQUEST['contact']) ? $_REQUEST['contact'] : '';
		$data['User']['registertype']		=	'manual';		
		$data['User']['status'] 				=	1;
		$data['User']['register_date'] 	= 	date ("d-M-Y"); 
		$data['User']['usertype_id']  	=  4;
		
		$data['User']['password']  =  AuthComponent::password($_REQUEST['password']);
		$emailexist 						= 	$this->User->find('first',array('conditions'=>array('AND'=>array('User.email'=>$data['User']['email']))));
			
		if (empty($emailexist))  {
			$this->User->create();            
			if ($this->User->save($data)) {
				$user_id    		=  $this->User->getLastInsertID();							
				$usertype_id	=	4;	
				
				$doctor['UserDoctor']['clinic_id']		=	$clinic_id;	
				$doctor['UserDoctor']['doctor_id']	=	$user_id;
				$this->UserDoctor->save($doctor);
				
				$response		= 	array ('success'=>1,'message'=>'User Register Successfully');
				$response['data']		=	array (
					'user_id'		=> 	$user_id,
					'usertype_id'	=> $usertype_id
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
		exit;
    }		
	
	/* ======================================  User Module End ========================================*/
	/*  --------------------------------------------------------------------  Follower Module Start   ----------------------------------------------------------------*/
	

	//http://dev414.trigma.us/N-162/Webservices/add_follower?user_id=2260&follower_id=3236
	public function add_follower () 
	{
		$this->loadModel ('UserFollower');
		$this->loadModel ('NotificationTypeUser');
		$user_id					=	$_REQUEST['user_id'];
		$follower_id			=	$_REQUEST['follower_id'];
		$data['UserFollower']['user_id']				=	$_REQUEST['user_id'];
		$data['UserFollower']['follower_id']			=	$_REQUEST['follower_id'];
		$data['UserFollower']['date']				=	date('Y-m-d');
		
		$user_follower 	= $this->UserFollower->find ('count',array('conditions'=>array('UserFollower.user_id'=>$user_id,'UserFollower.follower_id'=>$follower_id)));
		
		if ($user_follower == 0)  {
			if ($this->UserFollower->save($data))  {
			/* NotificationTypeUser */
				$typeUser['NotificationTypeUser']['user_chat_id']				=	0;
				$typeUser['NotificationTypeUser']['post_id']							=	0;
				$typeUser['NotificationTypeUser']['receiver_id']					=	$follower_id;
				$typeUser['NotificationTypeUser']['sender_id']						=	$user_id;
				$typeUser['NotificationTypeUser']['notification_type_id']		=	3;
				$typeUser['NotificationTypeUser']['date']								=	date('Y-m-d');	
				$this->NotificationTypeUser->save($typeUser);
			/*  NotificationTypeUser */
				/* Notification code Start*/
			$path 					= WWW_ROOT.'ck.pem';				
			$receiver			=	$this->User->find ('first',array('conditions'=>array('User.id'=>$_REQUEST['follower_id']),'contain'=>array(),'fields'=>array('id','name','device_token','user_notification')));
			$sender				=	$this->User->find ('first',array('conditions'=>array('User.id'=>$_REQUEST['user_id']),'contain'=>array(),'fields'=>array('id','name')));
			//echo "<pre>";print_r ($receiver);die;
			if ($receiver['User']['user_notification']  == 'Yes')  {
				
				$message		=	$sender['User']['name'].' follow you.';
				$passphrase 	= '123456';
				
				if (@$receiver['User']['device_token'] != '') {
					$deviceToken	=	$receiver['User']['device_token'];
				}  else  {
					$deviceToken	=	'';
				}
				//$deviceToken	=	'a3afe7ab458c454306eae1e1f5bcf1080ebe775931258f5a6a10d14d29e0a6e8';
				
				// Create a Stream
				$ctx = stream_context_create();
				// Define the certificate to use 
				stream_context_set_option($ctx, 'ssl', 'local_cert',$path);	
				// Passphrase to the certificate
				stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);	
				
				// Open a connection to the APNS server
				$fp 	= stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT,$ctx);
				//echo $fp;die;
				// Check that we've connected
				if (!$fp) {
					exit("Failed to connect: $err $errstr" . PHP_EOL);
				} 
				
				$body['aps'] 	= array ('alert' => $message,'type' =>  'text','sound' => 'default');
				$name1			= 'Daily Reminders Notification';
				$body['data'] 	= array ('id' => 123,'name' => $name1,'status'=>0,'user_id'=>$sender['User']['id'],'user_name'=>$sender['User']['name']);

				$payload = json_encode($body);
				$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
				
				// Send it to the server
				$result = fwrite($fp, $msg, strlen($msg));
				
				if (!$result) {	
					//return 0; 
					$response 	= array('success'=>0,'msg'=>'Error in notification.');
					echo json_encode ($response);exit;	
					fclose ($fp);						
				}  else  {
					//return 1;					
					fclose($fp);
				}	
			}
			/* Notification code End*/
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
	
	//http://dev414.trigma.us/N-162/Webservices/user_follower?user_id=1&follower_id=23
	public function user_follower ()
	{		
		$user_id			=	$_REQUEST['user_id'];
		//$follower_id	=	$_REQUEST['follower_id'];
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
							'id','name','email','usertype_id','register_date','contact','birthday','current_wt','gender','location','profile_image'
						),
						'Follower1' => array (
							'id','name','email','usertype_id','register_date','contact','birthday','current_wt','gender','location','profile_image'
						)
					)
				)
			)
		);		
		//echo "<pre>";print_r($data);die;
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
		$today 			= date('y-m-d');
		$response = array('success'=>1,'message'=>'success.');
		foreach($data['Follower'] as $key=>$value) {
			//$follower_status	=	$group		=	$this->UserFollower->find ('count',array('conditions' =>array('UserFollower.user_id'=>$user_id,'UserFollower.follower_id'=>$follower_id)));
			$profile_image		=!empty ($value['Follower1']['profile_image']) ? FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$value['Follower1']['profile_image'] : '';
			// if ($follower_status == 0) {
				// $follower_status	=	'No';
			// }  else  {
				// $follower_status	=	'Yes';
			// }
			$location_name	=	$this->get_location ($value['Follower1']['id']);
			//echo $location_name;die;
			$response['data'][]			=	array(
				'type'				=> 'Follower',
				'id'					=> $id,
				'name'				=> $name,										
				'follower_id'		=> $value['Follower1']['id'],										
				'follower_name'	=> $value['Follower1']['name'],										
				'followers_email'	=> $value['Follower1']['email'],										
				'followers_birthday'	=> date_diff(date_create($value['Follower1']['birthday']), date_create($today))->y,										
				'followers_age'	=> $value['Follower1']['birthday'],										
				'followers_current_wt'	=> $value['Follower1']['current_wt'],										
				'followers_gender'	=> $value['Follower1']['gender'],										
				'followers_location'	=> $location_name,										
				'followers_profile_image'	=> $profile_image,										
			);
		}		
		//echo "<pre>";print_r($response);
		echo json_encode($response);exit;					
	}
	
	//http://dev414.trigma.us/N-162/Webservices/users?user_id=1
	public function users ()
	{
		$users		=	$this->UserFollower->find ('all',array('conditions'=>array('OR'=>array('UserFollower.user_id'=>$_REQUEST['user_id'],'UserFollower.follower_id'=>$_REQUEST['user_id'])),'contain'=>array()));
		
		$user_id		=	array();
		foreach ($users as $info)  {
				array_push ($user_id,$info['UserFollower']['user_id'],$info['UserFollower']['follower_id']);
		}
		$user_id =	array_unique ($user_id);		
		$data 	= 	$this->User->find (
			'all',
			array(
				'conditions'	=> array(
					'User.id'	=> $user_id
				),
				'fields'	=> array(
					'id','name','email','usertype_id','register_date','contact','profile_image','birthday','current_wt','gender','location',''
				),
				'contain'		=> array ()
			)
		);		
		//echo "<pre>";print_r($user_id);
		//echo "<pre>";print_r($data);die;
		if (empty($data)) {
			$response = array('success'=>0,'message'=>'no follower found.');
			echo json_encode ($response);exit;
		}	
			
		$today 			= date('y-m-d');
		$response = array('success'=>1,'message'=>'success.');
		foreach($data as $key=>$value) {
			if ( $value['User']['id'] != $_REQUEST['user_id'])  {
				$location_name	=	$this->get_location ($value['User']['id']);
				//echo $location_name;die;
				$profile_image	=!empty ($value['User']['profile_image']) ? FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$value['User']['profile_image'] : '';
				$response['data'][]			=	array(
					'follower_id'		=> $value['User']['id'],										
					'follower_name'	=> $value['User']['name'],										
					'followers_email'	=> $value['User']['email'],										
					'followers_birthday'	=> date_diff(date_create($value['User']['birthday']), date_create($today))->y,										
					'followers_age'	=> $value['User']['birthday'],										
					'followers_current_wt'	=> $value['User']['current_wt'],										
					'followers_gender'	=> $value['User']['gender'],										
					'followers_location'	=> $location_name,										
					'followers_profile_image'	=> $profile_image,										
				);
			}
		}		
		//echo "<pre>";print_r($response);die;
		echo json_encode($response);exit;					
	}
	
	//http://dev414.trigma.us/N-162/Webservices/user_following?user_id=1&follower_id=56
	public function user_following ()
	{
		$user_id			=	$_REQUEST['user_id'];
		$follower_id	=	$_REQUEST['follower_id'];
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
					'Following'	=> array ('User'	=> array ('id','name','email','usertype_id','register_date','contact','birthday','current_wt','gender','location','profile_image')),
					'Follower'	=> array (
						'User'		=> array (
							'id','name','email','usertype_id','register_date','contact','birthday','current_wt','gender','location','profile_image'
						),
						'Follower1' => array (
							'id','name','email','usertype_id','register_date','contact','birthday','current_wt','gender','location','profile_image'
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
			$location_name	=	$this->get_location ($value['User']['id']);
			$follower_status	=	$group		=	$this->UserFollower->find ('count',array('conditions' =>array('UserFollower.follower_id'=>$user_id,'UserFollower.user_id'=>$follower_id)));
			if ($follower_status == 0) {
				$follower_status	=	'No';
			}  else  {
				$follower_status	=	'Yes';
			}
			$profile_image	=!empty ($value['User']['profile_image']) ? FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$value['User']['profile_image'] : '';
			$response['data'][]			=	array(
				'id'					=> $id,
				'name'				=> $name,										
				'follower_status'	=> $follower_status,										
				'following_id'		=> $value['User']['id'],										
				'following_name'	=> $value['User']['name'],										
				'following_email'	=> $value['User']['email'],										
				'following_birthday'	=> $value['User']['birthday'],										
				'following_current_wt'	=> $value['User']['current_wt'],										
				'following_gender'	=> $value['User']['gender'],										
				'following_location'	=> $location_name,										
				'following_profile_image'	=> $profile_image,										
			);
		}
		echo json_encode($response);exit;								
	}
	
	
	/* ===================================== Follower Module End ======================================*/	
	/*  ------------------------------------------------------------------ Static Page Module Start ---------------------------------------------------------------*/
	
	
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
	
	
	/* ===================================== Static Page Module Start ===================================*/
	/* ------------------------------------------------------------------ Group Module Start  -----------------------------------------------------------------------*/
	
	
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
	
	//http://dev414.trigma.us/N-162/webservices/group_members?user_id=27&group_id=1
	public function group_members() 
	{
		$this->Group->virtualFields = array (
			'members'	=>'select count(*) from group_users as gu where Group.id = gu.group_id',
			'joined'		=>'select count(*) from group_users as gu where Group.id = gu.group_id and gu.user_id ='.$_REQUEST['user_id']
		);
		$groups		=	$this->Group->find ('first',array('conditions'=>array('Group.id'=>$_REQUEST['group_id']),'contain'=>array('GroupUser'=>array('User'))));
		//echo "<pre>";print_r ($groups);
		
		$response 	= array ('success'=>1,'message'=>'success.');
		if (!empty($groups))  {
			$group_image	=	!empty ($groups['Group']['group_image']) ? FULL_BASE_URL.$this->webroot.'files' . DS . 'Group'. DS .$groups['Group']['group_image'] : '';
			$joined				=	$groups['Group']['joined'] ;
			if ($joined == 0) {
				$join = 'No';
			}  else {
				$join = 'Yes';
			}
			
			// $response['data']['group_id']	=	$groups['Group']['id'];
			// $response['data']['group_name']	=	$groups['Group']['group_name'];
			// $response['data']['role']	=	$groups['Group']['role'];
			// $response['data']['description']	=	$groups['Group']['description'];
			// $response['data']['members']	=	$groups['Group']['members'];
			// $response['data']['group_image']	=	$group_image;
			// $response['data']['join']	=	$join;
			
			foreach($groups['GroupUser'] as $info) {
				$location_name	=	$this->get_location ($info['User']['id']);
				$profile_image	=	!empty ($info['User']['profile_image']) ? FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$info['User']['profile_image'] : '';
				$response['data'][]	=	array(
					'group_id'			=> $groups['Group']['id'],
					'user_id'			=> $info['User']['id'],
					'user_name'	=> $info['User']['name'],
					'birthday'			=> $info['User']['birthday'],
					'age'				=> date_diff(date_create($info['User']['birthday']), date_create(date('y-m-d')))->y,	
					'current_wt'		=> $info['User']['current_wt'],
					'gender'			=> $info['User']['gender'],
					'location'			=> $location_name,
					'profile_image'	=>$profile_image
				 );
			}
			if (empty($response))  {
				$response = array ('success'=>0,'message'=>'data not found.');
				echo json_encode($response);exit;
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
		$description		=	$this->Group->find ('first',array('conditions' =>array('Group.id' =>$id),'contain'=>array('GroupUser' =>array('User'))));
		if(!empty($description))  {
			foreach($description['GroupUser']as $key => $val)  {
				$data [] = array(
					'id' 		=> $val['User']['id'],
					'name' 	=> $val['User']['name'],
					'image'	=> FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$val['User']['profile_image']
				);
			} 
			if (empty($data))  {
				$data = array();
			}
			$group_image	=	!empty ($description['Group']['group_image']) ? FULL_BASE_URL.$this->webroot.'files' . DS . 'Group'. DS .$description['Group']['group_image'] : '';
			$response		= 	array('success'=>1,'message'=>'success.');
			$response['data']	=	array(
				'group_id'		=> $description['Group']['id'],
				'group_name'	=> $description['Group']['group_name'],
				'description'	=> $description['Group']['description'],
				'rule'				=> $description['Group']['role'],
				'members'		=> $description['Group']['members'],
				'group_users'	=>$data,
				'group_image'	=>$group_image,
				'date'				=> $description['Group']['date'],
			);
			echo json_encode($response);exit;
		}  else {
			$response = array ('success'=>0,'message'=>'No any blog found.');
			echo json_encode($response);exit;
		}
		exit;
	}
	
	
	/* ===================================== Group Module End ========================================*/	
	/* ------------------------------------------------------------------  Post Module Start -------------------------------------------------------------------------*/
	
	
	//http://dev414.trigma.us/N-162/Webservices/photo_post?user_id=4444&post_status=Public&photo=photo.png&description=sdafsfaf
	public function photo_post ()  
	{
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
	public function before_after_post ()  
	{
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
	public function text_post () 
	{
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
	public function quote_post ()  
	{
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
		
	//http://dev414.trigma.us/N-162/Webservices/browse_post?user_id=27&post_status=Public
	public function browse_post ()  
	{
		 $this->loadModel('User');
		$user_id				=	$_REQUEST['user_id'];
		$post_status		=	$_REQUEST['post_status'];
		$this->Post->virtualFields = array (
			'inspired' 		=> 'SELECT count(*) FROM post_inspiredes WHERE Post.id=post_inspiredes.post_id',
			'comments' 	=> 'SELECT count(*) FROM post_comments WHERE Post.id=post_comments.post_id',
			'like_status'	=>'SELECT count(*) FROM post_inspiredes WHERE Post.id =post_inspiredes.post_id and post_inspiredes.user_id='.$user_id.''
		);

		if ($post_status == 'Public')  {
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
					'order'	=> array ('Post.id desc'),
					'conditions' => array ('Post.status'=>'Public')
				)
			);
		}  else  {
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
					'order'	=> array ('Post.id desc'),
					'conditions' => array ('Post.user_id'=>$user_id)
				)
			);
		}
		//echo "<pre>";print_r ($posts);die;
		
		$response = array('success'=>1,'msg'=>'success.');
		foreach ($posts as $post)  {
			
			/* Lat Long Api Start */
			//echo $post['Post']['user_id'];die;
			$user_data_post = $this->User->find('first',array('conditions' =>array('User.id' =>$post['Post']['user_id'])));
			//echo "<pre>";print_r ($user_data_post);die;
			$url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($user_data_post['User']['lat']).','.trim($user_data_post['User']['long']).'&sensor=false';
			$json = @file_get_contents($url);
			$data=json_decode($json);
			//echo $data;die;
			$status = $data->status;
			//echo $status;die;
			if($status=="OK")  {
			   $data_post = $data->results[0]->formatted_address;
			}  else  {
			   $data_post = 'Not Available';
			}
			//echo $data_post;die;
			/* Lat Long Api End */
			
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
						'status'				=> $post['Post']['status'],
						'location' =>$data_post,
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
						'location' =>$data_post,
						'description'		=> $post['PostBeforeAfter']['description'],
						'status'				=> $post['Post']['status'],
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
						'location' =>$data_post,
						'description'		=> $post['PostText']['text'],
						'status'				=> $post['Post']['status'],
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
						'location' =>$data_post,
						'description'		=> $post['PostQuote']['quote'],
						'status'				=> $post['Post']['status'],
						'date'					=> date('d M Y ',strtotime($post['PostQuote']['date']))
					);				
					
				}
			//}
		}		
		
		if (empty($response['data']))  {
			$response = array('success'=>0,'msg'=>'No post found.');
		}
		echo json_encode ($response);exit;
	}
	
	//http://dev414.trigma.us/N-162/Webservices/post_inspiredes?user_id=27&post_id=50&receiver_id=45
	public function post_inspiredes ()  
	{
		$this->autoRender =false;
		$this->loadModel ('NotificationTypeUser'); 
		$user_id			=	$_REQUEST['user_id'];
		$post_id			=	$_REQUEST['post_id'];
		$receiver_id	=	$_REQUEST['receiver_id'];
		//$post_user	=	$_REQUEST['post_user'];
		$this->User->id = $receiver_id;
		if(!$this->User->exists())	{
			$response = array('success'=>0,'message'=>'Receiver not exist');exit;
		}
		
		$this->User->id = $_REQUEST['user_id'];
		if(!$this->User->exists())	{
			$response = array('success'=>0,'message'=>'Sender not exist');exit;
		}
				
		if ($post_id == '' or $user_id == '')  {
			$response[] = array('success'=>0,'msg'=>'Wrong request.');
			echo json_encode ($response);exit;		
		}
		$count 	= 	$this->PostInspirede->find ('count',array('conditions'=>array('PostInspirede.post_id'=>$post_id,'PostInspirede.user_id'=>$user_id)));
		if ($count == 0)  {
			$data['PostInspirede']['user_id']		=	$_REQUEST['user_id'];
			$data['PostInspirede']['post_id']		=	$_REQUEST['post_id'];
			$data['PostInspirede']['date']			=	date('Y-m-d');	
			//$post_user_data = $this->User->find('first',array('conditions' =>array('User.id' =>$post_user)));
			if ($this->PostInspirede->save($data))  {
				
				/* NotificationTypeUser */
				$typeUser['NotificationTypeUser']['user_chat_id']				=	0;
				$typeUser['NotificationTypeUser']['post_id']							=	$post_id;
				$typeUser['NotificationTypeUser']['receiver_id']					=	$receiver_id;
				$typeUser['NotificationTypeUser']['sender_id']						=	$user_id;
				$typeUser['NotificationTypeUser']['notification_type_id']		=	1;
				$typeUser['NotificationTypeUser']['date']								=	date('Y-m-d');	
				$this->NotificationTypeUser->save($typeUser);
				/*  NotificationTypeUser */
				/* Notification code Start*/
				$path 					= WWW_ROOT.'ck.pem';				
				$receiver			=	$this->User->find ('first',array('conditions'=>array('User.id'=>$_REQUEST['receiver_id']),'contain'=>array(),'fields'=>array('id','name','device_token','user_notification')));
				$sender				=	$this->User->find ('first',array('conditions'=>array('User.id'=>$_REQUEST['user_id']),'contain'=>array(),'fields'=>array('id','name')));
				//echo "<pre>";print_r ($receiver);
				//echo "<pre>";print_r ($sender);die;
				if ($receiver['User']['user_notification']  == 'Yes')  {
					
					$message		=	$sender['User']['name'].' like your Post';
					$passphrase 	= '123456';
					
					if (@$receiver['User']['device_token'] != '') {
						$deviceToken	=	$receiver['User']['device_token'];
					}  else  {
						$deviceToken	=	'';
					}
					//$deviceToken	=	'a3afe7ab458c454306eae1e1f5bcf1080ebe775931258f5a6a10d14d29e0a6e8';
					
					// Create a Stream
					$ctx = stream_context_create();
					// Define the certificate to use 
					stream_context_set_option($ctx, 'ssl', 'local_cert',$path);	
					// Passphrase to the certificate
					stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);	
					
					// Open a connection to the APNS server
					$fp 	= stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT,$ctx);
					//echo $fp;die;
					// Check that we've connected
					if (!$fp) {
						exit("Failed to connect: $err $errstr" . PHP_EOL);
					} 
					
					$body['aps'] 	= array ('alert' => $message,'type' =>  'text','sound' => 'default');
					$name1			= 'Daily Reminders Notification';
					$body['data'] 	= array ('id' => 123,'name' => $name1,'status'=>0,'user_id'=>$sender['User']['id'],'user_name'=>$sender['User']['name']);

					$payload = json_encode($body);
					$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
					
					// Send it to the server
					$result = fwrite($fp, $msg, strlen($msg));
					
					if (!$result) {	
						//return 0; 
						$response 	= array('success'=>0,'msg'=>'Error in notification.');
						echo json_encode ($response);exit;	
						fclose ($fp);						
					}  else  {
						//return 1;					
						fclose($fp);
					}	
				}
				/* Notification code End*/
				
				$response 	= array('success'=>1,'msg'=>'Success.');
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
	
	//http://dev414.trigma.us/N-162/Webservices/post_comments?user_id=27&post_id=50&comment=djsdgkjdfkj&receiver_id=45
	public function post_comments ()  
	{
		$this->loadModel ('NotificationTypeUser');
		$user_id			=	$_REQUEST['user_id'];
		$receiver_id	=	$_REQUEST['receiver_id'];
		$post_id			=	$_REQUEST['post_id'];
		$comment		=	$_REQUEST['comment'];
		
		if ($post_id == '' or $user_id == '' or $comment == '')  {
			$response[] = array('success'=>0,'msg'=>'Wrong request.');
			echo json_encode ($response);exit;		
		}
		
		$data['PostComment']['user_id']		=	$_REQUEST['user_id'];
		$data['PostComment']['post_id']		=	$_REQUEST['post_id'];
		$data['PostComment']['comment']	=	$_REQUEST['comment'];
		$data['PostComment']['date']				=	date('Y-m-d');
		
		if ($this->PostComment->save($data))  {	
		
			/* NotificationTypeUser */
				$typeUser['NotificationTypeUser']['user_chat_id']				=	0;
				$typeUser['NotificationTypeUser']['post_id']							=	$post_id;
				$typeUser['NotificationTypeUser']['receiver_id']					=	$receiver_id;
				$typeUser['NotificationTypeUser']['sender_id']						=	$user_id;
				$typeUser['NotificationTypeUser']['notification_type_id']		=	2;
				$typeUser['NotificationTypeUser']['date']								=	date('Y-m-d');	
				$this->NotificationTypeUser->save($typeUser);
			/*  NotificationTypeUser */
			/* Notification code Start*/
			$path 					= WWW_ROOT.'ck.pem';				
			$receiver			=	$this->User->find ('first',array('conditions'=>array('User.id'=>$_REQUEST['receiver_id']),'contain'=>array(),'fields'=>array('id','name','device_token','user_notification')));
			$sender				=	$this->User->find ('first',array('conditions'=>array('User.id'=>$_REQUEST['user_id']),'contain'=>array(),'fields'=>array('id','name')));
			//echo "<pre>";print_r ($receiver);die;
			if ($receiver['User']['user_notification']  == 'Yes')  {
				
				$message		=	$sender['User']['name'].' comment your Post';
				$passphrase 	= '123456';
				
				if (@$receiver['User']['device_token'] != '') {
					$deviceToken	=	$receiver['User']['device_token'];
				}  else  {
					$deviceToken	=	'';
				}
				//$deviceToken	=	'a3afe7ab458c454306eae1e1f5bcf1080ebe775931258f5a6a10d14d29e0a6e8';
				
				// Create a Stream
				$ctx = stream_context_create();
				// Define the certificate to use 
				stream_context_set_option($ctx, 'ssl', 'local_cert',$path);	
				// Passphrase to the certificate
				stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);	
				
				// Open a connection to the APNS server
				$fp 	= stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT,$ctx);
				//echo $fp;die;
				// Check that we've connected
				if (!$fp) {
					exit("Failed to connect: $err $errstr" . PHP_EOL);
				} 
				
				$body['aps'] 	= array ('alert' => $message,'type' =>  'text','sound' => 'default');
				$name1			= 'Daily Reminders Notification';
				$body['data'] 	= array ('id' => 123,'name' => $name1,'status'=>0,'user_id'=>$sender['User']['id'],'user_name'=>$sender['User']['name']);

				$payload = json_encode($body);
				$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
				
				// Send it to the server
				$result = fwrite($fp, $msg, strlen($msg));
				
				if (!$result) {	
					//return 0; 
					$response 	= array('success'=>0,'msg'=>'Error in notification.');
					echo json_encode ($response);exit;	
					fclose ($fp);						
				}  else  {
					//return 1;					
					fclose($fp);
				}	
			}
			/* Notification code End*/
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
		$response = array('success'=>0,'message'=>'Error.');
		echo json_encode($response);exit;					
	}
	

	/* ===================================== Post Module End =========================================*/
	/* ------------------------------------------------------------------ Track Module Start ----------------------------------------------------------------------- */
	
	//http://dev414.trigma.us/N-162/Webservices/my_goals?user_id=29
	public function my_goals () 
	{
		//echo exec('ffmpeg -version');die;
		$user	=	$this->User->find (
			'first',array (
				'conditions'	=> array (
					'User.id'	=> $_REQUEST['user_id']
				),
				'fields'			=> array (
					'id','name','profile_image','starting_wt','current_wt','goal_wt'
				),
				'contain'		=> array (
					'NotificationUser'	=> array(
						'Notification'
					)
				)
			)
		);		
		
		//echo "<pre>";print_r ($user);die;
		if (empty($user))  {
			$response = array('success'=>0,'message'=>'User info not found.');
			echo json_encode($response);exit;		
		}
	
		$highest_weight	=	$user['User']['highest_weight'];		
		if ($highest_weight == '')  {
			$highest_weight	=	'';
		}
		
		$last_night					=	$this->GoalsWeight->find ('first',array('conditions'=>array('GoalsWeight.user_id'=>$_REQUEST['user_id']),'order'=>array('GoalsWeight.id desc')));
		
		$response = array('success'=>1,'message'=>'success.');
		$response['data'][]	=	array(
			'user_id'					=> $user['User']['id'],															
			'starting_wt'			=> $user['User']['starting_wt'],															
			'current_wt'				=> $user['User']['current_wt'],															
			'highest_weight'	=> $highest_weight,															
			'last_night_weight'				=> $last_night['GoalsWeight']['current_weight'],															
			'goal_wt'					=> $user['User']['goal_wt'],															
		);
		echo json_encode($response);exit;			
	}
	
	//http://dev414.trigma.us/N-162/Webservices/user_weight?user_id=29
	public function user_weight () 
	{
		$this->User->virtualFields = array(
			'highest_weight'=>'SELECT max(goals_weights.current_weight) FROM goals_weights where User.id=goals_weights.user_id'
		);
		
		$user	=	$this->User->find ('first',array('conditions'=>array('User.id'=>$_REQUEST['user_id']),'contain'=>array()));		
		if (empty($user))  {
			$response = array('success'=>0,'message'=>'User info not found.');
			echo json_encode($response);exit;		
		}
	
		$highest_weight	=	$user['User']['highest_weight'];		
		if ($highest_weight == '')  {
			$highest_weight	=	'';
		}
		
		$last_night					=	$this->GoalsWeight->find ('first',array('offset'=>'1','conditions'=>array('GoalsWeight.user_id'=>$_REQUEST['user_id']),'order'=>array('GoalsWeight.id desc')));
		//echo "<pre>";print_r ($last_night);die;
		if (@$last_night['GoalsWeight']['current_weight'] == '')  {
			$last_night_weight	= '';
		}
		$response = array('success'=>1,'message'=>'success.');
		$response['data'][]	=	array(
			'user_id'					=> $user['User']['id'],															
			'starting_wt'			=> $user['User']['starting_wt'],															
			'current_wt'				=> $user['User']['current_wt'],															
			'highest_weight'	=> $highest_weight,															
			'last_night_weight'				=> $last_night_weight,															
			'goal_wt'					=> $user['User']['goal_wt'],															
		);
		echo json_encode($response);exit;			
	}
	
	//http://dev414.trigma.us/N-162/Webservices/track_weight?user_id=29&current_wt=56&goal_wt=400
	public function track_weight () 
	{
		$user_id			=	$_REQUEST['user_id'];
		$current_wt	=	$_REQUEST['current_wt'];
		$goal_wt		=	$_REQUEST['goal_wt'];
		
		$curdate			= date ('Y-m-d');
		$last_night		=	$this->GoalsWeight->find ('first',array('conditions'=>array('GoalsWeight.user_id'=>$user_id,'GoalsWeight.date'=>$curdate)));		
		if (!empty($last_night))  {
			$response = array('success'=>1,'message'=>'Weight already set .');
			echo json_encode ($response);exit;			
		}
		
		$this->User->id					=	$user_id;
		$data['User']['current_wt']	=	$current_wt;
		$data['User']['goal_wt']		=	$goal_wt;
		if ($this->User->save($data))  {			
			$goal_weight['GoalsWeight']['user_id']					=	$user_id;
			$goal_weight['GoalsWeight']['current_weight']		=	$current_wt;
			$goal_weight['GoalsWeight']['goal_weight']			=	$goal_wt;
			$goal_weight['GoalsWeight']['date']						=	date('Y-m-d-g:i:s');
			if ($this->GoalsWeight->save($goal_weight))  {	
				$response = array('success'=>1,'message'=>'Success.');
				echo json_encode ($response);exit;			
			}   	
		}
		
		$response = array('success'=>0,'message'=>'Error.');
		echo json_encode ($response);exit;	
	}
	
	//http://dev414.trigma.us/N-162/Webservices/user_sleep?user_id=29
	public function user_sleep () 
	{
		$this->User->virtualFields = array(
			'average_sleep'=>'SELECT avg(goal_sleeps.total_sleep) FROM goal_sleeps where User.id=goal_sleeps.user_id',
			'previous_sleep'=>'SELECT total_sleep FROM `goal_sleeps` where User.id=goal_sleeps.user_id order by id desc limit 1',
		);
		
		$user	=	$this->User->find ('first',array('conditions'=>array('User.id'=>$_REQUEST['user_id']),'contain'=>array()));		
		if (empty($user))  {
			$response = array('success'=>0,'message'=>'User info not found.');
			echo json_encode($response);exit;		
		}
	
		$average_sleep	=	$user['User']['average_sleep'];		
		$previous_sleep	=	$user['User']['previous_sleep'];		
		if ($average_sleep == '')  {
			$average_sleep	=	'';
		}
		if ($previous_sleep == '')  {
			$previous_sleep	=	'';
		}
		$response = array('success'=>1,'message'=>'success.');
		$response['data'][]	=	array(
			'user_id'					=> $user['User']['id'],															
			'goal_sleep'			=> $user['User']['goal_sleep'],															
			'previous_sleep'	=> $previous_sleep,															
			'average_sleep'	=> round($average_sleep,1)															
		);
		echo json_encode($response);exit;			
	}
	
	//http://dev414.trigma.us/N-162/Webservices/track_sleep?user_id=29&sleep_time=2015-12-17 10:42:00 PM&wake_time=2015-12-18 12:42:00 AM&goal_sleep=8
	public function track_sleep () 
	{
		$user_id			=	$_REQUEST['user_id'];
		$sleep_time	=	$_REQUEST['sleep_time'];
		$wake_time	=	$_REQUEST['wake_time'];		
		$curdate			= date ('Y-m-d');
		$last_night		=	$this->GoalSleep->find ('first',array('conditions'=>array('GoalSleep.user_id'=>$user_id,'GoalSleep.date'=>$curdate)));
		
		if (!empty($last_night))  {
			$response = array('success'=>1,'message'=>'Weight already set .');
			echo json_encode ($response);exit;			
		}	
		
		$to_time			= strtotime($sleep_time);
		$from_time 	= strtotime($wake_time);
		$total_sleep	= round(abs($to_time - $from_time) / (60*60),2);		
		
		$goal_sleep['GoalSleep']['user_id']			=	$user_id;
		$goal_sleep['GoalSleep']['sleep_time']		=	$sleep_time;
		$goal_sleep['GoalSleep']['wake_time']		=	$wake_time;
		$goal_sleep['GoalSleep']['total_sleep']		=	$total_sleep;
		$goal_sleep['GoalSleep']['date']					=	date('Y-m-d');
		if ($this->GoalSleep->save($goal_sleep))  {	
			$response = array('success'=>1,'message'=>'Success.');
			echo json_encode ($response);exit;			
		} 	
		$response = array('success'=>1,'message'=>'Error.');
		echo json_encode ($response);exit;	
	}	
	
	//http://dev414.trigma.us/N-162/webservices/foods
	public function foods () {
		$foods			=	$this->GoalFood->find ('all');
		//echo "<pre>";print_r($foods);die;
		$response 	= array ('success'=>1,'message'=>'success.');
		if (!empty($foods))  {
			foreach($foods as $info) {
				$food_image	=	!empty ($info['GoalFood']['image']) ? FULL_BASE_URL.$this->webroot.'files' . DS . 'Food'. DS .$info['GoalFood']['image'] : '';				
				$response['data'][]	=	array(
					'id'			=> $info['GoalFood']['id'],
					'name'		=> $info['GoalFood']['food_name'],
					'image'	=> $food_image,
				 );
			}
			echo json_encode ($response);exit;
		}
		$response 	= array ('success'=>0,'message'=>'error.');
		echo json_encode ($response);exit;
	}
		
	//http://dev414.trigma.us/N-162/webservices/foods_details?food_type=Breakfast
	public function foods_details () 
	{
		$food_type	=	$_REQUEST['food_type'];
		
		switch ($food_type)	 {
			case "Breakfast":
				
				$lunchs			=	$this->FoodBreakfast->find ('all');
				$response 	= array ('success'=>1,'message'=>'success.');
				if (!empty($lunchs))  {
					foreach($lunchs as $info) {
						$lunch_image	=	!empty ($info['FoodBreakfast']['image']) ? FULL_BASE_URL.$this->webroot.'files' . DS . 'Food'. DS .$info['FoodBreakfast']['image'] : '';				
						$response['data'][]	=	array(
							'id'			=> $info['FoodBreakfast']['id'],
							'name'		=> $info['FoodBreakfast']['name'],
							'image'	=> $lunch_image,
							'food_type'=>$food_type
						 );
					}
					echo json_encode ($response);exit;
				}
				break;
				
			case "Lunch":
			
				$lunchs		=	$this->FoodLunch->find ('all');
				$response 	= array ('success'=>1,'message'=>'success.');
				if (!empty($lunchs))  {
					foreach($lunchs as $info) {
						$lunch_image	=	!empty ($info['FoodLunch']['image']) ? FULL_BASE_URL.$this->webroot.'files' . DS . 'Food'. DS .$info['FoodLunch']['image'] : '';
						
						$response['data'][]	=	array(
							'id'			=> $info['FoodLunch']['id'],
							'name'		=> $info['FoodLunch']['name'],
							'image'	=> $lunch_image,
							'food_type'=>'Lunch'
						 );
					}
					echo json_encode ($response);exit;
				}
				break;
				
			case "Dinner":
			
				$lunchs		=	$this->FoodDinner->find ('all');
				$response 	= array ('success'=>1,'message'=>'success.');
				if (!empty($lunchs))  {
					foreach($lunchs as $info) {
						$lunch_image	=	!empty ($info['FoodDinner']['image']) ? FULL_BASE_URL.$this->webroot.'files' . DS . 'Food'. DS .$info['FoodDinner']['image'] : '';
						
						$response['data'][]	=	array(
							'id'			=> $info['FoodDinner']['id'],
							'name'		=> $info['FoodDinner']['name'],
							'image'	=> $lunch_image,
							'food_type'=>'Dinner'
						 );
					}
					echo json_encode ($response);exit;
				}
				$response = array ('success'=>0,'message'=>'data not found.');
				echo json_encode($response);exit;
				break;
				
			case "Snack":
			
				$lunchs		=	$this->FoodSnack->find ('all');
				$response 	= array ('success'=>1,'message'=>'success.');
				if (!empty($lunchs))  {
					foreach($lunchs as $info) {
						$lunch_image	=	!empty ($info['FoodSnack']['image']) ? FULL_BASE_URL.$this->webroot.'files' . DS . 'Food'. DS .$info['FoodSnack']['image'] : '';
						
						$response['data'][]	=	array(
							'id'			=> $info['FoodSnack']['id'],
							'name'		=> $info['FoodSnack']['name'],
							'image'	=> $lunch_image,
							'food_type'=>'Snack'
						 );
					}
					echo json_encode ($response);exit;
				}
				break;
				
			case "Water":
			
				$lunchs		=	$this->FoodWater->find ('all');
				$response 	= array ('success'=>1,'message'=>'success.');
				if (!empty($lunchs))  {
					foreach($lunchs as $info) {
						$lunch_image	=	!empty ($info['FoodWater']['image']) ? FULL_BASE_URL.$this->webroot.'files' . DS . 'Food'. DS .$info['FoodWater']['image'] : '';
						
						$response['data'][]	=	array(
							'id'			=> $info['FoodWater']['id'],
							'name'		=> $info['FoodWater']['name'],
							'image'	=> $lunch_image,
							'food_type'=>'Water'
						 );
					}
					echo json_encode ($response);exit;
				}
				break;
				
			case "My Recipes":
				$goal_food_id  = 6;
				break;
		}		
		$response = array ('success'=>0,'message'=>'data not found.');
		echo json_encode($response);exit;
	}

	//http://dev414.trigma.us/N-162/Webservices/user_food?user_id=29&food_type=1
	public function user_food () 
	{
		$curdate				= date ('Y-m-d');
		$user_id				=	$_REQUEST['user_id'];
		$goal_food_id	=	$_REQUEST['food_type'];

		$user_today_foods	=	$this->GoalFoodUser->find (
			'first',array (
				'conditions'	=> array(
					'GoalFoodUser.user_id'	=> $user_id,
					'GoalFoodUser.goal_food_id'	=> $goal_food_id,
					'GoalFoodUser.date'		=> $curdate,
				),
				'contain'	=> array(
					'User'	=>array('fields'	=>array('User.id','User.name','User.usertype_id','User.profile_image')),
					'GoalFood'	=>array ('FoodBreakfast','FoodLunch','FoodDinner','FoodSnack','FoodWater','FoodMyRecipe'),
					'Phase'
				)
			)
		);	
		//echo "<pre>"; print_r($user_today_foods);die;
				
		switch ($goal_food_id)	 {
			case 1:
			if (!empty($user_today_foods['GoalFoodUser']['food']))  {
				$lunch	=	explode(',',$user_today_foods['GoalFoodUser']['food']);
			}  else  {
				$lunch	=	array ();
			}	
		
			$response = array('success'=>1,'message'=>'success.','user_id'=> $user_id);
			if (!empty($user_today_foods['GoalFood']['FoodBreakfast']))  {
				foreach ($user_today_foods['GoalFood']['FoodBreakfast'] as $breakfst)  {
					if (in_array($breakfst['id'],$lunch))  	{   $status = 'Yes';  }  else  {  $status  =  'No';  }
					$response['data'][]	=	array (																
						'id'			=> $breakfst['id'],		
						'name'		=> $breakfst['name'],		
						'image'	=>  FULL_BASE_URL.$this->webroot.'files'.DS.'Food'.DS.$breakfst['image'],
						'status'	=> $status	
					);
					$status	=	'';				
				}
			}  else  {
				$this->loadModel('FoodBreakfast');
				$food_breakfast	=	$this->FoodBreakfast->find ('all');
				foreach ($food_breakfast as $breakfst1)  {
					$status  =  'No';  
					$response['data'][]	=	array (																
						'id'			=> $breakfst1['FoodBreakfast']['id'],		
						'name'		=> $breakfst1['FoodBreakfast']['name'],		
						'image'	=>  FULL_BASE_URL.$this->webroot.'files'.DS.'Food'.DS.$breakfst1['FoodBreakfast']['image'],
						'status'	=> $status	
					);
					$status	=	'';				
				}
			}
			echo json_encode($response);exit;	
			break;
		case 2:				
			if (!empty($user_today_foods['GoalFoodUser']['food']))  {
				$lunch	=	explode(',',$user_today_foods['GoalFoodUser']['food']);
			}  else  {
				$lunch	=	array ();
			}
			$response = array('success'=>1,'message'=>'success.','user_id'=> $user_id);
			if (!empty($user_today_foods['GoalFood']['FoodLunch'])) {
				foreach ($user_today_foods['GoalFood']['FoodLunch'] as $lnch)  {
					if (in_array($lnch['id'],$lunch))  	{   $status = 'Yes';  }  else  {  $status  =  'No';  }
					$response['data'][]	=	array (																
						'id'			=> $lnch['id'],		
						'name'		=> $lnch['name'],		
						'image'	=>  FULL_BASE_URL.$this->webroot.'files'.DS.'Food'.DS.$lnch['image'],
						'status'	=> $status	
					);
					$status	=	'';				
				}  
			}  else  {
				$this->loadModel('FoodLunch');
				$FoodLunch	=	$this->FoodLunch->find ('all');
				foreach ($FoodLunch as $FoodLunch1)  {
					$status  =  'No';  
					$response['data'][]	=	array (																
						'id'			=> $FoodLunch1['FoodLunch']['id'],		
						'name'		=> $FoodLunch1['FoodLunch']['name'],		
						'image'	=>  FULL_BASE_URL.$this->webroot.'files'.DS.'Food'.DS.$FoodLunch1['FoodLunch']['image'],
						'status'	=> $status	
					);
					$status	=	'';				
				}
			
			}
			echo json_encode($response);exit;	
			break;
		case 3:
			if (!empty($user_today_foods['GoalFoodUser']['food']))  {
				$lunch	=	explode(',',$user_today_foods['GoalFoodUser']['food']);
			}  else  {
				$lunch	=	array ();
			}
			$response = array('success'=>1,'message'=>'success.','user_id'=> $user_id);
			if (!empty($user_today_foods['GoalFood']['FoodDinner'])) {
				foreach ($user_today_foods['GoalFood']['FoodDinner'] as $dnner)  {
					if (in_array($dnner['id'],$lunch))  	{   $status = 'Yes';  }  else  {  $status  =  'No';  }
					$response['data'][]	=	array (																
						'id'			=> $dnner['id'],		
						'name'		=> $dnner['name'],		
						'image'	=>  FULL_BASE_URL.$this->webroot.'files'.DS.'Food'.DS.$dnner['image'],
						'status'	=> $status	
					);
					$status	=	'';				
				}
			}  	else  {
				$this->loadModel('FoodDinner');
				$FoodLunch	=	$this->FoodDinner->find ('all');
				foreach ($FoodLunch as $FoodLunch1)  {
					$status  =  'No';  
					$response['data'][]	=	array (																
						'id'			=> $FoodLunch1['FoodDinner']['id'],		
						'name'		=> $FoodLunch1['FoodDinner']['name'],		
						'image'	=>  FULL_BASE_URL.$this->webroot.'files'.DS.'Food'.DS.$FoodLunch1['FoodDinner']['image'],
						'status'	=> $status	
					);
					$status	=	'';				
				}
			}
			echo json_encode($response);exit;	
			break;
		case 4:
			if (!empty($user_today_foods['GoalFoodUser']['food']))  {
				$lunch	=	explode(',',$user_today_foods['GoalFoodUser']['food']);
			}  else  {
				$lunch	=	array ();
			}
			$response = array('success'=>1,'message'=>'success.','user_id'=> $user_id);
			if (!empty($user_today_foods['GoalFood']['FoodSnack'])) {
				foreach ($user_today_foods['GoalFood']['FoodSnack'] as $dnner)  {
					if (in_array($dnner['id'],$lunch))  	{   $status = 'Yes';  }  else  {  $status  =  'No';  }
					$response['data'][]	=	array (																
						'id'			=> $dnner['id'],		
						'name'		=> $dnner['name'],		
						'image'	=>  FULL_BASE_URL.$this->webroot.'files'.DS.'Food'.DS.$dnner['image'],
						'status'	=> $status	
					);
					$status	=	'';				
				}
			}  else  {
				$this->loadModel('FoodSnack');
				$FoodLunch	=	$this->FoodSnack->find ('all');
				foreach ($FoodLunch as $FoodLunch1)  {
					$status  =  'No';  
					$response['data'][]	=	array (																
						'id'			=> $FoodLunch1['FoodSnack']['id'],		
						'name'		=> $FoodLunch1['FoodSnack']['name'],		
						'image'	=>  FULL_BASE_URL.$this->webroot.'files'.DS.'Food'.DS.$FoodLunch1['FoodSnack']['image'],
						'status'	=> $status	
					);
					$status	=	'';				
				}
			}
			echo json_encode($response);exit;	
			break;
		case 5:
			if (!empty($user_today_foods['GoalFoodUser']['food']))  {
				$lunch	=	explode(',',$user_today_foods['GoalFoodUser']['food']);
			}  else  {
				$lunch	=	array ();
			}
			$response = array('success'=>1,'message'=>'success.','user_id'=> $user_id);
			if (!empty($user_today_foods['GoalFood']['FoodWater'])) {
				foreach ($user_today_foods['GoalFood']['FoodWater'] as $dnner)  {
					if (in_array($dnner['id'],$lunch))  	{   $status = 'Yes';  }  else  {  $status  =  'No';  }
					$response['data'][]	=	array (																
						'id'			=> $dnner['id'],		
						'name'		=> $dnner['name'],		
						'image'	=>  FULL_BASE_URL.$this->webroot.'files'.DS.'Food'.DS.$dnner['image'],
						'status'	=> $status	
					);
					$status	=	'';				
				}
			}   else   {
				$this->loadModel('FoodWater');
				$FoodLunch	=	$this->FoodWater->find ('all');
				foreach ($FoodLunch as $FoodLunch1)  {
					$status  =  'No';  
					$response['data'][]	=	array (																
						'id'			=> $FoodLunch1['FoodWater']['id'],		
						'name'		=> $FoodLunch1['FoodWater']['name'],		
						'image'	=>  FULL_BASE_URL.$this->webroot.'files'.DS.'Food'.DS.$FoodLunch1['FoodWater']['image'],
						'status'	=> $status	
					);
					$status	=	'';				
				}
			}
			echo json_encode($response);exit;	
			break;
		case 6:
			if (!empty($user_today_foods['GoalFoodUser']['food']))  {
				$lunch	=	explode(',',$user_today_foods['GoalFoodUser']['food']);
			}  else  {
				$lunch	=	array ();
			}
			$response = array('success'=>1,'message'=>'success.','user_id'=> $user_id);
			if (!empty($user_today_foods['GoalFood']['FoodMyRecipe'])) {
				foreach ($user_today_foods['GoalFood']['FoodMyRecipe'] as $dnner)  {
					if (in_array($dnner['id'],$lunch))  	{   $status = 'Yes';  }  else  {  $status  =  'No';  }
					$response['data'][]	=	array (																
						'id'			=> $dnner['id'],		
						'name'		=> $dnner['name'],		
						'image'	=>  FULL_BASE_URL.$this->webroot.'files'.DS.'Food'.DS.$dnner['image'],
						'status'	=> $status	
					);
					$status	=	'';				
				}
			}   else  {
				$this->loadModel('FoodMyRecipe');
				$FoodLunch	=	$this->FoodMyRecipe->find ('all');
				foreach ($FoodLunch as $FoodLunch1)  {
					$status  =  'No';  
					$response['data'][]	=	array (																
						'id'			=> $FoodLunch1['FoodMyRecipe']['id'],		
						'name'		=> $FoodLunch1['FoodMyRecipe']['name'],		
						'image'	=>  FULL_BASE_URL.$this->webroot.'files'.DS.'Food'.DS.$FoodLunch1['FoodMyRecipe']['image'],
						'status'	=> $status	
					);
					$status	=	'';				
				}
			}
			echo json_encode($response);exit;	
			break;
		}			
		$response = array('success'=>0,'message'=>'error.');		
	} 
	
	//http://dev414.trigma.us/N-162/Webservices/track_food?user_id=29&phase_id=1&food_type=1&food=1,3,4
	public function track_food () 
	{
	   $this->loadModel('GoalFoodUser');
		$user_id				=	$_REQUEST['user_id'];
		$phase_id			=	$_REQUEST['phase_id'];
		$goal_food_id	=	$_REQUEST['food_type'];
		$food					=	$_REQUEST['food'];
		$date					=	date('Y-m-d');	
		
		$user_today_foods	=	$this->GoalFoodUser->find (
			'first',array (
				'conditions'	=> array(
					'GoalFoodUser.user_id'	=> $user_id,
					'GoalFoodUser.goal_food_id'	=> $goal_food_id,
					'GoalFoodUser.date'		=> $date,
				),
				'contain'	=> array()
			)
		);	
		//echo "<pre>"; print_r($user_today_foods);die;
		if (empty($user_today_foods))  {
			$goal_food['GoalFoodUser']['user_id']				=	$user_id;
			$goal_food['GoalFoodUser']['phase_id']			=	$phase_id;
			$goal_food['GoalFoodUser']['goal_food_id']	=	$goal_food_id;
			$goal_food['GoalFoodUser']['food']					=	$food;
			$goal_food['GoalFoodUser']['date']					=	$date;
			
			$this->GoalFoodUser->create ();
			if ($this->GoalFoodUser->save($goal_food))  {
				$response = array('success'=>1,'message'=>'success.');
				echo json_encode ($response);exit;	
			}
		}  else {
			$this->GoalFoodUser->deleteAll (array('GoalFoodUser.user_id' => $user_id,'GoalFoodUser.date' => $date));
			$goal_food['GoalFoodUser']['user_id']				=	$user_id;
			$goal_food['GoalFoodUser']['phase_id']			=	$phase_id;
			$goal_food['GoalFoodUser']['goal_food_id']	=	$goal_food_id;
			$goal_food['GoalFoodUser']['food']					=	$food;
			$goal_food['GoalFoodUser']['date']					=	$date;
			
			$this->GoalFoodUser->create ();
			if ($this->GoalFoodUser->save($goal_food))  {
				$response = array('success'=>1,'message'=>'success.');
				echo json_encode ($response);exit;	
			}
		}
		$response = array('success'=>0,'message'=>'error.');
		echo json_encode ($response);exit;	
	}
	
	//http://dev414.trigma.us/N-162/Webservices/user_supplement?user_id=4
	public function user_supplement () 
	{
		$curdate		= date ('Y-m-d');
		$user_id		=	$_REQUEST['user_id'];
		$user_supplement	=	$this->GoalActivityUser->query ("
			select goal_supplement_id,supplement_name,image, 'Yes'as Status from goal_supplement_users gu inner join goal_supplements g on g.id=gu.goal_supplement_id where user_id=".$user_id." and gu.date='".$curdate."' union select id,supplement_name,image, 'No' as Status from goal_supplements where id not in (select goal_supplement_id from goal_supplement_users where user_id=".$user_id." and date=".$curdate.")"
		);
		//echo "<pre>";print_r ($user_supplement);die;
		$i = array();
		$response = array('success'=>1,'message'=>'success.');
		foreach($user_supplement as $key=>$value) {			
			if (in_array($value[0]['goal_supplement_id'],$i))  {
				
			}   else  {
				array_push ($i,$value[0]['goal_supplement_id']);
				$response['data'][]			=	array(
					'id'			=> $value[0]['goal_supplement_id'],
					'name'		=> $value[0]['supplement_name'],
					'image'	=> $value[0]['image'],
					'status'	=> $value[0]['Status'],																			
				);
			}
		}		
		$this->array_sort_by_column($response['data'], 'id');	
		//	echo "<pre>";print_r ($response);die;
		echo json_encode($response);exit;			
	}
	
	//http://dev414.trigma.us/N-162/Webservices/track_supplement?user_id=29&supplement=1,3,4
	public function track_supplement() 
	{
		$user_id				=	$_REQUEST['user_id'];
		$supplement		=	$_REQUEST['supplement'];
		$curdate				=	date('Y-m-d');
		$supplement		=	explode (',',$supplement);
		$exist = $this->GoalSupplementUser->find (
			'first',array(
				'conditions'	=> array (
					'AND'		=> array (
						'GoalSupplementUser.user_id'						=>$user_id,
						'GoalSupplementUser.date'							=>$curdate
					)
				)
			)
		);
		
		if (empty($exist))  {
			for ($i=0;$i<count($supplement);$i++)  {						
				if (empty($exist))	{
					$goal_supplement['GoalSupplementUser']['user_id']							=	$user_id;
					$goal_supplement['GoalSupplementUser']['goal_supplement_id']	=	$supplement[$i];
					$goal_supplement['GoalSupplementUser']['date']								=	$curdate;
					
					$this->GoalSupplementUser->create ();
					$this->GoalSupplementUser->save($goal_supplement);
				}  
			}
		} else  {
			$this->GoalSupplementUser->deleteAll (array('GoalSupplementUser.user_id' => $user_id,'GoalSupplementUser.date' => $curdate));
			for ($i=0;$i<count($supplement);$i++)  {		
				$goal_supplement1['GoalSupplementUser']['user_id']						=	$user_id;
				$goal_supplement1['GoalSupplementUser']['goal_supplement_id']	=	$supplement[$i];
				$goal_supplement1['GoalSupplementUser']['date']								=	$curdate;
				
				$this->GoalSupplementUser->create ();
				$this->GoalSupplementUser->save($goal_supplement1);
			}
		}
		
		$response = array('success'=>1,'message'=>'success.');
		echo json_encode ($response);exit;	
	}
	
	//http://dev414.trigma.us/N-162/Webservices/user_protein_shakes?user_id=4
	public function user_protein_shakes () 
	{
		$curdate		= date ('Y-m-d');
		$user_id		=	$_REQUEST['user_id'];
		
		$user_protein_shakes	=	$this->GoalActivityUser->query ("
			select goal_protein_shake_id,supplement_name,image, 'Yes'as Status from goal_protein_shake_users gu inner join goal_protein_shakes g on g.id=gu.goal_protein_shake_id where user_id=".$user_id." and gu.date='".$curdate."' union select id,supplement_name,image, 'No' as Status from goal_protein_shakes where id not in (select goal_protein_shake_id from goal_protein_shake_users where user_id=".$user_id." and date=".$curdate.")"
		);
		//echo "<pre>";print_r($user_protein_shakes);
		$response = array('success'=>1,'message'=>'success.');
		$i  = array();
		foreach($user_protein_shakes as $key=>$value)  {			
			if (in_array($value[0]['goal_protein_shake_id'],$i))  {
				
			}   else  {
				array_push ($i,$value[0]['goal_protein_shake_id']);
				$response['data'][]			=	array(
					'id'			=> $value[0]['goal_protein_shake_id'],
					'name'		=> $value[0]['supplement_name'],
					'image'	=> FULL_BASE_URL.$this->webroot.'files'.DS.'Food'.DS.'my_activity'.DS.$value[0]['image'],
					'status'	=> $value[0]['Status'],																			
				);
			}
		}		
		//echo "<pre>";print_r($response);
		$this->array_sort_by_column($response['data'], 'id');	
		echo json_encode($response);exit;			
	}
	
	//http://dev414.trigma.us/N-162/Webservices/track_protein_shakes?user_id=29&protein=1,2,3
	public function track_protein_shakes() 
	{
		$user_id		=	$_REQUEST['user_id'];
		$protein		=	$_REQUEST['protein'];
		$curdate		=	date('Y-m-d');
		$protein		=	explode (',',$protein);
		
		$exist = $this->GoalProteinShakeUser->find (
			'first',array(
				'conditions'	=> array (
					'AND'		=> array (
						'GoalProteinShakeUser.user_id'						=>$user_id,
						'GoalProteinShakeUser.date'							=>$curdate
					)
				)
			)
		);
		
		if (empty($exist))  {
			for ($i=0;$i<count($protein);$i++)  {
				$goal_protein['GoalProteinShakeUser']['user_id']	=	$user_id;
				$goal_protein['GoalProteinShakeUser']['goal_protein_shake_id']	=	$protein[$i];
				$goal_protein['GoalProteinShakeUser']['date']		=	$curdate;
				
				$this->GoalProteinShakeUser->create ();
				$this->GoalProteinShakeUser->save($goal_protein);
			}			
		}  else  {
			$this->GoalProteinShakeUser->deleteAll (array('GoalProteinShakeUser.user_id' => $user_id,'GoalProteinShakeUser.date' => $curdate));
			for ($i=0;$i<count($protein);$i++)  {		
				$goal_protein['GoalProteinShakeUser']['user_id']	=	$user_id;
				$goal_protein['GoalProteinShakeUser']['goal_protein_shake_id']	=	$protein[$i];
				$goal_protein['GoalProteinShakeUser']['date']		=	$curdate;
				
				$this->GoalProteinShakeUser->create ();
				$this->GoalProteinShakeUser->save($goal_protein);
			}
		}
		$response = array('success'=>1,'message'=>'success.');
		echo json_encode ($response);exit;	
	}
	
	//http://dev414.trigma.us/N-162/Webservices/user_activity?user_id=4
	public function user_activity () 
	{
		$curdate		= date ('Y-m-d');
		$user_id		=	$_REQUEST['user_id'];
		
		$user_today_activity	=	$this->GoalActivityUser->query ("
			select  goal_activity_id,name,image, 'Yes'as Status from goal_activity_users gu inner join goal_activities g on g.id=gu.goal_activity_id where user_id=".$user_id." and gu.date='".$curdate."' union select id,name,image, 'No' as Status from goal_activities where id not in (select goal_activity_id from goal_activity_users where user_id=".$user_id." and date=".$curdate.")"
		);
		
		//echo "<pre>";print_r($user_today_activity);die;
		$i = array();
		$response = array('success'=>1,'message'=>'success.');
		foreach($user_today_activity as $key=>$value) {
			if (in_array($value[0]['goal_activity_id'],$i))  {
				
			}   else  {
				array_push ($i,$value[0]['goal_activity_id']);
				$response['data'][]			=	array(
					'id'			=> $value[0]['goal_activity_id'],
					'name'		=> $value[0]['name'],
					'image'	=> FULL_BASE_URL.$this->webroot.'files'.DS.'Food'.DS.'my_activity'.DS.$value[0]['image'],
					'status'	=> $value[0]['Status'],																			
				);
			}
		}		
		
		$this->array_sort_by_column($response['data'], 'id');	
		//echo "<pre>";print_r($response);die;
		echo json_encode($response);exit;		
	}
	
	//http://dev414.trigma.us/N-162/Webservices/track_activity?user_id=29&activity=1,2,3,4,5,6
	public function track_activity ()  
	{
	
		$user_id		=	$_REQUEST['user_id'];
		$curdate		=	date('Y-m-d');
		$activity		=	$_REQUEST['activity'];
		$activity		=	explode (',',$activity);
		
		$exist = $this->GoalActivityUser->find (
			'first',array(
				'conditions'	=> array (
					'AND'		=> array (
						'GoalActivityUser.user_id'						=>$user_id,
						'GoalActivityUser.date'							=>$curdate
					)
				)
			)
		);
		
		if (empty($exist))  {			
			for ($i=0;$i<count($activity);$i++)  {
				$goal_activity['GoalActivityUser']['user_id']				=	$user_id;
				$goal_activity['GoalActivityUser']['goal_activity_id']	=	$activity[$i];
				$goal_activity['GoalActivityUser']['date']						=	$curdate;

				$this->GoalActivityUser->create ();
				$this->GoalActivityUser->save($goal_activity);
			}
		}  else  {
			$this->GoalActivityUser->deleteAll (array('GoalActivityUser.user_id' => $user_id,'GoalActivityUser.date' => $curdate));
			for ($i=0;$i<count($activity);$i++)  {		
				$goal_activity1['GoalActivityUser']['user_id']	=	$user_id;
				$goal_activity1['GoalActivityUser']['goal_activity_id']	=	$activity[$i];
				$goal_activity1['GoalActivityUser']['date']		=	$curdate;
				
				$this->GoalActivityUser->create ();
				$this->GoalActivityUser->save($goal_activity1);
			}
		}
		$response = array('success'=>1,'message'=>'success.');
		echo json_encode ($response);exit;	
	}
	
	/* ==================================== Track Module End ===================================*/
	/* ----------------------------------------------------------------- Goal Notification Start --------------------------------------------------*/
	
	//http://dev414.trigma.us/N-162/Webservices/like_notifications_list?user_id=29
	function like_notifications_list ()  {
		$this->loadModel ('NotificationTypeUser');
		$user_id					=	$_REQUEST['user_id'];
		$user_notification	=	$this->NotificationTypeUser->find ('all',array('conditions'=>array('NotificationTypeUser.receiver_id'=>$user_id),'order'=>array('NotificationTypeUser.id desc')));
				
		//echo "<pre>";print_r ($user_notification);die;
		if (empty($user_notification))  {
			$response = array('success'=>0,'message'=>'No Record found.');
			echo json_encode ($response);exit;	
		}
		
		$response = array('success'=>1,'message'=>'success.');
		foreach($user_notification as $value) {		
			
			$profile_image	=	!empty ($value['Sender']['profile_image']) ? FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$value['Sender']['profile_image'] : '';if (@$value['Sender']['registertype'] == 'facebook')  {
				$profile_image = $value['Sender']['profile_image'];
			}
			
			if ($value['NotificationTypeUser']['notification_type_id'] == 1)  {						
				$response['data'][]			=	array(
					'type'					=> 'Notification',
					'name'					=> $value['Sender']['name'].' like your post.',																					
					'profile_image'	=> $profile_image,																					
					'post_id'				=> $value['NotificationTypeUser']['post_id'],																					
					'date'					=> $value['NotificationTypeUser']['date'],																					
				);					
			}  else if ($value['NotificationTypeUser']['notification_type_id'] == 2)  {				
				$response['data'][]			=	array(
					'type'					=> 'Notification',
					'name'					=> $value['Sender']['name'].' comment your post.',																					
					'post_id'				=> $value['NotificationTypeUser']['post_id'],																					
					'profile_image'	=> $profile_image,																					
					'date'					=> $value['NotificationTypeUser']['date'],																					
				);
			}  else if ($value['NotificationTypeUser']['notification_type_id'] == 3)  {
				$response['data'][]			=	array(
					'type'					=> 'Notification',
					'name'					=> $value['Sender']['name'].' follow you.',																					
					'post_id'				=> '',																					
					'profile_image'	=> $profile_image,																					
					'date'					=> '',																					
				);
			}  else if ($value['NotificationTypeUser']['notification_type_id'] == 4)  {
				$response['data'][]			=	array(
					'type'					=> 'Notification',
					'name'					=> $value['Sender']['name'].' like your post.',																					
					'profile_image'	=> $profile_image,																					
					'post_id'				=> $value['NotificationTypeUser']['post_id'],																					
					'date'					=> $value['NotificationTypeUser']['date'],																					
				);
			}
		}	

		if (empty($response['data']))  {
			$response = array('success'=>0,'message'=>'No Record found.');
		}
		echo json_encode ($response);exit;			
	}
	
	//http://dev414.trigma.us/N-162/Webservices/notifications_list?user_id=29
	function notifications_list ()  {
		$user_id				=	$_REQUEST['user_id'];
		$user_post		=	$this->Post->find ('list',array('conditions'=>array('Post.user_id'=>$user_id)));
		$user_follow		=	$this->UserFollower->find ('all',array('conditions'=>array('UserFollower.user_id'=>$user_id),'contain'=>array('Follower1'=>array('id','name','profile_image','registertype'))));
		$post_like			=	$this->PostInspirede->find ('all',array('conditions'=>array('PostInspirede.post_id'=>$user_post),'contain'=>array('User'=>array('id','name','profile_image','registertype'))));
		$post_comment=	$this->PostComment->find ('all',array('conditions'=>array('PostComment.post_id'=>$user_post),'contain'=>array('User'=>array('id','name','profile_image','registertype'))));
		
		//echo "<pre>";print_r ($user_follow);die;
		$response = array('success'=>1,'message'=>'success.');
		if (!empty($post_like))  {
			foreach($post_like as $value) {		
				$profile_image	=	!empty ($value['User']['profile_image']) ? FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$value['User']['profile_image'] : '';		
				if (@$value['User']['registertype'] == 'facebook')  {
					$profile_image = $value['User']['profile_image'];
				}
				$response['data'][]			=	array(
					'type'				=> 'Notification',
					'name'		=> $value['User']['name'].' like your post.',																					
					'profile_image'	=> $profile_image,																					
					'post_id'	=> $value['PostInspirede']['post_id'],																					
					'date'		=> $value['PostInspirede']['date'],																					
				);
			}	
		}		

		if (!empty($post_comment))  {
			foreach($post_comment as $value) {		
				$profile_image	=	!empty ($value['User']['profile_image']) ? FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$value['User']['profile_image'] : '';		
				if (@$value['User']['registertype'] == 'facebook')  {
					$profile_image = $value['User']['profile_image'];
				}
				$response['data'][]			=	array(
					'type'				=> 'Notification',
					'name'		=> $value['User']['name'].' comment your post.',																					
					'post_id'	=> $value['PostComment']['post_id'],																					
					'profile_image'	=> $profile_image,																					
					'date'		=> $value['PostComment']['date'],																					
				);
			}	
		}

		if (!empty($user_follow))  {
			foreach($user_follow as $value) {			
				$profile_image	=	!empty ($value['User']['profile_image']) ? FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$value['Follower1']['profile_image'] : '';		
				if (@$value['User']['registertype'] == 'facebook')  {
					$profile_image = $value['User']['profile_image'];
				}
				$response['data'][]			=	array(
					'type'				=> 'Notification',
					'name'		=> $value['Follower1']['name'].' follow you.',																					
					'post_id'	=> '',																					
					'profile_image'	=> $profile_image,																					
					'date'		=> '',																					
				);
			}	
		}
		
		if (empty($response['data']))  {
			$response = array('success'=>0,'message'=>'No Record found.');
		}
		echo json_encode ($response);exit;				
	}
	
	//http://dev414.trigma.us/N-162/Webservices/main_notification_set?user_id=29
	public function main_notification_set ()  
	{
		$user_id				=	$_REQUEST['user_id'];
		
		$exist	=	$this->User->find (
			'first',array (
				'conditions'=>array (
					'User.id'				=> $user_id,
				),
				'contain'		=>array ()
			)
		);
		//echo "<pre>";print_r ($exist);die;
		if ($exist['User']['user_notification'] == 'No')  {
			$goal_activity['User']['id']			=	$user_id;
			$goal_activity['User']['user_notification']	=	'Yes';
				
			$this->User->create ();
			if ($this->User->save($goal_activity))  {			
				$response = array('success'=>1,'message'=>'reminders set.');
				echo json_encode ($response);exit;	
			}  
		}  else  {
			$goal_activity['User']['id']			=	$user_id;
			$goal_activity['User']['user_notification']	=	'No';
				
			$this->User->create ();
			if ($this->User->save($goal_activity))  {			
				$response = array('success'=>2,'message'=>'reminders delete.');
				echo json_encode ($response);exit;	
			}  
		}
	}
	
	//http://dev414.trigma.us/N-162/webservices/all_reminders
	public function all_reminders() 
	{
		$notification		=	$this->Notification->find ('all');
		
		$response = array ('success'=>1,'message'=>'success.');
		if (!empty($notification))  {
			foreach($notification as $info) {
				$response['data'][]	=	array(
					'id'		=> $info['Notification']['id'],
					'name'	=> $info['Notification']['name'],
				);
			}
			echo json_encode ($response);exit;
		}
		$response = array ('success'=>0,'message'=>'data not found.');
		echo json_encode($response);exit;
	}	
	
	//http://dev414.trigma.us/N-162/Webservices/reminders_set?user_id=29&notification_id=5
	public function reminders_set ()  
	{
		$user_id				=	$_REQUEST['user_id'];
		$notification_id	=	$_REQUEST['notification_id'];
		
		$exist	=	$this->NotificationUser->find (
			'count',array (
				'conditions'=>array (
					'NotificationUser.user_id'				=> $user_id,
					'NotificationUser.notification_id'	=> $notification_id
				)
			)
		);
		//echo "<pre>";print_r ($exist);
		if ($exist == 0)  {
			$goal_activity['NotificationUser']['user_id']			=	$user_id;
			$goal_activity['NotificationUser']['notification_id']	=	$notification_id;
				
			$this->NotificationUser->create ();
			if ($this->NotificationUser->save($goal_activity))  {			
				$response = array('success'=>1,'message'=>'reminders set.');
				echo json_encode ($response);exit;	
			}  
			$response = array('success'=>0,'message'=>'error.');
			echo json_encode ($response);exit;	
		}  else  {
			if ($this->NotificationUser->deleteAll (array('NotificationUser.user_id' => $user_id,'NotificationUser.notification_id' => $notification_id)))  {
					$response = array('success'=>2,'message'=>'reminders delete.');
					echo json_encode ($response);exit;
			}  
			$response = array('success'=>0,'message'=>'error.');
			echo json_encode ($response);exit;
		}
	}
	
	//http://dev414.trigma.us/N-162/Webservices/reminders_user?user_id=29
	public function reminders_user ()  
	{
		$user_id				=	$_REQUEST['user_id'];
	
		$exist	=	$this->NotificationUser->find (
			'all',array (
				'conditions'=> array (
					'NotificationUser.user_id'				=> $user_id,
				),
				'contain'		=> array (
					'Notification',
					'User'		=> array (
						'fields'	=> array ('id','starting_wt','current_wt','goal_wt')
					)
				) 
			)
		);
		$users	=$this->User->find ('first',array ('conditions'=> array ('User.id'=> $user_id),'fields'=>array ('id','starting_wt','current_wt','goal_wt'),'contain'=>array()));
		//echo "<pre>";print_r($users);die;
		if (!empty($exist))  {
			foreach ($exist as $exist1)  {
				$starting_wt	=	$exist1['User']['starting_wt'];
				$current_wt	=	$exist1['User']['current_wt'];
				$goal_wt		=	$exist1['User']['goal_wt'];
				
				$inspires		=	2;
				$meals			=	100;
				$exercises		=	0;
				$referrals		=	0;
				$successPoint		=	102;
			}
		}  else  {
			$starting_wt	=	$users['User']['starting_wt'];
			$current_wt	=	$users['User']['current_wt'];
			$goal_wt		=	$users['User']['goal_wt'];
			
			$inspires		=	2;
			$meals			=	100;
			$exercises		=	0;
			$referrals		=	0;
			$successPoint		=	102;
		}
		if ($starting_wt == '')  {
			$starting_wt	=	'';
		}
		
		if ($current_wt == '')  {
			$current_wt	=	'';
		}
		
		if ($goal_wt == '')  {
			$goal_wt	=	'';
		}
		
		$notification_id	=	array ();
		foreach ($exist as $info) {
			array_push($notification_id,$info['NotificationUser']['notification_id']);
		}
		
		if (in_array('1',$notification_id))  	{   $daily_reminders  							= 'Yes';  }  else  {  $daily_reminders  								=  'No';  }
		if (in_array('2',$notification_id))  	{   $water_reminders_five_minutes  	= 'Yes';  }  else  {  $water_reminders_five_minutes  	=  'No';  }
		if (in_array('3',$notification_id))  	{   $water_reminders_thirty_minutes  = 'Yes';  }  else  {  $water_reminders_thirty_minutes  	=  'No';  }
		if (in_array('4',$notification_id))  	{   $water_reminders_every_hours		= 'Yes';  }  else  {  $water_reminders_every_hours		=  'No';  }
		if (in_array('5',$notification_id))  	{   $protein_reminders_weight_loss  	= 'Yes';  }  else  {  $protein_reminders_weight_loss  	=  'No';  }
		if (in_array('6',$notification_id))  	{   $proteinRemindersBackOnTrack	= 'Yes';  }  else  {  $proteinRemindersBackOnTrack	=  'No';  }
		if (in_array('7',$notification_id))  	{   $protein_reminders_maintenance = 'Yes';  }  else  {  $protein_reminders_maintenance  	=  'No';  }
		if (in_array('8',$notification_id))  	{   $vetamin_medication_reminder  	= 'Yes';  }  else  {  $vetamin_medication_reminder  	=  'No';  }
		if (in_array('9',$notification_id))  	{   $morning_weight_reminder  			= 'Yes';  }  else  {  $morning_weight_reminder  			=  'No';  }
		if (in_array('10',$notification_id)) 	{   $sleep_reminder  							= 'Yes';  }  else  {  $sleep_reminder  								=  'No';  }
		
		$response = array('success'=>1,'message'=>'success.','user_id'=> $user_id,'starting_wt'=>$starting_wt,'current_wt'=>$current_wt,'goal_wt'=>$goal_wt,'inspires'=>$inspires,'meals'=>$meals,'exercises'=>$exercises,'referrals'=>$referrals,'successPoint'=>$successPoint);

		$response['data'][0]	=	array (																
			'id'			=> 1,		
			'name'		=> 'daily_reminders',		
			'status'	=> $daily_reminders,			
		);
		$response['data'][1]	=	array (			
			'id'			=> 2,
			'name'		=> 'water_reminders_five_minutes',		
			'status'	=> $water_reminders_five_minutes,
		);
		$response['data'][2]	=	array (			
			'id'			=> 3,
			'name'		=> 'water_reminders_thirty_minutes',		
			'status'	=> $water_reminders_thirty_minutes,
		);
		$response['data'][3]	=	array (			
			'id'			=> 4,
			'name'		=> 'water_reminders_every_hours',		
			'status'	=> $water_reminders_every_hours,
		);
		$response['data'][4]	=	array (			
			'id'			=> 5,
			'name'		=> 'protein_reminders_weight_loss',		
			'status'	=> $protein_reminders_weight_loss,
		);
		$response['data'][5]	=	array (			
			'id'			=> 6,
			'name'		=> 'proteinRemindersBackOnTrack',		
			'status'	=> $proteinRemindersBackOnTrack,
		);
		$response['data'][6]	=	array (			
			'id'			=> 7,
			'name'		=> 'protein_reminders_maintenance',		
			'status'	=> $protein_reminders_maintenance,
		);
		$response['data'][7]	=	array (			
			'id'			=> 8,
			'name'		=> 'vetamin_medication_reminder',		
			'status'	=> $vetamin_medication_reminder,
		);
		$response['data'][8]	=	array (			
			'id'			=> 9,
			'name'		=> 'morning_weight_reminder',		
			'status'	=> $morning_weight_reminder,
		);
		$response['data'][9]	=	array (			
			'id'			=> 10,
			'name'		=> 'sleep_reminder',		
			'status'	=> $sleep_reminder,
		);
		//echo "<pre>";print_r ($response);die;
		echo json_encode($response);exit;	
	}
	
	//Notification for Like Post, Comment Post and Follow User
	//http://dev414.trigma.us/N-162/Webservices/send_notification?receiver_id=29&sender_id=27&post_id=34&notification=Like
	function send_notification ()   {
		$this->autoRender = false;
		$gateway 			= 'gateway.sandbox.push.apple.com:2195';
		$path 					= WWW_ROOT.'ck.pem';
		
		$this->User->id = $_REQUEST['receiver_id'];
		if(!$this->User->exists())	{
			$response = array('success'=>0,'message'=>'Receiver not exist');exit;
		}
		
		$this->User->id = $_REQUEST['sender_id'];
		if(!$this->User->exists())	{
			$response = array('success'=>0,'message'=>'Sender not exist');exit;
		}
				
		$receiver			=	$this->User->find ('first',array('conditions'=>array('User.id'=>$_REQUEST['receiver_id']),'contain'=>array(),'fields'=>array('id','token','user_notification')));
		$sender				=	$this->User->find ('first',array('conditions'=>array('User.id'=>$_REQUEST['sender_id']),'contain'=>array(),'fields'=>array('id','name')));
		//echo "<pre>";print_r ($receiver);die;
		if ($receiver['User']['user_notification']  == 'Yes')  {
			if ($_REQUEST['notification'] == 'Like')  {
				$message		=	$sender['User']['name'].' like your Post';
			}  else if ($_REQUEST['notification'] == 'Comment')  {
				$message		=	$sender['User']['name'].' comment your Post';
			}  else if ($_REQUEST['notification'] == 'Follow')  {
				$message		=	$sender['User']['name'].' comment your Post';
			}
			$passphrase 	= '123456';
			
			if (@$receiver['User']['device_token'] != '') {
				$deviceToken	=	$receiver['User']['device_token'];
			}  else  {
				$deviceToken	=	'';
			}
			//$deviceToken	=	'a3afe7ab458c454306eae1e1f5bcf1080ebe775931258f5a6a10d14d29e0a6e8';
			
			// Create a Stream
			$ctx = stream_context_create();
			// Define the certificate to use 
			stream_context_set_option($ctx, 'ssl', 'local_cert',$path);	
			// Passphrase to the certificate
			stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);	
			
			// Open a connection to the APNS server
			$fp 	= stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT,$ctx);
			//echo $fp;die;
			// Check that we've connected
			if (!$fp) {
				exit("Failed to connect: $err $errstr" . PHP_EOL);
			} 
			
			$body['aps'] 	= array ('alert' => $message,'type' =>  'text','sound' => 'default');
			$name1			= 'Daily Reminders Notification';
			$body['data'] 	= array ('id' => 123,'name' => $name1,);

			$payload = json_encode($body);
			$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
			
			// Send it to the server
			$result = fwrite($fp, $msg, strlen($msg));
			
			if (!$result) {	
				return 0; 
				fclose ($fp);						
			}  else  {
				return 1;					
				fclose($fp);
			}	
		}
	}
	
	//http://dev414.trigma.us/N-162/Cron/daily_reminders.php
	public function daily_reminders()  {
		$this->autoRender = false;
		$path 						= WWW_ROOT.'ck.pem';	
		$message				=	'This is your Daily Reminders Notification';
		$passphrase 		= '123456';
		$users					=  $this->NotificationUser->find (
			'all',array(
				'contain'		=> array (
					'User'		=> array(
						'fields'	=> array (
							'User.id','User.name','user_notification','device_token'
						)
					),
					'Notification'
				),
				'conditions'	=> array (
					'NotificationUser.notification_id'	=> 1
				)
			)
		);	
		//echo "<pre>";print_r($users);die;
		foreach ($users as $info)  {				
			/* Notification code Start*/
			//echo "<pre>";print_r ($info);die;
			if ($info['User']['user_notification']  == 'Yes' and $info['User']['device_token'] != '')  {				
				$deviceToken	=	$info['User']['device_token'];
				//$deviceToken	=	'a3afe7ab458c454306eae1e1f5bcf1080ebe775931258f5a6a10d14d29e0a6e8';
				
				// Create a Stream
				$ctx = stream_context_create();
				// Define the certificate to use 
				stream_context_set_option($ctx, 'ssl', 'local_cert',$path);	
				// Passphrase to the certificate
				stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);	
				
				// Open a connection to the APNS server
				$fp 	= stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT,$ctx);
				//echo $fp;die;
				// Check that we've connected
				if (!$fp) {
					exit("Failed to connect: $err $errstr" . PHP_EOL);
				} 
				
				$body['aps'] 	= array ('alert' => $message,'type' =>  'text','sound' => 'default');
				$name1			= 'Daily Reminders Notification';
				$body['data'] 	= array ('id' => 123,'name' => $name1,);

				$payload = json_encode($body);
				$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
				
				// Send it to the server
				$result = fwrite($fp, $msg, strlen($msg));
				
				if (!$result) {	
					//return 0; 
					$response 	= array('success'=>0,'msg'=>'Error in notification.');
					echo json_encode ($response);exit;	
					fclose ($fp);						
				}  else  {
					//return 1;					
					fclose($fp);
				}	
			}
			/* Notification code End*/			
		}
		die;	
    }	
	

	//http://dev414.trigma.us/N-162/Cron/water_reminders_five_minutes.php
	public function water_reminders_five_minutes()  {
		$this->autoRender = false;
		$path 						= WWW_ROOT.'ck.pem';	
		$message				=	'This is your water reminder every five minutes';
		$passphrase 		= '123456';
		$users					=  $this->NotificationUser->find (
			'all',array(
				'contain'		=> array (
					'User'		=> array(
						'fields'	=> array (
							'User.id','User.name','user_notification','device_token'
						)
					),
					'Notification'
				),
				'conditions'	=> array (
					'NotificationUser.notification_id'	=> 2
				)
			)
		);	
		//echo "<pre>";print_r($users);die;
		foreach ($users as $info)  {				
			/* Notification code Start*/
			//echo "<pre>";print_r ($info);die;
			if ($info['User']['user_notification']  == 'Yes' and $info['User']['device_token'] != '')  {				
				$deviceToken	=	$info['User']['device_token'];
				//$deviceToken	=	'a3afe7ab458c454306eae1e1f5bcf1080ebe775931258f5a6a10d14d29e0a6e8';
				
				// Create a Stream
				$ctx = stream_context_create();
				// Define the certificate to use 
				stream_context_set_option($ctx, 'ssl', 'local_cert',$path);	
				// Passphrase to the certificate
				stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);	
				
				// Open a connection to the APNS server
				$fp 	= stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT,$ctx);
				//echo $fp;die;
				// Check that we've connected
				if (!$fp) {
					exit("Failed to connect: $err $errstr" . PHP_EOL);
				} 
				
				$body['aps'] 	= array ('alert' => $message,'type' =>  'text','sound' => 'default');
				$name1			= 'Daily Reminders Notification';
				$body['data'] 	= array ('id' => 123,'name' => $name1,);

				$payload = json_encode($body);
				$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
				
				// Send it to the server
				$result = fwrite($fp, $msg, strlen($msg));
				
				if (!$result) {	
					//return 0; 
					$response 	= array('success'=>0,'msg'=>'Error in notification.');
					echo json_encode ($response);exit;	
					fclose ($fp);						
				}  else  {
					//return 1;					
					fclose($fp);
				}	
			}
			/* Notification code End*/			
		}
		die;			
    }
	
	//http://dev414.trigma.us/N-162/Cron/water_reminders_thirty_minutes.php
	public function water_reminders_thirty_minutes()  {
		$this->autoRender = false;
		$path 						= WWW_ROOT.'ck.pem';	
		$message				=	'This is your water reminder every thirty minutes';
		$passphrase 		= '123456';
		$users					=  $this->NotificationUser->find (
			'all',array(
				'contain'		=> array (
					'User'		=> array(
						'fields'	=> array (
							'User.id','User.name','user_notification','device_token'
						)
					),
					'Notification'
				),
				'conditions'	=> array (
					'NotificationUser.notification_id'	=> 3
				)
			)
		);	
		//echo "<pre>";print_r($users);die;
		foreach ($users as $info)  {				
			/* Notification code Start*/
			//echo "<pre>";print_r ($info);die;
			if ($info['User']['user_notification']  == 'Yes' and $info['User']['device_token'] != '')  {				
				$deviceToken	=	$info['User']['device_token'];
				//$deviceToken	=	'a3afe7ab458c454306eae1e1f5bcf1080ebe775931258f5a6a10d14d29e0a6e8';
				
				// Create a Stream
				$ctx = stream_context_create();
				// Define the certificate to use 
				stream_context_set_option($ctx, 'ssl', 'local_cert',$path);	
				// Passphrase to the certificate
				stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);	
				
				// Open a connection to the APNS server
				$fp 	= stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT,$ctx);
				//echo $fp;die;
				// Check that we've connected
				if (!$fp) {
					exit("Failed to connect: $err $errstr" . PHP_EOL);
				} 
				
				$body['aps'] 	= array ('alert' => $message,'type' =>  'text','sound' => 'default');
				$name1			= 'Daily Reminders Notification';
				$body['data'] 	= array ('id' => 123,'name' => $name1,);

				$payload = json_encode($body);
				$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
				
				// Send it to the server
				$result = fwrite($fp, $msg, strlen($msg));
				
				if (!$result) {	
					//return 0; 
					$response 	= array('success'=>0,'msg'=>'Error in notification.');
					echo json_encode ($response);exit;	
					fclose ($fp);						
				}  else  {
					//return 1;					
					fclose($fp);
				}	
			}
			/* Notification code End*/			
		}
		die;					
    }
	
	//http://dev414.trigma.us/N-162/Cron/water_reminders_every_hours.php
	public function water_reminders_every_hours()  {
		$this->autoRender = false;
		$path 						= WWW_ROOT.'ck.pem';	
		$message				=	'This is your water reminder every hour';
		$passphrase 		= '123456';
		$users					=  $this->NotificationUser->find (
			'all',array(
				'contain'		=> array (
					'User'		=> array(
						'fields'	=> array (
							'User.id','User.name','user_notification','device_token'
						)
					),
					'Notification'
				),
				'conditions'	=> array (
					'NotificationUser.notification_id'	=> 4
				)
			)
		);	
	//	echo "<pre>";print_r($users);die;
		foreach ($users as $info)  {				
			/* Notification code Start*/
			//echo "<pre>";print_r ($info);die;
			if ($info['User']['user_notification']  == 'Yes' and $info['User']['device_token'] != '')  {				
				$deviceToken	=	$info['User']['device_token'];
				//$deviceToken	=	'a3afe7ab458c454306eae1e1f5bcf1080ebe775931258f5a6a10d14d29e0a6e8';
				
				// Create a Stream
				$ctx = stream_context_create();
				// Define the certificate to use 
				stream_context_set_option($ctx, 'ssl', 'local_cert',$path);	
				// Passphrase to the certificate
				stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);	
				
				// Open a connection to the APNS server
				$fp 	= stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT,$ctx);
				//echo $fp;die;
				// Check that we've connected
				if (!$fp) {
					exit("Failed to connect: $err $errstr" . PHP_EOL);
				} 
				
				$body['aps'] 	= array ('alert' => $message,'type' =>  'text','sound' => 'default');
				$name1			= 'Daily Reminders Notification';
				$body['data'] 	= array ('id' => 123,'name' => $name1,);

				$payload = json_encode($body);
				$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
				
				// Send it to the server
				$result = fwrite($fp, $msg, strlen($msg));
				
				if (!$result) {	
					//return 0; 
					$response 	= array('success'=>0,'msg'=>'Error in notification.');
					echo json_encode ($response);exit;	
					fclose ($fp);						
				}  else  {
					//return 1;					
					fclose($fp);
				}	
			}
			/* Notification code End*/			
		}
		die;				
    }
	
	//http://dev414.trigma.us/N-162/Cron/protein_reminders_weight_loss.php
	public function protein_reminders_weight_loss()  {
		$this->autoRender = false;
		$path 						= WWW_ROOT.'ck.pem';	
		$message				=	'This is your protein reminder for weight loss';
		$passphrase 		= '123456';
		$users					=  $this->NotificationUser->find (
			'all',array(
				'contain'		=> array (
					'User'		=> array(
						'fields'	=> array (
							'User.id','User.name','user_notification','device_token'
						)
					),
					'Notification'
				),
				'conditions'	=> array (
					'NotificationUser.notification_id'	=> 5
				)
			)
		);	
		//echo "<pre>";print_r($users);die;
		foreach ($users as $info)  {				
			/* Notification code Start*/
			//echo "<pre>";print_r ($info);die;
			if ($info['User']['user_notification']  == 'Yes' and $info['User']['device_token'] != '')  {				
				$deviceToken	=	$info['User']['device_token'];
				//$deviceToken	=	'a3afe7ab458c454306eae1e1f5bcf1080ebe775931258f5a6a10d14d29e0a6e8';
				
				// Create a Stream
				$ctx = stream_context_create();
				// Define the certificate to use 
				stream_context_set_option($ctx, 'ssl', 'local_cert',$path);	
				// Passphrase to the certificate
				stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);	
				
				// Open a connection to the APNS server
				$fp 	= stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT,$ctx);
				//echo $fp;die;
				// Check that we've connected
				if (!$fp) {
					exit("Failed to connect: $err $errstr" . PHP_EOL);
				} 
				
				$body['aps'] 	= array ('alert' => $message,'type' =>  'text','sound' => 'default');
				$name1			= 'Daily Reminders Notification';
				$body['data'] 	= array ('id' => 123,'name' => $name1,);

				$payload = json_encode($body);
				$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
				
				// Send it to the server
				$result = fwrite($fp, $msg, strlen($msg));
				
				if (!$result) {	
					//return 0; 
					$response 	= array('success'=>0,'msg'=>'Error in notification.');
					echo json_encode ($response);exit;	
					fclose ($fp);						
				}  else  {
					//return 1;					
					fclose($fp);
				}	
			}
			/* Notification code End*/			
		}
		die;		
    }
	
	//http://dev414.trigma.us/N-162/Cron/protein_reminders_back_on_track.php
	public function protein_reminders_back_on_track()  {
		$this->autoRender = false;
		$path 						= WWW_ROOT.'ck.pem';	
		$message				=	'This is your protein reminder back on track';
		$passphrase 		= '123456';
		$users					=  $this->NotificationUser->find (
			'all',array(
				'contain'		=> array (
					'User'		=> array(
						'fields'	=> array (
							'User.id','User.name','user_notification','device_token'
						)
					),
					'Notification'
				),
				'conditions'	=> array (
					'NotificationUser.notification_id'	=> 6
				)
			)
		);	
		//echo "<pre>";print_r($users);die;
		foreach ($users as $info)  {				
			/* Notification code Start*/
			//echo "<pre>";print_r ($info);die;
			if ($info['User']['user_notification']  == 'Yes' and $info['User']['device_token'] != '')  {				
				$deviceToken	=	$info['User']['device_token'];
				//$deviceToken	=	'a3afe7ab458c454306eae1e1f5bcf1080ebe775931258f5a6a10d14d29e0a6e8';
				
				// Create a Stream
				$ctx = stream_context_create();
				// Define the certificate to use 
				stream_context_set_option($ctx, 'ssl', 'local_cert',$path);	
				// Passphrase to the certificate
				stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);	
				
				// Open a connection to the APNS server
				$fp 	= stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT,$ctx);
				//echo $fp;die;
				// Check that we've connected
				if (!$fp) {
					exit("Failed to connect: $err $errstr" . PHP_EOL);
				} 
				
				$body['aps'] 	= array ('alert' => $message,'type' =>  'text','sound' => 'default');
				$name1			= 'Daily Reminders Notification';
				$body['data'] 	= array ('id' => 123,'name' => $name1,);

				$payload = json_encode($body);
				$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
				
				// Send it to the server
				$result = fwrite($fp, $msg, strlen($msg));
				
				if (!$result) {	
					//return 0; 
					$response 	= array('success'=>0,'msg'=>'Error in notification.');
					echo json_encode ($response);exit;	
					fclose ($fp);						
				}  else  {
					//return 1;					
					fclose($fp);
				}	
			}
			/* Notification code End*/			
		}
		die;		
    }
	
	//http://dev414.trigma.us/N-162/Cron/protein_reminders_maintenance.php
	public function protein_reminders_maintenance()  {
		$this->autoRender = false;
		$path 						= WWW_ROOT.'ck.pem';	
		$message				=	'This is your protein reminder for maintenance';
		$passphrase 		= '123456';
		$users					=  $this->NotificationUser->find (
			'all',array(
				'contain'		=> array (
					'User'		=> array(
						'fields'	=> array (
							'User.id','User.name','user_notification','device_token'
						)
					),
					'Notification'
				),
				'conditions'	=> array (
					'NotificationUser.notification_id'	=> 7
				)
			)
		);	
		//echo "<pre>";print_r($users);die;
		foreach ($users as $info)  {				
			/* Notification code Start*/
			//echo "<pre>";print_r ($info);die;
			if ($info['User']['user_notification']  == 'Yes' and $info['User']['device_token'] != '')  {				
				$deviceToken	=	$info['User']['device_token'];
				//$deviceToken	=	'a3afe7ab458c454306eae1e1f5bcf1080ebe775931258f5a6a10d14d29e0a6e8';
				
				// Create a Stream
				$ctx = stream_context_create();
				// Define the certificate to use 
				stream_context_set_option($ctx, 'ssl', 'local_cert',$path);	
				// Passphrase to the certificate
				stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);	
				
				// Open a connection to the APNS server
				$fp 	= stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT,$ctx);
				//echo $fp;die;
				// Check that we've connected
				if (!$fp) {
					exit("Failed to connect: $err $errstr" . PHP_EOL);
				} 
				
				$body['aps'] 	= array ('alert' => $message,'type' =>  'text','sound' => 'default');
				$name1			= 'Daily Reminders Notification';
				$body['data'] 	= array ('id' => 123,'name' => $name1,);

				$payload = json_encode($body);
				$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
				
				// Send it to the server
				$result = fwrite($fp, $msg, strlen($msg));
				
				if (!$result) {	
					//return 0; 
					$response 	= array('success'=>0,'msg'=>'Error in notification.');
					echo json_encode ($response);exit;	
					fclose ($fp);						
				}  else  {
					//return 1;					
					fclose($fp);
				}	
			}
			/* Notification code End*/			
		}
		die;		
    }
	
	//http://dev414.trigma.us/N-162/Cron/vetamin_medication_reminder.php
	public function vetamin_medication_reminder()  {
		$this->autoRender = false;
		$path 						= WWW_ROOT.'ck.pem';	
		$message				=	'This is your vetamin medication reminder.';
		$passphrase 		= '123456';
		$users					=  $this->NotificationUser->find (
			'all',array(
				'contain'		=> array (
					'User'		=> array(
						'fields'	=> array (
							'User.id','User.name','user_notification','device_token'
						)
					),
					'Notification'
				),
				'conditions'	=> array (
					'NotificationUser.notification_id'	=> 8
				)
			)
		);	
		//echo "<pre>";print_r($users);die;
		foreach ($users as $info)  {				
			/* Notification code Start*/
			//echo "<pre>";print_r ($info);die;
			if ($info['User']['user_notification']  == 'Yes' and $info['User']['device_token'] != '')  {				
				$deviceToken	=	$info['User']['device_token'];
				//$deviceToken	=	'a3afe7ab458c454306eae1e1f5bcf1080ebe775931258f5a6a10d14d29e0a6e8';
				
				// Create a Stream
				$ctx = stream_context_create();
				// Define the certificate to use 
				stream_context_set_option($ctx, 'ssl', 'local_cert',$path);	
				// Passphrase to the certificate
				stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);	
				
				// Open a connection to the APNS server
				$fp 	= stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT,$ctx);
				//echo $fp;die;
				// Check that we've connected
				if (!$fp) {
					exit("Failed to connect: $err $errstr" . PHP_EOL);
				} 
				
				$body['aps'] 	= array ('alert' => $message,'type' =>  'text','sound' => 'default');
				$name1			= 'Daily Reminders Notification';
				$body['data'] 	= array ('id' => 123,'name' => $name1,);

				$payload = json_encode($body);
				$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
				
				// Send it to the server
				$result = fwrite($fp, $msg, strlen($msg));
				
				if (!$result) {	
					//return 0; 
					$response 	= array('success'=>0,'msg'=>'Error in notification.');
					echo json_encode ($response);exit;	
					fclose ($fp);						
				}  else  {
					//return 1;					
					fclose($fp);
				}	
			}
			/* Notification code End*/			
		}
		die;		
    }
	
	//http://dev414.trigma.us/N-162/Cron/morning_weight_reminder.php
	public function morning_weight_reminder()  {
		$this->autoRender = false;
		$path 						= WWW_ROOT.'ck.pem';	
		$message				=	'This is your morning weight reminder';
		$passphrase 		= '123456';
		$users					=  $this->NotificationUser->find (
			'all',array(
				'contain'		=> array (
					'User'		=> array(
						'fields'	=> array (
							'User.id','User.name','user_notification','device_token'
						)
					),
					'Notification'
				),
				'conditions'	=> array (
					'NotificationUser.notification_id'	=> 9
				)
			)
		);	
		//echo "<pre>";print_r($users);die;
		foreach ($users as $info)  {				
			/* Notification code Start*/
			//echo "<pre>";print_r ($info);die;
			if ($info['User']['user_notification']  == 'Yes' and $info['User']['device_token'] != '')  {				
				$deviceToken	=	$info['User']['device_token'];
				//$deviceToken	=	'a3afe7ab458c454306eae1e1f5bcf1080ebe775931258f5a6a10d14d29e0a6e8';
				
				// Create a Stream
				$ctx = stream_context_create();
				// Define the certificate to use 
				stream_context_set_option($ctx, 'ssl', 'local_cert',$path);	
				// Passphrase to the certificate
				stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);	
				
				// Open a connection to the APNS server
				$fp 	= stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT,$ctx);
				//echo $fp;die;
				// Check that we've connected
				if (!$fp) {
					exit("Failed to connect: $err $errstr" . PHP_EOL);
				} 
				
				$body['aps'] 	= array ('alert' => $message,'type' =>  'text','sound' => 'default');
				$name1			= 'Daily Reminders Notification';
				$body['data'] 	= array ('id' => 123,'name' => $name1,);

				$payload = json_encode($body);
				$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
				
				// Send it to the server
				$result = fwrite($fp, $msg, strlen($msg));
				
				if (!$result) {	
					//return 0; 
					$response 	= array('success'=>0,'msg'=>'Error in notification.');
					echo json_encode ($response);exit;	
					fclose ($fp);						
				}  else  {
					//return 1;					
					fclose($fp);
				}	
			}
			/* Notification code End*/			
		}
		die;		
    }
	
	//http://dev414.trigma.us/N-162/Cron/sleep_reminder.php
	public function sleep_reminder()  {
		$this->autoRender = false;
		$path 						= WWW_ROOT.'ck.pem';	
		$message				=	'This is your sleep reminder.';
		$passphrase 		= '123456';
		$users					=  $this->NotificationUser->find (
			'all',array(
				'contain'		=> array (
					'User'		=> array(
						'fields'	=> array (
							'User.id','User.name','user_notification','device_token'
						)
					),
					'Notification'
				),
				'conditions'	=> array (
					'NotificationUser.notification_id'	=> 10
				)
			)
		);	
		//echo "<pre>";print_r($users);die;
		foreach ($users as $info)  {				
			/* Notification code Start*/
			//echo "<pre>";print_r ($info);die;
			if ($info['User']['user_notification']  == 'Yes' and $info['User']['device_token'] != '')  {				
				$deviceToken	=	$info['User']['device_token'];
				//$deviceToken	=	'a3afe7ab458c454306eae1e1f5bcf1080ebe775931258f5a6a10d14d29e0a6e8';
				
				// Create a Stream
				$ctx = stream_context_create();
				// Define the certificate to use 
				stream_context_set_option($ctx, 'ssl', 'local_cert',$path);	
				// Passphrase to the certificate
				stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);	
				
				// Open a connection to the APNS server
				$fp 	= stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT,$ctx);
				//echo $fp;die;
				// Check that we've connected
				if (!$fp) {
					exit("Failed to connect: $err $errstr" . PHP_EOL);
				} 
				
				$body['aps'] 	= array ('alert' => $message,'type' =>  'text','sound' => 'default');
				$name1			= 'Daily Reminders Notification';
				$body['data'] 	= array ('id' => 123,'name' => $name1,);

				$payload = json_encode($body);
				$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
				
				// Send it to the server
				$result = fwrite($fp, $msg, strlen($msg));
				
				if (!$result) {	
					//return 0; 
					$response 	= array('success'=>0,'msg'=>'Error in notification.');
					echo json_encode ($response);exit;	
					fclose ($fp);						
				}  else  {
					//return 1;					
					fclose($fp);
				}	
			}
			/* Notification code End*/			
		}
		die;		
    }	
	
	public function userss ()  {
		$users	=	$this->User->find ('all',
								array (
									'limit'			=> 5,
									'offset'			=> 5,
									'contain'		=> array (),
									'order'			=> array('User.id desc')
								)
							);
		echo "<pre>";print_r ($users);die;
	}
	
	
	/* ----------------------------------------------------------------- Goal Notification Start ---------------------------------------------------------------------*/
	
}