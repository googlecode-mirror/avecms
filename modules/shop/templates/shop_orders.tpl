
<script language="javascript">
function print_container(id,act) {ldelim}
	var html=document.getElementById(id).innerHTML;
	html=html.replace(/&lt;/gi, '<');
	html=html.replace(/&gt;/gi, '>');
	var act=(act=='preform') ? '<pre>' : '';
	var pFenster=window.open('', null, 'height=600,width=780,toolbar=yes,location=yes,status=yes,menubar=yes,scrollbars=yes,resizable=yes') ;
	var HTML='<html><head></head><body style="font-family:arial,verdana;font-size:12px" onload="window.print()">'+act+html+'</body></html>' ;
	pFenster.document.write(HTML);
	pFenster.document.close();
{rdelim}

function request(id) {ldelim}
	var text='{#OrderRequestText#}';
	text=text.replace(/%%ORDER%%/gi, id);
	text=text.replace(/%%USER%%/gi, '{$smarty.session.user_name}');
	document.getElementById('request').style.display='';
	document.getElementById('request_subject').value='{#OrdersRequestSubject#} '+id;
	document.getElementById('request_text').value=text;
{rdelim}
</script>

<div class="grid_12">
	<h2 id="page-heading">{#MyOrders#}</h2>

	{if $orderRequestOk==1}
		{#OrderOverviewActionRequestOk#}<br />
		<br />
	{/if}

	<div style="display:none" id="request">
		<form method="post" action="index.php?module=shop&action=myorders&sub=request">
			<table width="100%" border="0" cellspacing="1" cellpadding="4" class="mod_shop_orders_form">
				<tr>
					<td>
						<strong>{#OrderRequestSubject#}</strong><br />
						<input class="mod_shop_inputfields" id="request_subject" type="text" name="subject" style="width:97%" />
					</td>
				</tr>

				<tr>
					<td>
						<strong>{#OrderRequestMessage#}</strong><br />
						<textarea class="mod_shop_inputfields" id="request_text" name="text" rows="5" style="width:97%"></textarea><br />
						<br />
						<input type="submit" class="button" value="{#OrderRequestSend#}">
					</td>
				</tr>
			</table><br />
		</form>
	</div>

	<table width="100%" class="mod_shop_basket_table" border="0" cellpadding="0" cellspacing="1">
		<tr>
			<td class="mod_shop_basket_header" width="130"><strong>{#OrderOverviewOrderdate#}</strong></td>
			<td class="mod_shop_basket_header" width="120" align="right"><strong>{#OrderOverviewSumm#}</strong></td>
			<td class="mod_shop_basket_header" align="center"><strong>{#OrderOverviewStatus#}</strong></td>
			<td class="mod_shop_basket_header"><strong>{#OrderOverviewAction#}</strong></td>
		</tr>

		{foreach from=$my_orders item=mo}
			<tr>
				<td class="mod_shop_basket_row">{$mo->Datum|date_format:"%d.%m.%Y %H:%M"}</td>
				<td class="mod_shop_basket_row" align="right">{num_format val=$mo->Gesamt} {$Currency}</td>
				<td class="mod_shop_basket_row" align="center"><span class="mod_shop_orders_{$mo->Status}">&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
				<td class="mod_shop_basket_row">
					<textarea style="display:none" id="h_{$mo->Id}">{$mo->RechnungHtml|addslashes}</textarea>
					<textarea style="display:none" id="t_{$mo->Id}">{$mo->RechnungText|addslashes}</textarea>
					<a href="javascript:print_container('h_{$mo->Id}');">{#OrderOverviewActionPrint#}</a> |&nbsp;
					<a href="#" onclick="request('{$mo->TransId}')">{#OrderOverviewActionRequest#}</a>
				</td>
			</tr>
		{/foreach}
	</table><br />

	<span class="mod_shop_orders_wait">&nbsp;&nbsp;&nbsp;&nbsp;</span> {#OrdersStatusWait#}<br />
	<span class="mod_shop_orders_progress">&nbsp;&nbsp;&nbsp;&nbsp;</span> {#OrdersStatusProgress#}<br />
	<span class="mod_shop_orders_ok">&nbsp;&nbsp;&nbsp;&nbsp;</span> {#OrdersStatusOk#}<br />
	<span class="mod_shop_orders_ok_send">&nbsp;&nbsp;&nbsp;&nbsp;</span> {#OrdersStatusOkSend#}<br />
	<span class="mod_shop_orders_failed">&nbsp;&nbsp;&nbsp;&nbsp;</span> {#OrdersStatusFailed#}
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
