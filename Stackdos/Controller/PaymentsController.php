<?php
#Project : onbeat (Stackdos)
class PaymentsController extends AppController  {
	public $uses = array('Advertisement','Advertisercost','Advertiserearn','PlanUser','User','Payment','Share');
	
	public function admin_redeem ($id =Null)  {
		$this->User->virtualFields = array(
			'redeem_amount'=>'SELECT sum(shares.earn) FROM shares where User.id=shares.user_id and shares.redeem="No"'
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
}
