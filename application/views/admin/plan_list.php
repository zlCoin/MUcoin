<?=isset($admin_header) ? $admin_header : ''?>
<div class="app">

	
<?=isset($admin_menu) ? $admin_menu : ''?>
	<section class="layout">
	
<?=isset($admin_left) ? $admin_left : ''?>
	

		<section class="main-content">

			<header class="header navbar bg-default">
				<ul class="nav navbar-nav">
					<li class="active">
						<a href="javascript:;">保本计划</a>
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
												<th>会员ID</th>
												<th>会员姓名</th>
												<th>金额</th>
												<th>收款银行</th>
												<th>收款姓名</th>
												<th>银行帐号</th>
												<th>开卡地区</th>
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
												<td><?=$row->member_id?></td>
												<td><?=$row->user?></td>
												<td><?=$row->money?></td>
												<td><?=$row->bank?></td>
												<td><?=$row->bank_name?></td>
												<td><?=$row->account?></td>
												<td><?=$row->province."".$row->city?></td>
												<td><?=$row->state==1?"付款":"未审批"?></td>
												<td><?
											if($row->state==1){
											?>
											<a href="<?=site_url('admin/plan/payment/'.$row->plan_id)?>" class="btn btn-danger">付款</a>
											<?
											}else{
											?><a href="<?=site_url('admin/plan/confirm/'.$row->plan_id)?>" class="btn btn-info">确定</a><?
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