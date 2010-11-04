
<script type="text/javascript">
function check_email() {ldelim}
	if (document.getElementById('l_mailreminder').value == '') {ldelim}
		alert("{#LOGIN_ENTER_EMAIL#}");
		document.getElementById('l_mailreminder').focus();
		return false;
	{rdelim}
	return true;
{rdelim}
</script>

<h2 id="page-heading">{#LOGIN_REMIND#}</h2>

<div class="block" id="forms">
	{if $smarty.request.sub=='send'}
		<fieldset>
			<p>{#LOGIN_REMINDER_INFO3#}</p>
		</fieldset>
	{else}
		<form method="post" action="{$ABS_PATH}index.php?module=login&action=passwordreminder" onsubmit="return check_email();">
			<input type="hidden" name="sub" value="send" />
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
