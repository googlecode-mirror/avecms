
<script language="javascript">
function print_container(id) {ldelim}
	var html = document.getElementById(id).innerHTML;
	html = html.replace(/&lt;/gi, '<');
	html = html.replace(/&gt;/gi, '>');
	var pFenster = window.open('', null, 'height=600,width=780,toolbar=yes,location=yes,status=yes,menubar=yes,scrollbars=yes,resizable=yes');
	var HTML = '<html><head></head><body style="font-family:arial,verdana;font-size:12px" onload="window.print()">'+html+'</body></html>';
	pFenster.document.write(HTML);
	pFenster.document.close();
{rdelim}
function request(id) {ldelim}
	var text = '{#OrderRequestText#}';
	text = text.replace(/%%ORDER%%/gi, id);
	text = text.replace(/%%USER%%/gi, '{$smarty.session.user_name|escape:"javascript"}');
	document.getElementById('request').style.display = '';
	document.getElementById('request_subject').value = '{#OrdersRequestSubject#} '+id;
	document.getElementById('request_text').value = text;
{rdelim}
</script>

<div class="grid_12 tablebox">
	<h2 id="page-heading">{#MyOrders#}</h2>

	{if $orderRequestOk==1}
		{#OrderOverviewActionRequestOk#}<br />
		<br />
	{/if}

	<form style="display:none" id="request" method="post" action="index.php?module=shop&action=myorders&sub=request">
		<fieldset>
			<p>
				<label>{#OrderRequestSubject#}</label>
				<input id="request_subject" type="text" name="subject" style="width:99%" />
			</p>
			<p>
				<label>{#OrderRequestMessage#}</label>
				<textarea id="request_text" name="text" rows="5" style="width:99%"></textarea>
			</p>
			<input type="submit" class="confirm button" value="{#OrderRequestSend#}">
		</fieldset>
	</form>

	<table width="100%" border="1">
		<thead>
			<tr>
				<th>{#OrderOverviewOrderdate#}</th>
				<th>{#OrderOverviewSumm#}</th>
				<th>{#OrderOverviewStatus#}</th>
				<th>{#OrderOverviewAction#}</th>
			</tr>
		</thead>

		<tbody>
			{foreach from=$my_orders item=mo}
				<tr class="odd">
					<td>{$mo->Datum|date_format:$TIME_FORMAT|pretty_date}</td>
					<td align="right">{num_format val=$mo->Gesamt} {$Currency}</td>
					<td align="center"><span class="mod_shop_orders_{$mo->Status}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
					<td align="center">
						<textarea style="display:none" id="h_{$mo->Id}">{$mo->RechnungHtml}</textarea>
						<textarea style="display:none" id="t_{$mo->Id}">{$mo->RechnungText}</textarea>
						<a href="javascript:print_container('h_{$mo->Id}');">{#OrderOverviewActionPrint#}</a> |&nbsp;
						<a href="javascript:void(0);" onclick="request('{$mo->TransId}')">{#OrderOverviewActionRequest#}</a>
					</td>
				</tr>
			{/foreach}
		</tbody>
	</table>

	<span class="mod_shop_orders_wait">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> {#OrdersStatusWait#}<br />
	<span class="mod_shop_orders_progress">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> {#OrdersStatusProgress#}<br />
	<span class="mod_shop_orders_ok">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> {#OrdersStatusOk#}<br />
	<span class="mod_shop_orders_ok_send">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> {#OrdersStatusOkSend#}<br />
	<span class="mod_shop_orders_failed">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> {#OrdersStatusFailed#}
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
