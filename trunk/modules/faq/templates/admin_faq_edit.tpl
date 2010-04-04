<div class="pageHeaderTitle" style="padding-top: 7px;">
<div class="h_module"></div>
    <div class="HeaderTitle"><h2>{#faq_EDIT#}</h2></div>
    <div class="HeaderText">{#faq_EDIT_TIP#}</div>
</div><br>
<div class="infobox">
<a href="index.php?do=modules&action=modedit&mod=faq&moduleaction=edit_quest&cp={$sess}&parent={$parent}&id=">{#faq_ADD_QUEST#}</a>
&nbsp;|&nbsp;
<a href="index.php?do=modules&action=modedit&mod=faq&moduleaction=1&cp={$sess}">{#faq_BACK#}</a>
</div>
<br>
{if $quest}
  <table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
    <tr class="tableheader">
      <td width="40%">{#faq_QUEST#}</td>
 	  <td width="50%">{#faq_ANSWER#}</td>
      <td width="2%" colspan="2">{#faq_ACTIONS#}</td>
    </tr>
    {foreach from=$quest item=item}
  <tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
      <td>
      {$item->quest|stripslashes|truncate:40}
      </td>
      <td>
     {$item->answer|stripslashes|truncate:60}
      </td>
      <td align="center">
        <a title="{#faq_QEDIT_HINT#}" href="index.php?do=modules&action=modedit&mod=faq&moduleaction=edit_quest&cp={$sess}&id={$item->id}">
        <img src="{$tpl_dir}/images/icon_edit.gif" alt="" border="0" /></a>
      </td>
      <td align="center">
        <a title="{#faq_QDELETE_HINT#}" href="index.php?do=modules&action=modedit&mod=faq&moduleaction=del_quest&cp={$sess}&id={$item->id}">
        <img src="{$tpl_dir}/images/icon_del.gif" alt="" border="0" />
      </td>
    </tr>
    {/foreach}
  </table>
<br />
</form>
{else}
<h4 class="error" style="color: #800000">{#faq_NO_ITEMS#}</h4>
{/if}

