<?=isset($admin_header) ? $admin_header : ''?>
<div class="app">

	
<?=isset($admin_menu) ? $admin_menu : ''?>
	<section class="layout">
	
<?=isset($admin_left) ? $admin_left : ''?>
	

		<section class="main-content">

			<header class="header navbar bg-default">
				<ul class="nav navbar-nav">
					<li class="active">
						充值卡密码帐单
					</li>			
				</ul>
			</header>


			<div class="content-wrap">
				
				
				<div class="row">
					
					
					<div class="col-md-12">
						<section class="panel">
							<form class="form-inline" method="post" name="searchForm" id="searchForm" action="<?=site_url('admin/activation_code_bill')?>">
							<ol class="breadcrumb">
                                    <li>
                                        查询: (卡密/使用人)
                                    </li>
                                    <li>
                                        <input type="text" class="form-control" name="keyword" id="keyword" value="<?=$keyword?>" >
                                    </li>
                                    <li class="active"><button type="submit" class="btn btn-primary">&nbsp;<i class="fa fa-search"></i>&nbsp;提交&nbsp;</button></li>
                                </ol></form>
							<div class="panel-body no-padding">
								<div class="table-responsive">
									<table data-sortable="" class="table table-striped responsive" data-sortable-initialized="true">
										<thead>
											<tr>
												<th>充值时间</th>
												<th>充值卡密码</th>
												<th>购买人</th>
												<th>购买时间</th>
												<th>使用人</th>
												<th>有效期</th>
											</tr>
										</thead>
										<tbody>
											<?
											$t=30*86400;
											foreach($list as $key=>$row){
											?>
											<tr>
												<td><?=$row->etime>0?date("Y-m-d H:i",$row->etime):"未使用"?></td>
												<td><?=$row->code?></td>
												<td><?=$row->user?></td>
												<td><?=date("Y-m-d H:i",$row->btime)?></td>		
												<td><?=$row->activation_user?></td>										
												<td><?=date("Y-m-d H:i",$row->btime+$t)?></td>
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