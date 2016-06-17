<?php $this->load->view('header.php') ?>
<h2>二级密码</h2>
<br />
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary">
			<div class="panel-body">
			<div class="block ">
			<?=isset($hint) ? $hint : ''?>
				<form id="theForm" name="theForm" class="form-horizontal form-groups-bordered validate" method="post" action="<?=site_url('/password2/password2_submit')?>" >
					<div class="form-group">
						<label class="col-sm-3 control-label">会员账号:</label>
						<div class="col-sm-3">
							<?=$row->user?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">二级密码:</label>
						<div class="col-sm-3">
							<input type="password" class="form-control"  name="password2" id="password2"/>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
						<input type="hidden" id="page" name="page" value="<?=$page?>">
						<input type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;" class="btn btn-primary">
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
	$("#theForm").validate({
	   rules: {
		   password2: {
			required: true,
			minlength: 5
		   }
		},
		messages: {
		   password2: {
			required: "请输入二级密码",
			minlength: jQuery.format("二级密码不能小于{0}个字符")
		   }  
	   }
	});
});
</script>
<?php $this->load->view('footer.php') ?>