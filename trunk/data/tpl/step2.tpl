<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>{$version_setup}</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<link href="data/tpl/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="data/tpl/ns_tooltip.js"></script>
</head>

<body id="body">

<div class="wrapper">
	<div class="step step_2"></div>
	<h1 align="right">{$la.database_setting}</h1>
	<p>&nbsp;</p>
	{if $warnnodb}
	<div class="error">{$warnnodb}</div>
	{else}
	<div class="help">{$la.database_setting_desc}</div>
	{/if}
	<form action="install.php" method="post" enctype="multipart/form-data" name="s" id="s">
		<div id="inquiry_form">
			<div class="cf">
				<label for="dbhost">{$la.dbserver}</label>
				<input name="dbhost" type="text" id="dbhost" value="{$smarty.request.dbhost|escape|stripslashes|default:'localhost'}" />
				<img class="tip_help" onmouseover="AddTT('{$la.olh_host}');" onmouseout="RemoveTT();" src="data/tpl/img/help.gif" alt="" width="24" height="24" />
			</div>
			<div class="cf">
				<label for="dbuser">{$la.dbuser}</label>
				<input name="dbuser" type="text" id="dbuser" value="{$smarty.request.dbuser|escape|stripslashes|default:root}" />
				<img class="tip_help" onmouseover="AddTT('{$la.olh_user}');" onmouseout="RemoveTT();" src="data/tpl/img/help.gif" alt="" width="24" height="24" />
			</div>
			<div class="cf">
				<label for="dbname">{$la.dbname}</label>
				<input class="text" name="dbname" type="text" id="dbname" value="{$smarty.request.dbname|escape|stripslashes}" />
				<img class="tip_help" onmouseover="AddTT('{$la.olh_name}');" onmouseout="RemoveTT();" src="data/tpl/img/help.gif" alt="" width="24" height="24" />
			</div>
			<div class="cf">
				<label for="dbpass">{$la.dbpass}</label>
				<input name="dbpass" type="text" id="dbpass" value="" />
				<img class="tip_help" onmouseover="AddTT('{$la.olh_pass}');" onmouseout="RemoveTT();" src="data/tpl/img/help.gif" alt="" width="24" height="24" />
			</div>
			<div class="cf">
				<label for="dbprefix">{$la.dbprefix}</label>
				<input name="dbprefix" type="text" id="dbprefix" value="{$smarty.request.dbprefix|escape|stripslashes|default:$dbpref}" />
				<img class="tip_help" onmouseover="AddTT('{$la.olh_prf}');" onmouseout="RemoveTT();" src="data/tpl/img/help.gif" alt="" width="24" height="24" />
			</div>
		</div>
		<div class="help">{$la.database_setting_foot}</div>
		<input name="force" type="hidden" id="force" value="{$smarty.request.force|escape|stripslashes}" />
		<input name="step" type="hidden" id="step" value="2" />
		<div align="center" class="go_buttons">
			<input accesskey="e" name="Submit" type="submit" class="button" value="{$la.database_setting_save}" />
			<input onclick="if(confirm('{$la.confirm_exit}')) location.href='data/exit.html'" type="button" class="button" value="{$la.exit}" />
		</div>
	</form>
</div>

</body>
</html>