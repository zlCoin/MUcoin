<?=isset($admin_header) ? $admin_header : ''?>
<div class="app">

	
<?=isset($admin_menu) ? $admin_menu : ''?>
	<section class="layout">
	
<?=isset($admin_left) ? $admin_left : ''?>
	

		<section class="main-content">

			<header class="header navbar bg-default">
				<ul class="nav navbar-nav">
					<li class="active">
						<a href="javascript:;">管理员修改</a>
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
                                                    <form id="theForm" name="theForm" role="form" class="form-horizontal bordered-group"  method="post" action="<?=site_url('/admin/administrator/modify_submit')?>">
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">帐号</label>
                                                            <div class="col-sm-10">
                                                                <?=$row->user?>
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
                                                                <input type="text" class="form-control" value="<?=$row->name?>" name="name" id="name">
                                                            </div>
                                                        </div>  
														<div class="form-group">
                                                            <label class="col-sm-2 control-label">手机</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" value="<?=$row->mobile?>" name="mobile" id="mobile">
                                                            </div>
                                                        </div>  
														<div class="form-group">
                                                            <label class="col-sm-2 control-label">邮箱</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" value="<?=$row->email?>" name="email" id="email">
                                                            </div>
                                                        </div>  
														<div class="form-group">
															 <label class="col-sm-2 control-label">选择角色</label>
                                                            <div class="col-sm-10">
                                                                <select class="form-control selectpicker" data-style="btn-primary" name="role_id" id="role_id">
																<?
																foreach($role as $key_role=>$val_role){
																?>
                                                                    <option value="<?=$key_role?>" <?=$row->role_id==$key_role?"selected":""?>><?=$val_role?></option>
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
																<input type="hidden" id="id" name="id" value="<?=$row->admin_id?>">
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
		   name: "required",
		   password: {
			minlength: 5
		   },
		   password_again: {
			minlength: 5,
			equalTo: "#password"
		   },
		   role_id: "required"
		},
		messages: {
		   name: "请输入姓名",
		   password: {
			minlength: jQuery.format("密码不能小于{0}个字 符")
		   },
		   password_again: {
			minlength: "确认密码不能小于5个字符",
			equalTo: "两次输入密码不一致不一致"
		   },
		   role_id: "请选择角色"
	   }
	});
});
</script>
<?=isset($admin_footer) ? $admin_footer : ''?>