
<!-- admin_list.tpl -->
{strip}

<div class="pageHeaderTitle" style="padding-top:7px">
	<div class="h_module"></div>
	<div class="HeaderTitle"><h2>{#SYSBLOCK_EDIT#}</h2></div>
	<div class="HeaderText">{#SYSBLOCK_EDIT_TIP#}</div>
</div><br />

<div class="infobox">
	» <a href="index.php?do=modules&action=modedit&mod=sysblock&moduleaction=edit&cp={$sess}">{#SYSBLOCK_ADD#}</a>
</div><br />

{if $SysBlock}
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<col width="20">
		<col>
		<col width="100">
		<col width="20">
		<col width="20">
		<tr class="tableheader">
			<td>{#SYSBLOCK_ID#}</td>
			<td>{#SYSBLOCK_NAME#}</td>
			<td>{#SYSBLOCK_TAG#}</td>
			<td colspan="2">{#SYSBLOCK_ACTIONS#}</td>
		</tr>

		{foreach from=$SysBlock item=item}
			<tr style="background-color:#eff3eb" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
				<td class="itcen">{$item->id}</td>
				<td>
					<a title="{#SYSBLOCK_EDIT_HINT#}" href="index.php?do=modules&action=modedit&mod=sysblock&moduleaction=edit&cp={$sess}&id={$item->id}">
						{$item->sysblock_name|escape}
					</a>
				</td>
				<td>
					<input name="textfield" type="text" value="[mod_sysblock:{$item->id}]"  />
				</td>
				<td align="center">
					<a title="{#SYSBLOCK_EDIT_HINT#}" href="index.php?do=modules&action=modedit&mod=sysblock&moduleaction=edit&cp={$sess}&id={$item->id}">
						<img src="{$tpl_dir}/images/icon_edit.gif" alt="" border="0" />
					</a>
				</td>
				<td align="center">
					<a title="{#SYSBLOCK_DELETE_HINT#}" onclick="return confirm('{#SYSBLOCK_DEL_HINT#}');" href="index.php?do=modules&action=modedit&mod=sysblock&moduleaction=del&cp={$sess}&id={$item->id}">
						<img src="{$tpl_dir}/images/icon_del.gif" alt="" border="0" />
					</a>
				</td>
			</tr>

		{/foreach}
	</table>
{else}
	<h4 style="color:#800000">{#SYSBLOCK_NO_ITEMS#}</h4>
{/if}

{/strip}
<!-- /admin_list.tpl -->
