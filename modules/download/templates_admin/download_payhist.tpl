<div class="pageHeaderTitle" style="padding-top: 7px;">
<div class="h_module"></div>
    <div class="HeaderTitle"><h2>{#ModName#}</h2></div>
    <div class="HeaderText">&nbsp;</div>
</div>
{include file="$source/download_topnav.tpl"}
<h4>{#PayHistory#}</h4>
  <table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
    <tr class="tableheader">
      <td>{#PayUser#}</td>
      <td>{#PayIP#}</td>
      <td>{#PaySumm#}</td>
      <td>{#PayFile#}</td>
      <td>{#PayDate#}</td>

    </tr>
    {foreach from=$pay item=i}
  <tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
	<td width="180">
	{$i->user_name}
	</td>
	<td align="center">{$i->User_IP}
	</td>
	<td align="center">{$i->PayAmount}
	</td>
	<td align="center" nowrap="nowrap">{$i->FileName}
	</td>
	<td align="center" nowrap="nowrap" class="itcen">{$i->PayDate}
	</td>
    </tr>
    {/foreach}
  </table>
<br />
<br />
{$page_nav}