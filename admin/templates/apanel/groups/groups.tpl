<div id="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_group">&nbsp;</div>
	<div class="HeaderTitle">
		<h2>{#UGROUP_TITLE#}</h2>
	</div>
	<div class="HeaderText">{#UGROUP_INFO#}</div>
</div>
<div class="upPage">&nbsp;</div><br />

{if checkPermission('group_new')}
<script type="text/javascript" language="JavaScript">
function check_name() {ldelim}
	if (document.getElementById('Name').value == '') {ldelim}
		alert("{#UGROUP_ENTER_NAME#}");
		document.getElementById('Name').focus();
		return false;
	{rdelim}
	return true;
{rdelim}
</script>

<h4>{#UGROUP_NEW_GROUP#}</h4>
<form method="post" action="index.php?do=groups&amp;action=new&amp;cp={$sess}" onSubmit="return check_name();">
	<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
		<tr>
			<td class="second">{#UGROUP_NEW_NAME#} <input type="text" name="Name" id="Name" value="{$g_name|escape:html}" style="width: 250px;">&nbsp;<input type="submit" class="button" value="{#UGROUP_BUTTON_ADD#}" />
		</tr>
	</table>
</form>
{/if}

<h4>Список групп</h4>
<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
	<tr>
		<td class="tableheader">{#UGROUP_ID#}</td>
		<td class="tableheader">{#UGROUP_NAME#}</td>
		<th class="tableheader">{#UGROUP_COUNT#}</th>
		<th colspan="2" class="tableheader">{#UGROUP_ACTIONS#}</th>
	</tr>

	{* foreach from=$ugroups item=g *}
	{foreach from=$navi_groups item=g}
		<tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
			<td width="1%" class="itcen">{$g->Benutzergruppe}</td>

			<td>
				{if checkPermission('group_edit')}
					{if $g->Benutzergruppe > 2}
						<a title="{#UGROUP_EDIT#}" href="index.php?do=groups&amp;action=grouprights&amp;cp={$sess}&amp;Id={$g->Benutzergruppe}"><strong>{$g->Name|escape:html}</strong></a>
					{else}
						<strong>{$g->Name|escape:html}</strong>
					{/if}
				{else}
					<strong>{$g->Name|escape:html}</strong>
				{/if}
			</td>

			<td align="center"  width="1%">{if checkPermission('user')}{if $g->Benutzergruppe==2 || $g->UserCount < 1}-{else}<a title="{#UGROUP_IN_GROUP#}" href="index.php?do=user&amp;cp={$sess}&amp;Benutzergruppe={$g->Benutzergruppe}">{$g->UserCount}</a>{/if}{else}<strong>{$g->UserCount}</strong>{/if}</td>

			<td width="1%" align="center">
				{if checkPermission('group_edit')}
					{if $g->Benutzergruppe > 2}
						<a title="{#UGROUP_EDIT#}" href="index.php?do=groups&amp;action=grouprights&amp;cp={$sess}&amp;Id={$g->Benutzergruppe}">
						<img src="{$tpl_dir}/images/icon_edit.gif" alt="" border="0" /></a>
					{else}
						<img src="{$tpl_dir}/images/icon_edit_no.gif" alt="" border="0" />
					{/if}
				{else}
					<img title="{#UGROUP_NO_PERMISSION#}" src="{$tpl_dir}/images/icon_edit_no.gif" alt="" border="0" />
				{/if}
			</td>

			<td width="1%" align="center">
				{if checkPermission('group_edit')}
					{if $g->Benutzergruppe > 2}
						{if $g->UserCount > 0}
							<img title="{#UGROUP_USERS_IN_GROUP#}" src="{$tpl_dir}/images/icon_delete.gif" alt="" border="0" />
						{else}
							<a title="{#UGROUP_DELETE#}" onclick="return confirm('{#UGROUP_DELETE_CONFIRM#}')" href="index.php?do=groups&amp;action=delete&amp;cp={$sess}&amp;Id={$g->Benutzergruppe}">
							<img src="{$tpl_dir}/images/icon_delete.gif" alt="" border="0" /></a>
						{/if}
					{else}
						<img title="{#UGROUP_NO_DELETABLE#}" src="{$tpl_dir}/images/icon_delete_no.gif" alt="" border="0" />
					{/if}
				{else}
					<img title="{#UGROUP_NO_PERM_DELETE#}" src="{$tpl_dir}/images/icon_delete_no.gif" alt="" border="0" />
				{/if}
			</td>
		</tr>
	{/foreach}
</table><br />
<br />
<div class="iconHelpSegmentBox">
	<div class="segmentBoxHeader">
		<div class="segmentBoxTitle">&nbsp;</div>
	</div>
	<div class="segmentBoxContent">
		<img class="absmiddle" src="{$tpl_dir}/images/arrow.gif" alt="" border="0" /> <strong>{#UGROUP_LEGEND_LINK#}</strong><br />
		<br />
		<img class="absmiddle" src="{$tpl_dir}/images/icon_edit.gif" alt="" border="0" /> - {#UGROUP_LEGEND_EDIT#}<br />
		<img class="absmiddle" src="{$tpl_dir}/images/icon_delete.gif" alt="" border="0" /> - {#UGROUP_LEGEND_DELETE#}
	</div>
</div>