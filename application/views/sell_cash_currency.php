<?php $this->load->view('header.php') ?>
<h2>出售现金积分</h2><span>提示:成功交易后七天才可重新挂单！</span>
<br />
<div class="dataTables_wrapper form-inline">
	<div class="block">		
	<?=isset($hint) ? $hint : ''?>
	 <form id="theForm" name="theForm" method="post" action="<?=site_url('/sell_cash_currency/sell_submit')?>" >
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
								现金积分:</label>
						</td>
						<td class="col2">
							<input type="text"  readonly=""  value="<?=$row->cash_currency?>" name="cash_currency" id="cash_currency" class="valid form-control">							
						</td>
					</tr>
					<tr>
						<td class="col1">
							<label>
								出售数量:</label>
						</td>
						<td class="col2">
						<input type="text" class="form-control" readonly=""  class="valid" id="number" name="number" value="500"    />
						</td>
					</tr>
					<tr>
						<td class="col1">
							<label>
							  手续费:</label>
						</td>
						<td class="col2">
						<input type="text" readonly="" class="valid form-control" id="poundage" name="poundage" value="50"/>
						</td>
					</tr>
					<tr>
						<td class="col1">
							<label>
								联系电话:</label>
						</td>
						<td class="col2">
							<input type="text" readonly=""   value="<?=$row->mobile?>" name="mobile" id="mobile" class="valid form-control">							
						</td>
					</tr>
				<tr>
						<td class="col1">
							<label>
								收款银行:</label>
						</td>
						<td class="col2">
							<input type="text"  readonly=""  value="<?=$row->collection_bank?>" name="collection_bank" id="collection_bank" class="valid form-control">							
						</td>
					</tr>	
					<tr>
						<td class="col1">
							<label>
								收款姓名:</label>
						</td>
						<td class="col2">
							<input type="text" readonly=""   value="<?=$row->name?>" name="name" id="name" class="valid form-control">							
						</td>
					</tr>	
					<tr>
						<td class="col1">
							<label>
								收款帐号:</label>
						</td>
						<td class="col2">
							<input type="text"  readonly=""  value="<?=$row->account?>" name="account" id="account" class="valid form-control">							
						</td>
					</tr>	
					<tr>
						<td class="col1">
							<label>
								开户行:</label>
						</td>
						<td class="col2">
							<input type="text"  readonly=""  value="<?=$row->bank?>" name="bank" id="bank" class="valid form-control">							
						</td>
					</tr>	
					<tr id="bank_tr">
						<td class="col1">
							<label>
								开户地区:</label>
						</td>
						<td class="col2">
						 <select class="select " id="province" name="province"  disabled>
						<option value="">请选择</option>
						<?
						foreach($province as $key=>$p){
						?>
						<option value="<?=$key?>" <?=$row->province==$key?"selected":""?>><?=$p?></option>
						<?
						}
						?>
						</select>
						<select class="select" id="city" name="city" disabled>
						  <option value="">请选择</option>
						  <?
						  if($city!=""){
						  foreach($city as $key=>$c){
						?>
						<option value="<?=$key?>" <?=$row->city==$key?"selected":""?>><?=$c?></option>
						<?
						}
						  
						  }
						  ?>
						</select>
						</td>
					</tr>		
					<tr>
						<td>
							
						</td>
						<td>
							<?
						 if($cash_currency_market_state_count){
							?>
							<button class="btn btn-grey" type="button" >市场挂单已满，请稍后再挂.</button>
								<?
						 }else{
							if($cash_currency_market_count>0 || $cash_currency_market_state_count>0){
							?>
								<button class="btn btn-grey" type="button" >暂停出售</button>
								<?
							}else{
							?>
								<button class="btn btn_disabled" type="submit" >确定出售</button>
						<?
							}
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
},"出售现金积分必须不小于100，且为100的倍数");
$(document).ready(function() {
	$("#theForm").validate({
	   rules: {
		   mobile: "required",
		   name: "required",
		   account: "required",
		   bank: "required",
		   cash_currency: {
				min:500
		   },
		   number: {
				required:true
		   }
		},
		messages: {
		   mobile: "请输入联系电话",
		   name: "请输入收款人",
		   account: "请输入银行账号" ,
		   bank: "请输入开户行",
		   cash_currency: {
				min:"现金积分必须不小于500"
		   },
		   number: {
				required:"请填写出售数量"
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