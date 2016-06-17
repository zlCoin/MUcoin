<?=isset($admin_header) ? $admin_header : ''?>
<div class="app">
<?=isset($admin_menu) ? $admin_menu : ''?>
	<section class="layout">
	
<?=isset($admin_left) ? $admin_left : ''?>
		<section class="main-content">

			<header class="header navbar bg-default"> 
				<ul class="nav navbar-nav">
					<li class="active">
						<a href="javascript:;">会员 共计：<?=$total_rows?></a>
					</li>	
				</ul>
			</header>
			<div class="content-wrap">
				<div class="row">
					<div class="col-md-12">
						<section class="panel">
		  					<form class="form-inline" method="post" name="searchForm" id="searchForm" action="<?=site_url('admin/member')?>">
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
							<div class="panel-body no-padding">
								<div class="table-responsive">
									<table data-sortable="" class="table table-striped responsive" data-sortable-initialized="true">
										<thead>
											<tr>
												<th>ID</th>
												<th>帐号</th>
												<th>姓名</th>
												<th>奖金积分</th>
												<th>原始积分</th>
												<th>手机</th>
												<th>推荐人</th>
												<th>登录</th>
												<th>套餐</th>
												<th>激活时间</th>
												<th>操作</th>
											</tr>
										</thead>
										<?php if($list){ ?>
										<tbody>
											<?
											foreach($list as $key=>$row){
											?>
											<tr>
												<td><?=$row->member_id?></td>
												<td><?=$row->user?></td>
												<td><?=$row->name?></td>
												<td><?=$row->cash_currency?></td>
												<td><?=$row->electronic_currency?></td>
												<td><?=$row->mobile?></td>
												<td><?=$row->parent_id>0?$row->parent_user:"&nbsp;"?></td>
												<td><?=$row->lock==0?"正常":"冻结"?></td>
												<td><?=$row->tc_price?></td>
												<td><?=date("Y-m-d H:i",$row->atime)?></td>
												<td>
													<a href="<?=site_url('admin/member/modify/'.$row->member_id)?>" class="btn btn-info">管理</a>
													<? if($row->lock==0){ ?>
													<a href="<?=site_url('admin/member/login/'.$row->member_id)?>" class="btn btn-danger" target="_blank">登陆</a>
													<? }else{ ?>
													<a href="<?=site_url('admin/member/unlocking/'.$row->member_id)?>" class="btn btn-danger" onclick="javascript:return confirm('确定解冻吗？');">解冻</a>
													<? } ?>
												</td>
											</tr>
											<? } ?>
										</tbody>
										<?php } ?>
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