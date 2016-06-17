<?=isset($admin_header) ? $admin_header : ''?>
<div class="app">

	
<?=isset($admin_menu) ? $admin_menu : ''?>
	<section class="layout">
	
<?=isset($admin_left) ? $admin_left : ''?>
	

		<section class="main-content">

			<header class="header navbar bg-default">
				<ul class="nav navbar-nav">
					<li class="active">
						<a href="javascript:;">保本计划付款</a>
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
																		<input type="hidden" name="CardHolder" value="<?=$row->bank_name?>" />
																		<input type="hidden" name="CardNo" value="<?=$row->account?>" />
																		<input type="hidden" name="BankName" value="<?=$row->bank_name?>" />
																		<input type="hidden" name="BranchName" value="<?=$row->branch_name?>" />
																		<input type="hidden" name="Province" value="<?=$row->province?>" />
																		<input type="hidden" name="City" value="<?=$row->city?>" />
																		<input type="hidden" name="Amount" value="<?=$row->money?>" />
																		<input type="hidden" name="SignMD5" value="<?=md5($config['mer_code'].$row->no.$row->bank_name.$row->account.$row->bank_name.$row->money.$config['mer_key'])?>" />
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
		   MerCode: "required",
		   MerCashNo: "required",
		   CardHolder: "required",
		   CardNo: "required",
		   BankName: "required",
		   BranchName: "required",
		   Province: "required",
		   City: "required",
		   Amount: "required",
		   SignMD5: "required"
		},
		messages: {
		   MerCode: "请输入交易账户号",
		   MerCashNo: "请输入提现订单号",
		   CardHolder: "请输入提现人姓名",
		   CardNo: "请输入提现人银行卡号",
		   BankName: "请输入银行名称",
		   BranchName: "请输入开户行名称",
		   Province: "请输入开卡省份",
		   City: "请输入开卡城市",
		   City: "请输入转帐金额",
		   SignMD5: "请输入Md5"
	   }
	});
});
</script>
<?=isset($admin_footer) ? $admin_footer : ''?>