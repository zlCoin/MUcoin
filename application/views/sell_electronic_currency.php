<?php $this->load->view('header.php') ?>
<h2>出售电子积分</h2> 
<br />
<div class="dataTables_wrapper form-inline">
	<div class="block">		
	<?=isset($hint) ? $hint : ''?>
	 <form id="theForm" name="theForm" method="post" action="<?=site_url('/sell_electronic_currency/sell_submit')?>" >
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
								电子积分:</label>
						</td>
						<td class="col2">
							<input type="text" readonly="" value="<?=$row->electronic_currency?>" name="electronic_currency" id="electronic_currency" class="valid">							
						</td>
					</tr>	<tr>
						<td class="col1">
							<label>
								出售数量:</label>
						</td>
						<td class="col2">
						<input type="text"  readonly=""  class="valid" id="number" name="number" value="500"  />
						</td>
					</tr>
					<tr>
						<td class="col1">
							<label>
								手续费:</label>
						</td>
						<td class="col2">
						<input type="text" readonly="" class="valid" id="poundage" name="poundage" value="50"/>
						</td>
					</tr>
					<tr>
						<td class="col1">
							<label>
								联系电话:</label>
						</td>
						<td class="col2">
							<input type="text"  value="<?=$row->mobile?>" name="mobile" id="mobile" class="valid">							
						</td>
					</tr>
					<tr>
						<td class="col1">
							<label>
								开户银行:</label>
						</td>
						<td class="col2">
							<input type="text"  value="<?=$row->bank?>" name="bank" id="bank" class="valid">							
						</td>
					</tr>	
					<tr>
						<td class="col1">
							<label>
								收款姓名:</label>
						</td>
						<td class="col2">
							<input type="text"  value="<?=$row->name?>" name="name" id="name" class="valid">							
						</td>
					</tr>	
					<tr>
						<td class="col1">
							<label>
								收款帐号:</label>
						</td>
						<td class="col2">
							<input type="text"  value="<?=$row->account?>" name="account" id="account" class="valid">							
						</td>
					</tr>	
				
					<tr>
						<td>
							
						</td>
						<td><?
						if($electronic_currency_market_count>0){
						?>
							<button class="btn btn-grey" type="button" >暂停出售</button>
							<?
						}else{
						?>
							<button class="btn btn_blue" type="submit" >确定出售</button>
							<?
						}	
						?>
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
},"出售电子积分必须不小于100，且为100的倍数");
$(document).ready(function() {
	$("#theForm").validate({
	   rules: {
		   mobile: "required",
		   name: "required",
		   account: "required",
		   bank: "required",
		   electronic_currency: {
				min:100
		   },
		   number: {
				required:true,
				number:true,
				min:100,
				max:<?=$row->electronic_currency?>,
				multiple100:true
		   }
		},
		messages: {
		   mobile: "请输入联系电话",
		   name: "请输入收款人",
		   account: "请输入银行账号" ,
		   bank: "请输入开户行",
		   electronic_currency: {
				min:"电子积分必须不小于100"
		   },
		   number: {
				required:"请填写出售数量",
				number:"必须是数字",
				max:"最大数量<?=$row->electronic_currency?>",
				min:"最小数量100",
				multiple100:"出售电子积分必须不小于100，且为100的倍数"
		   }	   
	   }
	});
});
function set_poundage(){
	var number=$("#number").val()*0.1;
	$("#poundage").val(number);
}
</script>
<?php $this->load->view('footer.php') ?>