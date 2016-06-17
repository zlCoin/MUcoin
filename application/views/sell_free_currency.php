<?php $this->load->view('header.php') ?>
<h2>出售自由积分</h2> 
<br />
<div class="dataTables_wrapper form-inline">
	<div class="block">		
	<?=isset($hint) ? $hint : ''?>
	 <form id="theForm" name="theForm" method="post" action="<?=site_url('/sell_free_currency/sell_submit')?>" >
	<table class="table table-bordered table-striped datatable">
		<tr>
						<td class="col1">
							<label>
								会员账号:</label>
						</td>
						<td class="col2">
							<?=$row->user?><input type="hidden" id="user" name="user" value="<?=$row->user?>">
						</td>
					</tr>		
					<tr>
						<td class="col1">
							<label>
								自由积分:</label>
						</td>
						<td class="col2">
							<input type="text" readonly="" value="<?=$row->free_currency?>" name="free_currency" id="free_currency" class="valid">							
						</td>
					</tr>
					<tr>
						<td class="col1">
							<label>
								卖出的自由积分:</label>
						</td>
						<td class="col2">
								<?=$system_free_currency->sell?>
						</td>
					</tr>	
					<tr>
						<td class="col1">
							<label>
								未可流通的自由积分:</label>
						</td>
						<td class="col2">	
								0
						</td>
					</tr>	
					<tr>
						<td class="col1">
							<label>
								出售数量:</label>
						</td>
						<td class="col2">
						<input type="text" class="valid" id="number" name="number" value="100"  />
						</td>
					</tr>
					<tr>
						<td class="col1">
							<label>
								出售价格:</label>
						</td>
						<td class="col2">
						<input type="text" class="valid" id="price" name="price" value="1"    />
						</td>
					</tr>
					<tr>
						<td>
							
						</td>
						<td>
							<button class="btn btn-navy">确定出售</button>
						</td>
					</tr>
				</table>
                </form>
</div>
 <script>
jQuery.validator.addMethod("multiple100", function(value, element){
	var i100=value%100;
	if(i100==0)
		return true;
	else 
		return false;
},"出售现金积分必须不小于100，且为100的倍数");
$(document).ready(function() {
	$("#theForm").validate({
	   rules: {
		   free_currency: {
				min:100
		   },
		   number: {
				required:true,
				number:true,
				min:100,
				multiple100:true
		   }
		},
		messages: {
		   free_currency: {
				min:"自由积分必须不小于100"
		   },
		   number: {
				required:"请填写出售数量",
				number:"必须是数字",
				min:"最小数量数量100",
				multiple100:"出售自由积分必须不小于100，且为100的倍数"
		   }	   
	   }
	});
});
</script>
<?php $this->load->view('footer.php') ?>