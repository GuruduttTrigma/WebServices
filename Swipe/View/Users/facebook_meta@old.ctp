<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
	<meta name="apple-mobile-web-app-capable" content="yes">

	<link rel="apple-touch-icon" sizes="76x76" href="//global.fncstatic.com/static/p/video/app/landing/img/apple-video-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="120x120" href="//global.fncstatic.com/static/p/video/app/landing/img/apple-video-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="152x152" href="//global.fncstatic.com/static/p/video/app/landing/img/apple-video-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="//global.fncstatic.com/static/p/video/app/landing/img/apple-video-icon-180x180.png">

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
	<meta name="apple-mobile-web-app-capable" content="yes">
	  <link rel="apple-touch-icon" sizes="76x76" href="//global.fncstatic.com/static/p/video/app/landing/img/apple-video-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="120x120" href="//global.fncstatic.com/static/p/video/app/landing/img/apple-video-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="152x152" href="//global.fncstatic.com/static/p/video/app/landing/img/apple-video-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="//global.fncstatic.com/static/p/video/app/landing/img/apple-video-icon-180x180.png">
	<link rel="schema.dc" href="http://purl.org/dc/elements/1.1/" />
	<link rel="schema.dcterms" href="http://purl.org/dc/terms/" />
	<link rel="schema.iptc" href="http://iptc.org/std/nar/2006-10-01/" />
	<link rel="schema.prism" href="http://prismstandard.org/namespaces/basic/2.1/" />
	<link rel="icon" href="//global.fncstatic.com/static/p/video/img/fn/favicon.png" type="image/png" />
	<link rel="shortcut icon" href="<?php echo $data['image']; ?>" />
	<link rel="canonical" href="<?php echo $data['video']; ?>" />

	<meta property="fb:app_id" content="1505555673096572" />
	<meta property="og:title" content="<?php echo $data['title'];?>" />
	<meta property="og:description" content="<?php echo $data['description'];?>" />
	<meta property="og:url" content="http://talentswipe.com/users/facebook_meta?image=<?php echo $data['image']; ?>&video=<?php echo $data['video']; ?>&title=<?php echo $data['title']; ?>&description=<?php echo $data['description']; ?>" />
	<meta property="og:image" content="<?php echo $data['image']; ?>" />
	<meta property="og:type" content="video" />
	<meta property="og:video" content="<?php echo $data['video']; ?>&amp;d=talentswipe.com&amp;auto_play=true" />
	<meta property="og:video:secure_url" content="<?php echo $data['secure_url']; ?>" />
	<meta property="og:video:height" content="360">
	<meta property="og:video:width" content="640">
	<meta property="og:video:type" content="application/x-shockwave-flash" />  
	
	
</head>
<body>
<video loop autoplay width='100%' height='100%' src='<?php echo $data['secure_url']; ?>' type='video/mov'></video>
<!--<h1>Talentswipe</h1>-->
<div><?php //echo $data['title']; ?></div>
<div><?php //echo $data['description']; ?></div>
<div><?php //echo $data['image']; ?></div>
<div><?php //echo $data['video']; ?></div>
<div><?php //echo $data['secure_url']; ?></div>
</body>
</html>