<!-- password_lost.tpl -->
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
{strip}

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

{/strip}
<!-- /password_lost.tpl -->
