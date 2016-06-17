<?php $this->load->view('header.php') ?>
<h2>管理赠送积分</h2>
<br />
<div class="dataTables_wrapper form-inline">
	<div class="block">		
	<?=isset($hint) ? $hint : ''?>
	<table class="table table-bordered table-striped datatable">
		<thead>
					<tr>
						<th>时间</th>
						<th>现金积分</th>
						<th>自由金</th>
					</tr>
				</thead>
				<tbody>
				   <?
					foreach($list as $key=>$row){
					?>
					<tr class="odd gradeX">
						<td><?=$row->y."-".$row->m."-".$row->d?></td>
						<td><?=$row->cash?></td>
						<td><?=$row->free_gold?></td>
					</tr>
					<?
					  }
					?>				
				</tbody>
			</table>
			<?=$pagination?>
</div>
<?php $this->load->view('footer.php') ?>