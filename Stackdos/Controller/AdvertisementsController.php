<?php
App::uses('AppController', 'Controller');
/**
 * Albums Controller
 *
 * @property Album $Album
 */
class AdvertisementsController extends AppController {  
public $components = array('ImageResize');
/**
 * index method
 *
 * @return void
 */
   
public function beforeFilter() {
 parent::beforeFilter();
 $this->Auth->allow(array('test','showAdsToFriends','send_message'));
}


public function admin_index() {
  //$song = $this->Advertisement->find('all');
  // $this->Set('songs',$song);
    if($this->request->is('post')){              
            @$keyword = $this->request->data['keyword'];			
               if($keyword){
                    $song = $this->Advertisement->find('all',array('conditions'=>array('OR'=>array('Advertisement.title LIKE'=>"%$keyword%",'Advertisement.location LIKE'=>"%$keyword%",'Advertisement.image LIKE'=>"%$keyword%",'Advertisement.description LIKE'=>"%$keyword%",'Advertisement.post_code LIKE'=>"%$keyword%")),'order' => array('Advertisement.id' => 'desc')));

               }
               if(empty($song)){
                         $this->Session->setFlash(__("Please try again,We didn't get your query."));
                 }		
               $this->Set('songs',$song);
        }else{
                $this->Advertisement->recursive = 0;
               $this->paginate = array('order' => array('Advertisement.id' => 'desc'),'limit' =>10);
                $this->set('songs', $this->paginate());					
        }
                $this->Set('ads',$this->Advertisement->find('all'));
}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
			$this->Advertisement->id = $id;
			if (!$this->Advertisement->exists()) {
					throw new NotFoundException(__('Invalid Advertisement'));
			}
			$this->set('ads', $this->Advertisement->read(null, $id));

	}

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
	

/**
 * admin_add method
 *
 * @return voidadmin_add_advertisement/admin_add_multi_post_advertisement
 */
	public function admin_add_advertisement() {
		
    }
	
	public function admin_add_multi_post_advertisement() {
		ini_set('max_execution_time', 300); 
		ini_set('memory_limit', '256M');
		$this->loadModel('Plan');
		$this->loadModel('PlanUser');
		$this->loadModel('PostShow');
		$this->loadModel('User');
		$this->loadModel('Advertisercost');	
		$potential = 0;
		$userId = $this->Auth->user('id');
		if ($this->request->is('post')) {			
			//echo "<pre>";print_r($this->request->data);die;
			$post_codess	=	$this->request->data['Advertisement']['post_code'];
			$post_codes		= explode (',',$post_codess);	
			//echo "<pre>";print_r($post_codes);die;
			
			/* *******************************************  Start  ********************************* */
			//$potential_from 	= 0;	
			$plan					=	$this->Plan->find('first',array('conditions'=>array('Plan.id'=>$this->request->data['Plan']['id'])));			
			$potential_from	=	$plan['Plan']['potential_from'];
			$potential_to		=	$plan['Plan']['potential'];
			$payMoney		=	$plan['Plan']['cost'];
			$transaction_id	=	rand();
			$userId 				= $this->Auth->user('id');
			//$zip 					= $this->request->data['Advertisement']['post_code'];
			$zip						=	$postCode;
			$plan_id 			= $this->request->data['Plan']['id'];
			//echo $transaction_id;die;
					
			$this->request->data['Advertisement']['status'] 			= '1';
			$this->request->data['Advertisement']['plan_id'] 		= $plan_id;
			$this->request->data['Advertisement']['transaction_id'] 		= $transaction_id;
			$this->request->data['Advertisement']['user_id'] 		= $userId;
			$this->request->data['Advertisement']['title'] 				= $this->request->data['Advertisement']['title'];		
			$this->request->data['Advertisement']['email'] 			= $this->request->data['Advertisement']['email'];				
			$this->request->data['Advertisement']['description'] = $this->request->data['Advertisement']['description'];					
			$this->request->data['Advertisement']['potential']		= $potential_to;					
			$this->request->data['Advertisement']['payMoney']	= $payMoney;					
			
			if (!empty($this->request->data['Advertisement']['promo_code']))  {
				$this->request->data['Advertisement']['promo_code'] = $this->request->data['Advertisement']['promo_code'];							
			} else {
				$this->request->data['Advertisement']['promo_code'] = '';					
			}
			
			if (!empty($this->request->data['Advertisement']['optional_postcode1']))  {
				$this->request->data['Advertisement']['optional_postcode1'] = $this->request->data['Advertisement']['optional_postcode1'];							
			} else {
				$this->request->data['Advertisement']['optional_postcode1'] = '';					
			}		
			
			if (!empty($this->request->data['Advertisement']['optional_postcode2']))  {
				$this->request->data['Advertisement']['optional_postcode2'] = $this->request->data['Advertisement']['optional_postcode2'];							
			} else {
				$this->request->data['Advertisement']['optional_postcode2'] = '';					
			}	
			
			
			if (!empty($this->request->data['Advertisement']['post_code']))  {
				$this->request->data['Advertisement']['post_code'] = $this->request->data['Advertisement']['post_code'];				
			} else {
				$this->request->data['Advertisement']['post_code'] = '';					
			}		
						
			$dname	= time()."image.png";
			$this->request->data['Advertisement']['image'] 		= $dname;				
			$this->Advertisement->create();
			
			if ($this->Advertisement->save($this->request->data)) {
				$id			= $this->Advertisement->getLastInsertId();								
				if ($_FILES['data']['error']['Advertisement']['image'] == 0) {						
				$pth = 'files/screens' . DS .$dname;
					move_uploaded_file($_FILES['data']['tmp_name']['Advertisement']['image'], $pth);                   
				}  					
				
				/* --------------------------  User Plan Start ------------------------------------------------  */
				$planUser['PlanUser']['user_id'] 				= $userId;
				$planUser['PlanUser']['post_id']				= $id;
				$planUser['PlanUser']['plan_id']				= $plan_id;
				$planUser['PlanUser']['transaction_id']	= $transaction_id;
				$planUser['PlanUser']['status'] 				= 1;
				$planUser['PlanUser']['post_created'] 	= 1;
				$planUser['PlanUser']['date'] 					= date('Y-m-d H:i');
				//echo "<pre>";print_r ($planUser);die;
				$this->PlanUser->create();
				$this->PlanUser->save($planUser);													
				/* --------------------------  User Plan  End ------------------------------------------------  */
				
				for ($i=0;$i<count($post_codes); $i++) {
					if ($post_codes[$i] != '') {
						$zip = $post_codes[$i];
						$posts	=	$this->User->find ('list',array('conditions'=>array('User.post_code'=>$zip,'User.id Not'=>$userId)));
						if (!empty($posts))  {
							foreach($posts as $key=>$toshowpost)  {
								$this->request->data['PostShow']['user_id'] = $key;
								$this->request->data['PostShow']['post_id'] = $id;
								$this->request->data['PostShow']['status'] = 1;
								$this->PostShow->create();
								$this->PostShow->save($this->request->data);
							}			
						}			
						$this->send_message ($zip);					
					} 		
				}				
			}
			$this->Session->setFlash(__('The Advertisement has been saved.'));
			$this->redirect(array('action' => 'index'));
		}
			
		$AdvertCostFrom =  $this->Advertisercost->find('all', array('fields' => array('Advertisercost.potential_from')));
		$plans 					=  $this->Plan->find('all', array('fields' => array('id','Plan.no_of_shares')));		
		$AdvertCostTo 		=  $this->Advertisercost->find('all', array('fields' => array('Advertisercost.potential')));	
		$data =  $this->User->find('all',array(
			'contain'=>array(),
			'fields'=>array('DISTINCT User.post_code','User.id'),
			'conditions'=>array("User.post_code !=" => ''),
			'order'=>'User.post_code ASC','group'=>'User.post_code'));		
		$this->set ('post_codes',$data);
		$this->set('AdvertCostFrom',$AdvertCostFrom);	 
		$this->set('AdvertCostTo',$AdvertCostTo);		
		$this->set('plans',$plans);		
    }
	
	public function admin_add() {
		$this->loadModel('Plan');
		$this->loadModel('PlanUser');
		$this->loadModel('PostShow');
		$this->loadModel('User');
		$this->loadModel('Advertisercost');	
		$potential = 0;
		$userId = $this->Auth->user('id');
		if ($this->request->is('post')) {
			
			/* *******************************************  Start  ********************************* */
			//$potential_from 	= 0;	
			$plan					=	$this->Plan->find('first',array('conditions'=>array('Plan.id'=>$this->request->data['Plan']['id'])));
			
			$potential_from	=	$plan['Plan']['potential_from'];
			$potential_to		=	$plan['Plan']['potential'];
			$payMoney		=	$plan['Plan']['cost'];
			$transaction_id	=	rand();
			$userId 				= $this->Auth->user('id');
			$zip 					= $this->request->data['Advertisement']['post_code'];
			$plan_id 			= $this->request->data['Plan']['id'];
			//echo $transaction_id;die;
			//$this->send_message ($zip);
			// if ($userId == '' or $zip == '' or $transaction_id= '') {
				// $response = array('status'=>0,'msg'=>'Wrong resquest.');
				// echo json_encode($response);exit();	
			// }
			
			$this->request->data['Advertisement']['status'] 			= '1';
			$this->request->data['Advertisement']['plan_id'] 		= $plan_id;
			$this->request->data['Advertisement']['transaction_id'] 		= $transaction_id;
			$this->request->data['Advertisement']['user_id'] 		= $userId;
			$this->request->data['Advertisement']['title'] 				= $this->request->data['Advertisement']['title'];		
			$this->request->data['Advertisement']['email'] 			= $this->request->data['Advertisement']['email'];				
			$this->request->data['Advertisement']['description'] = $this->request->data['Advertisement']['description'];					
			$this->request->data['Advertisement']['potential']		= $potential_to;					
			$this->request->data['Advertisement']['payMoney']	= $payMoney;					
			
			if (!empty($this->request->data['Advertisement']['promo_code']))  {
				$this->request->data['Advertisement']['promo_code'] = $this->request->data['Advertisement']['promo_code'];							
			} else {
				$this->request->data['Advertisement']['promo_code'] = '';					
			}
			
			if (!empty($this->request->data['Advertisement']['optional_postcode1']))  {
				$this->request->data['Advertisement']['optional_postcode1'] = $this->request->data['Advertisement']['optional_postcode1'];							
			} else {
				$this->request->data['Advertisement']['optional_postcode1'] = '';					
			}		
			
			if (!empty($this->request->data['Advertisement']['optional_postcode2']))  {
				$this->request->data['Advertisement']['optional_postcode2'] = $this->request->data['Advertisement']['optional_postcode2'];							
			} else {
				$this->request->data['Advertisement']['optional_postcode2'] = '';					
			}	
			
			if (!empty($this->request->data['Advertisement']['post_code']))  {
				$this->request->data['Advertisement']['post_code'] = $this->request->data['Advertisement']['post_code'];							
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
			//if (!empty($getAllUser))  {
				//foreach($getAllUser as $userList) {
					//$finalArray[$userList['User']['id']] = $userList['User']['fb_friend'];
				//}
				//$totalFriend  = $finalArray;			
				//echo "<pre>";print_r($totalFriend);
				//$totalFriend = $this->nearbytotal($val['lat'],$val['lng'],$userId);
				//$friendPost = $this->showAdsToFriends($totalFriend,$potential_from,$potential_to);
				//echo "<pre>";print_r($friendPost);die;
				//if (!empty($friendPost))  {			
					// foreach($friendPost as $friendcount){
						// $potential += $friendcount;
					// }  
					// $getTotalPotential = $potential;				
					$dname	= time()."image.png";
					$this->request->data['Advertisement']['image'] 		= $dname;
					//$one = $this->request->data['Advertisement']['image'];
					//pr ($_FILES['data']['tmp_name']['Advertisement']['image']);die;
					$this->Advertisement->create();
					if ($this->Advertisement->save($this->request->data)) {
						$id			= $this->Advertisement->getLastInsertId();								
						if ($_FILES['data']['error']['Advertisement']['image'] == 0) {						
							$pth = 'files/screens' . DS .$dname;
							move_uploaded_file($_FILES['data']['tmp_name']['Advertisement']['image'], $pth);                   
						}  
						
						//$pay = $this->Advertisercost->query("SELECT cost from advertisercosts where potential_from <='".$getTotalPotential."' AND potential >= '".$getTotalPotential."'");
					//	$payMoney = $pay[0]['advertisercosts']['cost'];			
						//$this->Advertisement->saveField('total_earn',$payMoney);  						
						//	$this->Advertisement->saveField('potential',$getTotalPotential);  
						
						/* --------------------------  User Plan Start ------------------------------------------------  */
							$planUser['PlanUser']['user_id'] 				= $userId;
							$planUser['PlanUser']['post_id']				= $id;
							$planUser['PlanUser']['plan_id']				= $plan_id;
							$planUser['PlanUser']['transaction_id']	= $transaction_id;
							$planUser['PlanUser']['status'] 				= 1;
							$planUser['PlanUser']['post_created'] 	= 1;
							$planUser['PlanUser']['date'] 					= date('Y-m-d H:i');
							//echo "<pre>";print_r ($planUser);die;
							$this->PlanUser->create();
							$this->PlanUser->save($planUser);													
						/* --------------------------  User Plan  End ------------------------------------------------  */
						
						$posts	=	$this->User->find ('list',array('conditions'=>array('User.post_code'=>$zip,'User.id Not'=>$userId)));
						if (!empty($posts))  {
							foreach($posts as $key=>$toshowpost)  {
								$this->request->data['PostShow']['user_id'] = $key;
								$this->request->data['PostShow']['post_id'] = $id;
								$this->request->data['PostShow']['status'] = 1;
								$this->PostShow->create();
								$this->PostShow->save($this->request->data);
							}			
						}						
						if($this->send_message ($zip))  {
							$this->Session->setFlash(__('The Advertisement has been saved'));
							$this->redirect(array('action' => 'index'));
						}  else  {
							$this->Session->setFlash(__('The Advertisement has been saved.'));
							$this->redirect(array('action' => 'index'));
						}
						//$this->Advertisement->query("Update  `advertisements` set `total_earn`='".$payMoney."',`potential`='".$getTotalPotential."' where  `id`='".$id."' ");
						
						//$this->send_message ($zip);
					} else{
						$this->Session->setFlash(__('The Advertisement could not be saved.'));			
					} 
				// }  else {
					// $this->Session->setFlash(__('The Advertisement could not be saved. There is no friend find in area.'));						
				// }
			// } else {
					// $this->Session->setFlash(__('The Advertisement could not be saved. There is no friend find in area.'));					
			// } 		
		
			/* ========================================================= */
			
			// $post_code = $this->request->data['Advertisement']['post_code'] ;
			// $advert_cost_from = $this->request->data['Advertisement']['advert_cost_from'];
			// $advert_cost_to = $this->request->data['Advertisement']['advert_cost_to'];
			// $getAllUser = $this->User->find('all', array( 
				// 'conditions' => array('User.post_code'=>$post_code,'not' => array('User.id' => $userId))
			// ));	
			// if(!empty($getAllUser)){
				// foreach($getAllUser as $userList) {
					// $finalArray[$userList['User']['id']] = $userList['User']['fb_friend'];
				// }
				// if(!empty($finalArray)){
					// $totalFriend  = $finalArray;
				// } else {
					// $totalFriend ='';
				// }
				// $friendPost = $this->showAdsToFriends($totalFriend,$advert_cost_from,$advert_cost_to);
				// if(!empty($friendPost)){
					// foreach($friendPost as $friendcount){
						// $potential += $friendcount;
					// }
					
					// $getTotalPotential = $potential;				
					// $image = $this->request->data['Advertisement']['image'] ;
					// $planInfo	=	$this->Plan->find ('first',array('conditions'=>array('Plan.id'=>$this->request->data['Plan']['id'])));
					//echo "<pre>"; print_r($planInfo);die;
				   // $pay = $this->Advertisercost->query("SELECT cost from advertisercosts where potential_from <='".$getTotalPotential."' AND potential >= '".$getTotalPotential."'");
					// $payMoney = $pay[0]['advertisercosts']['cost'];							  
					  // $this->request->data['Advertisement']['total_earn']  = $payMoney;
					  // $this->request->data['Advertisement']['potential']  = $planInfo['Plan']['potential'];
					  // $this->request->data['Advertisement']['user_id']  = $userId;
					  // $this->request->data['Advertisement']['status']  = (int)1;
					  // @$image = $this->Advertisement->find('first',array('fields'=>array('image'))); 
					  // $one = $this->request->data['Advertisement']['image'];
					  // if($one['name']){
						// $this->request->data['Advertisement']['image'] = $one['name'];
					  // } else{
						// $this->request->data['Advertisement']['image']= @$image['Advertisement']['image'];
					  // }
					  // $this->Advertisement->create();
					  // if ($this->Advertisement->save($this->request->data)) {
						// $id=$this->Advertisement->getLastInsertId();	
						// if ($one['error'] == 0) {
						  // $pth = 'files/screens' . DS .$one['name'];
						  // move_uploaded_file($one['tmp_name'], $pth);                   
						// }
						// /* -------------------------- Save Plan Start   ------------------------------------  */
						// $data['PlanUser']['user_id'] 	= 1;
						// $data['PlanUser']['post_id'] 	= $id;
						// $data['PlanUser']['plan_id'] 	= $this->request->data['Plan']['id'];
						// $data['PlanUser']['status'] 	= 1;
						// $data['PlanUser']['post_created'] = 1;
						// $this->PlanUser->create();
						// $this->PlanUser->save($data);
						// /* -------------------------- Save Plan End   ------------------------------------  */
						// if(!empty($friendPost)){
							// $this->loadModel('PostShow');
							// foreach($friendPost as $key=>$toshowpost){
								// $this->request->data['PostShow']['user_id'] = $key;
								// $this->request->data['PostShow']['post_id'] = $id;
								// $this->request->data['PostShow']['status'] = 1;
								// $this->PostShow->create();
								// $this->PostShow->save($this->request->data);
							// }			
						// }
						// $this->Session->setFlash(__('The Advertisement has been saved'));
						// $this->redirect(array('action' => 'index'));
					  // } else {
						// $this->Session->setFlash(__('The Advertisement could not be saved. Please, try again.'));
					  // }
				// } else {
					// $this->Session->setFlash(__('The Advertisement could not be saved. There is no friend find in area.'));
				// }  
			// } else {
				// $this->Session->setFlash(__('The Advertisement could not be saved. There is no friend find in area.'));
			// }  
		}
		$AdvertCostFrom =  $this->Advertisercost->find('all', array('fields' => array('Advertisercost.potential_from')));		
		$this->set('AdvertCostFrom',$AdvertCostFrom);	 

		$AdvertCostTo =  $this->Advertisercost->find('all', array('fields' => array('Advertisercost.potential')));		
		$plans =  $this->Plan->find('all', array('fields' => array('id','Plan.no_of_shares')));		
		$this->set('AdvertCostTo',$AdvertCostTo);		
		$this->set('plans',$plans);		
    }
	
/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_add_earn_price() {
		$this->loadModel('EarnPrice');
		$this->loadModel('Advertiserearn');
		if ($this->request->is('post')) {			
			$data	=	$this->request->data;
			$this->EarnPrice->id=	1;
			if ($this->EarnPrice->save($data))  {
				$this->Advertiserearn->updateAll(array('Advertiserearn.earn_per_post'=>'"'.$data['EarnPrice']['price'].'"'));
				$this->Session->setFlash(__('The Earn Price has been saved'));
			}
			//echo "<pre>"; print_r($data);die;
		}		
		$this->set('price',$this->EarnPrice->find('first'));
	}
 public function admin_edit($id = null) {
        $this->Advertisement->id = $id;
        if (!$this->Advertisement->exists()) {
                throw new NotFoundException(__('Invalid Image'));
        }
        @$image = $this->Advertisement->find('first',array('conditions'=>array('Advertisement.id'=>$id)));
		//debug($image); exit;
        if ($this->request->is('post') || $this->request->is('put')) {
             $once = $this->request->data['Advertisement']['image'];   
			$post_code	=$this->request->data['Advertisement']['post_code'];
			//echo  $post_code;die; 
			if (is_numeric($post_code))  {
				if($once['name']){
					$this->request->data['Advertisement']['image'] = $id.$once['name'];
				}else{
					$this->request->data['Advertisement']['image'] = $image['Advertisement']['image']; 
				}
				if ($this->Advertisement->save($this->request->data)) {
					  if($this->request->data['Advertisement']['image']){
							if ($once['error'] == 0) {
								$pth = 'files' . DS . 'screens' . DS .$id.$once['name'];
								move_uploaded_file($once['tmp_name'], $pth);      
							}                     
					  }
						$this->Session->setFlash(__('The Advertisement has been saved'));
						$this->redirect(array('action' => 'index'));
				} else {
						$this->Session->setFlash(__('The Advertisement could not be saved. Please, try again.'));
				}
			}  else {
					$this->Session->setFlash(__('The Advertisement could not be saved, Wrong post code. Please, try again.'));
			}
        } else {
                $this->request->data = $this->Advertisement->read(null, $id);
        }
      


        $this->set('advertisement', $this->Advertisement->read(null, $id));		
	//	$id = $this->Auth->User('id');
	//	$this->set('user',$this->User->find('first',array('conditions'=>array('User.id'=>$id))));
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
        $this->Advertisement->id = $id;
        if (!$this->Advertisement->exists()) {
                throw new NotFoundException(__('Invalid song'));
        }
        if ($this->Advertisement->delete($id,true)) {
                $this->Session->setFlash(__('Advertisement deleted'));
                $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Advertisement was not deleted'));
        $this->redirect(array('action' => 'index'));
}
	
	
public function admin_deleteall($id = null){
if (!$this->request->is('post')) {
    throw new MethodNotAllowedException();
}
foreach ($this->request['data']['Advertisement'] as $k) {
    $this->Advertisement->id = (int) $k;
    if ($this->Advertisement->exists()) {
        $this->Advertisement->delete($k,true);
    }            
}        
$this->Session->setFlash(__('Selected Advertisement were removed.'));
                $this->redirect(array('action' => 'index'));
}
	
	
	
public function admin_activate($id = null) {  
$this->Advertisement->id = $id;
if ($this->Advertisement->exists()) {
    $x = $this->Advertisement->save(array(
        'Advertisement' => array(
            'status' => '1'
        )
    ));
    $this->Session->setFlash("Advertisement activated successfully.");
    $this->redirect(array(
        'action' => 'index'
    ));
} else {
    $this->Session->setFlash("Unable to activate Advertisement.");
    $this->redirect(array(
        'action' => 'index'
    ));
}        
}
    
    
public function admin_block($id = null) {
    $this->Advertisement->id = $id;
    if ($this->Advertisement->exists()) {
        $x = $this->Advertisement->save(array(
            'Advertisement' => array(
                'status' => '0'
            )
        ));
        $this->Session->setFlash("Advertisement blocked successfully.");
        $this->redirect(array(
            'action' => 'index'
        ));
    } else {
        $this->Session->setFlash("Unable to block Advertisement.");
        $this->redirect(array(
            'action' => 'index'
        ));
    }        
}
	
	
	
	
	
public function admin_activateall($id = null){
if (!$this->request->is('post')) {
throw new MethodNotAllowedException();
}        
//debug($this->request);exit;
foreach ($this->request['data']['Advertisement'] as $k => $v) {	
if($k == $v){
        $this->Advertisement->id = $v;
        if ($this->Advertisement->exists()) {
                $x = $this->Advertisement->save(array(
                        'Advertisement' => array(
                                'status' => "1"
                        )					
                ));
	$this->Session->setFlash(__('Selected Advertisement Activated.', true));					
        } else {
                $this->Session->setFlash("Unable to Activate Advertisement.");
        }
}            
}
 $this->redirect(array(
'action' => 'index'
));
}
	
	
		
public function admin_deactivateall($id = null){
        if (!$this->request->is('post')) {
    throw new MethodNotAllowedException();
}        
foreach ($this->request['data']['Advertisement'] as $k => $v) {	
        if($k == $v){
                $this->Advertisement->id = $v;
                if ($this->Advertisement->exists()) {
                        $x = $this->Advertisement->save(array(
                                'Advertisement' => array(
                                        'status' => "0"
                                )					
                        ));
				$this->Session->setFlash(__('Selected Advertisement Deactivated.', true));					
                } else {
                        $this->Session->setFlash("Unable to Deactivated Advertisement.");
                }
        }
}
         $this->redirect(array(
        'action' => 'index'
    ));
}
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
			if (!empty($userInfo))  {
				foreach ($userInfo as $data)  {
					if (@$data['User']['token'] != '') {
						//echo "<pre>";print_r ($data);die;
						//$name	=	$data['User']['first_name'].' '.$data['User']['last_name'];
						$message		=	"There's a new post in your area. Share now!.";
						$passphrase 	= '123456';
						//$name		= 'fff';
						
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
							if (ctype_xdigit($deviceToken))  {
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
					}
				}
			}
			return 1;die;
		}	
	}


}?>
