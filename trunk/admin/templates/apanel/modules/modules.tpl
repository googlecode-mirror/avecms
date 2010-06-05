<div id="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_module">&nbsp;</div>
	<div class="HeaderTitle"><h2>{#MODULES_SUB_TITLE#}</h2></div>
	<div class="HeaderText">{#MODULES_TIP#}</div>
</div>
<div class="upPage">&nbsp;</div>

{if $errors}
	<ul class="infobox_error">
		{foreach from=$errors item=message}
			<li>{$message}</li>
		{/foreach}
	</ul>
{/if}

{assign var=permission_modules_admin value=check_permission('modules_admin')}
{if $permission_modules_admin}
	<form method="post" action="index.php?do=modules&action=quicksave&cp={$sess}">
{/if}

<h4>{#MODULES_INSTALLED#}</h4>

<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
	<col width="30" />
	<col width="200" />
	<col width="150" />
	<col />
	<col width="90" />
	{if $permission_modules_admin}
		<col width="30" />
		<col width="30" />
		<col width="30" />
	{/if}
	<tr class="tableheader">
		<td align="center">?</td>
		<td>{#MODULES_NAME#}</td>
		<td>{#MODULES_TEMPLATE#}</td>
		<td>{#MODULES_SYSTEM_TAG#}</td>
		<td align="center">{#MODULES_VERSION#}</td>
		{if $permission_modules_admin}
			<td colspan="3">{#MODULES_ACTIONS#}</td>
		{/if}
	</tr>

	{foreach from=$installed_modules item=module}
		{if $module->permission}
			<tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
				<td align="center">
					<a title="<b>{$module->name}</b><br>{$module->info|escape|default:''}" href="javascript:void(0);" style="cursor:help;">
						<img src="{$tpl_dir}/images/icon_help.gif" alt="" border="0" />
					</a>
				</td>

				<td nowrap="nowrap">
					{if $module->adminedit && $module->status}
						<a href="index.php?do=modules&action=modedit&mod={$module->path}&moduleaction=1&cp={$sess}">{$module->name}</a>
					{else}
						{$module->name}
					{/if}
				</td>

				<td>
					{if $module->template}
						{assign var=module_id value=$module->id}
						{if $module->status}
							{html_options name=Template[$module_id] options=$all_templates selected=$module->template style="width:100%"}
						{else}
							{html_options name=Template[$module_id] options=$all_templates selected=$module->template style="width:100%" disabled="disabled"}
						{/if}
					{else}
						&nbsp;
					{/if}
				</td>

				<td>{$module->tag|stripslashes|default:'&nbsp;'}</td>

				<td align="center" class="Version">{$module->version|escape|default:''}</td>

				{if $permission_modules_admin}
					<td align="center">
						{if $module->status}
							<a title="{#MODULES_STOP#}" href="index.php?do=modules&amp;action=onoff&amp;module={$module->path}&amp;cp={$sess}">
								<img src="{$tpl_dir}/images/icon_stop.gif" alt="" border="0" />
							</a>
						{else}
							<a title="{#MODULES_START#}" href="index.php?do=modules&amp;action=onoff&amp;module={$module->path}&amp;cp={$sess}">
								<img src="{$tpl_dir}/images/icon_start.gif" alt="" border="0" />
							</a>
						{/if}
					</td>

					<td align="center">
						{if $module->status}
							<a title="{#MODULES_REINSTALL#}" onclick="return confirm('{#MODULES_REINSTALL_CONF#}')" href="index.php?do=modules&amp;action=reinstall&amp;module={$module->path}&amp;cp={$sess}">
								<img src="{$tpl_dir}/images/icon_reinstall.gif" alt="" border="0" />
							</a>
						{else}
							<a title="{#MODULES_DELETE#}" onclick="return confirm('{#MODULES_DELETE_CONFIRM#}')" href="index.php?do=modules&amp;action=delete&amp;module={$module->path}&amp;cp={$sess}">
								<img src="{$tpl_dir}/images/icon_delete.gif" alt="" border="0" />
							</a>
						{/if}
					</td>

					<td align="center">
						{if $module->need_update}
							<a title="{#MODULES_UPDATE#}" href="index.php?do=modules&amp;action=update&amp;module={$module->path}&amp;cp={$sess}">
								<img src="{$tpl_dir}/images/icon_new_versions.gif" alt="" border="0" />
							</a>
						{else}
							&nbsp;
						{/if}
					</td>
				{/if}
			</tr>
		{/if}
	{/foreach}
</table><br />

{if $permission_modules_admin}
	<input type="submit" class="button" value="{#MODULES_BUTTON_SAVE#}" />
</form>
{/if}

{if $not_installed_modules}

<h4>{#MODULES_NOT_INSTALLED#}</h4>

<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
	<col width="30" />
	<col width="200" />
	<col width="150" />
	<col />
	<col width="90" />
	{if $permission_modules_admin}
		<col width="30" />
		<col width="30" />
		<col width="30" />
	{/if}
	<tr class="tableheader">
		<td align="center">?</td>
		<td>{#MODULES_NAME#}</td>
		<td>{#MODULES_TEMPLATE#}</td>
		<td>{#MODULES_SYSTEM_TAG#}</td>
		<td align="center">{#MODULES_VERSION#}</td>
		{if $permission_modules_admin}
			<td colspan="3">{#MODULES_ACTIONS#}</td>
		{/if}
	</tr>

	{foreach from=$not_installed_modules item=module}
		{if $module->permission}
			<tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
				<td align="center">
					<a title="{$module->name} :: {$module->info|escape|default:''}" href="javascript:void(0);" style="cursor: help;">
						<img src="{$tpl_dir}/images/icon_help_no.gif" alt="" border="0" />
					</a>
				</td>

				<td>{if $module->adminedit}<strong>{$module->name}</strong>{else}{$module->name}{/if}</td>

				<td>
					{if $module->template}
						<select style="width:100%" disabled="disabled"><option>{$all_templates[1]}</option></select>
					{else}
						&nbsp;
					{/if}
				</td>

				<td>{$module->tag|stripslashes|default:''}</td>

				<td align="center" class="Version">{$module->version|escape|default:''}</td>

				{if $permission_modules_admin}
					<td align="center">
						<a title="{#MODULES_INSTALL#}" href="index.php?do=modules&amp;action=install&amp;module={$module->path}&amp;cp={$sess}">
							<img src="{$tpl_dir}/images/icon_install.gif" alt="" border="0" />
						</a>
					</td>

					<td align="center"><img src="{$tpl_dir}/images/icon_delete_no.gif" alt="" border="0" /></td>

					<td>&nbsp;</td>
				{/if}
			</tr>
		{/if}
	{/foreach}
</table><br />
{/if}
<br />

<div class="iconHelpSegmentBox">
	<div class="segmentBoxHeader">
		<div class="segmentBoxTitle">&nbsp;</div>
	</div>

	<div class="segmentBoxContent">
		<img class="absmiddle" src="{$tpl_dir}/images/arrow.gif" alt="" border="0" /> <strong>{#MODULES_LEGEND#}</strong><br />
		<br />
		<img class="absmiddle" src="{$tpl_dir}/images/icon_start.gif" alt="" border="0" /> - {#MODULES_START#}<br />
		<img class="absmiddle" src="{$tpl_dir}/images/icon_stop.gif" alt="" border="0" /> - {#MODULES_STOP#}<br />
		<img class="absmiddle" src="{$tpl_dir}/images/icon_delete.gif" alt="" border="0" /> - {#MODULES_DELETE#}<br />
		<img class="absmiddle" src="{$tpl_dir}/images/icon_install.gif" alt="" border="0" /> - {#MODULES_INSTALL#}<br />
		<img class="absmiddle" src="{$tpl_dir}/images/icon_reinstall.gif" alt="" border="0" /> - {#MODULES_REINSTALL#}<br />
		<img class="absmiddle" src="{$tpl_dir}/images/icon_new_versions.gif" alt="" border="0" /> - {#MODULES_UPDATE#}
	</div>
</div>