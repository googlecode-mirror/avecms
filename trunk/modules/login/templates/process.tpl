<!-- process.tpl -->
{strip}

<h2 id="page-heading">{#LOGIN_PLEASE_LOGON#}</h2>

{if $login == 'true'}
	{#LOGIN_TEXT_TRUE_INFO#} {redirectLink}
{else}
	{#LOGIN_TEXT_FALSE_INFO#}

	<p>&nbsp;</p>

	<form method="post" action="index.php">
		<label for="f_email"><strong>{#LOGIN_YOUR_MAIL#}</strong></label><br />
		<input type="text" name="user_login" id="f_email" class="loginfield" style="width:200px" /><br />

		<label for="f_kennwort"><strong>{#LOGIN_PASSWORD#}</strong></label><br />
		<input type="password" name="user_pass" id="f_kennwort" class="loginfield" style="width:200px" /><br />

		<input type="checkbox" name="SaveLogin" id="SaveLogin" value="1" />&nbsp;
		<a title="{#LOGIN_SAVE_INFO#}" href="javascript:void(0);">{#LOGIN_SAVE_COOKIE#}</a><br />
		<br />

		<input type="submit" class="button" value="{#LOGIN_BUTTON_ENTER#}" />

		<input type="hidden" name="module" value="login" />
		<input type="hidden" name="action" value="login" />
	</form>

	<a title="{#LOGIN_REMINDER_INFO#}" href="index.php?module=login&amp;action=passwordreminder">{#LOGIN_PASSWORD_REMIND#}</a>
	{if $active == 1}
		&nbsp;|&nbsp;
		<a title="{#LOGIN_REGISTER_INFO#}" href="index.php?module=login&amp;action=register">{#LOGIN_NEW_REGISTER#}</a>
	{/if}
{/if}

{/strip}
<!-- /process.tpl -->
