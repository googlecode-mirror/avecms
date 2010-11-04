
<script type="text/javascript">
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

<h2 id="page-heading">{#LOGIN_PASSWORD_CHANGE#}</h2>

<div class="block" id="forms">
	{if $changeok==1}
		<fieldset>
			<p>{#LOGIN_PASSWORD_OK#}</p>
		</fieldset>
	{else}
		<form method="post" action="{$ABS_PATH}index.php?module=login&action=passwordchange" onsubmit="return check_password();">
			<input type="hidden" name="sub" value="send" />

			<p>{#LOGIN_PASSWORD_INFO#}</p>

			{if $errors}
				<p>{#LOGIN_FOUND_ERROR#}</p>
				<ul>
					{foreach from=$errors item=error}
						<li class="regerror">{$error}</li>
					{/foreach}
				</ul>
			{/if}

			<fieldset class="login">
				<p>
					<label>{#LOGIN_OLD_PASSWORD#}</label>
					<input type="password" name="old_pass" id="o_pass" />
				</p>
				<p>
					<label>{#LOGIN_NEW_PASSWORD#}</label>
					<input type="password" name="new_pass" id="n_pass" />
				</p>
				<p>
					<label>{#LOGIN_NEW_PASSWORD_C#}</label>
					<input type="password" name="new_pass_c" id="n_pass_c" />
				</p>
				<input class="login button" type="submit" value="{#LOGIN_CHANGE_PASSWORD#}" />
			</fieldset>
		</form>
	{/if}
</div>
