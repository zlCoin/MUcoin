<?=isset($admin_header) ? $admin_header : ''?>
<div class="app">

	
<?=isset($admin_menu) ? $admin_menu : ''?>
	<section class="layout">
	
<?=isset($admin_left) ? $admin_left : ''?>
	

		<section class="main-content">

			<header class="header navbar bg-default">
				<ul class="nav navbar-nav">
					<li class="active">
						<a href="javascript:;">自由股明细</a>
					</li>	
				</ul>
			</header>


			<div class="content-wrap">
				
				
				<div class="row">
					
					
					<div class="col-md-12">
						<section class="panel">
							<form class="form-inline" method="post" name="searchForm" id="searchForm" action="<?=site_url('admin/free_stock')?>">
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
												<th>买入时间</th>
												<th>会员</th>
												<th>自由股编号</th>
												<th>数量</th>
												<th>日积分赠送</th>
												<th>积分赠送次数</th>
												<th>累计积分赠送</th>
												<th>状态</th>
											</tr>
										</thead>
										<tbody>
											<?
											foreach($list as $key=>$row){
											?>
											<tr>
												<td><?=date("Y-m-d H:i",$row->ctime)?></td>
												<td><?=$row->user?></td>
												<td><?=$row->no?></td>
												<td><?=$row->number?></td>
												<td><?=$row->day_dividend?></td>
												<td><?=$row->time?></td>
												<td><?=$row->cumulative_dividend?></td>
												<td><?=$row->state==0?"积分赠送":"出局"?></td>
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