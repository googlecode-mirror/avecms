{*
<form method="post" action="index.php" class="login">
	<p>{#LOGIN_PLEASE_LOGON#}</p>

	<input type="hidden" name="module" value="login" />
	<input type="hidden" name="action" value="login" />
	<input type="text" name="user_login" value="" tabindex="1" class="inputbox" />
	<input type="password" name="user_pass" value="" tabindex="2" class="pass" />
	<input type="submit" class="button" value="Войти" />

	<p>
		<input type="checkbox" name="SaveLogin" id="SaveLogin" value="1" style="margin:0" />&nbsp;
		{#LOGIN_SAVE_COOKIE#}&nbsp;
		<a class="tooltip" title="{#LOGIN_SAVE_INFO#}" href="#">{#LOGIN_SAVE_ICON#}</a><br />

		<a class="tooltip" title="{#LOGIN_REMINDER_INFO#}" href="{$ABS_PATH}index.php?module=login&amp;action=passwordreminder">{#LOGIN_PASSWORD_REMIND#}</a>&nbsp;|&nbsp;
		{if $active == 1}
			<a class="tooltip" title="{#LOGIN_REGISTER_INFO#}" href="{$ABS_PATH}index.php?module=login&amp;action=register">{#LOGIN_NEW_REGISTER#}</a>
		{/if}
	</p>
</form>
*}
<div class="block" id="login-forms">
	<form method="post" action="{$ABS_PATH}index.php">
		<input type="hidden" name="module" value="login" />
		<input type="hidden" name="action" value="login" />
		<fieldset class="login">
			<legend>{#LOGIN_AUTORIZATION#}</legend>
			<p class="notice">{#LOGIN_PLEASE_LOGON#}</p>
			<p>
				<label>{#LOGIN_YOUR_EMAIL#}</label>
				<input type="text" name="user_login" value="{$smarty.request.user_login|escape|stripslashes}" />
			</p>
			<p>
				<label>{#LOGIN_YOUR_PASSWORD#}</label>
				<input type="password" name="user_pass" />
			</p>
			<input class="login button" type="submit" value="{#LOGIN_BUTTON_LOGIN#}" />
		</fieldset>
	</form>
	<p>
		<input type="checkbox" name="SaveLogin" id="SaveLogin" value="1" style="margin:0" />&nbsp;
		{#LOGIN_SAVE_COOKIE#}&nbsp;
		<a class="tooltip" title="{#LOGIN_SAVE_INFO#}" href="#">{#LOGIN_SAVE_ICON#}</a><br />

		<a class="tooltip" title="{#LOGIN_REMINDER_INFO#}" href="{$ABS_PATH}index.php?module=login&amp;action=passwordreminder">{#LOGIN_PASSWORD_REMIND#}</a>&nbsp;|&nbsp;
		{if $active == 1}
			<a class="tooltip" title="{#LOGIN_REGISTER_INFO#}" href="{$ABS_PATH}index.php?module=login&amp;action=register">{#LOGIN_NEW_REGISTER#}</a>
		{/if}
	</p>
</div>