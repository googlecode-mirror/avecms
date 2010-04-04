<!-- delete_account.tpl -->
{strip}

<h2 id="page-heading">{#LOGIN_DELETE_ACCOUNT#}</h2>

<div id="module_content">
	{if $admin==1}
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

{/strip}
<!-- /delete_account.tpl -->
