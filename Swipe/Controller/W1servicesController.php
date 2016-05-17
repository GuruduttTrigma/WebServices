<?php
	#Project : N-166 (Swipe)
	App::uses('AppController', 'Controller');
	class WebservicesController extends AppController 
	{
		public $uses = array('Category','AllVideo','VideoComment','VideoLike','VideoDislike','VideoView','User','UserFollower','FavoriteVideo','SiteSetting');
  		public function beforeFilter() 
		{
			parent::beforeFilter();
			$this->Auth->allow(array('signup','login','forgot','admin_reset','changepass','myProfile','profile_edit','categories','add_video','all_videos','all_videos_of_user','all_videos_by_category_id','all_videos_by_category_id_and_user_id','like_video','dislike_video','comment_video','views_video','trim_video','total_dislikes','video_details','video_comments','user_follower','testing','favorite_video','user_favorite_video','user_following','get_products_by_bar_code','get_products_by_ingredients','favorite_video_of_user','add_follower','laderboard','user_unfollow','sitesetting'));
		}	
		
		# //http://dev414.trigma.us/N-166/Webservices/signup?username=gurudutt1&first_name=guru&last_name=sharma&profile_image=profileimage2.png&email=gurudutt.sharma@trigma.in&register_type=facebook&password=123456&conpassword=123456
		public function signup () 
		{
			if ($_REQUEST['password'] != $_REQUEST['conpassword'])  {
				$response    = 	array('status'=>0,'message'=>'Password  and Conform Password does not match.');
				echo json_encode($response);
				exit;
			}
			$data['User']['username']		=	isset ($_REQUEST['username']) ? $_REQUEST['username'] : '';
			$data['User']['first_name']		=	isset ($_REQUEST['first_name']) ? $_REQUEST['first_name'] : '';
			$data['User']['last_name']		=	isset ($_REQUEST['last_name']) ? $_REQUEST['last_name'] : '';
			$data['User']['profile_image']	=	isset ($_REQUEST['profile_image']) ? $_REQUEST['profile_image'] : '';
			$data['User']['email']				=	isset ($_REQUEST['email']) ? $_REQUEST['email'] : '';
			$data['User']['register_type']	=	isset ($_REQUEST['register_type']) ? $_REQUEST['register_type'] : '';		
			$data['User']['status'] 				=	1;
			$data['User']['register_date'] 	= 	date ("Y-m-d"); 
			$data['User']['usertype_id']  	=  7;
			
			if ($_REQUEST['register_type']	==	"facebook")  {	
				$data['User']['fb_id']  			=  @$_REQUEST['fb_id'];		
				$getFbIDStatus 					=  $this->User->find('first',array('conditions'=>array('User.fb_id'=>$_REQUEST['fb_id'])));
				if (empty($getFbIDStatus))  {
					$fbexist 						= 	$this->User->find('first',array('conditions'=>array('AND'=>array('User.fb_id'=>$_REQUEST['fb_id']))));
					if (empty($fbexist))  {						
						$this->User->create();               
						if ($this->User->save($data)) {
							$user_id  				= 	$this->User->getLastInsertID();
							$this->User->query ("update users set password= '' where id = '".$user_id."'");
							$response 			= 	array('status'=>1,'message'=>'User Register Successfully with facebook','user_id'=>$user_id);
							echo json_encode($response);die;
						}  else  {
							$response				= 	array('status'=>0,'message'=>'Please try again');
							echo json_encode($response);die;
						}
					}  else  {
						$response					= 	array('status'=>3,'message'=>'Facebook id exist, please try another email');
						echo json_encode($response);die;
					} 			
				}  else  {
					$response 					= 	array('status'=>3,'message'=>'facebook id  already exist, please try another user');
					echo json_encode($response);die;
				}
			}  	else if($_REQUEST['register_type']== "manual")  {					
				//$data['User']['password']  	=  @$_REQUEST['password'];
				$data['User']['password']  	=  AuthComponent::password($_REQUEST['password']);
				$exist 								= 	$this->User->find("first", array("conditions" => array("User.username" => $data['User']['username'])));
				if (empty($exist))  {
					$emailexist 					= 	$this->User->find('first',array('conditions'=>array('AND'=>array('User.email'=>$data['User']['email']))));
					if (empty($emailexist))  {
						$this->User->create();               
						if ($this->User->save($data)) {
							$user_id    			=  $this->User->getLastInsertID();							
							if(@$_REQUEST['profile_image']!='') {  
								$name				=  $user_id."profileImage.png";
								$this->User->saveField('profile_image',$name);
								@$_REQUEST['profile_image']	=  str_replace('data:image/png;base64,', '', @$_REQUEST['profile_image']);
								$_REQUEST['profile_image'] 		=  str_replace(' ', '+',$_REQUEST['profile_image']);
								$unencodedData						=  base64_decode($_REQUEST['profile_image']);
								$pth 											=  WWW_ROOT.'files' . DS . 'profileimage' . DS .$name;
								file_put_contents($pth, $unencodedData);
							 }
							 $isf	 			= 	$this->User->find('first',array('conditions'=>array('User.id'=>$user_id)));
							$user_id		=	isset ($isf['User']['id']) ? $isf['User']['id'] : '';	
							$username	=	isset ($isf['User']['username']) ? $isf['User']['username'] : '';								
							$email			=	isset ($isf['User']['email']) ? $isf['User']['email'] : '';	
							$contact		=	isset ($isf['User']['contact']) ? $isf['User']['contact'] : '';	
							$usertype_id	=	isset ($isf['User']['usertype_id']) ? $isf['User']['usertype_id'] : '';	
							
							$response = array (
								'status' 			=> 1,
								'message'		=> 'User Register Successfully',
								'user_id' 		=> $user_id,
								'username'	=> $username,
								'image'			=> FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$isf['User']['profile_image'],
								'email'			=> $email,
								'usertype_id'	=> $usertype_id							
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
			$fu 							= 	$this->User->find('first', array('conditions' => array('User.email' => $email)));
			if (empty($fu)) {  
				$response			= array('status'=>0,'message'=>"Email does not exist");
				echo json_encode($response);exit;		
			}
		
			if ($fu['User']['status'] != "1") {
				$response			= array('status'=>0,'message'=>"Your account has been blocked by Administrator");
				echo json_encode($response);exit;
			}
			
			$name = $fu['User']['email'];
			if  ($fu['User']['username'] != '')  {
				$name = $fu['User']['username'];
			} 
			$key 						=	Security::hash(String::uuid(), 'sha512', true);
			$hash 						= 	sha1($fu['User']['email'] . rand(0, 100));
			$url 							= 	Router::url(array('controller' => 'admin/users', 'action' => 'reset'), true) . '/' . $key . '#' . $hash;
			$ms 							= 	"<p>Hi <br/>".$name.",<br/><a href=".$url.">Click here</a> to reset your password.</p><br /> ";
			$fu['User']['token'] 		= $key;
			$this->User->id 		= $fu['User']['id'];
			if ($this->User->saveField('token', $fu['User']['token'])) {
				$l 							= new CakeEmail();
				$l->emailFormat ('html')->template ('signup', 'fancy')->subject ('Reset Your Password')->to ($email)->from ('gurudutt.sharma@trigma.in')->send($ms);
				$response			= array('success'=>1,'message'=>"Check Your Email To Reset your password");
				echo json_encode($response);
				exit;
			} 	else {				
				$response 			= array('status'=>0,'message'=>"Please try again");
				echo json_encode($response);
				exit;                                
			}
		}
		
		//	http://dev414.trigma.us/N-110BB/Webservices/reset?email=gurudutt.sharma@trigma.in
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
		
		//http://dev414.trigma.us/N-166/webservices/myProfile?id=207
		public function myProfile() 
		{  
			$id	=	$_REQUEST['id'];
			$this->User->id	=	$id;
			if($this->User->exists	())  {    
				$user=$this->User->find ('all',array('conditions'=>  array('User.id'=>$id)));
				//pr ($user);die;
				foreach ($user as $key => $value) {
					$url 				= FULL_BASE_URL.$this->webroot.'files' .DS. 'profileimage';
					$username 	= !empty($value['User']['username'])?$value['User']['username'] :'';
					$email			= !empty($value['User']['email'])?$value['User']['email'] :'';
					$first_name	=	isset ($value['User']['first_name']) ? $value['User']['first_name'] : '';
					$last_name	=	isset ($value['User']['last_name']) ? $value['User']['last_name'] : '';
					$followers		=	isset ($value['User']['followers']) ? $value['User']['followers'] : '';
					$followings	=	isset ($value['User']['last_name']) ? $value['User']['followings'] : '';
					$videos			=	isset ($value['User']['last_name']) ? $value['User']['videos'] : '';
					$location			=	isset ($value['User']['last_name']) ? $value['User']['location'] : '';
					$profile			=	isset ($value['User']['last_name']) ? $value['User']['profile'] : '';
					$dob			=	isset ($value['User']['last_name']) ? $value['User']['dob'] : '';
					$profile_image	=	isset ($value['User']['profile_image']) ? FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$value['User']['profile_image'] : '';
					
					if (!empty($value['AllVideo']))  {
						foreach ($value['AllVideo'] as $info) {
						//pr ($info);die;
							if ($info['thumbnail_images'] != '')  {
								$thumbnail_images = FULL_BASE_URL.$this->webroot.'files' . DS . 'thumbnail_images'. DS .$info['thumbnail_images'];
							}  else {
								$thumbnail_images = FULL_BASE_URL.$this->webroot.'files' . DS . 'thumbnail_images'. DS .'index.png';
							}
							$full_video 	= !empty($info['full_video'])?FULL_BASE_URL.$this->webroot.'files' . DS . 'full_videos'. DS .$info['full_video'] :'';
							$small_video 	= !empty($info['small_video'])?FULL_BASE_URL.$this->webroot.'files' . DS . 'small_videos'. DS .$info['small_video'] :'';
							$date 	= !empty($info['date'])?$info['date'] :'';
							$allvideo[] = array (
								'full_video'			=>$full_video,
								'small_video'			=>$small_video,
								'thumbnail_images'			=>$thumbnail_images,
								'title'			=>$info['title'],				
								'description'			=>$info['description'],				
								'total_likes'			=>$info['total_likes'],				
								'total_dislikes'			=>$info['total_dislikes'],				
								'total_comments'			=>$info['total_comments'],				
								'date'			=>$date,				
							);
						}
					}  else  {
						$allvideo = array();
					}
					$data	=  array (
						'id'			=>$value['User']['id'],
						'username'=>$username,
						'first_name'=>$first_name,
						'last_name'=>$last_name,
						'email'		=>$email,
						'followers'	=>$followers,
						'followings'	=>$followings,
						'profile_image'=>$profile_image,
						'videos'	=>$videos,
						'location'	=>$location,
						'profile'	=>$profile,
						'dob'	=>$dob,
						'status'		=>1,
						'allvideo'=>$allvideo
					);
				}    
				//pr ($data);die;
				echo json_encode($data);exit;
			} else {
				$data = array('status'=>0,'msg'=>'Invalid User');
				 echo json_encode($data);exit;
			}    
		}
		
		// dev414.trigma.us/N-166/w1services/profile_edit?id=2285&username=rahul&profile=manager&profile_image=profileimage2.png&dob=456&first_name=guru123&last_name=sharm
		public function profile_edit () 
		{
			$this->loadModel('User');
			$this->User->id = $_REQUEST['id'];
			if (!$this->User->exists()) 
			{	
				throw new NotFoundException(__('Invalid user'));
			}
			$user	=	$this->User->find ('first',array('conditions'=>array('User.id'=>$_REQUEST['id'])));
			$result	=  array ();
			if (!empty($user)) {
										
				if(!empty($_REQUEST['username']))  {
					$this->request->data['User']['username']	= $_REQUEST['username'];
				} 		
				/* if(!empty($_REQUEST['location']))  {
					$this->request->data['User']['location']	= $_REQUEST['location'];
				} 	 */	
				if(!empty($_REQUEST['profile']))  {
					$this->request->data['User']['profile']	= $_REQUEST['profile'];
				} 		
				if(!empty($_REQUEST['dob']))  {
					$this->request->data['User']['dob']	= $_REQUEST['dob'];
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
						$ti=date('Y-m-d-g:i:s');
						$dname= $ti.$id."image.png";
						$this->User->saveField('profile_image',$dname);
						@$_REQUEST['profile_image']= str_replace('data:image/png;base64,', '', $_REQUEST['profile_image']);
						$_REQUEST['profile_image'] = str_replace(' ', '+',$_REQUEST['profile_image']);
						$unencodedData=base64_decode($_REQUEST['profile_image']);
						$pth3 = WWW_ROOT.'files' . DS . 'profileimage'. DS .$dname;
						file_put_contents($pth3, $unencodedData);
					}

					// $user_id		    =	$user['User']['id'];
					// $username	=	$user['User']['username'];
					// $email			=	$user['User']['email'];
					// $first_name	=	$user['User']['first_name'];
					// $last_name	=	$user['User']['last_name'];
					// $followers		=	$user['User']['followers'];
					// $followings  	=	$user['User']['followings'];
					// $videos			=	$user['User']['videos'] ;
					$profile_image	=	 FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$user['User']['profile_image'] ;
					
					$result['id']					= $user['User']['id']; 
					$result['username']		= $_REQUEST['username']; 
					$result['first_name']	= $_REQUEST['first_name'];
					$result['last_name']		= $_REQUEST['last_name'];
					$result['followers']		= $user['User']['followers']; 
					$result['followings']		= $user['User']['followings']; 
					$result['videos']			= $user['User']['videos']; 
					$result['profile_image']			= $profile_image; 
					$result['email']			= $user['User']['email']; 
					$result['location']			= $user['User']['location']; 
					$result['profile']			= $_REQUEST['profile']; 
					$result['dob']			= $_REQUEST['dob'];
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
		
		//http://dev414.trigma.us/N-166/Webservices/sitesetting
		public function sitesetting () 
		{
			$data 	= 	$this->SiteSetting->find ('all');
			if (empty($data)) {
				$response = array('status'=>0,'msg'=>'no category found.');
				echo json_encode ($response);exit;
			}	
			foreach($data as $value) {
				$response[]	=	array(
					'status'				=>1,
					'web_url'				=>$value['SiteSetting']['web_url'],
					'facebook_url'		=>$value['SiteSetting']['facebook_url'],										
					'twitter_url'			=>$value['SiteSetting']['twitter_url'],										
					'googleplus'			=>$value['SiteSetting']['googleplus'],										
					'site_email'			=>$value['SiteSetting']['site_email'],										
				);
			}
			//pr ($response);
			echo json_encode($response);exit;
		}		
		
		//http://dev414.trigma.us/N-166/Webservices/add_video?user_id=2285&category_id=1&full_video=video.mp4&full_video_starting=00:00:5&full_video_ending=00:00:8&title=video&description=video is for nation&thumbnail_image=img.png
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
			$time = time();
			if($_REQUEST['full_video']!='') {  
				$name				=  $time."full_video.mov";
				$_REQUEST['full_video']		=  str_replace('data:video/mov;base64,', '',$_REQUEST['full_video']);
				$_REQUEST['full_video'] 		=  str_replace(' ', '+',$_REQUEST['full_video']);
				$unencodedData					=  base64_decode($_REQUEST['full_video']);
				$pth 										=  WWW_ROOT.'files' . DS . 'full_videos' . DS .$name;
				file_put_contents($pth, $unencodedData);
			}   
			$fullVideo		=	$pth;
			
			/*
			Cuting thumbnail
			$thumName	=	$time."thumbnailImages.png";
			$thumnailImg	=	WWW_ROOT.'files' . DS . 'thumbnail_images' . DS .$thumName;
			cut thumbnail from starting		
			exec("ffmpeg -i $fullVideo -f image2 -vframes 1 $thumnailImg");
			$thumnail_time = $_REQUEST['full_video_starting'];
			Cut thumbnail from time 
			exec ("ffmpeg -i $fullVideo -f image2 -ss $thumnail_time -vframes 1 $thumnailImg");
			*/
			
			if ($_REQUEST['thumbnail_image'] !='') {  
				$thumName	=	$time."thumbnailImages.png";
				$_REQUEST['thumbnail_image']		=  str_replace('data:video/mov;base64,', '',$_REQUEST['thumbnail_image']);
				$_REQUEST['thumbnail_image'] 		=  str_replace(' ', '+',$_REQUEST['thumbnail_image']);
				$unencodedData1								=  base64_decode($_REQUEST['thumbnail_image']);
				$thumnailImg										=	WWW_ROOT.'files' . DS . 'thumbnail_images' . DS .$thumName;
				file_put_contents($thumnailImg, $unencodedData1);
			}
		
			$full_video_starting = $_REQUEST['full_video_starting'];
			$full_video_ending	=$_REQUEST['full_video_ending'] ;
			$smViName	=	$time."small_video.mov";
			$smallVideo	= 	WWW_ROOT.'files' . DS . 'small_videos' . DS .$smViName;
			
			exec("ffmpeg -i $fullVideo -ss $full_video_starting -t $full_video_ending -async 1 $smallVideo");
		
			$data['AllVideo']['user_id']				=	$_REQUEST['user_id'];
			$data['AllVideo']['category_id']		=	$_REQUEST['category_id'];
			$data['AllVideo']['full_video']			=	$name;
			$data['AllVideo']['small_video']		=	$smViName;
			$data['AllVideo']['thumbnail_images']		=	$thumName;
			$data['AllVideo']['title']						=	$_REQUEST['title'];
			$data['AllVideo']['description']			=	$_REQUEST['description'];
			$data['AllVideo']['total_likes']			=	0;
			$data['AllVideo']['total_dislikes']		=	0;
			$data['AllVideo']['total_comments']	=	0;
			$data['AllVideo']['total_views']			=	0;
			$data['AllVideo']['date']					=	date("Y-m-d H:i:s");
			
			if ($this->AllVideo->save ($data))  {
				$response = array('status'=>1,'msg'=>'success.');
				echo json_encode ($response);exit;
			}  else  {
				$response = array('status'=>0,'msg'=>'error.');
				echo json_encode ($response);exit;
			}			
		}
		
		//http://dev414.trigma.us/N-166/Webservices/all_videos
		public function all_videos ()
		{
			$data 	= 	$this->AllVideo->find ('all',array('contain'=>array('Category.name','User.username')));
			if (empty($data)) {
				$response = array('status'=>0,'msg'=>'no video found.');
				echo json_encode ($response);exit;
			}	
			foreach ($data as $key=>$value) {
					if ($value['AllVideo']['thumbnail_images'] != '')  {
						$thumbnail_images = FULL_BASE_URL.$this->webroot.'files' . DS . 'thumbnail_images'. DS .$value['AllVideo']['thumbnail_images'];
					}  else {
						$thumbnail_images = FULL_BASE_URL.$this->webroot.'files' . DS . 'thumbnail_images'. DS .'index.png';
					}
				$response[]	=	array(
					'status'			=> 1,
					'video_id'			=> $value['AllVideo']['id'],
					'user_id'			=> $value['AllVideo']['user_id'],										
					'category_id'	=> $value['AllVideo']['category_id'],										
					'category_name'	=> $value['Category']['name'],										
					'full_video'		=> FULL_BASE_URL.$this->webroot.'files' . DS . 'full_videos'. DS .$value['AllVideo']['full_video'],										
					'small_video'	=> FULL_BASE_URL.$this->webroot.'files' . DS . 'small_videos'. DS .$value['AllVideo']['small_video'],										
					'thumbnail_images'	=> $thumbnail_images,
					'title'					=> $value['AllVideo']['title'],										
					'description'		=> $value['AllVideo']['description'],										
					'total_likes'		=> $value['AllVideo']['total_likes'].' Likes',										
					'total_dislikes'	=> $value['AllVideo']['total_dislikes'].' Dislikes',										
					'total_comments' =>$value['AllVideo']['total_comments'].' Comments',										
				'	total_views'		=>$value['AllVideo']['total_views'].'Views',											
					'date' 				=> $value['AllVideo']['date'], 										
					'username'		=> $value['User']['username'], 										
				);
			}
			//pr ($response);die;
			echo json_encode($response);exit;					
		}
		
		//http://dev414.trigma.us/N-166/Webservices/all_videos_of_user?user_id=2285
		public function all_videos_of_user ()
		{
			
			if ($_REQUEST['user_id'] == '')  {
				$response = array('status'=>0,'msg'=>'error:wrong parameters.');
				echo json_encode ($response);exit;
			} else {
				$user_id	=	$_REQUEST['user_id'] ;
			}
			$data 	= 	$this->AllVideo->find ('all',array('conditions'=>array('AllVideo.user_id'=>$user_id),'contain'=>array('Category.name','User.username')));
			//pr ($data);die;
			if (empty($data)) {
				$response = array('status'=>0,'msg'=>'no video found.');
				echo json_encode ($response);exit;
			}	
			foreach($data as $key=>$value) {
				if ($value['AllVideo']['thumbnail_images'] != '')  {
					$thumbnail_images = FULL_BASE_URL.$this->webroot.'files' . DS . 'thumbnail_images'. DS .$value['AllVideo']['thumbnail_images'];
				}  else {
					$thumbnail_images = FULL_BASE_URL.$this->webroot.'files' . DS . 'thumbnail_images'. DS .'index.png';	
				}
				$response[]	=	array(
				'status'			=> 1,
				'video_id'				=> $value['AllVideo']['id'],
				'user_id'		=> $value['AllVideo']['user_id'],										
				'category_id'	=> $value['AllVideo']['category_id'],										
				'category_name'	=> $value['Category']['name'],										
				'full_video'		=> FULL_BASE_URL.$this->webroot.'files' . DS . 'full_videos'. DS .$value['AllVideo']['full_video'],										
				'small_video'	=> FULL_BASE_URL.$this->webroot.'files' . DS . 'small_videos'. DS .$value['AllVideo']['small_video'],										
				'thumbnail_images'	=> $thumbnail_images,										
				'title'				=> $value['AllVideo']['title'],										
				'description'	=> $value['AllVideo']['description'],										
				'total_likes'	=> $value['AllVideo']['total_likes'].' Likes',										
				'total_dislikes'		=> $value['AllVideo']['total_dislikes'].' Dislikes',										
				'total_comments' =>$value['AllVideo']['total_comments'].' Comments',										
				'total_views'=>$value['AllVideo']['total_views'].'Views',										
				'date' 			=> $value['AllVideo']['date'], 										
				'username'	=> $value['User']['username'], 										
				'cat_name'		=> $value['Category']['name'], 									
				);
			}
			//pr ($response);
			echo json_encode($response);exit;
						
		}
		
		//http://dev414.trigma.us/N-166/Webservices/all_videos_by_category_id?category_id=1
		public function all_videos_by_category_id ()
		{
			if ($_REQUEST['category_id'] == '')  {
				$response = array('status'=>0,'msg'=>'error:wrong parameters.');
				echo json_encode ($response);exit;
			} else {
				$category_id	=	$_REQUEST['category_id'] ;
			}
			$data 	= 	$this->AllVideo->find ('all',array('conditions'=>array('AllVideo.category_id'=>$category_id),'contain'=>array('Category.name','User.username')));
			if (empty($data)) {
				$response = array('status'=>0,'msg'=>'no video found.');
				echo json_encode ($response);exit;
			}	
			foreach($data as $key=>$value) {
					if ($value['AllVideo']['thumbnail_images'] != '')  {
						$thumbnail_images = FULL_BASE_URL.$this->webroot.'files' . DS . 'thumbnail_images'. DS .$value['AllVideo']['thumbnail_images'];	
					}  else {
						$thumbnail_images = FULL_BASE_URL.$this->webroot.'files' . DS . 'thumbnail_images'. DS .'index.png';	
					}
					$response[]	=	array(
					'status'			=> 1,
					'video_id'			=> $value['AllVideo']['id'],
					'user_id'			=> $value['AllVideo']['user_id'],										
					'category_id'	=> $value['AllVideo']['category_id'],										
					'category_name'	=> $value['Category']['name'],										
					'full_video'		=> FULL_BASE_URL.$this->webroot.'files' . DS . 'full_videos'. DS .$value['AllVideo']['full_video'],										
					'small_video'	=>FULL_BASE_URL.$this->webroot.'files' . DS . 'small_videos'. DS .$value['AllVideo']['small_video'],										
					'thumbnail_images'	=>$thumbnail_images,										
					'title'					=> $value['AllVideo']['title'],										
					'description'		=> $value['AllVideo']['description'],										
					'total_likes'		=> $value['AllVideo']['total_likes'].' Likes',										
					'total_dislikes'	=> $value['AllVideo']['total_dislikes'].' Dislikes',										
					'total_comments' =>$value['AllVideo']['total_comments'].' Comments',										
					'total_views'	=>$value['AllVideo']['total_views'].' Views',										
					'date' 				=> $value['AllVideo']['date'], 										
					'username'		=> $value['User']['username'], 										
					'cat_name'		=> $value['Category']['name'], 									
					);
			}
			if (empty($response))  {
				$response = array('status'=>0,'msg'=>'no video found.');
				echo json_encode ($response);exit;
			}
			//pr ($response);die;
			echo json_encode($response);exit;
						
		}
		
		//http://dev414.trigma.us/N-166/Webservices/all_videos_by_category_id?category_id=1&user_id=2340
		public function all_videos_by_category_id_and_user_id ()
		{
			if ($_REQUEST['category_id'] == '')  {
				$response = array('status'=>0,'msg'=>'error:wrong parameters.');
				echo json_encode ($response);exit;
			} else {
				$user_id			=	$_REQUEST['user_id'] ;
				$category_id	=	$_REQUEST['category_id'] ;
			}
			$data 	= 	$this->AllVideo->find ('all',array('conditions'=>array('AND'=>array('AllVideo.category_id'=>$category_id,'AllVideo.user_id'=>$user_id)),'contain'=>array('Category.name','User.username')));
			if (empty($data)) {
				$response = array('status'=>0,'msg'=>'no video found.');
				echo json_encode ($response);exit;
			}	
			foreach($data as $key=>$value) {
					if ($value['AllVideo']['thumbnail_images'] != '')  {
						$thumbnail_images = FULL_BASE_URL.$this->webroot.'files' . DS . 'thumbnail_images'. DS .$value['AllVideo']['thumbnail_images'];	
					}  else {
						$thumbnail_images = FULL_BASE_URL.$this->webroot.'files' . DS . 'thumbnail_images'. DS .'index.png';	
					}
					$response[]	=	array(
					'status'			=> 1,
					'video_id'			=> $value['AllVideo']['id'],
					'user_id'			=> $value['AllVideo']['user_id'],										
					'category_id'	=> $value['AllVideo']['category_id'],										
					'category_name'	=> $value['Category']['name'],										
					'full_video'		=> FULL_BASE_URL.$this->webroot.'files' . DS . 'full_videos'. DS .$value['AllVideo']['full_video'],										
					'small_video'	=>FULL_BASE_URL.$this->webroot.'files' . DS . 'small_videos'. DS .$value['AllVideo']['small_video'],										
					'thumbnail_images'	=>$thumbnail_images,										
					'title'					=> $value['AllVideo']['title'],										
					'description'		=> $value['AllVideo']['description'],										
					'total_likes'		=> $value['AllVideo']['total_likes'].' Likes',										
					'total_dislikes'	=> $value['AllVideo']['total_dislikes'].' Dislikes',										
					'total_comments' =>$value['AllVideo']['total_comments'].' Comments',										
					'total_views'	=>$value['AllVideo']['total_views'].' Views',										
					'date' 				=> $value['AllVideo']['date'], 										
					'username'		=> $value['User']['username'], 										
					'cat_name'		=> $value['Category']['name'], 									
					);
			}
			if (empty($response))  {
				$response = array('status'=>0,'msg'=>'no video found.');
				echo json_encode ($response);exit;
			}
			//pr ($response);die;
			echo json_encode($response);exit;
						
		}
		
		//http://dev414.trigma.us/N-166/Webservices/like_video?user_id=2285&video_id=1
		public function like_video ()
		{
			if ($_REQUEST['user_id'] == '' or $_REQUEST['video_id'] == '')  {
				$response = array('status'=>0,'msg'=>'error:wrong parameters.');
				echo json_encode ($response);exit;
			} else {
				$user_id	=	$_REQUEST['user_id'];
				$video_id	=	$_REQUEST['video_id'];
			}
			
			$exist	=	$this->VideoLike->find('first',array('conditions'=>array('AND'=>array('VideoLike.user_id'=>$user_id,'VideoLike.all_video_id'=>$video_id)),'contain'=>array()));
			if (!empty($exist)) {
				$response = array('status'=>0,'msg'=>'error: you already like this video.');
				echo json_encode ($response);exit;
			}
			
			$data['VideoLike']['user_id']	=	$_REQUEST['user_id'];
			$data['VideoLike']['all_video_id']	=	$_REQUEST['video_id'];
			$data['VideoLike']['date']			=	date("Y-m-d H:i:s");
			
			if ($this->VideoLike->save ($data))  {
				$id		=	$this->VideoLike->getLastInsertId();
				$videos	=	$this->AllVideo->find('first',array('conditions'=>array('AllVideo.id'=>$video_id),'contain'=>array()));
				$update['AllVideo']['id']	=	$video_id;
				$update['AllVideo']['total_likes']	=	$videos['AllVideo']['total_likes'] + 1;
				if ($this->AllVideo->save ($update))  {
					$response = array('status'=>0,'msg'=>'success.');
					echo json_encode ($response);exit;
				}
			}  else  {
				$response = array('status'=>0,'msg'=>'error.');
				echo json_encode ($response);exit;
			}			
		}
		
		//http://dev414.trigma.us/N-166/Webservices/dislike_video?user_id=2285&video_id=1
		public function dislike_video ()
		{
			if ($_REQUEST['user_id'] == '' or $_REQUEST['video_id'] == '')  {
				$response = array('status'=>0,'msg'=>'error:wrong parameters.');
				echo json_encode ($response);exit;
			} else {
				$user_id	=	$_REQUEST['user_id'];
				$video_id	=	$_REQUEST['video_id'];
			}
			
			$exist	=	$this->VideoLike->find('first',array('conditions'=>array('AND'=>array('VideoLike.user_id'=>$user_id,'VideoLike.all_video_id'=>$video_id)),'contain'=>array()));
			//pr($exist);die;
			if (empty($exist)) {
				$response = array('status'=>0,'msg'=>'error: you already dislike this video.');
				echo json_encode ($response);exit;
			}
						
			if ($this->VideoLike->deleteAll (array('VideoLike.all_video_id' => $video_id,'VideoLike.user_id' => $user_id)))  {
				$id		=	$this->VideoLike->getLastInsertId();
				$videos	=	$this->AllVideo->find('first',array('conditions'=>array('AllVideo.id'=>$video_id),'contain'=>array()));
				$update['AllVideo']['id']	=	$video_id;
				$update['AllVideo']['total_likes']	=	$videos['AllVideo']['total_likes'] - 1;
				if ($this->AllVideo->save ($update))  {
					$response = array('status'=>1,'msg'=>'success.');
					echo json_encode ($response);exit;
				}
			}  else  {
				$response = array('status'=>0,'msg'=>'error.');
				echo json_encode ($response);exit;
			}			
		}
		
		//http://dev414.trigma.us/N-166/Webservices/favorite_video?user_id=2285&video_id=1
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
		
		//http://dev414.trigma.us/N-166/Webservices/favorite_video_of_user?user_id=2314&index=1
		public function favorite_video_of_user ()
		{
			//$this->FavoriteVideo->recursive = 2;
			
			if ($_REQUEST['user_id'] == '' )  {
				$response = array('status'=>0,'msg'=>'error:wrong parameters.');
				echo json_encode ($response);exit;
			} else {
				$user_id	=	$_REQUEST['user_id'];
			}
			if (@$_REQUEST['index'] == '' )  {
				$offset = 1;
			} else {
				$offset	=	$_REQUEST['index'];
			}
			$exist	=	$this->FavoriteVideo->find(
				'all',array(
					'conditions'=>array('FavoriteVideo.user_id'=>$user_id),
					'limit'=>10,
					'offset'=>$offset,
					'contain'=>array(
						'User'=>array('UserType'),
						'AllVideo'=>array(
							'User','Category'
						)
					)
				)
			);
			//pr ($exist);die;
			if (empty($exist)) {
				$response = array('status'=>0,'msg'=>'No data found.');
				echo json_encode ($response);exit;
			}
			
			foreach($exist as $key=>$value) {
				
				$response[]	=	array(
				'status'			=> 1,
				'video_id'			=> $value['AllVideo']['id'],
				'user_id'			=> $value['AllVideo']['user_id'],										
				'category_id'	=> $value['AllVideo']['category_id'],										
				'full_video'		=> FULL_BASE_URL.$this->webroot.'files' . DS . 'full_videos'. DS .$value['AllVideo']['full_video'],										
				'small_video'	=> FULL_BASE_URL.$this->webroot.'files' . DS . 'small_videos'. DS .$value['AllVideo']['small_video'],										
				'thumbnail_images'	=> FULL_BASE_URL.$this->webroot.'files' . DS . 'thumbnail_images'. DS .$value['AllVideo']['thumbnail_images'],										
				'title'					=> $value['AllVideo']['title'],										
				'description'		=> $value['AllVideo']['description'],										
				'total_likes'		=> $value['AllVideo']['total_likes'],										
				'total_dislikes'	=> $value['AllVideo']['total_dislikes'],										
				'total_comments' =>$value['AllVideo']['total_comments'],										
				'total_views'	=>$value['AllVideo']['total_views'],										
				'date' 				=> $value['AllVideo']['date'], 										
				'username'		=> $value['User']['username'], 										
				);
			}
			//pr ($response);
			echo json_encode ($response);exit;
		}
		
		
		//http://dev414.trigma.us/N-166/Webservices/comment_video?user_id=2285&video_id=1&comment=hello
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
					$response = array('status'=>0,'msg'=>'success.');
					echo json_encode ($response);exit;
				}
			}  else  {
				$response = array('status'=>0,'msg'=>'error.');
				echo json_encode ($response);exit;
			}			
		}
		
		
		//http://dev414.trigma.us/N-166/Webservices/views_video?user_id=2285&video_id=1
		public function views_video ()
		{
			if ($_REQUEST['user_id'] == '' or $_REQUEST['video_id'] == '')  {
				$response = array('status'=>0,'msg'=>'error:wrong parameters.');
				echo json_encode ($response);exit;
			} else {
				$user_id	=	$_REQUEST['user_id'];
				$video_id	=	$_REQUEST['video_id'];
			}
			
			$data['VideoView']['user_id']	=	$_REQUEST['user_id'];
			$data['VideoView']['all_video_id']	=	$_REQUEST['video_id'];
			$data['VideoView']['date']			=	date("Y-m-d H:i:s");
			
			if ($this->VideoView->save ($data))  {
				$id		=	$this->VideoView->getLastInsertId();
				$videos	=	$this->AllVideo->find('first',array('conditions'=>array('AllVideo.id'=>$video_id),'contain'=>array()));
				$update['AllVideo']['id']	=	$video_id;
				$update['AllVideo']['total_views']	=	$videos['AllVideo']['total_views'] + 1;
				if ($this->AllVideo->save ($update))  {
					$response = array('status'=>0,'msg'=>'success.');
					echo json_encode ($response);exit;
				}
			}  else  {
				$response = array('status'=>0,'msg'=>'error.');
				echo json_encode ($response);exit;
			}			
		}
		
				
		//http://dev414.trigma.us/N-166/Webservices/video_details?video_id=3&user_id=2314&follower_id=2223
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
				'favorite_status'=>'SELECT count(*) FROM favorite_videos WHERE all_video_id='.$video_id.' and user_id='.$user_id.'',
				'follower_status'=>'SELECT count(*) FROM user_followers WHERE follower_id ='.$follower_id.' and user_id='.$user_id.'',
			);
			$value 	= 	$this->AllVideo->find ('first',array('conditions'=>array('AllVideo.id'=>$video_id),'contain'=>array('Category.name','User.username')));
							//$exist 								= 	$this->User->find("first", array("conditions" => array("User.username" => $data['User']['username'])));

			//pr ($value);die;
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
				$profile_image = '';
			} else {
				$profile_image = FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$value['User']['profile_image'];
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
				'total_likes'		=> $value['AllVideo']['total_likes'].' Likes',										
				'total_dislikes'		=> $value['AllVideo']['total_dislikes'].' Dislikes',										
				'total_comments' =>$value['AllVideo']['total_comments'].' Comments',										
				'total_views'	=>$value['AllVideo']['total_views'].' Views',										
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
		
		//http://dev414.trigma.us/N-166/Webservices/video_comments?video_id=1
		public function video_comments ()
		{
			$this->VideoComment->contain(array('User','AllVideo'=>array('User.id','User.username','User.email','User.followers','User.followings','User.register_date','User.profile_image','User.contact')));
			$data 	= 	$this->VideoComment->find ('all');
			//pr ($data);die; 
			if (empty($data)) {
				$response = array('status'=>0,'msg'=>'no video found.');
				echo json_encode ($response);exit;
			}	
			foreach($data as $key=>$value) {
				$response[]	=	array(
					'status'			=> 1,
					'id'				=> $value['VideoComment']['id'],
					'user_id'		=> $value['VideoComment']['user_id'],										
					'video_id'		=> $value['VideoComment']['all_video_id'],										
					'comment'		=> $value['VideoComment']['comment'],										
					'date'				=> $value['VideoComment']['date'],										
					'username'	=> $value['User']['username'],										
					'title'				=> $value['AllVideo']['title'],										
					'description'	=> $value['AllVideo']['description'],										
					'total_likes'		=> $value['AllVideo']['total_likes'].' Likes',										
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
		
		//http://dev414.trigma.us/N-166/Webservices/add_follower?user_id=2260&follower_id=3236
		public function add_follower () 
		{
			$this->loadModel ('UserFollower');
			$data['UserFollower']['user_id']				=	$_REQUEST['user_id'];
			$data['UserFollower']['follower_id']			=	$_REQUEST['follower_id'];
			$data['UserFollower']['user_types_id']	=	2;
			$data['UserFollower']['date']				=	date('Y-m-d');
			
			$user_exist 	= $this->User->find ('first',array('conditions'=>array('User.id'=>$_REQUEST['follower_id'])));
			$check_user = $this->UserFollower->find ('first',array('conditions'=>array('AND'=>array('UserFollower.follower_id'=>$_REQUEST['follower_id'],'UserFollower.user_id'=>$_REQUEST['user_id']))));
			
			//pr ($user_exist);die;
			if (empty($user_exist))  {
				$response = array('status'=>0,'msg'=>'User not exist.');
				echo json_encode ($response);exit;
			}			
			if (empty($check_user)) {
				if ($this->UserFollower->save($data))  {
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
		
		//http://dev414.trigma.us/N-166/Webservices/user_follower?user_id=1
		public function user_follower ()
		{
			$data 	= 	$this->User->find ('first',array('conditions'=>array('User.id'=>$_REQUEST['user_id']),'contain'=>array('Following'=>array('User'),'Follower'=>array('User','Follower1'))));
			//pr ($data);die; 
			if (empty($data)) {
				$response = array('status'=>0,'msg'=>'no follower found.');
				echo json_encode ($response);exit;
			}	
			$id 				= $data['User']['id'];
			$username	= $data['User']['username'];		
			foreach($data['Follower'] as $key=>$value) {
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
					'followers_videos'		=> $value['Follower1']['videos'],										
					'followers_profile_image'	=> FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$value['Follower1']['profile_image'],								
				);
			}
			//pr ($response);die;
			echo json_encode($response);exit;					
		}
		
		//http://dev414.trigma.us/N-166/Webservices/user_following?user_id=1
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
						'followers_profile_image'	=> FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$value['User']['profile_image'],								
					);
				}
			}
			if (empty($response)) {
				$response = array('status'=>0,'msg'=>'no follower found.');
				echo json_encode ($response);exit;
			}	
			//pr ($response);die;
			echo json_encode($response);exit;					
		}
		
		//http://dev414.trigma.us/N-166/Webservices/user_unfollow?user_id=2260&follower_id=3236
		public function user_unfollow () 
		{
			$this->loadModel ('UserFollower');
			$data['UserFollower']['user_id']			=	$_REQUEST['user_id'];
			$data['UserFollower']['follower_id']		=	$_REQUEST['follower_id'];
			$check_user = $this->UserFollower->find ('first',array('conditions'=>array('UserFollower.follower_id'=>$_REQUEST['follower_id'])));
			if (!empty($check_user)) {
				if($this->UserFollower->deleteAll (array('UserFollower.follower_id' => $_REQUEST['follower_id'],'UserFollower.user_id' => $_REQUEST['user_id'])))  {
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
		//http://dev414.trigma.us/N-166/Webservices/get_products_by_bar_code
		public function get_products_by_bar_code () 
		{
			Configure::write('debug',2);
			App::import('Vendor', 'factual-php-driver-master',array('file'=>'factual-php-driver-master/Factual.php'));
			
			$tableName = "products-cpg";
			
			$factual_api_key     = "ivg1N0ckRGOCBEh0WuZihMDY9T7DYzZmVXifYu5o";
            $factual_api_sec     = "tE9hakw2MiU643lfDYcustbrdJ5p8g9da4vi5oB1";
            $mapbox_access_token = "YOUR_MAPBOX_ACCESS_TOKEN";
            $mapbox_map_id       = "YOUR_MAP_ID";            
			/** instantiate Factual driver **/
            $factual = new Factual($factual_api_key, $factual_api_sec);
            //Search for products containing the word "shampoo"
			
			$query = new FactualQuery;
			//$query->search("shampoo");
			$query->field("upc")->equal("080878053605"); 
			$res = $factual->fetch($tableName, $query); 
			echo "<pre>";print_r($res->getData());			
			die;
		}	
		
		//http://dev414.trigma.us/N-166/Webservices/get_products_by_ingredients
		public function get_products_by_ingredients () 
		{
			Configure::write('debug',2);
			App::import('Vendor', 'factual-php-driver-master',array('file'=>'factual-php-driver-master/Factual.php'));
			
			$tableName = "products-cpg-nutrition";
			
			$factual_api_key     = "ivg1N0ckRGOCBEh0WuZihMDY9T7DYzZmVXifYu5o";
            $factual_api_sec     = "tE9hakw2MiU643lfDYcustbrdJ5p8g9da4vi5oB1";
            $mapbox_access_token = "YOUR_MAPBOX_ACCESS_TOKEN";
            $mapbox_map_id       = "YOUR_MAP_ID";            
			/** instantiate Factual driver **/
            $factual = new Factual($factual_api_key, $factual_api_sec);
            //Search for products containing the word "shampoo"
			define(PAGE_SIZE, 10);
			$query = new FactualQuery;
			//$query->search("shampoo");
			//$query->limit(10);
			 $query->offset($page * PAGE_SIZE);
			$query->limit(PAGE_SIZE);
			$query->field("ingredients")->equal("Pork"); 
			$res = $factual->fetch($tableName, $query); 
			echo "<pre>";print_r($res->getData());			
			die;
		}	
		
			//http://dev414.trigma.us/N-166/Webservices/laderboard?category_id=1
		public function laderboard ()
		{
			if ($_REQUEST['category_id'] == '')  {
				$response[] = array('status'=>0,'msg'=>'error:wrong parameters.');
				echo json_encode ($response);exit;
			} else {
				$category_id	=	$_REQUEST['category_id'] ;
			}
			$data 	= 	$this->AllVideo->find ('all',array('conditions'=>array('AllVideo.category_id'=>$category_id),'contain'=>array('Category.name','User.username')));
			if (empty($data)) {
				$response[] = array('status'=>0,'msg'=>'no video found.');
				echo json_encode ($response);exit;
			}	
			foreach($data as $key=>$value) {
				if ($value['AllVideo']['thumbnail_images'] != '')  {
					$thumbnail_images = FULL_BASE_URL.$this->webroot.'files' . DS . 'thumbnail_images'. DS .$value['AllVideo']['thumbnail_images'];
				}  else {
					$thumbnail_images = FULL_BASE_URL.$this->webroot.'files' . DS . 'thumbnail_images'. DS .'index.png';
				}
				if ($value['AllVideo']['total_views'] >50)  {
					$response[]	=	array(
					'status'			=> 1,
					'video_id'			=> $value['AllVideo']['id'],
					'user_id'			=> $value['AllVideo']['user_id'],										
					'category_id'	=> $value['AllVideo']['category_id'],										
					'category_name'	=> $value['Category']['name'],										
					'full_video'		=> FULL_BASE_URL.$this->webroot.'files' . DS . 'full_videos'. DS .$value['AllVideo']['full_video'],										
					'small_video'	=>FULL_BASE_URL.$this->webroot.'files' . DS . 'small_videos'. DS .$value['AllVideo']['small_video'],										
					'thumbnail_images'	=>	$thumbnail_images,								
					'title'					=> $value['AllVideo']['title'],										
					'description'		=> $value['AllVideo']['description'],										
					'total_likes'		=> $value['AllVideo']['total_likes'].' '.'Likes',										
					'total_dislikes'	=> $value['AllVideo']['total_dislikes'].' '.'Dislikes',										
					'total_comments' =>$value['AllVideo']['total_comments'].' '.'Comments',										
					'total_views'	=>$value['AllVideo']['total_views'].' '.'Views',										
					'date' 				=> $value['AllVideo']['date'], 										
					'username'		=> $value['User']['username'], 										
					'cat_name'		=> $value['Category']['name'], 									
					);
				}
			}
			if (empty($response))  {
				$response = array('status'=>0,'msg'=>'no video found.');
				echo json_encode ($response);exit;
			}
			//pr ($response);die;
			echo json_encode($response);exit;
						
	}
	
	//http://dev414.trigma.us/N-166/Webservices/testing
	public function testing () 
	{
		mail("+919988252428", "", "Test SMS", "From: RRPowered <test@rrpowered.com>rn");die;
	}
	
	
		
		
	}