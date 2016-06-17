<!doctype html>
<html class="signin no-js" lang="">
<head>
<meta charset="utf-8">
<meta name="description" content="Flat, Clean, Responsive, admin template built with bootstrap 3">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
<title></title>
<link rel="stylesheet" href="vendor/offline/theme.css">
<link rel="stylesheet" href="vendor/pace/theme.css">
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/animate.min.css">
<link rel="stylesheet" href="css/skins/palette.1.css" id="skin">
<link rel="stylesheet" href="css/fonts/style.1.css" id="font">
<link rel="stylesheet" href="css/main.css">
<script src="vendor/modernizr.js"></script>
</head>
<body class="bg-color center-wrapper">
<div class="center-content">
    <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
        <section class="panel panel-default">
            <header class="panel-heading"><?php echo $error; ?></header>
            <div class="bg-white user pd-md">
                <form role="form" id="theForm" name="theForm"  action="<?=site_url('/supplier/lo_gina_submit')?>" method="post">
                    <input type="text" id="Username" name="Username" class="form-control mg-b-sm" placeholder="用户名" autofocus>
                    <input type="password" id="Password" name="Password" class="form-control" placeholder="密码">
                    <label class="checkbox pull-left">
                    <input type="checkbox" value="remember-me">记住我
                    </label>
                    <div class="text-right mg-b-sm mg-t-sm">
                        <a href="javascript:;">忘记密码?</a>
                    </div>
                    <button class="btn btn-info btn-block" type="submit">登录</button>
                </form>
            </div>
        </section>
    </div>
</div>
</body>
</html>