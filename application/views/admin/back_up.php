<?=isset($admin_header) ? $admin_header : ''?>
<div class="app">

	
<?=isset($admin_menu) ? $admin_menu : ''?>
	<section class="layout">
	
<?=isset($admin_left) ? $admin_left : ''?>
	

		<section class="main-content">

			<header class="header navbar bg-default">
				<ul class="nav navbar-nav">
					<li class="active">
						<a href="javascript:;">系统备份</a>
					</li>	
				</ul>
			</header>


			<div class="content-wrap">
				
				
				<div class="row">
					
					
					<div class="col-md-12">
						<section class="panel">
							
							<div class="panel-body no-padding">
								<div class="table-responsive">
									<table data-sortable="" class="table table-striped responsive" data-sortable-initialized="true">
										<thead>
											<tr>
												<th>文件</th>
												<th>操作</th>
											</tr>
										</thead>
										<tbody>
											<?
											 function traverse($path = '.') {
												$current_dir = opendir($path);    //opendir()返回一个目录句柄,失败返回false
												while(($file = readdir($current_dir)) !== false) {    //readdir()返回打开目录句柄中的一个条目
													$sub_dir = $path . DIRECTORY_SEPARATOR . $file;    //构建子目录路径
													if($file == '.' || $file == '..') {
														continue;
													} else if(is_dir($sub_dir)) {    //如果是目录,进行递归
														traverse($sub_dir);
													} else {    //如果是文件,直接输出
														?>
														<tr>
												<td><?=$file?></td>
												<td><a href="<?='/'.$path.'/'.$file?>" class="btn btn-info">下载</a></td>
											</tr>	
														<?
													}
												}
											}

											traverse('./uploads/back_up');
											?>
										</tbody>
									</table>
								</div>
							</div>
						</section>
					</div>
				</div>
			</div>

		<div class="site-overlay"></div></section>

	</section>
</div>
<?=isset($admin_footer) ? $admin_footer : ''?>