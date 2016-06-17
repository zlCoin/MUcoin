<?=isset($admin_header) ? $admin_header : ''?>
<div class="app">
<?=isset($admin_menu) ? $admin_menu : ''?>
	<section class="layout">
<?=isset($admin_left) ? $admin_left : ''?>
		<section class="main-content">
			<header class="header navbar bg-default">
				<ul class="nav navbar-nav">
					<li class="active">
						<a href="javascript:;">会员充值</a>
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
											<form id="theForm" name="theForm" role="form" class="form-horizontal bordered-group"  method="post" action="<?=site_url('/admin/member_recharge/recharge_submit')?>">
												<div class="form-group">
													<label class="col-sm-2 control-label">会员帐号</label>
													<div class="col-sm-10">
														<input type="text" class="form-control" name="user" />
													</div>
												</div>  
												<div class="form-group">
													<label class="col-sm-2 control-label">充值类型</label>
													<div class="col-sm-10">
													<input type="radio" checked value="wallet_currency" name="type" />&nbsp;报单积分
														<input type="radio" checked value="electronic_currency" name="type" />&nbsp;原始积分&nbsp;&nbsp;<input type="radio" value="cash_currency" checked name="type" />&nbsp;奖金积分
													</div>
												</div>  
												<div class="form-group">
													<label class="col-sm-2 control-label">增减类型</label>
													<div class="col-sm-10">
                                                        <select name="cz_type" id="cz_type">
														  <option value="" selected="selected">请选择类型</option>
														   <option value="increase">增加</option>
														   <option value="deduction">扣除</option>
														 </select>
													</div>
												</div> 
												<div class="form-group">
													<label class="col-sm-2 control-label">充值数量</label>
													<div class="col-sm-10">
														<input type="text" class="form-control" name="number" />
													</div>
												</div>  
												<div class="form-group">
													<label class="col-sm-2 control-label">备注</label>
													<div class="col-sm-10">
														<textarea class="form-control" rows="3" name="remark"></textarea>
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
			user: {
				required:true,
				remote:{
					url: "/admin/member_recharge/check_member",
					type: 'post',
					dataType: 'json',
					data:{
						user : function(){
							return jQuery("input[name=user]").val();
						}
					},
				}
			},
			number: {
				required:true,
				number:true
			},
         cz_type: {
				required:true
			}

		},
		messages: {
			user: {
				required:"请输入会员账号！",
				remote:'账号不存在！'
			},
			number:  {
				required:"请填写充值数量",
				number:"必须是数字"
			},
		  cz_type:  {
				required:"请选择增减类型"
			}
	   }
	});
});
</script>
<?=isset($admin_footer) ? $admin_footer : ''?>