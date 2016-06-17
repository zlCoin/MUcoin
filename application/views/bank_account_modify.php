<?php $this->load->view('header.php') ?>
<h2>收款账号,请正确填写开户行信息 ！</h2>
<br />
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary">
			<div class="panel-body">
				<?=isset($hint) ? $hint : ''?>
				<form id="theForm" name="theForm" class="form-horizontal form-groups-bordered validate" method="post" action="<?=site_url('/bank_account/modify_submit')?>" >
					<div class="form-group">
						<label class="col-sm-3 control-label">收款人:</label>
						<div class="col-sm-3">
							 <input type="text" class="form-control" readonly value="<?=$row->name?>"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">身份证:</label>
						<div class="col-sm-3">
							<input type="text" class="form-control" name="id" value="<?=$row->id?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">收款银行：</label>
						<div class="col-sm-3">
							<select class="form-control" name="collection_mode">
								<?php foreach($collection_mode as $key => $val){?>
								<option value="<?php echo $key; ?>" <?=$row->collection_mode == $key ? "selected" : "" ?>><?php echo $val; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
                    <div class="form-group">
						<label class="col-sm-3 control-label">收款人账号：</label>
						<div class="col-sm-3">
							<input type="text" class="form-control" name="account" <?php if($row->account!=''):?> readonly <?php endif;?> value="<?=$row->account?>"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">收款账号开户行：</label>
						<div class="col-sm-3">
							<input type="text" class="form-control" name="bank" value="<?=$row->bank?>"/>
						</div>
					</div>
                    <div class="form-group">
						<label class="col-sm-3 control-label">收款账号城市：</label>
						<div class="col-sm-2">
							<select class="form-control" name="province">
								<option value="">请选择</option>
								<?php foreach($province as $key => $p){ ?>
								<option value="<?=$key?>" <?=$row->province == $key ? "selected" : "" ?>><?=$p?></option>
								<?php } ?>
							</select>
						</div>
						<div class="col-sm-2">
							<select class="form-control" name="city" <?php if(!$city){ echo 'style="display:none;"'; }else{ echo 'style="display:block;"'; } ?>>
						  		<option value="">请选择</option>
						  		<?php
						  			if($city){
						  			foreach($city as $key=>$c){
								?>
									<option value="<?=$key?>" <?=$row->city == $key?"selected" : ""?>><?=$c?></option>
								<?php }} ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
 							<input type="submit" class="btn btn-primary" value="提交" />
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function() {
	$("#theForm").validate({
		rules: {
			account: "required",
			bank: "required"
		},
		messages: {
			account: "请输入账号" ,
			bank: "请输入开户行"
		}
	});
	jQuery("select[name=province]").change(function(){
		var CityDom = jQuery('select[name=city]');
		$.get("/area/get_city/" + jQuery(this).val(),function(data){
			if (data) {
				CityDom.html(data).show();
			}else{
				CityDom.hide().html("<option value=''>请选择</option>");
			}
		})
	})
});
</script>
<?php $this->load->view('footer.php') ?>