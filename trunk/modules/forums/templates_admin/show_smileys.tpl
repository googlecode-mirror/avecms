<div class="pageHeaderTitle" style="padding-top: 7px;">
<div class="h_module"></div>
    <div class="HeaderTitle"><h2>{#FORUMS_MODULE_NAME#}</h2></div>
    <div class="HeaderText">{#FORUMS_SMILIES_INF#}</div>
</div><br />
{include file="$source/forum_topnav.tpl"}
<h4>{#FORUMS_SMILIES#}</h4>
<form action="index.php?do=modules&action=modedit&mod=forums&moduleaction=list_smilies&cp={$sess}&save=1" method="post" enctype="multipart/form-data" name="kform">
	<table width="100%"  border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<tr class="tableheader">
			<td width="100">{#FORUMS_HEADER_SMILIES_ACTIVE#}</td>
			<td width="100" align="center">{#FORUMS_HEADER_SMILIES_CODE#}</td>		
			<td width="100" align="center">{#FORUMS_HEADER_SMILIES_PATH#}</td>
			<td width="30" align="center"></td>
			<td width="100" align="center">{#FORUMS_HEADER_POSI#}</td>
			<td width="1%"><input name="allbox" type="checkbox" id="d" onclick="selall();" value="" /></td>
			<td></td>
		</tr>
	{foreach from=$smileys item="sm"}
		<tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
			<td width="100" nowrap>
				<input type="radio" name="active[{$sm->id}]" value="1" {if $sm->active==1}checked{/if}> {#FORUMS_YES#}
				<input type="radio" name="active[{$sm->id}]" value="2" {if $sm->active==2}checked{/if}> {#FORUMS_NO#}
			</td>
			<td width="100" align="center" nowrap><input name="code[{$sm->id}]" type="text" id="code[{$sm->id}]" value="{$sm->code}" size="10"></td>
			<td width="100" align="center" nowrap><input name="path[{$sm->id}]" type="text" id="path[{$sm->id}]" value="{$sm->path}" size="15"></td>
			<td width="30" align="center" nowrap><img src="../templates/{$smarty.const.DEFAULT_THEME_FOLDER}/modules/forums/smilies/{$sm->path}" /></td>
			<td width="100" align="center"><input name="posi[{$sm->id}]" type="text" id="posi[{$sm->id}]" value="{$sm->posi}" size="5"></td>
			<td><input name="del[{$sm->id}]" type="checkbox" id="d" value="1" /></td>
			<td></td>
		</tr>
  {/foreach}
		<tr >
			<td colspan="7" class="second"><input type="submit" class="button" value="{#FORUMS_BUTTON_SAVE#}" /></td>
		</tr>
  </table>
</form>
<h4>{#FORUMS_ADD_SMILIES#}</h4>
<form action="index.php?do=modules&action=modedit&mod=forums&moduleaction=list_smilies&cp={$sess}&new=1" method="post" enctype="multipart/form-data" name="adds" id="adds">
	<table width="100%"  border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<tr class="tableheader">
			<td>{#FORUMS_HEADER_SMILIES_CODE#}</td>
			<td>{#FORUMS_HEADER_SMILIES_PATH#}</td>
			<td></td>
		</tr>
	{section name="new" loop=5}
    	{assign var="count" value=$count+1}
		<tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
			<td width="10%" align="center"><input name="code[]" type="text" id="code[]"></td>
			<td width="1%"><input name="path[]" type="text" id="path[]"></td>
			<td></td>
		</tr>
	{/section}
		<tr class="second">
			<td colspan="3"><input type="submit" class="button" value="{#FORUMS_BUTTON_ADD_SMILIES#}" /></td>
		</tr>
  </table>
</form>