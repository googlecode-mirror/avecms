<script language="javascript">
function mark_freemail() {ldelim}
	if(document.getElementById('free').selected==true)
		document.getElementById('SendFreeMail').checked=true;
	else
		document.getElementById('SendFreeMail').checked=false;
{rdelim}

function mark_mailpass() {ldelim}
	if(document.getElementById('password').value!='')
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
		<div class="HeaderTitle"><h2>{#USER_EDIT_TITLE#}<span style="color: #000;">&nbsp;&gt;&nbsp;{$row->firstname|escape} {$row->lastname|escape}</span></h2></div>
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

<form method="post" action="{$formaction}" enctype="multipart/form-data">
	<input name="Email_Old" type="hidden" value="{$smarty.request.email|stripslashes|default:$row->email|escape}" />
	<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
		<col width="300" valign="top" class="first">
		<col class="second">
		<tr>
			<td class="tableheader">{#SETTINGS_NAME#}</td>
			<td class="tableheader">{#SETTINGS_VALUE#}</td>
		</tr>

		<tr>
			<td>{#USER_LOGIN#}</td>
			<td><input name="user_name" type="text" id="user_name" size="40" style="width:250px;" value="{$smarty.request.user_name|stripslashes|default:$row->user_name|escape}" /></td>
		</tr>

		<tr>
			<td>{#USER_FIRSTNAME#}</td>
			<td><input name="firstname" type="text" id="firstname" size="40" style="width:250px;" value="{$smarty.request.firstname|stripslashes|default:$row->firstname|escape}" /></td>
		</tr>

		<tr>
			<td>{#USER_LASTNAME#}</td>
			<td><input name="lastname" type="text" id="lastname" size="40" style="width:250px;" value="{$smarty.request.lastname|stripslashes|default:$row->lastname|escape}" /></td>
		</tr>

		<tr>
			<td>{#USER_EMAIL#}</td>
			<td><input name="email" type="text" id="email" size="40" style="width:250px;" value="{$smarty.request.email|stripslashes|default:$row->email|escape}" /></td>
		</tr>

		<tr>
			<td>{#USER_PASSWORD#}&nbsp;{if $smarty.request.action=='edit'} ({#USER_PASSWORD_CHANGE#}){/if}</td>
			<td>
				{if $smarty.request.action=='edit'}
					<input onchange="mark_mailpass();" onkeydown="mark_mailpass();" onkeyup="mark_mailpass();" name="password" type="text" id="password" size="40" style="width:250px;" maxlength="50" />
				{else}
					<input name="password" type="text" id="password" size="40" style="width:250px;" maxlength="50" />
				{/if}
			</td>
		</tr>

		{if $is_forum==1 && $smarty.request.action=='edit'}
			<tr>
				<td>{#USER_NICK#}</td>
				<td><input name="uname_fp" type="text" size="40" style="width:250px;" value="{$row_fp->uname|escape}" /></td>
			</tr>

			<tr>
				<td>{#USER_SIGNATURE#}</td>
				<td><textarea name="signature_fp" style="width:400px; height:100px">{$row_fp->signature|escape}</textarea></td>
			</tr>

			<tr>
				<td>{#USER_AVATAR#}</td>
				<td>
					{if $row_fp->avatar != ''}
						<img src="../{$smarty.const.UPLOAD_AVATAR_DIR}/{$row_fp->avatar|escape}" alt="" /><br />
					{/if}
					<input type="text" name="avatar_fp" size="40" style="width:250px;" value="{$row_fp->avatar|escape}" />
				</td>
			</tr>
		{/if}

		{if $is_shop==1}
			<tr>
				<td>{#USER_TAX#}</td>
				<td>
					<input type="radio" name="taxpay" value="1" {if $row->taxpay=='1'}checked="checked" {/if}/> {#USER_YES#}
					<input type="radio" name="taxpay" value="0" {if $row->taxpay=='0'}checked="checked" {/if}/> {#USER_NO#}
				</td>
			</tr>
		{/if}

		<tr>
			<td>{#USER_COMPANY#}</td>
			<td><input name="company" type="text" size="40" style="width:250px;" value="{$smarty.request.company|stripslashes|default:$row->company|escape}" /></td>
		</tr>

		<tr>
			<td>{#USER_HOUSE_STREET#}</td>
			<td>
				<input name="street" type="text" id="street" size="25" style="width:180px;" value="{$smarty.request.street|stripslashes|default:$row->street|escape}" />&nbsp;
				<input name="street_nr" type="text" id="street_nr" size="7" style="width:60px;" maxlength="10" value="{$smarty.request.street_nr|stripslashes|default:$row->street_nr|escape}" />
			</td>
		</tr>

		<tr>
			<td>{#USER_ZIP_CODE#}</td>
			<td><input name="zipcode" type="text" id="zipcode" size="40" style="width:250px;" maxlength="20" value="{$smarty.request.zipcode|stripslashes|default:$row->zipcode|escape}" /></td>
		</tr>

		<tr>
			<td>{#USER_CITY#}</td>
			<td><input name="city" type="text" id="city" size="40" style="width:250px;" value="{$smarty.request.city|stripslashes|default:$row->city|escape}" /></td>
		</tr>

		<tr>
			<td>{#USER_COUNTRY#}</td>
			<td>
				<select name="country" style="width:250px;">
					{if $smarty.request.action=='new'}
						{assign var=sL value=$smarty.request.country|default:$smarty.session.user_language|escape|stripslashes}
					{else}
						{assign var=sL value=$row->country|escape|stripslashes}
					{/if}
					{foreach from=$available_countries item=land}
						<option value="{$land->country_code}"{if $sL==$land->country_code} selected="selected"{/if}>{$land->country_name|escape}</option>
					{/foreach}
				</select>
			</td>
		</tr>

		<tr>
			<td>{#USER_PHONE#}</td>
			<td><input name="phone" type="text" id="phone" size="40" style="width:250px;" value="{$smarty.request.phone|stripslashes|default:$row->phone|escape}" /></td>
		</tr>

		<tr>
			<td>{#USER_FAX#}</td>
			<td><input name="telefax" type="text" id="telefax" size="40" style="width:250px;" value="{$smarty.request.telefax|stripslashes|default:$row->telefax|escape}" /></td>
		</tr>

		<tr>
			<td>{#USER_BIRTHDAY#} <small>{#USER_BIRTHDAY_FORMAT#}</small></td>
			<td><input name="birthday" type="text" id="birthday" size="25" style="width:250px;" maxlength="10" value="{$smarty.request.birthday|stripslashes|default:$row->birthday|escape}" /></td>
		</tr>

		<tr>
			<td>{#USER_NOTICE#}</td>
			<td><textarea name="description" style="width:400px; height:100px" id="description">{$smarty.request.description|stripslashes|default:$row->description|escape}</textarea></td>
		</tr>

		<tr>
			<td>{#USER_MAIN_GROUP#}</td>
			<td>
				<select style="width:250px;" name="user_group">
					{if $smarty.request.action=='new' && $smarty.request.user_group != ''}
						{assign var=bG value=$smarty.request.user_group|stripslashes|escape}
					{else}
						{assign var=bG value=$smarty.request.user_group|stripslashes|default:$row->user_group|escape|default:4}
					{/if}
					{foreach from=$ugroups item=g}
						<option value="{$g->user_group}"{if $row->Id==1 && $g->user_group!=1} disabled="disabled"{else}{if $bG==$g->user_group}{assign var=ItsGroup value=$g->user_group} selected="selected"{/if}{/if}>{$g->user_group_name|escape}</option>
					{/foreach}
				</select>
			</td>
		</tr>

		<tr>
			<td>{#USER_SECOND_GROUP#}<br /><small>{#USER_SECOND_INFO#}</small></td>
			<td>
				<select name="user_group_extra[]" size="8" multiple="multiple" id="user_group_extra" style="width:250px;">
					{foreach from=$ugroups item=g}
						<option value="{$g->user_group}"{if $row->Id==1 && $g->user_group!=1} disabled="disabled"{elseif $user_group_extra && in_array($g->user_group,$user_group_extra)} selected="selected"{/if}>{$g->user_group_name|escape}</option>
					{/foreach}
				</select>
			</td>
		</tr>

		<tr>
			<td>{#USER_STATUS#}</td>
			<td>
				<select style="width:250px;" name="status" id="status" onchange="mark_freemail();">
					<option id="free" value="1"{if $row->status==1 || $smarty.request.action=='new'} selected="selected"{/if}>{#USER_ACTIVE#}</option>
					<option id="notfree" value="0"{if $row->Id==1 && $g->user_group!=1} disabled="disabled"{else}{if $row->status==0 && $smarty.request.action!='new'} selected="selected"{/if}{if $ItsGroup=='1' && $smarty.session.user_group=='1'} disabled="disabled"{/if}{/if}>{#USER_INACTIVE#}</option>
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
				<td><input name="SubjectMessage" type="text" id="SubjectMessage" value="{$smarty.request.SubjectMessage|stripslashes|escape}" size="40" style="width:400px;" /></td>
			</tr>

			<tr>
				<td>{#USER_MESSAGE_TEXT#}</td>
				<td><textarea style="width:400px; height:100px" name="SimpleMessage" id="SimpleMessage">{$smarty.request.SimpleMessage|stripslashes|escape}</textarea></td>
			</tr>
		{/if}
	</table><br />
	<input type="submit" class="button" value="{if $smarty.request.action=='new'}{#USER_BUTTON_ADD#}{else}{#USER_BUTTON_SAVE#}{/if}" />
</form>