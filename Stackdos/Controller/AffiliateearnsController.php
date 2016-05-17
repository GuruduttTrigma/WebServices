<?php
class AffiliateearnsController extends AppController {  
	public $uses = array('User','Advertisement');
	public $components = array('ImageResize');
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow(array('test','showAdsToFriends','send_message'));
	}

	public function admin_index() 	{
		if ($this->request->is('post') && $_POST != '')  {    
			die();
            $keyword = $this->request->data['keyword'];			
            if ($keyword)  {
				$song = $this->Advertisement->find('all',array('conditions'=>array('OR'=>array('Advertisement.title LIKE'=>"%$keyword%",'Advertisement.location LIKE'=>"%$keyword%",'Advertisement.image LIKE'=>"%$keyword%",'Advertisement.description LIKE'=>"%$keyword%",'Advertisement.post_code LIKE'=>"%$keyword%")),'order' => array('Advertisement.id' => 'desc')));
		   }
		   if(empty($song))  {
				$this->Session->setFlash(__("Please try again,We didn't get your query."));
			}		
		   $this->Set('songs',$song);
        }  else  {
			$this->User->virtualFields = array('affiliate_earn'=>'SELECT sum(amount) FROM affiliateearns as af where User.id=af.user_id and af.redeem_amount="No"','affiliate_redeem'=>'SELECT sum(amount) FROM affiliateearns as af where User.id=af.user_id and af.redeem_amount="Yes"');
			$this->paginate = array(
				'conditions' 	=> array ('User.affiliate_earn !='=>''),
				'order' 			=> array ('User.affiliate_earn' => 'desc'),
				'limit' 				=> 10,
				'contain'			=> array ('Affiliateearn'),
				'fields'			=> array ('id','affiliate_code','first_name','last_name','affiliate_earn','affiliate_redeem')
			);
			$this->set('data', $this->paginate('User'));					
        }
	}

	public function admin_redeem ($id =Null)  {
		$this->User->virtualFields = array(
			'affiliate_earn'=>'SELECT sum(amount) FROM affiliateearns as af where User.id=af.user_id and af.redeem_amount="No"'
		);
		$user_info	=	$this->User->find ('first',array('conditions'=>array('User.id'=>$id)));
		$this->set('user_info',$user_info);
	}
	public function admin_success ($id = Null) {
		$this->User->virtualFields = array(
			'redeem_amount'=>'SELECT sum(shares.earn) FROM shares where User.id=shares.user_id and shares.redeem="No"'
		);
		$user_info	=	$this->User->find ('first',array('conditions'=>array('User.id'=>$id)));
		
		$redeem_amount	=	floor($user_info['User']['redeem_amount']);
		$redeemAmt			=	$redeem_amount*10;
		//echo $redeemAmt;die;
		$i = 1;
		foreach ($user_info['Share'] as $info)  {			
			if ($info['redeem'] == 'No' and $i <=$redeemAmt)  {
				$this->Share->updateAll(array('Share.redeem'=>"'Yes'"),array('Share.id'=>$info['id']));
			}
			$i = $i+1;
		}
		$this->Session->setFlash(__('The Payment successful'));
		$this->redirect(array('controller'=>'users','action' => 'index'));
	}
	
	public function admin_cancel () {
		echo "cancel";die;
	}
	


}?>
