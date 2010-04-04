<div class="pageHeaderTitle" style="padding-top: 7px;">
<div class="h_module"></div>
    <div class="HeaderTitle"><h2>{#Modulname#}</h2></div>
    <div class="HeaderText">&nbsp;</div>
</div>
<br>
<div class="infobox"><a href="index.php?do=modules&action=modedit&mod=userpage&moduleaction=1&cp={$sess}">{#Config_Fields#}</a> | <a href="index.php?do=modules&action=modedit&mod=userpage&moduleaction=tpl&cp={$sess}">{#Template#}</a> | <strong>{#Update#}</strong></a></div></div>
<br>
<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
 <tr>
  <td class="tableheader">{#Forum_Update#}</td>
 </tr>
 <tr class="first">
 <td>
{if $smarty.request.ok == 1}
<h2>{#Update_ok#}</h2>
<br />
{/if}

<div class="infobox">
{if $error != 0}

<strong>Fehlermeldungen:</strong><br />
{foreach from=$error item=i}
{$i} {#Update_error#} <br />
{/foreach}

 </div>
 </td>
 </tr>
 <tr class="second">
 <td style="padding:0px">
 {#Update_error_info#}
 </td>
 </tr>
 </table>

{else}

<strong>{#Update_info#}</strong><br />
{foreach from=$files item=i}
{$i}<br />
{/foreach}

 </div>
 </td>
 </tr>
 <tr class="first">
 <td>
 {#Update_info2#}
 </td>
 </tr>
  <tr class="second">
 <td>
 <form method="post" action="{$formaction}">
 <input class="button" type="submit" value="{#Button_update#}">
 </form>
 </td>
 </tr>
 </table>

{/if}
