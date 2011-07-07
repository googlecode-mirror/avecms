<div class="pageHeaderTitle" style="padding-top: 7px;">
<div class="h_module"></div>
    <div class="HeaderTitle"><h2>{#ROADMAP_MODULE_NAME#}</h2></div>
    <div class="HeaderText">&nbsp;</div>
</div>
<br>
<div class="infobox"><strong>{#ROADMAP_LIST_PROJECTS#}</strong> |
<a href="javascript:void(0);"onclick="window.location.href='index.php?do=modules&action=modedit&mod=roadmap&moduleaction=1&cp={$sess}';cp_pop('index.php?do=modules&action=modedit&mod=roadmap&moduleaction=new_project&cp={$sess}&pop=1','780','400','1','');">{#ROADMAP_NEW_PROJECT#}</a> </div>
<br>
<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
  <tr class="tableheader">
    <td align="center" width="1%"><img src="{$tpl_dir}/images/icon_del.gif" alt="" /></td>
	<td align="center" width="1%">{#ROADMAP_PROJECT_ID#} </td>
    <td>{#ROADMAP_PROJECT_NAME#} </td>
    <td>{#ROADMAP_OPEN_TASKS#}</td>
	<td >{#ROADMAP_CLOSED_TASKS#}</td>
    <th colspan="2">{#ROADMAP_ACTIONS#}</th>
  </tr>
  {foreach from=$items item=item}
  <tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
    <td width="10">
	{if $item->project_status !=1}
	  <img title="{#ROADMAP_STATUS_INACTIVE#}" src="{$tpl_dir}/images/icon_lock.gif" alt="" />
	{else}
	  <img title="{#ROADMAP_STATUS_ACTIVE#}" src="{$tpl_dir}/images/icon_unlock.gif" alt="" />
	{/if}
	</td>
    <td align="center">{$item->id}</td>
	<td><a title="{#ROADMAP_TASKS_VIEW#}" href="index.php?do=modules&action=modedit&mod=roadmap&moduleaction=show_tasks&cp={$sess}&id={$item->id}&closed=0">{$item->project_name}</a></td>
    <td>{$item->open_tasks}</td>
    <td>{$item->closed_tasks}</td>
    <td width="1%" align="center">
	  <a title="{#ROADMAP_EDIT#}" href="javascript:void(0);" onclick="cp_pop('index.php?do=modules&action=modedit&mod=roadmap&moduleaction=edit_project&cp={$sess}&id={$item->id}&pop=1','780','345','1','');"><img src="{$tpl_dir}/images/icon_edit.gif" alt="" border="0" /></a></td>
    <td width="1%" align="center">
	  <a title="{#ROADMAP_DELETE#}" onclick="return confirm('{#ROADMAP_DELETE_CONFIRM#}')" href="index.php?do=modules&action=modedit&mod=roadmap&moduleaction=del_project&cp={$sess}&id={$item->id}"><img src="{$tpl_dir}/images/icon_del.gif" alt="" border="0" /></a>
	</td>
  </tr>
  {/foreach}
</table>
<br  />
{if $page_nav} <div class="infobox">{$page_nav}</div> {/if}

