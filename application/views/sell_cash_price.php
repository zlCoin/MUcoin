<?php $this->load->view('header.php') ?>
<h2>购买积分</h2> <span  style="color:red;">购买积分请扫描下方二维码 进行支付</span>
<br />
<div class="dataTables_wrapper form-inline">
	<div class="block">		
	<?=isset($hint) ? $hint : ''?>
 	<table class="table table-bordered table-striped datatable">
		 
				 
				<tr>
						<td class="col1">
							<label>
								扫描微信二维码:</label>
						</td>
						<td class="col2">
						33333				
						</td>
					</tr>	
					<tr>
						<td class="col1">
							<label>
								扫描支付宝二维码：</label>
						</td>
						<td class="col2">
							 说得对				
						</td>
					</tr>	
					 
					 
				</table>
 </div>
  
<?php $this->load->view('footer.php') ?>