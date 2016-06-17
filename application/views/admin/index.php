<?=isset($admin_header) ? $admin_header : ''?>
<div class="app">
<?=isset($admin_menu) ? $admin_menu : ''?>
	<section class="layout">
<?=isset($admin_left) ? $admin_left : ''?>
		<section class="main-content">
			<div class="content-wrap">
                <div class="row mg-b">
                    <div class="col-xs-6"><h3 class="no-margin">控制台</h3></div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <section class="panel">
                            <div class="panel-body">
                                <div class="circle-icon bg-success">
                                    <i class="fa fa-microphone"></i>
                                </div>
                                <div>
                                    <h3 class="no-margin"><?=$member_count?></h3>新用户
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <section class="panel">
                            <div class="panel-body">
                                <div class="circle-icon bg-danger"><i class="fa fa-anchor"></i></div>
                                <div><h3 class="no-margin"><?=$member_free?></h3>静态资产包</div>
                            </div>
                        </section>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <section class="panel">
                            <div class="panel-body">
                                <div class="circle-icon bg-danger"><i class="fa fa-anchor"></i></div>
                                <div><h3 class="no-margin"><?=$member_cash?></h3>动态奖金</div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
            <div class="site-overlay"></div>
        </section>
    </section>
</div>
<?=isset($admin_footer) ? $admin_footer : ''?>