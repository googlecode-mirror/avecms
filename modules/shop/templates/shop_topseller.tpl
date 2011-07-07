
{if $TopsellerActive==1}
	{if $smarty.request.categ==''}
		<table width="100%" cellpadding="0" cellspacing="0">
			<tr>
				{foreach from=$TopSeller item=ts name=tsitems}
					<td style="text-align:center;">
						<div class="mod_shop_newprod_box_container">
							<a title="" href="{$ts->Detaillink}">{$ts->Img}</a>
						</div>
					</td>
				{/foreach}
			</tr>
			<tr>
				{foreach from=$TopSeller item=ts name=tsitems}
					<td valign="top" style="text-align:center;">
						<a title="" href="{$ts->Detaillink}">{$ts->ArtName|truncate:55}</a><br />
					</td>
				{/foreach}
			</tr>
			<tr>
				{foreach from=$TopSeller item=ts name=tsitems}
					<td style="text-align:center;">
						<span class="mod_shop_price_small">{num_format val=$ts->Preis} {$Currency}</span>
					</td>
				{/foreach}
			</tr>
		</table>
	{else}
		{foreach from=$TopSeller item=ts name=tsitems}
			<table width="100%" style="margin:0">
				<tr>
					<td><a href="{$ts->Detaillink}">{$ts->Img}</a></td>
					<td align="center">
						<a href="{$ts->Detaillink}" class="topseller">{$ts->ArtName|truncate:55}</a>
						<div class="mod_shop_toptopseller_bottom">
							{num_format val=$ts->Preis} {$Currency}
							{if $ts->PreisW2 && $ZeigeWaehrung2=='1'} = <span class="mod_shop_ust">{num_format val=$ts->PreisW2} {$Currency2}</span>{/if}
						</div>
					</td>
				</tr>
			</table>
			{if !$smarty.foreach.tsitems.last}<hr />{/if}
		{/foreach}
	{/if}
{/if}
