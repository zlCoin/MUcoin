	<?php $this->load->view('header.php') ?>
	<div class="main-content">
	    <ol class="breadcrumb bc-3">
			<li><a href="/help"><i class="fa-home"></i>返回列表</a></li>
			<li>详细</li>
		</ol>
		<h1 class="text-center"><?=$row->title?></h1>
		<p style="color:#FF6600" class="text-center">[时间：<?=date("Y/m/d",$row->ctime)?>]</p>
		<div class="row">
			<div class="dataTables_content">
				<?=$row->content?>
			</div>
		</div>
	</div>

<?php $this->load->view('footer.php') ?>