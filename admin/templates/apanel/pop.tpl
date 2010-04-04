{strip}

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>({$smarty.session.user_name})</title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="pragma" content="no-cache">
<meta name="generator" content="">
<meta name="Expires" content="Mon, 06 Jan 1990 00:00:01 GMT">
<link href="{$tpl_dir}/css/style.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_dir}/js/jquery/css/mbTooltip.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="{$tpl_dir}/js/jquery/jquery.js"></script>
<script type="text/javascript" src="{$tpl_dir}/js/jquery/plugin/jquery.timers.js"></script>
<script type="text/javascript" src="{$tpl_dir}/js/jquery/plugin/jquery.dropshadow.js"></script>
<script type="text/javascript" src="{$tpl_dir}/js/jquery/plugin/mbTooltip.js"></script>
<script type="text/javascript" src="{$tpl_dir}/js/cpcode.js"></script>
</head>

<body>
	<table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td height="100%" width="100%" valign="top">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td height="100%" valign="top" id="content">{/strip}{$content}{strip}</td>
					</tr>
				</table>
			</td>
		</tr>

		<tr>
			<td width="100%" valign="bottom">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td id="tablebottom">{$smarty.const.APP_INFO}</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>

{/strip}