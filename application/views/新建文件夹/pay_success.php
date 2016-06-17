<?=isset($header) ? $header : ''?>
	<div class="grid_10">
		<div class="box round ">
			<h2>支付成功</h2>
			<div class="block " style="font-size:20px">
                  支付成功,您的帐号管理费有效期至<?=date("Y-m-d H:i",$row->expiration_date)?>
			</div>
		</div>
	</div>
	<div class="clear">
	</div>
</div>
<div class="clear"></div>
<script>

</script>
<?=isset($footer) ? $footer : ''?>