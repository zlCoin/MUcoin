<?php $this->load->view('header.php') ?>
<h2>二级密码变更</h2>
<br />
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary">
			<div class="panel-body">
			<div class="block">
				<form class="form-horizontal form-groups-bordered">
					<div class="form-group">
						<label class="col-sm-3 control-label">会员账号:</label>
						<div class="col-sm-3"><label class="control-label"><?=$row->user?></label></div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">原二级密码:</label>
						<div class="col-sm-3"><input type="password" class="form-control" name="password" /></div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">新二级密码:</label>
						<div class="col-sm-3"><input type="password" class="form-control" name="new_password" /></div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">确认二级密码:</label>
						<div class="col-sm-3"><input type="password" class="form-control" name="new_password1" /></div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<input type="button" value="提交" class="btn btn-primary changePassword">
						</div>
					</div>
				</form>
			</div>
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function() {

	jQuery('.changePassword').click(function(){
		jQuery.post('/Password_protection/password_submit',{password:jQuery('input[name=password]').val(),new_password:jQuery('input[name=new_password]').val(),new_password1:jQuery('input[name=new_password1]').val()},function(data){
			if (data.status) {
				layer.msg(data.info);
				setTimeout(function(){
					window.location.href = '/Password_protection/';
				},1000);
			}else{
				layer.msg(data.info);
			}
		})
	})
});
</script>
<?php $this->load->view('footer.php') ?>