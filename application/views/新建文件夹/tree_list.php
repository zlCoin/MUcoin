<?=isset($header) ? $header : ''?>
<div class="grid_10">
	<div class="box round grid">
		<h2>全体队友</h2>
		<div class="block">		
		<div class="dataTables_length"></div>
		<div class="dataTables_filter"></div>
		
		<form class="form-inline" method="post" name="searchForm" id="searchForm" action="<?=site_url('tree')?>">
		<table class="form" style="width: 40%;">
					<tr>
						<td  width="10%">
							<label>
							查询:</label>
						</td>
						<td >
					<input type="text"  name="keyword" id="keyword" value="<?=$keyword?>" ><button type="submit" class="btn btn-primary" style="margin-left:10px;line-height: 22px;">&nbsp;<i class="fa fa-search"></i>&nbsp;提交&nbsp;</button>
						</td>
					</tr>	</table>	
					</form>
			<table class="data display" >
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
				<?
					foreach($list as $key=>$row){
					?>
					<tr class="odd gradeX">
						<td><?=$row->member_id?></td>
						<td><?=$row->user?></td>
						<td><?=$row->name?></td>
						<td>第<?=$row->level-$level?>代</td>
						<td><?=date("Y-m-d H:i",$row->ctime)?></td>
						<td><?=$row->atime>0?date("Y-m-d H:i",$row->atime):"--"?></td>
						<td></td>
					</tr>
					<?
					}
					?>				
				</tbody>
			</table>
			<?=$pagination?>
		</div>
	</div>
</div>
<div class="clear"></div>
<script type="text/javascript" >
$(document).ready(function(){	
});
</script>
<?=isset($footer) ? $footer : ''?>