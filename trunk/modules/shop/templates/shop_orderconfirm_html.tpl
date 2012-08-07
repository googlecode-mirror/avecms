<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>{$CompanyHeadHtml}</title>
	</head>
{literal}
<style type="text/css">
html, body, td, div, th {font:11px Verdana,Arial,Helvetica,sans-serif;}
.articlesborder {background-color:#ccc;}
.articlesrow {background-color:#fff;}
.articlesheader {background-color:#eee;}
.overall {background-color:#eee;font-size:14px;border-top:1px solid #ccc;}
</style>
{/literal}
<body>

<div id="shopcontent">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td valign="top">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td>{$CompanyHeadHtml}</td>
						<td align="right">{if $CompanyLogo != ''}<img src="{$CompanyLogo}" alt="" border="" />{/if}</td>
					</tr>
				</table>

				<hr noshade="noshade" size="1">

				<h3><strong>{#BillTitle#}</strong></h3>

				{#BillHead#}

				<hr noshade="noshade" size="1">

				<table width="100%">
					<tr>
						<td valign="top">
							<h3><strong>{#ShippingAdress#}</strong></h3>
							{if $smarty.session.billing_company!=''}
								<strong>{$smarty.session.billing_company}</strong><br />
							{/if}
							{if $smarty.session.billing_company_reciever!=''}
								<em>{$smarty.session.billing_company_reciever}</em><br />
							{/if}
							{if $smarty.session.OrderPhone!=''}
								{$smarty.session.OrderPhone}<br />
							{/if}
							{$smarty.session.billing_firstname} {$smarty.session.billing_lastname}<br />
							<br />
							{$smarty.session.billing_street} {$smarty.session.billing_streetnumber}<br />
							{$smarty.session.billing_zip} {$smarty.session.billing_town}<br />
							{$smarty.request.country}<br />
						</td>

						<td valign="top">
							<h3><strong>{#BillAdress#}</strong></h3>
							{if $smarty.session.shipping_firstname=='' || $smarty.session.shipping_lastname==''}
								{#SameAsShipping#}
							{else}
								{if $smarty.session.shipping_company!=''}
									<strong>{$smarty.session.shipping_company}</strong><br />
								{/if}
								{if $smarty.session.shipping_company_reciever!=''}
									<em>{$smarty.session.shipping_company_reciever}</em><br />
								{/if}
								{$smarty.session.shipping_firstname} {$smarty.session.shipping_lastname}<br />
								<br />
								{$smarty.session.shipping_street} {$smarty.session.shipping_streetnumber}<br />
								{$smarty.session.shipping_zip} {$smarty.session.shipping_city}<br />
								{$smarty.request.RLand}<br />
							{/if}
						</td>
					</tr>

					<tr>
						<td valign="top">
							&nbsp;<br />
							<br />
						</td>
						<td valign="top">&nbsp;</td>
					</tr>
				</table>

				<table width="100%" border="0" cellpadding="3" cellspacing="1" class="articlesborder">
					<tr>
						<td valign="top" class="articlesheader"><strong>{#BasketArticles#}</strong></td>
						<td valign="top" class="articlesheader"><strong>{#ArtNumber#}</strong></td>
						<td valign="top" align="right" class="articlesheader"><strong>{#BasketAmount#}</strong></td>
						<td align="right" valign="top" class="articlesheader"><strong>{#BasketSummO#}</strong></td>
						<td align="right" valign="top" class="articlesheader"><strong>{#BasketSumm#}</strong></td>
					</tr>

					{foreach from=$BasketItems item=bi}
						<tr>
							<td valign="top" class="articlesrow"> <strong>{$bi->ArtName|truncate:100|escape:html}</strong>
								<!-- DELIVERY TIME -->
								{if $bi->Versandfertig}
									<div class="mod_shop_timetillshipping">{$bi->Versandfertig}</div>
								{/if}
								<!-- /DELIVERY TIME -->
								<!-- PRODUCT VARIATIONS -->
								{if $bi->Vars}
									<br /><br />
									<small> <strong>{#ProductVars#}</strong><br />
										{foreach from=$bi->Vars item=vars}
											<span class="mod_shop_basket_price">
												<em>{$vars->VarName|stripslashes}</em><br />
												{$vars->Name|stripslashes} {$vars->Operant}{$vars->WertE} {$Currency}
											</span><br />
										{/foreach}
									</small>
								{/if}
								<!-- /PRODUCT VARIATIONS -->
							</td>
							<td valign="top" class="articlesrow">{$bi->ArtNr}</td>
							<td align="center" valign="top" class="articlesrow">{$bi->Anzahl}</td>
							<td align="right" valign="top" class="articlesrow" nowrap="nowrap">{num_format val=$bi->EPreis} {$Currency}</td>
							<td align="right" valign="top" class="articlesrow" nowrap="nowrap">{num_format val=$bi->EPreisSumme} {$Currency}</td>
						</tr>
					{/foreach}
				</table><br />
				<br />

				<table width="100%" border="0" cellspacing="0" cellpadding="1">
					<tr>
						<td>{#OrderNumber#}</td>
						<td class="mod_shop_summlist">{$OrderId}</td>
					</tr>

					<tr>
						<td>{#OrderDate#}</td>
						<td class="mod_shop_summlist">{$OrderTime|date_format:"%d.%m.%Y, %H:%M:%S"}</td>
					</tr>

					<tr>
						<td class="mod_shop_summlist">{#TransCode#}</td>
						<td class="mod_shop_summlist">{$TransCode}</td>
					</tr>

					<tr>
						<td class="mod_shop_summlist">&nbsp;</td>
						<td class="mod_shop_summlist">&nbsp;</td>
					</tr>

					<tr>
						<td width="200">{#ShippingMethod#}</td>
						<td class="mod_shop_summlist">{$ShipperName|stripslashes}</td>
					</tr>

					<tr>
						<td width="200">{#BillingMethod#}</td>
						<td class="mod_shop_summlist">{$PaymentMethod|stripslashes}</td>
					</tr>

					<tr>
						<td width="200" class="mod_shop_summlist">&nbsp;</td>
						<td align="right" class="mod_shop_summlist">&nbsp;</td>
					</tr>

					<tr>
						<td width="200"><strong>{#OrdersSumm#}</strong></td>
						<td class="mod_shop_summlist"><strong>{num_format val=$smarty.session.Zwisumm} {$Currency}</strong></td>
					</tr>

					{if $smarty.session.CouponCode > 0}
						<tr>
							<td width="200">{#Coupon#}</td>
							<td class="mod_shop_summlist">-{$smarty.session.CouponCode} %</td>
						</tr>
					{/if}

					{if $smarty.session.Rabatt>0}
						<tr>
							<td width="200">{#CustomerDiscount#}</td>
							<td class="mod_shop_summlist">-{$smarty.session.RabattWert}{* ({num_format val=$smarty.session.Rabatt}) {$Currency}*}</td>
						</tr>
					{/if}

					<tr>
						<td width="200">{#Packing#}</td>
						<td> {num_format val=$smarty.session.ShippingSumm} {$Currency}</td>
					</tr>

					{if $smarty.session.KostenZahlungOut>0}
						<tr>
							<td width="200">{#SummBillingMethod#}</td>
							<td class="mod_shop_summlist">{$smarty.session.KostenZahlungPM}{$smarty.session.KostenZahlungOut} {$smarty.session.KostenZahlungSymbol}</td>
						</tr>
					{/if}

					<tr>
						<td width="200" class="overall"><strong>{#SummOverall#}</strong></td>
						<td class="overall"><strong>{num_format val=$PaymentOverall} {$Currency}</strong>{if $smarty.session.BasketSummW2}<br /><span class="mod_shop_ust">{num_format val=$PaymentOverall2} {$Currency2}</span>{/if}</td>
					</tr>
{*
					{foreach from=$VatZones item=vz}
						{if $smarty.session.VatInc!='' && in_array($vz->Wert,$smarty.session.VatInc)}
							<tr>
								<td width="200"> {#IncVat#} {$vz->Wert}%: </td>
								<td class="mod_shop_incvat">{assign var=VatSessionName value=$vz->Wert} {num_format val=$smarty.session.$VatSessionName} {$Currency}</td>
							</tr>
						{/if}
					{/foreach}
*}
					{if $smarty.session.CouponCode > 0}
						{foreach from=$VatZones item=vz}
							{if $smarty.session.VatInc!='' && in_array($vz->Wert,$smarty.session.VatInc)}
								<tr>
									<td width="200">{#IncVat#} {$vz->Wert}%</td>
									<td class="mod_shop_incvat">&nbsp;</td>
								</tr>
							{/if}
						{/foreach}
					{else}
						{foreach from=$VatZones item=vz}
							{if $smarty.session.VatInc!='' && in_array($vz->Wert,$smarty.session.VatInc)}
								<tr>
									<td width="200">{#IncVat#} {$vz->Wert}%: </td>
									<td class="mod_shop_incvat">{assign var=VatSessionName value=$vz->Wert} {num_format val=$smarty.session.$VatSessionName} {$Currency}</td>
								</tr>
							{/if}
						{/foreach}
					{/if}

					<tr>
						<td width="200">&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>

				<hr noshade="noshade" size="1">
				<h3>{#InfoPaymentConfirm#}</h3>
				<strong>{$PaymentMethod|stripslashes}</strong><br />
				<em>{$PaymentText}</em>
				<hr noshade="noshade" size="1">
				<strong>{#InfoEnd#}</strong><br />
				{$CompanyHeadHtml}
			</td>
		</tr>
	</table>
</div>

</body>
</html>