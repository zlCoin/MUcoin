<?php $this->load->view('header.php') ?>
<h2>提现额度明细</h2>
<br />
<div class="dataTables_wrapper form-inline">
	<div class="block">		
	<?=isset($hint) ? $hint : ''?>
	<table class="table table-bordered table-striped datatable">
 				<thead>
					<tr>
						<th>时间</th>
						<th>类型</th>
						<th>可提现额度</th>
 						<th>备注</th>
					</tr>
				</thead>
				<tbody>
				<?
					foreach($list as $key=>$row){
					?>
					<tr class="odd gradeX">
						<td><?=date("Y-m-d H:i",$row->ctime)?></td>
						<td><?=$row->type?></td>
						<td><?=$row->free_gold?></td>
 						<td><?=$row->remark?></td>
					</tr>
					<?
					}
					?>				
				</tbody>
			</table>
			<?=$pagination?>
</div>
<?php $this->load->view('footer.php') ?>