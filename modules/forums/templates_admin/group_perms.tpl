<div class="pageHeaderTitle" style="padding-top: 7px;">
<div class="h_module"></div>
    <div class="HeaderTitle"><h2>{#ModName#}</h2></div>
    <div class="HeaderText">{#R_Info#}</div>
</div><br />
{include file="$source/forum_topnav.tpl"}
<br>
<form action="index.php?do=modules&action=modedit&mod=forums&moduleaction=user_ranks&cp={$sess}&save=1" method="post">
<table width="100%"  border="0" cellspacing="1" cellpadding="8" class="tableborder">
  <tr>
  <td colspan="2" class="tableheader">{#Perm_GroupsAll#}</td>
  </tr>
{foreach from=$groups item=g}
  <tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
	  <td nowrap="nowrap"><a href="javascript:void(0);" onclick="window.open('index.php?do=modules&action=modedit&mod=forums&moduleaction=group_perms&cp={$sess}&pop=1&group={$g->Benutzergruppe}','gr','width=650,height=700,scrollbars=yes,left=0,top=0');">{$g->Name}</a></td>
	  <td width="1%"><a href="javascript:void(0);" onclick="window.open('index.php?do=modules&action=modedit&mod=forums&moduleaction=group_perms&cp={$sess}&pop=1&group={$g->Benutzergruppe}','gr','width=650,height=700,scrollbars=yes,left=0,top=0');"><img src="{$tpl_dir}/images/icon_edit.gif" alt="" border="0" /></a></td>
</tr>
 {/foreach}

</table>
</form>
