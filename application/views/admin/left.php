<aside class="sidebar collapsible">
	<div class="scroll-menu">
		<nav class="main-navigation slimscroll" data-height="auto" data-size="4px" data-color="#ddd" data-distance="0">
		<ul>
			<li class="<?=my_menu()=="index" || my_menu()=="/"?"open collapse-open":""?>">
				<a href="<?=site_url('/admin/index')?>">
					<i class="fa fa-dashboard"></i>
					<span>控制台</span>
				</a>
			</li>
			<li class="<?=my_menu()=="nonactivated_member" || my_menu()=="member"   || my_menu()=="activation_code"  || my_menu()=="activation_code_bill" || my_menu()=="pay"  || my_menu()=="shop_pay" || my_menu()=="plan"?"open collapse-open":""?>">
				<a href="javascript:;" data-toggle="dropdown">
					<i class="fa fa-user"></i>
					<span>会员管理</span>
					<i class="toggle-accordion"></i>
				</a>
				<ul class="dropdown-menu">
					<li>
						<a href="<?=site_url('/admin/nonactivated_member')?>">
							<span>未激活会员</span>
						</a>
					</li>
					<li>
						<a href="<?=site_url('/admin/member')?>">
							<span>会员</span>
						</a>
					</li>
				</ul>
			</li>
			<li class="<?=my_menu()=="bonus" || my_menu()=="electronic_currency_transfer" || my_menu()=="electronic_currency_buy" || my_menu()=="electronic_currency" || my_menu()=="cash_currency" || my_menu()=="free_currency"  || my_menu()=="free_gold"  || my_menu()=="free_stock"  || my_menu()=="electronic_currency_market" || my_menu()=="cash_currency_market"  || my_menu()=="free_currency_market"?"open collapse-open":""?>">
				<a href="javascript:;" data-toggle="dropdown">
					<i class="fa fa-cny"></i>
					<span>财富管理</span>
					<i class="toggle-accordion"></i>
				</a>
				<ul class="dropdown-menu">
					<li>
						<a href="<?=site_url('/admin/cash_currency')?>">
							<span>奖金积分明细</span>
						</a>
					</li>
					<li>
						<a href="<?=site_url('/admin/free_currency')?>">
							<span>资产包明细</span>
						</a>
					</li>
				</ul>
			</li>
			<li class="<?=my_menu()=="member_recharge" || my_menu()=="recharge_record"?"open collapse-open":""?>">
				<a href="javascript:;" data-toggle="dropdown">
					<i class="fa fa-credit-card"></i>
					<span>充值管理</span>
					<i class="toggle-accordion"></i>
				</a>
				<ul class="dropdown-menu">
					<li>
						<a href="<?=site_url('/admin/member_recharge')?>">
							<span>会员充值</span>
						</a>
					</li>
					<li>
						<a href="<?=site_url('/admin/recharge_record')?>">
							<span>充值记录</span>
						</a>
					</li>
				</ul>
			</li>
			<li class="<?=my_menu()=="a_bonus" || my_menu()=="a_bonus_record"?"open collapse-open":""?>">
				<a href="javascript:;" data-toggle="dropdown">
					<i class="fa fa-trophy"></i>
					<span>静态积分管理</span>
					<i class="toggle-accordion"></i>
				</a>
				<ul class="dropdown-menu">
				 
				 
					<li>
						<a href="<?=site_url('/admin/a_bonus_record')?>">
							<span>静态释放记录</span>
						</a>
					</li>
				</ul>
			</li>
			<li class="<?=my_menu()=="administrator" || my_menu()=="role"  || my_menu()=="message" || my_menu()=="system_set" || my_menu()=="system_switch" || my_menu()=="back_up"?"open collapse-open":""?>">
				<a href="javascript:;" data-toggle="dropdown">
					<i class="fa fa-pencil-square"></i>
					<span>系统管理</span>
					<i class="toggle-accordion"></i>
				</a>
				<ul class="dropdown-menu">
					<li>
						<a href="<?=site_url('/admin/administrator')?>">
							<span>管理员</span>
						</a>
					</li>
					<li>
						<a href="<?=site_url('/admin/system_set')?>">
							<span>参数设置</span>
						</a>
					</li>
					 
					<li>
						<a href="<?=site_url('/admin/back_up')?>">
							<span>系统备份</span>
						</a>
					</li>
			  </ul>
			</li>
			 <li class="<?=my_menu()=="notice"  || my_menu()=="help"?"open collapse-open":""?>">
				<a href="javascript:;" data-toggle="dropdown">
					<i class="fa fa-bullhorn"></i>
					<span>公告/帮助</span>
					<i class="toggle-accordion"></i>
				</a>
				<ul class="dropdown-menu">
					<li>
						<a href="<?=site_url('/admin/notice')?>">
							<span>公告管理</span>
						</a>
					</li>
					<li>
						<a href="<?=site_url('/admin/help')?>">
							<span>帮助管理</span>
						</a>
					</li>
				</ul>
			</li>


          <!--li class="open collapse-open">
				<a href="javascript:;" data-toggle="dropdown">
					<i class="fa fa-bullhorn"></i>
					<span>执行任务</span>
					<i class="toggle-accordion"></i>
				</a>
				<ul class="dropdown-menu">
					<li>
						<a href="/auto.php/">
							<span>1、老会员释放20%</span>
						</a>
					</li>
					<li>
						<a href="/auto.php/">
							<span>2、释放静态3%</span>
						</a>
					</li>
				</ul>
			</li--->



		</ul>
	 </nav>
     </div>
</aside>
