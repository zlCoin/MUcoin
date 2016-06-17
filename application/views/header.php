<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title><?=$title?></title>
<script src="/js/jquery-1.7.1.min.js"></script>
<script src="/js/validate/jquery.validate.js"></script>
<link rel="stylesheet" href="/assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
<link rel="stylesheet" href="/assets/css/font-icons/entypo/css/entypo.css">
<link rel="stylesheet" href="/assets/css/bootstrap.css">
<link rel="stylesheet" href="/assets/css/neon-core.css">
<link rel="stylesheet" href="/assets/css/neon-theme.css">
<link rel="stylesheet" href="/assets/css/skins/facebook.css">
<link rel="stylesheet" href="/css/layout.css">
 <!--[if lt IE 9]><script src="/assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body class="page-body  skin-facebook">
<!-- Imported styles on this page -->
<link rel="stylesheet" href="/assets/js/jvectormap/jquery-jvectormap-1.2.2.css">
<link rel="stylesheet" href="/assets/js/rickshaw/rickshaw.min.css">
<style type="text/css">
.pb15{
	padding-bottom:15px;
}
.dataTables_top{
	padding-top:15px;overflow:hidden;border:1px #eee solid;border-bottom:0;border-top-left-radius:3px;border-top-right-radius:3px;
}
</style>
<?
if (!$this->login_lib->is_member_login())
	redirect("/index");
?>
<body>
<div class="page-container">
    <!--left-->
	<?php $this->load->view('menu.php') ?>
	<!--end left-->
	<div class="main-content">
		<!---header-->
		<div class="row">
			<!-- Profile Info and Notifications -->
			<div class="col-md-6 col-sm-8 clearfix">
				<ul class="user-info pull-left pull-none-xsm">
					<!-- Profile Info -->
					<li class="profile-info dropdown"><!-- add class "pull-right" if you want to place this from right -->
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<img src="/assets/images/thumb-1@2x.png" alt="" class="img-circle" width="44" />
							<?=$this->login_lib->member_name()?>
						</a>
 						<ul class="dropdown-menu">
							<!-- Reverse Caret -->
							<li class="caret"></li>
							<!-- Profile sub-links -->
							<li><a href="/account"><i class="entypo-user"></i>账户管理</a></li>
							<li><a href="/password"><i class="entypo-database"></i>修改密码</a></li>
							<li><a href="/index/logout"><i class="entypo-logout"></i>退出登录</a></li>
						</ul>
					</li>
				</ul>
				<ul class="list-inline links-list pull-left">
					<?php if(!$this->login_lib->member_state()){?>
					<li class="sep"></li>
					<li><a href="#" >（账号未激活）</a></li>
					<?php } ?>
					<li class="sep"></li>
					<li><a href="#" ><?=$this->login_lib->member_grade()?></a></li>
					<li class="sep"></li>
					<li><a href="#" ><?=$this->login_lib->member_tc_price()?></a></li>
				</ul>
			</div>
			<!-- Raw Links -->
			<div class="col-md-6 col-sm-4 clearfix hidden-xs">
				<ul class="list-inline links-list pull-right">
					<li class="sep"></li>
					<li><a  href="<?=site_url('/index/logout')?>">登出&nbsp;<i class="entypo-logout right"></i></a></li>
				</ul>
			</div>
		</div>
		<!-- end header-->
		<hr />