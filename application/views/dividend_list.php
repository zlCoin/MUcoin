<?php $this->load->view('header.php') ?>
<h2>积分赠送明细</h2>
<br />
<div class="dataTables_wrapper form-inline">
	<div class="block">		
	<?=isset($hint) ? $hint : ''?>
	<table class="table table-bordered table-striped datatable">
		<thead>
				<thead>
					<tr>
						<th>套餐编号</th>
						<th>买入时间</th>
						<th>买入数量</th>
						<th>每周积分赠送</th>
						<th>积分赠送次数</th>
						<th>累计积分赠送</th>
						<th>积分赠送时间</th>
					</tr>
				</thead>
				<tbody>
				<?
					foreach($list as $key=>$row){
					?>
					<tr class="odd gradeX">
						<td><?=$row->no?></td>
						<td><?=date("Y-m-d H:i",$row->btime)?></td>
						<td><?=$row->number?></td>
						<td><?=$row->day_dividend?></td>
						<td><?=$row->time?></td>
						<td><?=$row->cumulative_dividend?></td>
						<td><?=date("Y-m-d H:i",$row->ctime)?></td>
					</tr>
					<?
					}
					?>				
				</tbody>
			</table>
			<?=$pagination?>
</div>
<?php $this->load->view('footer.php') ?>