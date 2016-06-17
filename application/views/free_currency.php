<?php $this->load->view('header.php') ?>
<h2>资产包明细</h2>
<br />
<div class="dataTables_wrapper form-inline">
	<?=isset($hint) ? $hint : ''?>
	<table class="table table-bordered table-striped datatable">
		<thead>
			<tr>
				<th>时间</th>
				<!--th>类型</th--->
				<th>金额</th>
				<th>备注</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($list as $key=>$row){ ?>
			<tr class="odd gradeX">
				<td><?=date("Y-m-d H:i",$row->ctime)?></td>
				<!--td><?=$cash_type[$row->type]?></td--->
				<td><?=$row->free_currency?></td>
				<td><?=$row->remark?></td>
			</tr>
			<?php } ?>				
		</tbody>
	</table>
	<?=$pagination?>
</div>
<?php $this->load->view('footer.php') ?>