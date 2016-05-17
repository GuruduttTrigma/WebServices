<?php
class PushnotificationsController extends AppController {  
	public $components = array('ImageResize');
   
	public function beforeFilter() {
		parent::beforeFilter();
			$this->Auth->allow(array('test','showAdsToFriends','send_message','pem'));
	}
	
	public function admin_add() {		
		$this->loadModel('Plan');
		$this->loadModel('PlanUser');
		$this->loadModel('PostShow');
		$this->loadModel('User');
		$this->loadModel('Advertisercost');	
		$potential = 0;
		$userId = $this->Auth->user('id');		
		$data =  $this->User->find('all',array(
			'contain'=>array(),
			'fields'=>array('DISTINCT User.post_code','User.id'),
			'conditions'=>array("User.post_code !=" => ''),
			'order'=>'User.post_code ASC','group'=>'User.post_code'));		
		$this->set ('post_codes',$data);
		if ($this->request->is('post')) {		
			$request	=	$this->request->data;
			//echo "<pre>";print_r ($request);die;			
			//$post_code	=	'G64';
			$post_code	=	$request['User']['post_code'];
			$message	=	$request['User']['description'];
			$path 					= WWW_ROOT.'Stackck.pem';		
			//$path 				= WWW_ROOT.'1ck.pem';	
			$passphrase 	= '123456';			
			
			if ($post_code != '')  { 	
			//echo $post_code;die;
			if ($post_code  == 'all')  {
				$userInfo			=	$this->User->find (
					'all',array(
						'contain'		=> array(),
						'fields'			=> array('id','email','token','devicetype')
					)
				);	
			}  else  {
				$userInfo			=	$this->User->find (
					'all',array(
						'conditions'	=> array (
							'User.post_code'	=> $post_code
						),
						'contain'		=> array(),
						'fields'			=> array('id','email','token','devicetype')
					)
				);	
			}
						
			//echo "<pre>";print_r ($userInfo);die;
			/* Notification code Start*/
						
			//echo $path;die;
			foreach ($userInfo as $data)  {
				if (@$data['User']['token'] != '') {
										
					if ($data['User']['token'] != '') {
						$deviceToken	=	$data['User']['token'];
					}  else  {
						$deviceToken	=	'';
					}		
					
					//$deviceToken	=	'c22e85d8cea2b172e3df59e0d3b814066fe477dc4e0ae5b46e912a6227ed8456';					
					//$data['User']['devicetype']  =  'Android11';
					if ($data['User']['devicetype'] == 'Android')   {
						//echo "android";die;
						$api_key = "AIzaSyDL_ynycfW9hL8-sERnCs2v0bc3TiXN0dE";
						$registrationIds = array($deviceToken);
						$msg = array (
							'message' 	=> $message,
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
						$name1			= 'Daily Reminders Notification';
						$body['data'] 	= array ('id' => 123,'status'=>1);

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
			$this->Session->setFlash("Notification Send successfully.");
		}
		}
    }
	
	public function pem ()  {
		
	}
}?>
