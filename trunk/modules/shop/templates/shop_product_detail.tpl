<div class="grid_12">
<!-- SHOP - ITEMS -->
{strip}

{if !$row}
	<p>{#ErrorNoProduct#}</p>
{else}

<h2 id="page-heading">{$row->ArtName|stripslashes|escape:html}</h2>




<div class="grid_12 alpha omega">
<div class="grid_8 alpha  mod_shop_table">
<table  border="0" cellspacing="0">

<!-- разделы -->
<tr>
	<td class="tdleft">{#ShopRazdel#}:</td>
	<td>{include file="$mod_dir/shop/templates/shop_topnav.tpl"}</td>
</tr>

<!-- если новая цена -->
{if $row->PreisDiff > 0}
	<tr>
		<td class="tdleft">
		{* {#PriceListS#}&nbsp;*}
		</td>
		<td><strong style="text-decoration:line-through">{numFormat val=$row->PreisListe} {$Currency}</strong></td>
	</tr>
	<tr>
		<td  class="tdleft"><strong>{#PriceYouSave#}</strong></td>
		<td>{numFormat val=$row->PreisDiff} {$Currency} ({math equation="p / (x / 100)" x=$row->PreisListe y=$row->Preis p=$row->PreisDiff format="%.0f"} %)</td>
	</tr>
{/if}

<!-- основная цена -->
<tr>
	<td class="tdleft">{#OurPrice#}</td>
	<td><div class="mod_shop_price_big"> {numFormat val=$row->Preis} {$Currency}</div> </td>
</tr>

<!-- цена в другой валюте -->
{if $row->PreisW2 && $ZeigeWaehrung2=='1'}
	<tr>
		<td  class="tdleft">{#OurPrice#} в {$Currency2}</td>
		<td>{numFormat val=$row->PreisW2} {$Currency2}</td>
	</tr>
{/if}

<!-- Стоимость за 1 -->
{if $row->Einheit_Preis}
	<tr>
		<td  class="tdleft">{$row->Einheit|replace:'.00':''} {$row->Einheit_Art} {#UnitIncluded#} {$row->Einheit_Art_S}:</td>
		<td>{numFormat val=$row->Einheit_Preis} {$Currency}</td>
	</tr>
{/if}

<!-- Стоимость с НДС -->
{if $row->ZeigeNetto==1  && $row->Preis_USt>0 && $row->NettoAnzeigen==1}
	<tr>
		<td  class="tdleft">{#IncludeMwSt#}</td>
		<td>{numFormat val=$row->Preis_USt} {$Currency} {#InVatOnce#} / {numFormat val=$row->Preis_Netto_Out} {$Currency} netto</td>
	</tr>
{/if}

<!-- цена оптовикам -->
{if $StPrices}
	<tr>
		<td  class="tdleft">{#StPrices#}:</td>
		<td>
				<div class="tablebox"><table >
					<tr>
						<th>{#AnzPr#}</th>
						<th>{#StPrice#}</th>
					</tr>
					{foreach from=$StPrices name=staffel item=sp}
						<tr>
							<td>{$sp->StkVon} - {if !$smarty.foreach.staffel.last}{$sp->StkBis}{else}?{/if}</td>
							<td>{numFormat val=$sp->Preis} {$Currency}</td>
						</tr>
					{/foreach}
				</table></div>
		</td>
	</tr>
{/if}


<!-- форма покупки товара..... старт -->
{if $row->Lager < 1 }

<!-- наличие -->
<tr>
<td  class="tdleft">Наличие</td>
<td>
<div class="mod_shop_preorder_warn">{#PreOrderMsgF#}</div>
</td>
</tr>

        {else}
        <form method="post" action="{$row->AddToLink}">

        <!-- варианты товара старт -->
        {if $Variants}
        <tr>
        <td  class="tdleft">{#ProductVars#}</td>
        <td>
                <table cellpadding="1" cellspacing="0" border="0">
                {foreach from=$Variants item=vars}
                <tr>
                <td>{$vars->VarName}&nbsp;&nbsp;</td>
                <td>
                <select class="mod_shop_inputfields" name="product_vars[]">
                <option value="0"></option>
                {foreach from=$vars->VarItems item=vi}
                <option value="{$vi->Id}">{$vi->Name} ({$vi->Operant}{numFormat val=$vi->Wert} {$Currency})</option>
                {/foreach}
                </select>
                <input title="{$vars->Beschreibung|default:'-'}" type="button" class="button" value="?" style="margin-left:2px" />
                </td>
                </tr>
                {/foreach}
                </table>
        </td>
        </tr>
        {/if}


        <!-- кнопки покупки и сравнения -->
        <tr>
        <td  class="tdleft">{#PreOrderMsgY#}:</td>
        <td>

<input class="mod_shop_inputfields" name="amount" type="hidden" size="4" maxlength="2" value="1" {if $row->Lager < 1 && $KaufLagerNull != '1'}disabled="disabled"{/if} />
<input name="product_id" type="hidden" value="{$row->Id}" />
<input {if $row->InBasket==1} onclick="alert('{#AllreadyInBasket#}'); return false;"{/if} class="absmiddle"  name="insertinto" type="image" src="{$shop_images}inbasket.gif" />
{if $WishListActive==1}
<input onclick="{if $smarty.session.cp_benutzerid<1}alert('{#ToWishlistError#}');return false;{else}document.getElementById('to_wishlist_{$row->Id}').value='1';{/if}" name="insertwishlist" class="absmiddle"   type="image" src="{$shop_images}compare.gif" />
<input type="hidden" name="wishlist_{$row->Id}" id="to_wishlist_{$row->Id}"  value="" />
{/if}


                    {if $row->MultiImages}
                    {*
                      <br />
                        {foreach from=$row->MultiImages item=mi}

                        <div style="float:left;margin-right:1px">
                        <a href="javascript:void(0);" onclick="window.open('modules/shop/uploads/{$mi->Bild}','x','width=400,height=400,scrollbars=1,resizable=1')"><img class="mod_shop_image " src="modules/shop/thumb.php?file={$mi->Bild}&type={$mi->Endung}" alt="" border="0" /></a>	</div>
                        {/foreach}
                        <div style="clear:both"></div>
                    *}
                    {/if}

        </td>
        </tr>

        </form>
        {/if}
<!-- форма покупки товара..... финиш -->



<!-- производитель -->
{if $row->Hersteller_Name != ''}
	<tr>
		<td  class="tdleft">{#Manufacturer#}</td>
		<td>
			{if $row->Hersteller_Home != ''}
				<a href="{$row->Hersteller_Home}"  target="_blank">
					{if $row->Hersteller_Logo != ''}
						<img src="index.php?thumb={$row->Hersteller_Logo}&height=30" title="{$row->Hersteller_Home}" align="absmiddle" alt="{$row->Hersteller_Name}" border="0" />
					{else}
						{$row->Hersteller_Home}
					{/if}
				</a>&nbsp;&nbsp;<a href="{$row->Hersteller_Link}" title="{#ManufacturerProds#}{$row->Hersteller_Name}">{#ManufacturerProds#}</a>
			{else}
				{if $row->Hersteller_Logo != ''}
					&nbsp;&nbsp;<img src="index.php?thumb={$row->Hersteller_Logo}&y_height=30" alt="{$row->Hersteller_Name}" border="0" />
				{/if}
			{/if}
		</td>
	</tr>
{/if}

<!-- Доставка -->
{if $row->Versandfertig}
<tr>
<td  class="tdleft">{#Shippingmethod#}</td>
<td>{$row->Versandfertig}</td>
</tr>
{/if}

<!-- Артикул -->
<tr>
<td  class="tdleft">{#ArtNr#}</td>
<td>{$row->ArtNr}</td>
</tr>

<!-- Дата начала продажи -->
<tr>
<td  class="tdleft">{#Release#}</td>
<td>{$row->Erschienen|date_format:$config_vars.DateFormatRelease}</td>
</tr>

<!-- Рейтинги -->
<tr>
<td  class="tdleft">{#CommentsVotesCut#}</td>
<td>
{if $rez->Proz<1}{#CommentsNull#}{else}<img class="absmiddle" src="{$shop_images}{$rez->Proz}.gif" alt="" />&nbsp;&nbsp;—&nbsp;&nbsp;{/if}{#CommentsCount#}&nbsp; 
<a href="#rezNew">{$rez->Anz}</a>
</td>
</tr>
</table>
</div>
<div class="grid_4 omega">

<!-- Картинки товара -->
<div class="mod_shop_img_box" id="photos">
	{if $row->BildFehler!=1}
		<a  class="image"href="modules/shop/uploads/{$row->Bild}" title="{$row->ArtName|truncate:100|stripslashes|escape:html}"><img style="float:left;" src="modules/shop/uploads/{$row->Bild}" border="0" width="200" alt="{$row->ArtName|truncate:175|stripslashes|escape:html}" /></a>
	{/if}
	{if $row->MultiImages}
		<div>
			{foreach from=$row->MultiImages item=mi}
				<a class="image" href="modules/shop/uploads/{$mi->Bild}" title="{$row->ArtName|truncate:100|stripslashes|escape:html}"><img  src="modules/shop/thumb.php?file={$mi->Bild}&amp;type={$mi->endung}&amp;x_width=55"  alt="{$row->ArtName|truncate:175|stripslashes|escape:html}" /></a>
			{/foreach}
		</div>
	{/if}
</div>
</div>
<div class="clear"></div>
</div>
<!-- Описание товара и еще 5 характеристик -->
<div class="clearfix"></div>
<div class="tab-container">
    <div class="tab-header">
      <div class="tab-handle">{#Description#}</div>
      {if $row->Frei_Titel_1!=''}<div class="tab-handle">{$row->Frei_Titel_1}</div>{/if}
      {if $row->Frei_Titel_2!=''}<div class="tab-handle">{$row->Frei_Titel_2}</div>{/if}
      {if $row->Frei_Titel_3!=''}<div class="tab-handle">{$row->Frei_Titel_3}</div>{/if}
      {if $row->Frei_Titel_4!=''}<div class="tab-handle">{$row->Frei_Titel_4}</div>{/if}
    </div>
    <div class="tab-body">
    
      <div class="tab-body-element">
        <h3>{#Description#}</h3>
        <div class="mod_shop_newprod_box">
          {$row->TextLang|stripslashes}
        </div>
      </div>
      {if $row->Frei_Titel_1!=''}
      <div class="tab-body-element">
        <h3>{$row->Frei_Titel_1}</h3>
        <div class="mod_shop_newprod_box">
          {$row->Frei_Text_1|stripslashes}
        </div>
      </div>
      {/if}
      {if $row->Frei_Titel_2!=''}
      <div class="tab-body-element">
        <h3>{$row->Frei_Titel_2}</h3>
        <div class="mod_shop_newprod_box">
          {$row->Frei_Text_2|stripslashes}
        </div>
      </div>
      {/if}
      {if $row->Frei_Titel_3!=''}
      <div class="tab-body-element">
        <h3>{$row->Frei_Titel_3}</h3>
        <div class="mod_shop_newprod_box">
          {$row->Frei_Text_3|stripslashes}
        </div>
      </div>
      {/if}
      {if $row->Frei_Titel_4!=''}
      <div class="tab-body-element">
        <h3>{$row->Frei_Titel_4}</h3>
        <div class="mod_shop_newprod_box">
          {$row->Frei_Text_4|stripslashes}
        </div>
      </div>
      {/if}
    </div>
</div>
<div class="clearfix"></div>

<!-- Аналогичные продукты -->
{if $equalProducts}
{include file="$mod_dir/shop/templates/shop_equal_products.tpl"}
{/if}

<!-- форма отправки рецензии-->
{if $AllowComments}
<a name="rezNew"></a><h3>{#ArticleComments#}</h3>
{if $CanComment==1}
<div>
<div class="mod_faq_quest" onclick="show_hide_text(this,'{#CommentWrite#}')">{#CommentWrite#}</div>
<div style="display: none">
{if $CanComment==1}

<form onsubmit="return confirm_comment();" method="post" action="index.php?sendcomment=1&amp;module=shop&amp;action=product_detail&amp;product_id={$smarty.request.product_id}&amp;categ={$smarty.request.categ}&amp;navop={$smarty.request.navop}">
{if $smarty.session.cp_uname}
<input value="{$smarty.session.cp_uname}" id="l_ATitel" type="hidden" name="ATitel">
{else}
<fieldset>
<legend><label for="l_ATitel">{#CommentTitle#}</label></legend>
<input style="width:97%" id="l_ATitel" type="text" name="ATitel">
</fieldset>
{/if}
<fieldset>
<legend><label for="l_AKommentar">{#CommentC#}</label></legend>
<textarea style="width:97%;height:100px"  id="l_AKommentar" name="AKommentar"></textarea>
</fieldset>
<fieldset>
<legend><label for="l_AWertung">{#CommentVoteInf#}</label></legend>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:0;">
  <tr>
    <td align="center"><img class="absmiddle" src="{$shop_images}1.gif" alt="" /></td>
    <td align="center"><img class="absmiddle" src="{$shop_images}2.gif" alt="" /></td>
    <td align="center"><img class="absmiddle" src="{$shop_images}3.gif" alt="" /></td>
    <td align="center"><img class="absmiddle" src="{$shop_images}4.gif" alt="" /></td>
    <td align="center"><img class="absmiddle" src="{$shop_images}5.gif" alt="" /></td>
</tr>
  <tr>
<td align="center">
  <input name="AWertung" type="radio" value="1" /></td>
    <td align="center">
      <input name="AWertung" type="radio" value="2" /></td>
    <td align="center">
      <input name="AWertung" type="radio" value="3" checked="checked" /></td>
    <td align="center">
      <input name="AWertung" type="radio" value="4" /></td>
    <td align="center">
      <input name="AWertung" type="radio" value="5" /></td>
</tr>
</table>
</fieldset>
<input type="submit" class="button" value="{#ArticleSendComment#}">
</form><br />
{/if}</div>
</div>
{/if}

<!-- сами рецензии-->
{foreach from=$Comments item=c}
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="mod_comment_box">
<tr>
<td class="mod_comment_header">{$c->Datum|date_format:$config_vars.DateFormatRelease} оставил рецензию {$c->Titel|stripslashes} </td>
</tr>
<tr>
<td class="mod_comment_text">
{$c->Kommentar|stripslashes}
</td>
</tr>
</table>
{/foreach}
{/if}
{/if}
{/strip}

<script language="javascript">
function confirm_comment()
{ldelim}
	if(document.getElementById('l_ATitel').value == '')
	{ldelim}
		alert('{#ConfirmEnoTitle#}');
		document.getElementById('l_ATitel').focus();
		return false;
	{rdelim}

	if(document.getElementById('l_AKommentar').value == '')
	{ldelim}
		alert('{#ConfirmEnoText#}');
		document.getElementById('l_AKommentar').focus();
		return false;
	{rdelim}

	if(confirm('{#ConfirmComment#}')) return true;
	return false;
{rdelim}
</script>
<hr/>
<!-- FOOTER -->
 {$FooterText}
</div>
 {if $smarty.request.print!=1}
<div class="grid_4">
 <!-- Правое меню -->
    <div class="box menu">
      <h2><a href="#" id="toggle-section-menu">Каталог товаров</a></h2>
      <div class="block" id="section-menu">{$ShopNavi}</div>
    </div>

  <!-- Блок авторизации -->
    <div class="box">
      <h2> <a href="#" id="toggle-login-forms">Авторизация</a> </h2>
      <div class="block" id="login-forms">{$UserPanel}</div>
    </div>
    
  <!-- Блок поиска по магазину -->
    <div class="box">
      <h2><a href="#" id="toggle-shop-search">Поиск товаров</a></h2>
      <div class="block" id="shop-search">{$Search}</div>
    </div>
    
  <!-- Блок корзины -->
    <div class="box">
      <h2><a href="#" id="toggle-shopbasket">Корзина</a></h2>
      <div class="block" id="shopbasket">{$Basket}</div>
    </div>

  <!-- Блок обработанных заказов -->
    <div class="box">
      <h2><a href="#" id="toggle-shopbasket">Мои заказы</a></h2>
      <div class="block" id="shopbasket">{$MyOrders}</div>
    </div>

  <!-- Блок информации -->
    <div class="box">
      <h2><a href="#" id="toggle-popcommentors">Информация</a></h2>
      <div class="block" id="popcommentors">{$InfoBox}</div>
    </div>
</div>
{/if}
