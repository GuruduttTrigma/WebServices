<?php
App::uses('AppController', 'Controller');
/**
 * Sitesettings Controller
 *
 * @property Sitesetting $Sitesetting
 */
class WebservicesController extends AppController {
        public function beforeFilter() {
		            parent::beforeFilter();
                            $this->Auth->allow(array('add','adsList','adsDetails','mobileuserlogin','userAds','adsshare','nearby','getNearUser','nearbytotal','AdvertiserStatus','sendPaypalDetails','getZipCodeByLocation','getTotalFriends'));
                            $this->loadModel('Advertisement');
							$this->loadModel('Advertisercost');
							$this->loadModel('Advertiserearn');
                            $this->loadModel('Sitesetting');
                            $this->loadModel('User');
	    }

 
/*********************************** Webservices List **********************************************/

// http://dev414.trigma.us/onbeat/webservices/getTotalFriends?lat=19.727456&long=72.846537

	public function getTotalFriends(){	
		  //  configure::write('debug',2);
			$this->loadModel('User');
			$lat = $_REQUEST['lat'];
			$long = $_REQUEST['long'];
			$lat1=$lat;
			$lng1=$long;
			$UserCount =array();
			$range=500*1609.344;
            $all=$this->User->find('all');
			if($all) {
				$i=0;
				$u_count=0;
				$curr=date('Y-m-d H:i');
				foreach($all as $single){
				$lat2=$single['User']['lat'];
				$lng2=$single['User']['long'];	
				$earthRadius = 3958.75;
				$dLat = deg2rad($lat2-$lat1);
				$dLng = deg2rad($lng2-$lng1);
				$a = sin($dLat/2) * sin($dLat/2) +
				cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
				sin($dLng/2) * sin($dLng/2);
				$c = 2 * atan2(sqrt($a), sqrt(1-$a));
				$dist = $earthRadius * $c;
				// from miles
				$meterConversion = 1609;
				$geopointDistance = $dist * $meterConversion;										
				$get=$geopointDistance;
			    $ran =  500;
				if(round($get * 0.000621371192,2)<= $ran){
											$total += $single['User']['fb_friend'];
				}	
				$i++;
				}
				if(!empty($total)){
					echo $total;
				} else {
					echo '0';
				}
			}
			exit;
	}

// http://dev414.trigma.us/onbeat/webservices/nearby?lat=19.727456&long=72.846537
	
	public function nearbytotal($lat,$long){	
		  //  configure::write('debug',2);
			$this->loadModel('User');
			$lat1=$lat;
			$lng1=$long;
			$UserCount =array();
			$range=500*1609.344;
            $all=$this->User->find('all');
			if($all) {
				$i=0;
				$u_count=0;
				$curr=date('Y-m-d H:i');
				foreach($all as $single){
					$lat2=$single['User']['lat'];
					$lng2=$single['User']['long'];	
					$earthRadius = 3958.75;
					$dLat = deg2rad($lat2-$lat1);
					$dLng = deg2rad($lng2-$lng1);
					$a = sin($dLat/2) * sin($dLat/2) +
					cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
					sin($dLng/2) * sin($dLng/2);
					$c = 2 * atan2(sqrt($a), sqrt(1-$a));
					$dist = $earthRadius * $c;
					// from miles
					$meterConversion = 1609;
					$geopointDistance = $dist * $meterConversion;										
					$get=$geopointDistance;
					$ran =  500;
					if(round($get * 0.000621371192,2)<= $ran){
												$total += $single['User']['fb_friend'];
					}	
					$i++;
				}
				if(!empty($total)){
					return $total;
				} else {
					return '';
				}
			}
	}
	

// http://dev414.trigma.us/onbeat/webservices/adsshare?shared_userid=1&post_id=7

	public function adsshare(){
		   $this->loadModel('Share');
		   $this->loadModel('Advertisement');
		   $shared_id = $_REQUEST['shared_userid'];
		   $postId = $_REQUEST['post_id'];
			if($shared_id!='' && $postId!=''){
				$userDetails = $this->User->find('first',array('conditions'=>array('User.id'=>$shared_id)));
				$totalFriends = $userDetails['User']['fb_friend'];
					if($totalFriends>0){
						$totalEarn = $this->Advertiserearn->query("SELECT earn_per_post from advertiserearns where no_of_friends_fr <='".$totalFriends."' AND 	no_of_friends_to >= '".$totalFriends."'");
						$this->request->data['Share']['earn'] =  $totalEarn[0]['advertiserearns']['earn_per_post'];	
						$this->request->data['Share']['user_id'] = $shared_id;
						$this->request->data['Share']['post_id'] = $postId;
						$this->request->data['Share']['status'] = 1;
						$this->Share->create();
						$this->Share->save($this->request->data);
						$ads = $this->Advertisement->find('first',array('conditions'=>array('Advertisement.id'=>$postId)));
						$response = array('post_id'=>$ads['Advertisement']['id'],
													'title'=>$ads['Advertisement']['title'],
													'location'=>$ads['Advertisement']['location'],
													'image'=>FULL_BASE_URL.$this->webroot.'files/screens/'.$ads['Advertisement']['image'],
													'description'=>$ads['Advertisement']['description'],
													'status'=>1,
													'msg'=>'Advertisement Shared Successfully.'
						);					
						echo json_encode($response);
						exit;								
					}	else { 
						$response = array('status'=>0,'msg'=>'you have no friends to share..');
						echo json_encode($response);
						exit;		
					}
			} else {
					$response = array('status'=>0,'msg'=>'Please Provide user id And post id.');
					echo json_encode($response);
					exit;				
			}	
	}

	public function adsList(){
		$this->loadModel('Share');
		$this->loadModel('User');
		$user_id = $_REQUEST['user_id'];
		$ads = $this->Advertisement->find('all',array('conditions'=>array('Advertisement.status'=>1),'order'=>array('Advertisement.id'=>'desc')));
			if(!empty($ads)){
					$userAds = $this->User->find('first',array('conditions'=>array('User.id'=>$user_id)));
				///	$response = array('status'=>1);
					foreach($ads as $ad){
						$getShare=$this->Share->find('first',array('conditions'=>array('AND'=>array('Share.user_id'=>$user_id,'Share.post_id' => $ad['Advertisement']['id']))));
						if(empty($getShare))
						{
								$userDetails = $this->User->find('first',array('conditions'=>array('User.id'=>$user_id)));
								$totalFriends = $userDetails['User']['fb_friend'];
								$totalEarn = $this->Advertiserearn->query("SELECT earn_per_post from advertiserearns where no_of_friends_fr <='".$totalFriends."' AND 	no_of_friends_to >= '".$totalFriends."'");
								$earn =  $totalEarn[0]['advertiserearns']['earn_per_post'];	
								
									$response['adsList'][] = array('id'=>$ad['Advertisement']['id'],
									  'title' => $ad['Advertisement']['title'],
									  'location' => $ad['Advertisement']['location'],
									  'image'=> FULL_BASE_URL.$this->webroot.'files/screens/'.$ad['Advertisement']['image'],
									  'description' => $ad['Advertisement']['description'],
									  'friends' => $totalFriends,
									  'earn' => @$earn
									 );
						}
					}
					if(!empty($response)){
						$response['status'] = 1;
					} else {
						$response = array('status'=>0,'msg'=>'Advertisement not available');
					}
					echo json_encode($response);
					exit;		
			} else {
					$response= array('status'=>0,'msg'=>'Advertisement not available');
					echo json_encode($response);
					exit;
			}		
	}
	
	public function adsDetails($ad_id=null){
		$adsId = $_REQUEST['ad_id'];
		$ads = $this->Advertisement->find('first',array('conditions' =>array('Advertisement.id'=>$adsId)));
		$data = array('id' =>$ads['Advertisement']['id'],
							 'title' =>$ads['Advertisement']['title'],
							 'location'=>$ads['Advertisement']['location'],
							 'image' =>  FULL_BASE_URL.$this->webroot.'files/screens/'.$ads['Advertisement']['image'],
							 'description' =>$ads['Advertisement']['description'],
							);
		 $ad = json_encode($data);
          echo $ad;
          exit;   
	}
	
	function getLnt($zip){
		$url = "http://maps.googleapis.com/maps/api/geocode/json?address=
		".urlencode($zip)."&sensor=false";
		$result_string = file_get_contents($url);
		$result = json_decode($result_string, true);
		$result1[]=$result['results'][0];
		$result2[]=$result1[0]['geometry'];
		$result3[]=$result2[0]['location'];
		return $result3[0];
	}
	
// http://dev414.trigma.us/onbeat/webservices/add?user_id=184&title=test&email=test@gmail.com&promo_code=123&post_code=160071&optional_postcode1=160075&optional_postcode2=521362&description=test only.&image=img.png	
	public function add(){
						$this->loadModel('Advertiserearn');
						$this->autoRender = false;  
						$this->request->data['Advertisement']['status'] = '0';
						$this->request->data['Advertisement']['user_id'] = $_REQUEST['user_id'];
						$this->request->data['Advertisement']['title'] = $_REQUEST['title'];		
						$this->request->data['Advertisement']['email'] = $_REQUEST['email'];				
						$this->request->data['Advertisement']['description'] = $_REQUEST['description'];	
						$this->request->data['Advertisement']['image'] = $_REQUEST['image'];	
						if(!empty($_REQUEST['promo_code'])){
							$this->request->data['Advertisement']['promo_code'] = $_REQUEST['promo_code'];							
						} else {
							$this->request->data['Advertisement']['promo_code'] = '';					
						}
						if(!empty($_REQUEST['optional_postcode1'])){
							$this->request->data['Advertisement']['optional_postcode1'] = $_REQUEST['optional_postcode1'];							
						} else {
							$this->request->data['Advertisement']['optional_postcode1'] = '';					
						}			
						if(!empty($_REQUEST['optional_postcode2'])){
							$this->request->data['Advertisement']['optional_postcode2'] = $_REQUEST['optional_postcode2'];							
						} else {
							$this->request->data['Advertisement']['optional_postcode1'] = '';					
						}	
						if(!empty($_REQUEST['post_code'])){
							$this->request->data['Advertisement']['post_code'] = $_REQUEST['post_code'];							
						} else {
							$this->request->data['Advertisement']['post_code'] = '';					
						}						
						$zip = $_REQUEST['post_code'];
						$val = $this->getLnt($zip);
						if(!empty($val)){
							$this->request->data['User']['lat'] = $val['lat'];	
							$this->request->data['User']['long'] = $val['lng'];	
							$totalFriend = $this->nearbytotal($val['lat'],$val['lng']);
								if(!empty($totalFriend)){
									$earn = $this->Advertisercost->query("SELECT cost from advertisercosts where potential_from <='".$totalFriend."' AND potential >= '".$totalFriend."'");			
								
									$this->request->data['Advertisement']['total_earn'] =  $earn[0]['advertisercosts']['cost'];	
								}	
							 // print_r($totalFriend); exit;
						} 			
						$this->Advertisement->create();
						if ($this->Advertisement->save($this->request->data)) {
								$id=$this->Advertisement->getLastInsertId();	
								$dname= $id."image.png";
								$this->Advertisement->saveField('image',$dname);                      
								@$_REQUEST['image']= str_replace('data:image/png;base64,', '', $_REQUEST['image']);
								$_REQUEST['image'] = str_replace(' ', '+',$_REQUEST['image']);
								$unencodedData=base64_decode($_REQUEST['image']);
								$pth3 = WWW_ROOT.'files' . DS . 'screens'. DS .$dname;
								$pth4 = WWW_ROOT.'files' . DS . 'smallimages'. DS .$dname;
								file_put_contents($pth3, $unencodedData);         
							//	$adcosts = $this->Advertisercost->find('all',array('conditions'=>array('Advertisercost.status'=>1),'order'=>array('Advertisercost.id'=>'ASC')));	

							if(!empty($totalFriend)){
								$adcosts = $this->Advertisercost->find('all',array('conditions'=>array('Advertisercost.status'=>1),'order'=>array('Advertisercost.id'=>'ASC')));
								$pay = $this->Advertisercost->query("SELECT cost from advertisercosts where potential_from <='".$totalFriend."' AND potential >= '".$totalFriend."'");
								$payMoney = $pay[0]['advertisercosts']['cost'];	
								$response = array('status'=>1,'paymoney'=>$payMoney,'potential'=>$totalFriend);
								echo json_encode($response);
								exit();
							} else {
								$response = array('status'=>0,'paymoney'=>'no money to pay','potential'=>$totalFriend);
								echo json_encode($response);		
								exit();
							}	
						} else{
								$response = array('status'=>(int)0);
								echo json_encode($response);
								exit();				
						} 
	}
	
    // http://dev414.trigma.us/onbeat/webservices/getZipCodeByLocation?post_code=121
	
		public function getZipCodeByLocation(){
					$zip = $_REQUEST['post_code'];
					$val = $this->getLnt($zip);
					if(!empty($val)){
						$lat = $val['lat'];	
						$long = $val['lng'];					
						$this->getNearZipCode($lat,$long);
						exit;
					} else  {
						$data = array('status'=>0,'msg'=>'Invalid Zipcode.');
						echo json_encode($data);		
						exit;					
					}
		}
	
    //	http://dev414.trigma.us/onbeat/webservices/userAds?user_id=121

	public function userAds($user_id = null){
			$this->loadModel('Advertisement');
			$this->loadModel('Share');
			$user_id = $_REQUEST['user_id'];
			$ads = $this->Advertisement->find('all',array('conditions'=>array('Advertisement.user_id'=>$user_id),'order'=>array('Advertisement.id'=>'desc')));
			//echo '<pre>';print_r($ads);die;
			$this->loadModel('User');
			$total=0;
			$uData = $this->User->findByid($user_id);
			if(!empty($uData)){
				$totalfriend = $uData['User']['fb_friend'];
				$posts = count($ads);				
				if($uData['User']['registertype']=='manual'){
					$upic = FULL_BASE_URL.$this->webroot.'files/profileimage/'.$uData['User']['profile_image'];
				} else {
					$upic  = $uData['User']['profile_image'];	
				}
			//	$upic = FULL_BASE_URL.$this->webroot.'files/profileimage/'.$uData['User']['profile_image'];	
				$data =  array('post_count'=>$posts,'user_pic'=>$upic,'first_name'=>$uData['User']['first_name'],'last_name'=>$uData['User']['last_name'],'gender'=>$uData['User']['gender'],'location'=>$uData['User']['location'],'email'=>$uData['User']['email'],'contact'=>$uData['User']['contact']);
				foreach($ads as $key=>$ad){
					  $advert = $this->Share->find('first',array('conditions'=>array('Share.post_id'=>$ad['Advertisement']['id']),'order'=>array('Share.id'=>'desc')));
					  $total = $total+$advert['Share']['earn'];
					  //echo $advert['Share']['earn'];die;
					  if(!empty($ad['Advertisement']['promo_code']))
					  {
						  $promo = $ad['Advertisement']['promo_code'];
					  }
					  else{
						  $promo = "";
					  }
					  if(!empty($ad['Advertisement']['phone']))
					  {
						  $phone = $ad['Advertisement']['phone'];
					  }
					  else{
						  $phone = "";
					  }
					  $data['advertisements'][] = array('id'=>$advert['Share']['post_id'],
									  'title' => $ad['Advertisement']['title'],
									  'location' => $ad['Advertisement']['location'],
									  'image'=> FULL_BASE_URL.$this->webroot.'files/screens/'.$ad['Advertisement']['image'],
									  'username' => $ad['User']['username'],
									  'profileimage' => $ad['User']['profile_image'],
									  'description' => $ad['Advertisement']['description'],
									  'post_code' => $ad['Advertisement']['post_code'],
									   'phone' => $phone,
									  'promo_code' => $promo,
									  'optional_postcode1' => $ad['Advertisement']['optional_postcode1'],
									  'optional_postcode2' => $ad['Advertisement']['optional_postcode2'],
									  'shared' => '1',
									  'earn' => $advert['Share']['earn']
									 );				
				}
				
				if(!empty($total)){
					$total=number_format($total,2);
					$data['totalEarn']= array('totalEarns'=> $total);
				} else {
					$data['totalEarn']= array('totalEarns'=>'0');	
				}	
				echo json_encode($data);
				$this->autoRender = false;
				exit();  
		    } else {
				$data = array('status'=>0,'msg'=>'Invalid User.');
				echo json_encode($data); exit;					
			}	
	}

//  http://dev414.trigma.us/onbeat/webservices/AdvertiserStatus?user_id=121&user_status=1
	
		public function AdvertiserStatus(){
		    $this->loadModel('User');
			$userId = $_REQUEST['user_id'];
			$status = $_REQUEST['user_status'];
			$user = $this->User->find('first',array('conditions'=>array('User.id'=>$userId)));
			if(!empty($user)){
				if($status=='1'){
						$this->User->query("Update  `users` set `user_status`='".$status."' where  `id`='".$userId."' ");
						$data = array('status'=>1,'msg'=>'Your Current Location is Active for post.');			
						echo json_encode($data); exit;
				} else {
						$this->User->query("Update  `users` set `user_status`='".$status."' where  `id`='".$userId."' ");
						$data = array('status'=>0,'msg'=>'Your Current Location is not  Active for post.');
						echo json_encode($data); exit;	
				} 
			} else {
						$data = array('status'=>0,'msg'=>'Invalid User.');
						echo json_encode($data); exit;					
			}
		}
		
	    public function sendPaypalDetails(){
			$userId = $_REQUEST['user_id'];
			$paypal_id = $_REQUEST['paypal_id'];
			if(!empty($paypal_id)){
				$userDetails = $this->User->find('first',array('conditions'=>array('User.id'=>$userId)));
				if(!empty($userDetails)){
					   $email = $userDetails['User']['email'];
					//	$ms="<p>Hello ,<br/>". @$this->request->data['User']['username']." <br/> You have been registered successfully  with Serv.<br /> ";
						$ms = "test only.";
						 $l = new CakeEmail();
						 $l->emailFormat('html')->template('send_payment', 'fancy')->subject('Thanks For Sending Payment Details')->viewVars(array('user_id'=>$userDetails['User']['id'],'email'=>$email,'payment_account'=>$paypal_id,'first_name'=>$userDetails['User']['first_name'],))->to('lavkush.ramtripathi@trigma.in')->from($email)->send($ms);
						$data = array('status'=>1,'msg'=>'Payment Details Send Admin.');
						echo json_encode($data); exit;							 
				} else {
							$data = array('status'=>0,'msg'=>'Invalid User.');
							echo json_encode($data); exit;					
				}	
		    } else {			
							$data = array('status'=>0,'msg'=>'Please Fill Payment Account..');
							echo json_encode($data); exit;				
			}
		}	
		
		
	public function getNearZipCode($lat,$long){	
			$lat1=$lat;
			$lng1=$long;	
			$this->loadModel('Outcode');
			$ZipCode =array();
			$range=3.10686*1609.344;
            $all=$this->Outcode->find('all');
			if($all)
			{
				$i=0;
				$bar_count=0;
				$curr=date('Y-m-d H:i');
				$ZipCode['status']='2';
				foreach($all as $single){
				$lat2=$single['Outcode']['latitude'];
				$lng2=$single['Outcode']['longitude'];						
				$earthRadius = 3958.75;
										$dLat = deg2rad($lat2-$lat1);
										$dLng = deg2rad($lng2-$lng1);
										$a = sin($dLat/2) * sin($dLat/2) +
										   cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
										   sin($dLng/2) * sin($dLng/2);
										$c = 2 * atan2(sqrt($a), sqrt(1-$a));
										$dist = $earthRadius * $c;
										// from miles
										$meterConversion = 1609;
										$geopointDistance = $dist * $meterConversion;										
										$get=$geopointDistance;
									   $ran =  3.10686;
					if(round($get * 0.000621371192,2)<= $ran){
												$ZipCode['ZipCode'][] = array('postcode'=>  $single['Outcode']['postcode'],
																		'distance'=> round($get * 0.000621371192,2)." Miles",
																/*	'eastings'=>	$single['Outcode']['eastings'],
																		'northings'=>$single['Outcode']['northings'],
																		'distance'=> round($get * 0.000621371192,2)." Miles",
																		'latitude'=>$single['Outcode']['latitude'],
																		'longitude'=>$single['Outcode']['longitude'],
																		'town'=>$single['Outcode']['town'],
																		'region'=>$single['Outcode']['region'],
																		'country'=> $single['Outcode']['country'],
																		'status'=>'Post Code found' */
																);
					$bar_count++;
					}
					$i++;
				}
				if($bar_count==0)
										{
											$ZipCode[]['status']='0';
											$ZipCode[]['msg']='There is no post code near to the given address';
										}
			} else {		
						$ZipCode[]['status']="There is no post code";
						echo json_encode($ZipCode);
						exit;
			}
			echo json_encode($ZipCode);
			exit;
			
	}
	
/********************************* End Webservices List  *********************************************/ 
      
      
}
