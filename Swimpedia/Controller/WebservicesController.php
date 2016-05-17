<?php
	// Project : Live Swimpedia
	App::uses ('AppController', 'Controller');
	class WebservicesController extends AppController 
	{	
		public $components 	= 	array('ImageResize');
		public $uses				=	array('Answer','Category','Question','QuestionAnswer','Topic','User','UserPowerUp','UserType','ReportAndError','CustomerQuestion','CustomerQuestionAnswer');

		public function beforeFilter() 
		{
			parent::beforeFilter();
			$this->Auth->allow (array('signup','login','forgot','admin_changepass','admin_myProfile','onlineServiceProvider','onlineCustomer','admin_profile_edit','customerHelp','customerServices','customerServiceDetails','admin_topic_list','admin_question_list','admin_user_notification','admin_user_details','admin_topics','admin_reset','admin_question_answers','admin_quit_quize','admin_skip_question','admin_purchase_power_ups','admin_user_total_score','admin_user_lives','admin_user_live_update','admin_check_lives','admin_high_score','admin_question_answer','admin_count_click_no','admin_update_click_no','admin_distance','admin_topics_answers_check','admin_report_and_error','admin_add_question_answer','admin_count_answer','admin_laderboard','testing_answer','correct_topics_percent','user_click','admin_update_daycount','usercount','admin_user_power_ups','admin_user_live_purchase'));
		}
		
		/*
			1st API   (signup)
			
		*/	//http://app.swimpedia.com/Webservices/signup?display_name=gurudutt&birth_day=19-05-2015&email=gurudutt.sharma@trigma.in&image=profileimage2.png&register_type=manual&password=123456
		
		public function signup () 
		{
			$data['User']['username']		=	@$_REQUEST['display_name'];  
			$data['User']['birthday']  			=  @$_REQUEST['birth_day'];  
			$data['User']['email'] 				=  @$_REQUEST['email'];  
			$data['User']['profile_image']  	=  @$_REQUEST['image'];			
			$data['User']['register_type']  	=  @$_REQUEST['register_type'];			
			$data['User']['status'] 				=	1;
			$data['User']['register_date'] 	= 	date("Y-m-d"); 
			$data['User']['lives_time'] 		= 	date("Y-m-d"); 
			if ($_REQUEST['register_type']	==	"facebook") 
			{	
				$data['User']['fb_id']  				=  @$_REQUEST['fb_id'];		
				$data['User']['registertype']  	=  @$_REQUEST['register_type'];	
				
				if(isset($_REQUEST['display_name'])) 
				{
					$data['User']['username']	= $_REQUEST['display_name'];
				} else {
					$data['User']['username']	= '';
				}
				
				if(isset($_REQUEST['email'])) {
					$data['User']['email']			= $_REQUEST['email'];
				} else {
					$data['User']['email']			= '';
				} 
				
				if(isset($_REQUEST['birthday']) && !empty($_REQUEST['birthday'])) {
					$data['User']['birthday']		= $_REQUEST['birthday'];
				} else {
					$data['User']['birthday']		= '0000.00.00';
				} 
				
				if(isset($_REQUEST['image'])) {
					$data['User']['profile_image']	= $_REQUEST['image'];
				} else {
					$data['User']['profile_image']	= '';
				} 					
				
				$getFbIDStatus 						=  $this->User->find('first',array('conditions'=>array('User.fb_id'=>$_REQUEST['fb_id'])));
				
				if (empty($getFbIDStatus))
				{
					$fbexist 								= 	$this->User->find('first',array('conditions'=>array('AND'=>array('User.fb_id'=>$_REQUEST['fb_id']))));
					
					if (empty($fbexist)) 
					{
						$this->User->create();               
						if ($this->User->save($data)) {
							$user_id  					= 	$this->User->getLastInsertID();
							for($j=1; $j<5; $j++)  
							{ 		
								$powerUp['UserPowerUp']['user_id']			=	$user_id;
								$powerUp['UserPowerUp']['power_up_id']	=	$j;
								if ($j	==1) {
									$powerUp['UserPowerUp']['remaining']	=	5;
								} else if ($j ==2)  {
									$powerUp['UserPowerUp']['remaining']	=	3;
								} else if ($j==3) {
									$powerUp['UserPowerUp']['remaining']	=	3;
								} else if ($j==4) {
									$powerUp['UserPowerUp']['remaining']	=	3;
								}
								
								$this->UserPowerUp->create();               
								$this->UserPowerUp->set('user_id',$user_id);               
								$this->UserPowerUp->set('power_up_id',$j);               
								$this->UserPowerUp->set('remaining',$powerUp['UserPowerUp']['remaining']);               
								$this->UserPowerUp->save();
								
							}
							$this->User->query("update users set password= '' where id = '".$user_id."'");
							$response 				= 	array('status'=>1,'message'=>'User Register Successfully with facebook','user_id'=>$user_id);
							echo json_encode($response);die;
							exit;
						}  else {
							$response					= 	array('status'=>0,'message'=>'Please try again');
							echo json_encode($response);
							exit;
						}
					}  else  {
						$this->login($data['User']['email'],5);
						$response						= 	array('status'=>3,'message'=>'Facebook id exist, please try another email');
						echo json_encode($response);
						exit;		    
					} 			
				} else {
					$this->login($data['User']['email'],5);
					$response 						= 	array('status'=>3,'message'=>'facebook id  already exist, please try another user');
					echo json_encode($response);
					exit;		    
				}
			} elseif($_REQUEST['register_type']	==	"twiter") {
				$data['User']['twiter_id']  				=  $_REQUEST['twiter_id'];
				$data['User']['user_type']  			=  6;
				
				if(isset($_REQUEST['display_name'])){
					$data['User']['username']		= $_REQUEST['display_name'];
				} else {
					$data['User']['username']		= '';
				}
				
				if(isset($_REQUEST['email'])) {
					$data['User']['email']				= $_REQUEST['email'];
				} else {
					$data['User']['email']				= '';
				} 
				
				if(isset($_REQUEST['birthday']) && !empty($_REQUEST['birthday'])) {
					$data['User']['birthday']			= $_REQUEST['birthday'];
				} else {
					$data['User']['birthday']			= '0000.00.00';
				} 
				
				if(isset($_REQUEST['image'])) {
					$data['User']['profile_image']	= $_REQUEST['image'];
				} else {
					$data['User']['profile_image']	= '';
				} 				
				
				$getlnIDStatus 							=  $this->User->find('first',array('conditions'=>array('User.twiter_id'=>$_REQUEST['twiter_id'])));
				if (empty($getlnIDStatus))
				{
					$twitexist 								= 	$this->User->find('first',array('conditions'=>array('AND'=>array('User.twiter_id'=>$_REQUEST['twiter_id']))));
					if (empty($twitexist)) 
					{
						$this->User->create();               
						if ($this->User->save($data)) {
							$user_id  						= 	$this->User->getLastInsertID();
							for($j=1; $j<5; $j++)  
							{ 		
								$powerUp['UserPowerUp']['user_id']			=	$user_id;
								$powerUp['UserPowerUp']['power_up_id']	=	$j;
								if ($j	==1) {
									$powerUp['UserPowerUp']['remaining']	=	5;
								} else if ($j ==2)  {
									$powerUp['UserPowerUp']['remaining']	=	3;
								} else if ($j==3) {
									$powerUp['UserPowerUp']['remaining']	=	3;
								} else if ($j==4) {
									$powerUp['UserPowerUp']['remaining']	=	3;
								}
								
								$this->UserPowerUp->create();               
								$this->UserPowerUp->set('user_id',$user_id);               
								$this->UserPowerUp->set('power_up_id',$j);               
								$this->UserPowerUp->set('remaining',$powerUp['UserPowerUp']['remaining']);               
								$this->UserPowerUp->save();
								
							}
							$this->User->query("update users set password= '' where id = '".$user_id."'");
							$response 					= 	array('status'=>1,'message'=>'User Register Successfully with twiter','user_id'=>$user_id);
							echo json_encode($response);die;
							exit;
						} else {
							$response					= 	array('status'=>0,'message'=>'Please try again');
							echo json_encode($response);
							exit;
						}
					}  else {
						$this->login($data['User']['email'],5);
						$response						= 	array('status'=>3,'message'=>'Email id exist, please try another email');
						echo json_encode($response);
						exit;		    
					} 				
				}  else {
						$this->login($data['User']['email'],5);
						$response 					= 	array('status'=>3,'message'=>'twitter already exist, please try another user');
						echo json_encode($response);
						exit;		    
				}
			}  else if($_REQUEST['register_type']=="manual") {
				$data['User']['password']  		=  @$_REQUEST['password'];
				$exist 											= 	$this->User->find("first", array("conditions" => array("User.username" => $data['User']['username'])));

				if (empty($exist))
				{
					$emailexist 							= 	$this->User->find('first',array('conditions'=>array('AND'=>array('User.email'=>$data['User']['email']))));
					if (empty($emailexist)) 
					{
						
						$this->User->create();               
						if ($this->User->save($data)) {
							$user_id    						= $this->User->getLastInsertID();
							for($j=1; $j<5; $j++)  
							{ 		
								$powerUp['UserPowerUp']['user_id']			=	$user_id;
								$powerUp['UserPowerUp']['power_up_id']	=	$j;
								if ($j	==1) {
									$powerUp['UserPowerUp']['remaining']	=	5;
								} else if ($j ==2)  {
									$powerUp['UserPowerUp']['remaining']	=	3;
								} else if ($j==3) {
									$powerUp['UserPowerUp']['remaining']	=	3;
								} else if ($j==4) {
									$powerUp['UserPowerUp']['remaining']	=	3;
								}
								
								$this->UserPowerUp->create();               
								$this->UserPowerUp->set('user_id',$user_id);               
								$this->UserPowerUp->set('power_up_id',$j);               
								$this->UserPowerUp->set('remaining',$powerUp['UserPowerUp']['remaining']);               
								$this->UserPowerUp->save();
								
							}
							
							
							 if(@$_REQUEST['image']!=''){  
								$name						= $user_id."profileImage.png";
								$this->User->saveField('profile_image',$name);
								@$_REQUEST['profile_image']= str_replace('data:image/png;base64,', '', @$_REQUEST['image']);
								$_REQUEST['profile_image'] = str_replace(' ', '+',$_REQUEST['profile_image']);
								$unencodedData=base64_decode($_REQUEST['profile_image']);
								$pth 							= WWW_ROOT.'files' . DS . 'profileimage' . DS .$name;
								file_put_contents($pth, $unencodedData);
							 }
							$response 					= 	array('status'=>1,'message'=>'User Register Successfully','user_id'=>$user_id);
							echo json_encode($response);die;
							exit;
						} else {
							$response						= 	array('status'=>0,'message'=>'Please try again');
							echo json_encode($response);
							exit;
						}
					}	else	{
						$response						= 	array('status'=>3,'message'=>'Email id exist, please try another email');
						echo json_encode($response);
						exit;		    
					} 					
				}  else  {
					$response 							= 	array('status'=>3,'message'=>'User already exist, please try another user');
					echo json_encode($response);
					exit;		    
				}		
			}
			exit;			
		}
		
		/* 
			2 API    (Login)
		*/
		// http://app.swimpedia.com/Webservices/login?username=gurudutt&password=gurudutt
	 
		public function login ($u = null,$p = null)	
		{
			$this->request->data['User']['username']	=	$_REQUEST['username'];
			$this->request->data['User']['password']	= 	$_REQUEST['password'];                 
			$usern 													= 	$this->request->data['User']['username'];
			if ($u !='') {			
				$usern	=	$u;
				$this->request->data['User']['password']  = Null;
			}
			$us 														= 	$this->User->find("first", array("conditions" => array("User.email" => $usern)));
			
			if	(!empty($us)) {
				if ($us['User']['status'] == '1') { 
					App::Import('Utility', 'Validation'); 
					$pass 										=	AuthComponent::password($this->data['User']['password']); 
					if ($us['User']['registertype'] !='manual')    {
						$isf 										= 	$this->User->find("first", array("conditions" =>array('AND' => array("User.email" => $usern))));
					}    else    {
						$user 									=	$this->request->data['User']['username'];
						$isf 										= 	$this->User->find("first", array("conditions" =>array('AND' => array("User.email" => $user,"User.password"=>$pass))));
					}
					if (!$isf) {
						$response = array('message'=>"Invalid Password",'status' =>0);
						echo json_encode($response);
						exit; 
					} 
					else 
					{	
						$resp = "You have successfully logged-In";
						$type =$isf['User']['usertype_id'];
						
						if ($type == 6)  {
							$ty = "User";
						}  else  {
							$ty = "Undefiend";
						}
						
						if (isset ($isf['User']['id']))  {
							$user_id	=	$isf['User']['id'];
						}  else  {
							$user_id	=	'';
						}
						
						if (isset ($isf['User']['usertype_id']))  {
							$usertype_id	=	$isf['User']['usertype_id'];
						}  else  {
							$usertype_id	=	'';
						}
						
						if (isset($isf['User']['first_name'])) {
							$first_name	=	$isf['User']['first_name'];
						}  else  {
							$first_name	=	'';
						}
						
						if (isset($isf['User']['email'])) {
							$email	=	$isf['User']['email'];
						}  else  {
							$email	=	'';
						}
						
						if (isset ($isf['User']['contact']))  {
							$contact	=	$isf['User']['contact'];
						}  else  {
							$contact	=	'';
						}
						
						if(isset($isf['User']['address'])) {
							$address	=	$isf['User']['address'];
						} else {
							$address	=	'';
						}
						
						if(isset($isf['User']['city'])) {
							$city	=	$isf['User']['city'];
						} else {
							$city	=	'';
						}
						
						if(isset($isf['User']['lives_time'])) {
							$lives_time	=	$isf['User']['lives_time'];
						} else {
							$lives_time	=	'';
						}
						
						if (isset ($isf['User']['lives']))  {
							$lives	=	$isf['User']['lives'];
						}  else  {
							$lives	=	'';
						}

						$response = array (
							'message'=> $resp,
							'user_id' => $user_id,
							'usertype_id' =>$usertype_id,
							'name'=>$first_name,
							'email'=>$email,
							'contact'=>$contact,
							'image'=>FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$isf['User']['profile_image'],
							'address'=>$address,
							'city'=>$city,
							'lives'=>$lives,
							'lives_time'=>$lives_time,
							'status' => 1
						);
						echo json_encode($response);
						exit; 
					}
				}  else  {
					$response 									= array('message'=>"Your account has been blocked by Administrator",'status' =>0);
					echo json_encode($response);
					exit; 
				}
			} 
			else {
				$response =array('message'=>"Invalid username and password",'status' =>0);
				echo json_encode($response);
				exit; 			
			}
		}	
		
		/*                                                                                       3rd API      (forgot)                                                                      */
	// 3.  http://app.swimpedia.com/Webservices/forgot?email=gurudutt.sharma@trigma.in
		public function forgot () 
		{		
			$this->User->recursive 		= 	-1;
			$email 								= 	$_REQUEST['email'];
			$fu 									= 	$this->User->find('first', array('conditions' => array('User.email' => $email)));
			if ($fu)  {
				if ($fu['User']['status'] == "1")  {
					$key 						=	Security::hash(String::uuid(), 'sha512', true);
					$hash 						= 	sha1($fu['User']['email'] . rand(0, 100));
					$url 							= 	Router::url(array('controller' => 'admin/users', 'action' => 'reset'), true) . '/' . $key . '#' . $hash;
					$ms 							= 	"<p>Hi <br/>".$fu['User']['first_name'].",<br/><a href=".$url.">Click here</a> to reset your password.</p><br /> ";
					$fu['User']['token'] 		= $key;
					$this->User->id 		= $fu['User']['id'];
					if ($this->User->saveField('token', $fu['User']['token']))  {
						$l 							= new CakeEmail();
						$l->emailFormat ('html')->template ('signup', 'fancy')->subject ('Reset Your Password')->to ($email)->from ('gurudutt.sharma@trigma.in')->send($ms);
						$response				= array('message'=>"Check Your Email To Reset your password");
						echo json_encode($response);
						exit;
					}  else  {				
						$response 			= array('message'=>"Please try again");
						echo json_encode($response);
						exit;                                
					}
				}  else  {                             
					$response 				= array('message'=>"Your account has been blocked by Administrator");
					echo json_encode($response);
					exit;
				}
			}  else  {				
				$response 					= array('message'=>"Email does not exist");
				echo json_encode($response);
				exit;				
			}
		}
		
		/*************************************************************** API (4) ***********************************************/
		//	http://app.swimpedia.com/Webservices/forgot?email=gurudutt.sharma@trigma.in
		public function admin_reset ($token = null) 
		{
			$this->User->recursive = -1;
			if (!empty($token))  {
				$u = $this->User->findBytoken($token);
				if ($u)  {
					$this->User->id = $u['User']['id'];
					if (!empty ($this->data)) {
						if ($this->data['User']['password'] != $this->data['User']['password_confirm'])  {
							$this->Session->setFlash("Both the passwords are not matching...");
							return;
						}
						$this->User->data 								= $this->data;
						$this->User->data['User']['username'] 	= $u['User']['username'];
						$new_hash 										= sha1($u['User']['username'] . rand(0, 100)); //created token
						$this->User->data['User']['token'] 		= $new_hash;
						
						if ($this->User->validates(array('fieldList' => array('password', 'password_confirm')))) {
							if ($this->User->save($this->User->data))  {
								echo "Your password has been updated";
								exit;
							}
						}  else  {
							$this->set('errors', $this->User->invalidFields());
						}
					}
				}  else  {
					$this->Session->setFlash('Token Corrupted, Please Retry.the reset link <a style="cursor: pointer; color: rgb(0, 102, 0); text-decoration: none; background: url("http://files.adbrite.com/mb/images/green-double-underline-006600.gif") repeat-x scroll center bottom transparent; margin-bottom: -2px; padding-bottom: 2px;" name="AdBriteInlineAd_work" id="AdBriteInlineAd_work" target="_top">work</a> only for once.');
				}
			}
		}
		
		/*
			5th API      (change_password)
		*/
		//    4. http://app.swimpedia.com/admin/webservices/changepass?email=guru@gmail.com&opass=123456&cpass=lavkush&newpass=gurudutt

		public function admin_changepass () 
		{         
			$result			=  array();
			$password 	=	AuthComponent::password($_REQUEST['opass']);
			$em				=	$_REQUEST['email'];
			$pass			=	$this->User->find('first',array('conditions'=>array('OR'=>array('User.username'=>$em,'User.email' => $em))));
			$result['user_id']	=	$pass['User']['id'];
			
			if ($pass['User']['password']==$password)  {
				
				if ($_REQUEST['newpass'] != $_REQUEST['cpass'] ) {
					$result['message']="New password and Confirm password field do not match";                          
				}  else  {
					$_REQUEST['opass'] 	= $_REQUEST['newpass'];
					$this->User->id 			= $pass['User']['id'];
					
					if ($this->User->exists())  {
						$pass	= array('User'=>array('password'=>$_REQUEST['newpass']));
						
						if ($this->User->save($pass))  {
						   $result['message']	=	"Password updated";                              
						}
					}
				}
			}  else  {
				$result['message']				=	"Your old password did not match.";                             
			}        
			echo json_encode($result);
			exit;
		}
		
		/* 
			6th API      (MyProfile)
		*/
		 //http://app.swimpedia.com/admin/webservices/myProfile?id=207
		
		public function admin_myProfile () 
		{  
			$id	=	$_REQUEST['id'];
			$this->User->id	=	$id;
			
			if ($this->User->exists())  {    
				$user	=	$this->User->find('all',array('conditions'=>  array('User.id'=>$id)));
				foreach ($user as $key => $value)  {
					if (!empty ($value['User']['profile_image']))  {
						$profileImage = FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$value['User']['profile_image'];
					}  else  {
						$profileImage = '';
					}
					
					if (isset ($value['User']['username']))  {
						$username	=	$value['User']['username'];
					} else {
						$username	=	'';
					}
					
					if (isset ($value['User']['email']))  {
						$email	=	$value['User']['email'];
					}  else  {
						$email	=	'';
					}
					
					if (isset ($value['User']['contact']))  {
						$contact	=	$value['User']['contact'];
					}  else  {
						$contact	=	'';
					}
					
					if (isset ($value['User']['address']))  {
						$address	=	$value['User']['address'];
					}  else  {
						$address	=	'';
					}
					
					if (isset ($value['User']['first_name'])) {
						$first_name	=	$value['User']['first_name'];
					} else {
						$first_name	=	'';
					}
					
					if (isset ($value['User']['birthday'])) {
						$birth_day	=	$value['User']['birthday'];
					}  else  {
						$birth_day	=	'';
					}
					
					if (isset ($value['User']['register_date'])) {
						$register_date	=	$value['User']['register_date'];
					} else {
						$register_date	=	'';
					}
					$data	=  array(
						'id'=>$value['User']['id'],
						'username'=>$username,
						'email'=>$email,
						'profile_image'=>$profileImage,
						'contact'=>$contact,
						'address'=>$address,
						'name'=>$first_name,
						'date of birth'=>$birth_day,
						'register_date'=>$register_date,
						'status'=>1
						);
				}        
				echo json_encode($data);exit;
			}  else {
				$data = array('status'=>0,'msg'=>'Invalid User');
				 echo json_encode($data);exit;
			}    
		}
		
		/*                                                                                       7th API      (profile_edit)                                                                      */
		// http://app.swimpedia.com/admin/webservices/profile_edit?id=207&email=sharmq1a@gmail.com&profile_image=images.png&password=123456		

		public function admin_profile_edit () 
		{
			$this->loadModel('User');
			$this->User->id = $_REQUEST['id'];
			if (!$this->User->exists()) 
			{	
				throw new NotFoundException(__('Invalid user'));
			}
			
			$user_email_exist	=	$this->User->find ('first',array('conditions'=>array('User.email'=>$_REQUEST['email'],'NOT'=>array('User.id'=>$_REQUEST['id']))));
			
			$result	=  array ();
			if (empty($user_email_exist)) {
				
				if(!empty($_REQUEST['email']))
				{
					$this->request->data['User']['email']				= $_REQUEST['email'];
				} 							
				if(!empty($_REQUEST['profile_image']))
				{
					$this->request->data['User']['profile_image']	= $_REQUEST['profile_image'];
				} 		
				if(!empty($_REQUEST['password']))
				{
					$this->request->data['User']['password']		= $_REQUEST['password'];
				} 
				
				$id = $_REQUEST['id'];
			
				if ($this->User->save($this->request->data)) {
					if(isset($_REQUEST['profile_image'])&&!empty($_REQUEST['profile_image']))
					{
						$ti=date('Y-m-d-g:i:s');
						$dname= $ti.$id."image.png";
						$this->User->saveField('profile_image',$dname);
						@$_REQUEST['profile_image']= str_replace('data:image/png;base64,', '', $_REQUEST['profile_image']);
						$_REQUEST['profile_image'] = str_replace(' ', '+',$_REQUEST['profile_image']);
						$unencodedData=base64_decode($_REQUEST['profile_image']);
						$pth3 = WWW_ROOT.'files' . DS . 'profileimage'. DS .$dname;
						file_put_contents($pth3, $unencodedData);
					}
					$user	=	$this->User->find('first',array('conditions'=>  array('User.id'=>$id)));	
					if (!empty($user['User']['profile_image'])){
						$profileImage = FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$user['User']['profile_image'];
					} else {
						$profileImage = '';
					}
					if ($user['User']['usertype_id']	!= ''){
						$user['User']['usertype_id'] 	=	$user['User']['usertype_id'];
					} else {
						 $user['User']['usertype_id'] =	'';
					}
					if ($user['User']['username'] != '')  {
						$user['User']['username']	=	$user['User']['username'];
					} else {
						$user['User']['username']	= '';
					}			
					if ($user['User']['email']	!= '') {
						$user['User']['email'] 	=	$user['User']['email'];
					} else {
						 $user['User']['email'] = '';
					}
					if ($user['User']['contact'] != ''){
						$user['User']['contact']	=	$user['User']['contact'];
					} else {
						$user['User']['contact']	='';
					}	
					
					$result['id']					= $user['User']['id']; 
					$result['username']		= $user['User']['username']; 
					$result['image']			= $profileImage; 
					$result['email']			= $user['User']['email']; 
					$result['message']		= 'The details has been updated';
				} 
				else {
					$result['message']= 'The details could not be saved. Please, try again.';    
				}
				echo json_encode($result);
				exit();
			}
				$result['message']= 'Email already exist.';    
				echo json_encode($result);
				exit();
		}	
		
		/*
			8th API	
			Get topic list 
		*/
		//http://app.swimpedia.com/admin/Webservices/topics?user_id=2236
		public function admin_topics () 
		{			
			$user_id	= 	@$_REQUEST['user_id'];
			
			$this->Topic->virtualFields	=	array (
				'total_question'		=> 'select count(question) from questions where questions.topic_id = Topic.id',
				'attempt_question'	=> 'select count(id) from question_answers where question_answers.topic_id=Topic.id and question_answers.user_id ='.$user_id.''
				);
			$data 	= 	$this->Topic->find ('all');

			if (!empty($data)) {
				$response = array();
				foreach($data as $key=>$value) {
					if ($value['Topic']['total_question'] != $value['Topic']['attempt_question']) {
						$response[]	=	array(
							'status'					=> 1,
							'topic_id'				=> @$value['Topic']['id'],
							'topic_name'			=> @$value['Topic']['name'],										
							'all_attempt_status'	=> 1										
						);
					} 
				}
				if (!empty($response)) {
					echo json_encode ($response);exit;
				} else {
					$response[] = array('status'=>0,'msg'=>'All topics complete.');
					echo json_encode ($response);exit;
				}
			} else {
				$response[] = array('status'=>0,'msg'=>'no topics found.');
				echo json_encode ($response);exit;
			}	
		}
		
		/*
			9th API      
			(Question Answer Listing)
		*/
		//http://app.swimpedia.com/admin/webservices/topic_list?topic_id=4&user_id=207
		public function admin_topic_list () {
		
			$topic_id				= 	@$_REQUEST['topic_id'];
			$user_id				= 	@$_REQUEST['user_id'];
			
			/*
			*	Get Questions Id from question_answers table    
			*/
			$answer_question 		=  array();
			$answered_questions	=	array();
			
			$answer_question	=	$this->QuestionAnswer->find (
				'list',array(
					'conditions'=>array(
						'QuestionAnswer.user_id'			=> $user_id,
						'QuestionAnswer.topic_id'			=> $topic_id,
						'QuestionAnswer.current_status'	=> 1
					),
					'fields' => array('QuestionAnswer.question_id')
				)				
			);		
			
			if (!empty($answer_question)) {
				$answered_questions = array_values ($answer_question);
			}
			/*
				Get all questions from question table 
				not in that question arrive in question answer table
				with a randum order
			*/
			$this->Question->virtualFields = array(
					'user_lives' => 'SELECT lives FROM users where users.id ='.$user_id.''
				);
			$questions 			= 	$this->Question->find (
				'all',array(
					'conditions'=>array(
						'Question.topic_id'	=> $topic_id,
						'NOT'=>array(
							'Question.id'		=> $answered_questions
						)
					),
					'order' => 'rand()',
					'limit'=>1
				)
			);		
          // pr($questions);
			$right_option			=	array ();
			$other_option		=	array ();

			if (!empty($questions)) {
				foreach ($questions as $key=>$value) {
				
					/* 
						Get right option and 
						other options of Question
					*/
					foreach ($value['Answer'] as $ans) {
						if ($ans['right_question'] == 1) {
							$right_answer	=	$ans['answer'];
							array_push($right_option,$ans['answer']);
						}	else {
							array_push($other_option,$ans['answer']);
						}
					}
					// pr($other_option);
					$other_option	= array_merge ($other_option,$right_option);	
					// pr($other_option);
					$count_value	 	= count($other_option);
					$val1 				= $count_value - 1; 
					$val 					= rand(0,3);
					
					$x 					= $other_option[$val];
					$other_option[$val]		= 	$other_option[$val1];
					$other_option[$val1]	= 	$x;
					
					if (isset($other_option[0])) {
						$answer1	= $other_option[0];
					} else
					{
						$answer1	= '';
					}
					if (isset($other_option[1])) {
						$answer2	= $other_option[1];
					} else
					{
						$answer2	= ' ';
					}
					if (isset($other_option[2])) {
						$answer3	=$other_option[2];
					} else
					{
						$answer3	= ' ';
					}
					if (isset($other_option[3])) {
						$answer4	=$other_option[3];
					} else {
						$answer4	= ' ';
					}
					if (isset($right_answer)) {
						$right_answer	=	$right_answer;
					} else
					{
						$right_answer	= '';
					}
					
					$response[] = array (				
						'status'					=> 1,
						'topic_id'				=> $topic_id,
						'question_id'			=> $value['Question']['id'],
						'question'				=> $value['Question']['question'],
						'answers1'				=> $answer1,
						'answers2'				=> $answer2,
						'answers3'				=> $answer3,
						'answers4'				=> $answer4,
						'corrrect_answer'	=> $right_answer,
						'user_lives'			=> $value['Question']['user_lives']
					);
				}
				
				//pr($response);die;
				if (empty($response))  {
					$response[] = array (				
						'status'					=> 0,
						'message'				=> 'Please reload..'
					);
				}
				echo json_encode($response);exit;
			} else {
				$response[] = array('status'=>0,'msg'=>'no question found.');
				echo json_encode($response);exit;
			}
		}
		
		/*
			10th API
			Get question listing
		*/
		//http://app.swimpedia.com/admin/Webservices/question_list
		public function admin_question_list () 
		{
			$data = $this->Question->find ('all');
			if (!empty($data)) {
				foreach($data as $key=>$value) {
					$response[]=array(
						'id'				=> @$value['Question']['id'],
						'question'		=> @$value['Question']['question'],
						'topic_id'		=> @$value['Question']['topic_id'],
						'topic_name'	=> @$value['Topic']['name'],
						'answer'		=> @$value['Answer'],
						'status'			=> @$value['Question']['status']						
					);
				}
				//pr($response);die;
				echo json_encode($response);exit;
			} else {
				$response = array('status'=>0,'msg'=>'no topics found.');
				echo json_encode ($response);exit;
			}			
		}
		
		/*
			11th API
			Update user Notification
		*/
		//http://app.swimpedia.com/Webservices/user_notification
		
		public function admin_user_notification () 
		{
			$id = $_REQUEST['id'];
			$user_info = $this->User->find('first',array('conditions'=>array('User.id'=>$id),'fields'=>array('id','username','email','usertype_id','status','user_notification')));
			
			$data	= array();
			if ($user_info['User']['user_notification'] == 1) {
				$this->User->id							= $id;
				$data['User']['user_notification']	=	0;
				
				$this->User->save($data);
				
				$data = array('status'=>0,'msg'=>'User Notification has been updated.','user_id'=>$id);
				echo json_encode($data);
				exit;
			} else {
				$this->User->id							= $id;
				$data['User']['user_notification']	= 1;
				$this->User->save($data);
				$data = array('status'=>1,'msg'=>'User Notification has been updated.','user_id'=>$id);
				echo json_encode($data);
				exit;
			}
		}
		
		/*
			12 API
			
		*/
		// http://app.swimpedia.com/Webservices/user_details?user_id=207
		
		public function admin_user_details () 
		{
			$id 				= $_REQUEST['user_id'];
			$user_info		= $this->User->find('first',array('conditions'=>array('User.id'=>$id),'fields'=>array('id','username','email','profile_image','usertype_id','status','user_notification')));
			$id				=	$user_info['User']['id'];
			$userName 	= 	$user_info['User']['username'];			
			$image 		= 	FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$user_info['User']['profile_image'];
			$userScore 	= 	100; 
			$data 			= array('status'=>1,'msg'=>'Get user Details.','user_id'=>$id,'userName'=>$userName,'image'=>$image,'userScore'=>$userScore);
			//pr ($data);die;
			echo json_encode($data);
			exit;
		}

		/*
			13 API     
			(admin_question_answers)
		*/
		// http://app.swimpedia.com/admin/Webservices/question_answers?user_id=209&question_id=65745&topic_id=20&answer_id=3 Summer Olympics&points=5555&answer_status=1
		
		public function admin_question_answers () 
		{
			$answerName 	= 	$_REQUEST['answer_id'];
			$question_id	 	=	$_REQUEST['question_id'];
			//$answer			=	$this->Answer->find ('first',array('conditions'=>array('Answer.answer'=>$answerName,'Answer.question_id'=>$question_id)));
			ini_set('memory_limit', '256M');
			$answer			=	$this->Answer->find (
				'first',array(
					'conditions'=>array(
						'AND'=>array (
							'Answer.answer'=>$answerName,
							'Answer.question_id'=>$question_id
						)
					)
				)
			);
			//pr ($answer);die;
			@$answer_id 	= 	$answer['Answer']['id'];
			if (empty($answer)) {
				$response 			= array('status'=>0,'msg'=>'Error:Please try again !');
				echo json_encode($response);
				exit;	
			}
			if (!empty ($_REQUEST)) {
			
				if (isset($_REQUEST['user_id'])) {
					$data['QuestionAnswer']['user_id']		= $_REQUEST['user_id'];
				} else {
					$data['QuestionAnswer']['user_id']		= '';
				}
				
				if (isset($_REQUEST['question_id'])) {
					$data['QuestionAnswer']['question_id']	= $_REQUEST['question_id'];
				} else {
					$data['QuestionAnswer']['question_id']	= '';
				}
				
				if (isset($_REQUEST['topic_id'])) {
					$data['QuestionAnswer']['topic_id']		= $_REQUEST['topic_id'];
				} else {
					$data['QuestionAnswer']['topic_id']		= '';
				}
				
				if (isset($answer_id)) {
					$data['QuestionAnswer']['answer_id']	= $answer_id;
				} else {
					$data['QuestionAnswer']['answer_id']	= '';
				}
				
				if (isset($_REQUEST['points'])) {
					$data['QuestionAnswer']['points']			= $_REQUEST['points'];
				} else {
					$data['QuestionAnswer']['points']			= '';
				}
				
				if (isset($_REQUEST['answer_status'])) {
					$data['QuestionAnswer']['answer_status']	= $_REQUEST['answer_status'];
				} else {
					$data['QuestionAnswer']['answer_status']	= '';
				}
				
				$data['QuestionAnswer']['current_status']	=	1;
				
				$this->QuestionAnswer->create();
				if ($this->QuestionAnswer->save($data)) {
					$lastId					=	$this->QuestionAnswer->getLastInsertId ();
					$latestAnsDetails 	= $this->QuestionAnswer->find ('first',array('conditions'=>array('QuestionAnswer.id'=>$lastId)));
					//pr ($latestAnsDetails);die;
					$user_id	= $latestAnsDetails['QuestionAnswer']['user_id'];			
					$topic_id	= $latestAnsDetails['QuestionAnswer']['topic_id'];			
					
					$this->QuestionAnswer->virtualFields = array(
						'right_answer' 	=> 'SELECT count(id) FROM question_answers where question_answers.user_id ='.$user_id.' and question_answers.topic_id='.$topic_id.' and question_answers.answer_status = 1',
						'wrong_answer' 	=> 'SELECT count(id) FROM question_answers where question_answers.user_id ='.$user_id.' and question_answers.topic_id='.$topic_id.' and question_answers.answer_status = 0',
						'attempt_question' 	=> 'SELECT count(id) FROM question_answers where question_answers.user_id ='.$user_id.' and question_answers.topic_id='.$topic_id,
						'total_question'	=> 'select count(question) from questions where questions.topic_id ='.$topic_id,
					);
									
					$count_score = $this->QuestionAnswer->find (
						'first',array(
							'fields'		=> array('id','user_id','topic_id','right_answer','wrong_answer','attempt_question','total_question'),
							'conditions'=> array('QuestionAnswer.user_id'=>$user_id,'QuestionAnswer.topic_id'=>$topic_id)
						)
					);
					//pr ($count_score);die;
					$total_question	= 	$count_score['QuestionAnswer']['total_question'];
					$right_anwers	= 	$count_score['QuestionAnswer']['right_answer'];
					$wrong_anwers = 	$count_score['QuestionAnswer']['wrong_answer'];
					$total_anwers	= 	$right_anwers + $wrong_anwers;
					$attemptQstn		=	($total_anwers*100) / $total_question;
					$totalpercent		= 	($right_anwers/$total_anwers)*100;
					if ($data['QuestionAnswer']['answer_status'] == 1) {
						$response		= array('status'=>1,'msg'=>'Score Update .','total_right%'=>$totalpercent,'attempt_question'=>$attemptQstn);
						echo json_encode($response);
						exit;
					} else {
						$response 	= array('status'=>0,'msg'=>'Score Not Update .','total_right%'=>$totalpercent,'attempt_question'=>$attemptQstn);
						echo json_encode($response);
						exit;
					}
				} else {
					$response 				= array('status'=>0,'msg'=>'Score Not Update .');
					echo json_encode($response);
					exit;
				}
			}
			
			$response 			= array('status'=>0,'msg'=>'Score Not Update .');
			echo json_encode($response);
			exit;
		}
		
		/*	
			14th API
			Delete All id from question_answers table where user_id and topic_id exist 
		*/
		//http://app.swimpedia.com/admin/webservices/quit_quize?topic_id=4&user_id=207
	
		public function admin_quit_quize () 
		{
			$topic_id				= 	@$_REQUEST['topic_id'];
			$user_id				= 	@$_REQUEST['user_id'];			
			if ($this->QuestionAnswer->updateAll (				
				array(
				'QuestionAnswer.quit_status' => 1
				),
				array(
				'QuestionAnswer.topic_id' => $topic_id,
				'QuestionAnswer.user_id' => $user_id				
				)
			)) {				
				$response = array('status'=>1,'msg'=>'success.');
				echo json_encode($response);exit;
			} else {
				$response = array('status'=>0,'msg'=>'error occured.');
				echo json_encode($response);exit;
			}
		}
		/*
			15 API   
			Save data in queston_answers table with 
			answer_id = 0, points = 0, answer_status = 1, current_status = 1, skip_status = 1,
		*/
		/*http://app.swimpedia.com/admin/Webservices/skip_question?user_id=209&question_id=65745&topic_id=20*/
		
		public function admin_skip_question () 
		{
			if (!empty ($_REQUEST)) {
				if (isset($_REQUEST['user_id'])) {
					$data['QuestionAnswer']['user_id']		= 	$_REQUEST['user_id'];
				} else {
					$data['QuestionAnswer']['user_id']		=	'';
				}
				
				if (isset($_REQUEST['question_id'])) {
					$data['QuestionAnswer']['question_id']	= 	$_REQUEST['question_id'];
				} else {
					$data['QuestionAnswer']['question_id']	=	'';
				}
				
				if (isset($_REQUEST['topic_id'])) {
					$data['QuestionAnswer']['topic_id']		=	$_REQUEST['topic_id'];
				} else {
					$data['QuestionAnswer']['topic_id']		=	'';
				}
				
				$data['QuestionAnswer']['answer_id']		=	0;
				$data['QuestionAnswer']['points']				=	0;
				$data['QuestionAnswer']['answer_status']	= 	1;				
				$data['QuestionAnswer']['current_status']	=	1;
				$data['QuestionAnswer']['skip_status']		=	1;
				
				$this->QuestionAnswer->create();
				if ($this->QuestionAnswer->save($data)) {
						$response 									= array('status'=>1,'msg'=>'Success.');
						echo json_encode($response);
						exit;
				} else {
					$response 										= array('status'=>0,'msg'=>'Error .');
					echo json_encode($response);
					exit;
				}
			}			
			$response 												= array('status'=>0,'msg'=>'Error .');
			echo json_encode($response);
			exit;
		}
		
		/*
			* 16 API
			* Update power ups of user
			* If record found than update 
			* else save the record 
		*/
		/*http://app.swimpedia.com/admin/Webservices/purchase_power_ups?user_id=209&question_id=65745&topic_id=20&power_up_id=1&remaining=5*/
		/*http://app.swimpedia.com/admin/Webservices/purchase_power_ups?user_id=209&power_up_id=1&remaining=5*/
		
		public function admin_purchase_power_ups() 
		{
			if (!empty ($_REQUEST)) {
				$user_id			= $_REQUEST['user_id'];	
				$power_up_id	= $_REQUEST['power_up_id'];		
				$remaining		= $_REQUEST['remaining'];		
				
				$data				=	$this->UserPowerUp->find ('first',array('conditions'=>array('UserPowerUp.user_id'=>$user_id,'UserPowerUp.power_up_id'=>$power_up_id)));
				if (!empty($data)) {
					if ($this->UserPowerUp->updateAll (
							array (
								'UserPowerUp.remaining' => $remaining
							),
							array(
								'UserPowerUp.user_id' => $user_id,
								'UserPowerUp.power_up_id' => $power_up_id
							)
						)) {
						$response	= array('status'=>1,'msg'=>'Success .');
						echo json_encode($response);
						exit;
					} else {
						$response	= array('status'=>0,'msg'=>'Success .');
						echo json_encode($response);
						exit;						
					}
				}  else {
					$data1['UserPowerUp']['user_id']			=	$user_id;
					$data1['UserPowerUp']['power_up_id']	=	$power_up_id;
					$data1['UserPowerUp']['remaining']		=	$remaining;
					
					if ($this->UserPowerUp->save ($data1)) {
						$response	= array('status'=>1,'msg'=>'Success.');
						echo json_encode($response);
						exit;
					} else {
						$response	= array('status'=>0,'msg'=>'Success .');
						echo json_encode($response);
						exit;	
					}
				}
				
			}			
			$response 			= array('status'=>0,'msg'=>'Error .');
			echo json_encode($response);
			exit;
		}
		
		/*
			17 API
			Total score of user from question_answers table
		*/
		/*http://app.swimpedia.com/admin/Webservices/user_total_score?user_id=207&topic_id=20*/
		
		public function admin_user_total_score () 
		{	
			if (!empty ($_REQUEST)) {

				$user_id	= $_REQUEST['user_id'];			
				$topic_id	= $_REQUEST['topic_id'];

				$this->QuestionAnswer->virtualFields = array(
					'total_points' 				=> 'SELECT sum(points) FROM question_answers where question_answers.user_id ='.$user_id.' and question_answers.topic_id='.$topic_id.'',
					'total_topic_points' 		=> 'SELECT sum(points) FROM question_answers where question_answers.user_id ='.$user_id.'',
					'total_questions' 		=> 'SELECT count(id) FROM questions where questions.topic_id ='.$topic_id.'',
					'total_right_anwers' 	=> 'SELECT count(id) FROM question_answers where question_answers.user_id ='.$user_id.' and question_answers.topic_id='.$topic_id.' and question_answers.answer_status = 1',
					'total_wrong_anwers' 	=> 'SELECT count(id) FROM question_answers where question_answers.user_id ='.$user_id.' and question_answers.topic_id='.$topic_id.' and question_answers.answer_status = 0'
				);
				
				$count_score = $this->QuestionAnswer->find (
					'first',array(
						'fields'		=> array('id','user_id','topic_id','total_points','total_topic_points','total_questions','total_right_anwers','total_wrong_anwers'),
						'conditions'=> array('QuestionAnswer.user_id'=>$user_id,'QuestionAnswer.topic_id'=>$topic_id)
					)
				);
				
				//pr ($count_score);die;

				if (!empty($count_score)) {
					foreach ($count_score as $info) {
						$response[] = array(
							'status'						=> 1,
							'user_id'					=> $info['user_id'],
							'topic_id'					=> $info['topic_id'],
							'total_points'				=> $info['total_points'],
							'total_topic_points'		=> $info['total_topic_points'],
							'total_questions'			=> $info['total_questions'],
							'total_right_anwers'		=> $info['total_right_anwers'],
							'total_wrong_anwers'	=> $info['total_wrong_anwers'],	
							'message'					=> 'success'
						);
					
					}
					echo json_encode ($response);
					exit;
				} else {
					$response[] 			= array('status'=>1,'total_points'=>0);
					echo json_encode ($response);
					exit;
				}
			}			
			$response[] 			= array('status'=>0,'msg'=>'Error .');
			echo json_encode($response);
			exit;
		}
		
		/*
			18 API  (Cron Job)   
		*/
		/*http://app.swimpedia.com/admin/Webservices/user_lives*/
		
		public function admin_user_lives () 
		{			
			ini_set('memory_limit', '256M');
			$this->User->recursive = -1;
			//mail ('gurudutt.sharma@trigma.in','Cron1','cron1','webmaster@example.com');
			$user 	= $this->User->find ('all',array('fields'=>array('id','lives_time','cron_time','lives')));
			//pr ($user);die;
			$data1 	= new DateTime('');
			if (!empty($user)) {
				foreach ($user as $info) {			
					$data2		= 	new DateTime($info['User']['lives_time']);
					$overdue 	=	$data2->diff($data1);
					$dateDiff	= 	$overdue->h;				
					$dateDiffDay	= 	$overdue->d;				
					$user_id	=	$info['User']['id'];
					//pr ($overdue);die;
					if ($dateDiff >= 1 or $dateDiffDay >=1) {
						$data['User']['id']				=	$user_id;	
						$data['User']['lives']				=	3;	
						$data['User']['lives_time']		=	date('Y-m-d H:i:s');	
						$data['User']['cron_time']	= 	date('Y-m-d H:i:s');
						$this->User->save ($data);
					}
					if ($info['User']['lives'] == 3)  {
						$data['User']['id']				=	$user_id;
						$data['User']['lives_time']		=	date('Y-m-d H:i:s');
						$data['User']['cron_time']	= date('Y-m-d H:i:s');
						$this->User->save ($data);
					}
				}
			}
			die;
		}
		
		/*
			19 API
		*/
		/*http://app.swimpedia.com/admin/Webservices/user_live_update?user_id=147671*/
		
		public function admin_user_live_update () 
		{		
			if (!empty ($_REQUEST))  {
				$user_id	= $_REQUEST['user_id'];			
				$this->User->recursive = -1;
				
				$user = $this->User->find ('first',array('fields'=>array('id','lives','lives_time'),'conditions'=>array('User.id'=>$user_id)));
				
				if (!empty($user)) {
					$lives_time		=	@$user['User']['lives_time'];
					$remaining_time=	date('Y-m-d H:i:s', strtotime("$lives_time + 1 hours"));
					$current_time	=	new DateTime('');
					$data2				= 	new DateTime($remaining_time);
					$overdue 			=	$data2->diff($current_time);
					$dateminutes		= 	$overdue->i;				
					$datesecond		= 	$overdue->s;	
					if ($user['User']['lives'] == 3) {
						$lives_time = date('Y-m-d H:i:s');
					}  
					$user_lives = $user['User']['lives'] - 1;
										
					if ($user_lives >=0) {
						$data['User']['id'] 			= $user_id;
						$data['User']['lives'] 		= $user_lives;
						$data['User']['lives_time'] = $lives_time;
						
						if ($this->User->save($data)) {
							$response[] 			= array('status'=>1,'msg'=>'Success .','user_lives'=>$user_lives,'lives_time'=>$lives_time);
							echo json_encode($response);
							exit;
						} else {
							$response[] 			= array('status'=>0,'msg'=>'Error .');
							echo json_encode($response);
							exit;
						}
					} else {
						$response[] 			= array('status'=>0,'msg'=>'Lives already zero.','dateminutes'=>$dateminutes,'datesecond'=>$datesecond);
						echo json_encode($response);
						exit;
					}
				} else {
					$response[] 			= array('status'=>0,'msg'=>'Error .');
					echo json_encode($response);
					exit;
				}
			}			
			$response[] 			= array('status'=>0,'msg'=>'Error .');
			echo json_encode($response);
			exit;
		}
		
		/*		20 API  */
		/*http://app.swimpedia.com/admin/Webservices/check_lives?user_id=207*/
		
		public function admin_check_lives () 
		{		
			if (!empty ($_REQUEST)) {
				$user_id	= $_REQUEST['user_id'];	
				$this->User->recursive = -1;
				
				$this->User->virtualFields = array(
					'high_score' => 'SELECT sum(points) FROM question_answers where question_answers.user_id ='.$user_id.''
				);
				$user = $this->User->find ('first',array('fields'=>array('id','lives','lives_time','high_score'),'conditions'=>array('User.id'=>$user_id)));
				
				if (!empty($user)) {
					$total_lives 		= $user['User']['lives'];
					$lives_time		= $user['User']['lives_time'];
					$remaining_time= date('Y-m-d H:i:s', strtotime("$lives_time + 1 hours"));
					$current_time	=	new DateTime('');
					$data2				= new DateTime($remaining_time);
					$overdue 			=	$data2->diff($current_time);
					$dateminutes		= 	$overdue->i;				
					$datesecond		= 	$overdue->s;				
					$high_score 		= $user['User']['high_score'];
					
					if ($high_score ==  '') {
						$high_score = 0;
					}
				
					if ($lives_time ==  '') {
						$lives_time = '';
					}
					
					if ($remaining_time ==  '') 
					{
						$remaining_time = '';
					}
					
					if ($total_lives != 0 ) 
					{
						$response[] 	 		= array('status'=>1,'msg'=>'Success .','total_lives'=>$total_lives,'lives_time'=>$lives_time,'remaining_time'=>$remaining_time,'high_score'=>$high_score,'dateminutes'=>$dateminutes,'datesecond'=>$datesecond);
						echo json_encode($response);
						exit;
					} else 
					{
						$response[] 			= array('status'=>0,'msg'=>'Lives already zero.','dateminutes'=>$dateminutes,'datesecond'=>$datesecond,'total_lives'=>$total_lives,'high_score'=>$high_score);
						echo json_encode($response);
						exit;
					}
				} else 
				{
					$response[] 			= array('status'=>0,'msg'=>'Error .');
					echo json_encode($response);
					exit;
				}
			}			
			$response[] 			= array('status'=>0,'msg'=>'Error .');
			echo json_encode($response);
			exit;
		}
		
		/*
			21 API
		*/
		/*http://app.swimpedia.com/admin/Webservices/high_score?user_id=207*/
		
		public function admin_high_score() 
		{
			if (!empty ($_REQUEST)) {
				$user_id	= $_REQUEST['user_id'];			

				$this->QuestionAnswer->virtualFields = array(
					'high_score' 	=> 'SELECT sum(points) FROM question_answers where question_answers.user_id ='.$user_id.'',
					'lives_time' 	=> 'SELECT lives_time FROM users where users.id ='.$user_id.'',
					'lives' 			=> 'SELECT lives FROM users where users.id ='.$user_id.''
				);
				$user_info = $this->User->find ('first',array('conditions'=>array('User.id'=>$user_id)));
				$total_lives1 			=  $user_info['User']['lives'];
				$lives_time1 			=  $user_info['User']['lives_time'];
				$remaining_time1	=  date('Y-m-d H:i:s', strtotime("$lives_time1 + 1 hours"));
				$current_time1		=  new DateTime('');
				$data21				=  new DateTime($remaining_time1);
				$overdue1 			=	$data21->diff($current_time1);
				$dateminutes1		= 	$overdue1->i;				
				$datesecond1		= 	$overdue1->s;		
				//pr ($total_lives1).'<br>';
				//pr ($lives_time1).'<br>';
				//pr ($remaining_time1).'<br>';
				//pr ($current_time1).'<br>';
				//pr ($overdue1);die;
				if ($lives_time1 == '') {
					$lives_time1	=	'';
				}
				if ($remaining_time1 == '') {
					$remaining_time1	=	'';
				}
				
				
				$count_score = $this->QuestionAnswer->find ('first',array('fields'=>array('id','user_id','high_score','lives_time','lives'),'conditions'=>array('QuestionAnswer.user_id'=>$user_id)));
				//pr($user_info);die;
				if (!empty($count_score)) {
					foreach ($count_score as $info) {
						$total_lives 		= $info['lives'];
						$lives_time 		= $info['lives_time'];
						$remaining_time= date('Y-m-d H:i:s', strtotime("$lives_time + 1 hours"));
						$current_time	=	new DateTime('');
						$data2				= new DateTime($remaining_time);
						$overdue 			=	$data2->diff($current_time);
						$dateminutes		= 	$overdue->i;				
						$datesecond		= 	$overdue->s;		
						if ($lives_time == '') {
							$lives_time	=	'';
						}
						if ($remaining_time == '') {
							$remaining_time	=	'';
						}
						$response[] = array(
							'status'				=> 1,
							'high_score'		=> $info['high_score'],	
							'total_lives'			=> $total_lives,	
							'lives_time'			=> $lives_time,	
							'remaining_time'	=> $remaining_time,	
							'message'			=> 'success',
							'dateminutes'		=> $dateminutes,
							'datesecond'		=> $datesecond
						);
					}
					echo json_encode ($response);
					exit;
				} else {
					$response[] = array(
							'status'				=> 1,
							'high_score'		=> 0,	
							'total_lives'			=> $total_lives1,	
							'lives_time'			=> $lives_time1,	
							'remaining_time'	=> $remaining_time1,	
							'message'			=> 'success',
							'dateminutes'		=> $dateminutes1,
							'datesecond'		=> $datesecond1
						);
					echo json_encode ($response);
					exit;
				}
			}			
			$response[] 			= array('status'=>0,'msg'=>'Error .');
			echo json_encode ($response);
			exit;
		}
		
		/*
			22 API  (Cron Job) 
		*/
		/*http://app.swimpedia.com/admin/Webservices/update_click_no*/
		
		public function admin_update_click_no () 
		{			
			$this->User->recursive = -1;
			mail('gurudutt.sharma@trigma.in','Cron2','cron2','webmaster@example.com');
			//$user 	= $this->User->find ('all');
			$user 	= $this->User->find ('all',array('fields'=>array('id','click_no','click_time','cron_time2')));
			$data1 	= new DateTime('');
			
			if (!empty($user))  {
				foreach ($user as $info)  {		
					$click_no		=	$info['User']['click_no'];
					$click_time	=	$info['User']['click_time'];
					$date 			= date_create ($info['User']['click_time']);
					//$days 		= "1 day";
					//date_add($date, date_interval_create_from_date_string($days));
					$expire_date	= 	date_format ($date, 'Y-m-d H:i:s');
					$data2			= 	new DateTime ($expire_date);
					$overdue 		=	$data2->diff ($data1);
					$dateDiff		= 	$overdue->h;					
					$dateDiff1		= 	$overdue->d;					
					$user_id		=	$info['User']['id'];
					if ($click_time	!=	'') {
						if ($dateDiff1 == 1) {
							$data['User']['id']				=	$user_id;	
							$data['User']['click_no']		=	0;	
							$data['User']['click_time']	=	'';	
							$data['User']['cron_time2'] 	= 	date('Y-m-d H:i:s');
							$this->User->save ($data);
						}
					}
				}
			}
			die;
		}
		
		/*
			23 API
		*/
		/*http://app.swimpedia.com/admin/Webservices/count_click_no?user_id=207*/
		
		public function admin_count_click_no () 
		{			
			$this->User->recursive = -1;
			$user_id	=	$_REQUEST['user_id'];
			$user 		=	$this->User->find('first',array('conditions'=>array('User.id'=>$user_id)));
			$click_no	=	$user['User']['click_no'];	

			if (!empty($user)) {
				if ($user['User']['click_no']	< 5) {
					$data['User']['id']				= 	$user_id;	
					$data['User']['click_no']		= 	5;	
					$data['User']['click_time']	= 	date('Y-m-d H:i:s');	
					$this->User->save ($data);
					$response[] 						= 	array('status'=>1,'msg'=>'Success .');
					echo json_encode($response);
					exit;
				}
				$response[]	=	array('status'=>0,'msg'=>'error.','total_click'=>$click_no);
				echo json_encode($response);
				exit;
			}
			
			$response[]		=	array('status'=>0,'msg'=>'Error .');
			echo json_encode($response);
			exit;
		}
		
		/*
			24th API	
			Get topic list 
		*/
		//http://app.swimpedia.com/admin/Webservices/topics_answers_check?user_id=2236
		public function admin_topics_answers_check () 
		{			
			$user_id	= 	@$_REQUEST['user_id'];
			
			$this->Topic->virtualFields	=	array (
				'total_question'		=> 'select count(question) from questions where questions.topic_id = Topic.id',
				'attempt_question'	=> 'select count(id) from question_answers where question_answers.topic_id=Topic.id and question_answers.user_id ='.$user_id.'',
				'right_answer'		=> 'select count(id) from question_answers where question_answers.topic_id=Topic.id and question_answers.answer_status=1 and question_answers.user_id ='.$user_id.'',
				'wrong_answer'		=> 'select count(id) from question_answers where question_answers.topic_id=Topic.id and question_answers.answer_status=0 and question_answers.user_id ='.$user_id.''
				);
			$data 	= 	$this->Topic->find ('all');
			//pr ($data);die;
			if (!empty($data)) {
				$response = array();
				foreach($data as $key=>$value) {
					if ($value['Topic']['total_question'] == $value['Topic']['attempt_question']) {
						$response[]	=	array(
							'status'					=> 1,
							'topic_id'				=> @$value['Topic']['id'],
							'topic_name'			=> @$value['Topic']['name'],										
							'total_question'		=> @$value['Topic']['total_question'],										
							'right_answer'		=> @$value['Topic']['right_answer'],										
							'wrong_answer'		=> @$value['Topic']['wrong_answer'],										
							'all_attempt_status'	=> 1										
						);
					} 
				}
				if (!empty($response)) {
					//pr ($response);
					echo json_encode ($response);exit;
				} else {
					$response[] = array('status'=>0,'msg'=>'No one topic complete.');
					echo json_encode ($response);exit;
				}
			} else {
				$response[] = array('status'=>0,'msg'=>'no topics found.');
				echo json_encode ($response);exit;
			}	
		}
		
		/*
			25th API	
			Report and error
		*/
		//http://app.swimpedia.com/admin/Webservices/report_and_error?question_id=2234&user_id=2236&message=gurudutt is right
		public function admin_report_and_error () 
		{			
			
			$data['ReportAndError']['question_id']	=	@$_REQUEST['question_id'];
			$data['ReportAndError']['user_id']		= 	@$_REQUEST['user_id'];
			$data['ReportAndError']['message']		=	@$_REQUEST['message'];				
			$data['ReportAndError']['date']			=	date('d-m-Y');				
			$question_id										=	$data['ReportAndError']['question_id'];
			$user_id											=	$data['ReportAndError']['user_id'];
			if ($this->ReportAndError->save($data)) {
				$response[] = array('status'=>1,'msg'=>'success');
				echo json_encode ($response);exit;
			} else {
				$response[] = array('status'=>0,'msg'=>'no topics found.');
				echo json_encode ($response);exit;
			}	
		}
		
		/*
			26th API	
			Report and error
		*/
		//http://app.swimpedia.com/admin/Webservices/add_question_answer?question=gurudutt is a ?&answer=sharma/gupta/verma/tyagi/ram/syam
		public function admin_add_question_answer () 
		{
			$data['CustomerQuestion']['question']	=	@$_REQUEST['question'];
			$data['CustomerQuestion']['status']		=	1;
			$answer											=	@$_REQUEST['answer'];
			$answers											=	explode ('/',$answer);
			if (!empty($answers)) {
				if ($this->CustomerQuestion->save($data))  {
					$data1['CustomerQuestionAnswer']['question_id']	 	= 	$this->CustomerQuestion->getLastInsertID();
					for ($i = 0; $i<6; $i++) 
					{	
						if ($i == 0)  {
							$data1['CustomerQuestionAnswer']['right_question'] 	= '1';		
						} else  {
							$data1['CustomerQuestionAnswer']['right_question'] 	= '0';		
						}
						$data1['CustomerQuestionAnswer']['answer']	 			= $answers[$i];			
						$this->CustomerQuestionAnswer->create();
						$this->CustomerQuestionAnswer->save($data1);					
					}
					$response[] = array('status'=>1,'msg'=>'success.');
					echo json_encode ($response);exit;
				}
			} else {
				$response[] = array('status'=>0,'msg'=>'no topics found.');
				echo json_encode ($response);exit;
			}
			
		}
		
		/*
			27th API	
			Report and error
		*/
		//http://app.swimpedia.com/admin/Webservices/count_answer?topic_id=26&question_id=6&answers1=3&answers2=2&answers3=4&answers4=5
		public function admin_count_answer () 
		{
			/**
			* Get question_id 
			* Get answer1 , answer2 , answer3 , answer4 which is the random answers from the admin_topics_list
			**/
			
			$qst_id 	= 	$_REQUEST['question_id'];
			$ans1	=	$_REQUEST['answers1'];
			$ans2	=	$_REQUEST['answers2'];
			$ans3	=	$_REQUEST['answers3'];
			$ans4	=	$_REQUEST['answers4'];
			
			/**
			* Get ids of answers(answer1,......4)
			**/
			
			$data1	=	$this->Answer->find ('first',array('conditions'=>array('Answer.question_id'=>$qst_id,'Answer.answer'=>$ans1),'fields'=>array('id')));
			$data2	=	$this->Answer->find ('first',array('conditions'=>array('Answer.question_id'=>$qst_id,'Answer.answer'=>$ans2),'fields'=>array('id')));
			$data3	=	$this->Answer->find ('first',array('conditions'=>array('Answer.question_id'=>$qst_id,'Answer.answer'=>$ans3),'fields'=>array('id')));
			$data4	=	$this->Answer->find ('first',array('conditions'=>array('Answer.question_id'=>$qst_id,'Answer.answer'=>$ans4),'fields'=>array('id')));
			
			$answer1		=	$data1['Answer']['id'];
			$answer2		=	$data2['Answer']['id'];
			$answer3		=	$data3['Answer']['id'];
			$answer4		=	$data4['Answer']['id'];
			
			/**
			* Count no of users select a particular answer
			*
			**/
			
			if ($answer1 != '' && $answer2 != '' && $answer3 != '' && $answer4 != '' ) {
				$this->QuestionAnswer->virtualFields	=	array (
					'answer1'	=> 'select count(id) from question_answers where question_answers.question_id ='.$_REQUEST['question_id'].' and question_answers.answer_id ='.$answer1.'',
					'answer2'	=> 'select count(id) from question_answers where question_answers.question_id ='.$_REQUEST['question_id'].' and question_answers.answer_id ='.$answer2.'',
					'answer3'	=> 'select count(id) from question_answers where question_answers.question_id ='.$_REQUEST['question_id'].' and question_answers.answer_id ='.$answer3.'',
					'answer4'	=> 'select count(id) from question_answers where question_answers.question_id ='.$_REQUEST['question_id'].' and question_answers.answer_id ='.$answer4.'',
				);
				$data		=	$this->QuestionAnswer->find ('first');
				$response[] = array (
								'question_id'	=> $qst_id,
								'answer1'		=> $data['QuestionAnswer']['answer1'],
								'answer2'		=> $data['QuestionAnswer']['answer2'],
								'answer3'		=> $data['QuestionAnswer']['answer3'],
								'answer4'		=> $data['QuestionAnswer']['answer4'],
								'status'			=> 1
							);
				echo json_encode ($response);exit;				
			} else {
				$response[] = array('status'=>0,'msg'=>'error');
				echo json_encode ($response);exit;
			}	
		}
		
		
		/*
			28th API	
			Laderboard
		*/
		//http://app.swimpedia.com/admin/Webservices/laderboard
		public function admin_laderboard () 
		{
			$this->User->bindModel(
				array(
					'hasMany' => array(
						'QuestionAnswer' => array(
							'className' => 'QuestionAnswer',
							'foreignKey' => 'user_id'
						)
					)
				)
			);
			
			$this->User->virtualFields	=	array (
					'count'	=> 'select count(points) from question_answers where question_answers.user_id =User.id',
					'score'	=> 'select sum(points) from question_answers where question_answers.user_id =User.id',
				);
				
			$users	=	$this->User->find(
				'all',array(
					'conditions'=>array(
						'User.count >'=>0
					),
					'order'=>array(
						'User.score DESC'
					),
					'fields'=>array(
						'User.id','User.username','User.profile_image','User.score'
					),
					'contain'=>array()
				)
			);
			//pr ($users);die;
			
			$counter =1;
			if (!empty($users)) {
				foreach($users as $info) {
					if ($info['User']['score'] !='') {
					
						if($info['User']['profile_image'] != '')  {
							$info['User']['profile_image']	= FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$info['User']['profile_image'];
						}  else  {
							$info['User']['profile_image']	= '';
						}
						$response[]	=	array(
							'status'					=> 1,
							'counter'				=> $counter,
							'user_id'				=> @$info['User']['id'],
							'username'			=> @$info['User']['username'],										
							'profile_image'		=>$info['User']['profile_image'],						
							'score'					=> @$info['User']['score'],										
						);
						$counter = $counter+1;
					} 
				}
				//pr ($response);die;
				echo json_encode ($response);exit;				
			} else {
				$response[] = array('status'=>0,'msg'=>'error');
				echo json_encode ($response);exit;
			}	
		}
		
		//http://app.swimpedia.com/admin/Webservices/distance?lat1=41.031916&lon1=-74.214001&lat2=40.3905350&lon2=74.7603850&unit=M
		public function admin_distance() 
		{ 
			echo CAKE_CORE_INCLUDE_PATH;die;
			//pr($_REQUEST);die;
			$lat1		=	$_REQUEST['lat1'];
			$lon1	=	$_REQUEST['lon1'];
			$lat2		=	$_REQUEST['lat2'];
			$lon2	=	$_REQUEST['lon2'];
			$unit		=	$_REQUEST['unit'];
			$theta 	= 	$lon1 - $lon2;
			@$dist 	= 	sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
			$dist 	= 	acos($dist);
			$dist 	= 	rad2deg($dist);
			$miles 	= 	$dist * 60 * 1.1515;
			$unit 	= 	strtoupper($unit);
			if ($unit == "K")  {
				echo ($miles * 1.609344);
			}  elseif ($unit == "N")  {
				echo ($miles * 0.8684);
			}  else  {
				echo $miles;
			}
			exit;
		}	
				
		//http://app.swimpedia.com/Webservices/correct_topics_percent?user_id=208
		
		function correct_topics_percent () 
		{
			$user_id	= 	@$_REQUEST['user_id'];			
			$this->Topic->virtualFields	=	array (
				'total_question'		=> 'select count(question) from questions where questions.topic_id = Topic.id',
				'attempt_question'	=> 'select count(id) from question_answers where question_answers.topic_id=Topic.id and question_answers.user_id ='.$user_id.'',
				'right_answer'		=> 'select count(id) from question_answers where question_answers.topic_id=Topic.id and question_answers.answer_status=1 and question_answers.user_id ='.$user_id.'',
				'wrong_answer'		=> 'select count(id) from question_answers where question_answers.topic_id=Topic.id and question_answers.answer_status=0 and question_answers.user_id ='.$user_id.''
				);
			$data 	= 	$this->Topic->find ('all');
			//pr ($data);die;
			if (!empty($data)) {
				$response = array();
				foreach($data as $key=>$value) {
						$attemptQuestion  = $value['Topic']['right_answer'] + $value['Topic']['wrong_answer'];
						//pr ($totalQuestion);die;
						$total_question = $value['Topic']['total_question'];
						if ($total_question > 0)  {
							$right_percent = ($attemptQuestion*100)/ $total_question;
						} else {
							$right_percent = 0;
						}
						$response[]	=	array(
							'status'					=> 1,
							'topic_id'				=> @$value['Topic']['id'],
							'topic_name'			=> @$value['Topic']['name'],										
							'total_question'		=> @$value['Topic']['total_question'],										
							'right_answer'		=> @$value['Topic']['right_answer'],										
							'wrong_answer'		=> @$value['Topic']['wrong_answer'],										
							'percent'				=> @$right_percent,										
							'all_attempt_status'	=> 1										
						);
				}
				if (!empty($response)) {
					//pr ($response);
					echo json_encode ($response);exit;
				} else {
					$response[] = array('status'=>0,'msg'=>'No one topic complete.');
					echo json_encode ($response);exit;
				}
			} else {
				$response[] = array('status'=>0,'msg'=>'no topics found.');
				echo json_encode ($response);exit;
			}	
		}		
		
		//http://app.swimpedia.com/Webservices/user_click?user_id=208
		public function user_click () 
		{			
			$this->loadModel('UserClickCount');
			$this->User->recursive = -1;	
			$user = $this->UserClickCount->find ('first',array('conditions'=>array('UserClickCount.user_id'=>$_REQUEST['user_id'])));
			$id = @$user['UserClickCount']['id'];
			// echo $user['UserClickCount']['count'];
			// pr($user);
			if (!empty($user)) {
				if ($user['UserClickCount']['count'] < 6)  {
					$data['UserClickCount']['id']			=	$user['UserClickCount']['id'];	
					$data['UserClickCount']['user_id']	=	$_REQUEST['user_id'];	
					$data['UserClickCount']['count']		=	$user['UserClickCount']['count'] + 1;	
					$data['UserClickCount']['click_time']	=	date('Y-m-d H:i:s');	
					if ($this->UserClickCount->save ($data))  {
						$user1 = $this->UserClickCount->find ('first',array('conditions'=>array('UserClickCount.id'=>$id)));
						$response[] = array('status'=>1,'msg'=>'success','count'=>$user1['UserClickCount']['count'],'click_time'=>$user1['UserClickCount']['click_time']);
						echo json_encode ($response);exit;
					}  else  {
						$response[] = array('status'=>0,'msg'=>'error');
						echo json_encode ($response);exit;
					}
				}  else  {
					$response[] = array('status'=>0,'msg'=>'Already Five click.');
					echo json_encode ($response);exit;
				}
			}  else {
				$data['UserClickCount']['user_id']		=	$_REQUEST['user_id'];	
				$data['UserClickCount']['count']			=	1;	
				$data['UserClickCount']['click_time']		=	date('Y-m-d H:i:s');	
				if ($this->UserClickCount->save ($data))  {
					$user_insert_id  	= 	$this->UserClickCount->getLastInsertID();
					$user1 = $this->UserClickCount->find ('first',array('conditions'=>array('UserClickCount.id'=>$user_insert_id)));
					$response[] = array('status'=>1,'msg'=>'success','count'=>$user1['UserClickCount']['count'],'click_time'=>$user1['UserClickCount']['click_time']);
					echo json_encode ($response);exit;
				}  else  {
					$response[] = array('status'=>0,'msg'=>'error');
					echo json_encode ($response);exit;
				}		
			}
		}
		
		public function admin_update_daycount () 
		{			
			// $this->loadModel
					$this->loadModel('userClickCount');
					$date= date('Y-m-d H:i:s');
			$this->userClickCount->query("update user_click_counts set count= '0' ,click_time= '".$date."' " );
			die;
		}
		
			/*
			32 API  
		*/
		/*http://app.swimpedia.com/Webservices/usercount?user_id=208*/
		
		public function usercount () 
		{			
			// $this->loadModel
			$this->loadModel('UserClickCount');
			$user_insert_id		=	@$_REQUEST['user_id'];	
				$user1 = $this->UserClickCount->find ('first',array('conditions'=>array('user_id'=>$user_insert_id)));
				@$usercount = 5- $user1['UserClickCount']['count'];
					$response = array('status'=>1,'msg'=>'success','user_left'=>$usercount,'user_id'=>$user_insert_id);
					echo json_encode ($response);exit;
			die;
		}
		
		//http:app.swimpedia.com/admin/Webservices/user_power_ups?user_id=35
		public function admin_user_power_ups () 
		{
			$this->loadModel ('UserPowerUp');
			$user_id	=	@$_REQUEST['user_id'];		
			$users		=	$this->UserPowerUp->find('all',array('conditions'=>array('UserPowerUp.user_id'=>$user_id),'contain'=>array('User.id','User.username','PowerUp.id','PowerUp.name')));
			//pr ($users);die;
			if (!empty($users))  {
				$response	=	array ();
				$arr	=	array();
				foreach($users as $key=>$value) {
					array_push ($arr,$value['UserPowerUp']['power_up_id']);
					$response[]	=	array(
						'status'				=> 1,
						'id'					=> @$value['UserPowerUp']['id'],
						'power_up_id'	=> @$value['UserPowerUp']['power_up_id'],										
						'remaining'		=> @$value['UserPowerUp']['remaining'],										
						'name'				=> @$value['PowerUp']['name'],										
					);
				}
				for ($i=1;$i<=4;$i++)  {
					if (in_array($i, $arr)) {
					
					}  else {
						if ($i ==1) {
							$response[]	=	array(
								'status'				=> 1,
								'id'					=> $i,
								'power_up_id'	=> @$i,										
								'remaining'		=> @5,										
								'name'				=> 'freeze',										
							);
						} 	elseif ($i == 2)  {
							$response[]	=	array(
								'status'				=> 1,
								'id'					=> $i,
								'power_up_id'	=> @$i,										
								'remaining'		=> @3,										
								'name'				=> 'jump it',										
							);
						} 	elseif ($i == 3)  {
							$response[]	=	array(
								'status'				=> 1,
								'id'					=> $i,
								'power_up_id'	=> @$i,										
								'remaining'		=> @3,										
								'name'				=> 'people choice',										
							);
						} 	elseif ($i == 4)  {
							$response[]	=	array(
								'status'				=> 1,
								'id'					=> $i,
								'power_up_id'	=> @$i,										
								'remaining'		=> @3,										
								'name'				=> 'half',										
							);
						}
					}
				}
                                arsort($response);
				//pr ($response);
                                //echo json_encode ($response);
                                foreach ($response as $sortData)  {
                                      $responseData[] = array(
								'status'				=> 1,
								'id'					=> $sortData['id'],
								'power_up_id'	=> @$sortData['power_up_id'],										
								'remaining'		=> @$sortData['remaining'],										
								'name'				=> @$sortData['name'],										
							);

                                }
                               //pr ($responseData);
                                $response = $responseData;
				echo json_encode ($response);
				exit;
			} 	else {
				$response[] = array('status'=>0,'msg'=>'No record found.');
				echo json_encode ($response);exit;
			}
		}
		
		//http://app.swimpedia.com/admin/Webservices/user_live_purchase?user_id=208*/
		public function admin_user_live_purchase () 
		{		
			if (!empty ($_REQUEST))  {
				$user_id	= $_REQUEST['user_id'];			
				$this->User->recursive = -1;				
				$user = $this->User->find ('first',array('fields'=>array('id','lives','lives_time'),'conditions'=>array('User.id'=>$user_id)));				
				if (!empty($user)) {								
					$data['User']['id'] 			= $user_id;
					$data['User']['lives'] 		= 3;
					$data['User']['lives_time']		=	date('Y-m-d H:i:s');	
					$data['User']['cron_time']	= date('Y-m-d H:i:s');
					if ($this->User->save($data)) {
						$response[] 			= array('status'=>1,'msg'=>'Success');
						echo json_encode($response);
						exit;
					} else {
						$response[] 			= array('status'=>0,'msg'=>'Error .');
						echo json_encode($response);
						exit;
					}
				} else {
					$response[] 			= array('status'=>0,'msg'=>'Error .');
					echo json_encode($response);
					exit;
				}
			}			
			$response[] 			= array('status'=>0,'msg'=>'Error .');
			echo json_encode($response);
			exit;
		}
	}
