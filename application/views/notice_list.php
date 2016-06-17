<?php $this->load->view('header.php') ?>
<h2>公告</h2>
<br />
<div class="dataTables_wrapper form-inline">
	<div class="block">		
	<?=isset($hint) ? $hint : ''?>
	<table class="table table-bordered table-striped datatable">
		<thead>
				<tr>
					<th>时间</th>
					<th>标题</th>
				</tr>
			</thead>
			<tbody>
			<?
				foreach($list as $key=>$row){
				?>
				<tr class="odd gradeX">
					<td style="width:150px"><?=date("Y/m/d H:i",$row->ctime)?></td>
					<td><a  href="<?=site_url('/notice/show/'.$row->notice_id)?>"><?=$row->title?></a></td>
				</tr>
				<?
				}
				?>			
			</tbody>
		</table>
		<?=$pagination?>
</div>
<?php $this->load->view('footer.php') ?>