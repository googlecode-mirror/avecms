<div class="grid_12 tablebox">
{if !$BasketItems}
	<h2 id="page-heading">{#BasketEmpty#}</h2>
{else}
	<h2 id="page-heading">{#ShopBasket#}</h2>
	<form method="post" action="index.php?module=shop&amp;action=showbasket&amp;refresh=1">
		<table>
        <thead>
			<tr>
				<th valign="top">{#BasketPicture#}</th>
				<th valign="top">{#BasketAmount#}</th>
				<th valign="top">{#BasketArticles#}</th>
				<th valign="top">{#BasketSummO#}</th>
				<th valign="top">{#BasketSumm#}</th>
				<th valign="top">{#BasketDel#}</th>
			</tr>
       </thead>
<tfoot>
			<tr class="total">
				<th align="right" valign="middle" colspan="4">{#TempOverall#}</th>
				<td align="left" valign="middle" colspan="2" class="mod_shop_basket_row_right">
					<h3> {num_format val=$smarty.session.BasketOverall} {$Currency}</h3>
					{if $smarty.session.BasketSummW2}
						<span class="mod_shop_ust">{num_format val=$smarty.session.BasketSummW2} {$Currency2}</span>
						<table width="100%" border="0" cellspacing="0" cellpadding="2">
							{foreach from=$VatZones item=vz}
								{if $smarty.session.VatInc!='' && in_array($vz->Wert,$smarty.session.VatInc)}
									<tr>
										<td><div align="right">{#IncludesVatInf#} {$vz->Wert}%:</div></td>
										<td width="120">
											{assign var=VatSessionName value=$vz->Wert}
											<div align="right">{num_format val=$smarty.session.$VatSessionName} {$Currency}</div>
										</td>
									</tr>
								{/if}
							{/foreach}
						</table>
					{/if}
				</td>
			</tr>
</tfoot>
      <tbody>

			{foreach from=$BasketItems item=bi}
				<tr>
					<td align="center" valign="middle" nowrap="nowrap">
						{if $bi->BildFehler==1}
							&nbsp;{* <img src="{$shop_images}no_productimage.gif" alt="" /> *}
						{else}
							<a class="reflect" rel="lightbox" href="modules/shop/uploads/{$bi->Bild}" title="{$bi->ArtName|truncate:100|stripslashes|escape:html}">
								<img src="modules/shop/thumb.php?file={$bi->Bild}&type={$bi->Bild_Typ}&xwidth=50" alt="{$bi->ArtName|truncate:175|stripslashes|escape:html}" border="0" />
							</a>
						{/if}
					</td>
					<td align="center" valign="middle">
						<input class="mod_shop_inputfields" name="amount[{$bi->Id}]" type="text" size="3" maxlength="3" value="{$bi->Anzahl}" />
					</td>
					<td align="left" valign="middle">
						<a href="{$bi->ProdLink}" target="_blank"><strong>{$bi->ArtName|truncate:100|escape:html}</strong></a> - {$bi->Hersteller_Name}<br />
						<small>{#ArtNr#} {$bi->ArtNr}</small>
						<!-- DELIVERY TIME -->
						{if $bi->Versandfertig}
							<div>{$bi->Versandfertig}</div>
						{/if}
						<!-- PRODUCT VARIATIONS -->
						{if $bi->Vars}
							<br /><br />
							<strong>{#ProductVars#}</strong><br />
							{foreach from=$bi->Vars item=vars}
								<span class="mod_shop_basket_price">
									<em>{$vars->VarName|stripslashes}</em><br />
									{$vars->Name|stripslashes} {$vars->Operant} {num_format val=$vars->WertE} {$Currency}
								</span><br />
							{/foreach}
						{/if}
						<!-- PRODUCT VARIATIONS END -->
					</td>
					<td align="center" valign="middle" nowrap="nowrap">
						{num_format val=$bi->EPreis} {$Currency}
						{if $bi->PreisW2 && $ZeigeWaehrung2=='1'}
							<br />
							<span class="mod_shop_ust">{num_format val=$bi->PreisW2} {$Currency2}</span>
						{/if}
					</td>

					<td align="center" valign="middle" class="mod_shop_basket_row_price" nowrap="nowrap">
						{num_format val=$bi->EPreisSumme} {$Currency}
						{if $bi->PreisW2Summ && $ZeigeWaehrung2=='1'}
							<br />
							<span class="mod_shop_ust">{num_format val=$bi->PreisW2Summ} {$Currency2}</span>
						{/if}
					</td>

					<td align="center" valign="middle" class="mod_shop_basket_row_right">
						<input class="absmiddle" name="del_product[{$bi->Id}]" type="checkbox" value="1" />
					</td>
				</tr>
			{/foreach}
</tbody>
		</table>

		<div align="right">
			<input class="absmiddle" type="image" src="{$shop_images}refresh.gif" />&nbsp;
			<a href="{$CheckoutLink}"><img class="absmiddle" src="{$shop_images}checkout.gif" alt="" border="0" /></a>
		</div>
	</form>
{/if}

<!-- FOOTER -->
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
      <h2><a href="#" id="toggle-myordersbox">Мои заказы</a></h2>
      <div class="block" id="myordersbox">{$MyOrders}</div>
    </div>

  <!-- Блок информации -->
    <div class="box">
      <h2><a href="#" id="toggle-shopinfobox">Информация</a></h2>
      <div class="block" id="shopinfobox">{$InfoBox}</div>
    </div>
</div>
{/if}