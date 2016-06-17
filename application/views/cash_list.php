<?php $this->load->view('header.php') ?>
<h2>奖金钱包明细</h2>
<br />
<div class="dataTables_wrapper form-inline">
	<?=isset($hint) ? $hint : ''?>
	<table class="table table-bordered table-striped datatable">
		<thead>
			<tr>
				<th width="200">时间</th>
				<th width="200">类型</th>
				<th>增加</th>
				<th>减少</th>
				<th>消费备注</th>
				<th>收入备注</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($list as $key=>$row){ ?>
			<tr class="odd gradeX">
				<td><?=date("Y-m-d H:i",$row->ctime)?></td>
				<td>
					<?php echo $cash_type[$row->type]; ?>
				</td>
				<td><?=$row->cash_currency>0?$row->cash_currency:"--"?></td>

				<td><?=$row->wallet_currency>0?$row->wallet_currency:"--"?></td>

				<td><?php if($row->type=='jihuo_sell') : ?><?="激活账户：".$row->from_user?><?php else:?>--<?php endif;?></td>
				<td><?=$row->remark?></td>
			</tr>
			<?php } ?>				
		</tbody>
	</table>
	<?=$pagination?>
</div>
<?php $this->load->view('footer.php') ?>