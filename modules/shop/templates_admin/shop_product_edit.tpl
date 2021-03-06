<div class="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_module">&nbsp;</div>
	<div class="HeaderTitle"><h2>{#ProductEdit#}</h2></div>
	<div class="HeaderText">&nbsp;</div>
</div><br />

{if $errors}
	<div style="padding:5px; border:1px solid #FF0000; background-color:#FFFFCC; color:#FF0000; font-weight:bold">
		{#ProductNewErrorInf#}
		<ul>
			{foreach from=$errors item=error}
				<li>{$error}</li>
			{/foreach}
		</ul>
	</div><br />
{/if}

<form action="index.php?do=modules&action=modedit&mod=shop&moduleaction=edit_product&cp={$sess}&pop=1&Id={$smarty.request.Id}&sub=save" method="post" enctype="multipart/form-data">
	<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
		<tr>
			<td width="190" class="first">{#ProductName#}</td>
			<td class="second">
				<input name="ArtName" type="text" id="ArtName" style="width:100%" value="{$row.ArtName|stripslashes|escape}" />
			</td>
		</tr>

		<tr>
			<td width="190" class="first">{#ProductNrS#}&nbsp;<a href="javascript:void(0);" title="{#ProductNewAllowedChars#}">[?]</a></td>
			<td class="second">
				<input name="ArtNr" type="text" id="ArtNr" style="width:100%" value="{$row.ArtNr|stripslashes}" />
				<input name="ArtNrOld" type="hidden" id="ArtNrOld" value="{$row.ArtNr|stripslashes}" />
			</td>
		</tr>

		<tr>
			<td width="190" class="first">{#ProductImage#}</td>
			<td class="second">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td valign="top">
							{if $row.BildFehler=='1'}
								<a href="javascript:void(0);" onclick="window.open('../modules/shop/uploads/{$row.Bild}','x','width=400,height=400,scrollbars=1,resizable=1')">
									<img class="mod_shop_image " src="../modules/shop/thumb.php?file={$row.Bild}&type={$row.Bild_Typ}" alt="" border="0" />
								</a><br />
								<input class="absmiddle" type="checkbox" name="del_img" value="1" />{#ProductCategEImageDel#}
								<input type="hidden" name="del_old" value="{$row.Bild}" />
							{/if}
						</td>
						<td valign="top">&nbsp;</td>
					</tr>
				</table>
			</td>
		</tr>

		<tr>
			<td width="190" class="first">{#ProductNewImage#}</td>
			<td class="second">
				<input name="Bild" type="file" id="Bild" size="68" />
			</td>
		</tr>

		<tr>
			<td width="190" class="first">{#ProductMultiImages#}
				<br>
				<small>{#ProductMultiImagesInf#}</small>
			</td>
			<td class="second">
				{if $row.BilderMulti}
					<div style="height:100px; overflow:auto">
						{foreach from=$row.BilderMulti item=mi}
							<div style="float:left;margin-right:1px">
								<a href="javascript:void(0);" onclick="window.open('../modules/shop/uploads/{$mi->Bild}','x','width=400,height=400,scrollbars=1,resizable=1')">
									<img class="mod_shop_image " src="../modules/shop/thumb.php?file={$mi->Bild}&type={$mi->Endung}" alt="" border="0" />
								</a><br />
								<input class="absmiddle" type="checkbox" name="del_multi[{$mi->Id}]" value="1" />{#ProductCategEImageDel#}
							</div>
						{/foreach}
						<div style="clear:both"></div>
					</div><br />
				{/if}

				{section name='new_images' loop=4}
					<input name="file[]" type="file" size="68" /><br />
				{/section}
			</td>
		</tr>

		<tr>
			<td width="190" class="first">
				{#SShopOfferImage#}<br />
				<small>{#SShopOfferInf#}</small>
			</td>
			<td class="second" valign="bottom">
				{if $row.AngebotBild != ''}<img id="_img_feld__1" src="../{$row.AngebotBild}" /><br /><br />{/if}
				<div id="feld_1"><img id="_img_feld__1" src="templates/apanel/images/blanc.gif" alt="" border="0" /></div>
				<div style="display:none" id="span_feld__1">&nbsp;</div>
				<input type="text" style="width:400px" name="AngebotBild" value="{$row.AngebotBild}" id="img_feld__1" />&nbsp;
				<input value="{#OpenMediapool#}" class="button" type="button" onclick="cp_imagepop('img_feld__1','','','0');" />
			</td>
		</tr>

		<tr>
			<td width="190" class="first">{#ProductAng#}</td>
			<td class="second">
				<input type="radio" name="Angebot" value="1" {if $row.Angebot=='1'}checked="checked" {/if}/>{#Yes#}&nbsp;
				<input type="radio" name="Angebot" value="0" {if $row.Angebot=='0'}checked="checked" {/if}/>{#No#}
			</td>
		</tr>

		<tr>
			<td width="190" class="first">{#ProductDActive#} </td>
			<td class="second">
				<input type="radio" name="status" value="1" {if $row.status=='1'}checked="checked" {/if}/>{#Yes#}&nbsp;
				<input type="radio" name="status" value="0" {if $row.status=='0'}checked="checked" {/if}/>{#No#}
			</td>
		</tr>

		<tr>
			<td width="190" class="first">{#ProductTs#}</td>
			<td class="second">{$Kurz}</td>
		</tr>

		<tr>
			<td width="190" class="first">{#ProductTl#}</td>
			<td class="second">{$Lang}</td>
		</tr>

		<tr>
			<td width="190" class="first">{#ProductCateg#}</td>
			<td class="second">
				<select style="width:250px" name="KatId">
					{foreach from=$ProductCategs item=pc}
						<option value="{$pc->Id}" {if $pc->parent_id=='0'}style="font-weight:bold"{/if} {if $pc->Id==$row.KatId}selected="selected"{/if}>{$pc->visible_title}</option>
					{/foreach}
				</select>
			</td>
		</tr>

		<tr>
			<td width="190" class="first">
				{#ProductCategMulti#}&nbsp;
				<a title="{#ProductCategMultiInf#}" href="javascript:void(0);">[?]</a>
			</td>
			<td class="second">
				<select name="KatId_Multi[]" multiple="multiple" size="6" style="width:250px">
					{foreach from=$ProductCategs item=pc}
						{assign var='sel' value=''}
						{if $pc->Id}
							{if (in_array($pc->Id,$KatIds))}
								{assign var='sel' value='selected'}
							{/if}
						{/if}
						<option {if $pc->parent_id=='0'}style="font-weight:bold"{/if} value="{$pc->Id}" {$sel}>{$pc->visible_title}</option>
					{/foreach}
				</select>
			</td>
		</tr>

		<tr>
			<td width="190" class="first">
				{#ProductMatchwords#}
				&nbsp;<a title="{#ProductMatchwordsInf#}" href="javascript:void(0);">[?]</a>
			</td>
			<td class="second">
				<input name="Schlagwoerter" type="text" id="Schlagwoerter" style="width:100%" value="{$row.Schlagwoerter|stripslashes}" />
			</td>
		</tr>

		<tr>
			<td width="190" class="first">{#Keywordsshopartikles#}</td>
			<td class="second"><input name="ProdKeywords" type="text" id="ProdKeywords" size="40" value="{$row.ProdKeywords|stripslashes}" style="width:100%" /></td>
		</tr>

		<tr>
			<td width="190" class="first">{#Descriptionshopartikles#}</td>
			<td class="second"><input name="ProdDescription" type="text" id="ProdDescription" size="40" style="width:100%" value="{$row.ProdDescription|stripslashes}" maxlength="170" /></td>
		</tr>

		<tr>
			<td width="190" class="first">bid</td>
			<td class="second">
				<input name="bid" type="text" value="{$row.bid}" size="10" maxlength="5" />
			</td>
		</tr>

		<tr>
			<td width="190" class="first">cbid</td>
			<td class="second">
				<input name="cbid" type="text" value="{$row.cbid}" size="10" maxlength="5" />
			</td>
		</tr>

		<tr>
			<td width="190" class="first">{#ProductManufacturer#}</td>
			<td class="second">
				<select name="Hersteller" style="width:250px">
					<option value="0">{#ProductManufacturerNo#}</option>
						{foreach from=$Manufacturer item=m}
							<option value="{$m->Id}" {if $row.Hersteller==$m->Id}selected="selected"{/if}>{$m->Name|stripslashes}</option>
						{/foreach}
				</select>
			</td>
		</tr>

		<tr>
			<td width="190" class="first">{#ProductVatZone#}</td>
			<td class="second">
				<select name="UstZone" id="UstZone" style="width:250px">
					{foreach from=$VatZones item=vz}
						<option value="{$vz->Id}" {if $row.UstZone==$vz->Id}selected="selected"{/if}>{$vz->Name} ({$vz->Wert})</option>
					{/foreach}
				</select>
			</td>
		</tr>

		<tr>
			<td width="190" class="first">{#ProductPrice#}&nbsp;<a title="{#ProductPriceInf#}" href="javascript:void(0);">[?]</a></td>
			<td class="second">
				<input name="Preis" type="text" id="Preis" style="width:100px" maxlength="10" value="{$row.Preis}" />
			</td>
		</tr>

		<tr>
			<td width="190" class="first">{#ProductList#} &nbsp;<a title="{#ProductListInf#}" href="javascript:void(0);">[?]</a></td>
			<td class="second">
				<input name="PreisListe" type="text" id="PreisListe" style="width:100px" maxlength="10" value="{if $row.PreisListe > 0}{$row.PreisListe}{/if}" />
			</td>
		</tr>

		<tr>
			<td width="190" class="first">{#ProductWeight#}</td>
			<td class="second">
				<input name="Gewicht" type="text" id="Gewicht" style="width:100px" value="{if $row.Gewicht > 0}{$row.Gewicht}{/if}" />&nbsp;
				{#ProductWeightInf#}
			</td>
		</tr>

		<tr>
			<td width="190" class="first">{#ProductUnits#}
				&nbsp;<a title="{#ProductUnitsInf#}" href="javascript:void(0);">[?]</a>
			</td>
			<td class="second">
				<input name="Einheit" type="text" id="Einheit" style="width:100px" value="{if $row.Einheit > 0}{$row.Einheit}{/if}" />
				/ <select name="EinheitId" id="EinheitId">
					<option value=""></option>
					{foreach from=$Units item=unit}
						<option value="{$unit->Id}" {if $row.EinheitId==$unit->Id}selected="selected"{/if}>{$unit->Name|stripslashes}</option>
					{/foreach}
				</select>
			</td>
		</tr>

		<tr>
			<td width="190" class="first">{#ProductStored#}</td>
			<td class="second">
				<input name="Lager" type="text" id="Lager" style="width:100px" value="{$row.Lager}" />
			</td>
		</tr>

		<tr>
			<td width="190" class="first">{#ProductShippingTime#}</td>
			<td class="second">
				<select name="VersandZeitId" style="width:250px">
					<option value="0"></option>
					{foreach from=$ShippingTime item=st}
						<option value="{$st->Id}" {if $row.VersandZeitId==$st->Id}selected="selected"{/if}>{$st->Name|stripslashes}</option>
					{/foreach}
				</select>
			</td>
		</tr>

		<tr>
			<td width="190" class="first">{#ProductPublished#}
				&nbsp;<a title="{#ProductPublishedInf#}" href="javascript:void(0);">[?]</a>
			</td>
			<td class="second">
				{assign var=ZeitStart value=$row.Erschienen}
				{html_select_date time=$ZeitStart prefix="Ersch" end_year="+5" start_year="-10" display_days=true month_format="%B" reverse_years=false day_size=1 field_order=DMY month_extra="style='width:80px'" all_extra=""}
			</td>
		</tr>

		<tr>
			<td width="190" class="first">{#ProductFreeTitle#} 1 </td>
			<td class="second">
				<input name="Frei_Titel_1" type="text" id="Frei_Titel_1" style="width:100%" value="{$row.Frei_Titel_1|stripslashes}" />
			</td>
		</tr>

		<tr>
			<td width="190" class="first">{#ProductText#} 1 </td>
			<td class="second">{$Frei1}	</td>
		</tr>

		<tr>
			<td width="190" class="first">{#ProductFreeTitle#} 2 </td>
			<td class="second">
				<input name="Frei_Titel_2" type="text" id="Frei_Titel_2" style="width:100%" value="{$row.Frei_Titel_2|stripslashes}" />
			</td>
		</tr>

		<tr>
			<td width="190" class="first">{#ProductText#} 2 </td>
			<td class="second">{$Frei2}	</td>
		</tr>

		<tr>
			<td width="190" class="first">{#ProductFreeTitle#} 3 </td>
			<td class="second">
				<input name="Frei_Titel_3" type="text" id="Frei_Titel_3" style="width:100%" value="{$row.Frei_Titel_3|stripslashes}" />
			</td>
		</tr>

		<tr>
			<td width="190" class="first">{#ProductText#} 3 </td>
			<td class="second">{$Frei3}	</td>
		</tr>

		<tr>
			<td width="190" class="first">{#ProductFreeTitle#} 4 </td>
			<td class="second">
				<input name="Frei_Titel_4" type="text" id="Frei_Titel_4" style="width:100%" value="{$row.Frei_Titel_4|stripslashes}" />
			</td>
		</tr>

		<tr>
			<td width="190" class="first">{#ProductText#} 4 </td>
			<td class="second">{$Frei4}	</td>
		</tr>

		<tr>
			<td width="190" class="first">&nbsp;</td>
			<td class="second">
				<input accesskey="s" class="button" type="submit" value="{#ButtonSave#}" />
			</td>
		</tr>
	</table>
</form>