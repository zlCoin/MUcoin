<?=isset($admin_header) ? $admin_header : ''?>
<div class="app">

	
<?=isset($admin_menu) ? $admin_menu : ''?>
	<section class="layout">
	
<?=isset($admin_left) ? $admin_left : ''?>
	

		<section class="main-content">

			<header class="header navbar bg-default">
				<ul class="nav navbar-nav">
					<li class="active">
						<a href="javascript:;">商城帐单</a>
					</li>	
				</ul>
			</header>


			<div class="content-wrap">
				
				
				<div class="row">
					
					
					<div class="col-md-12">
						<section class="panel">
							<form class="form-inline" method="post" name="searchForm" id="searchForm" action="<?=site_url('admin/pay')?>">
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
												<th>时间</th>
												<th>流水单号</th>
												<th>交易号</th>
												<th>会员ID</th>
												<th>会员姓名</th>
												<th>金额</th>
												<th>购物积分</th>
												<th>操作</th>
											</tr>
										</thead>
										<tbody>
											<?
											foreach($list as $key=>$row){
											?>
											<tr>
												<td><?=date("Y-m-d H:i",$row->ctime)?></td>
												<td><?=$row->no?></td>
												<td><?=$row->trade_no?></td>
												<td><?=$row->member_id?></td>
												<td><?=$row->user?></td>
												<td><?=$row->money?></td>
												<td><?=$row->shopping_currency?></td>
												<td><a href="<?=site_url('admin/shop_pay/confirm/'.$row->shop_pay_id)?>" class="btn btn-info">确定</a>&nbsp;<a href="<?=site_url('admin/shop_pay/payment/'.$row->shop_pay_id)?>" class="btn btn-danger">付款</a></td>
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