<?php $this->load->view('header.php') ?>
<h2>我的积分记录</h2>
<br />
<div class="dataTables_wrapper form-inline">
	<div class="block">		
	<?=isset($hint) ? $hint : ''?>
	<table class="table table-bordered table-striped datatable">
		<thead>
					<tr>
						<th width="200">时间</th>
						<th>类型</th>
						<th>会员账号</th>
						<th>昵称</th>
						<th>扣除积分</th>
					</tr>
				</thead>
				<tbody>
				<?
					foreach($list as $key=>$row){
					?>
					<tr class="odd gradeX">
						<td><?=date("Y-m-d H:i",$row->ctime)?></td>
						<td><?=$row->type?></td>
						<td><?=$row->user."：转入帐号：".$row->to_user?></td>
						<td><?=$row->remark?></td>
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