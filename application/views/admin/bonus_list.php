<?=isset($admin_header) ? $admin_header : ''?>
<div class="app">

	
<?=isset($admin_menu) ? $admin_menu : ''?>
	<section class="layout">
	
<?=isset($admin_left) ? $admin_left : ''?>
	

		<section class="main-content">

			<header class="header navbar bg-default">
				<ul class="nav navbar-nav">
					<li class="active">
						<a href="javascript:;">奖金明细</a>
					</li>	
				</ul>
			</header>


			<div class="content-wrap">
				
				
				<div class="row">
					
					
					<div class="col-md-12">
						<section class="panel">
							 <form class="form-inline" method="post" name="searchForm" id="searchForm" action="<?=site_url('admin/bonus')?>">
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
												<th>会员编号</th>
												<th>结算日期</th>
												<th>推荐奖</th>
												<th>积分赠送</th>
												<th>培育金</th>
												<th>实发</th>
												<th>自由股</th>
											</tr>
										</thead>
										<tbody>
											<?
											foreach($list as $key=>$row){
											?>
											<tr>
												<td><?=$row->member_id?></td>
												<td><?=date("Y-m-d",$row->ctime)?></td>
												<td><?=$row->dividend?></td>
												<td><?=$row->recommend?></td>
												<td><?=$row->management?></td>
												<td><?=$row->actual_release?></td>
												<td><?=$row->free_stock?></td>
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