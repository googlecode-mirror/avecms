{strip}

<div id="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_module">&nbsp;</div>
	<div class="HeaderTitle"><h2>{#MODULES_SUB_TITLE#}</h2></div>
	<div class="HeaderText">{#MODULES_TIP#}</div>
</div>
<div class="upPage">&nbsp;</div><br />

{if checkPermission('modules_admin')}<form method="post" action="index.php?do=modules&action=quicksave&cp={$sess}">{/if}

<h4>Установленные</h4>

<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
	<tr class="tableheader">
		<td width="14px" align="center">?</td>
		<td width="184px">{#MODULES_NAME#}</td>
		<td>{#MODULES_SETTINGS#}</td>
		<td>{#MODULES_TEMPLATE#}</td>
		<td>{#MODULES_SYSTEM_TAG#}</td>
		<td width="70px">{#MODULES_VERSION#}</td>
		{if checkPermission('modules_admin')}
			<td width="76px" colspan="3">{#MODULES_ACTIONS#}</td>
		{/if}
	</tr>

	{foreach from=$modules item=modul}
		{if checkPermission($modul->mod_r) && $modul->mod_id != ''}
			<tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
				<td align="center">
					<a title="<b>{$modul->name}</b><br>{$modul->ol_info|stripslashes|escape:html|default:''}" href="javascript:void(0);" style="cursor:help;"><img src="{$tpl_dir}/images/icon_help.gif" alt="" border="0" /></a>
				</td>

				<td>
					<strong>{$modul->name}</strong>
				</td>

				<td width="2%" align="center" nowrap="nowrap">
					{if $modul->adminedit == 1 &&  $modul->status == 1 && checkPermission($modul->mod_r)}
						<a href="index.php?do=modules&action=modedit&mod={$modul->pfad}&moduleaction=1&cp={$sess}">{#MODULES_SETTINGS#}</a>
					{else}
						<small>&nbsp;-&nbsp;-&nbsp;-&nbsp;-&nbsp;-&nbsp;</small>
					{/if}
				</td>

				<td width="100">
					{if $modul->mt != '' &&  $modul->status == 1}
						<select name="Template[{$modul->mod_id}]">
							{foreach from=$modul->all_tmpl item=at}
								<option value="{$at->Id}" {if $at->Id == $modul->tid}selected="selected" {/if}>{$at->TplName}</option>
							{/foreach}
						</select>
					{elseif $modul->mt != '' &&  $modul->status == 0}
						<select disabled="disabled">
							{foreach from=$modul->all_tmpl item=at}
								<option value="{$at->Id}" {if $at->Id == $modul->tid}selected="selected" {/if}>{$at->TplName}</option>
							{/foreach}
						</select>
					{else}
						&nbsp;
					{/if}
				</td>

				<td>
					{if $modul->tag != ''}
						{$modul->tag}
					{else}
						&nbsp;
					{/if}
				</td>

				<td align="center" class="Version">
					{$modul->version}
				</td>

				{if checkPermission('modules_admin')}
					<td width="1%" align="center">
						{if $modul->status == 1}
							<a title="{#MODULES_STOP#}" href="index.php?do=modules&amp;action=onoff&amp;module={$modul->pfad}&amp;cp={$sess}"><img src="{$tpl_dir}/images/icon_stop.gif" alt="" border="0" /></a>
						{else}
							<a title="{#MODULES_START#}" href="index.php?do=modules&amp;action=onoff&amp;module={$modul->pfad}&amp;cp={$sess}"><img src="{$tpl_dir}/images/icon_start.gif" alt="" border="0" /></a>
						{/if}
					</td>

					<td width="1%" align="center">
						{if $modul->status == 1}
							<a title="{#MODULES_REINSTALL#}" onclick="return confirm('{#MODULES_REINSTALL_CONF#}')" href="index.php?do=modules&amp;action=reinstall&amp;module={$modul->pfad}&amp;cp={$sess}"><img src="{$tpl_dir}/images/icon_reinstall.gif" alt="" border="0" /></a>
						{else}
							<a title="{#MODULES_DELETE#}" onclick="return confirm('{#MODULES_DELETE_CONFIRM#}')" href="index.php?do=modules&amp;action=delete&amp;module={$modul->pfad}&amp;cp={$sess}"><img src="{$tpl_dir}/images/icon_delete.gif" alt="" border="0" /></a>
						{/if}
					</td>

					<td width="1%" align="center">
						{if $modul->mod_update == 1}
							<a title="{#MODULES_UPDATE#}" href="index.php?do=modules&amp;action=update&amp;module={$modul->pfad}&amp;cp={$sess}"><img src="{$tpl_dir}/images/icon_new_versions.gif" alt="" border="0" /></a>
						{else}
							<img src="{$tpl_dir}/images/icon_blank.gif" alt="" border="0" />
						{/if}
					</td>
				{/if}
			</tr>
		{/if}
	{/foreach}
</table><br />

{if checkPermission('modules_admin')}
	<input type="submit" class="button" value="{#MODULES_BUTTON_SAVE#}" />
</form>
{/if}

<h4>Неустановленные</h4>

<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
	<tr class="tableheader">
		<td width="14px" align="center">?</td>
		<td width="184px">{#MODULES_NAME#}</td>
		<td>{#MODULES_SETTINGS#}</td>
		<td>{#MODULES_TEMPLATE#}</td>
		<td>{#MODULES_SYSTEM_TAG#}</td>
		<td width="70px">{#MODULES_VERSION#}</td>
		{if checkPermission('modules_admin')}
			<td width="76px" colspan="3">{#MODULES_ACTIONS#}</td>
		{/if}
	</tr>

	{foreach from=$modules item=modul}
		{if checkPermission($modul->mod_r) && $modul->mod_id == ''}
			<tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
				<td align="center">
					<a title="{$modul->name} :: {$modul->ol_info|stripslashes|escape:html|default:''}" href="javascript:void(0);" style="cursor: help;"><img src="{$tpl_dir}/images/icon_help_no.gif" alt="" border="0" /></a>
				</td>

				<td>
					<font style="color: #656565;">{$modul->name}</font>
				</td>

				<td width="2%" align="center" nowrap="nowrap">
					<small>&nbsp;-&nbsp;-&nbsp;-&nbsp;-&nbsp;-&nbsp;</small>
				</td>

				<td width="100">
					{if $modul->mt != ''}
						<select disabled="disabled">
							{foreach from=$modul->all_tmpl item=at}
								<option value="{$at->Id}" {if $at->Id == $modul->tid}selected="selected" {/if}>{$at->TplName}</option>
							{/foreach}
						</select>
					{else}
						&nbsp;
					{/if}
				</td>

				<td>
					<font style="color: #ccc;">{if $modul->tag != ''}{$modul->tag|stripslashes|default:''}{else}&nbsp;{/if}</font>
				</td>

				<td align="center" class="Version">
					{$modul->version}
				</td>

				{if checkPermission('modules_admin')}
					<td width="1%" align="center">
						<a title="{#MODULES_INSTALL#}" href="index.php?do=modules&amp;action=install&amp;module={$modul->pfad}&amp;cp={$sess}"><img src="{$tpl_dir}/images/icon_install.gif" alt="" border="0" /></a>
					</td>

					<td width="1%" align="center">
						<img src="{$tpl_dir}/images/icon_delete_no.gif" alt="" border="0" />
					</td>

					<td width="1%" align="center">
						<img src="{$tpl_dir}/images/icon_blank.gif" alt="" border="0" />
					</td>
				{/if}
			</tr>
		{/if}
	{/foreach}
</table><br />
<br />

<div class="iconHelpSegmentBox">
	<div class="segmentBoxHeader">
		<div class="segmentBoxTitle">&nbsp;</div>
	</div>

	<div class="segmentBoxContent">
		<img class="absmiddle" src="{$tpl_dir}/images/arrow.gif" alt="" border="0" /> <strong>{#MODULES_LEGEND#}</strong><br />
		<br />
		<img class="absmiddle" src="{$tpl_dir}/images/icon_start.gif" alt="" border="0" /> - {$config_vars.MODULES_START}<br />
		<img class="absmiddle" src="{$tpl_dir}/images/icon_stop.gif" alt="" border="0" /> - {$config_vars.MODULES_STOP}<br />
		<img class="absmiddle" src="{$tpl_dir}/images/icon_delete.gif" alt="" border="0" /> - {$config_vars.MODULES_DELETE}<br />
		<img class="absmiddle" src="{$tpl_dir}/images/icon_install.gif" alt="" border="0" /> - {$config_vars.MODULES_INSTALL}<br />
		<img class="absmiddle" src="{$tpl_dir}/images/icon_reinstall.gif" alt="" border="0" /> - {$config_vars.MODULES_REINSTALL}<br />
		<img class="absmiddle" src="{$tpl_dir}/images/icon_new_versions.gif" alt="" border="0" /> - {$config_vars.MODULES_UPDATE}
	</div>
</div>

{/strip}