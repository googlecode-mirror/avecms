<div class="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_module"></div>
	<div class="HeaderTitle"><h2>{#FORUMS_MODULE_NAME#}</h2></div>
	<div class="HeaderText">{#FORUMS_GROUP_PERM_INFO#}</div>
</div><br />

{include file="$source/forum_topnav.tpl"}
<br>

<form action="index.php?do=modules&action=modedit&mod=forums&moduleaction=user_ranks&cp={$sess}&save=1" method="post">
	<table width="100%"  border="0" cellspacing="1" cellpadding="8" class="tableborder">
		<tr class="tableheader">
			<td>{#FORUMS_HEADER_PERM_GROUPS_ALL#}</td>
			<td>{#FORUMS_HEADER_ACTIONS#}</td>
		</tr>
		{foreach from=$groups item=g}
			<tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
				<td nowrap="nowrap">
					<a title="{#FORUMS_TITLE_PERM_GROUP#}" href="javascript:void(0);" onclick="window.open('index.php?do=modules&action=modedit&mod=forums&moduleaction=group_perms&cp={$sess}&pop=1&group={$g->user_group}','gr','width=650,height=700,scrollbars=yes,left=0,top=0');">{$g->user_group_name|escape}</a>
				</td>
				<td width="1%" align="center">
					<a title="{#FORUMS_TITLE_PERM_GROUP#}" href="javascript:void(0);" onclick="window.open('index.php?do=modules&action=modedit&mod=forums&moduleaction=group_perms&cp={$sess}&pop=1&group={$g->user_group}','gr','width=650,height=700,scrollbars=yes,left=0,top=0');"><img src="{$tpl_dir}/images/icon_edit.gif" alt="" border="0" /></a>
				</td>
			</tr>
		{/foreach}
	</table>
</form>
