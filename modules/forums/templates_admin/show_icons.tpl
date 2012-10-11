<div class="pageHeaderTitle" style="padding-top: 7px;">
<div class="h_module"></div>
    <div class="HeaderTitle"><h2>{#FORUMS_MODULE_NAME#}</h2></div>
    <div class="HeaderText">{#FORUMS_ICONS_INF#}</div>
</div><br />
{include file="$source/forum_topnav.tpl"}
<h4>{#FORUMS_LIST_ICONS#}</h4>
<form action="index.php?do=modules&action=modedit&mod=forums&moduleaction=list_icons&cp={$sess}&save=1" method="post" enctype="multipart/form-data" name="kform">
	<table width="100%"  border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<tr class="tableheader">
			<td width="100">{#FORUMS_HEADER_ICON_ACTIVE#}</td>
			<td width="100" align="center">{#FORUMS_HEADER_ICON_NAME#}</td>
			<td width="30" align="center"></td>
			<td width="100" align="center">{#FORUMS_HEADER_POSI#}</td>
			<td><input name="allbox" type="checkbox" id="d" onclick="selall();" value="" /></td>
		</tr>
	{foreach from=$smileys item="sm"}
		<tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
			<td width="100" nowrap>
				<input type="radio" name="active[{$sm->id}]" value="1" {if $sm->active==1}checked{/if}> {#FORUMS_YES#}
				<input type="radio" name="active[{$sm->id}]" value="2" {if $sm->active==2}checked{/if}> {#FORUMS_NO#}
			</td>
			<td width="100" align="center" nowrap><input name="path[{$sm->id}]" type="text" id="path[{$sm->id}]" value="{$sm->path}" size="15"></td>
			<td width="30" align="center" nowrap><img src="../templates/{$smarty.const.DEFAULT_THEME_FOLDER}/modules/forums/posticons/{$sm->path}" /></td>
			<td width="100" align="center"><input name="posi[{$sm->id}]" type="text" id="posi[{$sm->id}]" value="{$sm->posi}" size="5"></td>
			<td><input name="del[{$sm->id}]" type="checkbox" id="d" value="1" /></td>
    </tr>
  {/foreach}
	<tr >
		<td colspan="5" class="second"><input type="submit" class="button" value="{#FORUMS_BUTTON_SAVE#}" /></td></tr>
	</table>
</form>
<h4>{#FORUMS_ADD_ILLUSTR#}</h4>
<form action="index.php?do=modules&action=modedit&mod=forums&moduleaction=list_icons&cp={$sess}&new=1" method="post" enctype="multipart/form-data" name="adds" id="adds">
	<table width="100%"  border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<tr class="tableheader">
			<td>{#FORUMS_HEADER_ICON_NAME#}</td>
		</tr>
	{section name="new" loop=5}
		{assign var="count" value=$count+1}
		<tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
			<td><input name="path[]" type="text" id="path[]">&nbsp;&nbsp;{#FORUMS_ICON_PATH#}</td>
		</tr>
	{/section}
		<tr>
			<td class="second" ><input type="submit" class="button" value="{#FORUMS_BUTTON_ADD_ILLUSTR#}" /></td>
		</tr>
	</table>
</form>
