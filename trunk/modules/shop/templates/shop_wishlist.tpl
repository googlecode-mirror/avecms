
<link href="templates/{$theme_folder}/css/style.css" rel="stylesheet" type="text/css" />
{if $WishListActive==1}
	<div style="padding: 20px">
		<div class="mod_shop_topnav"><a class="mod_shop_navi" href="{$ShopStartLink}">{#PageName#}</a> {#PageSep#} {#Wishlist#} </div>
		<h2 id="page-heading">Ваши закладки</h2><br />
		{#WishlistInf#}<br />
		<br />

		{if !$MyWishlist}
			<strong>{#WishlistEmpty#}</strong>
		{else}
			<form method="post" action="index.php?module=shop&amp;action=wishlist&amp;refresh=1">
				<table border="0" cellpadding="5" cellspacing="1" class="mod_shop_basket_table">
					<tr>
						{foreach from=$MyWishlist item=bi}
							<td class="mod_shop_basket_row mod_shop_wishlist_td "><a href="{$bi->ProdLink}" target="_blank"><strong>{$bi->ArtName|truncate:100|escape:html}</strong></a> </td>
						{/foreach}
					</tr>

					<tr>
						{foreach from=$MyWishlist item=bi}
							<td class="mod_shop_basket_row_price mod_shop_wishlist_td ">
								Цена: {num_format val=$bi->EPreis} {$Currency}
							</td>
						{/foreach}
					</tr>

					<tr>
						{foreach from=$MyWishlist item=bi}
							<td class="mod_shop_basket_row mod_shop_wishlist_td ">
								<table border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td>
											Количество: <input class="inputbox" name="amount[{$bi->Id}]" type="text" size="3" maxlength="3" value="{$bi->Anzahl}" />
										</td>

										<td>
											&nbsp;-&nbsp;на сумму: <strong>{num_format val=$bi->EPreisSumme} </strong>{$Currency}
											{if $bi->PreisW2Summ && $ZeigeWaehrung2=='1'}
												<br />
												<span class="mod_shop_ust">{num_format val=$bi->PreisW2Summ} {$Currency2}</span>
											{/if}
										</td>
									</tr>

									<tr>
										<td>
											Удалить <input name="del_product[{$bi->Id}]" type="checkbox" value="1" />
										</td>
										<td>
											<input class="absmiddle" type="image" src="templates/{$theme_folder}/modules/shop/refresh.gif" />&nbsp;
											<a class="popup" href="index.php?add=1&amp;module=shop&amp;action=addtobasket&amp;product_id={$bi->Id}&amp;amount={$bi->Anzahl}{if $v}&amp;vars={$v}{/if}&amp;vars={foreach from=$bi->Vars name=v item=vars}{$vars->Id}{if !$smarty.foreach.v.last},{/if}{/foreach}"><img class="absmiddle" src="templates/{$theme_folder}/modules/shop/buynow.gif" alt="" border="0" /><span>{#AddToBasket#}</span></a>
										</td>
									</tr>
								</table>
							</td>
						{/foreach}
					</tr>

					<tr>
						{foreach from=$MyWishlist item=bi}
							<td class="mod_shop_basket_row mod_shop_wishlist_td ">
								{if $bi->BildFehler==1}
									&nbsp;{* <img src="{$shop_images}no_productimage.gif" alt="" /> *}
								{else}
									<a class="reflect" rel="lightbox" href="modules/shop/uploads/{$bi->Bild}" title="{$bi->ArtName|truncate:100|stripslashes|escape:html}"><img src="modules/shop/thumb.php?file={$bi->Bild}&type={$bi->Bild_Typ}&xwidth=50" alt="{$bi->ArtName|truncate:175|stripslashes|escape:html}" border="0" /></a>
								{/if}
							</td>
						{/foreach}
					</tr>

					<tr>
						{foreach from=$MyWishlist item=bi}
							<td class="mod_shop_basket_header mod_shop_wishlist_td ">Описание товара</td>
						{/foreach}
					</tr>

					<tr>
						{foreach from=$MyWishlist item=bi}
							<td class="mod_shop_basket_row mod_shop_wishlist_td " valign="top">{$bi->TextLang|stripslashes}</td>
						{/foreach}
					</tr>

					<tr>
						{foreach from=$MyWishlist item=bi}
							<td class="mod_shop_basket_header mod_shop_wishlist_td ">{$bi->Frei_Titel_1|stripslashes}</td>
						{/foreach}
					</tr>

					<tr>
						{foreach from=$MyWishlist item=bi}
							<td class="mod_shop_basket_row mod_shop_wishlist_td " valign="top">{$bi->Frei_Text_1|stripslashes}</td>
						{/foreach}
					</tr>

					<tr>
						{foreach from=$MyWishlist item=bi}
							<td class="mod_shop_basket_header mod_shop_wishlist_td ">{$bi->Frei_Titel_2|stripslashes}</td>
						{/foreach}
					</tr>

					<tr>
						{foreach from=$MyWishlist item=bi}
							<td class="mod_shop_basket_row mod_shop_wishlist_td " valign="top">{$bi->Frei_Text_2|stripslashes}</td>
						{/foreach}
					</tr>

					<tr>
						{foreach from=$MyWishlist item=bi}
							<td class="mod_shop_basket_header mod_shop_wishlist_td ">{$bi->Frei_Titel_3|stripslashes}</td>
						{/foreach}
					</tr>

					<tr>
						{foreach from=$MyWishlist item=bi}
							<td class="mod_shop_basket_row mod_shop_wishlist_td " valign="top">{$bi->Frei_Text_3|stripslashes}</td>
						{/foreach}
					</tr>

					<tr>
						{foreach from=$MyWishlist item=bi}
							<td class="mod_shop_basket_header mod_shop_wishlist_td ">{$bi->Frei_Titel_4|stripslashes}</td>
						{/foreach}
					</tr>

					<tr>
						{foreach from=$MyWishlist item=bi}
							<td class="mod_shop_basket_row mod_shop_wishlist_td " valign="top">{$bi->Frei_Text_4|stripslashes}</td>
						{/foreach}
					</tr>
				</table>
			{/if}
		</form>
	</div>
{/if}
