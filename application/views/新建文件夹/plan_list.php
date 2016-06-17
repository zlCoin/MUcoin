<?=isset($header) ? $header : ''?>
<div class="grid_10">
	<div class="box round grid">
		<h2>公告</h2>
		<div class="block" style="padding-left:100px;padding-right:100px">
			
			<?=isset($hint) ? $hint : ''?>
			

<form id="theForm" name="theForm" method="post" action="<?=site_url('/plan/exchange')?>" >
<?
if($plan>0){
?>

	<div style="text-align:center"><input type="button" class="btn btn-grey" value="已经兑换"></div>
<?
}else{
	if($max>=22 && date("Y-m-d H:i",$row->atime) >= '2016-01-01 00:00:00'){ 
	?>
		<div style="text-align:center"><button class="btn btn_disabled" disabled  type="button" >帐户注销</button></div>
	<?
	}else{
	?>
	<div style="text-align:center"><button class="btn btn-grey"   type="button" >帐户注销条件不满足</button></div>
	
	<?
	}
}
?>
   </form>	
		</div>
	</div>
</div>
<div class="clear"></div>
<script type="text/javascript" >
$(document).ready(function(){	
});
</script>
<?=isset($footer) ? $footer : ''?>