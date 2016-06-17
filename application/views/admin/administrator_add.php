<?=isset($admin_header) ? $admin_header : ''?>
<div class="app">

	
<?=isset($admin_menu) ? $admin_menu : ''?>
	<section class="layout">
	
<?=isset($admin_left) ? $admin_left : ''?>
	

		<section class="main-content">

			<header class="header navbar bg-default">
				<ul class="nav navbar-nav">
					<li class="active">
						<a href="javascript:;">管理员新增</a>
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
                                                    <form id="theForm" name="theForm" role="form" class="form-horizontal bordered-group"  method="post" action="<?=site_url('/admin/administrator/add_submit')?>">
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">帐号</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" value="" name="user" id="user">
                                                            </div>
                                                        </div>  
														 <div class="form-group">
															 <label class="col-sm-2 control-label">密码</label>
                                                            <div class="col-sm-10">
                                                                <input type="password" class="form-control" value="" name="password" id="password">
                                                            </div>
                                                        </div>  
														<div class="form-group">
															 <label class="col-sm-2 control-label">再输入一次</label>
                                                            <div class="col-sm-10">
                                                                <input type="password" class="form-control" value="" name="password_again" id="password_again">
                                                            </div>
                                                        </div>
														<div class="form-group">
                                                            <label class="col-sm-2 control-label">姓名</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" value="" name="name" id="name">
                                                            </div>
                                                        </div>  
														<div class="form-group">
                                                            <label class="col-sm-2 control-label">手机</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" value="" name="mobile" id="mobile">
                                                            </div>
                                                        </div>  
														<div class="form-group">
                                                            <label class="col-sm-2 control-label">邮箱</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" value="" name="email" id="email">
                                                            </div>
                                                        </div>  
														<div class="form-group">
															 <label class="col-sm-2 control-label">选择角色</label>
                                                            <div class="col-sm-10">
                                                                <select class="form-control selectpicker" data-style="btn-primary" name="role_id" id="role_id">
																<?
																foreach($role as $key_role=>$val_role){
																?>
                                                                    <option value="<?=$key_role?>"><?=$val_role?></option>
																	<?
									}	
																?>
                                                                </select>
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