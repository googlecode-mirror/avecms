{strip}
		{if !$BasketItems}
		{#BasketEmpty#}
		{else}

{foreach from=$BasketItems item=bi}
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin: 0;">
<tr>
<td width="1%" valign="top" nowrap="nowrap" bgcolor="#FFFFFF">{$bi->Anzahl} x</td>
<td align="left" valign="top" bgcolor="#FFFFFF" style="padding-left: 5px;">
				<a class="tooltip" title="{$bi->ArtName|escape:html}" href="{$bi->ProdLink}">{$bi->ArtName|truncate:21|escape:html}</a>

				{*
				{if $bi->Vars}
				<br />
				{foreach from=$bi->Vars item=vars}
				<small class="mod_shop_basket_price">
				<strong>{$vars->VarName|stripslashes}</strong><br />
				{$vars->Name|stripslashes}
				<br />
				{$vars->Operant}{$vars->Wert} {$Currency}				</small>
				<br />
				{/foreach}
				{/if}
				*}
</td>
<td width="13" align="right" valign="top" bgcolor="#FFFFFF">
<form method="post" action="{$bi->DelLink}"><input title="{$config_vars.OL_DeleteItem}" class="absmiddle" type="image" src="{$shop_images}delete.gif" /></form>				</td>
</tr></table>
<hr style=" margin: 3px 0;"/>
{/foreach}
{/if}
<div   style="margin-top: 5px; margin-bottom: 5px; "><strong>{#TempOverall#} {numFormat val=$smarty.session.BasketOverall} {$Currency}</strong></div>

<ul>
{if $BasketItems}
<li><a href="{$ShowBasketLink}">{#GotoBasket#}</a></li>
<li><a href="{$ShowPaymentLink}">{#GotoCheckout#}</a></li>
{/if}
{if $WishListActive==1}
<li><a href="{$WishListLink}" target="_blank">{#Wishlist#}</a> � <a class="tooltip" title="{$config_vars.WishlistInf}"  href="#">{#WhatsThat#}</a></li>
{/if}
</ul>
{/strip}