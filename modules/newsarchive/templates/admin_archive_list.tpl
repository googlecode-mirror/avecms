<script type="text/javascript" language="JavaScript">

 function check_name() {ldelim}
   if (document.getElementById('new_arc').value == '') {ldelim}
     alert("{#ARCHIVE_ENTER_NAME#}");
     document.getElementById('new_arc').focus();
     return false;
   {rdelim}
   return true;
 {rdelim}

</script>
<div class="pageHeaderTitle" style="padding-top: 7px;">
<div class="h_module"></div>
    <div class="HeaderTitle"><h2>{#ARCHIVE_LIST#}</h2></div>
    <div class="HeaderText">{#ARCHIVE_LIST_TIP#}</div>
</div><br>
<br>
{if $archives}
<form method="post" action="index.php?do=modules&action=modedit&mod=newsarchive&moduleaction=savelist&cp={$sess}">
  <table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
    <tr class="tableheader">
      <td width="1%">{#ARCHIVE_NAME#}</td>
      <td width="1%">{#ARCHIVE_TAG#}</td>
      <td width="96%">{#ARCHIVE_USE_RUBRIKS#}</td>
      <td width="1%" colspan="2">{#ARCHIVE_ACTIONS#}</td>
    </tr>
    {foreach from=$archives item=item}
  <tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
      <td>
        <input name="arc_name[{$item->id}]" type="text" id="arc_name[{$item->id}]" value="{$item->arc_name|escape:html|stripslashes}" size="40" />
      </td>
      <td width="100"><input name="textfield" type="text" value="[newsarchive:{$item->id}]" readonly /></td>
      <td>{if !$item->RubrikName}{#ARCHIVE_NO_RUBRIKS#}{else}{$item->RubrikName}{/if}</td>
      <td align="center">
        <a title="{#ARCHIVE_EDIT_HINT#}" href="index.php?do=modules&action=modedit&mod=newsarchive&moduleaction=edit&cp={$sess}&id={$item->id}">
        <img src="{$tpl_dir}/images/icon_edit.gif" alt="" border="0" /></a>
      </td>
      <td align="center">
        <a title="{#ARCHIVE_DELETE_HINT#}" href="index.php?do=modules&action=modedit&mod=newsarchive&moduleaction=del&cp={$sess}&id={$item->id}">
        <img src="{$tpl_dir}/images/icon_del.gif" alt="" border="0" />
      </td>
    </tr>
    {/foreach}
  </table>
<br /><input type="submit" class="button" value="{#ARCHIVE_BUTTON_SAVE#}" />
</form>
{else}
{#ARCHIVE_NO_ITEMS#}
{/if}

<br /><br />

<h4>{#ARCHIVE_ADD#}</h4>

<form action="index.php?do=modules&action=modedit&mod=newsarchive&moduleaction=add&cp={$sess}" method="post" onSubmit="return check_name();">
  <table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
    <tr>
      <td class="tableheader">{#ARCHIVE_NAME#}</td>
    </tr>

    <tr>
      <td class="second">
        <input name="new_arc" type="text" id="new_arc" size="60" />  <input name="submit" type="submit" class="button" value="{#ARCHIVE_BUTTON_ADD#}" />
      </td>
    </tr>
  </table>
</form>
