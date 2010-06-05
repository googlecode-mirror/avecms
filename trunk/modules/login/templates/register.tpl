<div class="box">
	<h2>
		<a href="#" id="toggle-forms">{#LOGIN_TEXT_REGISTER#}</a>
	</h2>
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

		<form method="post" action="{$ABS_PATH}index.php?module=login&action=register&sub=register">
			<fieldset class="login">
				<legend>{#LOGIN_TEXT_AUTHORIZATION#}</legend>
				<p>
					<label><span id="checkUsername" style="display:none"><img src="/templates/960px/img/ajax-loader.gif" border="0" /></span>{#LOGIN_YOUR_LOGIN#}</label>
					<input name="UserName" id="username" value="{$smarty.post.UserName|escape|stripslashes}" type="text">
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

			<fieldset>
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
						<input name="Firma" value="{$smarty.post.Firma|escape|stripslashes}" type="text">
					</p>
				{/if}
				<p>
					<label>{#LOGIN_YOUR_COUNTRY#}</label>
					<select name="Land">
						{if $smarty.request.action=='register' && $smarty.request.sub == 'register'}
							{assign var=sL value=$smarty.request.Land|lower}
						{else}
							{assign var=sL value=$row->Land|default:$smarty.session.user_language|lower}
						{/if}
						{foreach from=$available_countries item=land}
							<option value="{$land->LandCode}"{if $sL==$land->LandCode} selected{/if}>{$land->LandName}</option>
						{/foreach}
					</select>
				</p>
				{if $im}
					<p>
						<label>{#LOGIN_SECURITY_CODE#}</label>
						<div id="captcha">
							<img src="{$ABS_PATH}inc/captcha.php" alt="" width="120" height="60" border="0" />
						</div>
					</p>
					<p>
						<label>{#LOGIN_SECURITY_CODER#}</label>
						<input name="reg_secure" type="text" value="" />
					</p>
				{/if}
				<input class="confirm button" value="{#LOGIN_BUTTON_SUBMIT#}" type="submit">
			</fieldset>
		</form>
	</div>
</div>
{*
<h2 id="page-heading">{#LOGIN_TEXT_REGISTER#}</h2>

<div id="module_content">
	{if $errors}
		<ul>
			{foreach from=$errors item=e}
				<li class="regerror">{$e}</li>
			{/foreach}
		</ul>
	{/if}

	<form method="post" action="{$ABS_PATH}index.php?module=login&action=register&sub=register">
		<div class="formleft"><label for="UserName">{#LOGIN_YOUR_LOGIN#}</label></div>
		<div class="formright">
			<small><span id="h_UserName"></span></small>
			<input name="UserName" id="l_UserName" type="text" style="width:200px" value="{$smarty.post.UserName|escape|stripslashes}" size="80" />
		</div>
		<div class="clear"></div>

		{if $FirstName==1}
			<div class="formleft"><label for="l_reg_firstname">{#LOGIN_YOUR_FIRSTNAME#}</label></div>
			<div class="formright">
				<small><span id="h_reg_firstname"></span></small>
				<input name="reg_firstname" type="text" id="l_reg_firstname" style="width:200px" value="{$smarty.post.reg_firstname|escape|stripslashes}" size="80" />
			</div>
			<div class="clear"></div>
		{/if}

		{if $LastName==1}
			<div class="formleft"><label for="l_reg_lastname">{#LOGIN_YOUR_LASTNAME#}</label></div>
			<div class="formright">
				<small><span id="h_reg_lastname"></span></small>
				<input name="reg_lastname" type="text" id="l_reg_lastname" style="width:200px" value="{$smarty.post.reg_lastname|escape|stripslashes}" size="80" />
			</div>
			<div class="clear"></div>
		{/if}

		{if $FirmName==1}
			<div class="formleft"><label for="l_reg_Firma">{#LOGIN_YOUR_COMPANY#}</label></div>
			<div class="formright">
			<small><span id="h_Firma"></span></small>
				<input name="Firma" type="text" id="l_Firma" style="width:200px" value="{$smarty.post.Firma|escape|stripslashes}" size="80" />
			</div>
			<div class="clear"></div>
		{/if}

		<div class="formleft"><label for="l_reg_email">{#LOGIN_YOUR_MAIL#}</label></div>
		<div class="formright">
			<small><span id="h_reg_email"></span></small>
			<input name="reg_email" type="text" id="l_reg_email" style="width:200px" value="{$smarty.post.reg_email|escape|stripslashes}" size="80" />
		</div>
		<div class="clear"></div>

		<div class="formleft"><label for="l_reg_email_return">{#LOGIN_MAIL_CONFIRM#}</label></div>
		<div class="formright">
			<small><span id="h_reg_email_return"></span></small>
			<input name="reg_email_return" type="text" id="l_reg_email_return" style="width:200px" value="{$smarty.post.reg_email_return|escape|stripslashes}" size="80" />
		</div>
		<div class="clear"></div>

		<div class="formleft"><label for="l_reg_pass">{#LOGIN_PASSWORD#}</label></div>
		<div class="formright">
			<small><span id="h_reg_pass"></span></small>
			<input name="reg_pass" type="password" id="l_reg_pass" style="width:200px" value="{$smarty.post.reg_pass}" size="80" />
		</div>
		<div class="clear"></div>

		<div class="formleft"><label for="l_land">{#LOGIN_YOUR_COUNTRY#}</label></div>
		<div class="formright">
			<small><span id="h_land"></span></small>
			<select name="Land" id="l_land" style="width:205px">
				{if $smarty.request.action=='register' && $smarty.request.sub == 'register'}
					{assign var=sL value=$smarty.request.Land|lower}
				{else}
					{assign var=sL value=$row->Land|default:$smarty.session.user_language|lower}
				{/if}
				{foreach from=$available_countries item=land}
					<option value="{$land->LandCode}"{if $sL==$land->LandCode} selected{/if}>{$land->LandName}</option>
				{/foreach}
			</select>
		</div>
		<div class="clear"></div>

		{if $im}
			<div class="formleft">{#LOGIN_SECURITY_CODE#}</div>
			<div class="formright" id="captcha">
				<img src="{$ABS_PATH}inc/captcha.php" alt="" width="120" height="60" border="0" />
			</div>
			<div class="clear"></div>

			<div class="formleft"><label for="l_reg_secure">{#LOGIN_SECURITY_CODER#}</label></div>
			<div class="formright">
				<small><span id="h_reg_secure"></span></small>
				<input name="reg_secure" type="text" id="l_reg_secure" style="width:115px" value="" size="25" />
			</div>
			<div class="clear"></div>
		{/if}

		<div class="formleft">&nbsp;</div>
		<div class="formright">
			<input class="button" type="submit" value="{#LOGIN_BUTTON_SUBMIT#}" />
		</div>
		<div class="clear"></div>
	</form>
</div>
*}