
<h2 id="page-heading">{#LOGIN_TEXT_REGISTER#}</h2>

<div class="block" id="forms">
	{if $errors}
		<ul>
			{foreach from=$errors item=error}
				<li class="regerror">{$error}</li>
			{/foreach}
		</ul>
	{/if}
	<span id="checkResultUsername"></span>
	<span id="checkResultEmail"></span>

	<form method="post" action="{$ABS_PATH}index.php?module=login&action=register">
		<input type="hidden" name="sub" value="register" />
		<fieldset class="login">
			<legend>{#LOGIN_TEXT_AUTHORIZATION#}</legend>
			<p>
				<label><span id="checkUsername" style="display:none"><img src="/templates/960px/img/ajax-loader.gif" border="0" /></span>{#LOGIN_YOUR_LOGIN#}</label>
				<input name="user_name" id="username" value="{$smarty.post.user_name|escape|stripslashes}" type="text">
			</p>
			<p>
				<label><span id="checkEmail" style="display:none"><img src="/templates/960px/img/ajax-loader.gif" border="0" /></span>{#LOGIN_YOUR_MAIL#}</label>
				<input name="reg_email" id="email" value="{$smarty.post.reg_email|escape|stripslashes}" type="text">
			</p>
			<p>
				<label>{#LOGIN_PASSWORD#}</label>
				<input name="reg_pass" type="password" value="{$smarty.post.reg_pass|escape|stripslashes}">
			</p>
		</fieldset>

		<fieldset class="login">
			<legend>{#LOGIN_TEXT_USER_INFO#}</legend>
			{if $FirstName==1}
				<p>
					<label>{#LOGIN_YOUR_FIRSTNAME#}</label>
					<input name="reg_firstname" value="{$smarty.post.reg_firstname|escape|stripslashes}" type="text">
				</p>
			{/if}
			{if $LastName==1}
				<p>
					<label>{#LOGIN_YOUR_LASTNAME#}</label>
					<input name="reg_lastname" value="{$smarty.post.reg_lastname|escape|stripslashes}" type="text">
				</p>
			{/if}
			{if $FirmName==1}
				<p>
					<label>{#LOGIN_YOUR_COMPANY#}</label>
					<input name="company" value="{$smarty.post.company|escape|stripslashes}" type="text">
				</p>
			{/if}
			<p>
				<label>{#LOGIN_YOUR_COUNTRY#}</label>
				<select name="country">
					{if $smarty.request.action=='register' && $smarty.request.sub == 'register'}
						{assign var=sL value=$smarty.request.country|lower}
					{else}
						{assign var=sL value=$row->country|default:$smarty.session.user_language|lower}
					{/if}
					{foreach from=$available_countries item=land}
						<option value="{$land->country_code}"{if $sL==$land->country_code} selected{/if}>{$land->country_name}</option>
					{/foreach}
				</select>
			</p>
			{if $im}
				<p>
					<label>{#LOGIN_SECURITY_CODE#}</label>
					<div style="margin-bottom:1em" id="captcha">
						<img src="{$ABS_PATH}inc/captcha.php" alt="" width="120" height="60" border="0" />
					</div>
				</p>
				<p>
					<label>{#LOGIN_SECURITY_CODER#}</label>
					<input style="width:114px" name="reg_secure" type="text" value="" />
				</p>
			{/if}
			<input class="confirm button" value="{#LOGIN_BUTTON_SUBMIT#}" type="submit">
		</fieldset>
	</form>
</div>
