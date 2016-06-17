<?php $this->load->view('header.php') ?>
<!-- Imported styles on this page -->
<link rel="stylesheet" href="/assets/js/aci-tree/css/aciTree.css">
<h2>团队结构</h2>
<br />

<div class="panel panel-primary">
	<div class="panel-body no-padding" style="padding: 5px 0;">
		<div id="tree1" class="aciTree aciTreeFullRow" style="min-height: 70px;"></div>
	</div>
</div>
<script src="/assets/js/aci-tree/js/jquery.aciPlugin.min.js"></script>
<script src="/assets/js/aci-tree/js/jquery.aciTree.min.js"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
	var $ = jQuery,
		$events_log = $("#events_log");
	$('#tree1').aciTree({
		ajax:{
			url: '/Tree/GraphicalAjax/'
		},
		fullRow: true,
		columnData: [
			{
				props: 'state',
				width: 150
			},
		]
	})
});
</script>
<?php $this->load->view('footer.php') ?>

