<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content=""/>
<meta name="keywords" content="" />
<title><?php echo isset($title)?$title:'';?></title>
<script src="/js/jquery-1.9.1.js"></script>
<script src="/js/common.js"></script>
<?
if(isset($js['jquery-ui'])) {
?>
<script src="/js/jquery-ui.js"></script>
<?
}
if(isset($js['validate'])) {
?>
<script src="/js/validate/jquery.validate.js"></script>
<script src="/js/validate/additional-methods.js"></script>
<script src="/js/validate/messages_zh.js"></script>
<?
}
if(isset($js['editor'])) {
?>
<script src="/js/ckeditor/ckeditor.js"></script>
<?
}
if(isset($js['date'])) {
?>
<script type="text/javascript" src="/js/my97datepicker/WdatePicker.js"></script>
<!-- <input class="Wdate" type="text" onClick="WdatePicker()"> -->
<?
}
if(isset($js['pagination'])) {
?>
<script language="javascript" type="text/javascript" src="/js/pagination.js"></script>
<?
}
if(isset($js['jqgrid'])) {
?>
<script language="javascript" type="text/javascript" src="/js/jqgrid/js/grid.locale-cn.js"></script>
<link href="/js/jqgrid/css/ui.jqgrid.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="/js/jqgrid/js/jquery.jqGrid.min.js"></script>
<?
}
if(isset($js['jqueryui'])) {
?>
<link type="text/css" href="/css/jquery.ui.1.9.2.ie.css" rel="stylesheet" />
<link type="text/css" href="/css/jquery.ui.1.10.0.ie.css" rel="stylesheet" />
<link type="text/css" href="/css/jquery-ui-1.9.2.custom.css" rel="stylesheet" />
<link type="text/css" href="/css/jquery-ui-1.10.0.custom.css" rel="stylesheet" />
<script type="text/javascript" src="/js/jqueryui/js/jquery-ui-1.8.17.custom.min.js"></script>
<?
}
if(isset($js['formvalidator'])) {
?>
<script type="text/javascript" src="/js/formvalidator/formValidator-4.1.1.js"></script>
<script type="text/javascript" src="/js/formvalidator/formValidatorRegex.js"></script>
<?
}
if(isset($js['imgareaselect'])){
?>
<link rel="stylesheet" type="text/css" href="/js/imgareaselect/css/imgareaselect-default.css" />
<script type="text/javascript" src="/js/imgareaselect/scripts/jquery.imgareaselect.pack.js"></script>
<!-- 
$(document).ready(function () {
    $('img#photo').imgAreaSelect({
        handles: true,
        onSelectEnd: someFunction
    });
});
http://odyniec.net/projects/imgareaselect/examples.html
-->
<?
}
if(isset($js['uploadify'])){
?>
<script type="text/javascript" src="/js/uploadify/swfobject.js"></script>
<script type="text/javascript" src="/js/uploadify/jquery.uploadify.v2.1.4.min.js"></script>
<!-- 
$(document).ready(function() {
  $('#file_upload').uploadify({
    'uploader'  : '/uploadify/uploadify.swf',
    'script'    : '/uploadify/uploadify.php',
    'cancelImg' : '/uploadify/cancel.png',
    'folder'    : '/uploads',
    'auto'      : true
  });
});

<input id="file_upload" type="file" name="file_upload" />
-->
<?
}
if(isset($js['dropzone'])){
?>
<script type="text/javascript" src="/js/dropzone/lib/dropzone.js"></script>
<?
}
if(isset($js['fineuploader'])){
//http://fineuploader.com/demos.html
?>
<link rel="stylesheet" type="text/css" href="/js/fineuploader/fineuploader-4.4.0.min.css" />
<script type="text/javascript" src="/js/fineuploader/fineuploader-4.4.0.min.js"></script>
<?
}
if(isset($js['purview'])){
?>
<script type="text/javascript" src="/js/purview.js"></script>
<?
}
if(isset($js['easyTable'])){
?>
<script type="text/javascript" src="/js/easytable.js"></script>
<?
}
if(isset($js['bigcolorpicker'])){
?>
<link rel="stylesheet" type="text/css" href="/css/jquery.bigcolorpicker.css" /> 
<script type="text/javascript" src="/js/jquery.bigcolorpicker.min.js"></script> 
<?
}
if(isset($js['fineuploader'])){
?>
<link rel="stylesheet" type="text/css" href="/js/fineuploader/fineuploader-4.4.0.min.css" />
<script type="text/javascript" src="/js/fineuploader/fineuploader-4.4.0.min.js"></script>
<?
}
?>
<link rel="stylesheet" href="/vendor/table-sortable/theme.css">
<link rel="stylesheet" href="/vendor/offline/theme.css">
<link rel="stylesheet" href="/vendor/pace/theme.css">


<link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="/css/font-awesome.min.css">
<link rel="stylesheet" href="/css/animate.min.css">

<link rel="stylesheet" href="/css/panel.css">

<link rel="stylesheet" href="/css/skins/palette.1.css" id="skin">
<link rel="stylesheet" href="/css/fonts/style.1.css" id="font">
<link rel="stylesheet" href="/css/main.css">


<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

<script src="/vendor/modernizr.js"></script>
</script>
<?
if (!$this->login_lib->is_login())
	redirect("/supplier");
?>
</head>
<body>