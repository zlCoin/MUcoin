<?=isset($admin_header) ? $admin_header : ''?>
<div class="app">
<?=isset($admin_menu) ? $admin_menu : ''?>
	<section class="layout">
<?=isset($admin_left) ? $admin_left : ''?>
		<section class="main-content">
			<header class="header navbar bg-default">
				<ul class="nav navbar-nav">
					<li class="active">
						<a href="javascript:;">用户管理</a>
					</li>			
				</ul>
			</header>
			<div class="content-wrap">
                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <div class="panel-body">
                                <form id="theForm" name="theForm" role="form" class="form-horizontal bordered-group"  method="post" action="<?=site_url('/admin/member/modify_submit')?>">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">帐号</label>
                                        <div class="col-sm-10"> <label class="control-label"><?=$row->user?></label>&emsp;<a class="btn btn-info" href="<?=site_url('/admin/member/reg_ec_usertb/id/'. $row->member_id)?>">同步到商城</a></div>
                                    </div>
                                    <div class="form-group">
                                         <label class="col-sm-2 control-label">选择套餐</label>
                                        <div class="col-sm-3">
                                            <select name="tc_price" class="form-control">
                                                <option value="">请选择套餐</option>
                                                <?php foreach (fun_switch_package() as $item => $val):?>
                                                    <option value="<?php echo $item; ?>" <?php if($row->tc_price == $val['numbs']){ echo "selected='selected'"; }?>><?php echo $val['numbs'].'/'.$val['version']; ?></option>>
                                                <?php endforeach?>
                                            </select>
                                        </div>
                                    </div>
									<div class="form-group">
										 <label class="col-sm-2 control-label">密码</label>
                                        <div class="col-sm-3">
                                            <input type="password" class="form-control" name="password" id="password">
                                        </div>
                                    </div>  
									<div class="form-group">
										 <label class="col-sm-2 control-label">再输入一次</label>
                                        <div class="col-sm-3">
                                            <input type="password" class="form-control" name="password_again" id="password_again">
                                        </div>
                                    </div>
									<div class="form-group">
										<label class="col-sm-2 control-label">二级密码</label>
                                        <div class="col-sm-3">
                                            <input type="password" class="form-control" name="password1" id="password1">
                                        </div>
                                    </div>  
									<div class="form-group">
                                        <label class="col-sm-2 control-label">姓名</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" value="<?=$row->name?>" name="name" id="name">
                                        </div>
                                    </div>  
									<div class="form-group">
                                        <label class="col-sm-2 control-label">手机</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" value="<?=$row->mobile?>" name="mobile" id="mobile">
                                        </div>
                                    </div>  
									<div class="form-group">
                                        <label class="col-sm-2 control-label">邮箱</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" value="<?=$row->email?>" name="email" id="email">
                                        </div>
                                    </div>  
									<div class="form-group">
                                        <label class="col-sm-2 control-label">QQ</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" value="<?=$row->qq?>" name="qq" id="qq">
                                        </div>
                                    </div>  
									<div class="form-group">
                                        <label class="col-sm-2 control-label">原始积分</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" value="<?=$row->electronic_currency?>" name="electronic_currency" id="electronic_currency" readonly>
                                        </div>
                                    </div>  
									<div class="form-group">
                                        <label class="col-sm-2 control-label">奖金积分</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" value="<?=$row->cash_currency?>" name="cash_currency" id="cash_currency" readonly>
                                        </div>
                                    </div>  
									<div class="form-group">
                                        <label class="col-sm-2 control-label">资产积分</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" value="<?=$row->free_currency?>" name="free_currency" id="free_currency" readonly>
                                        </div>
                                    </div>  

									<div class="form-group">
                                        <label class="col-sm-2 control-label">报单积分</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" value="<?=$row->wallet_currency?>" name="wallet_currency" id="wallet_currency" readonly>
                                        </div>
                                    </div>  
									<div class="form-group">
                                        <label class="col-sm-2 control-label">冻结资产</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" value="<?=$row->dj_price?>" name="dj_price" id="dj_price" readonly>
                                        </div>
                                    </div>  
									<div class="form-group">
                                        <label class="col-sm-2 control-label">登录</label>
                                        <div class="col-sm-10">
                                            <input type="radio" <?=$row->lock==0?"checked":""?> value="0" id="lock0" name="lock">&nbsp;正常&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" <?=$row->lock==1?"checked":""?> value="1" id="lock1" name="lock">&nbsp;冻结
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label class="col-sm-2 control-label">备注</label>
                                        <div class="col-sm-3">
                                            <textarea  id="remark" name="remark" rows="3" class="form-control"><?=$row->remark?></textarea>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label class="col-sm-2 control-label"></label>
                                        <div class="col-sm-10">
                                            <button class="btn btn-default" type="submit" >提交</button>	
											<input type="hidden" id="id" name="id" value="<?=$row->member_id?>">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </section>
                    </div>
                </div>
			</div>
            <div class="site-overlay"></div>
        </section>
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