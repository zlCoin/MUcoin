<?php $this->load->view('header.php') ?>
<h2>报单积分明细</h2>
<br />
<div class="dataTables_wrapper form-inline">
	<table class="table table-bordered table-striped datatable">
		<thead>
			<tr>
				<th width="200">时间</th>
				<th width="200">明細</th>
				<th>消费备注</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($list as $key=>$row){ ?>
			<tr class="odd gradeX">
				<td><?=date("Y-m-d H:i",$row->addtime)?></td>
				<td><?php if(!$row->details_type){ echo '-'; }else{ echo '+'; }?>&nbsp;<?=$row->currency?></td>
				<td><?=$row->remarks?></td>
			</tr>
			<?php } ?>				
		</tbody>
	</table>
	<?=$pagination?>
</div>
<?php $this->load->view('footer.php') ?>