<?php $this->load->view('header.php') ?>
<h2>电子积分消费记录</h2>
<br />
<div class="dataTables_wrapper form-inline">
	<div class="block">		
	<?=isset($hint) ? $hint : ''?>
	<table class="table table-bordered table-striped datatable">
		<thead>
					<tr>
						<th>消费时间</th>
						<th>方式</th>
						<th>数量</th>
					</tr>
				</thead>
				<tbody>
				<?
					foreach($list as $key=>$row){
					?>
					<tr class="odd gradeX">
						<td><?=date("Y-m-d H:i",$row->ctime)?></td>
						<td><?=isset($electronic_type[$row->type])?$electronic_type[$row->type]:""?></td>
						<td><?=$row->electronic_currency?></td>
					</tr>
					<?
					}
					?>				
				</tbody>
			</table>
			<?=$pagination?>
</div>
<?php $this->load->view('footer.php') ?>