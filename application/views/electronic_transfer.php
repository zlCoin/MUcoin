<?php $this->load->view('header.php') ?>
<h2>积分转账</h2>
<br />
<div class="dataTables_wrapper form-inline">
	<div class="block">		
	<?=isset($hint) ? $hint : ''?>
	 <form id="theForm" name="theForm" method="post" action="<?=site_url('/electronic_transfer/to_submit')?>" >
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
								我的报单积分:</label>
						</td>
						<td class="col2">
						<input type="text" id="wallet_currency" class="form-control" name="wallet_currency" value="<?=$row->wallet_currency?>" readonly> 
						</td>
					</tr>
					<tr>
						<td class="col1">
							<label>
								提示:</label>
						</td>
						<td class="col2">
						 转账积分必须是 100 的倍数
						</td>
					</tr>
					<tr>
						<td class="col1">
							<label>
								转给会员:</label>
						</td>
						<td class="col2">
							<input type="text"  id="to_user" class="form-control" name="to_user" value="" placeholder="对方会员帐号" onchange="get_name()"/><div id="name_div" style="width:20%;color:#f00"></div>
						</td>
					</tr>
					<tr>
						<td class="col1">
							<label>
								转出积分:</label>
						</td>
						<td class="col2">
							<input type="text" id="to_electronic_currency" class="form-control" name="to_electronic_currency" value="" placeholder="转出积分数量"/>
						</td>
					</tr>
					<tr>
						<td>
							
						</td>
						<td>
						<?
						if($row->electronic_currency>=100){
						?>
							<button class="btn btn_disabled" type="submit">确定转帐</button>
							<?
						}else{
						?>
							<button class="btn btn-blue"  type="button" >确定转帐</button>
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
},"转帐积分必须不小于100，且为100的倍数");
$(document).ready(function() {
	$("#theForm").validate({
	   rules: {
		   to_user: "required",
		   to_electronic_currency: {
				required:true,
				number:true,
				min:100,
				multiple100:true
		   }
		},
		messages: {
		   to_user: "请输入对方会员帐号",
		   to_electronic_currency: {
				required:"请填写转帐数量",
				number:"必须是数字",
				min:"转帐积分不小于100",
				multiple100:"转帐积分必须不小于100，且为100的倍数"
		   }	   
	   }
	});
});
function get_name(){
	$.post("<?=site_url('/electronic_transfer/ajax_get_member_name_byuser')?>",{user:$('#to_user').val()},
	function(data){
		$('#name_div').html(data);
	},
	"text");
}
</script>
<?php $this->load->view('footer.php') ?>