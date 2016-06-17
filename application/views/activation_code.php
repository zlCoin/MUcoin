<?php $this->load->view('header.php') ?>
		  <label>说明：平台管理费，可向销售经理购买充值密码进行充值，100元/个，有效期30天</label>	
	<div class="row">
		<div class="block ">
			<?=isset($hint) ? $hint : ''?>
				<form id="theForm" name="theForm" class="form-horizontal form-groups-bordered validate" method="post" action="<?=site_url('/activation_code/submit')?>" >
					<div class="col-sm-6 col-xs-12">
							<div class="tile-stats tile-cyan">
								<h3>充值密码支付管理费</h3>
							</div>

						 <table class="table table-bordered table-striped datatable">
							<tbody>
							 <tr>
							 <td>
							   <div class="form-group">
								<label class="col-sm-3 control-label">会员账号:</label>
								<div class="col-sm-3">
									<?=$row->user?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">当前过期时间:</label>
								<div class="col-sm-3">
								<?=$row->expiration_date>0?date("Y-m-d",$row->expiration_date):"未缴纳"?>	
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">充值卡密码:</label>
								<div class="col-sm-5">
								<input type="text" id="code" name="code" value="" class="form-control"  onchange="set_day_number()">
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-3 col-sm-5">
									<input type="submit" class="btn btn-primary" value="确定充值" />
								</div>
							</div>
							 
					  </td>
					  </tr>
					  </tbody>
					  </table>
				  </div>
			  </form>
	    </div>
        <script>
 	$(document).ready(function() {
		$("#theForm").validate({
		   rules: {
				code: {
					required:true
					}
			},
			messages: {
				code: {
					required:"请输入充值卡密码"
					}
		   }
		});
	});
	function set_day_number(){
		var number=30;
		$("#day_number").html(number);
	}
</script>
	    <div class="col-sm-6 col-xs-12">
			<div class="tile-stats tile-orange">
 				<h3>充值列表</h3>
 			</div>
       <table class="table table-bordered table-striped datatable">
			<thead>
				<tr>
					<th>充值时间</th>
					<th class="text-center">充值卡密码</th>
					<th>备注</th>
				</tr>
			</thead>
			<tbody>
				<?
					foreach($list as $key=>$row){
				 ?>
				<tr>
					<td><?=$row->etime>0?date("Y-m-d H:i",$row->etime):""?></td>
					<td><?=$row->code?></td>
					<td><?=$row->remark?></td>
				</tr>
				<?
				}
				?>
			</tbody>
	   </table>
	<?=$pagination?>
		</div>
	</div>

 <!-- Footer--------------------------->
	<?php $this->load->view('footer.php') ?>