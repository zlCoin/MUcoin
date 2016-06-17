<?php $this->load->view('header.php') ?>
<h2>奖金总览</h2><span>温馨提醒,如果没有积分赠送,请检查您是否缴纳管理费和您的自由股是否需要复投！</span>
<br />
<div class="dataTables_wrapper form-inline">
	<div class="block">		
	<?=isset($hint) ? $hint : ''?>
	<table class="table table-bordered table-striped datatable">
		<thead>
					<tr>
						<th>日期</th>
						<th>积分赠送</th>
						<th>现金积分</th>
						<th>自由金</th>
						<th>合计</th>
					</tr>
				</thead>
				<tbody>
				<?
					foreach($list as $key=>$row){
						$management=my_get_row_bymember_idandymd($row->member_id,$row->ymd);
					?>
					<tr class="odd gradeX">
						<td><?=$row->y."-".$row->m."-".$row->d?></td>
						<td><?=$row->dividend?></td>
						<td><?=isset($management->cash)?$management->cash:"0"?></td>
						<td><?=isset($management->free_gold)?$management->free_gold:"0"?></td>
						<td><?
						$money=isset($management->money)?$management->money:0;
					    echo $money+$row->dividend;
							
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