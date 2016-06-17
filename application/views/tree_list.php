<?php $this->load->view('header.php') ?>
<h2>全体队友</h2>
<br />
<div class="dataTables_wrapper form-inline">
	<?=isset($hint) ? $hint : ''?>
	<div class="dataTables_top">
		<form method="post" action="<?=site_url('Tree')?>">
			<div class="col-sm-2 pb15">
				<input type="text" placeholder="账号" value="<?=$keyword?>" name="keyword" class="form-control" />
			</div>
			<div class="col-sm-2 pb15">
				<input type="submit" class="btn btn-blue" value="搜索" />
			</div>
		</form>
	</div>
	<table class="table table-bordered table-striped datatable">
		<thead>
			<tr>
				<th>ID</th>
				<th>账号</th>
				<th>姓名</th>
				<th>第X代</th>
				<th>注册时间</th>
				<th>激活时间</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($list as $key=>$row){ ?>
			<tr class="odd gradeX">
				<td><?=$row->member_id?></td>
				<td><?=$row->user?></td>
				<td><?=$row->name?></td>
				<td>第<?=$row->level-$level?>代</td>
				<td><?=date("Y-m-d H:i",$row->ctime)?></td>
				<td><?=$row->atime>0?date("Y-m-d H:i",$row->atime):"--"?></td>
				<td></td>
			</tr>
			<?php }?>				
		</tbody>
	</table>
	<?=$pagination?>
</div>
<?php $this->load->view('footer.php') ?>