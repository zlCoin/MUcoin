<?php $this->load->view('header.php') ?>
<h2>密码变更</h2>
<br />
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary">
			<div class="panel-body">
				<?=isset($hint) ? $hint : ''?>
				<form id="theForm" name="theForm" class="form-horizontal form-groups-bordered validate" method="post" action="<?=site_url('/password/password_submit')?>" >
					<div class="form-group">
						<label class="col-sm-3 control-label">会员账号:</label>
						<div class="col-sm-3">
							<input type="text" class="form-control" value="<?=$row->user?>" disabled />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">原登陆密码:</label>
						<div class="col-sm-3">
							<input type="password" class="form-control" id="original_password" name="original_password" />
 						</div>
					</div>
                  <div class="form-group">
						<label class="col-sm-3 control-label">新登陆密码:</label>
						<div class="col-sm-3">
							<input type="password" class="form-control" name="password" id="password"/>
 						</div>
					</div>

					 <div class="form-group">
						<label class="col-sm-3 control-label">确认登陆密码:</label>
						<div class="col-sm-3">
							<input type="password" class="form-control" name="password_again" id="password_again" />
 						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<input type="submit" value="提交" class="btn btn-primary" />
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function() {
	$("#theForm").validate({
		rules: {
			original_password: 'required',
			password: {
				required: true,
				minlength: 6
			},
			password_again: {
				required: true,
				minlength: 6,
				equalTo: "#password"
			},
		},
		messages: {
			original_password: '请输入原登陆密码',
			password: {
				required: "请输入新登陆密码",
				minlength: jQuery.format("新登陆密码不能小于{0}个字 符")
			},
			password_again: {
				required: "请输入确认登陆密码",
				minlength:jQuery.format("确认登陆密码不能小于{0}个字 符"),
				equalTo: "两次输入密码不一致"
			},    
		}
	});
});
</script>
<?php $this->load->view('footer.php') ?>