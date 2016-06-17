<?php $this->load->view('header.php') ?>
<h2>节点列表</h2>
<br />
<div class="dataTables_wrapper form-inline">
	<?=isset($hint) ? $hint : ''?>
	<table class="table table-bordered table-striped datatable">
		<thead>
			<tr>						
				<th>账号</th>
				<th>套餐</th>
				<th>注册时间</th>
				<th>激活时间</th>
				<th>激活</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($nodeList as $key=>$row){?>
			<tr class="odd gradeX">
				<td><?=$row->user?></td>
				<td><?=$row->tc_price?></td>
				<td><?=date("Y-m-d H:i",$row->ctime)?></td>
				<td><?=$row->atime > 0 ? date("Y-m-d H:i",$row->atime) : "--"?></td>
				<td>
				<?
				if($row->state==0){
				?>
					<a href="<?=site_url('/My_team/activation/'.$row->member_id)?>" class="btn btn-grey btn-minus" onclick="javascript:return confirm('您需要消耗<?=$row->tc_price?>排单积分，确定激活吗？');">激活</a>
				<?
				}else{
					echo "已激活";
				}
				?>
				</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>
<?php if($list){ ?>
<h2>推荐列表</h2>
<br />
<div class="dataTables_wrapper form-inline">
	<?=isset($hint) ? $hint : ''?>
	<table class="table table-bordered table-striped datatable">
		<thead>
			<tr>						
				<th>账号</th>
				<th>套餐</th>
				<th>注册时间</th>
				<th>状态</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($list as $key=>$row){?>
			<tr class="odd gradeX">
				<td><?=$row->user?></td>
				<td><?=$row->tc_price?></td>
				<td><?=date("Y-m-d H:i",$row->ctime)?></td>
				<td>
				<?
				if($row->state==0){
					echo "<b style='color:red'>未激活</b>";
				}else{
					echo "已激活";
				}
				?>
				</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<?=$pagination?>
</div>
<?php } ?>
<?php $this->load->view('footer.php') ?>