<?=isset($admin_header) ? $admin_header : ''?>
<div class="col_right" id="content">
<!-- content starts -->
<div class="div_home">
  <div class="ul_left"></div>
  <div class="ul_center">
    <ul class="breadcrumb">
      <li> 成功提示 </li>
    </ul>
  </div>
  <div class="ul_right"></div>
</div>
<div class="clearfloat"></div>
<div class="bd">
 <div class="box col-md-12">
        <div class="box-inner">
           <div class="ent_table">
				<div class="tip">
					<span class="red"><?=$msg?></span>
	  <span id="secondUi">0</span>秒钟后将自动跳转首页<br/><a href="<?=$url?>">正在自动跳转，如果你的浏览器没有自动跳转，请点击这里</a></span>
				</div>
	 </div>
        </div>
    </div> 
</div>
</div>
<script type="text/javascript">
    var s = 1;
    function secondUpdate() {
        --s;
        document.getElementById("secondUi").innerHTML = s;
        if(parseInt(s)<=parseInt(0)){
            window.location.href ='<?=site_url($url)?>';
			return false;
        }
        setTimeout('secondUpdate()',1000);
    }
    setTimeout('secondUpdate()',1000);
</script>
<?=isset($admin_footer) ? $admin_footer : ''?>