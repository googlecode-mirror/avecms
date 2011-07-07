
<h2 id="page-heading">{#LOGIN_DELETE_ACCOUNT#}</h2>

<div class="block" id="forms">
	{if $admin == 1}
		<fieldset class="login">
			<legend>{#LOGIN_DELETE_WARNING#}</legend>
			<p class="regerror">{#LOGIN_ADMIN_ACCOUNT#}</p>
		</fieldset>
	{else}
		{if $delok == 1}
			<fieldset class="login">
				<p>{#LOGIN_DELETE_OK#}</p>
			</fieldset>
		{else}
			<fieldset class="login">
				<legend>{#LOGIN_DELETE_WARNING#}</legend>
				<p>{#LOGIN_DELETE_INFO#}</p>
				<form method="post" action="index.php?module=login&action=delaccount">
					<input type="hidden" name="send" value="1" />
					<input name="delconfirm" type="checkbox" value="1" />
					{#LOGIN_DELETE_CONFIRM#}<br />
					<br />
					<input class="confirm button" value="{#LOGIN_DELETE_BUTTON#}" type="submit">
				</form>
			</fieldset>
		{/if}
	{/if}
</div>
