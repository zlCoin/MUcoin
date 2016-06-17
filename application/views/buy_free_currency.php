<?php $this->load->view('header.php') ?>
<h2>购买自由积分</h2>
<br />
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary">
			<div class="panel-body">
			<div class="block ">
			<?=isset($hint) ? $hint : ''?>
				<form id="theForm" name="theForm" class="form-horizontal form-groups-bordered validate" method="post" action="<?=site_url('/buy_free_currency/buy_submit')?>" >
					<table class="table table-bordered table-striped datatable">
					 <tr>
						<td class="col1">
							<label>
								系统当前自由积分余额:</label>
						</td>
						<td class="col2">
						<?=$system_free_currency?>
						</td>
					</tr>		
					<tr>
						<td class="col1">
							<label>
								您当前的自由金数量:</label>
						</td>
						<td class="col2">
							<?=$row->free_gold?>
						</td>
					</tr>
					<tr>
						<td class="col1">
							<label>
								您当前拥有的自由积分数量:</label>
						</td>
						<td class="col2">
							 <?=$row->free_currency?>
						</td>
					</tr>
					<tr>
						<td class="col1">
							<label>
								当前自由积分价格:</label>
						</td>
						<td class="col2">
							<?=$system_free_currency_price?>
						</td>
					</tr>	
					<tr>
						<td class="col1">
							<label>
								可购买数量:</label>
						</td>
						<td class="col2">
							<?=$row->free_gold*$system_free_currency_price?>
						</td>
					</tr>		
					<tr>
						<td class="col1">
							<label>
								购买数量:</label>
						</td>
						<td class="col2">
						<input type="text" class="medium" id="number" name="number" value="1"/>
						</td>
					</tr>
					<tr>
						<td>
							
						</td>
						<td>
							<button class="btn btn-blue">确定购买</button>
						</td>
					</tr>
				</table>
                </form>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function() {
	$("#theForm").validate({
	   rules: {
		   number: {
				required:true,
				number:true,
				min:100,
				max:<?=$row->free_gold*$system_free_currency_price?>
		   }
		},
		messages: {
		   number: {
				required:"请填写购买数量",
				number:"必须是数字",
				min:"最小购买数量100",
				max:"最大购买数量"
		   }	   
	   }
	});
});
</script>
<?php $this->load->view('footer.php') ?>