
<!-- perms.tpl -->
{strip}

<div id="pageHeaderTitle" style="padding-top:7px;">
	<div class="h_group">&nbsp;</div>
	<div class="HeaderTitle">
		<h2>{#UGROUP_TITLE2#}<span style="color: #000;"> &gt; {$g_name|escape:html}</span></h2>
	</div>
	{if $own_group==1}
		<br />
		<div class="HeaderTextError">{#UGROUP_YOUR_NOT_CHANGE#}</div><br />
		<br />
	{else}
		<div class="HeaderText">{#UGROUP_WARNING_TIP#}</div><br />
		<br />
		{if $no_group==1}
			<div class="HeaderTextError">{#UGROUP_NOT_EXIST#}</div><br />
			<br />
		{/if}
	{/if}
</div>
<div class="upPage">&nbsp;</div><br />

{if $own_group!=1 && $no_group!=1}

<form method="post" action="index.php?do=groups&amp;action=grouprights&amp;cp={$sess}&amp;Id={$smarty.request.Id}&amp;sub=save">
	<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
		<tr>
			<td class="tableheader">{#UGROUP_NAME#}</td>
		</tr>

		<tr>
			<td class="first"><input name="Name" type="text" value="{$g_name|escape:html}" size="40" maxlength="40" /></td>
		</tr>
	</table><br />

	<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
		<tr>
			<td class="tableheader">{#UGROUP_MODULES_RIGHT#}</td>
		</tr>

		<tr class="{cycle name='fs' values='first,second'}">
			<td valign="top">
				<select name="perms[]" style="width:300px" size="10" multiple="multiple" id="xxx">
					{foreach from=$modules item=module}
						{if $module->ModulPfad != 'mod_navigation'}
							<option value="{$module->ModulPfad}"{if in_array($module->ModulPfad, $g_group_permissions) || in_array('alles', $g_group_permissions)} selected="selected"{/if}{if $smarty.request.Id == 1 || $smarty.request.Id == $PAGE_NOT_FOUND_ID || in_array('alles', $g_group_permissions)} disabled="disabled"{/if}>{$module->ModulName|strip_tags}</option>
						{/if}
					{/foreach}
				</select>
			</td>
		</tr>
	</table><br />

	<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
		<col width="20">
		<tr>
			<td class="tableheader"><input type="checkbox" disabled="disabled" /></td>
			<td class="tableheader">{#UGROUP_CONTROL_RIGHT#}</td>
		</tr>

		{foreach from=$g_all_permissions item=perm}
			<tr class="{cycle name='fs' values='first,second'}">
				<td>
					<input type="checkbox" name="perms[]" value="{$perm}"{if in_array($perm, $g_group_permissions) || in_array('alles', $g_group_permissions)} checked="checked"{/if}{if $smarty.request.Id == 1 || $smarty.request.Id == $PAGE_NOT_FOUND_ID || in_array('alles', $g_group_permissions)} disabled="disabled"{/if} />
				</td>
				<td>{$config_vars.$perm}</td>
			</tr>
		{/foreach}
	</table><br />

	<input type="submit" class="button" value="{#UGROUP_BUTTON_SAVE#}" />
</form>

{/if}

{/strip}
<!-- /perms.tpl -->
