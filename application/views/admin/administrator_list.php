<?=isset($admin_header) ? $admin_header : ''?>
<div class="app">

	
<?=isset($admin_menu) ? $admin_menu : ''?>
	<section class="layout">
	
<?=isset($admin_left) ? $admin_left : ''?>
	

		<section class="main-content">

			<header class="header navbar bg-default">
				<ul class="nav navbar-nav">
					<li class="active">
						<a href="javascript:;">管理员</a>
					</li>			
				</ul>
				<ul class="nav navbar-nav" style="float:right;">
					<li style="width:120px">
						<a href="<?=site_url('admin/administrator/add')?>" class="btn btn-warning">新增</a>
					</li>		
				</ul>
			</header>


			<div class="content-wrap">
				
				
				<div class="row">
					
					
					<div class="col-md-12">
						<section class="panel">
							<form class="form-inline" method="post" name="searchForm" id="searchForm" action="<?=site_url('admin/administrator')?>">
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
												<th>ID</th>
												<th>帐号</th>
												<th>姓名</th>
												<th>角色</th>
												<th>手机</th>
												<th>邮箱</th>
												<th>操作</th>
											</tr>
										</thead>
										<tbody>
											<?
											foreach($list as $key=>$row){
											?>
											<tr>
												<td><?=$row->admin_id?></td>
												<td><?=$row->user?></td>
												<td><?=$row->name?></td>
												<td><?=isset($role[$row->role_id])?$role[$row->role_id]:"--"?></td>
												<td><?=$row->mobile?></td>
												<td><?=$row->email?></td>
												<td><a href="<?=site_url('admin/administrator/modify/'.$row->admin_id)?>" class="btn btn-info">编辑</a>
						<a href="<?=site_url('admin/administrator/delete/'.$row->admin_id)?>" class="btn btn-danger" onclick="javascript:return del_sure();">删除</a></td>
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