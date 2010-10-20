
<script language="javascript">
function OrderPrint(id){ldelim}
	var html=document.getElementById(id).innerHTML;
	html=html.replace(/&lt;/gi, '<');
	html=html.replace(/&gt;/gi, '>');
	html=html.replace(/&amp;/gi, '&');
	var pFenster = window.open('', null, 'height=600,width=780,toolbar=yes,location=yes,status=yes,menubar=yes,scrollbars=yes,resizable=yes');
	var HTML = '<body onload="print();">'+html;
	pFenster.document.write(HTML);
	pFenster.document.close();
{rdelim}
</script>

<div class="grid_12">
	<div class="mod_shop_topnav">
		<a class="mod_shop_navi" href="{$ShopStartLink}">{#PageName#}</a> {#PageSep#} {#OrderOkNav#}
	</div>
	{include file="$mod_dir/shop/templates/shop_bar.tpl"}<br />
	<br />
	<h2 id="page-heading">{#OrderPrintM1#}</h2>
	<p>
		{#OrderPrintM2#}<br />
		<br />
		<div id="{$smarty.session.TransId}" style="display:none">{$innerhtml}</div>
		&gt;&gt; <a href="javascript:OrderPrint('{$smarty.session.TransId}');">{#OrderPrint#}</a>
	</p>

	<!-- FOOTER -->
	{$FooterText}
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
