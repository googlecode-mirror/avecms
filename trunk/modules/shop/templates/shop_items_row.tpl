{if !$ShopArticles}
	{#ErrorNoProductsHere#}
{else}
	{* постраничная навигация *}
	{if $page_nav}{$page_nav}{/if}

	<table class="mod_shop_basket_table" border="0" cellpadding="0" cellspacing="1" width="100%" style="margin: 5px 0;">
		<tr>
			<th valign="top" class="mod_shop_basket_header">Наименование</th>
			<th valign="top" class="mod_shop_basket_header">Цена</th>
		</tr>

		{foreach from=$ShopArticles item=i}
			<tr>
				<td valign="top" class="mod_shop_basket_row">
					<strong><a href="{$i->Detaillink}">{$i->ArtName|truncate:45|stripslashes|escape:html}</a></strong>
				</td>
				<td valign="top" class="mod_shop_basket_row">
					{num_format val=$i->Preis} {$Currency}
				</td>
			</tr>
		{/foreach}
	</table>

	{* постраничная навигация *}
	{if $page_nav}{$page_nav}{/if}
{/if}