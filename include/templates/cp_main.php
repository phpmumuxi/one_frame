<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">    
<title>网站管理中心</title>
<link type="text/css" href="<?php echo KO_DOMAIN_URL; ?>/static/ht/css/skin_0.css" rel="stylesheet" id="cssfile2"/>
<script type="text/javascript" src="<?php echo KO_DOMAIN_URL; ?>/static/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo KO_DOMAIN_URL; ?>/static/js/jquery.validation.min.js"></script>
<script type="text/javascript" src="<?php echo KO_DOMAIN_URL; ?>/static/js/admincp.js"></script>
<script type="text/javascript" src="<?php echo KO_DOMAIN_URL; ?>/static/js/jquery.cookie.js"></script>
<script type="text/javascript">
var cookie_skin = $.cookie('KO_Css_Skin'); //换肤
if (cookie_skin) {
    $('#cssfile2').attr('href', '<?php echo KO_DOMAIN_URL; ?>/static/ht/css/' + cookie_skin + '.css');
}
</script>
</head>
<body>
<?php require_once($ko_template_file); ?>
</body>
</html>