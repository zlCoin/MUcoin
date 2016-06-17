<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>会员注册 - 众联积分</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="/css/style.css" rel='stylesheet' type='text/css' />
<script type="text/javascript" src="/js/jquery.min.js"></script>
<script type="text/javascript" src="/js/layer/layer.js"></script>
</head>
<body>
<div class="login-form" style="width: 320px;">
	<div class="head-info">新会员注册</div>
	<div class="clear"></div>
	<form class="reg" method="post">
		<input type="text" class="text" name="recommend_user" placeholder="推荐人账号" />
		<input type="text" class="text" name="parent_user" placeholder="节点人账号" />
		<select name="tc_price">
			<option value="">请选择套餐</option>
			<?php foreach (fun_switch_package() as $item => $val):?>
				<option value="<?php echo $item; ?>"><?php echo $val['numbs'].'/'.$val['version']; ?></option>>
			<?php endforeach?>
		</select>
		<input type="text" class="text" name="user" placeholder="会员账号" />
		<input type="text" class="text" name="name" placeholder="姓名" />
		<input type="text" class="text" name="mobile" placeholder="手机" >
		<input type="password" class="text" name="password" placeholder="登录密码" >
		<input type="password" class="text" name="password_again" placeholder="确认登录密码" >
		<input type="password" class="text" name="password1" placeholder="二级密码" >
		<input type="password" class="text" name="password1_again" placeholder="确认二级密码" />
		<input type="text" class="text" name="verifi" placeholder="验证码" />
		<img src="<?php echo site_url('index/verifi'); ?>" alt="点击更换验证码" style="width:220px;height:50px;cursor:pointer;" class="verfiImg" />
		<div class="signin"><div class="RegSubmit">马上注册</div></div>
	</form>
</div>
<div class="copy-rights">
	<p>Copyright &copy; 2016.Company name All rights reserved.</p>
</div>
<script>
jQuery(function(){
	jQuery('.verfiImg').click(function(){
		jQuery(this).attr('src', <?php echo "'" . site_url('index/verifi') . "/'"; ?> + Math.random());
	})
	jQuery(".RegSubmit").click(function(){
		jQuery.post('<?=site_url("/reg/reg_submit")?>',{parent_user:jQuery('input[name=parent_user]').val(),recommend_user:jQuery('input[name=recommend_user]').val(),user:jQuery('input[name=user]').val(),name:jQuery('input[name=name]').val(),password:jQuery('input[name=password]').val(),password_again:jQuery('input[name=password_again]').val(),password1:jQuery('input[name=password1]').val(),password1_again:jQuery('input[name=password1_again]').val(),mobile:jQuery('input[name=mobile]').val(),tc_price:jQuery('select[name=tc_price]').val(),verifi:jQuery('input[name=verifi]').val()},function(data){
			if (data.status) {
				layer.msg(data.info);
				setTimeout(function(){
					window.location.href = '/';
				},2000);
			}else{
				layer.msg(data.info);
			}
		})
	})
})
</script>
</body>
</html>