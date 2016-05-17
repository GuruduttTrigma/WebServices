<?php
#Project : onbeat (Stackdos)
class WebservicesController extends AppController  {
	public $uses = array('Advertisement','Advertisercost','Advertiserearn','PlanUser','User','Plan');
	public function beforeFilter() {
		parent::beforeFilter ();
		$this->Auth->allow(array('user_plans','friendAlgo','showAdsToFriends','getFriendsByZipcode','adsCost','adsCost2','adsEarn','add','adsList','adsDetails','mobileuserlogin','userAds','adsshare','nearby','getNearUser','nearbytotal','AdvertiserStatus','sendPaypalDetails','getZipCodeByLocation','getTotalFriends','getLatlng','checkPotential','purchase_plans','facebook_post','get_user_by_post_code','send_message','remove_user_token','test','sharing_price','message','total_earn_price_from_sharing','affiliate_code'));					
	}
	
	// http://pay-us.co/payusadmin/webservices/getLatlng?location=273212	
	/* 	public function getLatlng(){
		$location = $_REQUEST['location'];
		if(!empty($location)){
			$prepAddr = str_replace(' ','+',$location);

			$geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');

			$output= json_decode($geocode);

			$lat = $output->results[0]->geometry->location->lat;
			$long = $output->results[0]->geometry->location->lng;
			echo $lat.'--'.$long;
			exit;
		} 		
	} */
	
	// http://pay-us.co/payusadmin/webservices/adsCost2
	public function adsCost2()  { 
		$this->loadModel('Advertisercost');
		$getcost = $this->Advertisercost->find('all',array('conditions'=>array('Advertisercost.status'=>1,'Advertisercost.potential <'=>'10000'),'fields'=>array('id','cost','potential_from','potential as potential_to','status')));
		$finalArr = array();
		if(!empty($getcost)){
			foreach($getcost as $cost){
				$finalArr[] = $cost['Advertisercost'];
			}
			$response = array('status'=>1,'msg'=>'data found','data'=>$finalArr);
		} else {
			$response = array('status'=>0,'msg'=>'data not found');
		}
		echo json_encode($response);
		exit;
	} 
		
	// http://pay-us.co/payusadmin/webservices/adsCost?user_id=10&post_code=g64
	public function adsCost()  { 
		$this->loadModel('Advertisercost');
		$this->loadModel('User');
		$userId = $_REQUEST['user_id'];
		$potential = 0;
		$potential_from = '1';	
		$potential_to = '199999';		
		$zip = $_REQUEST['post_code'];
		$getAllUser = $this->User->find('all', array( 
			'conditions' => array('User.post_code'=>$zip,'not' => array('User.id' => $userId))
		));	
		if(!empty($getAllUser)){
			foreach($getAllUser as $userList) {
				$finalArray[$userList['User']['id']] = $userList['User']['fb_friend'];
			}
			$totalFriend  = $finalArray;
			$friendPost = $this->showAdsToFriends($totalFriend,$potential_from,$potential_to);
			if(!empty($friendPost)){
				foreach($friendPost as $friendcount){
					$potential += $friendcount;
				}
				$getTotalPotential = (int)$potential;		
				/*if($getTotalPotential<=500){
					$totalPotential = '501';
				} else {
					$totalPotential =$getTotalPotential;
				} */
				
				$getcost = $this->Advertisercost->query("SELECT id,cost,potential_from,potential as potential_to  FROM `advertisercosts` WHERE `potential` <=".$getTotalPotential." OR `potential_from` <=".$getTotalPotential."");	
				
				//$getcost = $this->Advertisercost->find('all',array('conditions'=>array('OR'=>array('Advertisercost.potential <='=>'"'.$getTotalPotential.'"','Advertisercost.potential_from <='=>'"'.$getTotalPotential.'"'),'Advertisercost.status'=>1),'fields'=>array('id','cost','potential_from','potential as potential_to','status')));
				
				$finalArr = array();
				if(!empty($getcost)){
					foreach($getcost as $cost){
						$finalArr[] = $cost['advertisercosts'];
					}
					$response = array('status'=>1,'msg'=>'data found','data'=>$finalArr);
				} 				
			} else {
				$response = array('status'=>(int)0,'msg'=>'Unable to post advertisement as no friends found in this area');
			}
		} else {
			$response = array('status'=>0,'msg'=>'data not found');
		}	
		echo json_encode($response);
		exit; 
	}	
	
	// http://pay-us.co/payusadmin/webservices/adsEarn	
	public function adsEarn()  { 
		$this->loadModel('Advertiserearn');
		$getcost = $this->Advertiserearn->find('all',array('conditons'=>array('Advertiserearn.status'=>1)));
		$finalArr = array();
		if(!empty($getcost)){
			foreach($getcost as $cost){
				$finalArr[] = $cost['Advertiserearn'];
			}
			$response = array('status'=>1,'msg'=>'data found','data'=>$finalArr);
		} else {
			$response = array('status'=>0,'msg'=>'data not found');
		}
		echo json_encode($response);
		exit;
	}	
	
	// http://pay-us.co/payusadmin/webservices/getFriendsByZipcode?zip=160101&fb_id=1546421068955892
	public function getFriendsByZipcode(){
		$zipcode = $_REQUEST['zip'];
		$fb_id = $_REQUEST['fb_id'];
		$latLong = $this->getLnt($zipcode);
		if(!empty($latLong)){
			$lat= $latLong['lat'];	
			$long = $latLong['lng'];	
			$lat1=$lat;
			$lng1=$long;
			$range=500*1609.344;
			$all = $this->User->find('all', array(
				'conditions' => array(
					'NOT' => array(
						'User.fb_id' =>$fb_id
					)
				),
				'fields'=>array('fb_id','first_name','last_name','lat','long','fb_friend','status')
			));
			if($all) {
				$i=0;
				$u_count=0;
				$finalArray = array();
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
					$meterConversion = 1609;
					$geopointDistance = $dist * $meterConversion;										
					$get=$geopointDistance;
					$ran =  500;
					if(round($get * 0.000621371192,2)<= $ran){
												$finalArray[] = $single['User']['fb_friend'];
												$total += $single['User']['fb_friend'];
					}	
					$i++;
				}
				
				//echo "<pre>"; print_r($finalArray);
				//$response = array('status'=>1,'msg'=>'data found','total'=>$total,'data'=>$finalArray);
				echo json_encode($response);
				exit;
			}			
		} else {
			$response = array('status'=>0,'msg'=>'Invalid zip.');
		}
		echo json_encode($response);
		exit;
	}

	// http://pay-us.co/payusadmin/webservices/showAdsToFriends	
	 public function showAdsToFriends($totalFriend,$potential_from,$potential_to){
		$potential_from = $potential_from;
		$potential_to = $potential_to;
		$potenial=0;
		$users= $totalFriend;
		$countusers=count($users);
		foreach($users as $val){
			$potenial=$potenial+$val;
		}
		$custom1=array();
		$num = count($users);   
		$total = pow(2, $num);
		$test =array();
		for ($i = 0; $i < $total; $i++)  {     
			$k=0;
			foreach($users as $key=>$val){
				if (pow(2, $k) & $i) 
				$a[$key]= $val;  
				$k++;
			} 
			if(!empty($a)){
				$arraysum=array_sum($a);
				$pack=($arraysum/1000);
				array_push($custom1,$arraysum);
				if($pack<.50)
				{
					array_push($test,$pack);
				}
			}
			unset($a);
		}
		$final1=array();
		$final=array();
		$custom=array('1'=>500,'501'=>599,'600'=>'649','650'=>699,'700'=>749,'750'=>799,'800'=>849);
		$number=count($custom1);
		$ii = 1;
		for($i=0; $i<=$number;$i++)  {
			if($custom1[$i]>=1 && $custom1[$i]<=$potential_to) {
				$ii = $ii+1;
				$abc=$custom1[$i];
				array_push($final,$abc);
			}
		}
		if ($ii ==1) {
			for($j=0; $j<=$number;$j++)
			{
				if($custom1[$j]>=$potential_to )
				{
				 $def=$custom1[$j];
				array_push($final1,$def);
				}
			}
		}
		if($ii!=1){
			$big=max($final);
		} else {
			$big=min($final1);
		}
		$value=($big)/1000;
		$max=$value;
		$num = count($users);   
		$total = pow(2, $num);
		$test =array();
		for ($i = 0; $i < $total; $i++) 
		{     
			$k=0;
			foreach($users as $key=>$val){
				if (pow(2, $k) & $i) 
				$a[$key]= $val;  
				$k++;
			} 
			if(!empty($a))
			{
				$arraysum=array_sum($a);
				$pack=($arraysum/1000);
				if ($pack == $max) {
					$c=count($a);
					return $a;
					exit;
				}
			}
			unset($a);
		}		
	}
	
	// http://pay-us.co/payusadmin/webservices/getTotalFriends?lat=19.727456&long=72.846537
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
	
	/*	public function getNearUser($zip_code,$userId){
		$this->loadModel('User');
		$user_id = $userId;
		$all = $this->User->find('all', array( 
			'conditions' => array('not' => array('User.id' => $user_id))
		));	

		} */
	
	// http://pay-us.co/payusadmin/webservices/nearby?lat=19.727456&long=72.846537	
	public function nearbytotal($lat,$long,$userId){	
		//  configure::write('debug',2);
		$this->loadModel('User');
		$user_id = $userId;
		$lat1=$lat;
		$lng1=$long;
		$UserCount =array();
		$range=100*1609.344;
		$all = $this->User->find('all', array( 
			'conditions' => array('not' => array('User.id' => $user_id))
		));	
		if($all) {
			$i=0;
			$u_count=0;
			$curr=date('Y-m-d H:i');
			foreach($all as $single){
				$lat2  = $single['User']['lat'];
				$lng2 = $single['User']['long'];	
				$earthRadius = 3958.75;
				$dLat = deg2rad($lat2-$lat1);
				$dLng = deg2rad($lng2-$lng1);
				$a = sin($dLat/2) * sin($dLat/2) +
				cos(deg2rad($lat1)) * cos(deg2rad($lat1)) *
				sin($dLng/2) * sin($dLng/2);
				$c = 2 * atan2(sqrt($a), sqrt(1-$a));
				$dist = $earthRadius * $c;
				// from miles
				$meterConversion = 1609;
				$geopointDistance = $dist * $meterConversion;										
				$get=$geopointDistance;
				$ran =  100;
				if(round($get * 0.000621371192,2)<= $ran){
											// $total += $single['User']['fb_friend'];
											$finalArray[$single['User']['id']] = $single['User']['fb_friend'];
				}	
				$i++;
			}
			if(!empty($finalArray)){
				return $finalArray;
			} else {
				return '';
			}
		}
	}	

	// http://pay-us.co/payusadmin/webservices/adsshare?shared_userid=1&post_id=7
	public function adsshare(){
	   $this->loadModel('EarnPrice');
	   $this->loadModel('Share');
	   $this->loadModel('Advertisement');
	   $earn_price= $this->EarnPrice->find('first');	
	 //  echo "<pre>";print_r($earn_price);die;
	   $shared_id	= $_REQUEST['shared_userid'];
	   $postId 		= $_REQUEST['post_id'];
	   /* -------------------- Check total share Start (10/12/2015) --------------------*/
	   $user_info	=	$this->User->find (
			'first',array (
				'conditions'=> array (
					'User.id'=> $shared_id
				),
				'contain'	=> array (
					'PlanUser'	=>'Plan'
				),
				'fields'=>array('User.id','User.email')
			)
		);
		//pr ($user_info);
		$total_share	=	array ();
		foreach ($user_info['PlanUser'] as $no_of_shares)  {
			if ($no_of_shares['Plan']['status'] == 1 and $no_of_shares['post_id'] == $postId)  {
				array_push ($total_share,$no_of_shares['Plan']['no_of_shares']);
			}                  
		}
		
		$total_shares	=	array_sum ($total_share);
		$total_share_by_user	=	$this->Share->find ('count',array('conditions'=>array('Share.user_id'=>$shared_id,'Share.post_id'=>$postId)));
		$remaining_share	=	$total_shares - $total_share_by_user;
		//echo $total_share_by_user.'<br>';
		//echo $total_shares.'<br>';die;
		if ($total_shares != 0 and $total_share_by_user !=0) {
			if ($total_shares <= $total_share_by_user)  {
				$response = array('status'=>0,'msg'=>'Post could not be shared. post have no remaining share.','remaining_share'=>$remaining_share);
				echo json_encode($response);	exit;
			}
		}
		
	   /* ------------------- Check total share End (10/12/2015) ---------------------*/
		if($shared_id!='' && $postId!='')  {
			$userDetails = $this->User->find('first',array('conditions'=>array('User.id'=>$shared_id)));
			$totalFriends = $userDetails['User']['fb_friend'];
			if($totalFriends>0){
				//$totalEarn = $this->Advertiserearn->query("SELECT earn_per_post from advertiserearns where no_of_friends_fr <='".$totalFriends."' AND 	no_of_friends_to >= '".$totalFriends."'");
				//$this->request->data['Share']['earn'] =  $totalEarn[0]['advertiserearns']['earn_per_post'];	
				// if ($totalFriends <200) {
					// $earn = 0.0;
				// }  else  {
					//$earn = 0.10;
					// $earn = $earn_price['EarnPrice']['price'];
				// }
				
				$earn = $earn_price['EarnPrice']['price'];
				
				$this->request->data['Share']['earn'] 	  =  $earn;	
				$this->request->data['Share']['user_id']  = $shared_id;
				$this->request->data['Share']['post_id']   = $postId;
				$this->request->data['Share']['status']     = 1;
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
				echo json_encode($response);exit;								
			}	else {
				$response = array('status'=>0,'msg'=>'Post could not be shared. you have no any fb friedns right now.');
				echo json_encode($response);	exit;		
			}
		} else {
				$response = array('status'=>0,'msg'=>'Please Provide user id And post id.');
				echo json_encode($response);	exit;				
		}	
	}

	// http://pay-us.co/payusadmin/webservices/adsList?user_id=1&post_code=G64
	public function adsList()  {
		$this->loadModel('Share');
		$this->loadModel('User');
		$this->loadModel('PostShow');
		$user_id 		= $_REQUEST['user_id'];
		$post_code 	= $_REQUEST['post_code'];
		
		$post_code_exists		=	$this->Advertisement->find('all',array('conditions'=>array('Advertisement.status'=>1),'order'=>array('Advertisement.id'=>'desc'),'contain'=>array(),'fields'=>array('Advertisement.id','Advertisement.post_code')));
		// echo "working";
		// echo "<pre>";print_r ($post_code_exists);die;
		foreach ($post_code_exists as $info)  {
			$post_code_exist = explode(',',$info['Advertisement']['post_code']);
			//echo "<pre>";print_r($post_code_exist);die;
			//echo $info['Advertisement']['post_code'];die;
			if (in_array ($post_code,$post_code_exist))  {
				//echo "<pre>";print_r($post_code_exist);die;
				$ads = $this->Advertisement->find('all',array('conditions'=>array('Advertisement.id'=>$info['Advertisement']['id'])));			
				//echo "<pre>";print_r ($ads);die;
				if(!empty($ads)){
					$userAds = $this->User->find('first',array('conditions'=>array('User.id'=>$user_id)));
				///	$response = array('status'=>1);
					foreach($ads as $ad){
						//$getMyPost=$this->PostShow->find('first',array('conditions'=>array('AND'=>array('PostShow.user_id'=>$user_id,'PostShow.post_id' => $ad['Advertisement']['id']))));
						//if(!empty($getMyPost)){
							$getShare=$this->Share->find('first',array('conditions'=>array('AND'=>array('Share.user_id'=>$user_id,'Share.post_id' => $ad['Advertisement']['id']))));
								if(empty($getShare))
							{			
									if(isset($ad['Advertisement']['promo_code']) && $ad['Advertisement']['promo_code']!=''){
										$promo_code = $ad['Advertisement']['promo_code'];
									} else {
										$promo_code = "PAYUS";
									}										
										$userDetails = $this->User->find('first',array('conditions'=>array('User.id'=>$user_id)));
										$totalFriends = $userDetails['User']['fb_friend'];
										$totalEarn = $this->Advertiserearn->query("SELECT earn_per_post from advertiserearns where no_of_friends_fr <='".$totalFriends."' AND 	no_of_friends_to >= '".$totalFriends."'");
										//echo "<pre>";print_r($totalEarn);die;
										if (empty($totalEarn))  {
											$earn =  '';
										}  else  {
											$earn =  $totalEarn[0]['advertiserearns']['earn_per_post'];	
										}
										
										
										if ($userDetails['User']['registertype'] == 'facebook')  {
											$profile_image	=	$userDetails['User']['profile_image'];
										}  else  {
											$profile_image	=	FULL_BASE_URL.$this->webroot.'files' . DS . 'profileimage'. DS .$userDetails['User']['profile_image'];
										}
											$response['adsList'][] = array('id'=>$ad['Advertisement']['id'],
											  'title' => $ad['Advertisement']['title'],
											  'profile_image' => $profile_image,
											  'location' => $ad['Advertisement']['location'],
											  'image'=> FULL_BASE_URL.$this->webroot.'files/screens/'.$ad['Advertisement']['image'],
											  'description' => $ad['Advertisement']['description'],
											  'promo_code' => $promo_code,
											  'contact' => $ad['Advertisement']['phone'],
											  'email' => $ad['Advertisement']['email'],
											  'friends' => $totalFriends,
											  'earn' => $earn
											 );
							}
						}
					//}
							
				} 
			}			
		}
		if(!empty($response)){
			$response['status'] = 1;
		} else {
			$response = array('status'=>0,'msg'=>'Advertisement not available');
		}
		echo json_encode($response);
		exit;	
	}
	
	public function adsDetails($ad_id=null)  {
		$adsId = $_REQUEST['ad_id'];
		$ads = $this->Advertisement->find('first',array('conditions' =>array('Advertisement.id'=>$adsId)));
		// echo "<pre>"; print_r($ads); exit;
			if(isset($ads['Advertisement']['promo_code']) && $ads['Advertisement']['promo_code']!=''){
				$promo_code = $ads['Advertisement']['promo_code'];
			} else {
				$promo_code = "PAYUS";
			}			
			if(isset($ads['Advertisement']['email']) && $ads['Advertisement']['email']!=''){
				$contacInfo = $ads['Advertisement']['email'];
			} else {
				$contacInfo = "";
			}				
		$data = array('id' =>$ads['Advertisement']['id'],
							 'title' =>$ads['Advertisement']['title'],
							 'promo_code'=>$promo_code,
							 'email'=>$contacInfo,
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

	// http://pay-us.co/payusadmin/webservices/checkPotential?user_id=1&potential_from=1&potential_to=500&post_code=g64	
	public function checkPotential()  {
		$this->loadModel('User');
		$this->loadModel('Advertisercost');
		$userId = $_REQUEST['user_id'];
		$potential_from = $_REQUEST['potential_from'];	
		$potential_to = $_REQUEST['potential_to'];		
		$zip = $_REQUEST['post_code'];
		$getAllUser = $this->User->find('all', array( 
			'conditions' => array('User.post_code'=>$zip,'not' => array('User.id' => $userId))
		));	
		if(!empty($getAllUser)){
			foreach($getAllUser as $userList) {
				$finalArray[$userList['User']['id']] = $userList['User']['fb_friend'];
			}
			$totalFriend  = $finalArray;
			$friendPost = $this->showAdsToFriends($totalFriend,$potential_from,$potential_to);
			if(!empty($friendPost)){
				foreach($friendPost as $friendcount){
					$potential += $friendcount;
				}
				$getTotalPotential = $potential;				
				$pay = $this->Advertisercost->query("SELECT cost from advertisercosts where potential_from <='".$getTotalPotential."' AND potential >= '".$getTotalPotential."'");
				$payMoney = $pay[0]['advertisercosts']['cost'];	
				$response = array('status'=>(int)1,'paymoney'=>$payMoney,'potential'=>$getTotalPotential);
			} else {
				$response = array('status'=>(int)0,'msg'=>'Unable to post advertisement as no friends found in this area');
			}
		} else {
			$response = array('status'=>(int)0,'msg'=>'Unable to post advertisement as no friends found in this area');
		}
		echo json_encode($response);
		exit;
	}	
	
	//   http://pay-us.co/payusadmin/webservices/add?user_id=21&potential_from=0&potential_to=500&title=test&email=test@gmail.com&promo_code=123&post_code=160071&optional_postcode1=160075&optional_postcode2=521362&description=test only.&image=img.png&plan_id=1&transaction_id=2144234&affiliate_code=45664646
	public function add()  {
		//$posts	=	$this->User->find ('list',array('conditions'=>array('User.post_code'=>$_REQUEST['post_code'])));
		//echo "<pre>";print_r ($posts);die;
		$potential = 0;
		$this->loadModel('PostShow');
		$this->loadModel('Advertiserearn');
		$this->autoRender = false;  		
		$potential_from 	= $_REQUEST['potential_from'];	
		$plan	=	$this->Plan->find('first',array('conditions'=>array('Plan.id'=>$_REQUEST['plan_id'])));
		$planUser	=	$this->PlanUser->find('first',array('conditions'=>array('PlanUser.plan_id'=>$_REQUEST['plan_id']),'order'=>array('PlanUser.id desc')));
		
		$potential_to	=	$plan['Plan']['potential'];
		$payMoney	=	$plan['Plan']['cost'];
		$transaction_id	=	$planUser['PlanUser']['transaction_id'];
		$userId 				= $_REQUEST['user_id'];
		$zip 					= $_REQUEST['post_code'];
		$plan_id 			= $_REQUEST['plan_id'];
		//echo $potential_to;die;
		//$this->send_message ($zip);
		if ($userId == '' or $zip == '' or $transaction_id= '') {
			$response = array('status'=>0,'msg'=>'Wrong resquest.');
			echo json_encode($response);exit();	
		}
		
		$this->request->data['Advertisement']['status'] 			= '1';
		$this->request->data['Advertisement']['plan_id'] 		= $plan_id;
		$this->request->data['Advertisement']['transaction_id'] 		= $transaction_id;
		$this->request->data['Advertisement']['user_id'] 		= $_REQUEST['user_id'];
		$this->request->data['Advertisement']['title'] 				= $_REQUEST['title'];		
		$this->request->data['Advertisement']['email'] 			= $_REQUEST['email'];				
		$this->request->data['Advertisement']['description'] = $_REQUEST['description'];	
		$this->request->data['Advertisement']['image'] 		= $_REQUEST['image'];			
		$this->request->data['Advertisement']['potential'] 	= $potential_to;			
		$this->request->data['Advertisement']['payMoney'] 	= $payMoney;			
		
	
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
		
		
		// $getAllUser = $this->User->find(
			// 'all',array ( 
				// 'conditions' => array (
					// 'User.post_code'	=> $zip,
					// 'not' 						=> array (
						// 'User.id' 			=> $userId
					// ),					
				// ),
				// 'order' =>array('User.id'),
				// 'contain' =>array(),
				// 'fields' =>array('id','fb_id','post_code','fb_friend'),
			// )
		// );
		//echo "<pre>";print_r($getAllUser);die;
		// if (!empty($getAllUser))  {
			// foreach($getAllUser as $userList) {
				// $finalArray[$userList['User']['id']] = $userList['User']['fb_friend'];
			// }
			// $totalFriend  = $finalArray;			
			//$totalFriend = $this->nearbytotal($val['lat'],$val['lng'],$userId);
			// $friendPost = $this->showAdsToFriends($totalFriend,$potential_from,$potential_to);
			//echo "<pre>";print_r($friendPost);die;
			// if (!empty($friendPost))  {			
				// foreach($friendPost as $friendcount){
					// $potential += $friendcount;
				// }  
				//$getTotalPotential = $potential;				
				$this->Advertisement->create();
				if ($this->Advertisement->save($this->request->data)) {
					$id			= $this->Advertisement->getLastInsertId();	
					$dname	= time().$id."image.png";
					$this->Advertisement->saveField('image',$dname);                      
					@$_REQUEST['image']	= str_replace('data:image/png;base64,', '', $_REQUEST['image']);
					$_REQUEST['image'] 	= str_replace(' ', '+',$_REQUEST['image']);
					$unencodedData			= base64_decode($_REQUEST['image']);
					$pth3 							= WWW_ROOT.'files' . DS . 'screens'. DS .$dname;
					$pth4 							= WWW_ROOT.'files' . DS . 'smallimages'. DS .$dname;
					file_put_contents($pth3, $unencodedData);         
					
					//$pay = $this->Advertisercost->query("SELECT cost from advertisercosts where potential_from <='".$getTotalPotential."' AND potential >= '".$getTotalPotential."'");
					//$payMoney = $pay[0]['advertisercosts']['cost'];			
					//$this->Advertisement->saveField('total_earn',$payMoney);  
					//$this->send_message ($zip);
					//	$this->Advertisement->saveField('potential',$getTotalPotential);  
					
					/* --------------------------  User Plan Start ------------------------------------------------  */
						$planUserInfo	=	$this->PlanUser->find(
							'first',array ( 
								'conditions' => array (
									'PlanUser.user_id'	=> $userId,									
									'PlanUser.plan_id'	=> $plan_id,									
									'PlanUser.post_created'	=> 0,									
								)
							)
						);
						if (empty($planUserInfo))  {
							$response = array('status'=>0,'message'=>'Please select correct plan');
							echo json_encode($response);exit();
						}		
						
						$this->PlanUser->updateAll(array('PlanUser.post_id'=>'"'.$id.'"','PlanUser.post_created'=>1),array('PlanUser.id'=>$planUserInfo['PlanUser']['id']));
												
					/* --------------------------  User Plan  End ------------------------------------------------  */
					
					$posts	=	$this->User->find ('list',array('conditions'=>array('User.post_code'=>$_REQUEST['post_code'],'User.id Not'=>$userId)));
					if (!empty($posts))  {
						foreach($posts as $key=>$toshowpost)  {
							$this->request->data['PostShow']['user_id'] = $key;
							$this->request->data['PostShow']['post_id'] = $id;
							$this->request->data['PostShow']['status'] = 1;
							$this->PostShow->create();
							$this->PostShow->save($this->request->data);
						}			
					}
					
					// if(!empty($friendPost))  {
						// $this->loadModel('PostShow');
						// foreach($friendPost as $key=>$toshowpost)  {
							// $this->request->data['PostShow']['user_id'] = $key;
							// $this->request->data['PostShow']['post_id'] = $id;
							// $this->request->data['PostShow']['status'] = 1;
							// $this->PostShow->create();
							// $this->PostShow->save($this->request->data);
						// }			
					// }
					//$this->Advertisement->query("Update  `advertisements` set `total_earn`='".$payMoney."',`potential`='".$getTotalPotential."' where  `id`='".$id."' ");
					
					$response = array('status'=>(int)4,'paymoney'=>$payMoney,'potential'=>$potential_to);
					echo json_encode($response);
					$this->send_message ($zip);
					exit();
				} else{
					$response = array('status'=>(int)5,'msg'=>'Advertisement could not be post');
					echo json_encode($response);
					exit();				
				} 
			// }  else {
				// $response = array('status'=>(int)5,'msg'=>'Unable to post advertisement as no friends found in this area.');
				// echo json_encode($response);		
				// exit();							
			// }
		// } else {
				// $response = array('status'=>(int)5,'msg'=>'Unable to post advertisement as no friends found in this area..');
				// echo json_encode($response);		
				// exit();							
		// } 			
	}

/*
	public function add(){
			$potential = 0;
			$this->loadModel('Advertiserearn');
			$this->autoRender = false;  
			$this->request->data['Advertisement']['status'] = '1';
			$this->request->data['Advertisement']['user_id'] = $_REQUEST['user_id'];
			$this->request->data['Advertisement']['title'] = $_REQUEST['title'];		
			$this->request->data['Advertisement']['email'] = $_REQUEST['email'];				
			$this->request->data['Advertisement']['description'] = $_REQUEST['description'];	
			$this->request->data['Advertisement']['image'] = $_REQUEST['image'];	
			$userId = $_REQUEST['user_id'];
			$potential_from = $_REQUEST['potential_from'];	
			$potential_to = $_REQUEST['potential_to'];	
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
				$totalFriend = $this->nearbytotal($val['lat'],$val['lng'],$userId);
				$friendPost = $this->showAdsToFriends($totalFriend,$potential_from,$potential_to);
			//	$totalPotential = $total; 
				if(!empty($friendPost)){			
					foreach($friendPost as $friendcount){
						$potential += $friendcount;
					}
					$getTotalPotential = $potential;				
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
						$pay = $this->Advertisercost->query("SELECT cost from advertisercosts where potential_from <='".$getTotalPotential."' AND potential >= '".$getTotalPotential."'");
						$payMoney = $pay[0]['advertisercosts']['cost'];			
						$this->Advertisement->saveField('total_earn',$payMoney);  
					//	$this->Advertisement->saveField('potential',$getTotalPotential);  
						if(!empty($friendPost)){
							$this->loadModel('PostShow');
							foreach($friendPost as $key=>$toshowpost){
								$this->request->data['PostShow']['user_id'] = $key;
								$this->request->data['PostShow']['post_id'] = $id;
								$this->request->data['PostShow']['status'] = 1;
								$this->PostShow->create();
								$this->PostShow->save($this->request->data);
							}			
						}
						$this->Advertisement->query("Update  `advertisements` set `total_earn`='".$payMoney."',`potential`='".$getTotalPotential."' where  `id`='".$id."' ");
						$response = array('status'=>1,'paymoney'=>$payMoney,'potential'=>$getTotalPotential);
						echo json_encode($response);
						exit();
					} else{
						$response = array('status'=>(int)0,'msg'=>'Advertisement could not be post');
						echo json_encode($response);
						exit();				
					} 
				}  else {
					$response = array('status'=>0,'msg'=>'Unable to post advertisement as no friends found in this area.');
					echo json_encode($response);		
					exit();							
				}
			} else {
					$response = array('status'=>0,'msg'=>'Invalid post code.');
					echo json_encode($response);		
					exit();							
			} 			
	}

*/
	
    // http://pay-us.co/payusadmin/webservices/getZipCodeByLocation?post_code=121	
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
	
    //	http://pay-us.co/payusadmin/webservices/userAds?user_id=121
	public function userAds($user_id = null){
		$this->loadModel('Advertisement');
		$this->loadModel('Share');
		$user_id = $_REQUEST['user_id'];
		$ads = $this->Advertisement->find('all',array('conditions'=>array('Advertisement.user_id'=>$user_id),'order'=>array('Advertisement.id'=>'desc')));
		//echo '<pre>';print_r($ads);die;
		$this->loadModel('User');
		$total=0;
		$uData = $this->User->findByid($user_id);
		//	echo '<pre>';print_r($uData);die;
		if(!empty($uData)){
			$totalfriend = $uData['User']['fb_friend'];
			$posts = count($ads);				
			if($uData['User']['registertype']=='manual'){
				$upic = FULL_BASE_URL.$this->webroot.'files/profileimage/'.$uData['User']['profile_image'];
			} else {
				$upic  = $uData['User']['profile_image'];	
			}
			if(isset($uData['User']['post_code']) && $uData['User']['post_code']!=''){
				$postCode = $uData['User']['post_code'];
			} else {
				$postCode = '';
			}
			if(!empty($uData['Share'])){
				foreach($uData['Share'] as $key=>$share){
					$total = $total+$share['earn'];
				}
				$totalShare = $total;
			}				
		//	$upic = FULL_BASE_URL.$this->webroot.'files/profileimage/'.$uData['User']['profile_image'];	
			$data =  array('post_count'=>$posts,'user_pic'=>$upic,'first_name'=>$uData['User']['first_name'],'last_name'=>$uData['User']['last_name'],'gender'=>$uData['User']['gender'],'location'=>$uData['User']['location'],'email'=>$uData['User']['email'],'contact'=>$uData['User']['contact'],'friends'=>$uData['User']['fb_friend'],'post_code'=>$postCode);
			foreach($ads as $key=>$ad){
				  // echo '<pre>';print_r($ad['Share']);die;
				  
				  $advert = $this->Share->find('first',array('conditions'=>array('Share.post_id'=>$ad['Advertisement']['id']),'order'=>array('Share.id'=>'desc')));
				//  $total = $total+$advert['Share']['earn'];
				  //echo $advert['Share']['earn'];die;
				  if(!empty($ad['Advertisement']['promo_code']))
				  {
					  $promo = $ad['Advertisement']['promo_code'];
				  }
				  else{
					  $promo = "PAYUS";
				  }
				  if(!empty($ad['Advertisement']['phone']))
				  {
					  $phone = $ad['Advertisement']['phone'];
				  }
				  else{
					  $phone = "";
				  }
				  $data['advertisements'][] = array('id'=>$ad['Advertisement']['id'],
								  'title' => $ad['Advertisement']['title'],
								  'location' => $ad['Advertisement']['location'],
								  'image'=> FULL_BASE_URL.$this->webroot.'files/screens/'.$ad['Advertisement']['image'],
								  'username' => $ad['User']['username'],
								  'profileimage' => $ad['User']['profile_image'],
								  'description' => $ad['Advertisement']['description'],
								  'post_code' => $ad['Advertisement']['post_code'],
								  'phone' => $phone,
								  'email' => $ad['Advertisement']['email'],
								  'promo_code' => $promo,
								  'optional_postcode1' => $ad['Advertisement']['optional_postcode1'],
								  'optional_postcode2' => $ad['Advertisement']['optional_postcode2'],
								  'shared' => '1',
								  'earn' => isset($advert['Share']['earn']) ? $advert['Share']['earn'] : ''
								 );				
			}
			//echo "<pre>";print_r($data);die;
			if(!empty($totalShare)){
				$total=number_format($totalShare,2);
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

	//  http://pay-us.co/payusadmin/webservices/AdvertiserStatus?user_id=121&user_status=1	
	public function AdvertiserStatus()  {
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
	
	// http://pay-us.co/payusadmin/webservices/sendPaypalDetails?user_id=22&paypal_id=123456789		
	public function sendPaypalDetails()  {
		$userId = $_REQUEST['user_id'];
		$paypal_id = $_REQUEST['paypal_id'];
		if(!empty($paypal_id)){
			$userDetails = $this->User->find('first',array('conditions'=>array('User.id'=>$userId)));
			if(!empty($userDetails)){
			   $email = $userDetails['User']['email'];
				//	$ms="<p>Hello ,<br/>". @$this->request->data['User']['username']." <br/> You have been registered successfully  with Serv.<br /> ";
				$ms = "test only.";
				 $l = new CakeEmail();
				 $l->emailFormat('html')->template('send_payment', 'fancy')->subject('Thanks For Sending Payment Details')->viewVars(array('user_id'=>$userDetails['User']['id'],'email'=>$email,'payment_account'=>$paypal_id,'first_name'=>$userDetails['User']['first_name'],))->to('frankie@onbeat.co.uk')->cc('puneesh.goyal@trigma.com')->from($email)->send($ms);
				$data = array('status'=>1,'msg'=>'Paypal detail sent.');
				echo json_encode($data); exit;							 
			} else {
				$data = array('status'=>0,'msg'=>'Invalid User.');
				echo json_encode($data); exit;					
			}	
		} else {			
			$data = array('status'=>0,'msg'=>'Please enter Paypal Id.');
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
	
	//http://pay-us.co/payusadmin/webservices/user_plans?user_id=22
	function user_plans () {
		$planUser	=	$this->PlanUser->find(
			'all',array(
				'conditions'	=> array(
					'PlanUser.user_id'			=> $_REQUEST['user_id'],
					'PlanUser.post_created'	=> 0
				)
			)
		);
		$response	=	array ('status'=>1,'message'=>'success');
		foreach ($planUser as $info)  {
			$response['data'][]	= array(
				'plan_id'  => $info['PlanUser']['plan_id'],				
			);	
		}
		
		if (empty($planUser))  {
			$response	=	array ('status'=>0,'message'=>'success');
			echo json_encode($response);exit;	
		}
		echo json_encode($response);exit;	
	}
	
	//http://pay-us.co/payusadmin/webservices/purchase_plans?user_id=22&plan_id=2&transaction_id=4545
	function purchase_plans () {
		
		$planUser['PlanUser']['user_id'] 				= $_REQUEST['user_id'];
		$planUser['PlanUser']['plan_id']				= $_REQUEST['plan_id'];
		$planUser['PlanUser']['transaction_id']	= $_REQUEST['transaction_id'];
		$planUser['PlanUser']['status'] 	= 1;
		$planUser['PlanUser']['post_created'] 	= 0;
		$planUser['PlanUser']['date'] 		= date('Y-m-d H:i');
		//echo "<pre>";print_r ($planUser);
		$this->PlanUser->create();
		$this->PlanUser->save($planUser);
		
		$response	=	array ('status'=>1,'message'=>'success');
		echo json_encode($response);exit;	
	}
	
	//http://pay-us.co/payusadmin/webservices/facebook_post?
	function facebook_post ()  {
		$msg = "testmsg";
		$title = "testt";
		$uri = "http://somesite.com";
		$desc = "testd";
		$pic = "http://static.adzerk.net/Advertisers/d18eea9d28f3490b8dcbfa9e38f8336e.jpg";
		$action_name = 'Register Now';
		$action_link = '';
		$attachment =  array(
		'access_token' => $access_token,
		'message' => $msg,
		'name' => $title,
		'link' => $uri,
		'description' => $desc,
		'picture'=>$pic,
		'actions' => json_encode(array('name' => $action_name,'link' => $action_link))
		);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,'https://graph.facebook.com/me/feed');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $attachment);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  //to suppress the curl output
		$result = curl_exec($ch);
		curl_close ($ch);
		die('Done.');
	}
	
	//http://pay-us.co/payusadmin/webservices/get_user_by_post_code?post_code=145
	function get_user_by_post_code ()  {
		$userCount	= $this->User->find ('count',array('conditions'=>array('User.post_code'=>$_REQUEST['post_code'])));
		$response	=	array ('status'=>1,'message'=>'success','totalUser'=>$userCount);
		echo json_encode($response);exit;	
	}
	
	//http://pay-us.co/payusadmin/webservices/send_message?post_code=232&device_token=83ae695af10f7492b943e6c3a6e9aad3fb2d6d24b7edc610973207029b05196a
	//dev414.trigma.us/traapp_ios/Webs/send_message?post_code=27&device_token=83ae695af10f7492b943e6c3a6e9aad3fb2d6d24b7edc610973207029b05196a
	public function send_message ($post_code = Null) 
	{
		$this->loadModel('User');
		//$post_code			=	$_REQUEST['post_code'];
		if ($post_code != '')  { 	
			//echo $post_code;die;
			$userInfo			=	$this->User->find (
				'all',array(
					'conditions'	=> array (
						'User.post_code'	=> $post_code
					),
					'contain'		=> array(),
					'fields'			=> array('id','email','token','devicetype')
				)
			);					
			//echo "<pre>";print_r ($userInfo);die;
			/* Notification code Start*/
			$path 					= WWW_ROOT.'Stackck.pem';				
			//echo $path;die;
			foreach ($userInfo as $data)  {
				if (@$data['User']['token'] != '') {
					//echo "<pre>";print_r ($data);die;
					//$name	=	$data['User']['first_name'].' '.$data['User']['last_name'];
					$message		=	"There's a new post in your area. Share now!.";
					$passphrase 	= '123456';
					$name		= 'Sir';
					
					if ($data['User']['token'] != '') {
						$deviceToken	=	$data['User']['token'];
					}  else  {
						$deviceToken	=	'';
					}		
					//$deviceToken	=	'dYa_J9yMo9s:APA91bGeSnpbnL24pp2BNEOYAdKLeRoQ8QIKGjdzIBZI7abzdECXxOaag_wTq5PwT_F5lvmEWrJpRosfgsqDDbcT4iTCPhJkN0hzhb0x84mlsMkbX9Dlzc_F7kpCbDThzQBdaFy9awY2';
					//$data['User']['token']  =  'Android';
					if ($data['User']['devicetype'] == 'Android')   {
						//echo "android";
						$api_key = "AIzaSyDL_ynycfW9hL8-sERnCs2v0bc3TiXN0dE";
						$registrationIds = array($deviceToken);
						$msg = array (
							'message' 	=> "There's a new post in your area. Share now!.",
							'title'		=> 'This is a title. title',
							'subtitle'	=> 'This is a subtitle. subtitle',
							'tickerText'	=> 'Ticker text here...Ticker text here...Ticker text here',
							'vibrate'	=> 1,
							'sound'		=> 1,
							'largeIcon'	=> 'large_icon',
							'smallIcon'	=> 'small_icon'
						); 
						$fields = array (
							'registration_ids' 	=> $registrationIds,
							'data'			=> $msg
						);
						$headers = array (
							'Authorization: key=' .$api_key,
							'Content-Type: application/json'
						);
						$ch = curl_init();
						curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send');
						curl_setopt( $ch,CURLOPT_POST, true );
						curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
						curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );	
						curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
						curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode($fields ));
						$result = curl_exec($ch);
						//echo $result;
						if ($result === FALSE) {
							//die('Curl failed: ' . curl_error($ch));
						}	
						curl_close($ch);
					}  else {
						// Create a Stream
						$ctx = stream_context_create();
						// Define the certificate to use 
						stream_context_set_option($ctx, 'ssl', 'local_cert',$path);	
						// Passphrase to the certificate
						stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);	
						
						// Open a connection to the APNS server
						$fp 	= stream_socket_client('ssl://gateway.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT,$ctx);
						//echo $fp;die;
						// Check that we've connected
						if (!$fp) {
							exit("Failed to connect: $err $errstr" . PHP_EOL);
						} 
						//echo $fp;die;
						$body['aps'] 	= array ('alert' => $message,'type' =>  'text','sound' => 'default');
						//$name1			= 'Daily Reminders Notification';
						//$body['data'] 	= array ('id' => 123,'name' => $name,'status'=>1,'user_name'=>$name);

						$payload = json_encode($body);
						$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
						
						// Send it to the server
						$result = fwrite($fp, $msg, strlen($msg));
						//echo $result;die;
						if (!$result) {	
							//return 0; 
							//$response 	= array('success'=>0,'msg'=>'Error in notification.');
							//echo json_encode ($response);exit;	
							fclose ($fp);						
						}  else  {
							//return 1;			
							//$response			= 	array('success'=>1,'message'=>'success....');echo json_encode ($response);exit;		
							fclose($fp);
							//$response			= 	array('success'=>1,'message'=>'success....');
							//echo json_encode ($response);exit;						
						}
					}						
				}
			}die;
		}
		//die;
		/* Notification code End*/
		//$response			= 	array('success'=>1,'message'=>'success.');
		///echo json_encode ($response);exit;		
	}
	
	
	//http://pay-us.co/payusadmin/webservices/remove_user_token?user_id=145
	function remove_user_token ()  {
		//$user_info	= $this->User->find ('first',array('conditions'=>array('User.id'=>$_REQUEST['user_id']),'contain'=>array()));
		$token		=	'';		
		if ($this->User->updateAll(array('User.token'=>'"'.$token.'"'),array('User.id'=>$_REQUEST['user_id'])))  {
			$response	=	array ('status'=>1,'message'=>'success');
			echo json_encode($response);exit;	
		}
		$response	=	array ('status'=>0,'message'=>'error');
		echo json_encode($response);exit;	
	}
	
	public function test ($post_code = Null) 
	{

		/* Notification code Start*/
		$path 					= WWW_ROOT.'Stackck.pem';				
		//echo $path;die;
	
		//echo "<pre>";print_r ($data);die;
		//$name	=	$data['User']['first_name'].' '.$data['User']['last_name'];
		$message		=	"There's a new post in your area. Share now!.";
		$passphrase 	= '123456';
		$name		= 'Sir';

		$deviceToken	=	'c91912b925f46281424b6edaeb844d7dfecb4bafdd8e47b933f8915c4a89e478';
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
		//echo $fp;die;
		$body['aps'] 	= array ('alert' => $message,'type' =>  'text','sound' => 'default');
		//$name1			= 'Daily Reminders Notification';
		//$body['data'] 	= array ('id' => 123,'name' => $name,'status'=>1,'user_name'=>$name);

		$payload = json_encode($body);
		$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
		
		// Send it to the server
		$result = fwrite($fp, $msg, strlen($msg));
		//echo $result;die;
		if (!$result) {	
			//return 0; 
			//$response 	= array('success'=>0,'msg'=>'Error in notification.');
			//echo json_encode ($response);exit;	
			fclose ($fp);						
		}  else  {
			//return 1;			
			//$response			= 	array('success'=>1,'message'=>'success....');echo json_encode ($response);exit;		
			fclose($fp);
			//$response			= 	array('success'=>1,'message'=>'success....');
			//echo json_encode ($response);exit;						
		}
		die;
	}
	
	//http://pay-us.co/payusadmin/webservices/sharing_price
	public function sharing_price ()  {
		$this->loadModel('EarnPrice');
		$get_data	= $this->EarnPrice->find ('first');
		
		if (!empty($get_data))  {
			$earn	=	$get_data['EarnPrice']['price'];
			$response			= 	array('success'=>1,'message'=>'success.','earn'=>$earn);
			echo json_encode ($response);exit;	
		}
		$response			= 	array('success'=>1,'message'=>'success.','earn'=>0);
		echo json_encode ($response);exit;		
	}
	
		public function message()

	{

		require_once(ROOT . DS. 'vendor' .  DS . 'twilio' . DS . 'Services'. DS. 'Twilio.php');

		$account_sid = 'AC7db73557abdf5414c555e66d7d78e3a3'; 

		$auth_token = '0f16455070b67016cee3d80a9dedb3a5'; 

		$client = new \Services_Twilio($account_sid, $auth_token); 

				$msg = 'Hi, your testservice request has been assigned , If you have any questions/comments please submit a message by clicking here. - Thanks from Terra. (www.terra-app.com)';

				$client->account->messages->create(array( 

					'To' => "+917307808974",

					'From' => "+12513337702", 

					'Body' => $msg, 

					'MediaUrl' => "http://farm2.static.flickr.com/1075/1404618563_3ed9a44a3a.jpg",  

				)); 

	

	}
	
	//http://pay-us.co/payusadmin/webservices/total_earn_price_from_sharing?user_id=408
	public function total_earn_price_from_sharing ()  {
		$this->loadModel('Share');
		$get_data	=	$this->Share->find ('all',array('conditions'=>array('Share.user_id'=>$_REQUEST['user_id'])));
		$get_user	=	$this->User->find ('first',array('conditions'=>array('User.id'=>$_REQUEST['user_id']),'contain'=>array()));
		//echo "<pre>";print_r ($get_user);die;
		$username = '';
		if (!empty($get_user))  {
			if (@$get_user['User']['username'] == '')  {
				$username = '';
			}  else  {
				$username = $get_user['User']['username'];
			}
		}
		
		$amount_due				=	0;
		$already_withdrawn	=	0;
		$total_earnings			=	0;
		
		//echo "<pre>";print_r ($get_data);die;
		if (!empty($get_data))  {			
			//echo "<pre>";print_r ($get_data);die;
			foreach ($get_data as $info)  {			
				if ($info['Share']['redeem']  ==  'No')  {
					$amount_due				=	$amount_due + $info['Share']['earn'];
				}  else  {
					$already_withdrawn	=	$already_withdrawn + $info['Share']['earn'];
				}
				$total_earnings				=	$total_earnings + $info['Share']['earn'];
			}
			$response			= 	array('user_name'=>$username,'total_earnings'=>$total_earnings,'already_withdrawn'=>$already_withdrawn,'amount_due'=>$amount_due);
			echo json_encode ($response);exit;
		}
		$response			= 	array('user_name'=>$username,'total_earnings'=>$total_earnings,'already_withdrawn'=>$already_withdrawn,'amount_due'=>$amount_due);
		echo json_encode ($response);exit;
	}
	
	//http://pay-us.co/payusadmin/webservices/test
    public function affiliate_code()  { 
		$this->loadModel('User');		
		$data = $this->User->find ('all',array('contain'=>array()));
		foreach ($data as $info)  {
			$this->User->id = $info['User']['id'];
			$this->request->data['User']['affiliate_code']   = $info['User']['id'].time();
			$this->User->save($this->request->data);
		}		
		die('Done');	
	}
}
