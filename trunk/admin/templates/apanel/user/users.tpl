
<!-- users.tpl -->
{strip}

<div id="pageHeaderTitle" style="padding-top:7px;">
	<div class="h_user">&nbsp;</div>
	<div class="HeaderTitle">
		<h2>{#USER_SUB_TITLE#}</h2>
	</div>
	<div class="HeaderText">{#USER_TIP1#}</div>
</div>
<div class="upPage">&nbsp;</div><br />

{if checkPermission('user_new')}
<script type="text/javascript" language="JavaScript">
function check_name() {ldelim}
	if (document.getElementById('UserName').value == '') {ldelim}
		alert("{#USER_NO_FIRSTNAME#}");
		document.getElementById('UserName').focus();
		return false;
	{rdelim}
	return true;
{rdelim}
</script>

<h4>{#USER_NEW_ADD#}</h4>

<form method="post" action="index.php?do=user&amp;action=new&amp;cp={$sess}" onSubmit="return check_name();">
	<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
		<tr>
			<td class="second"><strong>{#USER_FIRSTNAME_ADD#}</strong>&nbsp;<input type="text" id="UserName" name="UserName" value="" style="width: 250px;">&nbsp;<input type="submit" class="button" value="{#USER_BUTTON_ADD#}" /></td>
		</tr>
	</table>
</form>
{/if}

{if checkPermission('user')}

<h4>{#MAIN_SEARCH_USERS#}</h4>

<form action="index.php?do=user&amp;cp={$sess}" method="post">
	<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
		<col width="15%" class="second">
		<col width="15%" class="first">
		<col width="15%" class="second">
		<col width="15%" class="first">
		<col width="15%" class="second">
		<col width="15%" class="first">
		<col width="10%" class="second">
		<tr>
			<td><strong>{#MAIN_USER_PARAMS#}</strong></td>
			<td>
				<input style="width:100%" name="query" type="text" id="l_query" value="{$smarty.request.query|escape:html}" />
			</td>
			<td><strong>{#MAIN_USER_STATUS#}</strong></td>
			<td>
				<select style="width:100%" name="Status">
					<option value="all" {if $smarty.request.Status=='all'}selected="selected"{/if}>{#MAIN_USER_STATUS_ALL#}</option>
					<option value="1" {if $smarty.request.Status=='1'}selected="selected"{/if}>{#MAIN_USER_STATUS_ACTIVE#}</option>
					<option value="0" {if $smarty.request.Status=='0'}selected="selected"{/if}>{#MAIN_USER_STATUS_INACTIVE#}</option>
				</select>
			</td>
			<td><strong>{#MAIN_USER_GROUP#}</strong></td>
			<td>
				<select style="width:100%" name="Benutzergruppe" id="l_ug">
					<option value="0">{#MAIN_ALL_USER_GROUP#}</option>
					{foreach from=$ugroups item=g}
						<option value="{$g->Benutzergruppe}">{$g->Name|escape:html}</option>
					{/foreach}
				</select>
			</td>
			<td><input style="width:85px" type="submit" class="button" value="{#MAIN_BUTTON_SEARCH#}" /></td>
		</tr>
	</table>
</form>
{/if}

<h4>{#USER_ALL#}</h4>

{if checkPermission('user_edit')}<form method="post" action="index.php?do=user&amp;cp={$sess}&amp;action=quicksave">{/if}
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<col width="20" class="itcen">
		<col width="20">
		<col>
		<col width="200">
		<col width="120" class="time">
		<col width="120" class="time">
		<col width="20">
		<col width="20">
		<col width="20">
		<col width="20">
		<tr class="tableheader">
			<td>{#USER_ID#}</td>
			<td align="center"><input type="checkbox" disabled="disabled" /></td>
			<td>{#USER_NAME#}</td>
			<td>{#USER_GROUP#}</td>
			<td>{#USER_LAST_VISIT#}</td>
			<td>{#USER_REGISTER_DATE#}</td>
			<td colspan="4"><div align="center">{#USER_ACTION#}</div></td>
		</tr>

		{foreach from=$users item=user}
			<tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
				<td>{$user->Id}</td>
				<td><input title="{#USER_MARK_DELETE#}"  name="del[{$user->Id}]" type="checkbox" id="del[{$user->Id}]" value="1" {if !checkPermission('user_loesch') || $user->Benutzergruppe==1 || $user->Id==$smarty.session.user_id}disabled{/if} /></td>
				<td>
					{if checkPermission('user_edit')}
						<a title="{#USER_EDIT#}" href="index.php?do=user&amp;action=edit&amp;Id={$user->Id}&amp;cp={$sess}">
					{/if}
					<strong>{if $user->UserName!=''}{$user->UserName}{else}{$user->Vorname} {$user->Nachname}{/if}</strong>
					{if checkPermission('user_edit')}</a>{/if}<br /><small>{$user->Email} (IP:{$user->IpReg})</small>
				</td>

				<td>
					{if $user->Status!=1}
						{#USER_STATUS_WAIT#}
					{else}
						<select name="Benutzergruppe[{$user->Id}]" style="width:100%;">
							{foreach from=$ugroups item=g}
								{if $g->Benutzergruppe!=2}
									<option value="{$g->Benutzergruppe}" {if $user->Id==1 && $g->Benutzergruppe!=1} disabled{else}{if $g->Benutzergruppe==$user->Benutzergruppe}selected{/if}{/if}>{$g->Name|escape:html}</option>
								{/if}
							{/foreach}
						</select>
					{/if}
				</td>

				<td>
					{if $user->Status==1}
						{$user->ZuletztGesehen|date_format:#USER_DATE_FORMAT#}
					{else}
						-
					{/if}
				</td>

				<td>{$user->Registriert|date_format:#USER_DATE_FORMAT#}</td>

				<td nowrap="nowrap" align="center">
					{if checkPermission('user_edit')}
						<a title="{#USER_EDIT#}" href="index.php?do=user&amp;action=edit&amp;Id={$user->Id}&amp;cp={$sess}">
						<img src="{$tpl_dir}/images/icon_edit.gif" alt="" border="0" /></a>
					{else}
						<img title="{#USER_NO_CHANGE#}" src="{$tpl_dir}/images/icon_edit_no.gif" alt="" border="0" />
					{/if}
				</td>

				<td nowrap="nowrap" align="center">
					{if $user->Id != 1}
						{if checkPermission('user_loesch') && $user->Id!=$smarty.session.user_id}
							<a title="{#USER_DELETE#}" onclick="return (confirm('{#USER_DELETE_CONFIRM#}'))" href="index.php?do=user&amp;action=delete&amp;Id={$user->Id}&amp;cp={$sess}">
							<img src="{$tpl_dir}/images/icon_delete.gif" alt="" border="0" /></a>
						{else}
							<img src="{$tpl_dir}/images/icon_delete_no.gif" alt="" border="0" />
						{/if}
					{else}
						<img src="{$tpl_dir}/images/icon_delete_no.gif" alt="" border="0" />
					{/if}
				</td>

				<td>
					{if $user->IsShop==1 && $user->Orders >= 1}
						<a title="{#USER_ORDERS#}" href="javascript:void(0)" onclick="window.open('index.php?do=modules&action=modedit&mod=shop&moduleaction=showorders&cp={$sess}&search=1&Query={$user->Id}&start_Day=1&start_Month=1&start_Year=2005&pop=1','best','left=0,top=0,width=960,height=700,scrollbars=1,resizable=1');"><img hspace="2" src="{$tpl_dir}/images/icon_shop.gif" alt="" border="0" /></a>
					{else}
						<img hspace="2" src="{$tpl_dir}/images/icon_shop_no.gif" alt="" />
					{/if}
				</td>

				<td>
					{if $user->IsShop==1}
						<a title="{#USER_DOWNLOADS#}" href="javascript:void(0);" onclick="window.open('index.php?do=modules&action=modedit&mod=shop&moduleaction=shop_downloads&cp={$sess}&Id={$i.Id}&pop=1&User={$user->Id}&N={$user->Nachname}','sd','top=0,left=0,height=600,width=970,scrollbars=1');">
						<img hspace="2" src="{$tpl_dir}/images/icon_esd_download.gif" alt="" border="0" /></a>
					{else}
						-
					{/if}
				</td>
			</tr>
		{/foreach}
	</table><br />

	{if checkPermission('user_edit')}<input type="submit" class="button" value="{#USER_BUTTON_SAVE#}" />{/if}
</form><br />

{if $page_nav}
	<div class="infobox">{$page_nav}</div><br />
{/if}<br />

<div class="iconHelpSegmentBox">
	<div class="segmentBoxHeader">
		<div class="segmentBoxTitle">&nbsp;</div>
	</div>
	<div class="segmentBoxContent">
		<img class="absmiddle" src="{$tpl_dir}/images/arrow.gif" alt="" border="0" /> <strong>{#USER_LEGEND#}</strong><br />
		<br />
		<img class="absmiddle" src="{$tpl_dir}/images/icon_edit.gif" alt="" border="0" /> - {#USER_EDIT#}<br />
		<img class="absmiddle" src="{$tpl_dir}/images/icon_delete.gif" alt="" border="0" /> - {#USER_DELETE#}
	</div>
</div>

{/strip}
<!-- /users.tpl -->
