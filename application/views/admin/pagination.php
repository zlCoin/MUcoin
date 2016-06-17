<div class="text-center">
	<ul class="pagination pagination-lg">
	<?
if($num_pages>0){
if($current_page==1){
?>
<?
}else{
?>
		<li>
			<a href="<?=site_url($url.$parameter.'/'.$page_up)?>">«</a>
		</li>
		<?
}	
?>

<?
		if($num_pages>7){
			if($current_page>=$num_pages-1)
				$f_c=$current_page-7;
			else
				$f_c=$current_page;
			if($current_page+7>$num_pages)
				$f_n=$num_pages;
			else
				$f_n=$current_page+7;
		}else{
			$f_c=1;
			$f_n=$num_pages;
		}
	for($p=$f_c;$p<=$f_n;$p++){

			if($p==$current_page){
	?>
		<li class="active">
			<a href="<?=site_url($url.$parameter.'/'.$p)?>"><?=$p?></a>
		</li>
		<?
		}else{
	?>
<li >
			<a href="<?=site_url($url.$parameter.'/'.$p)?>"><?=$p?></a>
		</li>
<?
		}
	}
	if($num_pages>15 &&  $current_page<$num_pages-1){
		$num_pages1=$num_pages-1;
	?>	
<li ><a   href="javascript:;">...</a></li><li ><a   href="<?=site_url($url.'/'.$num_pages1)?>"><?=$num_pages1?></a></li><li ><a  href="<?=site_url($url.$parameter.'/'.$num_pages)?>"><?=$num_pages?></a></li>
	<?
	}
	?>


		<?
if($current_page==$num_pages){
	?>
<?
}else{
?>
		<li>
			<a href="<?=site_url($url.'/'.$num_pages)?>">»</a>
		</li>
		<?
}	
}
?>
	</ul>
</div>