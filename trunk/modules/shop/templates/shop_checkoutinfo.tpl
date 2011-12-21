
<div class="grid_12">
{*
	<script type="text/javascript" src="modules/shop/js/shop.js"></script>
	<div class="mod_shop_topnav">
		<a class="mod_shop_navi" href="{$ShopStartLink}">{#PageName#}</a> {#PageSep#} <a class="mod_shop_navi" href="{$ShopBasketLink}">{#ShopBasket#}</a> {#PageSep#} <a href="{$ShopCheckoutLink}">{#BillingName#}</a> {#PageSep#} {#CheckoutInfoStatus#}
	</div>
*}
	<h2 id="page-heading">{#CheckoutInfoStatus#}</h2>

	{include file="$mod_dir/shop/templates/shop_bar.tpl"}<br />

	{#CheckoutInfoText#}<br />
	<br />

	{if $NoAGB==1}
		<div class="mod_shop_warn">{#ErrorNoAGBText#}</div><br />
	{/if}

	<div class="grid_6 alpha tablebox">
		<table width="100%">
			<thead>
				<tr>
					<th class="table-head">{#ShippingAdress#}</th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td valign="top" height="150">
						<!-- Адрес доставки заказа -->
						{if $smarty.session.billing_company!=''}<strong>{$smarty.session.billing_company}</strong><br />{/if}
						{if $smarty.session.billing_company_reciever!=''}<em>{$smarty.session.billing_company_reciever}</em><br />{/if}
						{$smarty.session.billing_firstname} {$smarty.session.billing_lastname}<br />
						<br />
						{$smarty.session.billing_street} {$smarty.session.billing_streetnumber}<br />
						{$smarty.session.billing_zip} {$smarty.session.billing_town}<br />
						{$smarty.request.country}
					</td>
				</tr>
			</tbody>
		</table>
	</div>

	<div class="grid_6 omega tablebox">
		<table width="100%">
			<thead>
				<tr>
					<th class="table-head">{#BillAdress#}</th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td valign="top" height="150">
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
			</tbody>
		</table>
	</div>
	<div class="clear"></div>

	<div class="grid_12 alpha omega tablebox">
		<!-- Таблица заказанных товаров -->
		<table width="100%" border="1">
			<colgroup>
				<col>
				<col width="100">
				<col width="100">
				<col width="100">
			</colgroup>
			<thead>
				<tr>
					<th colspan="4" class="table-head">{#ProductOrdersSInf#}</th>
				</tr>
				<tr>
					<th align="left">{#BasketArticles#}</th>
					<th>{#BasketAmount#}</th>
					<th>{#BasketSummO#}</th>
					<th>{#BasketSumm#}</th>
				</tr>
			</thead>

			<tbody>
				{foreach from=$BasketItems item=bi}
					{cycle values='<tr class="odd">,<tr>'}
						<td>
							<a href="{$bi->ProdLink}"><strong>{$bi->ArtName|truncate:100|escape:html}</strong></a>

							{if $bi->Versandfertig}
								<!-- DELIVERY TIME -->
								<div class="mod_shop_timetillshipping">{$bi->Versandfertig}</div>
							{/if}

							{if $bi->Vars}
								<!-- PRODUCT VARIATIONS -->
								<br /><br />
								<strong>{#ProductVars#}</strong><br />
								{foreach from=$bi->Vars item=vars}
									<span class="mod_shop_basket_price">
										<em>{$vars->VarName|stripslashes}</em><br />
										{$vars->Name|stripslashes} {$vars->Operant}{$vars->WertE} {$Currency}
									</span><br />
								{/foreach}
							{/if}
						</td>
						<td align="center">{$bi->Anzahl}</td>
						<td align="right">{num_format val=$bi->EPreis} {$Currency}</td>
						<td align="right">{num_format val=$bi->EPreisSumme} {$Currency}</td>
					</tr>
				{/foreach}
			</tbody>
		</table>
		<!-- /Таблица заказанных товаров -->
	</div>
	<div class="clear"></div>

	<form name="process" method="post" action="index.php?module=shop&action=checkout">
		<div class="grid_4 alpha tablebox">
			<table width="100%">
				<tr>
					<td align="center" valign="middle" height="161">
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
				</tr>
			</table>
		</div>

		<div class="grid_8 omega tablebox">
			<!-- Сводная информация о заказе -->
			<table width="100%">
				{cycle values='<tr class="odd">,<tr>'}
					<td>{#ShippingMethod#}</td>
					<td>{$ShipperName|stripslashes}</td>
				</tr>

				{cycle values='<tr class="odd">,<tr>'}
					<td>{#BillingMethod#}</td>
					<td>{$PaymentMethod|stripslashes}</td>
				</tr>

				{cycle values='<tr class="odd">,<tr>'}
					<td>{#OrdersSumm#}</td>
					<td>{num_format val=$smarty.session.Zwisumm} {$Currency}</td>
				</tr>

				{if $smarty.session.CouponCode > 0}
					{cycle values='<tr class="odd">,<tr>'}
						<td>{#Coupon#}</td>
						<td>-{$smarty.session.CouponCode} %</td>
					</tr>
				{/if}

				{if $smarty.session.Rabatt>0}
					{cycle values='<tr class="odd">,<tr>'}
						<td>{#CustomerDiscount#}</td>
						<td>-{$smarty.session.RabattWert}{* ({num_format val=$smarty.session.Rabatt}) {$Currency}*}</td>
					</tr>
				{/if}

				{cycle values='<tr class="odd">,<tr>'}
					<td>{#Packing#}</td>
					<td>{num_format val=$smarty.session.ShippingSumm} {$Currency}</td>
				</tr>

				{if $smarty.session.KostenZahlungOut>0}
					{cycle values='<tr class="odd">,<tr>'}
						<td>{#SummBillingMethod#}</td>
						<td>{$smarty.session.KostenZahlungPM}{$smarty.session.KostenZahlungOut} {$smarty.session.KostenZahlungSymbol}</td>
					</tr>
				{/if}

				{cycle values='<tr class="odd">,<tr>'}
					<td>{#SummOverall#}</td>
					<td>
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
							{cycle values='<tr class="odd">,<tr>'}
								<td>{#IncVat#} {$vz->Wert}%</td>
								<td>&nbsp;</td>
							</tr>
						{/if}
					{/foreach}
				{else}
					{foreach from=$VatZones item=vz}
						{if $smarty.session.VatInc!='' && in_array($vz->Wert,$smarty.session.VatInc)}
							{cycle values='<tr class="odd">,<tr>'}
								<td>{#IncVat#} {$vz->Wert}%:</td>
								<td>{assign var=VatSessionName value=$vz->Wert} {num_format val=$smarty.session.$VatSessionName} {$Currency}</td>
							</tr>
						{/if}
					{/foreach}
				{/if}
			</table>
			<!-- /Сводная информация о заказе -->
		</div>
		<div class="clear"></div>

		{if $smarty.session.ShowNoVatInfo==1}
			<div class="mod_shop_warn">{#WarnVatInc#}</div><br />
		{/if}

		<div class="grid_6 alpha tablebox">
			<table width="100%">
				<thead>
					<tr>
						<th class="table-head">{#AGB#}</th>
					</tr>
				</thead>

				<tbody>
					<tr>
						<td>
							<!-- Лицензионное соглашение -->
							<div class="input" style="width:98%;height:120px;overflow:auto" name="Agb">{$ShopAgb}</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="grid_6 omega tablebox">
			<table width="100%">
				<thead>
					<tr>
						<th class="table-head">{#MessageTitle#}</th>
					</tr>
				</thead>

				<tbody>
					<tr>
						<td>
							<!-- Комментарий к заказу -->
							<textarea class="mod_shop_inputfields" style="width:98%;height:120px" name="Msg">{$smarty.request.Msg|escape:html|stripslashes}</textarea>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="clear"></div>

		<div id="agb" class="mod_shop_payment_table" style="padding:4px">
			<input id="abg_accept" type="checkbox" name="agb_accept" value="1" />&nbsp;
			<label for="abg_accept">{#AcceptAGB#}</label>
		</div>

{*		<input type="hidden" name="module" value="shop" />
		<input type="hidden" name="action" value="checkout" />
*}		<input type="hidden" name="sendorder" value="1" />
		<input type="hidden" name="create_account" value="{$smarty.request.create_account}" />
		<input type="hidden" name="zusammenfassung" id="zus" value="1" />
		<input type="hidden" name="PaymentId" value="{$smarty.session.PaymentId}" />
		<input type="hidden" name="ShipperId" value="{$smarty.session.ShipperId}" />
		<input type="hidden" name="billing_zip" value="{$smarty.session.billing_zip}" />
		<input type="hidden" name="country" value="{$smarty.request.country}" />
		<input type="hidden" name="RLand" value="{$smarty.request.RLand}" />
		<input type="image" class="absmiddle" src="{$shop_images}sendorder.gif" />
	</form>

	<!-- FOOTER -->
	{$FooterText}
</div>

{if $smarty.request.print!=1}
	<div class="grid_4">
		<!-- Правое меню -->
		<div class="box menu">
			<h2><a href="#" id="toggle-section-menu">{#ProductOverview#}</a></h2>
			<div class="block" id="section-menu">{$ShopNavi}</div>
		</div>

		<!-- Блок авторизации -->
		<div class="box">
			<h2> <a href="#" id="toggle-login-forms">{#UserPanel#}</a> </h2>
			<div class="block" id="login-forms">{$UserPanel}</div>
		</div>

		<!-- Блок поиска по магазину -->
		<div class="box">
			<h2><a href="#" id="toggle-shop-search">{#ProductSearch#}</a></h2>
			<div class="block" id="shop-search">{$Search}</div>
		</div>

		<!-- Блок корзины -->
		<div class="box">
			<h2><a href="#" id="toggle-shopbasket">{#ShopBasket#}</a></h2>
			<div class="block" id="shopbasket">{$Basket}</div>
		</div>

		{if $smarty.session.user_id}
			<!-- Блок обработанных заказов -->
			<div class="box">
				<h2><a href="#" id="toggle-myordersbox">{#MyOrders#}</a></h2>
				<div class="block" id="myordersbox">{$MyOrders}</div>
			</div>
		{/if}

		<!-- Блок информации -->
		<div class="box">
			<h2><a href="#" id="toggle-shopinfobox">{#Infopage#}</a></h2>
			<div class="block" id="shopinfobox">{$InfoBox}</div>
		</div>

		<!-- Блок популярных товаров -->
		<div class="box">
			<h2><a href="#" id="toggle-shoppopprods">{#Topseller#}</a></h2>
			<div class="block" id="shoppopprods">{$Topseller}</div>
		</div>
	</div>
{/if}
