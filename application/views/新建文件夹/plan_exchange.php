<?=isset($header) ? $header : ''?>

<script>

$().ready(function() {
// 在键盘按下并释放及提交后验证提交表单
  $("#theForm").validate({
	    rules: {
	      
	      money: {
	        required: true,
	        range:[500,2600]
	      },
	      bank_name: {
	        required: true
	      },
	      id: {
	        required: true	      
	      },
	      mobile: {
	        required: true
	      },
		  collection_bank: {
	        required: true
	      },
		  account: {
	        required: true
	      },
		  bank: {
	        required: true
	      },
		  province: {
	        required: true
	      },
		  city: {
	        required: true
	      }
	    },
	    messages: {
	      
	      money: {
	        required: "请输入金额!",
			range:"请输入合法的金额(500至2600)!"
	      },
	      bank_name: {
	        required: "收款人不能为空!"
	      },
		  id: {
	        required: "身份证不能为空!"
	      },
		  mobile: {
	        required: "手机号码不能为空"
	      },
		  collection_bank: {
	        required: "收款银行不能为空!"
	      },
		  account: {
	        required: "收款人账号不能为空!"
	      },
		  bank: {
	        required: "收款账号开户行不能为空!"
	      },
		  province: {
	        required: "收款账号省份不能为空!"
	      },
		  city: {
	        required: "收款账号城市不能为空!"
	      }
	     
	     
	    }
	});
});
</script>

	<div class="grid_10">
		<div class="box round ">
			<h2>账户注销</h2>
			<font color="blue"><span style="font-size:130%;">请在"个人账户-->收款账号"菜单中完善收款信息，否则将收不到汇款！</span></font>
			<div class="block ">			
			<?=isset($hint) ? $hint : ''?>
                  <form id="theForm" name="theForm" method="post" action="<?=site_url('/plan/exchange_submit')?>" >
				<table class="form">
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
								现金积分:</label>
						</td>
						<td class="col2">
							<?=$row->cash_currency?>
						</td>
					</tr>
						<tr>
						<td class="col1">
							<label>
								兑换金额:</label>
						</td>
						<td class="col2">
							<input type="text" class="medium"  id="money" name="money" value="<?=$money?>">  
						</td>
					</tr>
					<tr>
						<td class="col1">
							<label>
								收款人:</label>
						</td>
						<td class="col2">
						 <input type="text" class="medium" id="bank_name" name="bank_name"  readonly  value="<?=$row->name?>"/>
						</td>
					</tr>
					<tr>
						<td class="col1">
							<label>
								身份证:</label>
						</td>
						<td class="col2">
							<input type="text" class="medium" id="id" name="id"  readonly value="<?=$row->id?>"/>
						</td>
					</tr>
					<tr>
						<td class="col1">
							<label>
								手机:</label>
						</td>
						<td class="col2">
						<input type="text" class="medium" id="mobile" name="mobile"  readonly value="<?=$row->mobile?>"/>
						</td>
					</tr>					
					<tr>
						<td class="col1">
							<label>
								收款银行:</label>
						</td>
						<td class="col2">						
						 <input type="text" class="medium" id="collection_bank"  readonly name="collection_bank" value="<?=$row->collection_bank==""?"中国农业银行":$row->collection_bank?>"/>
						</td>
					</tr>
					<tr>
						<td class="col1">
							<label>
								收款人账号:</label>
						</td>
						<td class="col2">
							<input type="text" class="medium" id="account" name="account"  readonly value="<?=$row->account?>"/>
						</td>
					</tr>
					<tr id="bank_tr">
						<td class="col1">
							<label>
								收款账号开户行:</label>
						</td>
						<td class="col2">
						<input type="text" class="medium" id="bank" name="bank"  readonly value="<?=$row->bank?>"/>
						</td>
					</tr>
					<tr id="bank_tr">
						<td class="col1">
							<label>
								收款账号城市:</label>
						</td>
						<td class="col2">
						 <select class="select" id="province" name="province"  onfocus="this.defaultIndex=this.selectedIndex;" onchange="this.selectedIndex=this.defaultIndex;">
						<option value="">请选择</option>
						<?
						foreach($province as $key=>$p){
						?>
						<option value="<?=$key?>" <?=$row->province==$key?"selected":""?>><?=$p?></option>
						<?
						}
						?>
						</select>
						
						<select class="select" id="city" name="city"  onfocus="this.defaultIndex=this.selectedIndex;" onchange="this.selectedIndex=this.defaultIndex;">
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
							<button class="btn btn_disabled" type="submit">提交兑换</button>
						</td>
					</tr>
					<tr>
						<td>
							
						</td>
						<td>							
							<a   href="<?=site_url('/bank_account')?>"><font color="blue">我要修改资料</font></a>
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

<?=isset($footer) ? $footer : ''?>