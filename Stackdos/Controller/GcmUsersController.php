<?php

App::uses('AppController', 'Controller');
App::uses('HttpSocket', 'Network/Http');

//header('Access-Control-Allow-Origin: *');
//header('Access-Control-Allow-Methods: GET, POST'); 
/**
 * GcmUsers Controller
 *
 * @property GcmUser $GcmUser
 */
class GcmUsersController extends AppController {

    /**
     * index method
     *
     * @return void
     */
    function beforeFilter() {
       // configure::write('debug', 2);
        parent::beforeFilter();
        $this->Auth->allow(array('user_login', 'logout', 'add', 'user_logout', 'forgot', 'confirm', 'view', 'ios','send_notification','notification','send','androidapps','iosapps','index'));
    }

    public function index() {
        $this->layout="default3";
        //configure::write('debug',2);
        $this->GcmUser->recursive = 0;
        $this->set('gcm', $this->paginate());
        if ($this->request->is('post')) {
            if ($this->request->data['keyword']) {
                $data = $this->GcmUser->find("all", array("conditions" => array("OR" => array("GcmUser.email LIKE" => "%" . $this->request->data['keyword'] . "%", "GcmUser.device LIKE" => "%" . $this->request->data['keyword'] . "%"))));
            }
            $this->set("gcm", $data);
        }
    }
    public function admin_index() {
        //$this->layout="default3";
        //configure::write('debug',2);
        $this->GcmUser->recursive = 0;
        $this->set('gcm', $this->paginate());
        if ($this->request->is('post')) {
            if ($this->request->data['keyword']) {
                $this->request->data['keyword'] = trim($this->request->data['keyword']);
                $data = $this->GcmUser->find("all", array("conditions" => array("OR" => array("GcmUser.email LIKE" => "%" . $this->request->data['keyword'] . "%", "GcmUser.device LIKE" => "%" . $this->request->data['keyword'] . "%"))));
            }
            $this->set("gcm", $data);
        }
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->GcmUser->exists($id)) {
            throw new NotFoundException(__('Invalid gcm user'));
        }
        $options = array('conditions' => array('GcmUser.' . $this->GcmUser->primaryKey => $id));
        $this->set('gcmUser', $this->GcmUser->find('first', $options));
    }

   
    /**
     * add method
     *
     * @return void
     */
    public function admin_add() {

//header('Access-Control-Allow-Origin: *');
//header('Access-Control-Allow-Methods: GET, POST'); 
        //$this->layout="default3";

        if ($this->request->is('post')) {
            if (!empty($this->request->data['device'])) {
                $asd = $this->GcmUser->find('first', array('conditions' => array('device' => $this->request->data['device'])));
                if (!count($asd)) {
                    $GcmUser = array('GcmUser' => array(
                            'rgid' => $this->request->data['rgid'],
                            'name' => $this->request->data['name'],
                            'email' => $this->request->data['email'],
                            'device' => $this->request->data['device'],
                            'platform' => $this->request->data['platform'],
                            'created_at' => date('Y-m-d h:i:s')
                    ));
                }
            }

            ob_start();
            var_dump($this->request->data);
            $c = ob_get_clean();
            $fc = fopen('files' . DS . 'users' . DS . 'detail.txt', 'w');
            fwrite($fc, $c);
            fclose($fc);

            $this->GcmUser->create();
            if ($this->GcmUser->save($GcmUser)) {
                $this->Session->setFlash(__('The gcm user has been saved'));
                $registatoin_ids = array($this->request->data['regId']);
                $message = 'Thanx For Installing Katann.';
                $result = $this->send_notification($registatoin_ids, $message);

                return $result;
                //$this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The gcm user could not be saved. Please, try again.'));
            }
        }
    }
    
    
    
     public function add() {
         //Configure::write("debug",2);
//header('Access-Control-Allow-Origin: *');
//header('Access-Control-Allow-Methods: GET, POST'); 
       // $this->layout="default3";

        if ($this->request->is('post')) {
            if (!empty($this->request->data['device'])) {
                $asd = $this->GcmUser->find('first', array('conditions' => array('device' => $this->request->data['device'])));
                if (!count($asd)) {
                    $GcmUser = array('GcmUser' => array(
                            'rgid' => $this->request->data['regId'],
                            'name' => $this->request->data['name'],
                            'email' => $this->request->data['email'],
                            'device' => $this->request->data['device'],
                            'platform' => $this->request->data['platform'],
                            'created_at' => date('Y-m-d h:i:s')
                    ));
                }
            }

            ob_start();
            var_dump($this->request->data);
            $c = ob_get_clean();
            $fc = fopen('files' . DS . 'users' . DS . 'detail.txt', 'w');
            fwrite($fc, $c);
            fclose($fc);

            $this->GcmUser->create();
            if ($this->GcmUser->save($GcmUser)) {
                
                $this->Session->setFlash(__('The gcm user has been saved'));
                $registatoin_ids = array($this->request->data['regId']);
                $message = 'Thanx For Installing Katann.';
                $result = $this->send_notification($registatoin_ids, $message);
               
                return $result;
                exit;
                //$this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The gcm user could not be saved. Please, try again.'));
            }
        }
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        if (!$this->GcmUser->exists($id)) {
            throw new NotFoundException(__('Invalid gcm user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->GcmUser->save($this->request->data)) {
                $this->Session->setFlash(__('The gcm user has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The gcm user could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('GcmUser.' . $this->GcmUser->primaryKey => $id));
            $this->request->data = $this->GcmUser->find('first', $options);
        }
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null) {
        //configure::write('debug',2);
        $this->GcmUser->id = $id;
        if (!$this->GcmUser->exists()) {
            throw new NotFoundException(__('Invalid gcm user'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->GcmUser->delete()) {
            $this->Session->setFlash(__('Gcm user deleted'));
            $this->redirect(array('controller' => 'GcmUsers', 'action' => 'index'));
        }
        $this->Session->setFlash(__('Gcm user was not deleted'));
    }
    
    
    /*public function send_notification($id = NULL, $message = NULL) {
        // include config
        //include_once './config.php';

        // Set POST variables
        $url = 'https://android.googleapis.com/gcm/send';

        $fields = array(
            'registration_ids' => 353811051367756,
            'data' => rand(9,999).' Just Testing Here '.rand(10,1000),
        );

        $headers = array(
            'Authorization: key=AIzaSyCakO2C2UO_zgHKsAjyyJfIC319JN1a_gI',
            'Content-Type: application/json'
        );
        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        // Close connection
        curl_close($ch);
        $this->Session->setFlash('Report uploaded & push has been sent.'.);
       //return $result;
    }
    */

    public function send_notification($id=null,$msg = null) {
        // include config
        //include_once './config.php';
        // Set POST variables
        $this->loadModel('User');
        $user = $this->User->find("first",array("conditions"=>array("User.id"=>$id)));
        $device = $user['User']['device'];
        $platform = $user['User']['platform'];
        $url = 'https://android.googleapis.com/gcm/send';
        $this->loadModel('Pushsetting');
        $pu = $this->Pushsetting->find("first");        
        if($msg){
               $message  = $msg;
            }else{
               $message = 'Dear '.$user['User']['username'].', '.$pu['Pushsetting']['push_data'];
            }
        $fields = array(
//            'registration_ids' => $registatoin_ids,
            'registration_ids' => $user['User']['device'],
            'data' => $message
        );

        $headers = array(
            'Authorization: key=AIzaSyCakO2C2UO_zgHKsAjyyJfIC319JN1a_gI',
            'Content-Type: application/json'
        );
        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        // Close connection
        curl_close($ch);
        echo  $result;
         $this->Session->setFlash('Report uploaded & push has been sent.');
          $this->redirect("/admin/Users/report_upload");  
    }

    public function notification() {
        //$category=$this->
        $this->layout = "default";
        $id = $this->GcmUser->find('all');
        $this->set('response', $id);
        $this->loadModel('Application');
        $cat = $this->Application->find('all');
        $this->set('category', $cat);
    }

    public function send() {
        $this->layout = 'ajax';
        $message = array("price" => $this->request->data['message']);
        $as = $this->send_notification($this->request->data['rgid'], $message);
        $this->set('response', $as);
    }

    public function test() {
        
    }

    public function ios($id=null,$msg = null) {
        //$this->layout = 'ajax';
        $this->loadModel('User');
        $user = $this->User->find("first",array("conditions"=>array("User.id"=>$id)));
        $device = $user['User']['device'];
        $platform = $user['User']['platform'];
        $this->loadModel('Pushsetting');
        $url = 'http://katann.expiredomains.co.uk/';
            $pu = $this->Pushsetting->find("first");   
            if($msg){
               $message  = $msg;
            }else{
               $message = 'Dear '.$user['User']['username'].', '.$pu['Pushsetting']['push_data'];
            }
            $badges = isset($_REQUEST['badges']) ? $_REQUEST['badges'] : '1';
           // $url = $this->request->data['url'];

// Put your device token here (without spaces):
//$deviceToken = '63bd203684ded35cf96874c8caf0ff2a4d73a04cc66d9770a5391ab3e2af086d';
            $deviceToken = $device;

// Put your private key's passphrase here:
            $passphrase = '1234';

// Put your alert message here:
//$message = 'Just Testing Here!';
////////////////////////////////////////////////////////////////////////////////
//debug(WWW_ROOT);exit;
            $ctx = stream_context_create();
            stream_context_set_option($ctx, 'ssl', 'local_cert', WWW_ROOT . 'ck.pem');
            stream_context_set_option($ctx, 'ssl', 'cafile', WWW_ROOT . 'ca.cer');
            stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
            stream_context_set_option($ctx, 'ssl', 'verify_peer', false);

// Open a connection to the APNS server

            $fp = stream_socket_client(
              'ssl://gateway.sandbox.push.apple.com:2195', $err,
              $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx); 

//            $fp = stream_socket_client(
//                    'ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);

            if (!$fp)
                $msg_flash = ("Failed to connect: $err $errstr" . PHP_EOL);

            $msg_flash = 'Connected to APNS' . PHP_EOL;

// Create the payload body
            $body['aps'] = array(
                'alert' => array('action-loc-key' => 'Open', 'body' => $message),
                'sound' => 'default',
                'badge' => $badges,
                'url' => $url
            );

            $response = json_encode($body);
            $this->set('response', $response);

            $payload = json_encode($body);

// Build the binary notification
            $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

// Send it to the server
            $result = fwrite($fp, $msg, strlen($msg));            

            if (!$result)
                $msg_flash = 'Message not delivered' . PHP_EOL;
            else
                $msg_flash = $msg . PHP_EOL;

// Close the connection to the server
            fclose($fp);
      //  }
          $this->Session->setFlash('Report uploaded & push has been sent.');
          $this->redirect("/admin/Users/report_upload");   
            
    }

    public function iosapps() {
        $this->layout = "default3";
        // configure::write('debug',2);
        $this->GcmUser->recursive = 0;
        //$this->set('gcmUsers', $this->paginate(''));   
        $this->set('gcmUsers', $this->GcmUser->find('all', array('order' => "id DESC")));
    }

    public function androidapps() {
        $this->layout = "default3";
       // configure::write('debug', 2);
        $this->GcmUser->recursive = 0;
        //$this->set('gcmUsers', $this->paginate());    
        $this->set('gcmUsers', $this->GcmUser->find('all', array('order' => "id DESC")));
        //$this->loadModel('User');
    }
    
    public function admin_deleteall($id = null){
        if (!$this->request->is('post')) {
            //debug($this->request->data);exit;
            throw new MethodNotAllowedException();
        }
        foreach ($this->request['data']['GcmUser'] as $k) {
            $this->GcmUser->id = (int) $k;
            if ($this->GcmUser->exists()) {
                $this->GcmUser->delete();
            }
            
        }
        
        $this->Session->setFlash(__('Selected GcmUser were removed.'));
        $this->redirect(array(
            'action' => 'admin_index'
        ));
    } 
    
       

     public function admin_auto_send($id = null) {
        $this->loadModel('User');
        $user = $this->User->find("first",array("conditions"=>array("User.id"=>$id)));
        if($user['User']['platform']== "IOS"){
           $this->redirect("/GcmUsers/ios/".$id);
        }else{
           $this->redirect("/GcmUsers/send_notification/".$id);  
        }
     }
     
     
      public function admin_manual_send($id = null) {
          $this->loadModel('User');
          $data = $this->User->find("first",array("conditions"=>array("User.id"=>$id)));
          $this->set('users',$data);  
          $device = $data['User']['device'];
          $plateform = $data['User']['platform'];
          if($this->request->is("post")){
              $msg = $this->request->data['GcmUser']['message'];
            if($data['User']['platform']== "IOS"){
              $this->redirect("/GcmUsers/ios/".$id."/".$msg);
                }else{
              $this->redirect("/GcmUsers/send_notification/".$id."/".$msg);  
           }
          }
          
     }
    
    
    
}
