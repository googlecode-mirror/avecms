{strip}
<!-- shop_equal_products.tpl -->
<h3>{#EqualProductsInterest#}</h3>
{foreach from=$equalProducts item=i}


<div class="mod_shop_container_1" >
<div class="grid_2 alpha" >
<a  class="image" href="{$i->Detaillink}" title="{$i->ArtName|truncate:100|stripslashes|escape:html}">
{if $i->BildFehler==1}
<img  src="{$shop_images}no_productimage.gif" alt="{$i->ArtName|truncate:175|stripslashes|escape:html}" />
{else}
<img  src="{if $i->ImgSrc=='FALSE'}modules/shop/thumb.php?file={$i->Bild}&amp;type={$i->Bild_Typ}&amp;x_width={$WidthThumb}{else}{$i->ImgSrc}{/if}" border="0" alt="{$i->ArtName|truncate:175|stripslashes|escape:html}" />
{/if}            
</a>
</div>
<div class="grid_8" >
<h3><a title="{$i->ArtName|truncate:45|stripslashes|escape:html}" href="{$i->Detaillink}">{$i->ArtName|truncate:45|stripslashes|escape:html}</a></h3>

<p>{$i->TextKurz|truncate:350|strip_tags}</p>

<!-- UNITS -->
{if $i->Einheit_Preis}
<p>{$i->Einheit|replace:'.00':''} {$i->Einheit_Art} {#UnitIncluded#} {$i->Einheit_Art_S}: {numFormat val=$i->Einheit_Preis} {$Currency}</p>
{/if}

{if $i->ZeigeNetto==1 && $i->Preis_USt>0}
<p>{#IncludeMwSt#} {numFormat val=$i->Preis_Netto_Out} {$Currency} <!-- {#Netto#} -->+ {#InVatOnce#} {numFormat val=$i->Preis_USt} {$Currency}
{if $i->PreisDiff>0}
<strong>{#PriceYouSave#}</strong> {numFormat val=$i->PreisDiff} {$Currency} ({math equation="p / (x / 100)" x=$i->PreisListe y=$i->Preis p=$i->PreisDiff format="%.0f"} %)
{/if}
</p>
{/if}



<small>
{if $i->Hersteller_Name != ''}
{#Manufacturer#} <a href="{$i->Hersteller_Link}">{$i->Hersteller_Name}</a>&nbsp;•&nbsp;
{/if}
{#ArtNr#} <em>{$i->ArtNr}</em>&nbsp;•&nbsp;
{#Release#} <em>{$i->Erschienen|date_format:$config_vars.DateFormatRelease}</em>
</small>
</div>
<div class="grid_2 omega">
<div class="mod_shop_price_box">
  {if $i->PreisDiff > 0}
  <!-- Стоимсоть подсвечена -->
  <div class="mod_shop_price_new">{numFormat val=$i->Preis} {$Currency}<img src="/templates/ave/modules/shop/shop_scell.gif" width="27" height="27" alt="Старая цена {$i->PreisListe} {$Currency}" /></div>
  {else}
  <!-- Стоимсоть  -->
  <div class="mod_shop_price_big">{numFormat val=$i->Preis} {$Currency}</div>
  {/if}
  <!-- Стоимость в альтернативной валюте -->
  {if $i->PreisW2 && $ZeigeWaehrung2=='1'}<div class="mod_shop_ust">{numFormat val=$i->PreisW2} {$Currency2}</div>{/if}
  
  {if $i->Prozwertung > 0}
  <img   class="shop_stars" src="{$shop_images}{$i->Prozwertung}.gif" alt="{#CommentsVotesCut#}" />
  {else}
  <img   class="shop_stars" src="{$shop_images}nostars.gif" alt="{#CommentsVotesCut#}" />
  {/if}            
  {if $CanOrderHere==1}
  {if $i->Lager < 1}
  <div class="mod_shop_price_alert">{#PreOrderMsgF#}</div><br />
  {else}
  <form method="post" action="{$i->AddToLink}">
  <input name="amount" type="hidden" size="2" maxlength="2" value="1" {if $i->Lager < 1 && $KaufLagerNull != '1'}disabled="disabled"{/if} />
  <input name="product_id" type="hidden" value="{$i->Id}" />
  <input   {if $i->InBasket==1} onclick="alert('{#AllreadyInBasket#}'); return false;"{/if} name="insertinto" type="image" src="{$shop_images}inbasket.gif" /><br />
  <input   onclick="{if $smarty.session.cp_benutzerid<1}alert('{#ToWishlistError#}');return false;{else}document.getElementById('to_wishlist_{$i->Id}').value='1';{/if}" name="insertwishlist" type="image" src="{$shop_images}compare.gif" />
  <input type="hidden" name="wishlist_{$i->Id}" id="to_wishlist_{$i->Id}"  value="" />
  </form>
  {/if}
  {else}
  <a href="{$i->Detaillink}">{#ShowDetails#}</a>
  {/if}
</div>
</div>
<div class="clearfix"></div>
</div>
{if !$smarty.foreach.items.last}<hr />{/if}
{/foreach}
<!-- /shop_equal_products.tpl -->
{/strip}