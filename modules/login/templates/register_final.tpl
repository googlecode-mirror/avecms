<div class="box">
	<h2>
		<a href="#" id="toggle-forms">{#LOGIN_TEXT_REGISTER#}</a>
	</h2>
	<div class="block" id="forms">
		<fieldset class="login">
			{if $final == "ok"}
				<p>{#LOGIN_MESSAGE_OK#}</p>
			{else}
				<p>{#LOGIN_MESSAGE_TEXT#}</p>
				<form method="post" action="index.php?module=login&action=register&sub=registerfinal">
					<p>
						<label>{#LOGIN_CODE_FROM_MAIL#}</label>
						<input type="text" name="emc" />
					</p>
					<input class="confirm button" value="{#LOGIN_BUTTON_FINAL#}" type="submit">
				</form>
			{/if}
		</fieldset>
	</div>
</div>
{*
<h2 id="page-heading">{#LOGIN_TEXT_REGISTER#}</h2>

<div id="module_content">
	{if $final == "ok"}
		<p><em>{#LOGIN_MESSAGE_OK#}</em></p>
	{else}
		<p><em>{#LOGIN_MESSAGE_TEXT#}</em></p>
		<form method="post" action="index.php?module=login&action=register&sub=registerfinal">
			<div class="formleft"><label for="l_emc">{#LOGIN_CODE_FROM_MAIL#}</label></div>
			<div class="formright"><input name="emc" type="text" id="l_emc" style="width:200px" value="{$smarty.request.emc|strip_tags|stripslashes}" /></div>
			<div class="clear"></div><br />

			<input type="submit" class="button" value="{#LOGIN_BUTTON_FINAL#}" />
		</form>
	{/if}
</div>
*}