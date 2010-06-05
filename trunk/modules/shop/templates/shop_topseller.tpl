{if $TopsellerActive==1}
{foreach from=$TopSeller item=ts name=tsitems}
			<table width="100%" style=" margin: 0;">
				<tr>
					<td>
						<a href="{$ts->Detaillink}">{$ts->Img}</a>
					</td>

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