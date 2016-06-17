<?=isset($admin_header) ? $admin_header : ''?>
<div class="app">

	
<?=isset($admin_menu) ? $admin_menu : ''?>
	<section class="layout">
	
<?=isset($admin_left) ? $admin_left : ''?>
	

		<section class="main-content">

			<header class="header navbar bg-default">
				<ul class="nav navbar-nav">
					<li class="active">
						<a href="javascript:;">充值卡密码</a>
					</li>			
				</ul>
				<ul class="nav navbar-nav" style="float:right;">
					<li style="width:120px">
						<a href="<?=site_url('admin/activation_code/add')?>" class="btn btn-warning">新增</a>
					</li>		
				</ul>
			</header>


			<div class="content-wrap">
				
				
				<div class="row">
					
					
					<div class="col-md-12">
						<section class="panel">
							<form class="form-inline" method="post" name="searchForm" id="searchForm" action="<?=site_url('admin/activation_code')?>">
							<ol class="breadcrumb">
                                    <li>
                                        <a href="javascript:;">查询</a>
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
												<th>充值卡密码</th>
												<th>购买人</th>
												<th>购买时间</th>
												<th>充值时间</th>
												<th>状态</th>
												<th>批号</th>
												<th>操作</th>
											</tr>
										</thead>
										<tbody>
											<?
											foreach($list as $key=>$row){
											?>
											<tr>
												<td><?=$row->code?></td>
												<td><?=$row->user?></td>
												<td><?=date("Y-m-d H:i",$row->btime)?></td>												
												<td><?=$row->etime>0?date("Y-m-d H:i",$row->etime):"未使用"?></td>
												<td><?=$activation_code_state[$row->state]?></td>
												<td><?=$row->batch_no?></td>
												<td><?	if($row->state==0){	
											?>
						<a class="btn btn-danger"  href="<?=site_url('admin/activation_code/invalid/'.$row->activation_code_id)?>" onclick="javascript:return confirm('确定失效吗？');">失效</a><?
											}?></td>
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