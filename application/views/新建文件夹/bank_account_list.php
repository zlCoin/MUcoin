<?=isset($header) ? $header : ''?>
<div class="grid_10">
	<div class="box round grid">
		<h2>收款账号</h2>
		<div class="block">		
		<div class="dataTables_length"></div>
		<div class="dataTables_filter"><a href="<?=site_url('bank_account/add/')?>" class="btn">新增收款帐号</a></div>
			<table class="data display" >
				<thead>
					<tr>
						<th>ID</th>
						<th>收款方式</th>
						<th>开户行</th>
						<th>账号</th>
						<th>户名</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
				<?
					foreach($list as $key=>$row){
					?>
					<tr class="odd gradeX">
						<td><?=$row->member_bank_id?></td>
						<td><?=$collection_mode[$row->collection_mode]?></td>
						<td><?=$row->bank?></td>
						<td><?=$row->account?></td>
						<td><?=$row->name?></td>
						<td><a href="<?=site_url('bank_account/modify/'.$row->member_bank_id)?>" class="btn btn-grey btn-minus">编辑</a>
						<a href="<?=site_url('bank_account/delete/'.$row->member_bank_id)?>" class="btn btn-grey btn-minus" onclick="javascript:return del_sure();">删除</a></td>
					</tr>
					<?
					}
					?>				
				</tbody>
			</table>
			<?=$pagination?>
		</div>
	</div>
</div>
<div class="clear"></div>
<script type="text/javascript" >
$(document).ready(function(){	
});
</script>
<?=isset($footer) ? $footer : ''?>