<!-- password_change.tpl -->
<script type="text/javascript" language="JavaScript">
function check_password() {ldelim}
	if (document.getElementById('o_pass').value == '') {ldelim}
		alert("{#LOGIN_OLD_PASS_EMPTY#}");
		document.getElementById('o_pass').focus();
		return false;
	{rdelim}

	if (document.getElementById('n_pass').value == '') {ldelim}
		alert("{#LOGIN_NEW_PASS_EMPTY#}");
		document.getElementById('n_pass').focus();
		return false;
	{rdelim}

	if (document.getElementById('n_pass_c').value == '') {ldelim}
		alert("{#LOGIN_NEW_PASSC#}");
		document.getElementById('n_pass_c').focus();
		return false;
	{rdelim}

	if (document.getElementById('n_pass').value != document.getElementById('n_pass_c').value) {ldelim}
		alert("{#LOGIN_PASSWORDS_NOEQU#}");
		document.getElementById('n_pass').focus();
		return false;
	{rdelim}

	return true;
{rdelim}
</script>
{strip}

<h2 id="page-heading">{#LOGIN_PASSWORD_CHANGE#}</h2>

<div id="module_content">
	{if $changeok==1}
		<p><em>{#LOGIN_PASSWORD_OK#}</em></p>
	{else}
		<p><em>{#LOGIN_PASSWORD_INFO#}</em></p>

		{if $errors}
			<h2>{#LOGIN_FOUND_ERROR#}</h2>
			<ul>
				{foreach from=$errors item=e}
					<li class="regerror">{$e}</li>
				{/foreach}
			</ul>
		{/if}

		<form action="index.php" method="post" onsubmit="return check_password();">
			<div class="formleft"><label for="o_pass">{#LOGIN_OLD_PASSWORD#}</label></div>
			<div class="formright"><input name="old_pass" type="password" id="o_pass" style="width:200px" value="" /></div>
			<div class="clear"></div><br />

			<div class="formleft"><label for="n_pass">{#LOGIN_NEW_PASSWORD#}</label></div>
			<div class="formright"><input name="new_pass" type="password" id="n_pass" style="width:200px" value="" /></div>
			<div class="clear"></div><br />

			<div class="formleft"><label for="n_pass_c">{#LOGIN_NEW_PASSWORD_C#}</label></div>
			<div class="formright"><input name="new_pass_c" type="password" id="n_pass_c" style="width:200px" value="" /></div>
			<div class="clear"></div><br />

			<input type="submit" class="button" value="{#LOGIN_CHANGE_PASSWORD#}" />

			<input type="hidden" name="module" value="login" />
			<input type="hidden" name="action" value="passwordchange" />
			<input type="hidden" name="sub" value="send" />
		</form>
	{/if}
</div>

{/strip}
<!-- /password_change.tpl -->
