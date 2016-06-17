<?=isset($admin_header) ? $admin_header : ''?>
<div class="app">
<?=isset($admin_menu) ? $admin_menu : ''?>
	<section class="layout">
<?=isset($admin_left) ? $admin_left : ''?>
		<section class="main-content">
			<header class="header navbar bg-default">
				<ul class="nav navbar-nav">
					<li class="active">
						<a href="javascript:;">参数设置</a>
					</li>			
				</ul>
			</header>
			<div class="content-wrap">
				<div class="row">
					<div class="col-md-12">
						<section id="elements" class="tab-pane active">
							<div class="row">
							    <div class="col-lg-12">
							        <section class="panel">
							            <div class="panel-body">
							                <form id="theForm" name="theForm" role="form" class="form-horizontal bordered-group"  method="post" action="<?=site_url('/admin/system_set/set_submit')?>">
												<div class="form-group">
							                        <label class="col-sm-2 control-label">每周释放百分比</label>
							                        <div class="col-sm-2">
							                            <input type="text" class="form-control" value="<?=$row->invest_limit?>" name="invest_limit" id="invest_limit">
							                        </div>
							                    </div>  
												<div class="form-group">
							                        <label class="col-sm-2 control-label">推荐奖</label>
							                        <div class="col-sm-2">
							                            <input type="text" class="form-control" value="<?=$row->bonus?>" name="bonus" id="bonus">
							                        </div>
							                    </div>  
												<div class="form-group">
							                        <label class="col-sm-2 control-label">周积分赠送</label>
							                        <div class="col-sm-2">
							                            <input type="text" class="form-control" value="<?=$row->day_dividend?>" name="day_dividend" id="day_dividend">
							                        </div>
							                    </div>  
											 
												 
												 
												<div class="form-group">
													<label class="col-sm-2 control-label">1积分</label>
													<div class="col-sm-2">
														<div class="input-group">
															<input type="text" class="form-control" value="<?=$row->rmb?>" name="rmb" id="rmb">
															<div class="input-group-addon">RMB</div>
														</div>
													</div>
												</div>
												<div class="form-group">
							                        <label class="col-sm-2 control-label"></label>
							                        <div class="col-sm-10">
							                            <button class="btn btn-default" type="submit" >提交</button>
							                        </div>
							                    </div> 
							                </form>
							            </div>
							        </section>
							    </div>
							</div>
						</section>
 
					</div>
				</div>
			</div>
		<div class="site-overlay"></div></section>
	</section>
</div>
<script>
$(document).ready(function() {
	$("#theForm").validate({
	   rules: {
		   invest_limit: "required",
		   bonus: "required",
		   day_dividend: "required",
		   dividend_time: "required",
		   cap_amount: "required",
		   stock_limit: "required",
		   rmb: "required"
		},
		messages: {
		   invest_limit: "请输入投资额度",
		   bonus: "请输入推荐奖",
		   day_dividend: "请输入日积分赠送",
		   dividend_time: "请输入积分赠送次数",
		   cap_amount: "请输入培育金日封顶金额",
		   stock_limit: "请输入静态持股上限",
		   rmb: "请输入积分兑换RMB比例"
	   }
	});
});
</script>
<?=isset($admin_footer) ? $admin_footer : ''?>