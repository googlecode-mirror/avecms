<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>{$smarty.session.user_name|escape}</title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="pragma" content="no-cache">
<meta name="generator" content="">
<meta name="Expires" content="Mon, 06 Jan 1990 00:00:01 GMT">
<link href="templates/{$smarty.session.admin_theme|escape}/css/style.css" rel="stylesheet" type="text/css" />
<link href="templates/{$smarty.session.admin_theme|escape}/js/jquery/css/mbTooltip.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="templates/{$smarty.session.admin_theme|escape}/js/jquery/jquery.js"></script>
<script type="text/javascript" src="templates/{$smarty.session.admin_theme|escape}/js/jquery/plugin/jquery.timers.js"></script>
<script type="text/javascript" src="templates/{$smarty.session.admin_theme|escape}/js/jquery/plugin/jquery.dropshadow.js"></script>
<script type="text/javascript" src="templates/{$smarty.session.admin_theme|escape}/js/jquery/plugin/mbTooltip.js"></script>
<script type="text/javascript" src="templates/{$smarty.session.admin_theme|escape}/js/cpcode.js"></script>
</head>

<body>
<table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td valign="top" id="content">{$content}</td>
	</tr>

	<tr>
		<td id="tablebottom">{$smarty.const.APP_INFO}</td>
	</tr>
</table>
</body>
</html>