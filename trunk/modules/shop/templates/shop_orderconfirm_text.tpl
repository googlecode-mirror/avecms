=================================================
{#BillTitle#}
=================================================

{#BillHead#}
=================================================

{#ShippingAdress#}
=================================================
{if $smarty.session.billing_company!=''}{$smarty.session.billing_company}
{/if}{if $smarty.session.billing_company_reciever!=''}{$smarty.session.billing_company_reciever}
{/if}{if $smarty.session.OrderPhone!=''}{$smarty.session.OrderPhone}
{/if}{$smarty.session.billing_firstname} {$smarty.session.billing_lastname}

{$smarty.session.billing_street} {$smarty.session.billing_streetnumber}
{$smarty.session.billing_zip} {$smarty.session.billing_town}
{$smarty.request.Land}


{#BillAdress#}
=================================================
{if $smarty.session.shipping_firstname=='' || $smarty.session.shipping_lastname==''}{#SameAsShipping#}{else}{if $smarty.session.shipping_company!=''}{$smarty.session.shipping_company}
{/if}{if $smarty.session.shipping_company_reciever!=''}{$smarty.session.shipping_company_reciever}
{/if}{$smarty.session.shipping_firstname} {$smarty.session.shipping_lastname}

{$smarty.session.shipping_street} {$smarty.session.shipping_streetnumber}
{$smarty.session.shipping_zip} {$smarty.session.shipping_city}
{$smarty.request.RLand}
{/if}

#################################################
{foreach from=$BasketItems item=bi}
{$bi->ArtName|truncate:100|escape:html} ({#ArtNumber#}: {$bi->ArtNr}) {if $bi->Versandfertig}
{$bi->Versandfertig}{/if}{if $bi->Vars}
{#ProductVars#}
{foreach from=$bi->Vars item=vars} {$vars->VarName|stripslashes}
{$vars->Name|stripslashes} {$vars->Operant}{$vars->WertE} {$Currency}
{/foreach}{/if}

{#BasketAmount#}: {$bi->Anzahl}
{#BasketSummO#}: {numFormat val=$bi->EPreis} {$Currency}
{#BasketSumm#}: {numFormat val=$bi->EPreisSumme} {$Currency}
#################################################
{/foreach}

{#OrderNumber#} {$OrderId}
{#OrderDate#} {$OrderTime|date_format:"%d.%m.%Y, %H:%M:%S"}
{#TransCode#} {$TransCode}

{#ShippingMethod#} {$ShipperName|stripslashes}
{#BillingMethod#} {$PaymentMethod|stripslashes}

{#OrdersSumm#} {numFormat val=$smarty.session.Zwisumm} {$Currency}
{if $smarty.session.CouponCode > 0}{#Coupon#}-{$smarty.session.CouponCode} %
{/if}
{if $smarty.session.Rabatt>0}{#CustomerDiscount#} -{$smarty.session.RabattWert}
{/if}{#Packing#} {numFormat val=$smarty.session.ShippingSumm} {$Currency}

{if $smarty.session.KostenZahlungOut>0}
{#SummBillingMethod#} {$smarty.session.KostenZahlungPM}{$smarty.session.KostenZahlungOut} {$smarty.session.KostenZahlungSymbol}{/if}
{#SummBillingMethod#} {numFormat val=$smarty.session.KostenZahlung} {$Currency}
{#SummOverall#} {numFormat val=$PaymentOverall} {$Currency}
=================================================
{if $smarty.session.CouponCode > 0}
{foreach from=$VatZones item=vz}{if $smarty.session.VatInc!='' && in_array($vz->Wert,$smarty.session.VatInc)}
{#IncVat#} {$vz->Wert}%{/if}
{/foreach}{else}{foreach from=$VatZones item=vz}
{if $smarty.session.VatInc!='' && in_array($vz->Wert,$smarty.session.VatInc)}
{#IncVat#} {$vz->Wert}%: {assign var=VatSessionName value=$vz->Wert} {numFormat val=$smarty.session.$VatSessionName} {$Currency}
{/if}
{/foreach}{/if}

=================================================


{#InfoPaymentConfirm#}
{$PaymentMethod|stripslashes}
{$PaymentText}


{#InfoEnd#}
{$CompanyHeadText}