<?php if($city){?>
<option value="0">请选择</option>
<?
foreach($city as $key=>$val){
?>
<option value="<?=$key?>"><?=$val?></option>
<?
}
}
?>