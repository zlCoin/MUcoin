<?php $this->load->view('header.php') ?>
<h2>朋友圈密码修改</h2>
<br />
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary">
			<div class="panel-body">
			<div class="block ">
			<?=isset($hint) ? $hint : ''?>
				 <form id="theForm" name="theForm" method="post" action="<?=site_url('/team_password_controller/TeamPassword_Submit')?>" class="form-horizontal form-groups-bordered validate" >
	        <table class="table table-bordered table-striped datatable">
					<tr>
						<td>
							<label>
								会员账号:</label>
						</td>
						<td>
							<select class="form-control" id="TeamMember" name="TeamMember" >
								<option value="">请选择</option>
									<?
										foreach($TeamMember as $key=>$t){
											
											if ($TeamMemberSelected == $t)
											{
									?>
												<option value="<?=$key?>" selected="selected"> <?=$t?> </option>
									<?
											}
											else
											{
												?>
												
												<option value="<?=$key?>" > <?=$t?> </option>
												<?
											}
										}
									?>
							</select>						
						</td>
					</tr>	
					<tr>
						<td>
							<label>
								新登陆密码:</label>
						</td>
						<td>
							<input type="password" class="form-control"  name="password" id="password" />
						</td>
					</tr>
					<tr>
						<td>
							<label>
								确认登陆密码:</label>
						</td>
						<td>
							<input type="password" class="form-control" name="password_again" id="password_again" value=""/>
						</td>
					</tr>
					<tr>
						<td>
							<label>
								二级密码:</label>
						</td>
						<td>
							<input type="password" class="form-control"  name="password1" id="password1"/>
						</td>
					</tr>
					<tr>
						<td>
							<label>
								确认二级密码:</label>
						</td>
						<td>
							<input type="password" class="form-control"  name="password1_again" id="password1_again"/>
						</td>
					</tr>
					<tr>
						<td>
							
						</td>
						<td>
						<input type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;" class="btn btn-blue">
						</td>
					</tr>
				</table>
				</form>	
				</div>
			</div>
		</div>
	</div>
</div>
<script>

$().ready(function() {
// 在键盘按下并释放及提交后验证提交表单
  $("#theForm").validate({
	    rules: {
	      
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
		  password1_again: {
	        required: true,
	        minlength: 8,
	        equalTo: "#password1"
	      },
		  TeamMember: {
	        required: true
	      }
	    },
	    messages: {
	      
	      password: {
	        required: "请输入新密码",
	        minlength: "密码长度不能小于 8 个字母"
	      },
	      password_again: {
	        required: "请再次输入新密码",
	        minlength: "密码长度不能小于 8 个字母",
	        equalTo: "两次密码输入不一致"
	      },
		  password1: {
	        required: "请输入二级密码",
	        minlength: "密码长度不能小于 8 个字母"
	      },
	      password1_again: {
	        required: "请再次输入二级密码",
			minlength: "密码长度不能小于 8 个字母",
	        equalTo: "两次密码输入不一致"
	        
	      },
		  TeamMember: {
	        required: "请选择您要重置的用户"
	        
	      }
	     
	    }
	});
});
</script>
<?php $this->load->view('footer.php') ?>