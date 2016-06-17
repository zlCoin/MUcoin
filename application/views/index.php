<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>众联</title>
<link rel="stylesheet" href="/assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
<link rel="stylesheet" href="/assets/css/font-icons/entypo/css/entypo.css">
<link rel="stylesheet" href="/assets/css/bootstrap.css">
<link rel="stylesheet" href="/assets/css/neon-core.css">
<link rel="stylesheet" href="/assets/css/neon-theme.css">
<link rel="stylesheet" href="/assets/css/neon-forms.css">
<link rel="stylesheet" href="/assets/css/custom.css">
<script src="/assets/js/jquery-1.11.0.min.js"></script>
<script>$.noConflict();</script>
<!--[if lt IE 9]><script src="/assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body class="page-body login-page login-form-fall">
<script type="text/javascript">
var baseurl = <?php echo '"' . $this->config->item('base_url') . '"'; ?>;
</script>
<div class="login-container">
	<div class="login-logo"><img src="/assets/images/logo.png" width="242" alt="logo"></div>
	<div class="login-progressbar"></div>
	<div class="login-form">
		<div class="login-content">
			<div class="login-title">系统登录</div>
			<div class="login-reg-switch">
				<div class="login-reg-hr"></div>
				<div class="login-reg-href">
					<span class="Link-a">
						<a href="/">登录</a>
						<a href="/reg/member">注册</a>
					</span>
				</div>
			</div>
			<div class="form-login-error"><h3 id="form-error-msg"></h3></div>
			<form method="post" role="form" id="form_login">
				<div class="form-group">
					<div class="input-group">
						<div class="input-group-addon">
							<i class="entypo-user"></i>
						</div>
						<input type="text" class="form-control" name="username" placeholder="用户名/手机号" autocomplete="off" />
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
						<div class="input-group-addon">
							<i class="entypo-key"></i>
						</div>
						<input type="password" class="form-control" name="password" placeholder="密码" autocomplete="off" />
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
						<div class="input-group-addon">
							<i class="entypo-vcard"></i>
						</div>
						<input type="text" class="form-control" name="verifi" placeholder="验证码" autocomplete="off" />
						<!--div class="form-login-verfi">
							<img src="<?php echo site_url('index/verifi'); ?>" class="verfiImg" alt="点击更换验证码" />
						</div-->
					</div>
				</div>
				<div class="form-group">
					<img src="<?php echo site_url('index/verifi'); ?>" class="verfiImg" alt="点击更换验证码" />
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-login-wyw btn-block btn-login">
						<i class="entypo-login"></i>
						登录
					</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Bottom scripts (common) -->
<script src="/assets/js/gsap/main-gsap.js"></script>
<script src="/assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
<script src="/assets/js/bootstrap.js"></script>
<script src="/assets/js/joinable.js"></script>
<script src="/assets/js/resizeable.js"></script>
<script src="/assets/js/neon-api.js"></script>
<script src="/assets/js/jquery.validate.min.js"></script>
<script src="/assets/js/neon-login.js"></script>
<!-- JavaScripts initializations and stuff -->
<script src="/assets/js/neon-custom.js"></script>
<!-- Demo Settings -->
<script src="/assets/js/neon-demo.js"></script>
<script type="text/javascript">
jQuery(function(){
	jQuery('.verfiImg').click(function(){
		jQuery(this).attr('src', <?php echo "'" . site_url('index/verifi') . "/'"; ?> + Math.random());
	})
})
</script>
</body>
</html>