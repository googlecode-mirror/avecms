<div class="pageHeaderTitle" style="padding-top:7px;">
	<div class="h_module"></div>
	<div class="HeaderTitle"><h2>{#BANNER_MODULE_NAME#}</h2></div>
	<div class="HeaderText">{#BANNER_MODULE_WELCOME#}</div>
</div><br />

<div class="infobox">
	<strong>{#BANNER_SHOW_ALL#}</strong> |&nbsp;
	<a href="javascript:void(0);"onclick="window.location.href='index.php?do=modules&action=modedit&mod={$mod_path}&moduleaction=1&cp={$sess}';cp_pop('index.php?do=modules&action=modedit&mod={$mod_path}&moduleaction=newbanner&cp={$sess}&pop=1','860','700','1','modbannenews');">{#BANNER_NEW_LINK#}</a> |&nbsp;
	<a href="index.php?do=modules&action=modedit&mod={$mod_path}&moduleaction=category&cp={$sess}">{#BANNER_CATEG_LINK#}</a>
</div><br />

<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
	<tr class="tableheader">
		<td width="10">&nbsp;</td>
		<td>{#BANNER_NAME_TABLE#} </td>
		<td>{#BANNER_FILE_TABLE#}</td>
		<td>{#BANNER_INCATEG_TABLE#}</td>
		<td>{#BANNER_SHOW_TABLE#}</td>
		<td>{#BANNER_HITS_TABLE#}</td>
		<td>{#BANNER_VIEWS_TABLE#}</td>
		<td colspan="2">{#BANNER_ACTIONS#}</td>
	</tr>
	{foreach from=$banners item=banner}
		{if ($banner->banner_status != 1) || ($banner->banner_file_name=='') || ($banner->banner_clicks >= $banner->banner_max_clicks && $banner->banner_max_clicks != 0) || ($banner->banner_views >= $banner->banner_max_views && $banner->banner_max_views != 0)}
			{assign var=active value=0}
		{else}
			{assign var=active value=1}
		{/if}

		<tr style="background-color:#eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
			<td width="10">
				{if $active!=1}
					<img title="{#BANNER_NOT_ACTIVE#}" src="{$tpl_dir}/images/icon_lock.gif" alt="" />
				{else}
					<img title="{#BANNER_IS_ACTIVE#}" src="{$tpl_dir}/images/icon_unlock.gif" alt="" />
				{/if}
			</td>

			<td><a href="javascript:void(0);" title="{#BANNER_EDIT_LINK#}" onclick="cp_pop('index.php?do=modules&action=modedit&mod={$mod_path}&moduleaction=editbanner&cp={$sess}&id={$banner->Id}&pop=1','860','700','1','modbanneredit');">{$banner->banner_name}</a></td>
			<td><a href="../modules/{$mod_path}/files/{$banner->banner_file_name}" title="{#BANNER_VIEW_LINK#}" target="_blank">{$banner->banner_file_name}</a></td>
			<td>
				{foreach from=$categories item=category}
					{if $category->Id==$banner->banner_category_id}{$category->banner_category_name}{/if}
				{/foreach}
			</td>
			<td align="center">{if $banner->banner_show_start<10}0{/if}{$banner->banner_show_start}:00  - {if $banner->banner_show_end<10}0{/if}{$banner->banner_show_end}:00</td>
			<td align="center">{$banner->banner_clicks} / {if $banner->banner_max_clicks==0}~{else}{$banner->banner_max_clicks}{/if}</td>
			<td align="center">{$banner->banner_views} / {if $banner->banner_max_views==0}~{else}{$banner->banner_max_views}{/if}</td>
			<td width="1%" align="center">
				<a title="{#BANNER_EDIT_LINK#}" href="javascript:void(0);" onclick="cp_pop('index.php?do=modules&action=modedit&mod={$mod_path}&moduleaction=editbanner&cp={$sess}&id={$banner->Id}&pop=1','860','700','1','modbanneredit');">
					<img src="{$tpl_dir}/images/icon_edit.gif" alt="" border="0" />
				</a>
			</td>
			<td width="1%" align="center">
				<a title="{#BANNER_DELETE_LINK#}" onclick="return confirm('{#BANNER_DELETE_CONFIRM#}')" href="index.php?do=modules&action=modedit&mod={$mod_path}&moduleaction=delbanner&cp={$sess}&id={$banner->Id}">
					<img src="{$tpl_dir}/images/icon_del.gif" alt="" border="0" />
				</a>
			</td>
		</tr>
	{/foreach}
</table><br />

{if $page_nav}<div class="infobox">{$page_nav}</div>{/if}