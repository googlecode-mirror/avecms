
<h2 id="page-heading">{#LOGIN_TEXT_REGISTER#}</h2>

<div class="block" id="forms">
	<fieldset class="login">
		{if $final == "ok"}
			<p>{#LOGIN_MESSAGE_OK#}</p>
			{if $smarty.session.referer != ''}
				<meta http-equiv="refresh" content="5;URL={$smarty.session.referer}" />
			{/if}
		{else}
			<p>{#LOGIN_MESSAGE_TEXT#}</p>
			<form method="post" action="index.php?module=login&action=register">
				<input type="hidden" name="sub" value="registerfinal" />
				<p>
					<label>{#LOGIN_CODE_FROM_MAIL#}</label>
					<input type="text" name="emc" />
				</p>
				<input class="confirm button" value="{#LOGIN_BUTTON_FINAL#}" type="submit">
			</form>
		{/if}
	</fieldset>
</div>
