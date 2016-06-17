<?php $this->load->view('header.php') ?>
<style type="text/css">
<!--
.STYLE1 {color: #999999}
-->
</style>

<h2>积分转商城</h2>
<br />
<div class="dataTables_wrapper form-inline">
	<div class="block">		
	<?=isset($hint) ? $hint : ''?>
	 <form id="theForm" name="theForm" method="post" action="<?=site_url('/cash_to_shopping/to_submit')?>" >
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
								积分:
							</label>
						</td>
					  <td class="col2">
 
                         <select name="cash_type" id="cash_type">
						  <option value="0" selected="selected">请选择积分类型</option>
                           <option value="cash_currency">奖金积分</option>
						   <option value="free_currency">资产积分</option>
						 </select>
					    &nbsp;&nbsp; <span class="STYLE1">资产积分剩余：
					    <?=$row->cash_currency?>
					    ;奖金积分剩余：
					    <?=$row->free_currency?>
						 </span></td>
					</tr>
					<tr>
						<td class="col1">
							<label>
								转换购物积分:</label>
						</td>
						<td class="col2">
							<input type="text" class="form-control" id="shopping_currency" name="shopping_currency" value="" placeholder="转换购物积分必须不小于100，且为100的倍数"/>
						</td>
					</tr>
					<tr>
						<td>
							
						</td>
						<td>
							<button class="btn btn-blue">确定转换</button>
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
},"转换购物积分必须不小于100，且为100的倍数");
$(document).ready(function() {
	$("#theForm").validate({
	   rules: {
		   cash_currency: {
				min:100
				},
		   shopping_currency: {
				required:true,
				number:true,
				min:100,
				multiple100:true
		   }
		},
		messages: {
		   cash_currency: {
				min:"现金积分必须不小于100"
				},
		   shopping_currency: {
				required:"请填写转换数量",
				number:"必须是数字",
				min:"最小购买数量100",
				multiple100:"转换购物积分必须不小于100，且为100的倍数"
		   }	   
	   }
	});
});
</script>
<?php $this->load->view('footer.php') ?>