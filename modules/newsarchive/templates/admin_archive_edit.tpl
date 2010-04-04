<script type="text/javascript" language="JavaScript">

 function check_name() {ldelim}
   if (document.getElementById('arc_name').value == '') {ldelim}
     alert("{#ARCHIVE_ENTER_NAME#}");
     document.getElementById('arc_name').focus();
     return false;
   {rdelim}
   return true;
 {rdelim}

</script>
<div class="pageHeaderTitle" style="padding-top: 7px;">
<div class="h_module"></div>
    <div class="HeaderTitle"><h2>{#ARCHIVE_EDIT#}</h2></div>
    <div class="HeaderText">{#ARCHIVE_EDIT_TIP#}</div>
</div>
<br>
<div class="infobox">
  <a href="index.php?do=modules&action=modedit&mod=newsarchive&moduleaction=1&cp={$sess}">{#ARCHIVE_RETURN#}</a>
</div>
<br>
<form method="post" action="index.php?do=modules&action=modedit&mod=newsarchive&moduleaction=saveedit&cp={$sess}" onSubmit="return check_name();">
  <table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
    <tr class="tableheader">
      <td colspan="2">&nbsp;</td>
    </tr>

    <tr>
      <td class="first" width="20%">{#ARCHIVE_ITEM_NAME#}</td>
      <td class="second"><input name="arc_name" type="text" id="arc_name" value="{$archives->arc_name|escape:html|stripslashes}" size="40"></td>
    </tr>  
    
    <tr>
      <td class="first" width="20%">{#ARCHIVE_RUBS_SELECT#}</td>
      <td class="second">
        <select name="rubs[]" size="8" multiple="multiple" style="width:200px">
          {foreach from=$rubs item=items}
            <option value="{$items->Id}" {if $items->sel}selected="selected"{else}{/if}>{$items->RubrikName|escape:html}</option>
          {/foreach}
        </select>
      </td>
    </tr>  

    <tr>
      <td class="first" width="20%">{#ARCHIVE_SHOW_DAYS#}</td>
      <td class="second">
        <input name="show_days" type="radio" value="1" {if $archives->show_days == 1}checked="checked"{/if}> {#ARCHIVE_YES#}
        <input name="show_days" type="radio" value="0" {if $archives->show_days == 0}checked="checked"{/if}> {#ARCHIVE_NO#}
        </td>
    </tr>

    <tr>
      <td class="first" width="20%">{#ARCHIVE_SHOW_EMPTY#}</td>
      <td class="second">
        <input name="show_empty" type="radio" value="1" {if $archives->show_empty == 1}checked="checked"{/if}> {#ARCHIVE_YES#}
        <input name="show_empty" type="radio" value="0" {if $archives->show_empty == 0}checked="checked"{/if}> {#ARCHIVE_NO#}
        </td>
    </tr>  
 

    <tr>
      <td class="second" colspan="2"><input type="submit" class="button" value="{#ARCHIVE_BUTTON_SAVE#}" /></td>
    </tr>
    <input type="hidden" name="id" value="{$archives->id}" />
    
  </table>
</form>
 