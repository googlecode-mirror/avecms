{strip}

<div class="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_module"></div>
	<div class="HeaderTitle"><h2>{#POLL_MODULE_NAME#}</h2></div>
	<div class="HeaderText">&nbsp;</div>
</div><br />

<div class="infobox">
	<a href="javascript:void(0);" onclick="cp_pop('index.php?do=modules&action=modedit&mod=poll&moduleaction=new&cp={$sess}&pop=1','850','750','1','modpollnew');">{#POLL_NEW_LINK#}</a>
</div><br />

<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
	<tr class="tableheader">
		<td align="center" width="1%"><img src="{$tpl_dir}/images/icon_del.gif" alt="" /></td>
		<td>{#POLL_NAME#}</td>
		<td>{#POLL_SYSTEM_TAG#}</td>
		<td>{#POLL_START_END#}</td>
		<td>{#POLL_HITS_CMMENT#}</td>
		<td colspan="2" align="center" width="2%">{#POLL_ACTIONS#}</td>
	</tr>

	{foreach from=$items item=item}
		<tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
			<td width="10">
				{if $item->active != 1}
					<img title="{#POLL_INACTIVE#}" src="{$tpl_dir}/images/icon_lock.gif" alt="" />
				{else}
					<img title="{#POLL_ACTIVE#}" src="{$tpl_dir}/images/icon_unlock.gif" alt="" />
				{/if}
			</td>

			<td><a href="javascript:void(0);" onclick="cp_pop('index.php?do=modules&action=modedit&mod=poll&moduleaction=edit&cp={$sess}&id={$item->id}&pop=1','850','750','1','modpolledit');"><strong>{$item->title}</strong></a></td>

			<td><input type="text" value="[mod_poll:{$item->id}]" size="15" readonly=""></td>

			<td class="time">c {$item->start|date_format:$config_vars.POLL_DATE_FORMAT1} по {$item->ende|date_format:$config_vars.POLL_DATE_FORMAT1}</td>

			<td>{if $item->sum_hits == ''}0{else}{$item->sum_hits}{/if} / <a href="javascript:void(0);" onclick="cp_pop('index.php?do=modules&action=modedit&mod=poll&moduleaction=comments&cp={$sess}&id={$item->id}&pop=1','850','750','1','modpolledit');">{$item->comments}</a></td>

			<td width="1%" align="center"><a title="{#POLL_EDIT_POLL#}" href="javascript:void(0);" onclick="cp_pop('index.php?do=modules&action=modedit&mod=poll&moduleaction=edit&cp={$sess}&id={$item->id}&pop=1','850','750','1','modpolledit');"><img src="{$tpl_dir}/images/icon_edit.gif" alt="" border="0" /></a></td>

			<td width="1%" align="center"><a title="{#POLL_DELETE#}" onclick="return confirm('{#POLL_DELETE_CONFIRM#}');" href="index.php?do=modules&action=modedit&mod=poll&moduleaction=delete&cp={$sess}&id={$item->id}"><img src="{$tpl_dir}/images/icon_del.gif" alt="" border="0" /></a></td>
		</tr>
	{/foreach}
</table><br />

{if $page_nav} <div class="infobox">{$page_nav}</div> {/if}

{/strip}