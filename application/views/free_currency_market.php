<?php $this->load->view('header.php') ?>
<h2>市场总览</h2>
<br />
<div class="dataTables_wrapper form-inline">
	<div class="block">		
	<?=isset($hint) ? $hint : ''?>
	<table class="table table-bordered table-striped datatable">
		<thead>
					<tr>
						<th>公司总发行</th>
						<th>已经发行数量</th>
						<th>本期发行数量</th>
						<th>发行价格</th>
						<th>本期剩余数量</th>
					</tr>
				</thead>
			<tbody>
				<tr class="odd">
					<td><?=$system_free_currency->free_currency?></td>
					<td><?=$system_free_currency->sell?></td>
					<td><?=$system_free_currency->sell?></td>
					<td><?=$system_free_currency->price?></td>
					<td><?=$system_free_currency->free_currency-$system_free_currency->sell?></td>
				</tr>
			</tbody>
		</table>





	<table class="table table-bordered table-striped datatable">
			<thead>
					<tr>
						<th>开盘价</th>
						<th>最高价</th>
						<th>最低价</th>
						<th>现价</th>
						<th>涨跌</th>
						<th>昨收盘</th>
						<th>历史成交量</th>
						<th>当日成交量</th>
					</tr>
				</thead>
			<tbody>
				<tr>
					<td><?=$system_free_currency_dynamic->opening_prices?></td>
					<td><?=$system_free_currency_dynamic->max_price?></td>
					<td><?=$system_free_currency_dynamic->min_price?></td>
					<td><?=$system_free_currency_dynamic->price?></td>
					<td><?=$system_free_currency_dynamic->up_and_down?></td>
					<td><?=$system_free_currency_dynamic->yesterday_close?></td>
					<td><?=$system_free_currency_dynamic->historical_volume?></td>
					<td><?=$system_free_currency_dynamic->day_volume?></td>
				</tr>
			</tbody>
		</table>


</div>

<div class="dataTables_wrapper form-inline">
 			<?=isset($hint) ? $hint : ''?>
 							<div class="tile-stats tile-cyan">
								<h3>出售列表</h3>
							</div>
         <table class="table table-bordered table-striped datatable">
                 <thead>
					<tr>
						<th width="100">发布时间</th>
						<th>会员</th>
						<th>数量</th>
						<th>价格</th>
						<th>成交时间</th>
						<th>成交数量</th>
						<th>状态</th>
						<th>操作</th>
					</tr>
				</thead>
			<?
					foreach($list as $key=>$row){
					?>
					<tr class="odd gradeX">
						<td><?=date("Y-m-d H:i",$row->ctime)?></td>
						<td><?=$row->user?></td>
						<td><?=$row->number?></td>
						<td><?=$row->price?></td>
						<td><?=$row->btime>0?date("Y-m-d",$row->btime):""?></td>
						<td><?=$row->buy_number>0?$row->buy_number:""?></td>
						<td><?
						if($row->state==0)
							echo "等待交易";
						else if($row->state==1)
							echo "交易成功";
						else if($row->state==2)
							echo "交易取消";
						
						?></td>
						<td><? 
						if($member_id!=$row->member_id && $row->state==0){
						?><a class="btn btn-navy"  href="<?=site_url('/electronic_currency_market/buy/'.$row->electronic_currency_market_id)?>" onclick="javascript:return confirm('确定购买吗？');">购买</a><?
						}else if($member_id==$row->member_id && $row->state==1){
						?><a class="btn btn-navy"  href="<?=site_url('/electronic_currency_market/buy/'.$row->electronic_currency_market_id)?>" onclick="javascript:return confirm('确定购买吗？');">购买</a><?
						}else{
						echo "--";
						}
						?></td>
					</tr>
					<?
					}
					?>				
				</tbody>
		</table>
			
			<?=$pagination?>

			<div class="tile-stats tile-orange">
 				<h3>价格动态</h3>
 			</div>
       <table class="table table-bordered table-striped datatable">
		 <thead>
					<tr>
						<th>卖出价</th>
						<th>数量</th>
					</tr>
				</thead>
			<tbody>
				<?
				//	foreach($help as $help_key=>$help_row){
				?>
				<tr class="odd">
					<td>/</td>
					<td>/</td>
				</tr>
				<tr class="odd">
					<td>/</td>
					<td>/</td>
				</tr>
				<tr class="odd">
					<td>/</td>
					<td>/</td>
				</tr>
				<tr class="odd">
					<td>/</td>
					<td>/</td>
				</tr>
				<tr class="odd">
					<td>/</td>
					<td>/</td>
				</tr>
				<?
				//	}
				?>
			</tbody>
		</table>
       <table class="table table-bordered table-striped datatable">
			<thead>
					<tr>
						<th>买入价</th>
						<th>数量</th>
					</tr>
				</thead>
			<tbody>
				<?
				//	foreach($help as $help_key=>$help_row){
				?>
				<tr class="odd">
					<td>/</td>
					<td>/</td>
				</tr>
				<tr class="odd">
					<td>/</td>
					<td>/</td>
				</tr>
				<tr class="odd">
					<td>/</td>
					<td>/</td>
				</tr>
				<tr class="odd">
					<td>/</td>
					<td>/</td>
				</tr>
				<tr class="odd">
					<td>/</td>
					<td>/</td>
				</tr>
				<?
				//	}
				?>
			</tbody>
		</table>
	</div>
<?php $this->load->view('footer.php') ?>