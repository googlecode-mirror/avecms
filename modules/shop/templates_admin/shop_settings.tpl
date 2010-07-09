<div class="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_module">&nbsp;</div>
	<div class="HeaderTitle"><h2>{#ModName#}</h2></div>
	<div class="HeaderText">&nbsp;</div>
</div><br />

{include file="$source/shop_topnav.tpl"}

<h4>{#ShopSettings#}</h4>

<form action="index.php?do=modules&action=modedit&mod=shop&moduleaction=settings&cp={$sess}&sub=save" method="post">
	<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
		<col width="300" valign="top" class="first">
		<col class="second">
		<tr>
			<td class="tableheader">{#SettingsName#}</td>
			<td class="tableheader">{#SettingsValue#}</td>
		</tr>

		<tr>
			<td>{#SisActive#}</td>
			<td><input name="status" type="checkbox" value="1" {if $row->status=='1'}checked="checked" {/if} /></td>
		</tr>

		<tr>
			<td>{#ShopKeywords#}</td>
			<td><input name="ShopKeywords" type="text" id="ShopKeywords" size="40" value="{$row->ShopKeywords}" style="width: 500px" /></td>
		</tr>

		<tr>
			<td>{#ShopDescription#}</td>
			<td><input name="ShopDescription" type="text" id="ShopDescription" size="40" style="width: 500px" value="{$row->ShopDescription}" maxlength="170" /></td>
		</tr>

		<tr>
			<td>{#TemplateArticles#}</td>
			<td>
				<select style="width:200px" name="TemplateArtikel">
					<option value="shop_items.tpl"{if $row->TemplateArtikel=='shop_items.tpl'} selected="selected"{/if}>{#TemplateStandart#}</option>
					<option value="shop_items_simple.tpl"{if $row->TemplateArtikel=='shop_items_simple.tpl'} selected="selected"{/if}>{#TemplateNItems#}</option>
					<option value="shop_items_row.tpl"{if $row->TemplateArtikel=='shop_items_row.tpl'} selected="selected"{/if}>{#TemplateRItems#}</option>
				</select>
			</td>
		</tr>

		<tr>
			<td>{#Scountry#}</td>
			<td>
				<input name="ShopLand" type="text" id="ShopLand" value="{$row->ShopLand|upper}" size="2" maxlength="2" />
			</td>
		</tr>

		<tr>
			<td>{#Scurrency#} </td>
			<td>
				<input name="Waehrung" type="text" id="Waehrung" value="{$row->Waehrung}" size="10" maxlength="10" />
			</td>
		</tr>

		<tr>
			<td>{#ScurencySymbol#} </td>
			<td>
				<input name="WaehrungSymbol" type="text" value="{$row->WaehrungSymbol}" size="10" maxlength="5" />
			</td>
		</tr>

		<tr>
			<td>{#AltCurrencyUse#}</td>
			<td>
				<input type="radio" value="1" name="ZeigeWaehrung2" {if $row->ZeigeWaehrung2==1}checked="checked" {/if}/>{#Yes#}&nbsp;
				<input type="radio" value="0" name="ZeigeWaehrung2" {if $row->ZeigeWaehrung2==0}checked="checked" {/if}/>{#No#}
			</td>
		</tr>

		<tr>
			<td>{#AltCurrency#}</td>
			<td>
				<input name="Waehrung2" type="text" value="{$row->Waehrung2}" size="10" maxlength="10" />
			</td>
		</tr>

		<tr>
			<td>{#AltCurrencySymbol#}</td>
			<td>
				<input name="WaehrungSymbol2" type="text" value="{$row->WaehrungSymbol2}" size="10" maxlength="5" />
			</td>
		</tr>

		<tr>
			<td>{#AltCMulti#}</td>
			<td>
				<input name="Waehrung2Multi" type="text" value="{$row->Waehrung2Multi}" size="10" maxlength="10" />
			</td>
		</tr>

		<tr>
			<td>{#SitemsEPage#}</td>
			<td>
				<input name="ArtikelMax" type="text" id="ArtikelMax" value="{$row->ArtikelMax}" size="10" maxlength="5" />
			</td>
		</tr>

		<tr>
			<td>{#WidthThumbs#}</td>
			<td>
				<input name="Vorschaubilder" type="text" value="{$row->Vorschaubilder}" size="10" maxlength="3" />
			</td>
		</tr>

		<tr>
			<td>{#WidthTsThumbs#}</td>
			<td>
				<input name="Topsellerbilder" type="text" value="{$row->Topsellerbilder}" size="10" maxlength="3" />
			</td>
		</tr>

		<tr>
			<td>
				{#SScountries#}<br />
				<small>{#SSelectCountries#}</small>
			</td>
			<td>
				<select name="VersandLaender[]" multiple="multiple" size="6" style="width:200px">
					{foreach from=$laender item=g}
						{assign var='sel' value=''}
						{if $g->country_code}
							{if (in_array($g->country_code,$row->VersandLaender)) }
								{assign var='sel' value='selected'}
							{/if}
						{/if}
						<option value="{$g->country_code}" {$sel}>{$g->country_name|escape:html}</option>
					{/foreach}
				</select>
			</td>
		</tr>

		<tr>
			<td>{#SNoShippingCostFrom#}</td>
			<td><input name="VersFreiBetrag" type="text" value="{$row->VersFreiBetrag}" size="10" maxlength="10" /></td>
		</tr>

		<tr>
			<td>{#SNoShippingCost#}</td>
			<td>
				<input type="radio" value="1" name="VersFrei" {if $row->VersFrei==1}checked="checked" {/if}/>{#Yes#}&nbsp;
				<input type="radio" value="0" name="VersFrei" {if $row->VersFrei==0}checked="checked" {/if}/>{#No#}
			</td>
		</tr>

		<tr>
			<td>{#SStopIfNull#}</td>
			<td>
				<input type="radio" value="1" name="KaufLagerNull" {if $row->KaufLagerNull==1}checked="checked" {/if}/>{#Yes#}&nbsp;
				<input type="radio" value="0" name="KaufLagerNull" {if $row->KaufLagerNull==0}checked="checked" {/if}/>{#No#}
			</td>
		</tr>

		<tr>
			<td>{#OrderGuests#}</td>
			<td>
				<input type="radio" value="1" name="GastBestellung" {if $row->GastBestellung==1}checked="checked" {/if}/>{#Yes#}&nbsp;
				<input type="radio" value="0" name="GastBestellung" {if $row->GastBestellung==0}checked="checked" {/if}/>{#No#}
			</td>
		</tr>

		<tr>
			<td>{#SUseCoupons#}</td>
			<td>
				<input type="radio" value="1" name="GutscheinCodes" {if $row->GutscheinCodes==1}checked="checked" {/if}/>{#Yes#}&nbsp;
				<input type="radio" value="0" name="GutscheinCodes" {if $row->GutscheinCodes==0}checked="checked" {/if}/>{#No#}
			</td>
		</tr>

		<tr>
			<td>{#ShopShowUnits#}</td>
			<td>
				<input type="radio" value="1" name="ZeigeEinheit" {if $row->ZeigeEinheit==1}checked="checked" {/if}/>{#Yes#}&nbsp;
				<input type="radio" value="0" name="ZeigeEinheit" {if $row->ZeigeEinheit==0}checked="checked" {/if}/>{#No#}
			</td>
		</tr>

		<tr>
			<td>{#ShopZeigeNetto#}</td>
			<td>
				<input type="radio" value="1" name="ZeigeNetto" {if $row->ZeigeNetto==1}checked="checked" {/if}/>{#Yes#}&nbsp;
				<input type="radio" value="0" name="ZeigeNetto" {if $row->ZeigeNetto==0}checked="checked" {/if}/>{#No#}
			</td>
		</tr>

		<tr>
			<td>{#SSShowCategsStart#}</td>
			<td>
				<input type="radio" value="1" name="KategorienStart" {if $row->KategorienStart==1}checked="checked" {/if}/>{#Yes#}&nbsp;
				<input type="radio" value="0" name="KategorienStart" {if $row->KategorienStart==0}checked="checked" {/if}/>{#No#}
			</td>
		</tr>

		<tr>
			<td>{#SSShowCategsSons#}</td>
			<td>
				<input type="radio" value="1" name="KategorienSons" {if $row->KategorienSons==1}checked="checked" {/if}/>{#Yes#}&nbsp;
				<input type="radio" value="0" name="KategorienSons" {if $row->KategorienSons==0}checked="checked" {/if}/>{#No#}
			</td>
		</tr>

		<tr>
			<td>{#SSShowRandomOffer#}</td>
			<td>
				<input type="radio" value="1" name="ZufallsAngebot" {if $row->ZufallsAngebot==1}checked="checked" {/if}/>{#Yes#}&nbsp;
				<input type="radio" value="0" name="ZufallsAngebot" {if $row->ZufallsAngebot==0}checked="checked" {/if}/>{#No#}
			</td>
		</tr>

		<tr>
			<td>{#SSShowRandomOfferCat#}</td>
			<td>
				<input type="radio" value="1" name="ZufallsAngebotKat" {if $row->ZufallsAngebotKat==1}checked="checked" {/if}/>{#Yes#}&nbsp;
				<input type="radio" value="0" name="ZufallsAngebotKat" {if $row->ZufallsAngebotKat==0}checked="checked" {/if}/>{#No#}
			</td>
		</tr>

		<tr>
			<td>{#CanOrderHere#}</td>
			<td>
				<input type="radio" value="1" name="BestUebersicht" {if $row->BestUebersicht==1}checked="checked" {/if}/>{#Yes#}&nbsp;
				<input type="radio" value="0" name="BestUebersicht" {if $row->BestUebersicht==0}checked="checked" {/if}/>{#No#}
			</td>
		</tr>

		<tr>
			<td>{#Wishlist#}</td>
			<td>
				<input type="radio" value="1" name="Merkliste" {if $row->Merkliste==1}checked="checked" {/if}/>{#Yes#}&nbsp;
				<input type="radio" value="0" name="Merkliste" {if $row->Merkliste==0}checked="checked" {/if}/>{#No#}
			</td>
		</tr>

		<tr>
			<td>{#ShowTopSeller#}</td>
			<td>
				<input type="radio" value="1" name="Topseller" {if $row->Topseller==1}checked="checked" {/if}/>{#Yes#}&nbsp;
				<input type="radio" value="0" name="Topseller" {if $row->Topseller==0}checked="checked" {/if}/>{#No#}
			</td>
		</tr>

		<tr>
			<td>{#AllowComments#}</td>
			<td>
				<input type="radio" value="1" name="Kommentare" {if $row->Kommentare==1}checked="checked" {/if}/>{#Yes#}&nbsp;
				<input type="radio" value="0" name="Kommentare" {if $row->Kommentare==0}checked="checked" {/if}/>{#No#}
			</td>
		</tr>

		<tr>
			<td>{#AllowCommentsGuest#}</td>
			<td>
				<input type="radio" value="1" name="KommentareGast" {if $row->KommentareGast==1}checked="checked" {/if}/>{#Yes#}&nbsp;
				<input type="radio" value="0" name="KommentareGast" {if $row->KommentareGast==0}checked="checked" {/if}/>{#No#}
			</td>
		</tr>

		<tr>
			<td>{#RequiredIntro#}</td>
			<td>
				<input type="radio" value="1" name="required_intro" {if $row->required_intro==1}checked="checked" {/if}/>{#Yes#}
				<input type="radio" value="0" name="required_intro" {if $row->required_intro==0}checked="checked" {/if}/>{#No#}
			</td>
		</tr>

		<tr>
			<td>{#RequiredDesc#}</td>
			<td>
				<input type="radio" value="1" name="required_desc" {if $row->required_desc==1}checked="checked" {/if}/>{#Yes#}
				<input type="radio" value="0" name="required_desc" {if $row->required_desc==0}checked="checked" {/if}/>{#No#}
			</td>
		</tr>

		<tr>
			<td>{#RequiredPrice#}</td>
			<td>
				<input type="radio" value="1" name="required_price" {if $row->required_price==1}checked="checked" {/if}/>{#Yes#}
				<input type="radio" value="0" name="required_price" {if $row->required_price==0}checked="checked" {/if}/>{#No#}
			</td>
		</tr>

		<tr>
			<td>{#RequiredStock#}</td>
			<td>
				<input type="radio" value="1" name="required_stock" {if $row->required_stock==1}checked="checked" {/if}/>{#Yes#}
				<input type="radio" value="0" name="required_stock" {if $row->required_stock==0}checked="checked" {/if}/>{#No#}
			</td>
		</tr>
	</table><br />

	<input accesskey="s" type="submit" value="{#ButtonSave#}" class="button" />
</form>