<?php $this->load->view('header.php') ?>
<h2>参与赠送积分</h2>
<br />
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary">
			<div class="panel-body">
			<div class="block ">
			<?=isset($hint) ? $hint : ''?>
				 <form id="theForm" name="theForm" method="post" action="<?=site_url('/activation_account/activation_submit')?>" class="form-horizontal form-groups-bordered validate" >
	        <table class="table table-bordered table-striped datatable">
					<tr>
						<td>
							<label>
								会员账号:</label>
						</td>
						<td>
							<?=$row->user?>
						</td>
					</tr>	
					<tr>
						<td>
							<label>
								电子积分:</label>
						</td>
						<td>
							<input type="text" id="electronic_currency" name="electronic_currency" value="<?=$row->electronic_currency?>" readonly class="form-control">
						</td>
					</tr>
					<tr>
						<td>
							<label>
								我的自由股:</label>
						</td>
						<td>
							<?=$row->free_stock?>
						</td>
					</tr>
					<tr>
						<td>
							<label>
								激活电子积分</label>
						</td>
						<td>
							1300.00
						</td>
					</tr>
					<tr>
						<td>
							<label>
								激活状态:</label>
						</td>
						<td>
							<?=$row->state==1?"激活":"未激活"?>
						</td>
					</tr>
					<tr>
						<td>
							<label>
								激活时间:</label>
						</td>
						<td>
							<?=$row->atime>0?date("Y-m-d H:i",$row->atime):""?>
						</td>
					</tr>
					<tr>
						<td>
							
						</td>
						<td>
						<?
						if($row->state==1){
						?>
							<button class="btn btn-blue"  type="button" >已经激活</button>
							<?
						}else{
							if($row->electronic_currency>=$system_set->invest_limit){
								?>
							<button class="btn btn_disabled"  type="submit" >激活</button>
							<?
							}else{
						?>
							<button class="btn btn-blue"  type="button" >激活</button>
							<?
								}
						}	
						?>
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
		    electronic_currency: {
				min:<?=$system_set->invest_limit?>
				}
		},
		messages: {
		    electronic_currency: {
				min:"电子积分必须不小于<?=$system_set->invest_limit?>"
				}
	   }
	});
});
</script>
<?php $this->load->view('footer.php') ?>