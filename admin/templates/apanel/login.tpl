<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>{#MAIN_LOGIN_TEXT#}</title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="pragma" content="no-cache">
<meta name="generator" content="">
<meta name="Expires" content="Mon, 06 Jan 1990 00:00:01 GMT">
<link href="{$tpl_dir}/css/style.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td width="100%" height="100%" align="center">
			<form method="post" action="admin.php">
				<input type="hidden" name="action" value="login">
				<input type="hidden" name="lang" value="ru" id="f_lang">
				<input type="hidden" name="theme" value="apanel" id="f_theme">
				<table cellspacing="0" cellpadding="0" border="0">
					<tr>
						<td valign="top"><img src="{$tpl_dir}/images/login_left.jpg" alt="" border="0" /></td>
						<td width="250" align="left">
							<img src="{$tpl_dir}/images/login_right.jpg" alt="" border="0" />
							<div class="login_box_hf"><strong>{#MAIN_YOUR_LOGIN#}</strong></div>
							<input style="width:250px" name="user_login" type="text" value="{$smarty.request.user_login|escape}" class="field" /><br />
							<br />
							<div class="login_box_hf"><strong>{#MAIN_YOUR_PASSWORD#}</strong></div>
							<input style="width:250px" name="user_pass" type="password" class="field" /><br />
							<br />
						</td>
					</tr>
					<tr>
						<td align="right" colspan="2">
							<input type="image" value="{#MAIN_BUTTON_LOGIN#}" src="{$tpl_dir}/images/button.jpg" title="{#MAIN_BUTTON_LOGIN#}" />
						</td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
</table>
</body>
</html>