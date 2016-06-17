<?php $this->load->view('header.php') ?>
<h2>商家帐户</h2>
<br />
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary">
			<div class="panel-body">
				<?=isset($hint) ? $hint : ''?>
				<form class="form-horizontal form-groups-bordered validate" method="post" action="<?=site_url('/account/modify_submit')?>" novalidate="novalidate" >
					<div class="form-group">
						<label class="col-sm-3 control-label">会员账号:</label>
						<div class="col-sm-3">
							<input type="text" value="<?=$row->user ?>" class="form-control" disabled>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">姓名：</label>
						<div class="col-sm-3">
							<input type="text" value="<?=$row->name ?>" class="form-control" disabled>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">手机：</label>
						<div class="col-sm-3">
							<input type="text" value="<?=$row->mobile ?>" class="form-control" disabled>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">email:</label>
						<div class="col-sm-3">
							<input type="text" class="form-control" name="email" value="<?=$row->email?>"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">QQ:</label>
						<div class="col-sm-3">
							<input type="text" class="form-control" id="qq" name="qq" value="<?=$row->qq?>"/>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<input type="submit" class="btn btn-primary" value="提交" />
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('footer.php') ?>