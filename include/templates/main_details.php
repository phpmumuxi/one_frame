<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0024)http://www.mogoedit.com/ -->
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>
        </title>
        <meta name="keywords" content="">
        <meta name="description" content="">
		<link rel="stylesheet" type="text/css" href="<?php echo KO_DOMAIN_URL; ?>/static/css/bootstrap.min.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo KO_DOMAIN_URL; ?>/static/css/style.css" />
        <link type="text/css" rel="stylesheet" href="<?php echo KO_DOMAIN_URL; ?>/static/css/main.css">
        <!-- <script type="text/javascript" src="<?php echo KO_DOMAIN_URL; ?>/static/js/d/jquery.js"></script>
        <script type="text/javascript" src="<?php echo KO_DOMAIN_URL; ?>/static/swt.js"></script> -->
    </head>
    <body>
       <div id="header">
            <div id="logo">
                <a href="/">
                    <img src="/static/images/logo.png" alt="方维期刊网编辑">
                </a>
            </div>
            <div id="h_right">
                <!-- 联系电话: 4006-587-789 -->
                <img src="/static/images/4006-587-789.png">
            </div>
        </div>
        <div style="width:100%; height:1px; background:#FFFFFF;">
        </div>
        <!-- menu -->
        <?php include(KO_TEMPLATES_PATH . '/nav.php'); ?>
        <?php require_once($ko_template_file); ?>
        <?php include(KO_TEMPLATES_PATH . '/footer.php'); ?>
        <script type="text/javascript" src="/static/js/d/common.js">
        </script>
        <script>
            $(function() {
                $('#o_sub_fast').click(function() {
                    location.href = "/";
                });
            });
        </script>
    </body>
</html>