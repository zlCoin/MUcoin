<?php $this->load->view('header.php') ?>
<div class="row">
	<div class="col-sm-3 col-xs-6">
		<div class="tile-stats tile-aqua">
			<div class="icon"><i class="entypo-mail"></i></div>
			<div class="num" data-start="0" data-end="<?=number_format($member->cash_currency,2,'.',',')?>" data-postfix="" data-duration="1500" data-delay="1200"><?=number_format($member->cash_currency,2,'.',',')?></div>
			<h3>奖金积分</h3>
			<p>统计</p>
		</div>
	</div>
	<div class="col-sm-3 col-xs-6">
		<div class="tile-stats tile-cyan">
			<div class="icon"><i class="entypo-mail"></i></div>
			<div class="num" data-start="0" data-end="<?=number_format($member->free_currency,2,'.',',')?>" data-postfix="" data-duration="1500" data-delay="1200"><?=number_format($member->free_currency,2,'.',',')?></div>
			<h3>资产积分</h3>
			<p>统计</p>
		</div>
	</div>
	<div class="col-sm-3 col-xs-6">
		<div class="tile-stats tile-red">
			<div class="icon"><i class="entypo-mail"></i></div>
			<div class="num" data-start="0" data-end="<?=number_format($member->wallet_currency,2,'.',',')?>" data-postfix="" data-duration="1500" data-delay="1200"><?=number_format($member->wallet_currency,2,'.',',')?></div>
			<h3>报单积分</h3>
			<p>统计</p>
		</div>
	</div>


<div class="col-sm-3 col-xs-6">
		<div class="tile-stats tile-default">
			<div class="icon"><i class="entypo-mail"></i></div>
			<div class="num" data-start="0" data-end="<?=number_format($member->dj_price,2,'.',',')?>" data-postfix="" data-duration="1500" data-delay="1200"><?=number_format($member->dj_price,2,'.',',')?></div>
			<h3>冻结积分</h3>
			<p>统计</p>
		</div>
</div>

<div class="col-sm-3 col-xs-6">
		<div class="tile-stats tile-orange">
			<div class="icon"><i class="entypo-mail"></i></div>
			<div class="num" data-start="0" data-end="<?=number_format($member->electronic_currency,2,'.',',')?>" data-postfix="" data-duration="1500" data-delay="1200"><?=number_format($member->electronic_currency,2,'.',',')?></div>
			<h3>原始积分</h3>
			<p>统计</p>
		</div>
</div>



</div>
<br />
<div class="row">
	<div class="col-sm-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title"><strong>系统公告</strong></div>
				<div class="panel-options">
					<a href="/notice/"><i class="entypo-dot-3"></i></a>
				</div>
			</div>
			<table class="table table-bordered table-responsive">
				<tbody>
					<?php
						foreach($notice as $notice_key=>$notice_row){
					?>
					<tr>
						<td><a href="<?=site_url('/notice/show/'.$notice_row->notice_id)?>"><?=$notice_row->title?></a></td>
						<td class="text-center"><span class="pie"><?=date("Y/m/d",$notice_row->ctime)?></span></td>
					</tr>
					<?php }; ?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title"><strong>帮助中心</strong></div>
				<div class="panel-options">
					<a href="/help/"><i class="entypo-dot-3"></i></a>
				</div>
			</div>
			<table class="table table-bordered table-responsive">
				<tbody>
					<?php
						foreach($help as $help_key => $help_row){
					?>
					<tr>
						<td><a href="<?=site_url('/help/show/'.$help_row->help_id)?>"><?=$help_row->title?></a></td>
						<td class="text-center"><span class="pie"><?=date("Y/m/d",$notice_row->ctime)?></span></td>
					</tr>
					<?php }; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<!-- Footer-->
<?php $this->load->view('footer.php') ?>