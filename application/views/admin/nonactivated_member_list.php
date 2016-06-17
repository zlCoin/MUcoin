<?=isset($admin_header) ? $admin_header : ''?>
<div class="app">
<?=isset($admin_menu) ? $admin_menu : ''?>
	<section class="layout">
<?=isset($admin_left) ? $admin_left : ''?>
		<section class="main-content">
			<header class="header navbar bg-default">
				<ul class="nav navbar-nav">
					<li class="active">
						<a href="javascript:;">未激活会员 共计：<?=$total_rows?></a> 
					</li>	
				</ul>
			</header>
			<div class="content-wrap">
				<div class="row">
					<div class="col-md-12">
						<section class="panel">
							<div class="panel-body no-padding">
								<div class="table-responsive">
									<form class="form-inline" method="post" name="searchForm" id="searchForm" action="<?=site_url('admin/nonactivated_member')?>">
										<ol class="breadcrumb">
										<li>
										<a href="javascript:;">查询</a>
										</li>
										<li>
										<input type="text" class="form-control" name="keyword" id="keyword" value="<?=$keyword?>" >
										</li>
										<li class="active"><button type="submit" class="btn btn-primary">&nbsp;<i class="fa fa-search"></i>&nbsp;提交&nbsp;</button></li>
										</ol>
                                	</form>
									<table data-sortable="" class="table table-striped responsive" data-sortable-initialized="true">
										<thead>
											<tr>
												<th>ID</th>
												<th>帐号</th>
												<th>姓名</th>
												<th>套餐</th>
												<th>手机</th>
												<th>推荐人</th>
												<th>注册时间</th>
												<th>操作</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach($list as $key=>$row){ ?>
											<tr>
												<td><?=$row->member_id?></td>
												<td><?=$row->user?></td>
												<td><?=$row->name?></td>
												<td><?=$row->tc_price?></td>
												<td><?=$row->mobile?></td>
												<td><?=$row->parent_id > 0 ? $row->parent_user : ""?></td>
												<td><?=date("Y-m-d H:i",$row->ctime)?></td>
												<td>
													<a href="<?=site_url('admin/nonactivated_member/show/'.$row->member_id)?>" class="btn btn-info" >查看</a>
													<?php if($row->lock == 0){?>
													<a href="<?=site_url('admin/member/login/'.$row->member_id)?>" class="btn btn-danger" target="_blank">登陆</a>
													<?php } ?>
													<a href="<?=site_url('admin/nonactivated_member/activation/'.$row->member_id)?>" class="btn btn-primary">激活</a>
													<a href="<?=site_url('admin/nonactivated_member/del_action/'.$row->member_id)?>" class="btn btn-primary">删除</a>
												</td>
											</tr>	
											<?php }	?>
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