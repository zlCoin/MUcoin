<?=isset($admin_header) ? $admin_header : ''?>
<div class="app">

	
<?=isset($admin_menu) ? $admin_menu : ''?>
	<section class="layout">
	
<?=isset($admin_left) ? $admin_left : ''?>
	

		<section class="main-content">

			<header class="header navbar bg-default">
				<ul class="nav navbar-nav">
					<li class="active">
						<a href="javascript:;">开始积分赠送</a>
					</li>			
				</ul>
			</header>


			<div class="content-wrap">
				
				
				<div class="row">
					
					
					<div class="col-md-12">
						<section id="elements" class="tab-pane active">
                                    <form class="form-inline" method="post" name="searchForm" id="searchForm" action="<?=site_url('admin/a_bonus/a_bonus_submit/'.$a_bonus_id)?>">
                                    
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <section class="panel">
                                                <div class="panel-body">
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label"></label>
                                                            <div class="col-sm-9">
																日期：<?=date("Y-m-d")?>&nbsp;&nbsp;<?=$state==1?"已经积分赠送":"未积分赠送"?>
                                                            </div>
															<label class="col-sm-3 control-label"></label>
															<div class="col-sm-9">
																还需要积分赠送：<?=$free_stock_count?>条,已经积分赠送<?=$bonus_count?>
                                                            </div>
															<label class="col-sm-3 control-label"></label>
															<div  class="col-sm-9" >	&nbsp;														
																					
<div class="spinner" id="loading_bar" style="display:none">

  <div class="bounce1"></div>

  <div class="bounce2"></div>

  <div class="bounce3"></div>

</div>
                                                            </div>

                                                        </div>  
														<div class="form-group">
                                                            <label class="col-sm-3 control-label"></label>
                                                            <div class="col-sm-9">
																<?
																if($system_switch->day_dividend==0){
																	?>
																	 <button class="btn btn-default" type="button" >暂停积分赠送</button>
																	<?
															}else{
																		if($state==1){
																		?>
																	 <button class="btn btn-default" type="button"  >结束积分赠送</button>
																	<?
																		}else{
																			if($bonus_count>0){
																			?>
                                                                <button class="btn btn-default" type="submit"  >继续积分赠送</button>
																<?
																			}else{
																?>
                                                                <button class="btn btn-default" type="submit">开始积分赠送</button>
																<?
																			}
																		}
															}
																?>
                                                            </div>
                                                        </div>  
														
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                    </form>
                                </section>
					</div>
				</div>
			</div>

		<div class="site-overlay"></div></section>

	</section>
</div>
<script type="text/javascript" >
	function a_bonus_(){
		$("#loading_bar").show();
		$.get("/admin/a_bonus/a_bonus_submit/<?=$a_bonus_id?>/<?=$free_stock_count?>", function(result){			
			$("#loading_bar").hide();
			if(result=="OK")
				alert("积分赠送成功");
			else
				alert("本轮积分赠送结束，请继续积分赠送")
			//parent.location.reload();
		});
	}
</script>
<?=isset($admin_footer) ? $admin_footer : ''?>