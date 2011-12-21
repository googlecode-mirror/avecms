<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>{$version_setup}</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<link href="data/tpl/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="data/tpl/ns_tooltip.js"></script>
</head>

<body id="body">

<div class="wrapper">
	<div class="step step_3"></div>
	<h1 align="right">{$la.install_type}</h1>
	<p>&nbsp;</p>
	<form action="install.php" method="post" enctype="multipart/form-data" name="s" id="s">
		<div id="inquiry_form">
			<div class="cf">
				<label>{$la.install_setting_desc}</label>
				<select name="demo">
					<option value="1" selected>{$la.install_demo}</option>
					<option value="0">{$la.install_clear}</option>
				</select>
				<img class="tip_help" onmouseover="AddTT('{$la.olh_setting_desc}');" onmouseout="RemoveTT();" src="data/tpl/img/help.gif" alt="" width="24" height="24" />
			</div>
		</div>
		<div class="help">{$la.database_setting_foot}</div>
		<input name="force" type="hidden" id="force" value="{$smarty.request.force|escape|stripslashes}" />
		<input name="step" type="hidden" id="step" value="3" />
		<div align="center" class="go_buttons">
			<input accesskey="e" name="Submit" type="submit" class="button" value="{$la.database_setting_save}" />&nbsp;
			<input onclick="if(confirm('{$la.confirm_exit}')) location.href='data/exit.html'" type="button" class="button" value="{$la.exit}" />
		</div>
	</form>
</div>

</body>
</html>