<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>{$version_setup}</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<link href="data/tpl/style.css" rel="stylesheet" type="text/css" />
</head>

<body id="body">

<div class="wrapper">
	<div class="step step_error"></div>
	<h1 align="right">{$error_header}</h1>
	<p>&nbsp;</p>
	{foreach from=$error_is_required item="inc"}
		<div class="error">{$inc}</div>
	{/foreach}
	{if $config_isnt_writeable == 1}
		<div class="error">{$la.config_isnt_writeable}</div>
	{/if}
	<div class="help">{$la.secondchance}</div>
	<form action="install.php" method="post" enctype="multipart/form-data" name="s" id="s" onSubmit="return defaultagree(this)">
		<p>
			<input onclick="alert('{$la.warning_force}');" name="force" type="checkbox" id="force" value="1"{if $config_isnt_writeable == 1} disabled{/if} />
			<span class="small">{$la.force} {if $config_isnt_writeable == 1}{$la.force_impossibly}{/if}</span>
		</p>
		{if $config_isnt_writeable != 1}
			<input name="force" type="hidden" id="force" value="{$smarty.request.force|escape|stripslashes}" />
		{/if}
		<input name="step" type="hidden" id="step" value="{$smarty.request.step|default:'1'}" />
		<div align="center" class="go_buttons">
			<input accesskey="e" name="Submit" type="submit" class="button" value="{$la.error_reload}" />
			<input onclick="if(confirm('{$la.confirm_exit}')) location.href='data/exit.html'" type="button" class="button" value="{$la.exit}" />
		</div>
	</form>
</div>

</body>
</html>