<?php $this->load->view('header.php') ?>
<h2>免费注册</h2>
<br />
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary">
			<div class="panel-body">
				<?=isset($hint) ? $hint : ''?>
				<form id="theForm" name="theForm" method="post" action="<?=site_url('/registration/registration_submit')?>" class="form-horizontal form-groups-bordered validate">
					<div class="form-group">
						<label class="col-sm-2 control-label">（账号）手机号：</label>
						<div class="col-sm-2">
							<input type="text" class="form-control" name="user_name" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">套餐：</label>
						<div class="col-sm-2">
							<select class="form-control" name="tc_price">
								<?php foreach (fun_switch_package() as $item => $val):?>
									<option value="<?php echo $item; ?>"><?php echo $val['numbs'].'/'.$val['version']; ?></option>>
								<?php endforeach?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">真实姓名：</label>
						<div class="col-sm-2">
							<input type="text" class="form-control" name="name" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">登录密码：</label>
						<div class="col-sm-2">
							<input type="password" class="form-control" name="password" id="password" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">确认登录密码：</label>
						<div class="col-sm-2">
							<input type="password" class="form-control" name="password_again" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">交易密码：</label>
						<div class="col-sm-2">
							<input type="password" class="form-control" name="password1" id="password1" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">确认交易密码：</label>
						<div class="col-sm-2">
							<input type="password" class="form-control" name="password1_again" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">身份证号：</label>
						<div class="col-sm-3">
							<input type="text" class="form-control" name="id" />
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-5">
							<input type="submit" class="btn btn-primary" value="提交" />
						</div>
					</div>
                </form>
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function() {
	jQuery.validator.addMethod("phone", function(value,element) {
			var mobile = /^1(\d{10})$/;
			return this.optional(element) || mobile.test(value);	
	}, "请正确填写手机号");
	$("#theForm").validate({
	   rules: {
			user_name: {
				required: true,
				phone: true,
				remote:{
					type:"POST",
					url:"<?=site_url('/registration/verify_user')?>",
					data:{
						user_name:function(){return $("input[name='user_name']").val();}
					} 
				}
		   	},
			password: {
				required: true,
				minlength: 8
			},
			password_again: {
				required: true,
				minlength: 8,
				equalTo: "#password"
			},
			password1: {
				required: true,
				minlength: 8
			},
			password1_again: {
				required: true,
				minlength: 8,
				equalTo: "#password1"
			},
		   	name: "required"
		},
		messages: {
			user_name: {
				required: "请输入手机号",
				phone: jQuery.format("请输入正确的手机号！"),
				remote: jQuery.format("账号已经存在")
			},
			password: {
				required: "请输入新登录密码",
				minlength: jQuery.format("新登录密码不能小于{0}个字 符")
			},
			password_again: {
				required: "请输入确认登陆密码",
				minlength:jQuery.format("确认登陆密码不能小于{0}个字 符"),
				equalTo: "两次输入密码不一致不一致"
			},
			password1: {
				required: "请输入二级密码",
				minlength: jQuery.format("二级密码不能小于{0}个字 符")
			},
			password1_again: {
				required: "请输入确认二级密码",
				minlength:jQuery.format("确认二级密码不能小于{0}个字 符"),
				equalTo: "两次输入二级密码不一致"
			},
			name: "请输入姓名"
		}
	});
});
</script>
<?php $this->load->view('footer.php') ?>