{strip}

<div class="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_module">&nbsp;</div>
	<div class="HeaderTitle"><h2>{#ModName#}</h2></div>
	<div class="HeaderText">{#Products#}</div>
</div><br />

{include file="$source/shop_topnav.tpl"}
<br />

<div class="infobox" style="padding:0px">
	<form method="post" action="index.php?do=modules&action=modedit&mod=shop&moduleaction=products&cp={$sess}">
		<table width="100%" border="0" cellpadding="4" cellspacing="1">
			<tr>
				<td width="150" class="first">
					<label for="pq">{#ProductSArtTitle#}</label>
				</td>

				<td width="100" class="second">
					<input class="mod_shop_inputfields" style="width:150px" name="product_query" id="pq" type="text" value="{$smarty.post.product_query|stripslashes|escape:html}" />
				</td>

				<td width="130" class="first">
					<label for="pfpt">{#PriceFromTo#}</label>
				</td>

				<td class="second">
					<input class="mod_shop_inputfields" style="width:70px" type="text" name="price_start" id="pfpt" value="{$smarty.post.price_start|stripslashes|escape:html|default:'0.00'}" />
					<input class="mod_shop_inputfields" style="width:70px" type="text" name="price_end" value="{$smarty.post.price_end|stripslashes|escape:html|default:'100000.00'}" />
				</td>
			</tr>

			<tr>
				<td width="150" class="first">
					<label for="mf">{#ManufacturerS#}</label>
				</td>

				<td width="100" class="second">
					<select class="mod_shop_inputfields" style="width:150px" name="manufacturer" id="mf">
						<option value="">{#ManufacturerA#}</option>
						{foreach from=$Manufacturer item=m}
							<option value="{$m->Id}" {if $smarty.post.manufacturer==$m->Id}selected="selected"{/if}>{$m->Name|stripslashes}</option>
						{/foreach}
					</select>
				</td>

				<td width="130" class="first">
					{#ProductStore#}
				</td>

				<td class="second">
					<select style="width:140px" name="Lager">
						<option value="egal">{#ProductDm#}</option>
						{section name='lager' loop=210 step=10 start=10}
							<option value="{$smarty.section.lager.index}" {if $smarty.request.lager==$smarty.section.lager.index}selected="selected"{/if}>{#ProductStoreS#} {$smarty.section.lager.index}</option>
						{/section}
					</select>
				</td>
			</tr>

			<tr>
				<td width="150" class="first">
					<label for="pc">{#ProductCategs#}</label>
				</td>

				<td width="100" class="second">
					<select class="mod_shop_inputfields" style="width:150px" name="product_categ" id="pc">
						<option>{#ProductCategsAll#}</option>
						{foreach from=$ProductCategs item=pc}
							<option value="{$pc->Id}"{if $pc->Elter == 0} style="font-weight:bold"{/if}{if $pc->Id==$smarty.post.product_categ} selected="selected"{/if}>{$pc->visible_title}</option>
						{/foreach}
					</select>
				</td>

				<td width="130" class="first">
					{#ProductBought#}
				</td>

				<td class="second">
					<select style="width:140px" name="Bestellungen">
						<option value="egal">{#ProductDm#}</option>
						{section name='best' loop=210 step=10 start=10}
							<option value="{$smarty.section.best.index}"{if $smarty.request.bestellungen==$smarty.section.best.index} selected="selected"{/if}>{#ProductStoreS#} {$smarty.section.best.index}</option>
						{/section}
					</select>
				</td>
			</tr>

			<tr>
				<td class="first">{#ProductActiveSearch#}</td>

				<td class="second">
					<select style="width:150px" name="active">
						<option value="all"{if $smarty.request.active=='all'} selected="selected"{/if}>{#ProductActiveSearchAll#}</option>
						<option value="1"{if $smarty.request.active=='1'} selected="selected"{/if}>{#ProductActiveSearchA#}</option>
						<option value="0"{if $smarty.request.active=='0'} selected="selected"{/if}>{#ProductActiveSearchI#}</option>
					</select>
				</td>

				<td class="first">
					<label for="rs">{#ProductDataSReduced#}</label>
				</td>

				<td class="second">
					<select class="mod_shop_inputfields" name="recordset" id="rs">
						{section name=recordset loop=210 step=10 start=10}
							<option value="{$smarty.section.recordset.index}"{if $smarty.section.recordset.index == $smarty.request.recordset|default:10} selected=selected"{/if}>{$smarty.section.recordset.index}</option>
						{/section}
					</select>

					<select style="width:90px" name="Angebot">
						<option value="egal">{#ProductDm#}</option>
						<option value="1"{if $smarty.request.angebot==1} selected="selected"{/if}>{#ProductOnlyReduced#}</option>
					</select>

					&nbsp;<input type="submit" class="button" value="{#ButtonSearch#}" />
				</td>
			</tr>
		</table>
	</form>
</div>

<h4>{#Products#}</h4>

<form name="kform" action="index.php?do=modules&action=modedit&mod=shop&moduleaction=products&cp={$sess}&sub=save" method="post">
	<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
		<tr>
			<td class="tableheader"><input name="allbox" type="checkbox" id="d" onclick="selall();" value="" /></td>
			<td class="tableheader">&nbsp;</td>
			<td class="tableheader"><a class="header" href="index.php?do=modules&action=modedit&mod=shop&moduleaction=products&cp={$sess}&recordset={$smarty.request.recordset|default:10}&sort={if $smarty.request.sort=='NameAsc'}NameDesc{else}NameAsc{/if}">{#CatName#}</a></td>
			<td class="tableheader"><a class="header" href="index.php?do=modules&action=modedit&mod=shop&moduleaction=products&cp={$sess}&recordset={$smarty.request.recordset|default:10}&sort={if $smarty.request.sort=='PriceAsc'}PriceDesc{else}PriceAsc{/if}">{#ProductPrice#}</a></td>
			<td class="tableheader"><a class="header" href="index.php?do=modules&action=modedit&mod=shop&moduleaction=products&cp={$sess}&recordset={$smarty.request.recordset|default:10}&sort={if $smarty.request.sort=='LagerAsc'}LagerDesc{else}LagerAsc{/if}">{#ProductStore#}</a></td>
			<td class="tableheader"><a class="header" href="index.php?do=modules&action=modedit&mod=shop&moduleaction=products&cp={$sess}&recordset={$smarty.request.recordset|default:10}&sort={if $smarty.request.sort=='GekauftAsc'}GekauftDesc{else}GekauftAsc{/if}">{#ProductBought#}</a></td>
			<td class="tableheader">{#CatIn#}</td>
			<td class="tableheader"><a class="header" href="index.php?do=modules&action=modedit&mod=shop&moduleaction=products&cp={$sess}&recordset={$smarty.request.recordset|default:10}&sort={if $smarty.request.sort=='PositionAsc'}PositionDesc{else}PositionAsc{/if}">{#ProductPosition#}</a></td>
			<td class="tableheader" width="1%" align="center" colspan="5">{#Actions#}</td>
		</tr>

		{foreach from=$products item=i}
			<tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
				<td width="1%">
					<input type="checkbox" name="shopartikel_{$i->Id}" value="1" />
				</td>

				<td width="1%" style="height:40px">
					{if $i->BildFehler==1}
						&nbsp;
					{else}
						<a href="javascript:void(0);" onclick="cp_pop('index.php?do=modules&action=modedit&mod=shop&moduleaction=edit_product&cp={$sess}&pop=1&Id={$i->Id}','980','650','1','shopshipper');">
							<img class="mod_shop_image " src="../modules/shop/thumb.php?file={$i->Bild}&type={$i->Bild_Typ}&xwidth=25" alt="" border="0" />
						</a>
					{/if}
				</td>

				<td>
					{if $i->Aktiv==1}
						<a title="{#ProductEdit#}" href="javascript:void(0);" onclick="cp_pop('index.php?do=modules&action=modedit&mod=shop&moduleaction=edit_product&cp={$sess}&pop=1&Id={$i->Id}','980','740','1','edit_product');">{$i->ArtName|truncate:45|stripslashes}</a>
					{else}
						<span style="text-decoration:line-through">{$i->ArtName|truncate:45|stripslashes}</span>
					{/if}
					<br />
					<small>{#ProductNr#} {$i->ArtNr}</small>
				</td>

				<td width="1%" align="center">
					<input name="Preis[{$i->Id}]" type="text" style="width:80px" maxlength="10" value="{$i->Preis}" />
				</td>

				<td width="1%" align="center">
					<input name="Lager[{$i->Id}]" type="text" style="width:40px{if $i->Lager == 0};font-weight:bold;color:#FF0000{/if}" maxlength="12" value="{$i->Lager}" />
				</td>

				<td width="1%" align="center">
					<input name="Bestellungen[{$i->Id}]" type="text" style="width:40px{if $i->Bestellungen == 0};font-weight:bold;color:#FF0000{/if}" maxlength="12" value="{$i->Bestellungen}" />
				</td>

				<td width="100">
					<select name="KatId[{$i->Id}]">
						{foreach from=$ProductCategs item=pc}
							<option value="{$pc->Id}" {if $pc->Elter == 0}style="font-weight:bold"{/if} {if $pc->Id==$i->KatId}selected="selected"{/if}>{$pc->visible_title}</option>
						{/foreach}
					</select>
				</td>

				<td width="15"><input name="PosiStartseite[{$i->Id}]" type="text" style="width:40px" maxlength="12" value="{$i->PosiStartseite}" /></td>

				<td width="1%">
					<a title="{#ProductEdit#}" href="javascript:void(0);" onclick="cp_pop('index.php?do=modules&action=modedit&mod=shop&moduleaction=edit_product&cp={$sess}&pop=1&Id={$i->Id}','980','740','1','edit_product');">
					<img src="{$tpl_dir}/images/icon_edit.gif" alt="{#DokEdit#}" border="0" /></a>
				</td>

				<td width="1%">
					<a title="{#ProductVarsEdit#}" href="javascript:void(0);" onclick="cp_pop('index.php?do=modules&action=modedit&mod=shop&moduleaction=product_vars&cp={$sess}&pop=1&Id={$i->Id}&KatId={$i->KatId}','980','740','1','edit_vars');">
					<img src="{$tpl_dir}/images/icon_data.gif" alt="{#ProductVarsEdit#}" border="0" /></a>
				</td>

				<td width="1%">
					<a title="{#PriceSt#}" href="javascript:void(0);" onclick="cp_pop('index.php?do=modules&action=modedit&mod=shop&moduleaction=staffel_preise&cp={$sess}&pop=1&Id={$i->Id}&KatId={$i->KatId}','980','740','1','edit_vars');">
					<img src="{$tpl_dir}/images/icon_staffel.gif" alt="" border="0" /></a>
				</td>

				<td width="1%">
					<a title="{#EditEsdDownloads#}" href="javascript:void(0);" onclick="cp_pop('index.php?do=modules&action=modedit&mod=shop&moduleaction=esd_downloads&cp={$sess}&pop=1&Id={$i->Id}&KatId={$i->KatId}','980','740','1','edit_vars');">
					<img src="{$tpl_dir}/images/icon_esd_download.gif" alt="" border="0" /></a>
				</td>

				<td width="1%">
					{if $i->comments > 0}
						<a title="{#EditCommentsR#}" href="javascript:void(0);" onclick="cp_pop('index.php?do=modules&action=modedit&mod=shop&moduleaction=edit_comments&cp={$sess}&pop=1&Id={$i->Id}','980','740','1','edit_comments');"><img src="{$tpl_dir}/images/icon_iscomment.gif" alt="" hspace="1" border="0" /></a>
					{else}
						<img src="{$tpl_dir}/images/icon_blank.gif" alt="" border="0" />
					{/if}
				</td>
			</tr>
		{/foreach}
	</table><br />

	<div class="second" style="padding:8px">
		{#ProductMarkedAction#}&nbsp;
		<select name="SubAction">
			<option value="nothing">---</option>
			<option value="close">{#ProductClose#}</option>
			<option value="open">{#ProductOpen#}</option>
			<option value="nothing"></option>
			<option value="del">{#ProductMassDelete#}</option>
		</select>
	</div><br />

	<button class="button" type="submit">{#ProductSave#}</button>
</form><br />

{if $page_nav}
	<br />
	{$page_nav}<br />
{/if}

{/strip}