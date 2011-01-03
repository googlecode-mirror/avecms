
<div class="block" id="login-forms">
	<form method="post" action="{$ABS_PATH}index.php?module=login&action=login">
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
</div>
