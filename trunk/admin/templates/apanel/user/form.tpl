
<!-- form.tpl -->
{strip}

<script language="javascript">
function mark_freemail() {ldelim}
	if(document.getElementById('free').selected==true)
		document.getElementById('SendFreeMail').checked=true;
	else
		document.getElementById('SendFreeMail').checked=false;
{rdelim}

function mark_mailpass() {ldelim}
	if(document.getElementById('Kennwort').value!='')
		document.getElementById('PassChange').checked=true;
	else
		document.getElementById('PassChange').checked=false;
{rdelim}
</script>

<div id="pageHeaderTitle" style="padding-top:7px;">
	<div class="h_user">&nbsp;</div>
	{if $smarty.request.action=='new'}
		<div class="HeaderTitle"><h2>{#USER_NEW_TITLE#}</h2></div>
		<div class="HeaderText">{#USER_NEW_TIP#}</div>
	{else}
		<div class="HeaderTitle"><h2>{#USER_EDIT_TITLE#}<span style="color: #000;">&nbsp;&gt;&nbsp;{$row->Vorname} {$row->Nachname}</span></h2></div>
		<div class="HeaderText">{#USER_EDIT_TIP#}</div>
	{/if}
</div>
<div class="upPage">&nbsp;</div><br />

{if $errors}
	<div class="HeaderText"><strong>{#USER_ERRORS#}</strong></div>
	<ul>
		{foreach from=$errors item=error}
			<li>{$error}</li>
		{/foreach}
	</ul><br />
{/if}

<form method="post" action="{$formaction}&Email_Old={$row->Email}" enctype="multipart/form-data">
	<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
		<col width="300" valign="top" class="first">
		<col class="second">
		<tr>
			<td class="tableheader">{#SETTINGS_NAME#}</td>
			<td class="tableheader">{#SETTINGS_VALUE#}</td>
		</tr>

		<tr>
			<td>{#USER_LOGIN#}</td>
			<td><input name="UserName" type="text" id="UserName" size="40" value="{$row->UserName}{if $smarty.request.UserName!=''}{$smarty.request.UserName|escape:html}{/if}"></td>
		</tr>

		<tr>
			<td>{#USER_FIRSTNAME#}</td>
			<td><input name="Vorname" type="text" id="Vorname" size="40" value="{$row->Vorname}{if $smarty.request.UserName!=''}{$smarty.request.UserName|escape:html}{/if}"></td>
		</tr>

		<tr>
			<td>{#USER_LASTNAME#}</td>
			<td><input name="Nachname" type="text" id="Nachname" size="40" value="{$row->Nachname}"></td>
		</tr>

		<tr>
			<td>{#USER_EMAIL#}</td>
			<td><input name="Email" type="text" id="Email" size="40" value="{$row->Email}"></td>
		</tr>

		<tr>
			<td>{#USER_PASSWORD#}&nbsp;{if $smarty.request.action=='edit'} ({#USER_PASSWORD_CHANGE#}){/if}</td>
			<td>
				{if $smarty.request.action=='edit'}
					<input onchange="mark_mailpass();" onkeydown="mark_mailpass();" onkeyup="mark_mailpass();" name="Kennwort" type="text" id="Kennwort" size="25" maxlength="20">
				{else}
					<input name="Kennwort" type="text" id="Kennwort" size="25" maxlength="20">
				{/if}
			</td>
		</tr>

		{if $is_forum==1 && $smarty.request.action=='edit'}
			<tr>
				<td>{#USER_NICK#}</td>
				<td><input name="BenutzerName_fp" type="text" size="40" value="{$row_fp->BenutzerName|stripslashes}"></td>
			</tr>

			<tr>
				<td>{#USER_SIGNATURE#}</td>
				<td><textarea name="Signatur_fp" style="width:300px; height:100px">{$row_fp->Signatur|stripslashes}</textarea></td>
			</tr>

			<tr>
				<td>{#USER_AVATAR#}</td>
				<td>
					{if $row_fp->Avatar!=''}
						<img src="../modules/forums/avatars/{$row_fp->Avatar}" alt="" /><br />
					{/if}
					<input type="text" name="Avatar_fp" size="40" value="{$row_fp->Avatar}">
				</td>
			</tr>
		{/if}

		{if $is_shop==1}
			<tr>
				<td>{#USER_TAX#}</td>
				<td>
					<input type="radio" name="UStPflichtig" value="1" {if $row->UStPflichtig=='1'}checked="checked"{/if} /> {#USER_YES#}&nbsp;
					<input type="radio" name="UStPflichtig" value="0" {if $row->UStPflichtig=='0'}checked="checked"{/if} /> {#USER_NO#}
				</td>
			</tr>
		{/if}

		<tr>
			<td>{#USER_COMPANY#}</td>
			<td><input name="Firma" type="text" size="40" value="{$row->Firma|escape}"></td>
		</tr>

		<tr>
			<td>{#USER_HOUSE_STREET#}</td>
			<td>
				<input name="Strasse" type="text" id="Strasse" size="25" value="{$row->Strasse}">&nbsp;
				<input name="HausNr" type="text" id="HausNr" size="10" maxlength="10" value="{$row->HausNr|escape:html}">
			</td>
		</tr>

		<tr>
			<td>{#USER_ZIP_CODE#}</td>
			<td><input name="Postleitzahl" type="text" id="Postleitzahl" size="25" maxlength="20" value="{$row->Postleitzahl}"></td>
		</tr>

		<tr>
			<td>{#USER_CITY#}</td>
			<td><input name="city" type="text" id="city" size="40" value="{$row->city}"></td>
		</tr>

		<tr>
			<td>{#USER_COUNTRY#}</td>
			<td>
				<select name="Land">
					{if $smarty.request.action=='new' && $smarty.request.Land != ''}
						{assign var=sL value=$smarty.request.Land}
					{else}
						{assign var=sL value=$row->Land|default:$DEF_COUNTRY}
					{/if}
					{foreach from=$available_countries item=land}
						<option value="{$land->LandCode}" {if $sL==$land->LandCode}selected{/if}>{$land->LandName}</option>
					{/foreach}
				</select>
			</td>
		</tr>

		<tr>
			<td>{#USER_PHONE#}</td>
			<td><input name="Telefon" type="text" id="Telefon" size="40" value="{$row->Telefon}"></td>
		</tr>

		<tr>
			<td>{#USER_FAX#}</td>
			<td><input name="Telefax" type="text" id="Telefax" size="40" value="{$row->Telefax}"></td>
		</tr>

		<tr>
			<td>{#USER_BIRTHDAY#}</td>
			<td><input name="GebTag" type="text" id="GebTag" size="25" maxlength="10" value="{$row->GebTag}">{#USER_BIRTHDAY_FORMAT#}</td>
		</tr>

		<tr>
			<td>{#USER_NOTICE#}</td>
			<td><textarea name="Bemerkungen" style="width:300px; height:100px" id="Bemerkungen">{$row->Bemerkungen}</textarea></td>
		</tr>

		<tr>
			<td>{#USER_MAIN_GROUP#}</td>
			<td>
				<select style="width:200px" name="Benutzergruppe">
					{if $smarty.request.action=='new' && $smarty.request.Benutzergruppe != ''}
						{assign var=bG value=$smarty.request.Benutzergruppe}
					{else}
						{assign var=bG value=$row->Benutzergruppe|default:4}
					{/if}
					{foreach from=$ugroups item=g}
						<option value="{$g->Benutzergruppe}" {if $row->Id==1 && $g->Benutzergruppe!=1} disabled{else}{if $bG==$g->Benutzergruppe}{assign var=ItsGroup value=$g->Benutzergruppe}selected{/if}{/if}>{$g->Name|escape:html}</option>
					{/foreach}
				</select>
			</td>
		</tr>

		<tr>
			<td>{#USER_SECOND_GROUP#}<br /><small>{#USER_SECOND_INFO#}</small></td>
			<td>
				<select name="BenutzergruppeMisc[]" size="8" multiple="multiple" id="BenutzergruppeMisc"  style="width:200px">
					{foreach from=$ugroups item=g}
						<option value="{$g->Benutzergruppe}" {if $row->Id==1 && $g->Benutzergruppe!=1} disabled{else}{if $BenutzergruppeMisc}{if in_array($g->Benutzergruppe,$BenutzergruppeMisc)}selected="selected"{/if}{else}{/if}{/if}>{$g->Name|escape:html}</option>
					{/foreach}
				</select>
			</td>
		</tr>

		<tr>
			<td>{#USER_STATUS#}</td>
			<td>
				<select style="width:150px" name="Status" id="Statuss" onchange="mark_freemail();">
					<option id="free" value="1" {if $row->Status==1 || $smarty.request.action=='new'}selected{/if}>{#USER_ACTIVE#}</option>
					<option id="notfree" value="0" {if $row->Id==1 && $g->Benutzergruppe!=1} disabled{else}{if $row->Status==0 && $smarty.request.action!='new'}selected{/if} {if $ItsGroup=='1' && $smarty.session.user_group=='1'}disabled{/if}{/if}>{#USER_INACTIVE#}</option>
				</select>
			</td>
		</tr>

		{if $smarty.request.action=='edit'}
			<tr>
				<td>{#USER_SEND_MESSAGE#}</td>
				<td><input name="SendFreeMail" type="checkbox" id="SendFreeMail" value="1" /> {#USER_MESSAGE_INFO#}</td>
			</tr>

			<tr>
				<td>{#USER_SEND_PASSWORD#}</td>
				<td><input name="PassChange" type="checkbox" id="PassChange" value="1" /> {#USER_PASSWORD_INFO#}</td>
			</tr>

			<tr>
				<td>{#USER_MESSAGE_SUBJECT#}</td>
				<td><input name="SubjectMessage" type="text" id="SubjectMessage" value="" size="40" /></td>
			</tr>

			<tr>
				<td>{#USER_MESSAGE_TEXT#}</td>
				<td><textarea style="width:300px; height:100px" name="SimpleMessage" id="SimpleMessage"></textarea></td>
			</tr>
		{/if}
	</table><br />
	<input type="submit" class="button" value="{if $smarty.request.action=='new'}{#USER_BUTTON_ADD#}{else}{#USER_BUTTON_SAVE#}{/if}" />
</form>

{/strip}
<!-- /form.tpl -->
