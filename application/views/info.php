<?php $this->load->view('header.php') ?>
<h2>账户资料</h2>
<br />
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary">
			<div class="panel-body">
			<div class="block ">
			<?=isset($hint) ? $hint : ''?>
 	        <table class="table table-bordered table-striped datatable">
 					<tr>
						<td class="col1">
							<label>
								会员账号:</label>
						</td>
						<td class="col2">
							<?=$row->user?>
						</td>
					</tr>
					<tr>
						<td class="col1">
							<label>
								激活状态:</label>
						</td>
						<td class="col2">
							<?=$row->state==1?"激活":"未激活"?>
						</td>
					</tr>
					<tr>
						<td class="col1">
							<label>
								激活时间:</label>
						</td>
						<td class="col2">
							<?=$row->atime>0?date("Y-m-d H:i",$row->atime):""?>
						</td>
					</tr>
					<tr>
						<td class="col1">
							<label>
								信誉等级:</label>
						</td>
						<td class="col2">
							
						</td>
					</tr>
					<tr>
						<td class="col1">
							<label>
								电子积分:</label>
						</td>
						<td class="col2">
							<?=$row->electronic_currency?>
						</td>
					</tr>
					<tr>
						<td class="col1">
							<label>
								现金积分:</label>
						</td>
						<td class="col2">
							<?=$row->cash_currency?>
						</td>
					</tr>
					<tr>
						<td class="col1">
							<label>
								自由股:</label>
						</td>
						<td class="col2">
							<?=$row->free_stock?>
						</td>
					</tr>
					<tr>
						<td class="col1">
							<label>
								自由积分:</label>
						</td>
						<td class="col2">
							<?=$row->free_currency?>
						</td>
					</tr>
					<tr>
						<td class="col1">
							<label>
								自由金:</label>
						</td>
						<td class="col2">
							<?=$row->free_gold?>
						</td>
					</tr>
					<tr>
						<td class="col1">
							<label>
								购物积分:</label>
						</td>
						<td class="col2">
							<?=$row->shopping_currency?>
						</td>
					</tr>
				</table>
 				</div>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('footer.php') ?>