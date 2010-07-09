<div id="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_group">&nbsp;</div>
	<div class="HeaderTitle">
		<h2>{#UGROUP_TITLE#}</h2>
	</div>
	<div class="HeaderText">{#UGROUP_INFO#}</div>
</div>
<div class="upPage">&nbsp;</div><br />

{if check_permission('group_new')}
<script type="text/javascript" language="JavaScript">
function check_name() {ldelim}
	if (document.getElementById('user_group_name').value == '') {ldelim}
		alert("{#UGROUP_ENTER_NAME#}");
		document.getElementById('user_group_name').focus();
		return false;
	{rdelim}
	return true;
{rdelim}
</script>

<h4>{#UGROUP_NEW_GROUP#}</h4>
<form method="post" action="index.php?do=groups&amp;action=new&amp;cp={$sess}" onSubmit="return check_name();">
	<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
		<tr>
			<td class="second">{#UGROUP_NEW_NAME#} <input type="text" name="user_group_name" id="user_group_name" value="{$g_name|escape}" style="width: 250px;">&nbsp;<input type="submit" class="button" value="{#UGROUP_BUTTON_ADD#}" />
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

	{foreach from=$ugroups item=g}
		<tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
			<td width="1%" class="itcen">{$g->user_group}</td>

			<td>
				{if check_permission('group_edit')}
					{if $g->user_group > 2}
						<a title="{#UGROUP_EDIT#}" href="index.php?do=groups&amp;action=grouprights&amp;cp={$sess}&amp;Id={$g->user_group}"><strong>{$g->user_group_name|escape}</strong></a>
					{else}
						<a title="{#UGROUP_NAME_EDIT#}" href="index.php?do=groups&amp;action=grouprights&amp;cp={$sess}&amp;Id={$g->user_group}"><strong>{$g->user_group_name|escape}</strong></a>
					{/if}
				{else}
					<strong>{$g->user_group_name|escape}</strong>
				{/if}
			</td>

			<td align="center" width="1%">{if check_permission('user')}{if $g->user_group==2 || $g->UserCount < 1}-{else}<a title="{#UGROUP_IN_GROUP#}" href="index.php?do=user&amp;cp={$sess}&amp;user_group={$g->user_group}">{$g->UserCount}</a>{/if}{else}<strong>{$g->UserCount}</strong>{/if}</td>

			<td width="1%" align="center">
				{if check_permission('group_edit')}
					{if $g->user_group > 2}
						<a title="{#UGROUP_EDIT#}" href="index.php?do=groups&amp;action=grouprights&amp;cp={$sess}&amp;Id={$g->user_group}">
						<img src="{$tpl_dir}/images/icon_edit.gif" alt="" border="0" /></a>
					{else}
						<a title="{#UGROUP_NAME_EDIT#}" href="index.php?do=groups&amp;action=grouprights&amp;cp={$sess}&amp;Id={$g->user_group}">
						<img src="{$tpl_dir}/images/icon_edit.gif" alt="" border="0" /></a>
					{/if}
				{else}
					<img title="{#UGROUP_NO_PERMISSION#}" src="{$tpl_dir}/images/icon_edit_no.gif" alt="" border="0" />
				{/if}
			</td>

			<td width="1%" align="center">
				{if check_permission('group_edit')}
					{if $g->user_group > 2}
						{if $g->UserCount > 0}
							<img title="{#UGROUP_USERS_IN_GROUP#}" src="{$tpl_dir}/images/icon_delete_no.gif" alt="" border="0" />
						{else}
							<a title="{#UGROUP_DELETE#}" onclick="return confirm('{#UGROUP_DELETE_CONFIRM#}')" href="index.php?do=groups&amp;action=delete&amp;cp={$sess}&amp;Id={$g->user_group}">
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