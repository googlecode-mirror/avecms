<div class="pageHeaderTitle" style="padding-top: 7px;">
<div class="h_module"></div>
    <div class="HeaderTitle"><h2>{#SNL_MODULE_NAME#}</h2></div>
    <div class="HeaderText">&nbsp;</div>
</div><br>

<div class="infobox">
  <strong>{#SNL_SENDING_LIST#}</strong> |
  <a href="javascript:void(0);" onclick="window.open('index.php?do=modules&amp;action=modedit&amp;mod=newsletter_sys&amp;moduleaction=new&amp;cp={$sess}&pop=1','newnl','top=0,left=0,width=850,height=750,scrollbars=1,resizable=1');">{#SNL_SEND_NEW#}</a>
</div>
<br>
<div class="infobox">
  <form method="post" action="index.php?do=modules&action=modedit&mod=newsletter_sys&moduleaction=1&cp=$sess">
    <input name="q" type="text" value="{$smarty.request.q|stripslashes|escape:html}" size="40" />
    <input type="submit" class="button" value="{#SNL_BUTTON_SEARCH#}" />
  </form>
</div>

<form method="post" action="index.php?do=modules&action=modedit&mod=newsletter_sys&moduleaction=delete&cp=$sess">
{if $smarty.request.file_not_found==1}
<br><div class="infobox">{#SNL_FILE_NOT_FOUND#}</div><br>
{/if}
<h4>{#SNL_SENDING_LIST#}</h4>
  <table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
    <tr class="tableheader">
      <td align="center" width="1%"><img src="{$tpl_dir}/images/icon_del.gif" alt="" /></td>
      <td>{#SNL_SEND_TITLE#}</td>
      <td width="80" align="center">{#SNL_SEND_TEXT#}</td>
      <td align="center" class="second">{#SNL_SEND_DATE#}</td>
      <td>{#SNL_SEND_AUTHOR#}</td>
      <td align="center">{#SNL_SEND_FORMAT#}</td>
      <td>{#SNL_SEND_RECIVERS#}</td>
      <td>{#SNL_SEND_ATTACHS#}</td>
    </tr>

    {foreach from=$items item=nl}
  <tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
      <td width="5" align="center"><input title="{#SNL_MARK_DELETE#}" name="del[{$nl->id}]" type="checkbox" id="del[]" value="checkbox" /></td>
      <td>{$nl->title|stripslashes|escape:html}</td>
      <td width="80" align="center"><input onclick="window.open('index.php?id={$nl->id}&do=modules&action=modedit&mod=newsletter_sys&moduleaction=shownewsletter&cp={$sess}&pop=1&format={$nl->format}','showtext','top=0,left=0,scrollbars=1,width=800,height=750')" type="button" class="button" value="{#SNL_SEND_SHOW#}" /></td>
      <td align="center" class="time">{$nl->send_date|date_format:$TIME_FORMAT|pretty_date:$DEF_LANGUAGE}</td>
      <td>{$nl->sender|stripslashes|escape:html}</td>
      <td align="center">{$nl->format|upper}</td>
      <td>{foreach from=$nl->groups item=e name=eg}{$e->Name}{if !$smarty.foreach.eg.last}, {/if}{/foreach}</td>
      <td>
	    {foreach from=$nl->attach item=attachments name=att}
	      <a href="index.php?do=modules&action=modedit&mod=newsletter_sys&moduleaction=getfile&cp={$sess}&file={$attachments}">{$attachments}</a>{if !$smarty.foreach.att.last}, {/if}
        {/foreach}
	  </td>
     </tr>
     {/foreach}
   </table>

<br /><input type="submit" class="button" value="{#SNL_DELETE_MARKED#}" />
</form>

<br /> {if $page_nav} <div class="infobox">{$page_nav}</div> {/if}
