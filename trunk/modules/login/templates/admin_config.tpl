<!-- admin_config.tpl -->
{strip}

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
				<select name="RegTyp" id="RegTyp">
					<option value="email" {if $RegTyp=='email'}selected{/if}>{#LOGIN_TYPE_BYEMAIL#}</option>
					<option value="now" {if $RegTyp=='now'}selected{/if}>{#LOGIN_TYPE_NOW#}</option>
					<option value="byadmin" {if $RegTyp=='byadmin'}selected{/if}>{#LOGIN_TYPE_BYADMIN#}</option>
				</select>
			</td>
		</tr>

		<tr>
			<td width="200" class="first">{#LOGIN_USE_SCODE#}</td>
			<td class="second">
				<input name="AntiSpam" type="radio" value="1" {if $AntiSpam=='1'}checked{/if} >{#LOGIN_YES#}
				<input name="AntiSpam" type="radio" value="0" {if $AntiSpam!='1'}checked{/if}>{#LOGIN_NO#}
			</td>
		</tr>

		<tr>
			<td width="200" class="first">{#LOGIN_ENABLE_REGISTER#}</td>
			<td class="second">
				<input name="IstAktiv" type="radio" value="1" {if $IstAktiv=='1'}checked{/if} >{#LOGIN_YES#}
				<input name="IstAktiv" type="radio" value="0" {if $IstAktiv!='1'}checked{/if}>{#LOGIN_NO#}
			</td>
		</tr>

		<tr>
			<td class="first">{#LOGIN_SHOW_FIRSTNAME#}</td>
			<td class="second">
				<input name="ZeigeVorname" type="radio" value="1" {if $ZeigeVorname=='1'}checked{/if} >{#LOGIN_YES#}
				<input name="ZeigeVorname" type="radio" value="0" {if $ZeigeVorname!='1'}checked{/if}>{#LOGIN_NO#}
			</td>
		</tr>

		<tr>
			<td class="first">{#LOGIN_SHOW_LASTNAME#}</td>
			<td class="second">
				<input name="ZeigeNachname" type="radio" value="1" {if $ZeigeNachname=='1'}checked{/if} >{#LOGIN_YES#}
				<input name="ZeigeNachname" type="radio" value="0" {if $ZeigeNachname!='1'}checked{/if}>{#LOGIN_NO#}
			</td>
		</tr>

		<tr>
			<td class="first">{#LOGIN_SHOW_COMPANY#}</td>
			<td class="second">
				<input name="ZeigeFirma" type="radio" value="1" {if $ZeigeFirma=='1'}checked{/if} >{#LOGIN_YES#}
				<input name="ZeigeFirma" type="radio" value="0" {if $ZeigeFirma!='1'}checked{/if}>{#LOGIN_NO#}
			</td>
		</tr>

		<tr>
			<td width="200" class="first" valign="top">{#LOGIN_BLACK_DOMAINS#}</td>
			<td class="second">
				{strip}<textarea style="width:400px; height:100px" name="DomainsVerboten" id="DomainsVerboten">{$DomainsVerboten}</textarea>{/strip}
			</td>
		</tr>

		<tr>
			<td width="200" class="first" valign="top">{#LOGIN_BLACK_EMAILS#}</td>
			<td class="second" >
				{strip}<textarea style="width:400px; height:100px" name="EmailsVerboten" id="EmailsVerboten">{$EmailsVerboten}</textarea>{/strip}
			</td>
		</tr>

		<tr>
			<td class="third" colspan="2"><input type="submit" class="button" value="{#LOGIN_BUTTON_SAVE#}" /></td>
		</tr>
	</table><br />
</form>

{/strip}
<!-- /admin_config.tpl -->
