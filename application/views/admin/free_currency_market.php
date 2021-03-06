<?=isset($admin_header) ? $admin_header : ''?>
<div class="app">

	
<?=isset($admin_menu) ? $admin_menu : ''?>
	<section class="layout">
	
<?=isset($admin_left) ? $admin_left : ''?>
	

		<section class="main-content">

			<header class="header navbar bg-default">
				<ul class="nav navbar-nav">
					<li class="active">
						<a href="javascript:;">自由积分市场管理</a>
					</li>	
				</ul>
			</header>


			<div class="content-wrap">
				
				
				<div class="row">
					
					
					<div class="col-md-12">
						<section class="panel">
							<form class="form-inline" method="post" name="searchForm" id="searchForm" action="<?=site_url('admin/electronic_currency_transfer')?>">
							<ol class="breadcrumb">
                                    <li>
                                        <a href="javascript:;">查询</a>
                                    </li>
                                    <li>
                                        <a href="javascript:;"><input type="text" class="form-control" name="keyword" id="keyword" value="<?=$keyword?>" ></a>
                                    </li>
                                    <li class="active"><button type="submit" class="btn btn-primary">&nbsp;<i class="fa fa-search"></i>&nbsp;提交&nbsp;</button></li>
                                </ol></form>
							<div class="panel-body no-padding">
								<div class="table-responsive">
									<table data-sortable="" class="table table-striped responsive" data-sortable-initialized="true">
										<thead>
											<tr>
												<th width="150">发布时间</th>
												<th>会员</th>
												<th>数量</th>
												<th>价格</th>
												<th>手续费</th>
												<th>购买者</th>
												<th>购买时间</th>
												<th>状态</th>
												<th>操作</th>
											</tr>
										</thead>
										<tbody>
											<?
											foreach($list as $key=>$row){
											?>
											<tr>
												<td><?=date("Y-m-d H:i",$row->ctime)?></td>
						<td><?=$row->user?></td>
						<td><?=$row->number?></td>
						<td><?=$row->price?></td>
						<td><?=$row->poundage?></td>
						<td><?=$row->buyer_user?></td>
						<td><?=$row->btime>0?date("Y-m-d H:i",$row->btime):"--"?></td>
						<td><?=$free_currency_market_state[$row->state]?></td>
						<td>
						<?
											if($row->state!=2){	
											?>
						<a class="btn btn-danger"  href="<?=site_url('admin/free_currency_market/cancel/'.$row->free_currency_market_id)?>" onclick="javascript:return confirm('确定取消吗？');">取消</a><?
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
								</div>
							</div>
							<?=$pagination?>
						</section>
					</div>
				</div>
			</div>

		<div class="site-overlay"></div></section>

	</section>
</div>
<?=isset($admin_footer) ? $admin_footer : ''?>