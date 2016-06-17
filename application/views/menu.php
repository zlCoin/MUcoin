<div class="sidebar-menu">
		<div class="sidebar-menu-inner">
			<header class="logo-env">
				<!-- logo -->
				<div class="logo">
					<a href="">
						<img src="/assets/images/logo@2x.png" width="200" alt="logo" />
					</a>
				</div>
				<!-- logo collapse icon -->
				<div class="sidebar-collapse">
					<a href="#" class="sidebar-collapse-icon"><!-- add class "with-animation" if you want sidebar to have animation during expanding/collapsing transition -->
						<i class="entypo-menu"></i>
					</a>
				</div>		
				<!--开启/关闭菜单图标（如果您想启用移动设备上的菜单不删除-->
				<div class="sidebar-mobile-menu visible-xs">
					<a href="#" class="with-animation">
						<i class="entypo-menu"></i>
					</a>
				</div>
			</header>
			<ul id="main-menu" class="main-menu">
				<li class="opened <?=my_menu()=="main" || my_menu()=="import_data"?"opened active":""?>">
					<a href="<?=site_url('/main')?>"><i class="entypo-gauge"></i><span class="title">首页</span></a>
				</li>				
				<li <?=my_menu()=="account" || my_menu()=="password" || my_menu()=="Password_protection" || my_menu()=="bank_account"  || my_menu()=="activation_account" || my_menu()=="activation_code" || my_menu()=="account" ||my_menu()=="management_fees" || my_menu()=="pay"?"class='opened active'":""?>>
					<a href="javascript:void(0);">
						<i class="entypo-users"></i>
						<span class="title">会员资料</span>
					</a>
					<ul>
						<li><a href="<?=site_url('/account')?>"><span class="title">账户管理</span></a></li>
						<li><a href="<?=site_url('/bank_account')?>"><span class="title">收款信息</span></a></li>
 						<li><a href="<?=site_url('/password')?>"><span class="title">密码变更</span></a></li>
 						<li><a href="<?=site_url('Password_protection')?>"><span class="title">二级密码变更</span></a></li>
 					</ul>
				</li>		
				<li <?=my_menu()=="My_team" || my_menu()=="registration" || my_menu()=="Tree" ? "class='opened active'" : "" ?>>
					<a href="javascript:void(0);">
						<i class="entypo-bookmark"></i>
						<span class="title">市场信息</span>
					</a>
					<ul>
						<li><a href="<?=site_url('/My_team')?>"><span class="title">直推列表</span></a></li>
						<li><a href="<?=site_url('/Tree')?>"><span class="title">成员列表</span></a></li>
						<li><a href="<?=site_url('/Tree/Graphical')?>"><span class="title">团队结构</span></a></li>
 					</ul>
				</li>
				<li <?= my_menu()=="sell_cash_price" || my_menu()=="cash_to_shopping" || my_menu()=="cash_to_wallet" || my_menu()=="electronic_transfer" ? "class='opened active'" : ""?>>
					<a href="javascript:void(0);">
						<i class="entypo-logo-db"></i>
						<span class="title">积分市场</span>
					</a>
					<ul>
						<li><a href="<?=site_url('/sell_cash_price')?>"><span class="title">购买积分</span></a></li>
						<li><a href="<?=site_url('/cash_to_shopping')?>"><span class="title">积分转商城</span></a></li>
                         <li><a href="<?=site_url('/cash_to_wallet')?>"><span class="title">奖金积分转报单积分</span></a></li>
						<li><a href="<?=site_url('/electronic_transfer')?>"><span class="title">积分转账</span></a></li>
						<li><a href="<?=site_url('/electronic_transfer')?>"><span class="title">进入交易大盘</span></a></li>
 					</ul>
				</li>
				<li <?= my_menu()=="Baodan_log" || my_menu()=="electronic_get"   ||  my_menu()=="electronic_consumption" || my_menu()=="cash_to_electronic" || my_menu()=="cash" || my_menu()=="free_currency" || my_menu()=="free_gold"?"class='opened active'":""?>>
					<a href="javascript:void(0);">
						<i class="entypo-doc-text-inv"></i>
						<span class="title">我的积分</span>
					</a>
					<ul>	
 						<li><a href="<?=site_url('/cash')?>"><span class="title">奖金积分明细</span></a></li>
						<li><a href="<?=site_url('/free_currency')?>"><span class="title">资产积分明细</span></a></li>
						<li><a href="<?=site_url('/Baodan_log')?>"><span class="title">报单积分明细</span></a></li>
 					</ul>
				</li>
				<li <?=my_menu()=="notice" || my_menu()=="help" || my_menu()=="message"?"class='opened active'":""?>>
					<a href="javascript:void(0);">
						<i class="entypo-megaphone"></i>
						<span class="title">帮助/公告</span>
					</a>
					<ul>
						<li><a href="<?=site_url('/notice')?>"><span class="title">系统公告</span></a></li>	
						<li><a href="<?=site_url('/help')?>"><span class="title">帮助中心</span></a></li>	
 					</ul>
				</li>
			</ul>
		</div>
	</div>