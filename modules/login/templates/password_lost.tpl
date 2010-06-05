<script type="text/javascript" language="JavaScript">
function check_email() {ldelim}
	if (document.getElementById('l_mailreminder').value == '') {ldelim}
		alert("{#LOGIN_ENTER_EMAIL#}");
		document.getElementById('l_mailreminder').focus();
		return false;
	{rdelim}
	return true;
{rdelim}
</script>
{*
<h2 id="page-heading">{#LOGIN_REMIND#}</h2>

<div id="module_content">

	{if $smarty.request.sub=='send'}
		<p><em>{#LOGIN_REMINDER_INFO3#}</em></p>
	{else}
		<p><em>{#LOGIN_REMINDER_INFO2#}</em></p>

		<form method="post" action="index.php" onsubmit="return check_email();">
			<input style="width:200px" value="Ваш E-mail" name="f_mailreminder" type="text" id="l_mailreminder" onfocus="if (this.value == 'Ваш E-mail') {ldelim}this.value = '';{rdelim}" onblur="if (this.value=='') {ldelim}this.value = 'Ваш E-mail';{rdelim}" />&nbsp;&nbsp;

			<input type="submit" class="button" value="{#LOGIN_BUTTON_NEWPASS#}" />

			<input type="hidden" name="module" value="login" />
			<input type="hidden" name="action" value="passwordreminder" />
			<input type="hidden" name="sub" value="send" />
		</form>
	{/if}
</div>
*}
<div class="box">
	<h2>
		<a href="#" id="toggle-forms">{#LOGIN_REMIND#}</a>

	</h2>
	<div class="block" id="forms">
		{if $smarty.request.sub=='send'}
			<fieldset>
				<p>{#LOGIN_REMINDER_INFO3#}</p>
			</fieldset>
		{else}
			<form method="post" action="{$ABS_PATH}index.php?module=login&action=passwordreminder&sub=send" onsubmit="return check_email();">
				<fieldset class="login">
					<legend>{#LOGIN_REMINDER_INFO4#}</legend>
					<p>{#LOGIN_REMINDER_INFO2#}</p>
					<p>
						<label>{#LOGIN_YOUR_MAIL#}</label>
						<input name="f_mailreminder" id="l_mailreminder" value="" type="text">
					</p>
					<input class="confirm button" value="{#LOGIN_BUTTON_NEWPASS#}" type="submit">
				</fieldset>
			</form>
		{/if}
	</div>
</div>