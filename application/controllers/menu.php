<div class="grid_12">
	<ul class="nav main">
		<li class="ic-house <?=my_menu()=="main" || my_menu()=="import_data"?"current":""?>"><a href="<?=site_url('/main')?>"><span>首页</span></a></li>
		<li class="ic-form-style <?=my_menu()=="account" || my_menu()=="free_stock_market" || my_menu()=="buy_free_stock" || my_menu()=="password" || my_menu()=="password_protection" || my_menu()=="bank_account"  || my_menu()=="activation_account" || my_menu()=="management_fees" || my_menu()=="pay"?"current":""?>"><a href="<?=site_url('/account')?>"><span>商家账户</span></a></li>
		<li class="ic-dashboard <?=my_menu()=="my_team"  ||  my_menu()=="tree"     ||  my_menu()=="registration"  ||  my_menu()=="spread" ?"current":""?>"><a href="<?=site_url('/my_team')?>"><span>销售管理</span></a></li>
		<li class="ic-charts <?=my_menu()=="bonus"  ||  my_menu()=="dividend"   ||  my_menu()=="recommend"   ||  my_menu()=="management"?"current":""?>"><a href="<?=site_url('/bonus')?>"><span>赠送积分</span></a></li>
		<li class="ic-finance <?=my_menu()=="electronic_transfer"   ||  my_menu()=="electronic"   ||  my_menu()=="electronic_get"   ||  my_menu()=="electronic_consumption"  ||  my_menu()=="cash_to_electronic"   ||  my_menu()=="cash_to_shopping"   ||  my_menu()=="cash"   ||  my_menu()=="free_currency"  ||  my_menu()=="free_gold"?"current":""?>"><a href="<?=site_url('/electronic')?>"><span>积分记录</span></a></li>
		<li class="ic-finance <?=my_menu()=="plan"?"current":""?>"><a href="<?=site_url('/plan')?>"><span>保本计划</span></a></li>
		<li class="ic-grid-tables  <?=my_menu()=="electronic_currency_market"  ||  my_menu()=="sell_electronic_currency"   ||  my_menu()=="cash_currency_market"   ||  my_menu()=="sell_cash_currency"  ||  my_menu()=="free_currency_market"  ||  my_menu()=="sell_free_currency"?"current":""?>"><a href="<?=site_url('/cash_currency_market')?>"><span>抢购积分</span></a></li>
 		<!--<li class="ic-notifications <?=my_menu()=="notice"?"current":""?>"><a href="<?=site_url('/notice')?>"><span>信息管理</span></a></li>-->
	</ul>
</div>
<div class="clear"></div>
<div class="grid_2">
	<div class="box sidemenu" style="height: 515px;">
		<div id="section-menu" class="block ui-accordion ui-widget ui-helper-reset ui-accordion-icons" role="tablist">
			<ul class="section menu">
			<?
			if(my_menu()=="main"   || my_menu()=="import_data"){
			?>
			<li><a class="menuitem ui-accordion-header ui-helper-reset ui-state-default ui-state-active ui-corner-top current" role="tab" aria-expanded="true" aria-selected="true" tabindex="0"><span class="ui-icon ui-icon-triangle-1-e"></span>首页</a>
					<ul class="submenu ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" style="height: auto; " >
						<li><a class="<?=my_menu()=="main"   || my_menu()=="import_data"?"active":""?>" href="<?=site_url('/main')?>" >首页</a></li>
						<li><a class="<?=my_menu()=="activation_account"?"active":""?>" href="<?=site_url('/activation_account')?>">参与赠送积分</a></li>
						<li><a class="<?=my_menu()=="management_fees"?"active":""?>" href="<?=site_url('/management_fees')?>" >在线支付管理费</a></li>
					 <li><a class="<?=my_menu()=="activation_code"?"active":""?>" href="<?=site_url('/activation_code')?>" >充值密码支付管理费</a></li>
						<li><a class="<?=my_menu()=="account"?"active":""?>" href="<?=site_url('/account')?>" >商家账户</a></li>
						<li><a class="<?=my_menu()=="my_team"?"active":""?>" href="<?=site_url('/my_team')?>" >销售管理</a></li>
						<li><a class="<?=my_menu()=="bonus"?"active":""?>" href="<?=site_url('/bonus')?>" >赠送积分</a></li>
						<li><a class="<?=my_menu()=="electronic"?"active":""?>" href="<?=site_url('/cash_currency_market')?>" >抢购积分</a></li>
						<li><a class="<?=my_menu()=="electronic"?"active":""?>" href="<?=site_url('/electronic')?>" >积分记录</a></li>
 						<!--<li><a class="<?=my_menu()=="notice"  ||  my_menu()=="help"   ||  my_menu()=="message"?"active":""?>" href="<?=site_url('/notice')?>" >信息管理</a></li>-->
					</ul>
				</li>
				<?
}	
			if(my_menu()=="account" || my_menu()=="free_stock_market" || my_menu()=="buy_free_stock" || my_menu()=="password" || my_menu()=="password_protection" || my_menu()=="bank_account"  || my_menu()=="activation_account"  || my_menu()=="management_fees" || my_menu()=="activation_code" || my_menu()=="pay"){
			?>
			<li><a class="menuitem ui-accordion-header ui-helper-reset ui-state-default ui-state-active ui-corner-top current" role="tab" aria-expanded="true" aria-selected="true" tabindex="0"><span class="ui-icon ui-icon-triangle-1-e"></span>商家账户</a>
					<ul class="submenu ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" style="height: auto; " >
						<li><a class="<?=my_menu()=="account"?"active":""?>" href="<?=site_url('/account')?>" >账户管理</a></li>
						<li><a class="<?=my_menu()=="management_fees" || my_menu()=="pay"?"active":""?>" href="<?=site_url('/management_fees')?>" >在线支付管理费</a></li>
						<li><a class="<?=my_menu()=="activation_code"?"active":""?>" href="<?=site_url('/activation_code')?>" >充值密码支付管理费</a></li>
						<li><a class="<?=my_menu()=="free_stock_market"?"active":""?>" href="<?=site_url('/free_stock_market')?>">我的自由股</a></li>
						<li><a class="<?=my_menu()=="buy_free_stock"?"active":""?>"  href="<?=site_url('/buy_free_stock')?>">追加自由股</a></li>
						<li><a class="<?=my_menu()=="password"?"active":""?>" href="<?=site_url('/password')?>" >密码变更</a></li>
						<li><a class="<?=my_menu()=="password_protection"?"active":""?>"  href="<?=site_url('/password_protection')?>" >密码保护</a></li>
						<li><a class="<?=my_menu()=="bank_account"?"active":""?>"  href="<?=site_url('/bank_account')?>">收款账号</a></li>
						<li><a class="<?=my_menu()=="activation_account"?"active":""?>" href="<?=site_url('/activation_account')?>">参与赠送积分</a></li>
					</ul>
				</li>
				<?
}	
			if(my_menu()=="my_team" ||  my_menu()=="tree" || my_menu()=="registration" || my_menu()=="spread" ){
			?>
				<li><a class="menuitem ui-accordion-header ui-helper-reset ui-state-default ui-state-active ui-corner-top current" role="tab" aria-expanded="true" aria-selected="true" tabindex="0"><span class="ui-icon ui-icon-triangle-1-e"></span>销售管理</a>
					<ul class="submenu ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" style="height: auto; " >
						<li><a class="<?=my_menu()=="my_team"?"active":""?>"  href="<?=site_url('/my_team')?>">朋友圈</a></li>
						<!--<li><a class="<?=my_menu()=="tree"?"active":""?>" href="<?=site_url('/tree')?>">全体队友</a></li>-->
						<li><a class="<?=my_menu()=="registration"?"active":""?>"  href="<?=site_url('/registration')?>">免费注册</a></li>
						<li><a class="<?=my_menu()=="spread"?"active":""?>"  href="<?=site_url('/spread')?>">分享朋友圈</a></li>
					</ul>
				</li>
				<?
			}
				if(my_menu()=="bonus" ||  my_menu()=="dividend"   ||  my_menu()=="recommend"   ||  my_menu()=="management" ){
						?>
				<li><a class="menuitem ui-accordion-header ui-helper-reset ui-state-default ui-state-active ui-corner-top current" role="tab" aria-expanded="true" aria-selected="true" tabindex="0"><span class="ui-icon ui-icon-triangle-1-e"></span>赠送积分</a>
					<ul class="submenu ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" style="height: auto; " >
						<li><a class="<?=my_menu()=="bonus"?"active":""?>" href="<?=site_url('/bonus')?>">奖金总览</a></li>
						<li><a class="<?=my_menu()=="dividend"?"active":""?>" href="<?=site_url('/dividend')?>">积分赠送明细</a></li>
						<li><a class="<?=my_menu()=="recommend"?"active":""?>" href="<?=site_url('/recommend')?>">销售赠送积分</a></li>
						<li><a class="<?=my_menu()=="management"?"active":""?>" href="<?=site_url('/management')?>">管理赠送积分</a></li>
					</ul>
				</li>
<?
			}
						if(my_menu()=="electronic_transfer" ||  my_menu()=="electronic"   ||  my_menu()=="electronic_get"   ||  my_menu()=="electronic_consumption"  ||  my_menu()=="cash_to_electronic"   ||  my_menu()=="cash_to_shopping"   ||  my_menu()=="cash"   ||  my_menu()=="free_currency"  ||  my_menu()=="free_gold"){
						?>
				<li><a class="menuitem ui-accordion-header ui-helper-reset ui-state-default ui-state-active ui-corner-top current" role="tab" aria-expanded="true" aria-selected="true" tabindex="0"><span class="ui-icon ui-icon-triangle-1-e"></span>积分记录</a>
					<ul class="submenu ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" style="height: auto; ">	
						<li><a class="<?=my_menu()=="electronic"?"active":""?>"  href="<?=site_url('/electronic')?>">电子积分转账记录</a></li>
						<li><a class="<?=my_menu()=="electronic_get"?"active":""?>" href="<?=site_url('/electronic_get')?>">电子积分获得记录</a></li>
						<li><a class="<?=my_menu()=="electronic_consumption"?"active":""?>" href="<?=site_url('/electronic_consumption')?>">电子积分消费记录</a></li>
						<li><a class="<?=my_menu()=="electronic_transfer"?"active":""?>" href="<?=site_url('/electronic_transfer')?>">电子积分转账</a></li>
						<li><a class="<?=my_menu()=="cash_to_electronic"?"active":""?>" href="<?=site_url('/cash_to_electronic')?>">现金积分转电子积分</a></li>
						<li><a class="<?=my_menu()=="cash_to_shopping"?"active":""?>" href="<?=site_url('/cash_to_shopping')?>">现金积分转购物积分</a></li>
						<li><a class="<?=my_menu()=="cash"?"active":""?>" href="<?=site_url('/cash')?>">现金积分明细</a></li>
						<li><a class="<?=my_menu()=="free_currency"?"active":""?>" href="<?=site_url('/free_currency')?>">自由积分明细</a></li>
						<li><a class="<?=my_menu()=="free_gold"?"active":""?>" href="<?=site_url('/free_gold')?>">自由金明细</a></li>
					</ul>
				</li>
				<?
						}	
						if(my_menu()=="electronic_currency_market" ||  my_menu()=="sell_electronic_currency"   ||  my_menu()=="cash_currency_market"   ||  my_menu()=="sell_cash_currency"  ||  my_menu()=="free_currency_market"  ||  my_menu()=="sell_free_currency"){
							$system_switch=my_system_switch();
						?>
				<li><a class="menuitem ui-accordion-header ui-helper-reset ui-state-default ui-state-active ui-corner-top current" role="tab" aria-expanded="true" aria-selected="true" tabindex="0"><span class="ui-icon ui-icon-triangle-1-e"></span>抢购积分</a>
					<ul class="submenu ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" style="height: auto; " role="tabpanel">
					<?
						if($system_switch->cash_currency==1){
						?>
						<li><a class="<?=my_menu()=="cash_currency_market"?"active":""?>"  href="<?=site_url('/cash_currency_market')?>">抢购现金积分</a></li>
						<li><a class="<?=my_menu()=="sell_cash_currency"?"active":""?>"  href="<?=site_url('/sell_cash_currency')?>">出售现金积分</a></li>
				<?
						}
					if($system_switch->electronic_currency==1){
						?>
						<li><a class="<?=my_menu()=="electronic_currency_market"?"active":""?>"  href="<?=site_url('/electronic_currency_market')?>">电子积分市场</a></li>
						<li><a class="<?=my_menu()=="sell_electronic_currency"?"active":""?>"  href="<?=site_url('/sell_electronic_currency')?>">出售电子积分</a></li>
						<?
						}
						if($system_switch->free_currency==1){
						?>
						<li><a class="<?=my_menu()=="free_currency_market"?"active":""?>"  href="<?=site_url('/free_currency_market')?>">自由积分市场</a></li>
						<li><a class="<?=my_menu()=="sell_free_currency"?"active":""?>"  href="<?=site_url('/sell_free_currency')?>">出售自由积分</a></li>
						<?
						}
						?>
					</ul>
				</li>
				<?
					}
						
						if(my_menu()=="plan"){
						?>
				<li><a class="menuitem ui-accordion-header ui-helper-reset ui-state-default ui-state-active ui-corner-top current" role="tab" aria-expanded="true" aria-selected="true" tabindex="0"><span class="ui-icon ui-icon-triangle-1-e"></span>保本计划</a>
					<ul class="submenu ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" style="height: auto; ">	
						<li><a class="<?=my_menu()=="plan"?"active":""?>"  href="<?=site_url('/plan')?>">保本计划</a></li>
					</ul>
				</li>
				<?
						}
if(my_menu()=="notice" ||  my_menu()=="help"   ||  my_menu()=="message"){
				?>
				<!--<li><a class="menuitem ui-accordion-header ui-helper-reset ui-state-default ui-state-active ui-corner-top current" role="tab" aria-expanded="true" aria-selected="true" tabindex="0"><span class="ui-icon ui-icon-triangle-1-e"></span>信息管理</a>
					<ul class="submenu ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" style="height: auto; " role="tabpanel">
						<li><a class="<?=my_menu()=="notice"?"active":""?>"  href="<?=site_url('/notice')?>">系统公告</a></li>
						<li><a class="<?=my_menu()=="help"?"active":""?>"  href="<?=site_url('/help')?>">帮助中心</a></li>
						<li><a class="<?=my_menu()=="message"?"active":""?>"  href="<?=site_url('/message')?>">留言板</a></li>
					</ul>
				</li>-->
				<?
}
				?>
			</ul>
		</div>
	</div>
</div>