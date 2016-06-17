<?php $this->load->view('header.php') ?>
<h2>分享朋友圈</h2>
<br />
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary">
			<div class="panel-body">
			<div class="block ">
			<?=isset($hint) ? $hint : ''?>
 	        <table class="table table-bordered table-striped datatable">
					<tr>
						<td style="color:red; font-size:15px;">
							http://<?php echo $_SERVER['SERVER_NAME']?>/reg/member/<?=$row->user?>
						</td>
						
					</tr>					
					
					 
				</table>
 				</div>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('footer.php') ?>