<?=isset($admin_header) ? $admin_header : ''?>
<div class="app">
<?=isset($admin_menu) ? $admin_menu : ''?>
	<section class="layout">
<?=isset($admin_left) ? $admin_left : ''?>
		<section class="main-content">
			<header class="header navbar bg-default">
				<ul class="nav navbar-nav">
					<li class="active">
						<a href="javascript:;">用户</a>
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
                                            <form id="theForm" name="theForm" role="form" class="form-horizontal bordered-group"  >
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">帐号</label>
                                                    <div class="col-sm-10"><?=$row->user?></div>
                                                </div>   
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">姓名</label>
                                                    <div class="col-sm-10"><?=$row->name?></div>
                                                </div>  
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">手机</label>
                                                    <div class="col-sm-10"><?=$row->mobile?></div>
                                                </div> 
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">奖金钱包</label>
                                                    <div class="col-sm-10"><?=$row->cash_currency?></div>
                                                </div>  
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">静态资产包</label>
                                                    <div class="col-sm-10"><?=$row->free_currency?></div>
                                                </div>  
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">报单钱包</label>
                                                    <div class="col-sm-10"><?=$row->wallet_currency?>
                                                    </div>
                                                </div>  
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">原始积分</label>
                                                    <div class="col-sm-10"><?=$row->electronic_currency?></div>
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
		   name: "required"
		},
		messages: {
		   name: "请输入帐号"
	   }
	});
});
</script>
<?=isset($admin_footer) ? $admin_footer : ''?>