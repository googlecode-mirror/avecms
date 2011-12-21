<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>{$version_setup}</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<link href="data/tpl/style.css" rel="stylesheet" type="text/css" />
</head>

<body id="body">

<div class="wrapper">
	<div class="step step_4"></div>
	<h1 align="right">{$la.stepstatus}</h1>
	<p>&nbsp;</p>
	<div class="help">{$la.header_logindata}</div>
	{if $errors}
		{foreach from=$errors item="error"}
		<div class="error">{$error}</div>
		{/foreach}
	{/if}
	<form action="install.php" method="post" enctype="multipart/form-data" name="s" id="s">
		<div id="inquiry_form">
			<div class="cf">
				<label for="username"><span class="star">*</span>{$la.username}</label>
				<input class="text" name="username" type="text" id="username" value="{$smarty.request.username|escape|stripslashes}" />
			</div>
			<div class="cf">
				<label for="email"><span class="star">*</span>{$la.email}</label>
				<input class="text" name="email" type="text" id="email" value="{$smarty.request.email|escape|stripslashes}" />
			</div>
			<div class="cf">
				<label for="pass"><span class="star">*</span>{$la.password}</label>
				<input class="text" name="pass" type="text" id="pass" value="{$smarty.request.pass|escape|stripslashes}" />
			</div>
		</div>
		<div class="help">{$la.loginstar}</div>
		<input name="force" type="hidden" id="force" value="{$smarty.request.force|escape|stripslashes}" />
		<input name="demo" type="hidden" id="demo" value="{$smarty.request.demo|escape|stripslashes}" />
		<input name="step" type="hidden" id="step" value="4" />
		<div align="center" class="go_buttons">
			<input name="Senden"type="submit" class="button" onclick="document.s.sumit.disabled();" value="{$la.button_setup_final}" />
		</div>
</div>

</body>
</html>