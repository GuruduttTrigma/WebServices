<!DOCTYPE html>
<html xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
	<meta name="apple-mobile-web-app-capable" content="yes">
	<!--   -->
	<link href="http://admin.talentswipe.com/working/skin/pink.flag/css/jplayer.pink.flag.min.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="http://admin.talentswipe.com/working/js/jquery.min.js"></script>
	<script type="text/javascript" src="http://admin.talentswipe.com/working/js/jquery.jplayer.min.js"></script>
	<script type="text/javascript">
	//<![CDATA[
	$(document).ready(function(){

		$("#jquery_jplayer_1").jPlayer({
			ready: function () {
				$(this).jPlayer("setMedia", {
					title: "<?php echo $data['title']; ?>",
					mov: "<?php echo $data['video_url'].'.mov'; ?>",
					poster: "<?php echo $data['image']; ?>"
				});
			},
			swfPath: "../js",
			supplied: "mov",
			size: {
				width: "640px",
				height: "360px",
				cssClass: "jp-video-360p"
			},
			useStateClassSkin: true,
			autoBlur: false,
			smoothPlayBar: true,
			keyEnabled: true,
			remainingDuration: true,
			toggleDuration: true
		});

	});
	//]]>
	</script>
	
	<!--  -->
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
	<link rel="canonical" href="http://admin.talentswipe.com/users/facebook_meta?image=<?php echo $data['image']; ?>&video=<?php echo $data['video']; ?>&title=<?php echo $data['title']; ?>&description=<?php echo $data['description']; ?>" />

	<meta property="fb:app_id" content="1537465243217434" />
	<meta property="og:site_name" content="http://admin.talentswipe.com/" />
	<meta property="og:type" content="video" />
	<meta property="og:title" content="<?php echo $data['title'];?>" />
	<meta property="og:description" content="<?php echo $data['description'];?>" />
	<meta property="og:url" content="http://admin.talentswipe.com/users/facebook_meta?image=<?php echo $data['image']; ?>&video=<?php echo $data['video']; ?>&title=<?php echo $data['title']; ?>&description=<?php echo $data['description']; ?>" />
	<meta property="og:image" content="<?php echo $data['image']; ?>" />
	<meta property="og:video" content="<?php echo $data['video']; ?>" />
	<meta property="og:video:url" content="<?php echo $data['video']; ?>" />
	<meta property="og:video:secure_url" content="<?php echo $data['secure_url']; ?>" />
	<meta property="og:video:height" content="360">
	<meta property="og:video:width" content="640">
	<meta property="og:video:type" content="video/mp4" />  
	<meta property="og:video:type" content="application/x-shockwave-flash" />  

	
</head>
<body style="background-color:#E55E4B">
<!--<h1>Talentswipe</h1>-->
<div><?php //echo $data['title']; ?></div>
<div><?php //echo $data['description']; ?></div>
<div><?php //echo $data['image']; ?></div>
<div><?php //echo $data['video']; ?></div>
<div><?php //echo $data['secure_url']; ?></div>
<div>
	<div class="loginWrapper">
			<span style="margin-left:5%;"> <img src="<?php echo $this->webroot.'assets/img/Winner.png'; ?>" alt="Logo"></span>
			<div class="logControl">
				<video  loop autoplay width='100%' height='100%' src='<?php echo $data['video']; ?>' type='video/mp4' controls="true"></video>
			</div>
			<!--<div id="jp_container_1" class="jp-video jp-video-360p" role="application" aria-label="media player">
				<div class="jp-type-single">
					<div id="jquery_jplayer_1" class="jp-jplayer"></div>
					<div class="jp-gui">
						<div class="jp-video-play">
							<button class="jp-video-play-icon" role="button" tabindex="0">play</button>
						</div>
						<div class="jp-interface">
							<div class="jp-progress">
								<div class="jp-seek-bar">
									<div class="jp-play-bar"></div>
								</div>
							</div>
							<div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>
							<div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
							<div class="jp-details">
								<div class="jp-title" aria-label="title">&nbsp;</div>
							</div>
							<div class="jp-controls-holder">
								<div class="jp-volume-controls">
									<button class="jp-mute" role="button" tabindex="0">mute</button>
									<button class="jp-volume-max" role="button" tabindex="0">max volume</button>
									<div class="jp-volume-bar">
										<div class="jp-volume-bar-value"></div>
									</div>
								</div>
								<div class="jp-controls">
									<button class="jp-play" role="button" tabindex="0">play</button>
									<button class="jp-stop" role="button" tabindex="0">stop</button>
								</div>
								<div class="jp-toggles">
									<button class="jp-repeat" role="button" tabindex="0">repeat</button>
									<button class="jp-full-screen" role="button" tabindex="0">full screen</button>
								</div>
							</div>
						</div>
					</div>
					<div class="jp-no-solution">
						<span>Update Required</span>
						To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
					</div>
				</div>
			</div>-->
			
	</div>
	<br>
	<div class="logControl">
		<span style="color:white">Description:</span><span style="color:white"><?php echo $data['description']; ?></span>
	</div>
	<br>
	<div>
	<a title="Download" href="javascript:void(0)" onclick="return confirm('Coming soon!');">
		<span>Download The App</span>
	</a>
	</div>
	<!--<a title="Download" href="<?php //echo $data['video']; ?>" download="<?php //echo $data['video']; ?>" onclick="return confirm('Are you sure you want to Download this Video?');">
		<span>Download The video</span>
	</a>-->
</div>
</body>

</html>