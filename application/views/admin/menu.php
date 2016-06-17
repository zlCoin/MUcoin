<header class="header header-fixed navbar">
	<div class="brand">
		<a data-move="ltr" data-toggle="off-canvas" class="fa fa-bars off-left visible-xs" href="javascript:;"></a>
		<a class="navbar-brand text-white" href="<?=site_url('/admin/index')?>">
			<span class="heading-font">Free Wealth System</span>
		</a>
	</div>
	<ul class="nav navbar-nav navbar-right off-right">
		<li class="quickmenu">
			<a href="javascript:;">
				<img title="user" alt="user" class="avatar pull-left img-circle" src="/images/img-profile.jpg">&nbsp;<?=$this->login_lib->admin_name()?>
			</a>			
		</li>
		<li ><a href="<?=site_url('/supplier/logout')?>">退出</a></li>
	</ul>
</header>