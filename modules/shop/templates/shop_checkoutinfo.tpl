<div id="content">
	<form name="process" method="post" action="index.php">
		<div id="shopcontent">
{*			<script type="text/javascript" src="modules/shop/js/shop.js"></script> *}
			<div class="mod_shop_topnav">
				<a class="mod_shop_navi" href="{$ShopStartLink}">{#PageName#}</a> {#PageSep#} <a class="mod_shop_navi" href="{$ShowBasketLink}">{#ShopBasket#}</a> {#PageSep#} <a href="index.php?module=shop&action=checkout">{#BillingName#}</a> {#PageSep#} {#CheckoutInfoStatus#}
			</div>

			{include file="$mod_dir/shop/templates/shop_bar.tpl"}<br />

			<h2 id="page-heading">{#CheckoutInfoStatus#}</h2>

			{#CheckoutInfoText#}<br />
			<br />

			{if $NoAGB==1}
				<div class="mod_shop_warn">{#ErrorNoAGBText#}</div><br />
			{/if}

			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td width="49%" valign="top" class="mod_shop_basket_header" style="border:1px solid #CCCCCC;"><h3>{#ShippingAdress#}</h3></td>

					<td>&nbsp;&nbsp;</td>

					<td width="49%" valign="top" class="mod_shop_basket_header" style="border:1px solid #CCCCCC;"><h3>{#BillAdress#}</h3></td>
				</tr>

				<tr>
					<td width="49%" valign="top" class="mod_shop_basket_row" style="border:1px solid #CCCCCC;">
						<!-- Адрес доставки заказа -->
						{if $smarty.session.billing_company!=''}<strong>{$smarty.session.billing_company}</strong><br />{/if}
						{if $smarty.session.billing_company_reciever!=''}<em>{$smarty.session.billing_company_reciever}</em><br />{/if}
						{$smarty.session.billing_firstname} {$smarty.session.billing_lastname}<br />
						<br />
						{$smarty.session.billing_street} {$smarty.session.billing_streetnumber}<br />
						{$smarty.session.billing_zip} {$smarty.session.billing_town}<br />
						{$smarty.request.country}
					</td>

					<td>&nbsp;&nbsp;</td>

					<td width="49%" valign="top" class="mod_shop_basket_row" style="border:1px solid #CCCCCC;">
						<!-- Адрес доставки счета -->
						{if $smarty.session.shipping_firstname=='' || $smarty.session.shipping_lastname==''}
							{#SameAsShipping#}
						{else}
							{if $smarty.session.shipping_company!=''}<strong>{$smarty.session.shipping_company}</strong><br />{/if}
							{if $smarty.session.shipping_company_reciever!=''}<em>{$smarty.session.shipping_company_reciever}</em><br />{/if}
							{$smarty.session.shipping_firstname} {$smarty.session.shipping_lastname}<br />
							<br />
							{$smarty.session.shipping_street} {$smarty.session.shipping_streetnumber}<br />
							{$smarty.session.shipping_zip} {$smarty.session.shipping_city}<br />
							{$smarty.request.RLand}<br />
						{/if}
					</td>
				</tr>
			</table><br />

			<!-- Таблица заказанных товаров -->
			<table width="100%" class="mod_shop_basket_table" border="0" cellpadding="0" cellspacing="1">
				<tr>
					<th valign="top" class="mod_shop_basket_header">{#BasketArticles#}</th>
					<th valign="top" class="mod_shop_basket_header">{#BasketAmount#}</th>
					<th valign="top" class="mod_shop_basket_header">{#BasketSummO#}</th>
					<th valign="top" class="mod_shop_basket_header">{#BasketSumm#}</th>
				</tr>

				{foreach from=$BasketItems item=bi}
					<tr>
						<td valign="middle" class="mod_shop_basket_row">
							<a href="{$bi->ProdLink}"><strong>{$bi->ArtName|truncate:100|escape:html}</strong></a>

							<!-- DELIVERY TIME -->
							{if $bi->Versandfertig}
								<div class="mod_shop_timetillshipping">{$bi->Versandfertig}</div>
							{/if}

							<!-- PRODUCT VARIATIONS -->
							{if $bi->Vars}
								<br /><br />
								<strong>{#ProductVars#}</strong><br />
								{foreach from=$bi->Vars item=vars}
									<span class="mod_shop_basket_price">
										<em>{$vars->VarName|stripslashes}</em><br />
										{$vars->Name|stripslashes} {$vars->Operant}{$vars->WertE} {$Currency}
									</span><br />
								{/foreach}
							{/if}
							<!-- PRODUCT VARIATIONS END -->
						</td>
						<td align="center" valign="middle" class="mod_shop_basket_row">{$bi->Anzahl}</td>
						<td align="center" valign="middle" class="mod_shop_basket_row" nowrap="nowrap">{num_format val=$bi->EPreis} {$Currency}</td>
						<td align="center" valign="middle" class="mod_shop_basket_row_price" nowrap="nowrap">{num_format val=$bi->EPreisSumme} {$Currency}</td>
					</tr>
				{/foreach}
			</table><br />
			<!-- /Таблица заказанных товаров -->

			<table width="100%" border="0" cellspacing="0" cellpadding="0" >
				<tr>
					<td align="center" valign="middle" style="border:1px solid #CCCCCC;">
						<!-- Купон на скидку -->
						{if $couponcodes==1}
							{if $smarty.session.CouponCode > 0}
								<div style="padding:0 10px;"><h4>{#CouponcodeOk#}</h4></div><br />
								<input type="hidden" id="coup_del" name="couponcode_del" value="" />
								<input onclick="document.getElementById('coup_del').value='1'" class="absmiddle" type="image" src="{$shop_images}coupon_delete.gif" alt="{#ButtonCouponDelete#}" />
							{else}
								<input class="absmiddle" type="text" name="couponcode" value="{#CouponCodeText#}" onfocus="this.value='';" />
								<input class="absmiddle" type="image" src="{$shop_images}coupon_ok.gif" alt="{#ButtonCouponSend#}" />
							{/if}
						{/if}
						<!-- /Купон на скидку -->
					</td>

					<td>&nbsp;&nbsp;</td>

					<td width="60%" valign="top">
						<!-- Сводная информация о заказе -->
						<table width="100%" border="0" cellspacing="1" cellpadding="3" class="mod_shop_basket_table">
							<tr>
								<td class="mod_shop_basket_row" align="right">{#ShippingMethod#}</td>
								<td width="130" align="right" class="mod_shop_basket_row_right">{$ShipperName|stripslashes}</td>
							</tr>

							<tr>
								<td class="mod_shop_basket_row" align="right">{#BillingMethod#}</td>
								<td width="130" align="right" class="mod_shop_basket_row_right">{$PaymentMethod|stripslashes}</td>
							</tr>

							<tr>
								<td class="mod_shop_basket_row" align="right">{#OrdersSumm#}</td>
								<td width="130" align="right" class="mod_shop_basket_row_right">{num_format val=$smarty.session.Zwisumm} {$Currency}</td>
							</tr>

							{if $smarty.session.CouponCode > 0}
								<tr>
									<td class="mod_shop_basket_row" width="200" align="right">{#Coupon#}</td>
									<td width="130" align="right" class="mod_shop_basket_row_right">-{$smarty.session.CouponCode} %</td>
								</tr>
							{/if}

							{if $smarty.session.Rabatt>0}
								<tr>
									<td class="mod_shop_basket_row" align="right">{#CustomerDiscount#}</td>
									<td width="130" align="right" class="mod_shop_basket_row_right">-{$smarty.session.RabattWert}{* ({num_format val=$smarty.session.Rabatt}) {$Currency}*}</td>
								</tr>
							{/if}

							<tr>
								<td class="mod_shop_basket_row" width="200" align="right">{#Packing#} </td>
								<td width="130" align="right" class="mod_shop_basket_row_right">{num_format val=$smarty.session.ShippingSumm} {$Currency}</td>
							</tr>

							{if $smarty.session.KostenZahlungOut>0}
								<tr>
									<td class="mod_shop_basket_row" width="200" align="right">{#SummBillingMethod#}</td>
									<td width="130" align="right" class="mod_shop_basket_row_right">{$smarty.session.KostenZahlungPM}{$smarty.session.KostenZahlungOut} {$smarty.session.KostenZahlungSymbol}</td>
								</tr>
							{/if}

							<tr>
								<td class="mod_shop_basket_row" align="right">{#SummOverall#}</td>
								<td width="130" align="right" class="mod_shop_basket_row_right">
									<span class="mod_shop_price_big">{num_format val=$PaymentOverall} {$Currency}</span>
									{if $smarty.session.BasketSummW2}
										<br />
										<span class="mod_shop_ust">{num_format val=$PaymentOverall2} {$Currency2}</span>
									{/if}
								</td>
							</tr>

							{if $smarty.session.CouponCode > 0}
								{foreach from=$VatZones item=vz}
									{if $smarty.session.VatInc!='' && in_array($vz->Wert,$smarty.session.VatInc)}
										<tr>
											<td class="mod_shop_basket_row" align="right"> {#IncVat#} {$vz->Wert}%</td>
											<td width="130" class="mod_shop_basket_row_right" align="right">&nbsp;</td>
										</tr>
									{/if}
								{/foreach}
							{else}
								{foreach from=$VatZones item=vz}
									{if $smarty.session.VatInc!='' && in_array($vz->Wert,$smarty.session.VatInc)}
										<tr>
											<td class="mod_shop_basket_row" align="right"> {#IncVat#} {$vz->Wert}%: </td>
											<td width="130" class="mod_shop_basket_row_right" align="right"> {assign var=VatSessionName value=$vz->Wert} {num_format val=$smarty.session.$VatSessionName} {$Currency}</td>
										</tr>
									{/if}
								{/foreach}
							{/if}
						</table>
						<!-- /Сводная информация о заказе -->
					</td>
				</tr>
			</table>

			{if $smarty.session.ShowNoVatInfo==1}
				<div class="mod_shop_warn">{#WarnVatInc#}</div>
			{/if}
			<br />
			<a name="agb"></a>

			<table width="100%" border="0" cellspacing="0" cellpadding="0" >
				<tr>
					<td width="49%" valign="top" class="mod_shop_basket_header" style="border:1px solid #CCCCCC;"><h3>{#AGB#}</h3></td>

					<td>&nbsp;&nbsp;</td>

					<td width="49%" valign="top" class="mod_shop_basket_header" style="border:1px solid #CCCCCC;"><h3>{#MessageTitle#}</h3></td>
				</tr>

				<tr>
					<td width="49%" valign="top" align="center" class="mod_shop_basket_row" style="border:1px solid #CCCCCC;">
						<!-- Лицензионное соглашение -->
						<div class="input" align="left" style="width:97%;height:120px;overflow:auto" name="Agb">{$ShopAgb}</div>
					</td>

					<td>&nbsp;&nbsp;</td>

					<td width="49%" valign="top" align="center" class="mod_shop_basket_row" style="border:1px solid #CCCCCC;">
						<!-- Комментарий к заказу -->
						<textarea class="mod_shop_inputfields" style="width:97%;height:120px;text-align:left" name="Msg">{$smarty.request.Msg|escape:html|stripslashes}</textarea>
					</td>
				</tr>
			</table>

			<div class="mod_shop_payment_table" style="padding:4px">
				<input id="abg_accept" type="checkbox" name="agb_accept" value="1" />&nbsp;
				<label for="abg_accept">{#AcceptAGB#}</label>
			</div>

			<input type="hidden" name="module" value="shop" />
			<input type="hidden" name="action" value="checkout" />
			<input type="hidden" name="sendorder" value="1" />
			<input type="hidden" name="create_account" value="{$smarty.request.create_account}" />
			<input type="hidden" name="zusammenfassung" id="zus" value="1" />
			<input type="hidden" name="PaymentId" value="{$smarty.session.PaymentId}" />
			<input type="hidden" name="ShipperId" value="{$smarty.session.ShipperId}" />
			<input type="hidden" name="billing_zip" value="{$smarty.session.billing_zip}" />
			<input type="hidden" name="country" value="{$smarty.request.country}" />
			<input type="hidden" name="RLand" value="{$smarty.request.RLand}" />
			<input type="image" class="absmiddle" src="{$shop_images}sendorder.gif" />
		</div>
	</form>

	<!-- FOOTER -->
	{$FooterText}
</div>

{if $smarty.request.print!=1}
	<div class="leftnavi">
		{$ShopNavi}
		<div style="clear:both"></div>
		{$Search}
		{$Basket}
		{$UserPanel}
		{$MyOrders}
		{$Topseller}
		{$InfoBox}
	</div>
{/if}

<div style="clear:both"></div>