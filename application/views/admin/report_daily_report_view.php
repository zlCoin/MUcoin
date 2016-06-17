<?=isset($admin_header) ? $admin_header : ''?>
<div class="app">

	
<?=isset($admin_menu) ? $admin_menu : ''?>
	<section class="layout">
	
<?=isset($admin_left) ? $admin_left : ''?>
	

		<section class="main-content">

			<header class="header navbar bg-default">
				<ul class="nav navbar-nav">
					<li class="active">
						<a href="javascript:;">每日业绩</a>
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
												<th>日期</th>
												<th>新购买股数</th>
												<th>新激活用户数</th>											
											</tr>
										</thead>
										<tbody>
											<?
												$query = $this->db->query("
																			
																			select TopDate.new_date 
																					,stock.new_number
																					,member.new_user_count

																			from
																			(
																				select DATE_FORMAT(date_add(curdate(), interval 0 day) ,'%Y-%m-%d') as new_date
																				union
																				select DATE_FORMAT(date_add(curdate(), interval -1 day) ,'%Y-%m-%d') 
																				union
																				select DATE_FORMAT(date_add(curdate(), interval -2 day) ,'%Y-%m-%d') 
																				union
																				select DATE_FORMAT(date_add(curdate(), interval -3 day) ,'%Y-%m-%d') 
																				union
																				select DATE_FORMAT(date_add(curdate(), interval -4 day) ,'%Y-%m-%d') 
																				union
																				select DATE_FORMAT(date_add(curdate(), interval -5 day) ,'%Y-%m-%d') 
																				union
																				select DATE_FORMAT(date_add(curdate(), interval -6 day) ,'%Y-%m-%d') 
																				union
																				select DATE_FORMAT(date_add(curdate(), interval -7 day) ,'%Y-%m-%d') 
																				union
																				select DATE_FORMAT(date_add(curdate(), interval -8 day) ,'%Y-%m-%d') 
																				union
																				select DATE_FORMAT(date_add(curdate(), interval -9 day) ,'%Y-%m-%d') 
																				union
																				select DATE_FORMAT(date_add(curdate(), interval -10 day) ,'%Y-%m-%d') 
																				union
																				select DATE_FORMAT(date_add(curdate(), interval -11 day) ,'%Y-%m-%d') 
																				union
																				select DATE_FORMAT(date_add(curdate(), interval -12 day) ,'%Y-%m-%d') 
																				union
																				select DATE_FORMAT(date_add(curdate(), interval -13 day) ,'%Y-%m-%d') 
																				union
																				select DATE_FORMAT(date_add(curdate(), interval -14 day) ,'%Y-%m-%d') 
																				union
																				select DATE_FORMAT(date_add(curdate(), interval -15 day) ,'%Y-%m-%d') 
																			) TopDate left join 
																			(
																				select sum(s.number) as new_number,DATE_FORMAT(from_unixtime(s.ctime) ,'%Y-%m-%d') as new_date
																				from q_free_stock s group by DATE_FORMAT(from_unixtime(s.ctime) ,'%Y-%m-%d') 
																				order by DATE_FORMAT(from_unixtime(s.ctime) ,'%Y-%m-%d') desc limit 0,30
																			) stock
																			on TopDate.new_date = stock.new_date
																			left join 
																			(
																				select count(1) as new_user_count,DATE_FORMAT(from_unixtime(m.ctime) ,'%Y-%m-%d') as new_date
																				from q_member m group by DATE_FORMAT(from_unixtime(m.ctime) ,'%Y-%m-%d') ,m.state
																				having m.state=1
																				order by DATE_FORMAT(from_unixtime(m.ctime) ,'%Y-%m-%d') desc limit 0,30
																			) member
																			on TopDate.new_date = member.new_date;

																		");

												foreach ($query->result() as $row){
											?>
														<tr>
															<td><?=$row->new_date?></td>
															<td><?=$row->new_number?></td>
															<td><?=$row->new_user_count?></td>
															
														</tr>											
											<?
													}	
												
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