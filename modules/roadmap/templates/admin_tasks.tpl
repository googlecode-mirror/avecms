<div class="pageHeaderTitle" style="padding-top: 7px;">
<div class="h_module"></div>
    <div class="HeaderTitle"><h2>{#ROADMAP_LIST_TASKS#}</h2></div>
    <div class="HeaderText">&nbsp;</div>
</div>
<br>
<div class="infobox"><a href="index.php?do=modules&action=modedit&mod=roadmap&moduleaction=1&cp={$sess}">{#ROADMAP_RETURN_MAIN#}</a> |
<a href="javascript:void(0);"onclick="cp_pop('index.php?do=modules&action=modedit&mod=roadmap&moduleaction=new_task&id={$smarty.request.id|escape}&cp={$sess}&pop=1','780','480','1','');">{#ROADMAP_NEW_TASK#}</a> |  ( {if $smarty.request.closed == 0}<b>{#ROADMAP_OPEN_TASKS#}</b>{else}<a href="index.php?do=modules&action=modedit&mod=roadmap&moduleaction=show_tasks&cp={$sess}&id={$smarty.request.id|escape}&closed=0">{#ROADMAP_OPEN_TASKS#}</a>{/if} | {if $smarty.request.closed ==1}<b>{#ROADMAP_CLOSED_TASKS#}</b>{else}<a href="index.php?do=modules&action=modedit&mod=roadmap&moduleaction=show_tasks&cp={$sess}&id={$smarty.request.id|escape}&closed=1">{#ROADMAP_CLOSED_TASKS#}</a>{/if} )
</div>
<br>
<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
  <tr class="tableheader">
	<td align="center" width="1%">{#ROADMAP_PROJECT_ID#}</td>
    <td>{#ROADMAP_TASK_DESC#}</td>
    <td>{#ROADMAP_OWNER#}</td>
	<td>{#ROADMAP_PRIORITY#}</td>
    <th colspan="2">{#ROADMAP_ACTIONS#}</th>
  </tr>
  {foreach from=$items item=item}
  <tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
   <td align="center">{$item->id}</td>
	<td><a title="{#ROADMAP_EDIT_TASK#}" href="javascript:void(0);" onclick="cp_pop('index.php?do=modules&action=modedit&mod=roadmap&moduleaction=edit_task&cp={$sess}&id={$item->id}&pop=1','780','480','1','');">{$item->task_desc}</a></td>
    <td>{$row->username|escape}</td>
    <td>{$item->priority}</td>
    <td width="1%" align="center">
	  <a title="{#ROADMAP_EDIT_TASK#}" href="javascript:void(0);" onclick="cp_pop('index.php?do=modules&action=modedit&mod=roadmap&moduleaction=edit_task&cp={$sess}&id={$item->id}&pop=1','780','480','1','');"><img src="{$tpl_dir}/images/icon_edit.gif" alt="" border="0" /></a></td>
    <td width="1%" align="center">
	  <a title="{#ROADMAP_TASK_DELETE#}" onclick="return confirm('{#ROADMAP_TASK_DELETE_C#}')" href="index.php?do=modules&action=modedit&mod=roadmap&moduleaction=del_task&cp={$sess}&id={$item->id}&pid={$smarty.request.id|escape}&closed={$smarty.request.closed|escape}"><img src="{$tpl_dir}/images/icon_del.gif" alt="" border="0" /></a>
	</td>
  </tr>
  {/foreach}
</table>
<br  />
{if $page_nav} <div class="infobox">{$page_nav}</div> {/if}

