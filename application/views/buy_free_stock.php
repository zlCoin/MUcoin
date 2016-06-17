<?php $this->load->view('header.php') ?>
<h2>追加自由股</h2>
<br />
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary">
			<div class="panel-body">
			<div class="block">
				<?=isset($hint) ? $hint : ''?>
				<form class="form-horizontal form-groups-bordered validate" method="post" action="<?=site_url('/buy_free_stock/buy_submit')?>" >
					<div class="form-group">
						<label class="col-sm-3 control-label">会员账号:</label>
						<div class="col-sm-3">
							<input type="text" value="<?=$row->user?>" class="form-control" disabled />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">电子积分:</label>
						<div class="col-sm-2">
							<div class="input-group">
								<input type="text" value="<?=$row->electronic_currency?>" class="form-control" disabled />
								<div class="input-group-addon">积分</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">套餐:</label>
						<div class="col-sm-2">
							<select class="form-control" name="keys">
								<?php foreach (fun_switch_package() as $item => $val):?>
									<option value="<?php echo $item; ?>"><?php echo $val['numbs'].'/'.$val['version']; ?></option>>
								<?php endforeach?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">持有数量:</label>
						<div class="col-sm-2">
							<div class="input-group">
								<input type="text" value="<?=$free_stock_count->number?>" class="form-control" disabled />
								<div class="input-group-addon">股</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">持有上限:</label>
						<div class="col-sm-2">
							<div class="input-group">
								<input type="text" value="<?=$stock_max?>" class="form-control" disabled />
								<div class="input-group-addon">股</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<? if($row->state==1){ ?>
							<input class="btn btn-primary" type="submit" value="确定购买" />
							<? }else{ ?>
							<input class="btn btn-primary" type="button" value="没有激活" />
							<? } ?>
						</div>
					</div>
				</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('footer.php') ?>