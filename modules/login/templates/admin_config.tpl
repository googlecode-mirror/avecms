
<div class="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_module">&nbsp;</div>
	<div class="HeaderTitle">
		<h2>{#LOGIN_MODULE_NAME#}</h2>
	</div>
	<div class="HeaderText">{#LOGIN_MODULE_INFO#}</div>
</div><br />

<form method="post" action="index.php?do=modules&action=modedit&mod=login&moduleaction=1&cp={$sess}&sub=save">
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<tr class="tableheader">
			<td colspan="2">{#LOGIN_MODULE_EDIT#}</td>
		</tr>

		<tr>
			<td width="200" class="first">{#LOGIN_REGISTRATION_TYPE#}</td>
			<td class="second">
				<select name="login_reg_type" id="login_reg_type">
					<option value="email" {if $login_reg_type=='email'}selected{/if}>{#LOGIN_TYPE_BYEMAIL#}</option>
					<option value="now" {if $login_reg_type=='now'}selected{/if}>{#LOGIN_TYPE_NOW#}</option>
					<option value="byadmin" {if $login_reg_type=='byadmin'}selected{/if}>{#LOGIN_TYPE_BYADMIN#}</option>
				</select>
			</td>
		</tr>

		<tr>
			<td width="200" class="first">{#LOGIN_USE_SCODE#}</td>
			<td class="second">
				<input name="login_antispam" type="radio" value="1" {if $login_antispam=='1'}checked{/if} >{#LOGIN_YES#}
				<input name="login_antispam" type="radio" value="0" {if $login_antispam!='1'}checked{/if}>{#LOGIN_NO#}
			</td>
		</tr>

		<tr>
			<td width="200" class="first">{#LOGIN_ENABLE_REGISTER#}</td>
			<td class="second">
				<input name="login_status" type="radio" value="1" {if $login_status=='1'}checked{/if} >{#LOGIN_YES#}
				<input name="login_status" type="radio" value="0" {if $login_status!='1'}checked{/if}>{#LOGIN_NO#}
			</td>
		</tr>

		<tr>
			<td class="first">{#LOGIN_SHOW_FIRSTNAME#}</td>
			<td class="second">
				<input name="login_require_firstname" type="radio" value="1" {if $login_require_firstname=='1'}checked{/if} >{#LOGIN_YES#}
				<input name="login_require_firstname" type="radio" value="0" {if $login_require_firstname!='1'}checked{/if}>{#LOGIN_NO#}
			</td>
		</tr>

		<tr>
			<td class="first">{#LOGIN_SHOW_LASTNAME#}</td>
			<td class="second">
				<input name="login_require_lastname" type="radio" value="1" {if $login_require_lastname=='1'}checked{/if} >{#LOGIN_YES#}
				<input name="login_require_lastname" type="radio" value="0" {if $login_require_lastname!='1'}checked{/if}>{#LOGIN_NO#}
			</td>
		</tr>

		<tr>
			<td class="first">{#LOGIN_SHOW_COMPANY#}</td>
			<td class="second">
				<input name="login_require_company" type="radio" value="1" {if $login_require_company=='1'}checked{/if} >{#LOGIN_YES#}
				<input name="login_require_company" type="radio" value="0" {if $login_require_company!='1'}checked{/if}>{#LOGIN_NO#}
			</td>
		</tr>

		<tr>
			<td width="200" class="first" valign="top">{#LOGIN_BLACK_DOMAINS#}</td>
			<td class="second">
				<textarea style="width:400px; height:100px" name="login_deny_domain" id="login_deny_domain">{$login_deny_domain}</textarea>
			</td>
		</tr>

		<tr>
			<td width="200" class="first" valign="top">{#LOGIN_BLACK_EMAILS#}</td>
			<td class="second" >
				<textarea style="width:400px; height:100px" name="login_deny_email" id="login_deny_email">{$login_deny_email}</textarea>
			</td>
		</tr>

		<tr>
			<td class="third" colspan="2"><input type="submit" class="button" value="{#LOGIN_BUTTON_SAVE#}" /></td>
		</tr>
	</table><br />
</form>
