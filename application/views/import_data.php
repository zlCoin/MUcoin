<?php $this->load->view('header.php') ?>
<h2>导入数据</h2>
<br />
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary">
			<div class="panel-body">
			<div class="block ">
			<?=isset($hint) ? $hint : ''?>
			<form id="theForm" name="theForm" method="post" action="<?=site_url('/import_data/data_submit')?>" >
 	        <table class="table table-bordered table-striped datatable">
				<tr>
						<td>
							
						</td>
						<td>
							<button class="btn btn-navy" type="submit" >导入数据</button>
						</td>
					</tr>
				</table>
                </form>

 				</div>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('footer.php') ?>