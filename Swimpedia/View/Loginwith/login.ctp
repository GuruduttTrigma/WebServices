<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Academatch</title>
</head>

<body>
<h1>Sign in</h1>
<p>Sign in with one of the services below.</p>
<h2>Facebook</h2>
<a href="http://www.facebook.com/dialog/oauth?
			client_id=479754455411339&
			redirect_uri=http://linked.apnaphp.com/Loginwith/login&
			state=<?php echo $csrfToken; ?>&
			scope=email">Login with Facebook</a>
			
<h2>Twitter</h2>
<?php
	echo $this->Form->create('User', array('type' => 'post', 'action' => 'login'));
	echo $this->Form->hidden('Twitter.login', array('label' => false,'value' => '1'));
	echo $this->Form->submit("Login with twitter",array('label' => false));
	echo $this->Form->end();
?>
<h2>OpenID - MyOpenID</h2>
<?php
	echo $this->Form->create('User', array('type' => 'post', 'action' => 'login'));
	echo $this->Form->hidden('OpenidUrl.openid', array('label' => false,'value' => 'http://myopenid.com/'));
	echo $this->Form->submit("login with openid",array('label' => false,));
	echo $this->Form->end();
?>	
<h2>OpenID - Google</h2>
<?php
	echo $this->Form->create('User', array('type' => 'post', 'action' => 'login'));
	echo $this->Form->hidden('OpenidUrl.openid', array('label' => false,'value' => 'https://www.google.com/accounts/o8/id'));
	echo $this->Form->submit("login with googles openid",array('label' => false,));
	echo $this->Form->end();
?>	
<h2>OpenID - Yahoo</h2>
<?php
	echo $this->Form->create('User', array('type' => 'post', 'action' => 'login'));
	echo $this->Form->hidden('OpenidUrl.openid', array('label' => false,'value' => 'http://yahoo.com/'));
	echo $this->Form->submit("login with yahoos openid",array('label' => false,));
	echo $this->Form->end();
?>	
</body>
</html>