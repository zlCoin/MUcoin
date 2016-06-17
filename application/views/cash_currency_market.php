<?php $this->load->view('header.php') ?>
<h2>奖金交易市场</h2>
<br />
<div class="dataTables_wrapper form-inline">
	<div class="block">		
	<?=isset($hint) ? $hint : ''?>
	<table class="table table-bordered table-striped datatable">
		<thead>
				<thead>
					<tr>
						<th width="150">发布时间</th>
						<th>会员编号</th>
						<th>数量</th>
						<th>状态</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
				<?
					foreach($list as $key=>$row){
					?>
					<tr class="odd gradeX">
						<td><?=date("Y-m-d H:i",$row->ctime)?></td>
						<td><?=$row->user?></td>
						<td><?=$row->number?></td>
						
						<td><?=$cash_currency_market_state[$row->state]?></td>
						<td>						
						<? 
						if($row->state==0 && $row->btime==0){
							if($member_id!=$row->member_id){
						?><a  class="btn btn-info"  href="<?=site_url('/cash_currency_market/buy/'.$row->cash_currency_market_id)?>" onclick="javascript:return confirm('确定购买吗？');">购买</a><?
							}else{
						?><a  class="btn btn-info"  href="<?=site_url('/cash_currency_market/cancel/'.$row->cash_currency_market_id)?>" onclick="javascript:return confirm('确定取消吗？');">取消</a><?
							}
						}else if($member_id==$row->member_id && $row->state==1 ){
						?><a class="btn btn-info"  href="<?=site_url('/cash_currency_market/confirm/'.$row->cash_currency_market_id)?>" onclick="javascript:return confirm('确认收到款吗？');" style="margin-right:10px">确认收款</a><a  class="btn btn-info"  href="<?=site_url('/cash_currency_market/undo/'.$row->cash_currency_market_id)?>" onclick="javascript:return confirm('确定撤消吗？');">撤消</a><?
						}else{
							echo "--";
						}
						?>
						</td>
					</tr>
					<?
					}
					?>				
				</tbody>
			</table>
			<?=$pagination?>
</div>

<div class="dataTables_wrapper form-inline">
 			<?=isset($hint) ? $hint : ''?>
 							<div class="tile-stats tile-cyan">
								<h3>出售列表</h3>
							</div>
         <table class="table table-bordered table-striped datatable">
                     <thead>
					<tr>
						<th>发布时间</th>
						<th>数量</th>
						<th>购买者</th>
						<th>购买电话</th>
						<th>下单时间</th>
						<th>状态</th>
						<th>操作</th>
					</tr>
				</thead>
			<?
					foreach($member_transfer0 as $key=>$row){
					?>
				<tr class="odd gradeX">
						<td><?=date("Y-m-d H:i",$row->ctime)?></td>
						<td><?=$row->number?></td>
						<td><?=$row->buyer_user?></td>
						<td><?=$row->buyer_mobile?></td>
						<td><?=$row->btime>0?date("Y-m-d H:i",$row->btime):"--"?></td>
						<td><?=$cash_currency_market_state[$row->state]?></td>
						<td>
						<? 
						if($row->state==0 && $row->btime==0){
							if($member_id!=$row->member_id){
						?><a  class="btn btn-navy"  href="<?=site_url('/cash_currency_market/buy/'.$row->cash_currency_market_id)?>" onclick="javascript:return confirm('确定购买吗？');">购买</a><?
							}else{
						?><a  class="btn btn-bule"  href="<?=site_url('/cash_currency_market/cancel/'.$row->cash_currency_market_id)?>" onclick="javascript:return confirm('确定取消吗？');">取消</a><?
							}
						}else if($member_id==$row->member_id && $row->state==1 ){
						?><a class="btn btn-navy"  href="<?=site_url('/cash_currency_market/confirm/'.$row->cash_currency_market_id)?>" onclick="javascript:return confirm('确认收到款吗？');" style="margin-right:10px">确认收款</a><a  class="btn btn-navy"  href="<?=site_url('/cash_currency_market/undo/'.$row->cash_currency_market_id)?>" onclick="javascript:return confirm('确定撤消吗？');">撤消</a><?
						}else{
							echo "--";
						}
						?></td>
					</tr>
					<?
					}
					?>				
				</tbody>
		</table>

			<div class="tile-stats tile-orange">
 				<h3>购买列表</h3>
 			</div>
       <table class="table table-bordered table-striped datatable">
			<thead>
					<tr>
						<th>购买时间</th>					
						<th>会员编号</th>			
						<th>出售者</th>	
						<th>出售电话</th>
						<th>数量</th>
						<th>付款方式</th>
						<th>状态</th>
					</tr>
				</thead>
			<?
				foreach($member_transfer1 as $key=>$row){
					?>
					<tr class="odd gradeX">
						<td><?=$row->btime>0?date("Y-m-d H:i",$row->btime):"--"?></td>
						<td><?=$row->user?></td>
						<td><?=$row->name?></td>
						<td><?=$row->mobile?></td>
						<td><?=$row->number?></td>
						<td>收款银行:<?=$row->collection_bank?>&nbsp;&nbsp;开户行:<?=$row->bank?><br/>收款姓名:<?=$row->name?>&nbsp;&nbsp;收款帐号:<?=$row->account?></td>
						<td><?=$cash_currency_market_state[$row->state]?></td>
					</tr>
					<?
				      }
					?>				
				</tbody>
		</table>
	</div>
<?php $this->load->view('footer.php') ?>