
<div class="grid_12">
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

								{foreach from=$dl->DataFiles item=df}
									<tr>
										<td width="200" valign="top" class="mod_shop_basket_row">
											{if $df->Abgelaufen==1}
												{$df->title|stripslashes}
											{else}
												<strong>
													<a {if $df->description}title="{$df->description|escape}"{/if} href="{$df->link}">{$df->title|stripslashes}</a>
												</strong>
											{/if}
										</td>

										<td class="mod_shop_basket_row">{$dl->DownloadBis|date_format:#DateFormatEsdTill#}</td>
										<td class="mod_shop_basket_row">{$df->size} kb</td>
										<td align="right" class="mod_shop_basket_row">
											<a href="{$df->link}"><img src="{$shop_images}download.gif" alt="" border="0" /></a>
										</td>
									</tr>
								{/foreach}
							{/if}

							{if $dl->DataFilesUpdates}
								<tr>
									<td colspan="4" class="mod_shop_basket_header"><h3>{#DownloadsTypeUpdates#}</h3></td>
								</tr>

								{foreach from=$dl->DataFilesUpdates item=df}
									<tr>
										<td width="200" valign="top" class="mod_shop_basket_row">
											<strong>
												<a {if $df->description}title="{$df->description|escape}"{/if} href="{$df->link}">{$df->title}</a>
											</strong>
										</td>
										<td class="mod_shop_basket_row">{$dl->DownloadBis|date_format:#DateFormatEsdTill#}</td>
										<td class="mod_shop_basket_row">{$df->size} kb</td>
										<td align="right" class="mod_shop_basket_row">
											<a href="{$df->link}"><img src="{$shop_images}download.gif" alt="" border="0" /></a>
										</td>
									</tr>
								{/foreach}
							{/if}

							{if $dl->DataFilesBugfixes}
								<tr>
									<td colspan="4" class="mod_shop_basket_header"><h3>{#DownloadsTypeBugfix#}</h3></td>
								</tr>

								{foreach from=$dl->DataFilesBugfixes item=df}
									<tr>
										<td width="200" valign="top" class="mod_shop_basket_row">
											<strong>
												<a {if $df->description}title="{$df->description|escape}"{/if} href="{$df->link}">{$df->title}</a>
											</strong>
										</td>
										<td class="mod_shop_basket_row">{$dl->DownloadBis|date_format:#DateFormatEsdTill#}</td>
										<td class="mod_shop_basket_row">{$df->size} kb</td>
										<td align="right" class="mod_shop_basket_row">
											<a href="{$df->link}"><img src="{$shop_images}download.gif" alt="" border="0" /></a>
										</td>
									</tr>
								{/foreach}
							{/if}

							{if $dl->DataFilesOther}
								<tr>
									<td colspan="4" class="mod_shop_basket_header"><h3>{#DownloadsTypeOther#}</h3></td>
								</tr>

								{foreach from=$dl->DataFilesOther item=df}
									<tr>
										<td width="200" valign="top" class="mod_shop_basket_row">
											<strong>
												<a {if $df->description}title="{$df->description|escape}"{/if} href="{$df->link}">{$df->title}</a>
											</strong>
										</td>
										<td class="mod_shop_basket_row">Без ограничений</td>
										<td class="mod_shop_basket_row">{$df->size} kb</td>
										<td align="right" class="mod_shop_basket_row">
											<a href="{$df->link}"><img src="{$shop_images}download.gif" alt="" border="0" /></a>
										</td>
									</tr>
								{/foreach}
							{/if}
						</table>
					</div>
				</div>
			</li>
		{/foreach}
	</ul>
</div>

{if $smarty.request.print!=1}
	<div class="grid_4">
		<!-- Правое меню -->
		<div class="box menu">
			<h2><a href="#" id="toggle-section-menu">{#ProductOverview#}</a></h2>
			<div class="block" id="section-menu">{$ShopNavi}</div>
		</div>

		<!-- Блок авторизации -->
		<div class="box">
			<h2> <a href="#" id="toggle-login-forms">{#UserPanel#}</a> </h2>
			<div class="block" id="login-forms">{$UserPanel}</div>
		</div>

		<!-- Блок поиска по магазину -->
		<div class="box">
			<h2><a href="#" id="toggle-shop-search">{#ProductSearch#}</a></h2>
			<div class="block" id="shop-search">{$Search}</div>
		</div>

		<!-- Блок корзины -->
		<div class="box">
			<h2><a href="#" id="toggle-shopbasket">{#ShopBasket#}</a></h2>
			<div class="block" id="shopbasket">{$Basket}</div>
		</div>

		{if $smarty.session.user_id}
			<!-- Блок обработанных заказов -->
			<div class="box">
				<h2><a href="#" id="toggle-myordersbox">{#MyOrders#}</a></h2>
				<div class="block" id="myordersbox">{$MyOrders}</div>
			</div>
		{/if}

		<!-- Блок информации -->
		<div class="box">
			<h2><a href="#" id="toggle-shopinfobox">{#Infopage#}</a></h2>
			<div class="block" id="shopinfobox">{$InfoBox}</div>
		</div>

		<!-- Блок популярных товаров -->
		<div class="box">
			<h2><a href="#" id="toggle-shoppopprods">{#Topseller#}</a></h2>
			<div class="block" id="shoppopprods">{$Topseller}</div>
		</div>
	</div>
{/if}
