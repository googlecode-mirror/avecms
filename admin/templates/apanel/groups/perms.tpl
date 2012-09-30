<div id="pageHeaderTitle" style="padding-top:7px;">
	<div class="h_group">&nbsp;</div>
	<div class="HeaderTitle">
		<h2>{#UGROUP_TITLE2#}<span style="color: #000;"> &gt; {$g_name|escape}</span></h2>
	</div>
	{if $own_group}
		<br />
		<div class="HeaderTextError">{#UGROUP_YOUR_NOT_CHANGE#}</div><br />
		<br />
	{else}
		<div class="HeaderText">{#UGROUP_WARNING_TIP#}</div><br />
		<br />
		{if $no_group}
			<div class="HeaderTextError">{#UGROUP_NOT_EXIST#}</div><br />
			<br />
		{/if}
	{/if}
</div>
<div class="upPage">&nbsp;</div><br />

{if !$no_group && !$own_group}

<form method="post" action="index.php?do=groups&amp;action=grouprights&amp;cp={$sess}&amp;Id={$smarty.request.Id|escape}&amp;sub=save">
	<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
		<tr>
			<td class="tableheader">{#UGROUP_NAME#}</td>
		</tr>

		<tr>
			<td class="first"><input name="user_group_name" type="text" value="{$g_name|escape}" size="40" maxlength="40" /></td>
		</tr>
	</table><br />
	
	<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
		<col width="250" class="first">
		<col class="second">
		
		<tr>
			<td class="tableheader" colspan="2">{#UGROUP_AVATAR_GROUPS#}</td>
		</tr>

		<tr>
			<td>{#UGROUP_USE_AVATAR_GROUPS#}</td>
			<td>
				<input type="radio" name="set_default_avatar" value="1"{if $g_set_default_avatar==1} checked{/if} />{*#UGROUP_YES#*}Да&nbsp;
				<input type="radio" name="set_default_avatar" value="0"{if $g_set_default_avatar==0} checked{/if} />{*#UGROUP_NO#*}Нет
			</td>
		</tr>
		
		<tr>
			<td>{#UGROUP_AVATAR_GROUPS#}<br /><small>Аватары находятся в каталоге "/{$smarty.const.UPLOAD_AVATAR_DIR}/default/"</small></td>
			<td>
				{if $g_default_avatar}
				<img src="../{$smarty.const.UPLOAD_AVATAR_DIR}/default/{$g_default_avatar|escape}" /><br />
				{/if}
				<input name="default_avatar" type="text" value="{$g_default_avatar|escape}" size="40" maxlength="40" />
			</td>
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
						{if $module->mod_path != 'mod_navigation'}
							<option value="{$module->mod_path}"{if in_array($module->mod_path, $g_group_permissions) || in_array('alles', $g_group_permissions)} selected="selected"{/if}{if $smarty.request.Id == 1 || $smarty.request.Id == $PAGE_NOT_FOUND_ID || in_array('alles', $g_group_permissions)} disabled="disabled"{/if}>{$module->ModulName|escape}</option>
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
				<td>{$smarty.config.$perm}</td>
			</tr>
		{/foreach}
	</table><br />

	<input type="submit" class="button" value="{#UGROUP_BUTTON_SAVE#}" />
</form>

{/if}