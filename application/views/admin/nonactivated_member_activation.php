<?=isset($admin_header) ? $admin_header : ''?>
<div class="app">
<?=isset($admin_menu) ? $admin_menu : ''?>
	<section class="layout">
<?=isset($admin_left) ? $admin_left : ''?>
		<section class="main-content">
			<header class="header navbar bg-default">
				<ul class="nav navbar-nav">
					<li class="active">
						<a href="javascript:;">激活会员</a>
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
                                <form class="form-horizontal bordered-group" method="post" action="">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">帐号</label>
                                    <div class="col-sm-2"><?=$member->user?></div>
                                </div>  
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">选择套餐</label>
                                    <div class="col-sm-5">
                                    	<select name="tc_price" class="form-control">
                                    		<option value="">请选择套餐</option>
											<?php foreach (fun_switch_package() as $item => $val):?>
											<option value="<?php echo $item; ?>" <?php if($val['numbs'] == $member->tc_price){ echo "selected='selected'"; }?>><?php echo $val['numbs'].'/'.$val['version']; ?></option>>
											<?php endforeach?>
                                    	</select>
                                    </div>
                                </div>
								<div class="form-group">
									<label class="col-sm-2 control-label"></label>
									<div class="col-sm-10">
										<input type="hidden" name="member_id" value="<?=$member->member_id?>" />
										<button class="btn btn-default activation" type="button" />激活</button>
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
			<div class="site-overlay"></div>
		</section>
	</section>
</div>
<?=isset($admin_footer) ? $admin_footer : ''?>
<script src="/js/layer/layer.js"></script>
<script>
jQuery(function(){
	jQuery(".activation").click(function(){
		jQuery.get('/admin/nonactivated_member/activation_submit/',{id:jQuery('input[name=member_id]').val(),tc:jQuery('select[name=tc_price]').val()},function(data){
			if (data.status) {
				layer.msg(data.info);
				setTimeout(function(){
					window.location.href = '/admin/nonactivated_member/';
				},1000);
			}else{
				layer.msg(data.info);
				return ;
			}
		})
	})
})
</script>