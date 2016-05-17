<?php
	#Project :(Swipe)
	App::uses('AppController', 'Controller');
	App::uses('Xml', 'Utility');
	class WebservicesController extends AppController 
	{
		public $uses = array('Category','AllVideo','ReportVideo','ReportComment','VideoComment','VideoLike','VideoDislike','VideoView','User','UserBlock','UserFollower','FavoriteVideo','SiteSetting');
  		public function beforeFilter() 
		{
			parent::beforeFilter();
			$this->Auth->allow(array('signup','login','forgot','admin_reset','changepass','myProfile','profile_edit','categories','add_video','remove_video','like_video','dislike_video','total_dislikes','all_videos_of_user','all_videos_by_category_id','comment_video','video_comments','views_video','video_details','favorite_video','user_favorite_video','user_following','favorite_video_of_user','add_follower','user_unfollow','user_follower','sitesetting','video_views','userProfile','send_msg','add_twitter_user','all_user_laderboard','getvideo','report_video','report_comment','block_user'));
		}	
		
		# //http://talentswipe.com/Webservices/signup?username=gurudutt1&first_name=guru&last_name=sharma&profile_image=profileimage2.png&email=gurudutt.sharma@trigma.in&register_type=twitter&password=123456&conpassword=123456&twitter_id=123456
		public function signup () 
		{
			if ($_REQUEST['password'] != $_REQUEST['conpassword'])  {
				$response    = 	array('status'=>0,'message'=>'Password  and Conform Password does not match.');
				echo json_encode($response);
				exit;
			}
			$data['User']['username']			=	isset ($_REQUEST['username']) ? $_REQUEST['username'] : '';
			$data['User']['twitter_username']			=	isset ($_REQUEST['username']) ? $_REQUEST['username'] : '';
			$data['User']['first_name']		=	isset ($_REQUEST['first_name']) ? $_REQUEST['first_name'] : '';
			$data['User']['last_name']			=	isset ($_REQUEST['last_name']) ? $_REQUEST['last_name'] : '';
			$data['User']['profile_image']	=	isset ($_REQUEST['profile_image']) ? $_REQUEST['profile_image'] : '';
			$data['User']['email']					=	isset ($_REQUEST['email']) ? $_REQUEST['email'] : '';
			$data['User']['registertype']		=	isset ($_REQUEST['register_type']) ? $_REQUEST['register_type'] : '';		
			$data['User']['status'] 				=	1;
			$data['User']['register_date'] 	= 	date ("Y-m-d"); 
			$data['User']['usertype_id']  	=  7;
			
			if ($_REQUEST['register_type']	==	"facebook")  {	
				$data['User']['fb_id']  			=  @$_REQUEST['fb_id'];		
				$data['User']['twitter_username']	=	'';
				$getFbIDStatus 					=  $this->User->find('first',array('conditions'=>array('User.fb_id'=>$_REQUEST['fb_id'])));
				if (empty($getFbIDStatus))  {
					$fbexist 								= 	$this->User->find('first',array('conditions'=>array('AND'=>array('User.fb_id'=>$_REQUEST['fb_id']))));
					if (empty($fbexist))  {						
						$this->User->create();               
						if ($this->User->save($data)) {
							$user_id  					= 	$this->User->getLastInsertID();
							$this->User->query ("update users set password= '' where id = '".$user_id."'");
							$isf	 				= 	$this->User->find('first',array('conditions'=>array('User.id'=>$user_id)));
							$user_id			=	isset ($isf['User']['id']) ? $isf['User']['id'] : '';	
							$username	=	isset ($isf['User']['username']) ? $isf['User']['username'] : '';								
							$email			=	isset ($isf['User']['email']) ? $isf['User']['email'] : '';	
							$contact			=	isset ($isf['User']['contact']) ? $isf['User']['contact'] : '';	
							$usertype_id	=	isset ($isf['User']['usertype_id']) ? $isf['User']['usertype_id'] : '';	
							if ($isf['User']['profile_image'] == '')  {
								$profile_image = FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .'person-icon.png';
							}  else  {
								$profile_image =FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$isf['User']['profile_image'];
							}
							$response = array (
								'status' 			=> 1,
								'message'		=> 'User Register Successfully',
								'user_id' 		=> $user_id,
								'username'		=> $username,
								'profile_image'			=> $profile_image,
								'email'				=> $email,
								'usertype_id'	=> $usertype_id,
								'register_first_time'	=> 'Yes'		
							);
							echo json_encode($response);die;
							$response 				= 	array('status'=>1,'message'=>'User Register Successfully with facebook','user_id'=>$user_id);
							echo json_encode($response);die;
						}  else  {
							$response					= 	array('status'=>0,'message'=>'Please try again');
							echo json_encode($response);die;
						}
					}  else  {
						$response						= 	array('status'=>3,'message'=>'Facebook id exist, please try another email','user_id' =>$fbexist['User']['id']);
						echo json_encode($response);die;
					} 			
				}  else  {
					$data['User']['id'] = $getFbIDStatus['User']['id'];								
					$id	=	$getFbIDStatus['User']['id'];				
					$data['User']['twitter_username']	=	'';
					$this->User->create();               
					$this->User->save($data);		
					$data = array ();
					$data = array (
								'status' 			=> 3,
								'message'		=> 'facebook id  already exist, please try another user',
								'user_id' 		=> $getFbIDStatus['User']['id'],
								'username'		=> $getFbIDStatus['User']['username'],
								'profile_image'			=> $getFbIDStatus['User']['profile_image'],
								'email'				=> $getFbIDStatus['User']['email'],
								'usertype_id'	=> $getFbIDStatus['User']['usertype_id'],		
							);
					//$response 						= 	array('status'=>3,'message'=>'facebook id  already exist, please try another user','user_id' =>$getFbIDStatus['User']['id']);
					echo json_encode($data);die;
				}
			}  	else if ($_REQUEST['register_type']	==	"twitter")  {	
				$data['User']['twitter_id']  			=  @$_REQUEST['twitter_id'];	
				$data['User']['username']		=	'';
				$getFbIDStatus 					=  $this->User->find('first',array('conditions'=>array('User.twitter_id'=>$_REQUEST['twitter_id'])));
				if (empty($getFbIDStatus))  {
					$fbexist 								= 	$this->User->find('first',array('conditions'=>array('AND'=>array('User.twitter_id'=>$_REQUEST['twitter_id']))));
					if (empty($fbexist))  {						
						$this->User->create();               
						if ($this->User->save($data)) {
							$user_id  					= 	$this->User->getLastInsertID();
							$this->User->query ("update users set password= '' where id = '".$user_id."'");
							$isf	 				= 	$this->User->find('first',array('conditions'=>array('User.id'=>$user_id)));
							$user_id			=	isset ($isf['User']['id']) ? $isf['User']['id'] : '';	
							$username	=	isset ($isf['User']['username']) ? $isf['User']['username'] : '';								
							$email			=	isset ($isf['User']['email']) ? $isf['User']['email'] : '';	
							$contact			=	isset ($isf['User']['contact']) ? $isf['User']['contact'] : '';	
							$usertype_id	=	isset ($isf['User']['usertype_id']) ? $isf['User']['usertype_id'] : '';	
							if ($isf['User']['profile_image'] == '')  {
								$profile_image = FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .'person-icon.png';
							}  else  {
								$profile_image =FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$isf['User']['profile_image'];
							}
							$response = array (
								'status' 			=> 1,
								'message'		=> 'User Register Successfully',
								'user_id' 		=> $user_id,
								'username'		=> $username,
								'profile_image'			=> $profile_image,
								'email'				=> $email,
								'usertype_id'	=> $usertype_id,
								'register_first_time'	=> 'Yes'		
							);
							echo json_encode($response);die;
							$response 				= 	array('status'=>1,'message'=>'User Register Successfully with twitter','user_id'=>$user_id);
							echo json_encode($response);die;
						}  else  {
							$response					= 	array('status'=>0,'message'=>'Please try again');
							echo json_encode($response);die;
						}
					}  else  {
						$response						= 	array('status'=>3,'message'=>'Twitter id exist, please try another email.','user_id' =>$fbexist['User']['id']);
						echo json_encode($response);die;
					} 			
				}  else  {
					//echo "ddd";die;
					$data['User']['id'] = $getFbIDStatus['User']['id'];							
					$id	=	$getFbIDStatus['User']['id'];			
					$data['User']['username']		=	'';
					$this->User->create();   
					$data['User']['profile_image']	=	$_REQUEST['profile_image'];
					
					$data = array (
								'status' 			=> 3,
								'message'		=> 'twitter id  already exist, please try another user',
								'user_id' 		=> $getFbIDStatus['User']['id'],
								'username'		=> $getFbIDStatus['User']['username'],
								'profile_image'			=> $getFbIDStatus['User']['profile_image'],
								'email'				=> $getFbIDStatus['User']['email'],
								'usertype_id'	=> $getFbIDStatus['User']['usertype_id'],		
							);
					//$response 						= 	array('status'=>3,'message'=>'facebook id  already exist, please try another user','user_id' =>$getFbIDStatus['User']['id']);
					echo json_encode($data);die;
				}
			}  else if($_REQUEST['register_type']== "manual")  {				
				$data['User']['twitter_username'] = '';
				$data['User']['password']  	=  AuthComponent::password($_REQUEST['password']);
				$exist 										= 	$this->User->find("first", array("conditions" => array("User.username" => $data['User']['username'])));
				if (empty($exist))  {
					$emailexist 						= 	$this->User->find('first',array('conditions'=>array('AND'=>array('User.email'=>$data['User']['email']))));
					if (empty($emailexist))  {
						$this->User->create();               
						if ($this->User->save($data)) {
							$user_id    					=  $this->User->getLastInsertID();							
							if(@$_REQUEST['profile_image']!='') {  
								$name					=  $user_id."profileImage.png";
								$this->User->saveField('profile_image',$name);
								@$_REQUEST['profile_image']	=  str_replace('data:image/png;base64,', '', @$_REQUEST['profile_image']);
								$_REQUEST['profile_image'] 	=  str_replace(' ', '+',$_REQUEST['profile_image']);
								$unencodedData							=  base64_decode($_REQUEST['profile_image']);
								$pth 												=  WWW_ROOT.'files' . DS . 'profileimage' . DS .$name;
								file_put_contents($pth, $unencodedData);
							 }
							 $isf	 				= 	$this->User->find('first',array('conditions'=>array('User.id'=>$user_id)));
							$user_id			=	isset ($isf['User']['id']) ? $isf['User']['id'] : '';	
							$username	=	isset ($isf['User']['username']) ? $isf['User']['username'] : '';								
							$email			=	isset ($isf['User']['email']) ? $isf['User']['email'] : '';	
							$contact			=	isset ($isf['User']['contact']) ? $isf['User']['contact'] : '';	
							$usertype_id	=	isset ($isf['User']['usertype_id']) ? $isf['User']['usertype_id'] : '';	
							if ($isf['User']['profile_image'] == '')  {
								$profile_image = FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .'person-icon.png';
							}  else  {
								$profile_image =FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$isf['User']['profile_image'];
							}
							$response = array (
								'status' 			=> 1,
								'message'		=> 'User Register Successfully',
								'user_id' 		=> $user_id,
								'username'		=> $username,
								'profile_image'			=> $profile_image,
								'email'				=> $email,
								'usertype_id'	=> $usertype_id,							
								'register_first_time'	=> 'Yes'							
							);
							echo json_encode($response);die;
						}  else  {
							$response			= 	array('status'=>0,'message'=>'Please try again');
							echo json_encode($response);die;
						}
					}  else  {
						$response						= 	array('status'=>3,'message'=>'Email id exist, please try another email');
						echo json_encode($response);die;
					} 					
				}  else  {
					$response 							= 	array('status'=>3,'message'=>'USer already exist, please try another user');
					echo json_encode($response);die;
				}		
			}
			exit;			
		}
		
		// http://dev414.trigma.us/N-166/Webservices/login?email=gurudutt.sharma@trigma123.in&password=123456
		function login ($u = null,$p = null)	
		{
			$this->request->data['User']['username']	=	$_REQUEST['email'];
			$this->request->data['User']['password']	= 	$_REQUEST['password'];                 
			$usern 			= 	$this->request->data['User']['username'];
			$us 				= 	$this->User->find("first", array("conditions" => array("OR"=>array("User.email"=>$usern,"User.username" => $usern))));
			
			if (empty($us))  {
				$response =	array('message'=>"Invalid username and password",'status' =>0);
				echo json_encode($response);exit; 				
			}
			if ($us['User']['status'] != '1') { 
				$response =	array('message'=>"Your account has been blocked by Administrator",'status' =>0);
				echo json_encode($response);exit; 
			}
			App::Import('Utility', 'Validation'); 
			$pass 			=	AuthComponent::password($this->data['User']['password']); 
			$user 			=	$this->request->data['User']['username'];
			$isf 				= 	$this->User->find(
				'first', array(
					'conditions' 	=> array(
						'AND' 		=> array(
							'OR'=>array(
								'User.email' 		=> $user,
								"User.username" => $user
							), 
							'User.password' => $pass
						)
					)
				)
			);
			if (!$isf) {
				$response = 	array('message'=>"Invalid Password",'status' =>0);
				echo json_encode($response);exit; 					
			} 
			$resp 			= 	"You have successfully logged-In";
			$type 			=	$isf['User']['usertype_id'];						
				
			$user_id		=	isset ($isf['User']['id']) ? $isf['User']['id'] : '';
			$username	=	isset ($isf['User']['username']) ? $isf['User']['username'] : '';
			$email			=	isset ($isf['User']['email']) ? $isf['User']['email'] : '';
			$first_name	=	isset ($isf['User']['first_name']) ? $isf['User']['first_name'] : '';
			$last_name	=	isset ($isf['User']['last_name']) ? $isf['User']['last_name'] : '';
			$followers		=	isset ($isf['User']['followers']) ? $isf['User']['followers'] : '';
			$followings	=	isset ($isf['User']['last_name']) ? $isf['User']['followings'] : '';
			$videos			=	isset ($isf['User']['last_name']) ? $isf['User']['videos'] : '';
			$profile_image	=	isset ($isf['User']['profile_image']) ? FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$isf['User']['profile_image'] : '';
			if ($isf['User']['registertype'] == 'facebook')  {
				$profile_image = $value['User']['profile_image'];
			}
			$response		=	array (
				'message'	=> $resp,
				'user_id' 	=> $user_id,
				'username'=> $username,
				'email'		=> $email,
				'first_name'=> $first_name,
				'last_name'=> $last_name,
				'followers'	=> $followers,
				'followings'	=> $followings,
				'videos'		=> $videos,
				'profile_image'	=> $profile_image,
				'status'		=> 1
			);
			//pr ($response);die;
			echo json_encode($response);exit; 
		}
		
		// http://dev414.trigma.us/N-166/Webservices/forgot?email=gurudutt.sharma@trigma.in
		public function forgot () 
		{
			$email 						= 	$_REQUEST['email'];
			$fu 								= 	$this->User->find('first', array('conditions' => array('User.email' => $email)));
			if (empty($fu)) {  
				$response				= array('status'=>0,'message'=>"Email does not exist");
				echo json_encode($response);exit;		
			}
		
			if ($fu['User']['status'] != "1") {
				$response				= array('status'=>0,'message'=>"Your account has been blocked by Administrator");
				echo json_encode($response);exit;
			}
			
			$name = $fu['User']['email'];
			if  ($fu['User']['username'] != '')  {
				$name = $fu['User']['username'];
			} 
			$key 							=	Security::hash(String::uuid(), 'sha512', true);
			$hash 						= 	sha1($fu['User']['email'] . rand(0, 100));
			$url 								= 	Router::url(array('controller' => 'admin/users', 'action' => 'reset'), true) . '/' . $key . '#' . $hash;
			$ms 							= 	"<p>Hi <br/>".$name.",<br/><a href=".$url.">Click here</a> to reset your password.</p><br /> ";
			$fu['User']['token'] 		= $key;
			$this->User->id 		= $fu['User']['id'];
			if ($this->User->saveField('token', $fu['User']['token'])) {
				$l 							= new CakeEmail();
				$l->emailFormat ('html')->template ('signup', 'fancy')->subject ('Reset Your Password')->to ($email)->from ('adamzweibel@gmail.com')->send($ms);
				$response				= array('success'=>1,'message'=>"Check Your Email To Reset your password");
				echo json_encode($response);
				exit;
			} 	else {				
				$response 			= array('status'=>0,'message'=>"Please try again");
				echo json_encode($response);
				exit;                                
			}
		}
		
		//	http://dev414.trigma.us/N-110BB/Webs/reset?email=gurudutt.sharma@trigma.in
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
							} else {
								$this->Session->setFlash("Both fields are required...");
								return;
							}
						} else {
								$this->Session->setFlash("Both fields are required...");
								return;
							}
					}
				} else {
					$this->Session->setFlash('Token Corrupted, Please Retry.the reset link <a style="cursor: pointer; color: rgb(0, 102, 0); text-decoration: none; background: url("http://files.adbrite.com/mb/images/green-double-underline-006600.gif") repeat-x scroll center bottom transparent; margin-bottom: -2px; padding-bottom: 2px;" name="AdBriteInlineAd_work" id="AdBriteInlineAd_work" target="_top">work</a> only for once.');
				}
			}
		}
		
		//    4. http://dev414.trigma.us/N-166/Webservices/changepass?email=rahul@gmail.com&opass=1234567&password=123456&cpass=123456
		public function changepass () 
		{         
			  $result=  array();
                $password =AuthComponent::password($_REQUEST['opass']);
                $em= $_REQUEST['email'];
                $pass=$this->User->find('first',array('conditions'=>array('User.email' => $em)));
				//pr ($pass);die;
				if (empty($pass))  {
					$response = array('status'=>0,'message'=>"Email does not found.");
									echo json_encode($response);
									exit;   
				}
                if($pass['User']['password']==$password){
                     if($_REQUEST['password'] != $_REQUEST['cpass'] ){
									$response = array('status'=>0,'message'=>"New password and Confirm password field do not match");
									echo json_encode($response);
									exit;
                                              
                    }else {
                         $_REQUEST['opass'] = $_REQUEST['password'];
                         $this->User->id = $pass['User']['id'];
                         if($this->User->exists()){
                                $pass= array('User'=>array('password'=>AuthComponent::password($_REQUEST['password'])));
                            if($this->User->save($pass)) {
                         
								$response = array('status'=>1,'message'=>"Password updated");
									echo json_encode($response);
									exit;							   
                            }
                         }
                     }
                 }else{
                           	$response = array('status'=>2,'message'=>"Old Password not match");
									echo json_encode($response);
									exit;                       
                   }               
                    exit;
		}
		
		//http://talentswipe.com/Webservices/myProfile?id=108
		public function myProfile() 
		{  
			$id						=	$_REQUEST['id'];
			$this->User->id	=	$id;
			if($this->User->exists	())  { 	
				$this->User->virtualFields = array(
					'total_videos'	=>  "SELECT count(*) FROM all_videos WHERE all_videos.user_id ='".$id."'",
				);
				$value			=	$this->User->find ('first',array('conditions'=>  array('User.id'=>$id),'contain'=>array('AllVideo','Following','Follower')));
				$url 				= FULL_BASE_URL.$this->webroot.'files' .DS. 'profileimage';
				//echo "<pre>";print_r ($value);die;
				$username 	= !empty($value['User']['username'])?$value['User']['username'] :'';
				$about_me 	= !empty($value['User']['about_me'])?$value['User']['about_me'] :'';
				$twitter_username 	= !empty($value['User']['twitter_username'])?$value['User']['twitter_username'] :'';
				$email			= !empty($value['User']['email'])?$value['User']['email'] :'';
				$first_name	=	isset ($value['User']['first_name']) ? $value['User']['first_name'] : '';
				$last_name	=	isset ($value['User']['last_name']) ? $value['User']['last_name'] : '';
				$followers		=	isset ($value['User']['followers']) ? $value['User']['followers'] : '';
				$followings	=	isset ($value['User']['followings']) ? $value['User']['followings'] : '';
				$videos			=	isset ($value['User']['total_videos']) ? $value['User']['total_videos'] : '';
				$location		=	isset ($value['User']['location']) ? $value['User']['location'] : '';
				$profile			=	isset ($value['User']['profile']) ? $value['User']['profile'] : '';
				$dob				=	isset ($value['User']['dob']) ? $value['User']['dob'] : '';
				$fb_id				=	isset ($value['User']['fb_id']) ? $value['User']['fb_id'] : '';
				$twitter_id				=	isset ($value['User']['twitter_id']) ? $value['User']['twitter_id'] : '';
				$profile_image	=	isset ($value['User']['profile_image']) ? FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$value['User']['profile_image'] : '';
				
				if ($value['User']['profile_image'] == '')  {
					$profile_image 	= FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .'person-icon.png';
				}
				if ($value['User']['registertype'] == 'facebook')  {
					$profile_image	= $value['User']['profile_image'];
				}
				
				$this->AllVideo->virtualFields = array(
					'total_likes_dynamic'		=>  'SELECT count(*) FROM video_likes WHERE AllVideo.id=video_likes.all_video_id and  video_likes.status="Like"',
					'favorite_status'	=>  'SELECT count(*) FROM favorite_videos WHERE AllVideo.id=favorite_videos.all_video_id and favorite_videos.user_id='.$id.'',
					'follower_status'	=>  'SELECT count(*) FROM user_followers WHERE AllVideo.user_id =user_followers.follower_id and user_followers.user_id='.$id.'',
					'total_videos'	=>  'SELECT count(*) FROM all_videos WHERE AllVideo.user_id ='.$id.'',
					'total_view'			=>'SELECT count(*) FROM video_views WHERE AllVideo.id =video_views.all_video_id'
				);
				 
				$user_videos 		= 	$this->AllVideo->find (
					'all',array(
						'conditions'		=> array (
							'AllVideo.user_id'			=>  $id
						),
						'order'				=> array ('AllVideo.date desc'),
						'contain'			=> array('Category')
					)
				);		
				//echo "<pre>"; print_r($user_videos);die;
				// if (!empty($user_videos))  {
					// $total_videos = $user_videos['AllVideo']['total_videos'];
				// }  else {
					// $total_videos = '';
				// }
				//echo "<pre>"; print_r($user_videos);die;
				if (!empty($user_videos))  {		
					//echo "<pre>"; print_r($user_videos);die;
					foreach ($user_videos as $info) {
						if ($info['AllVideo']['thumbnail_images'] != '')  {
							$thumbnail_images 	= FULL_BASE_URL.$this->webroot.'files' . DS . 'thumbnail_images'. DS .$info['AllVideo']['thumbnail_images'];
						}  else {
							$thumbnail_images 	= FULL_BASE_URL.$this->webroot.'files' . DS . 'thumbnail_images'. DS .'index.png';
						}
						$full_video 					= !empty($info['AllVideo']['full_video'])?FULL_BASE_URL.$this->webroot.'files' . DS . 'full_videos'. DS .$info['AllVideo']['full_video'] :'';
						$small_video 				= !empty($info['AllVideo']['small_video'])?FULL_BASE_URL.$this->webroot.'files' . DS . 'small_videos'. DS .$info['AllVideo']['small_video'] :'';
									
						$count 							= 	$this->VideoLike->find ('first',array('conditions'=>array('VideoLike.all_video_id'=>$info['AllVideo']['id'],'VideoLike.user_id'=>$id),'contain'=>array()));
			
						$user_profile 				= 	$this->User->find ('first',array('conditions'=>array('User.id'=>$info['AllVideo']['user_id']),'fields'=>array('User.profile_image,User.registertype,User.username','about_me'),'contain'=>array()));
			
						$profile_image				=	isset ($user_profile['User']['profile_image']) ? FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$user_profile['User']['profile_image'] : '';
			
						if ($user_profile['User']['profile_image'] == '')  {
							$profile_image = FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .'person-icon.png';
						}
						
						if ($user_profile['User']['registertype'] == 'facebook')  {
							$profile_image = $user_profile['User']['profile_image'];
						}						
						
						if ($info['AllVideo']['total_likes_dynamic'] < 0)  {
							$like = 0;
						}  else  {
							$like = $info['AllVideo']['total_likes_dynamic'];
						}						
						
						if (empty($count))  {
							$likes 		= 'No';
							$dislike	=	'No';
						}  else {
							if ($count['VideoLike']['status']  == 'Like')  {
								$likes 		= 'Yes';
								$dislike	=	'No';
							}  
							if ($count['VideoLike']['status']  == 'DisLike')  {
								$likes 		= 'No';
								$dislike	=	'Yes';
							}  
						}				
						
						if ($info['AllVideo']['follower_status']  !=0) {
							$follower_status  = 1;
						}  else {
							$follower_status  = 0;
						} 
						
						if ($info['AllVideo']['favorite_status'] !=0) {
							$favorite_status  = 1;
						}  else {
							$favorite_status  = 0;
						} 
						
						$date123  = date('m/d/y ',strtotime($info['AllVideo']['date']));
						if ($info['AllVideo']['uploaded_by'] =='') {
							$videoBy	=	'';
						}  else {
							$videoBy	=	$info['AllVideo']['uploaded_by'];
						}
						$allvideo[] = array (
							'full_video'				=>$full_video,
							'small_video'			=>$small_video,
							'thumbnail_images'	=>$thumbnail_images,
							'title'						=>$info['AllVideo']['title'],				
							'category_name'	=>$info['Category']['name'],				
							'duration'				=>$info['AllVideo']['duration'],				
							'description'			=>$info['AllVideo']['description'],				
							'video_status'			=>$info['AllVideo']['status'],				
							'total_likes'				=>$like,				
							'videoBy'				=>$videoBy,				
							'total_views'			=>$info['AllVideo']['total_view'],				
							'total_dislikes'			=>$info['AllVideo']['total_dislikes'],				
							'total_comments'	=>$info['AllVideo']['total_comments'],
							'category_id'			=>$info['AllVideo']['category_id'],									
							'user_id'				=>$info['AllVideo']['user_id'],									
							'video_id'				=>$info['AllVideo']['id'],									
							'date'						=>$date123,
							'likes'					=> $likes,
							'dislikes'				=>$dislike,
							'follower_status'		=> $follower_status, 										
							'favorite_status'		=> $favorite_status,
							'profile_image'		=> $profile_image,						
							'username'			=> $user_profile['User']['username'], 		
							
						);
					}
					
				}  else  {
					$allvideo = array();
				}
				$data	=  array (
					'id'				=>$id,
					'username'	=>$username,
					'about_me'	=>$about_me,
					'twitter_username'	=>$twitter_username,
					'name'	=>$first_name.' '.$last_name,
					'first_name'	=>$first_name,
					'last_name'	=>$last_name,
					'email'			=>$email,
					'followers'	=>$followers,
					'followings'	=>$followings,
					'profile_image'=>$profile_image,
					'videos'		=>$videos,
					'location'		=>$location,
					'profile'			=>$profile,
					'dob'			=>$dob,
					'status'		=>1,	
					'fb_id'		=> $fb_id,
					'twitter_id'		=> $twitter_id,
					'allvideo'		=>$allvideo
				);
				//echo "<pre>";print_r ($data);die;
				echo json_encode($data);exit;
			} else {
				$data = array('status'=>0,'msg'=>'Invalid User');
				 echo json_encode($data);exit;
			}   
		}
		
		public function array_sort_by_column(&$arr, $col, $dir = SORT_DESC) 
		{
			$sort_col = array();
			foreach ($arr as $key=> $row) {
				$sort_col[$key] = $row[$col];
			}
			array_multisort($sort_col, $dir, $arr);
		}
		
		public function array_sort_by_column_asc(&$arr, $col, $dir = SORT_ASC) 
		{
			$sort_col = array();
			foreach ($arr as $key=> $row) {
				$sort_col[$key] = $row[$col];
			}
			array_multisort($sort_col, $dir, $arr);
		}
		
		//http://talentswipe.com/Webservices/userProfile?id=3&user_id=14
		public function userProfile() 
		{  
			$id						=	$_REQUEST['id'];
			$user_id				=	$_REQUEST['user_id'];
			$this->User->id	=	$id;
			if ($this->User->exists	())  {    				
				$user				= $this->User->find ('all',array('conditions'=>  array('User.id'=>$id),'contain'=>array('AllVideo')));
				
				//echo "<pre>";print_r ($user);die;
				$userViewVideo	=	$this->User->find (
					'first',array(
						'conditions'	=>  array(
							'User.id'	=> $user_id
						),
						'contain'		=> array(
							'VideoView.all_video_id'
						)
					)
				);
				$userVideoView 	= 	array();
			
				foreach ($userViewVideo['VideoView'] as $userView) {
					array_push ($userVideoView,$userView['all_video_id']);
				}
				
				foreach ($user as $key => $value) {
					$url 					= FULL_BASE_URL.$this->webroot.'files' .DS. 'profileimage';
					$username 	= !empty($value['User']['username'])?$value['User']['username'] :'';
					$about_me 	= !empty($value['User']['about_me'])?$value['User']['about_me'] :'';
					$twitter_username 	= !empty($value['User']['twitter_username'])?$value['User']['twitter_username'] :'';
					$email			= !empty($value['User']['email'])?$value['User']['email'] :'';
					$first_name	=	isset ($value['User']['first_name']) ? $value['User']['first_name'] : '';
					$last_name	=	isset ($value['User']['last_name']) ? $value['User']['last_name'] : '';
					$followers		=	isset ($value['User']['followers']) ? $value['User']['followers'] : '';
					$followings		=	isset ($value['User']['followings']) ? $value['User']['followings'] : '';
					$videos			=	isset ($value['User']['videos']) ? $value['User']['videos'] : '';
					$location		=	isset ($value['User']['location']) ? $value['User']['location'] : '';
					$profile			=	isset ($value['User']['profile']) ? $value['User']['profile'] : '';
					$dob				=	isset ($value['User']['dob']) ? $value['User']['dob'] : '';
					$fb_id				=	isset ($value['User']['fb_id']) ? $value['User']['fb_id'] : '';
					$twitter_id				=	isset ($value['User']['twitter_id']) ? $value['User']['twitter_id'] : '';
					$profile_image	=	isset ($value['User']['profile_image']) ? FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$value['User']['profile_image'] : '';
				
					if ($value['User']['profile_image'] == '')  {
						$profile_image = FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .'person-icon.png';
					}
					
					if ($value['User']['registertype'] == 'facebook')  {
						$profile_image = $value['User']['profile_image'];
					}
					
					$this->AllVideo->virtualFields = array(
						'total_likes_dynamic'		=>  'SELECT count(*) FROM video_likes WHERE AllVideo.id=video_likes.all_video_id and  video_likes.status="Like"',
						'favorite_status'	=>  'SELECT count(*) FROM favorite_videos WHERE AllVideo.id=favorite_videos.all_video_id and favorite_videos.user_id='.$id.'',
						'follower_status'	=>  'SELECT count(*) FROM user_followers WHERE AllVideo.user_id =user_followers.follower_id and user_followers.user_id='.$id.'',
						'total_view'			=>'SELECT count(*) FROM video_views WHERE AllVideo.id =video_views.all_video_id'
					);
					$user_videos 		= 	$this->AllVideo->find (
					'all',array(
							'conditions'		=> array (
								'AllVideo.user_id'			=>  $id,
								'AllVideo.status'			=>  'Yes'
							),
							'order'				=> array ('AllVideo.date desc')
						)
					);	
					//echo "<pre>";print_r($user_videos);die;
					if (!empty($user_videos))  {
						//$this->array_sort_by_column($value['AllVideo'], 'date');		
						foreach ($user_videos as $info) {
							if ($info['AllVideo']['status'] =='Yes')  {
								if ($info['AllVideo']['thumbnail_images'] != '')  {
									$thumbnail_images = FULL_BASE_URL.$this->webroot.'files' . DS . 'thumbnail_images'. DS .$info['AllVideo']['thumbnail_images'];
								}  else {
									$thumbnail_images = FULL_BASE_URL.$this->webroot.'files' . DS . 'thumbnail_images'. DS .'index.png';
								}
								
								$full_video 		= !empty($info['AllVideo']['full_video'])?FULL_BASE_URL.$this->webroot.'files' . DS . 'full_videos'. DS .$info['AllVideo']['full_video'] :'';
								$small_video 	= !empty($info['AllVideo']['small_video'])?FULL_BASE_URL.$this->webroot.'files' . DS . 'small_videos'. DS .$info['AllVideo']['small_video'] :'';
								
								$count 				= 	$this->VideoLike->find ('first',array('conditions'=>array('VideoLike.id'=>$info['AllVideo']['id'],'VideoLike.user_id'=>$id),'contain'=>array()));
					
								$user_profile 	= 	$this->User->find ('first',array('conditions'=>array('User.id'=>$info['AllVideo']['user_id']),'fields'=>array('User.profile_image,User.registertype,User.username'),'contain'=>array()));
								
								if ($info['AllVideo']['total_likes_dynamic'] < 0)  {
									$like = 0;
								}  else  {
									$like = $info['AllVideo']['total_likes_dynamic'];
								}
								
								if (empty($count))  {
									$likes 		= 'No';
									$dislike	=	'No';
								}  else {
									if ($count['VideoLike']['status']  == 'Like')  {
										$likes 		= 'Yes';
										$dislike	=	'No';
									}  
									if ($count['VideoLike']['status']  == 'DisLike')  {
										$likes 		= 'No';
										$dislike	=	'Yes';
									}  
								}
									
								if ($info['AllVideo']['follower_status']  !=0) {
									$follower_status  = 1;
								}  else {
									$follower_status  = 0;
								} 
								
								if ($info['AllVideo']['favorite_status'] !=0) {
									$favorite_status  = 1;
								}  else {
									$favorite_status  = 0;
								} 
								
								$date123  = date('m/d/y ',strtotime($info['AllVideo']['date']));
								if (in_array($info['AllVideo']['id'], $userVideoView))  {
									$video_status = 'Old';
								}   else  {
									$video_status = 'New';
								}
								if ($info['AllVideo']['uploaded_by'] =='') {
									$videoBy	=	'';
								}  else {
									$videoBy	=	$info['AllVideo']['uploaded_by'];
								}
								$allvideo[] = array (
									'full_video'			=>$full_video,
									'small_video'			=>$small_video,
									'thumbnail_images'			=>$thumbnail_images,
									'title'			=>$info['AllVideo']['title'],				
									'description'			=>$info['AllVideo']['description'],				
									'video_status'			=>$info['AllVideo']['status'],				
									'duration'			=>$info['AllVideo']['duration'],				
									'total_likes'			=>$like,				
									'videoBy'			=>$videoBy,				
									'total_views'			=>$info['AllVideo']['total_view'],				
									'category_name'			=>$info['Category']['name'],				
									'total_dislikes'			=>$info['AllVideo']['total_dislikes'],				
									'total_comments'			=>$info['AllVideo']['total_comments'],
									'category_id'			=>$info['AllVideo']['category_id'],									
									'video_id'			=>$info['AllVideo']['id'],									
									'date'			=>$date123,
									'view_status'			=>$video_status,
									'likes'					=> $likes,
									'dislikes'				=>$dislike,
									'follower_status'		=> $follower_status, 										
									'favorite_status'		=> $favorite_status,
									'profile_image'		=> $profile_image,
									'username'		=> $user_profile['User']['username'], 			
									
								);
							}
						}
						
					}  else  {
						$allvideo = array();
					}
					if (empty($allvideo))  {
						$allvideo = array();
					}
					$data	=  array (
						'id'				=>$value['User']['id'],
						'username'	=>$username,
						'about_me'	=>$about_me,
						'twitter_username'	=>$twitter_username,
						'first_name'	=>$first_name,
						'last_name'	=>$last_name,
						'name'	=>$first_name.' '.$last_name,
						'email'			=>$email,
						'followers'	=>$followers,
						'followings'	=>$followings,
						'profile_image'=>$profile_image,
						'videos'		=>$videos,
						'location'		=>$location,
						'profile'			=>$profile,
						'dob'			=>$dob,
						'fb_id'			=>$fb_id,
						'twitter_id'=>$twitter_id,
						'status'		=>1,
						'allvideo'		=>$allvideo
					);
				}    
				//pr ($data);die;
				echo json_encode($data);exit;
			} else {
				$data = array('status'=>0,'msg'=>'Invalid User');
				 echo json_encode($data);exit;
			}    
		}		
				
		// dev414.trigma.us/N-166/Webserviceservices/profile_edit?id=2285&username=rahul&profile=manager&profile_image=profileimage2.png&dob=456&first_name=guru123&last_name=sharm&about_me=testing
		public function profile_edit () 
		{
			$this->loadModel('User');
			$this->User->id = $_REQUEST['id'];
			if (!$this->User->exists()) 
			{	
				throw new NotFoundException(__('Invalid user'));
			}
			$this->User->virtualFields = array(
					'total_videos'	=>  "SELECT count(*) FROM all_videos WHERE all_videos.user_id ='".$_REQUEST['id']."'",
				);
			$user_email_exist	=	$this->User->find ('first',array('conditions'=>array('User.id'=>$_REQUEST['id'])));
			$result	=  array ();
			if (!empty($user_email_exist)) {
										
				if(!empty($_REQUEST['username']))  {
					$this->request->data['User']['username']	= $_REQUEST['username'];
				} 			
				if(!empty($_REQUEST['about_me']))  {
					$this->request->data['User']['about_me']	= $_REQUEST['about_me'];
				} 
				if(!empty($_REQUEST['profile']))  {
					$this->request->data['User']['profile']			= $_REQUEST['profile'];
				} 		
				if(!empty($_REQUEST['dob']))  {
					$this->request->data['User']['dob']				= $_REQUEST['dob'];
				} 
				if(!empty($_REQUEST['first_name']))  {
					$this->request->data['User']['first_name']	= $_REQUEST['first_name'];
				} 		
				if(!empty($_REQUEST['last_name']))  {
					$this->request->data['User']['last_name']	= $_REQUEST['last_name'];
				} 				
								
				$id = $_REQUEST['id'];
			
				if ($this->User->save($this->request->data)) {
					if(isset($_REQUEST['profile_image']) && !empty($_REQUEST['profile_image']))  {
						$ti=time();
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
					$user_id			=	isset ($user['User']['id']) ? $user['User']['id'] : '';
					$username	=	isset ($user['User']['username']) ? $user['User']['username'] : '';
					$about_me	=	isset ($user['User']['about_me']) ? $user['User']['about_me'] : '';
					$email			=	isset ($user['User']['email']) ? $user['User']['email'] : '';
					$first_name	=	isset ($user['User']['first_name']) ? $user['User']['first_name'] : '';
					$last_name	=	isset ($user['User']['last_name']) ? $user['User']['last_name'] : '';
					$followers		=	isset ($user['User']['followers']) ? $user['User']['followers'] : '';
					$followings	=	isset ($user['User']['followings']) ? $user['User']['followings'] : '';
					$videos			=	isset ($user['User']['videos']) ? $user['User']['videos'] : '';
					$profile_image	=	isset ($user['User']['profile_image']) ? FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$user['User']['profile_image'] : '';
					if ($user['User']['profile_image'] == '')  {
						$profile_image = FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .'person-icon.png';
					}
					if ($user['User']['registertype'] == 'facebook')  {
						$profile_image = $user['User']['profile_image'];
					}
					$result['id']					= $user['User']['id']; 
					$result['username']	= $user['User']['username']; 
					$result['about_me']	= $user['User']['about_me']; 
					$result['first_name']	= $user['User']['first_name']; 
					$result['last_name']	= $user['User']['last_name']; 
					$result['followers']		= $user['User']['followers']; 
					$result['followings']	= $user['User']['followings']; 
					$result['videos']			= $user['User']['total_videos']; 
					$result['profile_image']			= $profile_image; 
					$result['email']			= $user['User']['email']; 
					$result['location']		= $user['User']['location']; 
					$result['profile']			= $user['User']['profile']; 
					$result['dob']				= $user['User']['dob']; 
					$result['message']		= 'The details has been updated';
				} 
				else {
					$result['message']= 'The details could not be saved. Please, try again.';    
				}
				echo json_encode($result);
				exit();
			} else {
				$result['message']= 'Somthing error eccor';    
				echo json_encode($result);
				exit();
			}
		}	
		
		// dev414.trigma.us/N-166/Webserviceservices/add_twitter_user?id=2285&twitter_username=guru
		public function add_twitter_user () 
		{
			$this->loadModel('User');
			$this->User->id = $_REQUEST['id'];
			$id = $_REQUEST['id'];
			if (!$this->User->exists()) 
			{	
				$result['message']= 'User Invalid.';  
				echo json_encode($result);die;
			}
			$user_email_exist	=	$this->User->find ('first',array('conditions'=>array('User.id'=>$_REQUEST['id'])));
			$result	=  array ();
			if (!empty($user_email_exist)) {
										
				if(!empty($_REQUEST['twitter_username']))  {
					$this->request->data['User']['twitter_username']	= $_REQUEST['twitter_username'];
				} 			
							
				if ($this->User->save($this->request->data)) {
					$user	=	$this->User->find('first',array('conditions'=>  array('User.id'=>$id)));	
					if (!empty($user['User']['profile_image'])){
						$profileImage = FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$user['User']['profile_image'];
					} else {
						$profileImage = '';
					}
					$user_id			=	isset ($user['User']['id']) ? $user['User']['id'] : '';
					$username	=	isset ($user['User']['username']) ? $user['User']['username'] : '';
					$email			=	isset ($user['User']['email']) ? $user['User']['email'] : '';
					$first_name	=	isset ($user['User']['first_name']) ? $user['User']['first_name'] : '';
					$last_name	=	isset ($user['User']['last_name']) ? $user['User']['last_name'] : '';
					$followers		=	isset ($user['User']['followers']) ? $user['User']['followers'] : '';
					$followings	=	isset ($user['User']['last_name']) ? $user['User']['followings'] : '';
					$videos			=	isset ($user['User']['last_name']) ? $user['User']['videos'] : '';
					$profile_image	=	isset ($user['User']['profile_image']) ? FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$user['User']['profile_image'] : '';
					if ($user['User']['profile_image'] == '')  {
						$profile_image = FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .'person-icon.png';
					}
					if ($user['User']['registertype'] == 'facebook')  {
						$profile_image = $user['User']['profile_image'];
					}
					$result['id']					= $user['User']['id']; 
					$result['username']	= $user['User']['username']; 
					$result['first_name']	= $user['User']['first_name']; 
					$result['last_name']	= $user['User']['last_name']; 
					$result['followers']		= $user['User']['followers']; 
					$result['followings']	= $user['User']['followings']; 
					$result['videos']			= $user['User']['videos']; 
					$result['profile_image']			= $profile_image; 
					$result['email']			= $user['User']['email']; 
					$result['location']		= $user['User']['location']; 
					$result['profile']			= $user['User']['profile']; 
					$result['dob']				= $user['User']['dob']; 
					$result['message']		= 'The details has been updated';
				} 
				else {
					$result['message']= 'The details could not be saved. Please, try again.';    
				}
				echo json_encode($result);
				exit();
			} else {
				$result['message']= 'Somthing error eccor';    
				echo json_encode($result);
				exit();
			}
		}	
		
		//http://dev414.trigma.us/N-166/Webservices/categories
		public function categories () 
		{
			$data 	= 	$this->Category->find ('all');
			if (empty($data)) {
				$response = array('status'=>0,'msg'=>'no category found.');
				echo json_encode ($response);exit;
			}	
			foreach($data as $value) {
				$response[]	=	array(
					'status'				=>1,
					'category_id'		=>$value['Category']['id'],
					'category_name'=>$value['Category']['name'],										
					'image'				=>FULL_BASE_URL.$this->webroot.'files' . DS . 'categoryimages'. DS .$value['Category']['image']										
				);
			}
			//pr ($response);
			echo json_encode($response);exit;
		}		
		
		//http://dev414.trigma.us/N-166/Webservices/sitesetting?q=1
		public function sitesetting () 
		{
			$q = $_REQUEST['q'] ;
			$data 	= 	$this->SiteSetting->find ('first');
			if (empty($data)) {
				$response = array('status'=>0,'msg'=>'no url found.');
				echo json_encode ($response);exit;
			}	
			//echo $q;
			//echo $data['SiteSetting']['twitter_url'];
			//pr ($data);
			if ($q==1)  {
				$response = array('status'=>1,'url'=>$data['SiteSetting']['facebook_url']);
				echo json_encode ($response);exit;
			}   else if ($q==2)    {
				$response = array('status'=>1,'url'=>$data['SiteSetting']['twitter_url']);
				echo json_encode ($response);exit;
			}    else if ($q==3)    {
				$response = array('status'=>1,'url'=>$data['SiteSetting']['instagram']);
				echo json_encode ($response);exit;
			}    else if ($q==4)     {
				$response = array('status'=>1,'url'=>$data['SiteSetting']['linkedin']);
				echo json_encode ($response);exit;
			}
			//pr ($response);
			$response = array('status'=>0,'msg'=>'no url found.');
			echo json_encode ($response);exit;
		}		
		
		//http://admin.talentswipe.com/Webservices/add_video?user_id=2285&category_id=1&full_video=video.mp4&full_video_starting=00:00:5&full_video_ending=00:00:8&title=video&description=video is for nation&thumbnail_image=img.png&small_video=guru.mp4
		public function add_video ()
		{
			if ($_REQUEST['user_id'] 			== '' or 
				$_REQUEST['full_video'] 		== '' or  
				$_REQUEST['full_video_starting'] 		== '' or  
				$_REQUEST['full_video_ending'] 		== '' or  
				$_REQUEST['category_id'] 	== '' or 
				$_REQUEST['title']					== '' or
				$_REQUEST['description']		== '' 
			)  {
				$response = array('status'=>0,'msg'=>'error:wrong parameters.');
				echo json_encode ($response);exit;
			}
			$user_id 		= $_REQUEST['user_id'];
			$video 			= $this->User->find ('first',array('conditions'=>  array('User.id'=>$user_id),'contain'=>array(),'fields'=>array('User.id,User.videos')));
			$totalVideo 	= $video['User']['videos']+1;
			$time 				= time();
			
			$name									=  $time."full_video.mov";
			$_REQUEST['full_video']		=  str_replace('data:video/mov;base64,', '',$_REQUEST['full_video']);
			$_REQUEST['full_video'] 	=  str_replace(' ', '+',$_REQUEST['full_video']);
			$unencodedData					=  base64_decode($_REQUEST['full_video']);
			$pth 										=  WWW_ROOT.'files' . DS . 'full_videos' . DS .$name;
			file_put_contents($pth, $unencodedData);
			
			/*  ------------------------------- Save Small Video  Start------------------------------------- */
			// $smViName								=	$time."small_video.mp4";
			// $_REQUEST['small_video']		=  str_replace('data:video/mov;base64,', '',$_REQUEST['small_video']);
			// $_REQUEST['small_video'] 	=  str_replace(' ', '+',$_REQUEST['small_video']);
			// $unencodedData2						=  base64_decode($_REQUEST['small_video']);
			// $smallVideo 								=  WWW_ROOT.'files' . DS . 'small_videos' . DS .$smViName;
			// file_put_contents($smallVideo, $unencodedData2);
			/*  ------------------------------- Save Small Video  End ------------------------------------- */
			
			$fullVideo									=	$pth;
			
			$xyz = shell_exec("ffmpeg -i \"{$fullVideo}\" 2>&1");
			$search='/Duration: (.*?),/';
			preg_match($search, $xyz, $matches);
			$explode = explode(':', $matches[1]);
			$duration = floor(60*$explode[1] + $explode[2]); 
			
			if ($_REQUEST['thumbnail_image'] !='') {  
				$thumName	=	$time."thumbnailImages.png";
				$_REQUEST['thumbnail_image']	=  str_replace('data:video/mov;base64,', '',$_REQUEST['thumbnail_image']);
				$_REQUEST['thumbnail_image'] 	=  str_replace(' ', '+',$_REQUEST['thumbnail_image']);
				$unencodedData1							=  base64_decode($_REQUEST['thumbnail_image']);
				$thumnailImg										=	WWW_ROOT.'files' . DS . 'thumbnail_images' . DS .$thumName;
				file_put_contents($thumnailImg, $unencodedData1);
			}
			
			$full_video_starting 	=	$_REQUEST['full_video_starting'];
			$full_video_ending	=	$_REQUEST['full_video_ending'] ;
			$smViName				=	$time."small_video.mov";
			$smallVideo				= 	WWW_ROOT.'files' . DS . 'small_videos' . DS .$smViName;
			//$smallVideo1			= 	WWW_ROOT.'files' . DS . 'small_videos' . DS ."test.mp4";
			
			if ($duration > 30)  {
				exec("ffmpeg -i $fullVideo -ss $full_video_starting -t $full_video_ending -async 1 -crf 1 $smallVideo");
			}  else {
				file_put_contents($smallVideo, $unencodedData);
			}
			//exec("ffmpeg -i $fullVideo -ss $full_video_starting -t $full_video_ending -acodec copy -vcodec copy $smallVideo1");
			
			//exec("ffmpeg -i $fullVideo -ss $full_video_starting -t $full_video_ending 'crop=736:414:100:100' $smallVideo1");
				
			
			$data['AllVideo']['user_id']				=	$user_id;
			$data['AllVideo']['category_id']		=	$_REQUEST['category_id'];
			$data['AllVideo']['full_video']			=	$name;
			$data['AllVideo']['small_video']		=	$smViName;
			$data['AllVideo']['thumbnail_images']		=	$thumName;
			$data['AllVideo']['title']						=	$_REQUEST['title'];
			$data['AllVideo']['duration']				=	$duration;
			$data['AllVideo']['description']			=	$_REQUEST['description'];
			$data['AllVideo']['total_likes']			=	0;
			$data['AllVideo']['total_dislikes']		=	0;
			$data['AllVideo']['total_comments']	=	0;
			$data['AllVideo']['total_views']			=	0;
			$data['AllVideo']['date']					=	date("Y-m-d H:i:s");
			$data['AllVideo']['uploaded_by']		=	'User';
			
			if ($this->AllVideo->save ($data))  {
				$this->User->query ("update users set videos= '".$totalVideo."' where id = '".$user_id."'");
				$response = array('status'=>1,'msg'=>'success.');
				echo json_encode ($response);exit;
			}  else  {
				$response = array('status'=>0,'msg'=>'error.');
				echo json_encode ($response);exit;
			}			
		}
		
		//http://admin.talentswipe.com/Webservices/all_videos_of_user?user_id=2285&category_id=all&sort_by=rend
		public function all_videos_of_user ()
		{		
			$user_id 		= 	$_REQUEST['user_id'];
			
			$this->AllVideo->virtualFields = array(
				'total_likes_dynamic'=>  'SELECT count(*) FROM video_likes WHERE AllVideo.id=video_likes.all_video_id and  video_likes.status="Like"',
				'total_dislikes_dynamic'=>  'SELECT count(*) FROM video_likes WHERE AllVideo.id=video_likes.all_video_id and  video_likes.status="DisLike"',
				'total_dislikes_user'=>  'SELECT count(*) FROM video_likes WHERE AllVideo.id=video_likes.all_video_id and  video_likes.status="Like" and  video_likes.user_id='.$user_id.'',
				'total_likes_user'=>  'SELECT count(*) FROM video_likes WHERE AllVideo.id=video_likes.all_video_id and  video_likes.status="DisLike" and  video_likes.user_id='.$user_id.'',
				'favorite_status'			=>'SELECT count(*) FROM favorite_videos WHERE AllVideo.id=favorite_videos.all_video_id and favorite_videos.user_id='.$user_id.'',
				'follower_status'			=>'SELECT count(*) FROM user_followers WHERE AllVideo.user_id =user_followers.follower_id and user_followers.user_id='.$user_id.'',
				'total_view'			=>'SELECT count(*) FROM video_views WHERE AllVideo.id =video_views.all_video_id'
			);
			if (is_numeric(@$_REQUEST['category_id']))  {
				$pageCount = 	$this->AllVideo->find ('count',array('conditions'=>array('AllVideo.category_id'=>$_REQUEST['category_id']),'contain'=>array()));		
				$data 	= 	$this->AllVideo->find (
					'all',array(
						'conditions'=>array(
							'AllVideo.category_id'=>$_REQUEST['category_id'],
							'AllVideo.status'=>'Yes'
						),
						'contain'=>array('Category.name','User.username','User.profile_image','User.registertype','VideoLike','ReportVideo'),
						'order' => array('AllVideo.total_dislikes_user ASC','AllVideo.total_likes_user ASC','AllVideo.total_likes_dynamic ASC','AllVideo.total_dislikes_dynamic ASC','AllVideo.total_view ASC'),
						)
					);		
			}    else   {			
				$pageCount 	= 	$this->AllVideo->find ('count',array('contain'=>array()));		
				$data 				= 	$this->AllVideo->find (
					'all',array(
						'conditions'=>array(
							'AllVideo.status'	=>'Yes'
						),
						'contain'	=>  array('Category.name','User.username','User.profile_image','User.registertype','VideoLike','ReportVideo'),
						'order' 	=>  array('AllVideo.total_dislikes_user ASC','AllVideo.total_likes_user ASC','AllVideo.total_likes_dynamic ASC','AllVideo.total_dislikes_dynamic ASC','AllVideo.total_view ASC')
					)
				);
			}
	
			if (empty($data)) {
				$response = array('status'=>0,'msg'=>'no video found.');
				echo json_encode ($response);exit;
			}	
			//echo "<pre>";print_r($data);die;
			foreach($data as $key=>$value) {
				if ($value['AllVideo']['thumbnail_images'] != '')  {
					$thumbnail_images = FULL_BASE_URL.$this->webroot.'files' . DS . 'thumbnail_images'. DS .$value['AllVideo']['thumbnail_images'];
				}  else {
					$thumbnail_images = FULL_BASE_URL.$this->webroot.'files' . DS . 'thumbnail_images'. DS .'index.png';	
				}
				
				if (!empty($value['VideoLike'])) {
					$count 	= 	$this->VideoLike->find ('first',array('conditions'=>array('AllVideo.id'=>$value['AllVideo']['id'],'VideoLike.user_id'=>$_REQUEST['user_id']),'contain'=>array()));
				}   else {
					$count = 0;
				}	
				
				$profile_image	=	isset ($value['User']['profile_image']) ? FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$value['User']['profile_image'] : '';
					
				if ($value['User']['profile_image'] == '')  {
					$profile_image = FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .'person-icon.png';
				}
				if ($value['User']['registertype'] == 'facebook')  {
					$profile_image = $value['User']['profile_image'];
				}

				if (empty($count))  {
					$likes 		= 'No';
					$dislike	=	'No';
				}  else {
					if ($count['VideoLike']['status']  == 'Like')  {
						$likes 		= 'Yes';
						$dislike	=	'No';
					}  
					if ($count['VideoLike']['status']  == 'DisLike')  {
						$likes 		= 'No';
						$dislike	=	'Yes';
					}  
				}
					
				if ($value['AllVideo']['total_likes_dynamic'] < 0)  {
					$like = 0;
				}  else  {
					$like = $value['AllVideo']['total_likes_dynamic'];
				}
				
				if ($value['AllVideo']['total_dislikes_dynamic'] < 0)  {
					$total_dislikes_dynamic = 0;
				}  else  {
					$total_dislikes_dynamic = $value['AllVideo']['total_dislikes_dynamic'];
				}
				
				if ($value['AllVideo']['follower_status'] !=0) {
					$follower_status  = 1;
				}  else {
					$follower_status  = 0;
				} 
				if ($value['AllVideo']['favorite_status'] !=0) {
					$favorite_status  = 1;
				}  else {
					$favorite_status  = 0;
				} 
				if ($value['AllVideo']['uploaded_by'] =='') {
					$videoBy	=	'';
				}  else {
					$videoBy	=	$value['AllVideo']['uploaded_by'];
				}
				$date123  = date('m/d/y ',strtotime($value['AllVideo']['date']));
				$response[]	=	array(
					'status'				=> 1,
					'pageCount'		=> $pageCount,
					'video_id'			=> $value['AllVideo']['id'],
					'user_id'				=> $value['AllVideo']['user_id'],										
					'category_id'		=> $value['AllVideo']['category_id'],										
					'category_name'	=> $value['Category']['name'],										
					'full_video'			=> FULL_BASE_URL.$this->webroot.'files' . DS . 'full_videos'. DS .$value['AllVideo']['full_video'],										
					'small_video'		=> FULL_BASE_URL.$this->webroot.'files' . DS . 'small_videos'. DS .$value['AllVideo']['small_video'],										
					'thumbnail_images'	=> $thumbnail_images,										
					'title'					=> $value['AllVideo']['title'],										
					'description'		=> $value['AllVideo']['description'],										
					'total_likes'			=> $like,		
					'total_dislikes'	=> $total_dislikes_dynamic,			
					'videoBy'			=> $videoBy,									
					'duration'			=>$value['AllVideo']['duration'],		
					'total_comments' =>$value['AllVideo']['total_comments'],										
					'total_views'		=>$value['AllVideo']['total_view'],										
					'date' 					=> $date123, 										
					'username'			=> $value['User']['username'], 										
					'cat_name'			=> $value['Category']['name'], 	
					'likes'					=> $likes,
					'dislikes'				=>$dislike,
					'follower_status'		=> $follower_status, 										
					'favorite_status'		=> $favorite_status,
					'profile_image'		=> $profile_image
				);
				
			}
			
			//echo "<pre>";print_r($response);die;
			//$sort_by 		= 	$_REQUEST['sort_by'];
			//$this->array_sort_by_column_asc($response, 'total_likes');
			// if ($sort_by == 'rand')  {
				// shuffle($response);
			// }  else {
				// $this->array_sort_by_column($response, 'total_likes');
			// }			
			//echo "<pre>";print_r($response);die;
			//echo "<pre>";print_r($response);die;
			echo json_encode($response);exit;					
		}
		
		//http://talentswipe.com/Webservices/all_videos_of_user?user_id=2285&category_id=all&sort_by=rend
		public function all_user_laderboard ()
		{		
			$user_id 		= 	$_REQUEST['user_id'];
			
			$this->AllVideo->virtualFields = array(
				'total_likes_dynamic'=>  'SELECT count(*) FROM video_likes WHERE AllVideo.id=video_likes.all_video_id and  video_likes.status="Like"',
				'total_dislikes_dynamic'=>  'SELECT count(*) FROM video_likes WHERE AllVideo.id=video_likes.all_video_id and  video_likes.status="DisLike"',
				'total_dislikes_user'=>  'SELECT count(*) FROM video_likes WHERE AllVideo.id=video_likes.all_video_id and  video_likes.status="Like" and  video_likes.user_id='.$user_id.'',
				'total_likes_user'=>  'SELECT count(*) FROM video_likes WHERE AllVideo.id=video_likes.all_video_id and  video_likes.status="DisLike" and  video_likes.user_id='.$user_id.'',
				'favorite_status'			=>'SELECT count(*) FROM favorite_videos WHERE AllVideo.id=favorite_videos.all_video_id and favorite_videos.user_id='.$user_id.'',
				'follower_status'			=>'SELECT count(*) FROM user_followers WHERE AllVideo.user_id =user_followers.follower_id and user_followers.user_id='.$user_id.'',
				'total_view'			=>'SELECT count(*) FROM video_views WHERE AllVideo.id =video_views.all_video_id'
			);
			if (is_numeric(@$_REQUEST['category_id']))  {
				$pageCount = 	$this->AllVideo->find ('count',array('conditions'=>array('AllVideo.category_id'=>$_REQUEST['category_id']),'contain'=>array()));		
				$data 	= 	$this->AllVideo->find (
					'all',array(
						'conditions'=>array(
							'AllVideo.category_id'=>$_REQUEST['category_id'],
							'AllVideo.status'=>'Yes'
						),
						'contain'=>array('Category.name','User.username','User.profile_image','User.registertype','VideoLike'),
						'order' => array('AllVideo.total_dislikes_user ASC','AllVideo.total_likes_user ASC','AllVideo.total_likes_dynamic ASC','AllVideo.total_dislikes_dynamic ASC','AllVideo.total_view ASC'),
						)
					);		
			}    else   {			
				$pageCount 	= 	$this->AllVideo->find ('count',array('contain'=>array()));		
				$data 				= 	$this->AllVideo->find (
					'all',array(
						'conditions'=>array(
							'AllVideo.status'	=>'Yes'
						),
						'contain'	=>  array('Category.name','User.username','User.profile_image','User.registertype','VideoLike'),
						'order' 	=>  array('AllVideo.total_dislikes_user ASC','AllVideo.total_likes_user ASC','AllVideo.total_likes_dynamic ASC','AllVideo.total_dislikes_dynamic ASC','AllVideo.total_view ASC')
					)
				);
			}
	
			if (empty($data)) {
				$response = array('status'=>0,'msg'=>'no video found.');
				echo json_encode ($response);exit;
			}	
			//echo "<pre>";print_r($data);die;
			foreach($data as $key=>$value) {
				if ($value['AllVideo']['thumbnail_images'] != '')  {
					$thumbnail_images = FULL_BASE_URL.$this->webroot.'files' . DS . 'thumbnail_images'. DS .$value['AllVideo']['thumbnail_images'];
				}  else {
					$thumbnail_images = FULL_BASE_URL.$this->webroot.'files' . DS . 'thumbnail_images'. DS .'index.png';	
				}
				
				if (!empty($value['VideoLike'])) {
					$count 	= 	$this->VideoLike->find ('first',array('conditions'=>array('AllVideo.id'=>$value['AllVideo']['id'],'VideoLike.user_id'=>$_REQUEST['user_id']),'contain'=>array()));
				}   else {
					$count = 0;
				}	
				
				$profile_image	=	isset ($value['User']['profile_image']) ? FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$value['User']['profile_image'] : '';
					
				if ($value['User']['profile_image'] == '')  {
					$profile_image = FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .'person-icon.png';
				}
				if ($value['User']['registertype'] == 'facebook')  {
					$profile_image = $value['User']['profile_image'];
				}

				if (empty($count))  {
					$likes 		= 'No';
					$dislike	=	'No';
				}  else {
					if ($count['VideoLike']['status']  == 'Like')  {
						$likes 		= 'Yes';
						$dislike	=	'No';
					}  
					if ($count['VideoLike']['status']  == 'DisLike')  {
						$likes 		= 'No';
						$dislike	=	'Yes';
					}  
				}
					
				if ($value['AllVideo']['total_likes_dynamic'] < 0)  {
					$like = 0;
				}  else  {
					$like = $value['AllVideo']['total_likes_dynamic'];
				}
				
				if ($value['AllVideo']['total_dislikes_dynamic'] < 0)  {
					$total_dislikes_dynamic = 0;
				}  else  {
					$total_dislikes_dynamic = $value['AllVideo']['total_dislikes_dynamic'];
				}
				
				if ($value['AllVideo']['follower_status'] !=0) {
					$follower_status  = 1;
				}  else {
					$follower_status  = 0;
				} 
				if ($value['AllVideo']['favorite_status'] !=0) {
					$favorite_status  = 1;
				}  else {
					$favorite_status  = 0;
				} 
				if ($info['AllVideo']['uploaded_by'] =='') {
					$videoBy	=	'';
				}  else {
					$videoBy	=	$info['AllVideo']['uploaded_by'];
				}
				$date123  = date('m/d/y ',strtotime($value['AllVideo']['date']));
				$response[]	=	array(
					'status'				=> 1,
					'pageCount'		=> $pageCount,
					'video_id'			=> $value['AllVideo']['id'],
					'user_id'				=> $value['AllVideo']['user_id'],										
					'category_id'		=> $value['AllVideo']['category_id'],										
					'category_name'	=> $value['Category']['name'],										
					'full_video'			=> FULL_BASE_URL.$this->webroot.'files' . DS . 'full_videos'. DS .$value['AllVideo']['full_video'],										
					'small_video'		=> FULL_BASE_URL.$this->webroot.'files' . DS . 'small_videos'. DS .$value['AllVideo']['small_video'],										
					'thumbnail_images'	=> $thumbnail_images,										
					'title'					=> $value['AllVideo']['title'],										
					'description'		=> $value['AllVideo']['description'],										
					'total_likes'			=> $like,		
					'total_dislikes'	=> $total_dislikes_dynamic,			
					'videoBy'			=> $videoBy,									
					'duration'			=>$value['AllVideo']['duration'],		
					'total_comments' =>$value['AllVideo']['total_comments'],										
					'total_views'		=>$value['AllVideo']['total_view'],										
					'date' 					=> $date123, 										
					'username'			=> $value['User']['username'], 										
					'cat_name'			=> $value['Category']['name'], 	
					'likes'					=> $likes,
					'dislikes'				=>$dislike,
					'follower_status'		=> $follower_status, 										
					'favorite_status'		=> $favorite_status,
					'profile_image'		=> $profile_image
				);
				
			}
			
			
			$this->array_sort_by_column($response, 'total_likes');
				
			//echo "<pre>";print_r($response);die;
			//echo "<pre>";print_r($response);die;
			echo json_encode($response);exit;					
		}
		
		//http://admin.talentswipe.com/Webservices/all_videos_by_category_id?category_id=1&user_id=12
		public function all_videos_by_category_id ()
		{
			if ($_REQUEST['category_id'] == '')  {
				$response = array('status'=>0,'msg'=>'error:wrong parameters.');
				echo json_encode ($response);exit;
			} else {
				$category_id	=	$_REQUEST['category_id'] ;
			}
			$user_id 		= 	$_REQUEST['user_id'];
			$userViewVideo	=	$this->VideoView->find ('all',array('conditions'=>  array('VideoView.user_id'=>$user_id),'contain'=>array('VideoView.all_video_id')));
			$userVideoView = array();
			
			foreach ($userViewVideo as $userView) {
				array_push ($userVideoView,$userView['VideoView']['all_video_id']);
			}
								
			$this->AllVideo->virtualFields = array(
				'total_likes_dynamic'=>  'SELECT count(*) FROM video_likes WHERE AllVideo.id=video_likes.all_video_id and  video_likes.status="Like"',
				'favorite_status'			=>'SELECT count(*) FROM favorite_videos WHERE AllVideo.id=favorite_videos.all_video_id and favorite_videos.user_id='.$user_id.'',
				'follower_status'			=>'SELECT count(*) FROM user_followers WHERE AllVideo.user_id =user_followers.follower_id and user_followers.user_id='.$user_id.'',
				'view_status'				=>'SELECT count(*) FROM video_views WHERE AllVideo.id =video_views.all_video_id and video_views.user_id='.$user_id.'',
				'total_view'			=>'SELECT count(*) FROM video_views WHERE AllVideo.id =video_views.all_video_id'
			);
			
			$data 	= 	$this->AllVideo->find (
				'all',array(
					'conditions'=>  array(
						'AllVideo.category_id'	=>  $category_id,
						'AllVideo.status'			=>  'Yes',
						"NOT" => array("AllVideo.id" => $userVideoView )
					),
					'contain'	=>  array(
						'Category.name','User.username','User.profile_image','User.registertype','VideoLike.user_id'
					),
					'order' => array('rand()','AllVideo.view_status desc')					
				)
			);
			
			$alluserVideoView = $this->AllVideo->find (
				'all',array(
					'conditions'=>  array(
						'AllVideo.category_id'	=>  $category_id,
						'AllVideo.status'			=>  'Yes',
						"AllVideo.id" 					=> $userVideoView
					),
					'contain'	=>  array(
						'Category.name','User.username','User.profile_image','User.registertype','VideoLike.user_id'
					),
				)
			);
			
			//echo "<pre>";print_r($data);die;
			//echo "<pre>";print_r($data);


			// if (empty($data)) {
				// $response = array('status'=>0,'msg'=>'no video found.');
				// echo json_encode ($response);exit;
			// }	
			foreach($data as $key=>$value) {
				if ($value['AllVideo']['thumbnail_images'] != '')  {
					$thumbnail_images = FULL_BASE_URL.$this->webroot.'files' . DS . 'thumbnail_images'. DS .$value['AllVideo']['thumbnail_images'];	
				}  else {
					$thumbnail_images = FULL_BASE_URL.$this->webroot.'files' . DS . 'thumbnail_images'. DS .'index.png';	
				}
				if (!empty($value['VideoLike'])) {
					$count 	= 	$this->VideoLike->find ('first',array('conditions'=>array('AllVideo.id'=>$value['AllVideo']['id'],'VideoLike.user_id'=>$_REQUEST['user_id']),'contain'=>array()));
				}   else {
					$count = 0;
				}	
					
				$profile_image	=	isset ($value['User']['profile_image']) ? FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$value['User']['profile_image'] : '';
			
				if ($value['User']['profile_image'] == '')  {
					$profile_image = FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .'person-icon.png';
				}
				if ($value['User']['registertype'] == 'facebook')  {
					$profile_image = $value['User']['profile_image'];
				}
					
				if (empty($count))  {
					$likes 		= 'No';
					$dislike	=	'No';
				}  else {
					if ($count['VideoLike']['status']  == 'Like')  {
						$likes 		= 'Yes';
						$dislike	=	'No';
					}  
					if ($count['VideoLike']['status']  == 'DisLike')  {
						$likes 		= 'No';
						$dislike	=	'Yes';
					}  
				}
				if ($value['AllVideo']['total_likes_dynamic'] < 0)  {
					$like = 0;
				}  else  {
					$like = $value['AllVideo']['total_likes_dynamic'];
				}
				
				if ($value['AllVideo']['follower_status'] !=0) {
					$follower_status  = 1;
				}  else {
					$follower_status  = 0;
				} 
				if ($value['AllVideo']['favorite_status'] !=0) {
					$favorite_status  = 1;
				}  else {
					$favorite_status  = 0;
				} 
				if ($info['AllVideo']['uploaded_by'] =='') {
					$videoBy	=	'';
				}  else {
					$videoBy	=	$info['AllVideo']['uploaded_by'];
				}
				$date123  = date('m/d/y ',strtotime($value['AllVideo']['date']));
				$response[]	=	array(
				'status'			=> 1,
				'video_id'			=> $value['AllVideo']['id'],
				'user_id'			=> $value['AllVideo']['user_id'],										
				'category_id'	=> $value['AllVideo']['category_id'],		
				'duration'			=>$value['AllVideo']['duration'],		
				'category_name'	=> $value['Category']['name'],										
				'full_video'		=> FULL_BASE_URL.$this->webroot.'files' . DS . 'full_videos'. DS .$value['AllVideo']['full_video'],										
				'small_video'	=>FULL_BASE_URL.$this->webroot.'files' . DS . 'small_videos'. DS .$value['AllVideo']['small_video'],										
				'thumbnail_images'	=>$thumbnail_images,										
				'title'					=> $value['AllVideo']['title'],										
				'description'		=> $value['AllVideo']['description'],										
				'total_likes'		=> $like,										
				'videoBy'		=> $videoBy,										
				'total_dislikes'	=> $value['AllVideo']['total_dislikes'],										
				'total_comments' =>$value['AllVideo']['total_comments'],										
				'total_views'	=>$value['AllVideo']['total_view'],										
				'date' 				=> $date123, 										
				'username'		=> $value['User']['username'], 										
				'cat_name'		=> $value['Category']['name'], 	
				'likes'				=> $likes,
				'dislikes'			=> $dislike,
				'follower_status'		=> $follower_status, 										
				'favorite_status'		=> $favorite_status,
				'profile_image'		=> $profile_image
				);
			} 
			
			foreach($alluserVideoView as $key=>$value) {
				if ($value['AllVideo']['thumbnail_images'] != '')  {
					$thumbnail_images = FULL_BASE_URL.$this->webroot.'files' . DS . 'thumbnail_images'. DS .$value['AllVideo']['thumbnail_images'];	
				}  else {
					$thumbnail_images = FULL_BASE_URL.$this->webroot.'files' . DS . 'thumbnail_images'. DS .'index.png';	
				}
				if (!empty($value['VideoLike'])) {
					$count 	= 	$this->VideoLike->find ('first',array('conditions'=>array('AllVideo.id'=>$value['AllVideo']['id'],'VideoLike.user_id'=>$_REQUEST['user_id']),'contain'=>array()));
				}   else {
					$count = 0;
				}	
					
				$profile_image	=	isset ($value['User']['profile_image']) ? FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$value['User']['profile_image'] : '';
			
				if ($value['User']['profile_image'] == '')  {
					$profile_image = FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .'person-icon.png';
				}
				if ($value['User']['registertype'] == 'facebook')  {
					$profile_image = $value['User']['profile_image'];
				}
					
				if (empty($count))  {
					$likes 		= 'No';
					$dislike	=	'No';
				}  else {
					if ($count['VideoLike']['status']  == 'Like')  {
						$likes 		= 'Yes';
						$dislike	=	'No';
					}  
					if ($count['VideoLike']['status']  == 'DisLike')  {
						$likes 		= 'No';
						$dislike	=	'Yes';
					}  
				}
				if ($value['AllVideo']['total_likes_dynamic'] < 0)  {
					$like = 0;
				}  else  {
					$like = $value['AllVideo']['total_likes_dynamic'];
				}
				
				if ($value['AllVideo']['follower_status'] !=0) {
					$follower_status  = 1;
				}  else {
					$follower_status  = 0;
				} 
				if ($value['AllVideo']['favorite_status'] !=0) {
					$favorite_status  = 1;
				}  else {
					$favorite_status  = 0;
				} 
				if ($info['AllVideo']['uploaded_by'] =='') {
					$videoBy	=	'';
				}  else {
					$videoBy	=	$info['AllVideo']['uploaded_by'];
				}
				$date123  = date('m/d/y ',strtotime($value['AllVideo']['date']));
				$response[]	=	array(
				'status'			=> 1,
				'video_id'			=> $value['AllVideo']['id'],
				'user_id'			=> $value['AllVideo']['user_id'],										
				'category_id'	=> $value['AllVideo']['category_id'],	
				'duration'			=>$value['AllVideo']['duration'],		
				'category_name'	=> $value['Category']['name'],										
				'full_video'		=> FULL_BASE_URL.$this->webroot.'files' . DS . 'full_videos'. DS .$value['AllVideo']['full_video'],										
				'small_video'	=>FULL_BASE_URL.$this->webroot.'files' . DS . 'small_videos'. DS .$value['AllVideo']['small_video'],										
				'thumbnail_images'	=>$thumbnail_images,										
				'title'					=> $value['AllVideo']['title'],										
				'description'		=> $value['AllVideo']['description'],										
				'total_likes'		=> $like,										
				'videoBy'		=> $videoBy,										
				'total_dislikes'	=> $value['AllVideo']['total_dislikes'],										
				'total_comments' =>$value['AllVideo']['total_comments'],										
				'total_views'	=>$value['AllVideo']['total_view'],										
				'date' 				=> $date123, 										
				'username'		=> $value['User']['username'], 										
				'cat_name'		=> $value['Category']['name'], 	
				'likes'				=> $likes,
				'dislikes'			=> $dislike,
				'follower_status'		=> $follower_status, 										
				'favorite_status'		=> $favorite_status,
				'profile_image'		=> $profile_image
				);
			}
			
			if (empty($response))  {
				$response = array('status'=>0,'msg'=>'no video found.');
				echo json_encode ($response);exit;
			}
			echo json_encode($response);exit;						
		}
			
		//http://admin.talentswipe.com/Webservices/like_video?user_id=2285&video_id=1
		public function like_video ()
		{
			if ($_REQUEST['user_id'] == '' or $_REQUEST['video_id'] == '')  {
				$response = array('status'=>0,'msg'=>'error:wrong parameters.');
				echo json_encode ($response);exit;
			} else {
				$user_id		=	$_REQUEST['user_id'];
				$video_id	=	$_REQUEST['video_id'];
			}
			$existVideo	=	$this->VideoLike->find('first',array('conditions'=>array('AND'=>array('VideoLike.user_id'=>$user_id,'VideoLike.all_video_id'=>$video_id)),'contain'=>array()));
			if (empty($existVideo))  {
				/* View Video Code Start */
				$count 	= 	$this->VideoView->find ('count',array('conditions'=>array('VideoView.all_video_id'=>$video_id,'VideoView.user_id'=>$user_id)));
				if ($count == 0)  {
					$data['VideoView']['user_id']		=	$user_id;
					$data['VideoView']['all_video_id']	=	$video_id;
					$data['VideoView']['date']			=	date("Y-m-d H:i:s");				
					$this->VideoView->save ($data);					  	
				}  
				/* View Video Code End */
				
				$exist	=	$this->VideoLike->find('first',array('conditions'=>array('AND'=>array('VideoLike.user_id'=>$user_id,'VideoLike.all_video_id'=>$video_id)),'contain'=>array()));
				
				if (!empty($exist)) {
					if ($this->VideoLike->updateAll (array('VideoLike.status' =>"'Like'"),array('VideoLike.all_video_id' => $video_id,'VideoLike.user_id' => $user_id)))  {
						$likes	=	$this->VideoLike->find('count',array('conditions'=>array('VideoLike.all_video_id'=>$video_id,'VideoLike.status'=>'Like'),'contain'=>array()));				
						$total_likes = $likes." Likes";
						$response = array('status'=>1,'msg'=>'success.','total_likes'=>$total_likes);
						echo json_encode ($response);exit;
					}
				}
				
				$data['VideoLike']['status']				=	'Like';
				$data['VideoLike']['user_id']			=	$_REQUEST['user_id'];
				$data['VideoLike']['all_video_id']		=	$_REQUEST['video_id'];
				$data['VideoLike']['date']					=	date("Y-m-d H:i:s");
				
				if ($this->VideoLike->save ($data))  {
					$likes	=	$this->VideoLike->find('count',array('conditions'=>array('VideoLike.all_video_id'=>$video_id,'VideoLike.status'=>'Like'),'contain'=>array()));		
					$total_likes = $likes." Likes";
					$response = array('status'=>1,'msg'=>'success.','total_likes'=>$total_likes);
					echo json_encode ($response);exit;
				}  else  {
					$response = array('status'=>0,'msg'=>'error.');
					echo json_encode ($response);exit;
				}		
			}  	else  {
					$response = array('status'=>0,'msg'=>'already like.');
					echo json_encode ($response);exit;
				}	
		}
		
		//http://admin.talentswipe.com/Webservices/dislike_video?user_id=2285&video_id=1
		public function dislike_video ()
		{
			if ($_REQUEST['user_id'] == '' or $_REQUEST['video_id'] == '')  {
				$response = array('status'=>0,'msg'=>'error:wrong parameters.');
				echo json_encode ($response);exit;
			} else {
				$user_id	=	$_REQUEST['user_id'];
				$video_id	=	$_REQUEST['video_id'];
			}
			$existVideo	=	$this->VideoLike->find('first',array('conditions'=>array('AND'=>array('VideoLike.user_id'=>$user_id,'VideoLike.all_video_id'=>$video_id)),'contain'=>array()));
			if (empty($existVideo))  {
				/* View Video Code Start */
				$count 	= 	$this->VideoView->find ('count',array('conditions'=>array('VideoView.all_video_id'=>$video_id,'VideoView.user_id'=>$user_id)));
				if ($count == 0)  {
					$data['VideoView']['user_id']		=	$user_id;
					$data['VideoView']['all_video_id']	=	$video_id;
					$data['VideoView']['date']			=	date("Y-m-d H:i:s");				
					$this->VideoView->save ($data);					  	
				}  
				/* View Video Code End */
				
				$exist	=	$this->VideoLike->find('first',array('conditions'=>array('AND'=>array('VideoLike.user_id'=>$user_id,'VideoLike.all_video_id'=>$video_id)),'contain'=>array()));

				if (empty($exist)) {
					$data['VideoLike']['status']	=	'DisLike';
					$data['VideoLike']['user_id']	=	$_REQUEST['user_id'];
					$data['VideoLike']['all_video_id']	=	$_REQUEST['video_id'];
					$data['VideoLike']['date']			=	date("Y-m-d H:i:s");
					
					if ($this->VideoLike->save ($data))  {
						$likes =	$this->VideoLike->find('count',array('conditions'=>array('VideoLike.all_video_id'=>$video_id,'VideoLike.status'=>'DisLike'),'contain'=>array()));
						$total_likes = $likes." Likes";
						$response = array('status'=>1,'msg'=>'success.','total_likes'=>$total_likes);
						echo json_encode ($response);exit;
					}  else  {
						$response = array('status'=>0,'msg'=>'error.');
						echo json_encode ($response);exit;
					}		
				}
							
				if ($this->VideoLike->updateAll (array('VideoLike.status' =>"'DisLike'"),array('VideoLike.all_video_id' => $video_id,'VideoLike.user_id' => $user_id)))  {
					$likes	=	$this->VideoLike->find('count',array('conditions'=>array('VideoLike.all_video_id'=>$video_id,'VideoLike.status'=>'DisLike'),'contain'=>array()));
					$total_likes = $likes." Likes";
					$response = array('status'=>1,'msg'=>'success.','total_likes'=>$total_likes);
					echo json_encode ($response);exit;
				}  else  {
					$response = array('status'=>0,'msg'=>'error.');
					echo json_encode ($response);exit;
				}			
			}
				else  {
					$response = array('status'=>0,'msg'=>'already dislike.');
					echo json_encode ($response);exit;
				}	
		}
		
		//http://admin.talentswipe.com/Webservices/remove_video?video_id=1
		public function remove_video ()
		{
			if ($_REQUEST['video_id'] == '')  {
				$response = array('status'=>0,'msg'=>'error:wrong parameters.');
				echo json_encode ($response);exit;
			} else {
				$video_id	=	$_REQUEST['video_id'];
			}
						
			if ($this->AllVideo->delete ($video_id))  {
				
				$this->FavoriteVideo->deleteAll(array('FavoriteVideo.all_video_id'=>$video_id));
				$this->VideoComment->deleteAll(array('VideoComment.all_video_id'=>$video_id));
				$this->VideoLike->deleteAll(array('VideoLike.all_video_id'=>$video_id));
				$this->VideoView->deleteAll(array('VideoView.all_video_id'=>$video_id));
				
				$response = array('status'=>1,'msg'=>'success.');
				echo json_encode ($response);exit;
			}  else  {
				$response = array('status'=>0,'msg'=>'error.');
				echo json_encode ($response);exit;
			}			
		}
		
		//http://admin.talentswipe.com/Webservices/favorite_video?user_id=2285&video_id=1
		public function favorite_video ()
		{
			if ($_REQUEST['user_id'] == '' or $_REQUEST['video_id'] == '')  {
				$response = array('status'=>0,'msg'=>'error:wrong parameters.');
				echo json_encode ($response);exit;
			} else {
				$user_id	=	$_REQUEST['user_id'];
				$video_id	=	$_REQUEST['video_id'];
			}
			
			$exist	=	$this->FavoriteVideo->find('first',array('conditions'=>array('AND'=>array('FavoriteVideo.user_id'=>$user_id,'FavoriteVideo.all_video_id'=>$video_id)),'contain'=>array()));
			
			if (!empty($exist)) {
				if ($this->FavoriteVideo->deleteAll (array('FavoriteVideo.all_video_id' => $_REQUEST['video_id'],'FavoriteVideo.user_id' => $_REQUEST['user_id'])))  {
						$response = array('status'=>2,'msg'=>'User unfavorite video successfully.');
						echo json_encode ($response);exit;
				}  else  {
					$response= array('status'=>0,'msg'=>'error.');
					echo json_encode ($response);exit;
				}
			}
			
			$data['FavoriteVideo']['user_id']	=	$_REQUEST['user_id'];
			$data['FavoriteVideo']['all_video_id']	=	$_REQUEST['video_id'];
			$data['FavoriteVideo']['date']			=	date("Y-m-d H:i:s");
			
			if ($this->FavoriteVideo->save ($data))  {
				$response = array('status'=>1,'msg'=>'success.');
				echo json_encode ($response);exit;
			}  else  {
				$response = array('status'=>0,'msg'=>'error.');
				echo json_encode ($response);exit;
			}			
		}
		
		//http://admin.talentswipe.com/Webservices/favorite_video_of_user?user_id=2314
		public function favorite_video_of_user ()
		{
			
			if ($_REQUEST['user_id'] == '' )  {
				$response = array('status'=>0,'msg'=>'error:wrong parameters.');
				echo json_encode ($response);exit;
			} else {
				$user_id	=	$_REQUEST['user_id'];
			}
				
			$this->FavoriteVideo->virtualFields = array(
				'total_likes_dynamic'=>  'SELECT count(*) FROM video_likes WHERE AllVideo.id=video_likes.all_video_id and  video_likes.status="Like"',
				'favorite_status'			=>'SELECT count(*) FROM favorite_videos WHERE AllVideo.id=favorite_videos.all_video_id and favorite_videos.user_id='.$user_id.'',
				'follower_status'			=>'SELECT count(*) FROM user_followers WHERE AllVideo.user_id =user_followers.follower_id and user_followers.user_id='.$user_id.'',
				'total_view'					=>'SELECT count(*) FROM video_views WHERE AllVideo.id =video_views.all_video_id',
				'category_name'		=>'SELECT name FROM categories WHERE AllVideo.category_id =categories.id'
			);
			
			$exist	=	$this->FavoriteVideo->find (
				'all',array(
					'conditions'=>array('FavoriteVideo.user_id'=>$user_id),
					'contain'=>array(
						'User'=>array('fields'=>array('User.id,User.first_name,User.last_name,User.profile_image,User.username,User.email')),
						'AllVideo'=>array('User','Category')
					),
					'order' => array('AllVideo.total_likes DESC','AllVideo.total_views DESC','AllVideo.total_comments DESC','AllVideo.id DESC')
				)
			);
			
			//echo "<pre>"; print_r ($exist);
			if (empty($exist)) {
				$response = array('status'=>0,'msg'=>'No data found.');
				echo json_encode ($response);exit;
			}
			
			
			foreach($exist as $key=>$value) {
				if($value['AllVideo']['id'] !='')  {
					
					$count 							= 	$this->VideoLike->find ('first',array('conditions'=>array('AllVideo.id'=>$value['AllVideo']['id'],'VideoLike.user_id'=>$user_id),'contain'=>array()));
					
					$user_profile 				= 	$this->User->find ('first',array('conditions'=>array('User.id'=>$value['AllVideo']['user_id']),'fields'=>array('User.profile_image,User.registertype,User.username'),'contain'=>array()));
					
					$profile_image	=	isset ($user_profile['User']['profile_image']) ? FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$user_profile['User']['profile_image'] : '';
					
					if (@$user_profile['User']['profile_image'] == '')  {
						$profile_image = FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .'person-icon.png';
					}
					if ($user_profile['User']['registertype'] == 'facebook')  {
						$profile_image = $user_profile['User']['profile_image'];
					}
					
					if ($value['FavoriteVideo']['total_likes_dynamic'] < 0)  {
						$like = 0;
					}  else  {
						$like = $value['FavoriteVideo']['total_likes_dynamic'];
					}
					
					if (empty($count))  {
						$likes 		= 'No';
						$dislike	=	'No';
					}  else {
						if ($count['VideoLike']['status']  == 'Like')  {
							$likes 		= 'Yes';
							$dislike	=	'No';
						}  
						if ($count['VideoLike']['status']  == 'DisLike')  {
							$likes 		= 'No';
							$dislike	=	'Yes';
						}  
					}
					
					if ($value['FavoriteVideo']['follower_status'] !=0) {
						$follower_status  = 1;
					}  else {
						$follower_status  = 0;
					} 
					if ($value['FavoriteVideo']['favorite_status'] !=0) {
						$favorite_status  = 1;
					}  else {
						$favorite_status  = 0;
					} 
					if ($info['AllVideo']['uploaded_by'] =='') {
						$videoBy	=	'';
					}  else {
						$videoBy	=	$info['AllVideo']['uploaded_by'];
					}
					$date123  = date('m/d/y ',strtotime($value['AllVideo']['date']));
					
					if ($value['AllVideo']['id'] != '')  {
					$response[]	=	array(
					'status'			=> 1,
					'video_id'			=> $value['AllVideo']['id'],
					'user_id'			=> $value['AllVideo']['user_id'],										
					'category_id'	=> $value['AllVideo']['category_id'],
					'duration'			=>$value['AllVideo']['duration'],		
					'full_video'		=> FULL_BASE_URL.$this->webroot.'files' . DS . 'full_videos'. DS .$value['AllVideo']['full_video'],										
					'small_video'	=> FULL_BASE_URL.$this->webroot.'files' . DS . 'small_videos'. DS .$value['AllVideo']['small_video'],										
					'thumbnail_images'	=> FULL_BASE_URL.$this->webroot.'files' . DS . 'thumbnail_images'. DS .$value['AllVideo']['thumbnail_images'],								
					'title'					=> $value['AllVideo']['title'],										
					'description'		=> $value['AllVideo']['description'],										
					'total_likes'		=> $like,										
					'videoBy'		=> $videoBy,										
					'total_dislikes'	=> $value['AllVideo']['total_dislikes'],										
					'total_comments' =>$value['AllVideo']['total_comments'],										
					'total_views'	=>$value['FavoriteVideo']['total_view'],										
					'category_name'	=>$value['FavoriteVideo']['category_name'],										
					'date' 				=> $value['AllVideo']['date'], 										
					'username'		=> $user_profile['User']['username'], 		
					'likes'					=> $likes,
					'dislikes'				=>$dislike,
					'follower_status'		=> $follower_status, 										
					'favorite_status'		=> $favorite_status,
					'profile_image'		=> $profile_image
					);
					}
				}
			}
			 if (empty($response)) {
				$response = array('status'=>0,'msg'=>'Video currently not exist in App.');
				echo json_encode ($response);exit;
			}
			//echo "<pre>";print_r ($response);
			//$this->array_sort_by_column($response, 'total_likes');	
              //echo "<pre>";
			  //print_r($response);
			echo json_encode ($response);exit;
		}
		
		
		//http://admin.talentswipe.com/Webservices/comment_video?user_id=2285&video_id=1&comment=hello
		public function comment_video ()
		{
			if ($_REQUEST['user_id'] == '' or $_REQUEST['video_id'] == '')  {
				$response = array('status'=>0,'msg'=>'error:wrong parameters.');
				echo json_encode ($response);exit;
			} else {
				$user_id	=	$_REQUEST['user_id'];
				$user_id	=	$_REQUEST['user_id'];
				$video_id	=	$_REQUEST['video_id'];
			}
			
			$data['VideoComment']['user_id']		=	$_REQUEST['user_id'];
			$data['VideoComment']['all_video_id']	=	$_REQUEST['video_id'];
			$data['VideoComment']['comment']	=	$_REQUEST['comment'];
			$data['VideoComment']['date']			=	date("Y-m-d H:i:s");
			
			if ($this->VideoComment->save ($data))  {
				$id		=	$this->VideoComment->getLastInsertId();
				$videos	=	$this->AllVideo->find('first',array('conditions'=>array('AllVideo.id'=>$video_id),'contain'=>array()));
				$update['AllVideo']['id']	=	$video_id;
				$update['AllVideo']['total_comments']	=	$videos['AllVideo']['total_comments'] + 1;
				if ($this->AllVideo->save ($update))  {
					$this->VideoComment->contain(array('User','AllVideo'=>array('User.id','User.username','User.email','User.followers','User.followings','User.register_date','User.profile_image','User.contact')));
					$data 	= 	$this->VideoComment->find ('all');
					//pr ($data);die; 
					if (empty($data)) {
						$response = array('status'=>0,'msg'=>'no video found.');
						echo json_encode ($response);exit;
					}	
					
					foreach($data as $key=>$value) {
						if ($value['AllVideo']['total_likes'] < 0)  {
							$likes = 0;
						}  else  {
							$likes = $value['AllVideo']['total_likes'];
						}
						$profile_image	=	isset ($value['User']['profile_image']) ? FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$value['User']['profile_image'] : '';
						//$profile_image	=	isset ($value['User']['profile_image']) ? FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$value['User']['profile_image'] : FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .'person-icon.png';
						if ($value['User']['profile_image'] == '')  {
							$profile_image = FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .'person-icon.png';
						}
						if ($value['User']['registertype'] == 'facebook')  {
							$profile_image = $value['User']['profile_image'];
						}
						$response[]	=	array(
							'status'			=> 1,
							'id'				=> $value['VideoComment']['id'],
							'user_id'		=> $value['VideoComment']['user_id'],										
							'video_id'		=> $value['VideoComment']['all_video_id'],										
							'comment'		=> $value['VideoComment']['comment'],										
							'date'				=> $value['VideoComment']['date'],										
							'username'	=> $value['User']['username'],										
							'profile_image'	=> $profile_image,										
							'title'				=> $value['AllVideo']['title'],										
							'description'	=> $value['AllVideo']['description'],										
							'total_likes'		=> $likes.' Likes',										
							'total_dislikes'		=> $value['AllVideo']['total_dislikes'].' Dislikes',										
							'total_comments' =>$value['AllVideo']['total_comments'].' Comments',										
							'total_views'	=>$value['AllVideo']['total_views'].'Views',										
							'date' 			=> $value['AllVideo']['date'], 										
							'username'	=> $value['User']['username'], 										
						);
					}
					//pr ($response);die;
					echo json_encode($response);exit;			
				}
			}  else  {
				$response = array('status'=>0,'msg'=>'error.');
				echo json_encode ($response);exit;
			}			
		}
		
		
		//http://admin.talentswipe.com/Webservices/views_video?user_id=2285&video_id=1
		public function views_video ()
		{
			if ($_REQUEST['user_id'] == '' or $_REQUEST['video_id'] == '')  {
				$response = array('status'=>0,'msg'=>'error:wrong parameters.');
				echo json_encode ($response);exit;
			} else {
				$user_id	=	$_REQUEST['user_id'];
				$video_id	=	$_REQUEST['video_id'];
			}
			
			$count 	= 	$this->VideoView->find ('count',array('conditions'=>array('VideoView.all_video_id'=>$video_id,'VideoView.user_id'=>$user_id)));
			if ($count == 0)  {
				$data['VideoView']['user_id']	=	$_REQUEST['user_id'];
				$data['VideoView']['all_video_id']	=	$_REQUEST['video_id'];
				$data['VideoView']['date']			=	date("Y-m-d H:i:s");
				
				if ($this->VideoView->save ($data))  {
					$id		=	$this->VideoView->getLastInsertId();
					$videos	=	$this->AllVideo->find('first',array('conditions'=>array('AllVideo.id'=>$video_id),'contain'=>array()));
					$update['AllVideo']['id']	=	$video_id;
					$update['AllVideo']['total_views']	=	$videos['AllVideo']['total_views'] + 1;
					$views	=	$update['AllVideo']['total_views'];
					$total_views=$views.' '.'Views';									
					if ($this->AllVideo->save ($update))  {
						$response = array('status'=>0,'msg'=>'success.','total_views'=>$total_views);
						echo json_encode ($response);exit;
					}
				}  else  {
					$response = array('status'=>0,'msg'=>'error.');
					echo json_encode ($response);exit;
				}		
			}   else  {
				$response = array('status'=>0,'msg'=>'You already viewed');
				echo json_encode ($response);exit;
			}	
		}
		
				
		//http://admin.talentswipe.com/Webservices/video_details?video_id=3&user_id=2314&follower_id=2223
		public function video_details ()
		{
			if ($_REQUEST['video_id'] == '' and $_REQUEST['user_id'] == '' and $_REQUEST['follower_id'] == '')  {
				$response = array('status'=>0,'msg'=>'Wrong Parametes .');
				echo json_encode ($response);exit;
			}
			$video_id = $_REQUEST['video_id'];
			//echo $video_id;
			$user_id 	= $_REQUEST['user_id'];
			$follower_id 	= $_REQUEST['follower_id'];
			$this->AllVideo->virtualFields = array(
				'total_likes_dynamic'=>  'SELECT count(*) FROM video_likes WHERE AllVideo.id=video_likes.all_video_id and  video_likes.status="Like"',
				'favorite_status'=>'SELECT count(*) FROM favorite_videos WHERE all_video_id='.$video_id.' and user_id='.$user_id.'',
				'follower_status'=>'SELECT count(*) FROM user_followers WHERE follower_id ='.$follower_id.' and user_id='.$user_id.'',
				'total_view'			=>'SELECT count(*) FROM video_views WHERE AllVideo.id =video_views.all_video_id'
			);
			
			$value 	= 	$this->AllVideo->find ('first',array('conditions'=>array('AllVideo.id'=>$video_id),'contain'=>array('Category.name','User.username')));
							//$exist 								= 	$this->User->find("first", array("conditions" => array("User.username" => $data['User']['username'])));

			//pr ($value);die;
			if ($value['AllVideo']['total_likes_dynamic'] < 0)  {
				$like = 0;
			}  else  {
				$like = $value['AllVideo']['total_likes_dynamic'];
			}
			if ($value['AllVideo']['follower_status'] !=0) {
				$follower_status  = 1;
			}  else {
			    $follower_status  = 0;
			} 
			if ($value['AllVideo']['favorite_status'] !=0) {
				$favorite_status  = 1;
			}  else {
			    $favorite_status  = 0;
			} 
			if (empty($value)) {
				$response = array('status'=>0,'msg'=>'no video found.');
				echo json_encode ($response);exit;
			}	
			
			if (@$value['User']['profile_image'] =='')  {
				$profile_image = FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .'person-icon.png';
			} else {
				$profile_image = FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$value['User']['profile_image'];
			}
			if ($value['User']['registertype'] == 'facebook')  {
				$profile_image = $value['User']['profile_image'];
			}
		
			if ($info['AllVideo']['uploaded_by'] =='') {
				$videoBy	=	'';
			}  else {
				$videoBy	=	$info['AllVideo']['uploaded_by'];
			}
					
			$response[]	=	array(
				'status'			=> 1,
				'video_id'			=> $value['AllVideo']['id'],
				'follower_id'		=> $value['AllVideo']['user_id'],										
				'category_id'	=> $value['AllVideo']['category_id'],										
				'category_name'	=> $value['Category']['name'],										
				'full_video'		=> FULL_BASE_URL.$this->webroot.'files' . DS . 'full_videos'. DS .$value['AllVideo']['full_video'],										
				'small_video'	=> FULL_BASE_URL.$this->webroot.'files' . DS . 'small_videos'. DS .$value['AllVideo']['small_video'],										
				'thumbnail_images'	=> FULL_BASE_URL.$this->webroot.'files' . DS . 'thumbnail_images'. DS .$value['AllVideo']['thumbnail_images'],										
				'title'				=> $value['AllVideo']['title'],										
				'description'	=> $value['AllVideo']['description'],	
				'duration'			=>$value['AllVideo']['duration'],		
				'total_likes'		=> $like.' Likes',										
				'videoBy'		=> $videoBy,										
				'total_dislikes'		=> $value['AllVideo']['total_dislikes'].' Dislikes',										
				'total_comments' =>$value['AllVideo']['total_comments'].' Comments',										
				'total_views'	=>$value['AllVideo']['total_view'].' Views',										
				'date' 			=> $value['AllVideo']['date'], 										
				'username'	=> $value['User']['username'], 	
				'user_profile'=>$profile_image,
				'cat_name'		=> $value['Category']['name'], 										
				'follower_status'		=> $follower_status, 										
				'favorite_status'		=> $favorite_status, 										
			);	
			//pr ($response);
			echo json_encode($response);exit;					
		}
		
		//http://admin.talentswipe.com/Webservices/video_comments?video_id=1
		public function video_comments ()
		{
			$this->VideoComment->contain(array('User','AllVideo'=>array('User.id','User.username','User.email','User.followers','User.followings','User.register_date','User.profile_image','User.contact')));
			$data 	= 	$this->VideoComment->find ('all',array('conditions'=>array('VideoComment.all_video_id'=>$_REQUEST['video_id']),'order'=>array('VideoComment.id desc')));
			//pr ($data);die; 
			if (empty($data)) {
				$response = array('status'=>0,'msg'=>'no video found.');
				echo json_encode ($response);exit;
			}	
			
			foreach($data as $key=>$value) {
				if ($value['AllVideo']['total_likes'] < 0)  {
					$likes = 0;
				}  else  {
					$likes = $value['AllVideo']['total_likes'];
				}
				$profile_image	=	isset ($value['User']['profile_image']) ? FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$value['User']['profile_image'] : '';
				//$profile_image	=	isset ($value['User']['profile_image']) ? FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$value['User']['profile_image'] : FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .'person-icon.png';
				if ($value['User']['profile_image'] == '')  {
					$profile_image = FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .'person-icon.png';
				}
				if ($value['User']['registertype'] == 'facebook')  {
					$profile_image = $value['User']['profile_image'];
				}
				$response[]	=	array(
					'status'			=> 1,
					'id'				=> $value['VideoComment']['id'],
					'user_id'		=> $value['VideoComment']['user_id'],										
					'video_id'		=> $value['VideoComment']['all_video_id'],										
					'comment'		=> $value['VideoComment']['comment'],										
					'date'				=> $value['VideoComment']['date'],										
					'username'	=> $value['User']['username'],										
					'profile_image'	=> $profile_image,										
					'title'				=> $value['AllVideo']['title'],										
					'description'	=> $value['AllVideo']['description'],										
					'total_likes'		=> $likes.' Likes',										
					'total_dislikes'		=> $value['AllVideo']['total_dislikes'].' Dislikes',										
					'total_comments' =>$value['AllVideo']['total_comments'].' Comments',										
					'total_views'	=>$value['AllVideo']['total_views'].'Views',										
					'date' 			=> date("j F Y", strtotime($value['AllVideo']['date'])),										
					'username'	=> $value['User']['username'], 										
				);
			}
			//pr ($response);die;
			echo json_encode($response);exit;					
		}
		
		//http://admin.talentswipe.com/Webservices/video_views?video_id=1
		public function video_views ()
		{
			$this->AllVideo->contain(array('User','VideoView'=>array('User')));
			$data 	= 	$this->AllVideo->find ('first',array('conditions'=>array('AllVideo.id'=>$_REQUEST['video_id'])));
			//pr ($data);
			if (empty($data)) {
				$response = array('status'=>0,'msg'=>'no video found.');
				echo json_encode ($response);exit;
			}	
			foreach($data['VideoView'] as $key=>$value) {
				//pr ($value);die;
				if ($value['AllVideo']['total_likes'] < 0)  {
					$likes = 0;
				}  else  {
					$likes = $value['AllVideo']['total_likes'];
				}
				$profile_image	=	isset ($value['User']['profile_image']) ? FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$value['User']['profile_image'] : '';
				//$profile_image	=	isset ($value['User']['profile_image']) ? FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$value['User']['profile_image'] : FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .'person-icon.png';
				if ($value['User']['profile_image'] == '')  {
					$profile_image = FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .'person-icon.png';
				}
				if ($value['User']['registertype'] == 'facebook')  {
					$profile_image = $value['User']['profile_image'];
				}
				$response[]	=	array(
					'status'			=> 1,
					'id'					=> $value['id'],
					'user_id'			=> $value['User']['id'],		
					'username'		=> $value['User']['username'],											
					'video_id'		=> $data['AllVideo']['id'],										
					'view_date'				=> $value['date'],										
					'profile_image'	=> $profile_image,										
					'title'				=> $data['AllVideo']['title'],										
					'description'	=> $data['AllVideo']['description'],										
					'total_likes'		=> $likes.' Likes',										
					'total_dislikes'		=> $data['AllVideo']['total_dislikes'].' Dislikes',										
					'total_comments' =>$data['AllVideo']['total_comments'].' Comments',										
					'total_views'	=>$data['AllVideo']['total_views'].'Views',										
					'video_date' 			=> $data['AllVideo']['date'], 										
				);
			}
			//pr ($response);die;
			echo json_encode($response);exit;					
		}
		
		//http://admin.talentswipe.com/Webservices/add_follower?user_id=2260&follower_id=3236
		public function add_follower () 
		{
			$this->loadModel ('UserFollower');
			$user_id			=	$_REQUEST['user_id'];
			$follower_id			=	$_REQUEST['follower_id'];
			$data['UserFollower']['user_id']				=	$_REQUEST['user_id'];
			$data['UserFollower']['follower_id']			=	$_REQUEST['follower_id'];
			$data['UserFollower']['user_types_id']	=	2;
			$data['UserFollower']['date']				=	date('Y-m-d');
			
			$user_exist 	= $this->User->find ('first',array('conditions'=>array('User.id'=>$_REQUEST['user_id'])));
			$user_follower 	= $this->User->find ('first',array('conditions'=>array('User.id'=>$_REQUEST['follower_id'])));
			$check_user = $this->UserFollower->find ('first',array('conditions'=>array('AND'=>array('UserFollower.follower_id'=>$_REQUEST['follower_id'],'UserFollower.user_id'=>$_REQUEST['user_id']))));
			
			//pr ($check_user);die;
			$followings = $user_exist['User']['followings'];
			$followers = $user_follower['User']['followers'];
			$curFoll = $followings  +1;
			$curFollowing = $followers  +1;
			if (empty($user_exist))  {
				$response = array('status'=>0,'msg'=>'User not exist.');
				echo json_encode ($response);exit;
			}			
			if (empty($check_user)) {
				if ($this->UserFollower->save($data))  {
					$this->User->query ("update users set followings= '".$curFoll."' where id = '".$user_id."'");
					$this->User->query ("update users set followers= '".$curFollowing."' where id = '".$follower_id."'");
					$response = array ('status'=>1,'msg'=>'success.');
					echo json_encode ($response);exit;
				}  else  {
					$response = array('status'=>0,'msg'=>'error.');
					echo json_encode ($response);exit;
				}
			} else  {
				if ($this->UserFollower->deleteAll (array('UserFollower.follower_id' => $_REQUEST['follower_id'],'UserFollower.user_id' => $_REQUEST['user_id'])))  {
						$response = array('status'=>2,'msg'=>'User unfollow successfully.');
						echo json_encode ($response);exit;
				}  else  {
					$response = array('status'=>0,'msg'=>'error.');
					echo json_encode ($response);exit;
				}
			}
		}
		
		//http://admin.talentswipe.com/Webservices/user_follower?user_id=87
		public function user_follower ()
		{
			$data 	= 	$this->User->find ('first',array('conditions'=>array('User.id'=>$_REQUEST['user_id']),'contain'=>array('Following'=>array('User'),'Follower'=>array('User','Follower1'))));
			//echo "<pre>";print_r ($data);die; 
			if (empty($data)) {
				$response = array('status'=>0,'msg'=>'no follower found.');
				echo json_encode ($response);exit;
			}	
			
			if (empty($data['Follower'])) {
				$response = array('status'=>0,'msg'=>'no follower found.');
				echo json_encode ($response);exit;
			}	
			$id 				= $data['User']['id'];
			$username	= $data['User']['username'];	
            
			foreach($data['Follower'] as $key=>$value) {
				$follower_videos	=	$this->AllVideo->find ('count',array('conditions'=>array('AllVideo.user_id'=>$value['Follower1']['id'])));
				if ($value['Follower1']['profile_image'] == '')  {
					$profile_image = FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .'person-icon.png';
				}	else {
					$profile_image  = FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$value['Follower1']['profile_image'];
				}
				if ($value['Follower1']['registertype'] == 'facebook')  {
					$profile_image = $value['Follower1']['profile_image'];
				}
				//pr ($value);die;
				$response[]		=	array(
					'status'			=> 1,
					'id'				=> $id,
					'username'	=> $username,										
					'follower_id'	=> $value['Follower1']['id'],										
					'follower_username'	=> $value['Follower1']['username'],										
					'followers_email'		=> $value['Follower1']['email'],										
					'followers_followers'	=> $value['Follower1']['followers'],										
					'followers_followings'	=> $value['Follower1']['followings'],										
					'followers_videos'		=> $follower_videos,										
					'followers_profile_image'	=> $profile_image,								
				);
			}
			//echo "<pre>";print_r ($response);die;
			$this->array_sort_by_column($response, 'followers_videos');		
			//pr ($response);die;
			echo json_encode($response);exit;					
		}
		
		//http://admin.talentswipe.com/Webservices/user_following?user_id=1
		public function user_following ()
		{
			$data 	= 	$this->User->find ('first',array('conditions'=>array('User.id'=>$_REQUEST['user_id']),'contain'=>array('Following'=>array('User'))));
			//pr ($data);die; 
			if (empty($data)) {
				$response = array('status'=>0,'msg'=>'no user found.');
				echo json_encode ($response);exit;
			}	
			$response=array();
			$id 				= $data['User']['id'];
			$username	= $data['User']['username'];		
			foreach($data['Following'] as $key=>$value) {
				if ($value['User']['profile_image'] == '')  {
					$profile_image = FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .'person-icon.png';
				}	else {
					$profile_image  = FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$value['Follower1']['profile_image'];
				}
				if(!empty($value['User']))  {
					$response[]		=	array(
						'status'			=> 1,
						'id'				=> $id,
						'username'	=> $username,										
						'follower_id'	=> $value['User']['id'],										
						'follower_username'	=> $value['User']['username'],										
						'followers_email'		=> $value['User']['email'],										
						'followers_followers'	=> $value['User']['followers'],										
						'followers_followings'	=> $value['User']['followings'],										
						'followers_videos'		=> $value['User']['videos'],										
						'followers_profile_image'	=> $profile_image,								
					);
				}
			}
			if (empty($response)) {
				$response = array('status'=>0,'msg'=>'no follower found.');
				echo json_encode ($response);exit;
			}	
			//pr ($response);die;
			$this->array_sort_by_column($response, 'followers_followings');	
			echo json_encode($response);exit;					
		}
		
		//http://admin.talentswipe.com/Webservices/user_unfollow?user_id=2260&follower_id=3236
		public function user_unfollow () 
		{
			$this->loadModel ('UserFollower');
			$data['UserFollower']['user_id']			=	$_REQUEST['user_id'];
			$user_id			=	$_REQUEST['user_id'];
			$follower_id			=	$_REQUEST['follower_id'];
			$data['UserFollower']['follower_id']		=	$_REQUEST['follower_id'];
			//dasdadsad
			
			$user_exist 	= $this->User->find ('first',array('conditions'=>array('User.id'=>$_REQUEST['user_id'])));
			$user_follower 	= $this->User->find ('first',array('conditions'=>array('User.id'=>$_REQUEST['follower_id'])));
						
			$followings = $user_exist['User']['followings'];
			$followers = $user_follower['User']['followers'];
			$curFoll = $followings  -1;
			$curFollowing = $followers  -1;
			if (empty($user_exist))  {
				$response = array('status'=>0,'msg'=>'User not exist.');
				echo json_encode ($response);exit;
			}			
			
					
			
			//asdadasd
			$check_user = $this->UserFollower->find ('first',array('conditions'=>array('UserFollower.follower_id'=>$_REQUEST['follower_id'])));
			if (!empty($check_user)) {
				if($this->UserFollower->deleteAll (array('UserFollower.follower_id' => $_REQUEST['follower_id'],'UserFollower.user_id' => $_REQUEST['user_id'])))  {
					$this->User->query ("update users set followings= '".$curFoll."' where id = '".$user_id."'");
					$this->User->query ("update users set followers= '".$curFollowing."' where id = '".$follower_id."'");
					$response[] = array('status'=>1,'msg'=>'success.');
					echo json_encode ($response);exit;
				}  else  {
					$response[] = array('status'=>0,'msg'=>'error.');
					echo json_encode ($response);exit;
				}
			} else {
				$response[] = array('status'=>0,'msg'=>'Follower not exist.');
				echo json_encode ($response);exit;
			}
		}
				
		//http://admin.talentswipe.com/Webservices/send_msg?user_id=5&msg=Hello Sir,This is for testing;
		function send_msg ()  {
			$this->loadModel('UserFeedback');
			$user_id 				= 	$_REQUEST['user_id'];
			$msg	 					= 	$_REQUEST['msg'];
			$user_info				=	$this->User->find('first',array('conditions'=>array('User.id'=>$user_id),'contain'=>array()));
			$admin_info			=	$this->User->find('first',array('conditions'=>array('User.id'=>1),'contain'=>array()));
			
			$name 					=	$user_info['User']['first_name'].' '.$user_info['User']['last_name'];
			$user_email			=	$user_info['User']['email'];
			$admin_email		=	$admin_info['User']['email'];
			
			$data['UserFeedback']['user_id']	=	$user_id;
			$data['UserFeedback']['msg']	=	$msg;
			$this->UserFeedback->save($data);
			//echo $admin_email;die;
			$ms 						= 	"<p>Hi Administrator  <br/><br/> An App user by the name (".$name.") submiited his feedback & suggestions. <br/>Please find his message below: <br/><br/>".$msg;
			
			$l 							= new CakeEmail();
			$l->emailFormat ('html')->template ('feedback', 'fancy')->subject ('App User Suggestions & Feedback')->to ($admin_email)->from ($user_email)->send($ms);
			$response				= array('success'=>1,'message'=>"success.");
			echo json_encode($response);
			exit;
		}

		function getvideo ($id = Null)  {
			$this->autoRender = false;
			$value 			= 	$this->AllVideo->find ('first',array('conditions'=>array('AllVideo.id'=>$id),'contain'=>array()));
			$value_name	=	$value['AllVideo']['full_video'];
			echo '<a id="close-btn" href="#">Close</a>
						<video controls style="width:400px;height:280px;" id ="myVideoTag">
							<source src="http://admin.talentswipe.com/files/full_videos/'.$value_name.'" type="video/mp4">	
						</video>';
			die;
		}
		
		//http://admin.talentswipe.com/Webservices/report_video?user_id=5&reported_by=23&video_id=23
		function report_video ()  {
			if ($_REQUEST['user_id'] == '' || $_REQUEST['reported_by'] == '' || $_REQUEST['video_id'] == '' )  {
				$response				= array('success'=>0,'message'=>"All fields are required.");
				echo json_encode($response);exit;
			}
			
			$count = $this->ReportVideo->find ('count',array('conditions'=>array('ReportVideo.user_id'=>$_REQUEST['user_id'],'ReportVideo.reported_by'=>$_REQUEST['reported_by'],'ReportVideo.video_id'=>$_REQUEST['video_id'],)));
			
			if ($count > 0) {
				$response				= array('success'=>0,'message'=>"already reported.");
				echo json_encode($response);exit;
			}
			
			$data['ReportVideo']['user_id']			= 	$_REQUEST['user_id'];
			$data['ReportVideo']['reported_by']	= 	$_REQUEST['reported_by'];
			$data['ReportVideo']['all_video_id']	= 	$_REQUEST['video_id'];
			$data['ReportVideo']['date']					= 	date("Y-m-d H:i:s");
			if ($this->ReportVideo->save($data))  {
				$response				= array('success'=>1,'message'=>"success.");
				echo json_encode($response);exit;
			}  else  {
				$response				= array('success'=>0,'message'=>"Server Error.");
				echo json_encode($response);exit;
			}
		}
		
		//http://admin.talentswipe.com/Webservices/report_comment?user_id=5&reported_by=23&comment_id=23
		function report_comment ()  {
			if ($_REQUEST['user_id'] == '' || $_REQUEST['reported_by'] == '' || $_REQUEST['comment_id'] == '' )  {
				$response				= array('success'=>0,'message'=>"All fields are required.");
				echo json_encode($response);exit;
			}
			
			$count = $this->ReportComment->find ('count',array('conditions'=>array('ReportComment.user_id'=>$_REQUEST['user_id'],'ReportComment.reported_by'=>$_REQUEST['reported_by'],'ReportComment.comment_id'=>$_REQUEST['comment_id'],)));
			
			if ($count > 0) {
				$response				= array('success'=>0,'message'=>"already reported.");
				echo json_encode($response);exit;
			}
			
			$data['ReportComment']['user_id']			= 	$_REQUEST['user_id'];
			$data['ReportComment']['reported_by']	= 	$_REQUEST['reported_by'];
			$data['ReportComment']['comment_id']			= 	$_REQUEST['comment_id'];
			$data['ReportComment']['date']					= 	date("Y-m-d H:i:s");
			if ($this->ReportComment->save($data))  {
				$response				= array('success'=>1,'message'=>"success.");
				echo json_encode($response);exit;
			}  else  {
				$response				= array('success'=>0,'message'=>"Server Error.");
				echo json_encode($response);exit;
			}
		}
		
		//http://admin.talentswipe.com/Webservices/block_user?user_id=5&reported_by=23&comment_id=23&comment=Hello Sir,This is for testing
		function block_user ()  {
			if ($_REQUEST['user_id'] == '' || $_REQUEST['reported_by'] == '' || $_REQUEST['comment_id'] == '' || $_REQUEST['comment'] == '' )  {
				$response				= array('success'=>0,'message'=>"All fields are required.");
				echo json_encode($response);exit;
			}
			
			$count = $this->UserBlock->find ('count',array('conditions'=>array('UserBlock.user_id'=>$_REQUEST['user_id'],'UserBlock.reported_by'=>$_REQUEST['reported_by'])));
			
			if ($count > 0) {
				$response				= array('success'=>0,'message'=>"already blocked.");
				echo json_encode($response);exit;
			}
			
			$data['UserBlock']['user_id']			= 	$_REQUEST['user_id'];
			$data['UserBlock']['reported_by']	= 	$_REQUEST['reported_by'];
			$data['UserBlock']['comment']			= 	$_REQUEST['comment'];
			$data['UserBlock']['date']					= 	date("Y-m-d H:i:s");
			if ($this->UserBlock->save($data))  {
				$response				= array('success'=>1,'message'=>"success.");
				echo json_encode($response);exit;
			}  else  {
				$response				= array('success'=>0,'message'=>"Server Error.");
				echo json_encode($response);exit;
			}
		}
	}
?>