<div class="box">
	<h2>
		<a href="#" id="toggle-forms">{#LOGIN_DELETE_ACCOUNT#}</a>
	</h2>
	<div class="block" id="forms">
		{if $admin == 1}
			<fieldset class="login">
				<legend>{#LOGIN_DELETE_WARNING#}</legend>
				<p>{#LOGIN_ADMIN_ACCOUNT#}</p>
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
					<form method="post" action="index.php?module=login&action=delaccount&send=1">
						<input name="delconfirm" type="checkbox" value="1" />
						{#LOGIN_DELETE_CONFIRM#}<br />
						<br />
						<input class="confirm button" value="{#LOGIN_DELETE_BUTTON#}" type="submit">
					</form>
				</fieldset>
			{/if}
		{/if}
	</div>
</div>
{*
<h2 id="page-heading">{#LOGIN_DELETE_ACCOUNT#}</h2>

<div id="module_content">
	{if $admin!=1}
		<p><em>{#LOGIN_ADMIN_ACCOUNT#}</em></p>
	{else}
		{if $delok == 1}
			<p><em>{#LOGIN_DELETE_OK#}</em></p>
		{else}
			<p><em>{#LOGIN_DELETE_INFO#}</em></p>
			<form method="post" action="index.php?module=login&action=delaccount&send=1">
				<input name="delconfirm" type="checkbox" value="1" />
				{#LOGIN_DELETE_CONFIRM#}<br />
				<br />
				<input class="button" type="submit" value="{#LOGIN_DELETE_BUTTON#}" />
			</form>
		{/if}
	{/if}
</div>
*}