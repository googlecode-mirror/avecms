<div class="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_module">&nbsp;</div>
	<div class="HeaderTitle"><h2>{#ModName#}</h2></div>
	<div class="HeaderText">&nbsp;</div>
</div>
<br />
{include file="$source/shop_topnav.tpl"}
<h4>{#VariantsCats#}</h4>
<form action="index.php?do=modules&action=modedit&mod=shop&moduleaction=variants_categories&cp={$sess}&sub=save" method="post">
<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
  <tr>
    <td width="160" class="tableheader">{#CatName#}</td>
    <td class="tableheader">{#CatIn#}</td>
    <td class="tableheader">{#CategActive#} </td>
	<td class="tableheader">&nbsp;</td>
    </tr>
  {foreach from=$variantCateg item=ss}
  <tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
    <td><input style="width:160px" type="text" name="Name[{$ss->Id}]" value="{$ss->Name|stripslashes}"></td>
    <td width="100">
<select style="width:160px" name="KatId[{$ss->Id}]">
{foreach from=$ProductCategs item=pc}
<option value="{$pc->Id}" {if $pc->Elter == 0}style="font-weight:bold"{/if} {if $pc->Id==$ss->KatId}selected="selected"{/if}>{$pc->visible_title}</option>
{/foreach}
</select>
	</td>
    <td width="100">
     <input type="radio" name="Aktiv[{$ss->Id}]" value="1" {if $ss->Aktiv=='1'}checked{/if}> {#Yes#}
    <input type="radio" name="Aktiv[{$ss->Id}]" value="0" {if $ss->Aktiv=='0'}checked{/if}> {#No#}	</td>
	<td>
	<a href="javascript:void(0);" onclick="cp_pop('index.php?do=modules&action=modedit&mod=shop&moduleaction=edit_variants_category&cp={$sess}&pop=1&Id={$ss->Id}','800','550','1','shopshipper');">{#EditDescr#}</a>
	|
	<a onclick="return confirm('{#DelCategC#}')" href="index.php?do=modules&action=modedit&mod=shop&moduleaction=delete_variants_category&Id={$ss->Id}">{#DelMethod#}</a>	</td>
    </tr>
  {/foreach}
 </table>
 <br />
 <input type="submit" class="button" value="{#ButtonSave#}">
</form>
<h4>{#VariantsCatsNew#}</h4>
<form method="post" action="index.php?do=modules&action=modedit&mod=shop&moduleaction=new_variants_category&cp={$sess}">
<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
  <tr class="tableheader">
    <td width="200"><strong>{#SShipperName#}</strong></td>
    <td><strong>{#CatIn#}</strong></td>
  </tr>
  <tr>
 <td width="200" class="first">
<input style="width:250px" type="text" name="Name" value="{#SShipperName#}">

 </td>
 <td class="first">
<select style="width:160px" name="KatId">
{foreach from=$ProductCategs item=pc}
<option value="{$pc->Id}" {if $pc->Elter == 0}style="font-weight:bold"{/if} {if $pc->Id==$smarty.post.product_categ}selected="selected"{/if}>{$pc->visible_title}</option>
{/foreach}
</select>
<input type="submit" class="button" value="{#ButtonSave#}" />
 </td>
 </tr>
</table>
</form>