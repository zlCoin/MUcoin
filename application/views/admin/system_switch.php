<?=isset($admin_header) ? $admin_header : ''?>
<div class="app">

	
<?=isset($admin_menu) ? $admin_menu : ''?>
	<section class="layout">
	
<?=isset($admin_left) ? $admin_left : ''?>
	

		<section class="main-content">

			<header class="header navbar bg-default">
				<ul class="nav navbar-nav">
					<li class="active">
						<a href="javascript:;">开关设置</a>
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
                                                    <form id="theForm" name="theForm" role="form" class="form-horizontal bordered-group"  method="post" action="<?=site_url('/admin/system_switch/set_submit')?>">
														<div class="form-group">
                                                            <label class="col-sm-2 control-label">系统开关</label>
                                                            <div class="col-sm-10">
                                                                <input type="radio" <?=$row->system==1?"checked":""?> value="1" id="system1" name="system">&nbsp; 开启&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio"  <?=$row->system==0?"checked":""?> value="0" id="system0" name="system">&nbsp;关闭
                                                            </div>
                                                        </div>  
														<div class="form-group">
                                                            <label class="col-sm-2 control-label">电子积分市场开关</label>
                                                            <div class="col-sm-10">
                                                                <input type="radio" <?=$row->electronic_currency==1?"checked":""?> value="1" id="electronic_currency1" name="electronic_currency">&nbsp; 开启&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" <?=$row->electronic_currency==0?"checked":""?>  value="0" id="electronic_currency0" name="electronic_currency">&nbsp;关闭
                                                            </div>
                                                        </div> 
														<div class="form-group">
                                                            <label class="col-sm-2 control-label">现金积分市场开关</label>
                                                            <div class="col-sm-10">
                                                                <input type="radio" <?=$row->cash_currency==1?"checked":""?> value="1" id="cash_currency1" name="cash_currency">&nbsp; 开启&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" <?=$row->cash_currency==0?"checked":""?>  value="0" id="cash_currency0" name="cash_currency">&nbsp;关闭
                                                            </div>
                                                        </div> 
														<div class="form-group">
                                                            <label class="col-sm-2 control-label">自由积分市场开关</label>
                                                            <div class="col-sm-10">
                                                                <input type="radio" <?=$row->free_currency==1?"checked":""?> value="1" id="free_currency1" name="free_currency">&nbsp; 开启&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" <?=$row->free_currency==0?"checked":""?>  value="0" id="free_currency0" name="free_currency">&nbsp;关闭
                                                            </div>
                                                        </div> 
														<div class="form-group">
                                                            <label class="col-sm-2 control-label">日积分赠送开关</label>
                                                            <div class="col-sm-10">
                                                                <input type="radio" <?=$row->day_dividend==1?"checked":""?> value="1" id="day_dividend1" name="day_dividend">&nbsp; 开启&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio"  <?=$row->day_dividend==0?"checked":""?> value="0" id="system0" name="day_dividend">&nbsp;关闭
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
		   title: "required",
		   content: "required"
		},
		messages: {
		   title: "请输入标题",
		   content: "请输入内容"
	   }
	});
});
</script>
<?=isset($admin_footer) ? $admin_footer : ''?>