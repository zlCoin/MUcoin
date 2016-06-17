<?=isset($header) ? $header : ''?>
	<div class="grid_10">
		<div class="box round ">
			<h2>收款账号新增</h2>
			<div class="block ">
                  <form id="theForm" name="theForm" method="post" action="<?=site_url('/bank_account/add_submit')?>" >
				<table class="form">
					<tr>
						<td class="col1">
							<label>
								收款人:</label>
						</td>
						<td class="col2">
						<?=$this->login_lib->member_name()?>
							<input type="hidden" id="name" name="name" value="<?=$this->login_lib->member_name()?>">  
						</td>
					</tr>					
					<tr>
						<td class="col1">
							<label>
								收款方式:</label>
						</td>
						<td class="col2">
						<select name="collection_mode" id="collection_mode" onchange="select_collection_mode()">
						<?
						foreach($collection_mode as $key=>$val){
						?>
						<option value="<?=$key?>"><?=$val?></option>
						<?
						}
						?>
                        </select>
						</td>
					</tr>
					<tr>
						<td class="col1">
							<label>
								账号:</label>
						</td>
						<td class="col2">
							<input type="text" class="medium" id="account" name="account" value=""/>
						</td>
					</tr>
					<tr id="bank_tr">
						<td class="col1">
							<label>
								开户行:</label>
						</td>
						<td class="col2">
						<input type="text" class="medium" id="bank" name="bank" value=""/>
						</td>
					</tr>					
					<tr>
						<td>
							
						</td>
						<td>
							<button class="btn btn-navy">提交</button>
						</td>
					</tr>
				</table>
                </form>
			</div>
		</div>
	</div>
	<div class="clear">
	</div>
</div>
<div class="clear"></div>
<script>
$(document).ready(function() {
	select_collection_mode();
	$("#theForm").validate({
	   rules: {
		   name: "required",
		   account: "required",
		   bank: "required"
		},
		messages: {
		   name: "请输入收款人",
		   account: "请输入银行账号" ,
		   bank: "请输入开户行"
	   }
	});
});
function select_collection_mode(){
	var collection_mode=$("#collection_mode").val();
	if(collection_mode==1 || collection_mode==2){
		$("#bank_tr").hide();
	}else{
		$("#bank_tr").show();	
	}
}
</script>
<?=isset($footer) ? $footer : ''?>