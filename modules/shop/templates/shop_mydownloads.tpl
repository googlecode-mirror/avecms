{strip}
<!-- shop_mydownloads.tpl -->
<div id="content">
	<h2 id="page-heading">{#DownloadsOverviewShowLink#}</h2>
	{#DownloadsOverviewInf#}<br />
	<br />

	<ul>
		{foreach from=$downloads item=dl name=d}
			<li>
				<div>
					<div class="mod_faq_quest" onclick="show_hide_text(this)">{$dl->ArtName|stripslashes}</div>
					<div class ="mod_faq_ans" style="display:none">
						<table width="100%" class="mod_shop_basket_table" border="0" cellpadding="0" cellspacing="1">
							<tr>
								<td width="200" valign="top" class="mod_shop_basket_header">{#DownloadsFilename#}</td>
								<td valign="top" class="mod_shop_basket_header">{#DownloadsFileDownloadTill#}</td>
								<td valign="top" class="mod_shop_basket_header">{#DownloadsFileSize#}</td>
								<td valign="top" class="mod_shop_basket_header">&nbsp;</td>
							</tr>

							{if $dl->DataFiles}
								<tr>
									<td colspan="4" class="mod_shop_basket_header"><h3>{#DownloadsTypeFull#}</h3></td>
								</tr>
							{/if}

							{foreach from=$dl->DataFiles item=df}
								<tr>
									<td width="200" valign="top" class="mod_shop_basket_row">
										{if $df->Abgelaufen==1}
											{$df->Titel|stripslashes}
										{else}
											<strong>
												<a {if $df->Beschreibung}title="{$df->Beschreibung|escape}"{/if} href="index.php?module=shop&action=mydownloads&sub=getfile&Id={$df->Id}&FileId={$dl->ArtikelId}&getId={$df->Id}">{$df->Titel|stripslashes}</a>
											</strong>
										{/if}
									</td>

									<td class="mod_shop_basket_row">{$dl->DownloadBis|date_format:$config_vars.DateFormatEsdTill}</td>
									<td class="mod_shop_basket_row">{$df->size} kb</td>
									<td align="right" class="mod_shop_basket_row">
										<a href="index.php?module=shop&action=mydownloads&sub=getfile&Id={$df->Id}&FileId={$dl->ArtikelId}&getId={$df->Id}"><img src="{$shop_images}download.gif" alt="" border="0" /></a>
									</td>
								</tr>
							{/foreach}

							{if $dl->DataFilesUpdates}
								<tr>
									<td colspan="4" class="mod_shop_basket_header"><h3>{#DownloadsTypeUpdates#}</h3></td>
								</tr>
							{/if}

							{foreach from=$dl->DataFilesUpdates item=df}
								<tr>
									<td width="200" valign="top" class="mod_shop_basket_row"> <strong> <a {if $df->Beschreibung}title="{$df->Beschreibung|escape}"{/if} href="index.php?module=shop&action=mydownloads&sub=getfile&Id={$df->Id}&FileId={$dl->ArtikelId}&getId={$df->Id}">{$df->Titel}</a></strong></td>
									<td class="mod_shop_basket_row">{$dl->DownloadBis|date_format:$config_vars.DateFormatEsdTill}</td>
									<td class="mod_shop_basket_row">{$df->size} kb</td>
									<td align="right" class="mod_shop_basket_row"> <a href="index.php?module=shop&action=mydownloads&sub=getfile&Id={$df->Id}&FileId={$dl->ArtikelId}&getId={$df->Id}"><img src="{$shop_images}download.gif" alt="" border="0" /></a> </td>
								</tr>
							{/foreach}

							{if $dl->DataFilesBugfixes}
								<tr>
									<td colspan="4" class="mod_shop_basket_header"><h3>{#DownloadsTypeBugfix#}</h3></td>
								</tr>
							{/if}

							{foreach from=$dl->DataFilesBugfixes item=df}
								<tr>
									<td width="200" valign="top" class="mod_shop_basket_row"> <strong> <a {if $df->Beschreibung}title="{$df->Beschreibung|escape}"{/if} href="index.php?module=shop&action=mydownloads&sub=getfile&Id={$df->Id}&FileId={$dl->ArtikelId}&getId={$df->Id}">{$df->Titel}</a></strong></td>
									<td class="mod_shop_basket_row">{$dl->DownloadBis|date_format:$config_vars.DateFormatEsdTill}</td>
									<td class="mod_shop_basket_row">{$df->size} kb</td>
									<td align="right" class="mod_shop_basket_row"> <a href="index.php?module=shop&action=mydownloads&sub=getfile&Id={$df->Id}&FileId={$dl->ArtikelId}&getId={$df->Id}"><img src="{$shop_images}download.gif" alt="" border="0" /></a> </td>
								</tr>
							{/foreach}

							{if $dl->DataFilesOther}
								<tr>
									<td colspan="4" class="mod_shop_basket_header"><h3>{#DownloadsTypeOther#}</h3></td>
								</tr>
							{/if}

							{foreach from=$dl->DataFilesOther item=df}
								<tr>
									<td width="200" valign="top" class="mod_shop_basket_row"> <strong> <a {if $df->Beschreibung}title="{$df->Beschreibung|escape}"{/if} href="index.php?module=shop&action=mydownloads&sub=getfile&Id={$df->Id}&FileId={$dl->ArtikelId}&getId={$df->Id}">{$df->Titel}</a></strong></td>
									<td class="mod_shop_basket_row">Без ограничений</td>
									<td class="mod_shop_basket_row">{$df->size} kb</td>
									<td align="right" class="mod_shop_basket_row"> <a href="index.php?module=shop&action=mydownloads&sub=getfile&Id={$df->Id}&FileId={$dl->ArtikelId}&getId={$df->Id}"><img src="{$shop_images}download.gif" alt="" border="0" /></a> </td>
								</tr>
							{/foreach}
						</table>
					</div>
				</div>
			</li>
		{/foreach}
	</ul>
</div>

{if $smarty.request.print!=1}
	<div class="leftnavi" >
		{$ShopNavi}
		<div style="clear:both"></div>
		{$Search}
		{$Basket}
		{$UserPanel}
		{$MyOrders}
		{$Topseller}
		{$InfoBox}
	</div>
{/if}
<div style="clear:both"></div>
<!-- /shop_mydownloads.tpl -->
{/strip}