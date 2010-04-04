<script type="text/javascript" language="JavaScript">

 function check_name() {ldelim}
   if (document.getElementById('new_faq').value == '') {ldelim}
     alert("{#faq_ENTER_NAME#}");
     document.getElementById('new_faq').focus();
     return false;
   {rdelim}
   return true;
 {rdelim}

</script>


<div class="pageHeaderTitle" style="padding-top: 7px;">
<div class="h_module"></div>
    <div class="HeaderTitle"><h2>{#faq_LIST#}</h2></div>
    <div class="HeaderText">{#faq_LIST_TIP#}</div>
</div><br>

{if $faq}
<form method="post" action="index.php?do=modules&action=modedit&mod=faq&moduleaction=savelist&cp={$sess}">
  <table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
    <tr class="tableheader">
      <td>{#faq_NAME#}</td>
 	  <td>{#faq_DESC#}</td>
      <td width="100">{#faq_TAG#}</td>
      <td width="1%" colspan="2">{#faq_ACTIONS#}</td>
    </tr>
    {foreach from=$faq item=item}
  <tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
      <td>
        <input name="faq_name[{$item->id}]" type="text" id="faq_name[{$item->id}]" value="{$item->faq_name|escape:html|stripslashes}" size="40" />
      </td>
      <td>
        <input name="description[{$item->id}]" type="text" id="description[{$item->id}]" value="{$item->description|escape:html|stripslashes}" size="40" />
      </td>

      <td width="100"><input name="textfield" type="text" value="[mod_faq:{$item->id}]" readonly /></td>
      <td align="center">
        <a title="{#faq_EDIT_HINT#}" href="index.php?do=modules&action=modedit&mod=faq&moduleaction=edit&cp={$sess}&id={$item->id}">
        <img src="{$tpl_dir}/images/icon_edit.gif" alt="" border="0" /></a>
      </td>
      <td align="center">
        <a title="{#faq_DELETE_HINT#}" href="index.php?do=modules&action=modedit&mod=faq&moduleaction=del&cp={$sess}&id={$item->id}">
        <img src="{$tpl_dir}/images/icon_del.gif" alt="" border="0" />
      </td>
    </tr>
    {/foreach}

  </table>
<br /><input type="submit" class="button" value="{#faq_BUTTON_SAVE#}" />
</form>
{else}
<h4 style="color: #800000">{#faq_NO_ITEMS#}</h4>
{/if}



<h4>{#faq_ADD#}</h4>

<form action="index.php?do=modules&action=modedit&mod=faq&moduleaction=add&cp={$sess}" method="post" onSubmit="return check_name();">
  <table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
    <tr>
      <td class="tableheader">{#faq_NAME#}</td>
    </tr>

    <tr>
      <td class="second">
        <input name="new_faq" type="text" id="new_faq" size="60" />
      </td>
    </tr>
<tr>
      <td class="tableheader">{#faq_DESC#}</td>
    </tr>

    <tr>
      <td class="second">
        <input name="new_faq_desc" type="text" id="new_faq_desc" size="60" />
      </td>
    </tr>
    <tr>
      <td class="first">
        <input name="submit" type="submit" class="button" value="{#faq_BUTTON_ADD#}" />
      </td>
    </tr>
  </table>
</form>
