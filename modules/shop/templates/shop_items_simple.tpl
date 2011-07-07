
{if !$ShopArticles}
	{#ErrorNoProductsHere#}
{else}
	{* Geben Sie hier an, in wie vielen Spalten die Artikel nebeneinander angezeigt werden sollen. Empfohlen: 1 *}
	{assign var="cols" value=2}

	{* постраничная навигация *}
	{if $page_nav}{$page_nav}{/if}

	<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			{foreach from=$ShopArticles item=i}
				<td valign="top" width="50%">
					<div class="{if $newtr % $cols == 0}mod_shop_shop_items_left{else}mod_shop_shop_items_right{/if}">
						{assign var="newtr" value=$newtr+1}
						<table width="100%" border="0" cellpadding="3" cellspacing="0">
							<tr>
								<td valign="top">
									{if $i->BildFehler==1}
										<a href="{$i->Detaillink}"><img src="{$shop_images}no_productimage.gif" alt="" border="0" align="left" /></a>
									{else}
										<a href="{$i->Detaillink}"><img align="left" src="modules/shop/thumb.php?file={$i->Bild}&type={$i->Bild_Typ}" alt="" border="0" /></a>
									{/if}
								</td>

								<td valign="top" style="padding-left:10px">
									<strong><a href="{$i->Detaillink}">{$i->ArtName|truncate:45|stripslashes|escape:html}</a></strong>
									{* {$i->TextKurz|stripslashes|truncate:150} *}<br />
									<br />

									{if $i->Lager < 1 && $KaufLagerNull == '1'}
										<div class="mod_shop_preorder_warn">{#PreOrderMsg#}</div>
									{elseif $i->Lager < 1 && $KaufLagerNull == '0'}
										<div class="mod_shop_preorder_warn">{#PreOrderMsgF#}</div>
									{/if}<br />

									<div style="text-align:center">
										{if $i->PreisDiff > 0}
											<span class="mod_shop_ust">
												{#PriceListS#} <strong style="text-decoration:line-through">{$i->PreisListe} {$Currency}</strong><br />
												<strong>{#PriceYouSave#}</strong> {num_format val=$i->PreisDiff} {$Currency}
											</span>
										{/if}<br />

										<!-- PRICE -->
										<h2>{num_format val=$i->Preis} {$Currency}</h2>
										<!-- PRICE 2. CURRENCY -->
										{if $i->PreisW2 && $ZeigeWaehrung2=='1'}
											<br />
											<span class="mod_shop_ust">({num_format val=$i->PreisW2} {$Currency2})</span>
										{/if}
									</div>
								</td>
							</tr>
						</table><br />
						<br />
					</div>
				</td>
 				{if $newtr % $cols == 0}</tr><tr>{/if}
			{/foreach}
		</tr>
	</table>

	{* постраничная навигация *}
	{if $page_nav}{$page_nav}{/if}
{/if}
