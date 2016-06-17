<?php $this->load->view('header.php') ?>
<h2>我的自由股</h2>
<br />
<div class="dataTables_wrapper form-inline">
	<div class="block">		
	<?=isset($hint) ? $hint : ''?>
	<table class="table table-bordered table-striped datatable">
		<thead>
					<tr>
						<th>编号</th>
						<th>买入时间</th>
						<th>买入数量</th>
						<th>日积分赠送</th>
						<th>积分赠送次数</th>
						<th>累计积分赠送</th>
						<th>状态</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
				<?
					foreach($list as $key=>$row){
					?>
					<tr class="odd gradeX">
						<td><?=$row->no?></td>
						<td><?=date("Y-m-d H:i",$row->ctime)?></td>
						<td><?=$row->number?></td>
						<td><?=$row->day_dividend?></td>
						<td><?=$row->time?></td>
						<td><?=$row->cumulative_dividend?></td>
						<td><?=$row->time>=$system_set->dividend_time?"出局":"积分赠送"?></td>
						<td><?
						if($row->time>=$system_set->dividend_time){
						?><a href="<?=site_url('/free_stock_market/re_cast/'.$row->free_stock_id)?>" onclick="javascript:return confirm('确定复投吗？');">复投</a><?
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
</div>
<?php $this->load->view('footer.php') ?>