<?=isset($admin_header) ? $admin_header : ''?>
<div class="app">

	
<?=isset($admin_menu) ? $admin_menu : ''?>
	<section class="layout">
	
<?=isset($admin_left) ? $admin_left : ''?>
	

		<section class="main-content">

			<header class="header navbar bg-default">
				<ul class="nav navbar-nav">
					<li class="active">
						<a href="javascript:;">商城帐单付款</a>
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
													<form name="sendOrder" id="sendOrder" role="form" class="form-horizontal bordered-group"  method="post" action="https://payment.cai1pay.com/cashapp.aspx">
													<div class="form-group">
                                                            <label class="col-sm-2 control-label">帐号</label>
                                                            <div class="col-sm-10">
                                                                <?=$row->user?>
                                                            </div>
                                                        </div>  
														<div class="form-group">
                                                            <label class="col-sm-2 control-label">订单号</label>
                                                            <div class="col-sm-10">
                                                                <?=$row->no?>
                                                            </div>
                                                        </div>  
														<div class="form-group">
                                                            <label class="col-sm-2 control-label">金额</label>
                                                            <div class="col-sm-10">
                                                                <?=$row->money?>
                                                            </div>
                                                        </div>  
																
																<div class="form-group">
																		<label class="col-sm-2 control-label"></label>
																		<div class="col-sm-10">
																		<input type="hidden" name="MerCode" value="<?=$config['mer_code']?>" />
																<input type="hidden" name="MerCashNo" value="<?=$row->no?>" />
																<input type="hidden" name="CardHolder" value="<?=$member->bank_name?>" />
																<input type="hidden" name="CardNo" value="<?=$member->account?>" />
																<input type="hidden" name="BankName" value="<?=$member->bank_name?>" />
																<input type="hidden" name="BranchName" value="<?=$member->branch_name?>" />
																<input type="hidden" name="Province" value="<?=$member->province?>" />
																<input type="hidden" name="City" value="<?=$member->city?>" />
																<input type="hidden" name="Amount" value="<?=$row->money?>" />
																<input type="hidden" name="SignMD5" value="<?=md5($config['mer_code'].$row->no.$member->bank_name.$member->account.$member->bank_name.$row->money.$config['mer_key'])?>" />
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
		   user: "required",
		   name: "required",
		   password: {
			required: true,
			minlength: 5
		   },
		   password_again: {
			required: true,
			minlength: 5,
			equalTo: "#password"
		   },
		   role_id: "required"
		},
		messages: {
		   user: "请输入帐号",
		   name: "请输入姓名",
		   password: {
			required: "请输入密码",
			minlength: jQuery.format("密码不能小于{0}个字 符")
		   },
		   password_again: {
			required: "请输入确认密码",
			minlength: "确认密码不能小于5个字符",
			equalTo: "两次输入密码不一致不一致"
		   },
		   role_id: "请选择角色"
	   }
	});
});
</script>
<?=isset($admin_footer) ? $admin_footer : ''?>