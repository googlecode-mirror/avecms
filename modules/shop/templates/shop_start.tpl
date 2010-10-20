
<div class="grid_12">
	{if $smarty.request.categ==''}
		<!-- Всупительное слово -->
		{if $ShopWillkommen}
			{$ShopWillkommen}
		{/if}

		<!-- Презентация -->
		{$RandomOffer}

		{include file="$mod_dir/shop/templates/shop_tree_extended.tpl"}
	{/if}

	{if $KatName}
		<h2 id="page-heading">{$KatName}</h2>
		{$KatBeschreibung}<br />
		<hr />
	{/if}

	{if $smarty.request.categ!=''}
		{$RandomOfferKateg}
		{include file="$mod_dir/shop/templates/shop_tree.tpl"}
	{/if}

	<!-- SHOP - ITEMS -->
	{include file="$mod_dir/shop/templates/$TemplateArtikel"}
	<div class="clear"></div>

	<div class="tab-container">
		<div class="tab-header">
			<div class="tab-handle">Популярные товары</div>
			<div class="tab-handle">Специальное предложение</div>
			<div class="tab-handle">Поледние поступления</div>
		</div>

		<div class="tab-body">
			<div class="tab-body-element">
				<h3>Популярные товары</h3>
				<div class="mod_shop_newprod_box">
					<table width="100%" cellpadding="0" cellspacing="0">
						<tr>
							<td style="text-align:center;">
								<div class="mod_shop_newprod_box_container">
									<a title="" href="#"><img src="templates/ave/images/hp151111.jpg" alt="Canon Powershot G11" width="55" height="55"/></a>
								</div>
								<a title="" href="#">Canon Powershot G11</a><br />
								<span class="mod_shop_price_small">21.500 руб.</span>
							</td>
							<td style="text-align:center;">
								<div class="mod_shop_newprod_box_container">
									<a title="" href="#"><img src="templates/ave/images/hp151111.jpg" alt="Canon Powershot G11" width="55" height="55"/></a>
								</div>
								<a title="" href="#">Toshiba Satellite A300-148</a><br />
								<span class="mod_shop_price_small">45.400 руб.</span>
							</td>
							<td style="text-align:center;">
								<div class="mod_shop_newprod_box_container">
									<a title="" href="#"><img src="templates/ave/images/hp151111.jpg" alt="Canon Powershot G11" width="55" height="55"/></a>
								</div>
								<a title="" href="#">HP Compaq 530 FH524AA</a><br />
								<span class="mod_shop_price_small">37.500 руб.</span>
							</td>
							<td style="text-align:center;">
								<div class="mod_shop_newprod_box_container">
									<a title="" href="#"><img src="templates/ave/images/hp151111.jpg" alt="Canon Powershot G11" width="55" height="55"/></a>
								</div>
								<a title="" href="#">Acer Extensa 5220-200508Mi</a><br />
								<span class="mod_shop_price_small">1.550 руб.</span>
							</td>
							<td style="text-align:center;">
								<div class="mod_shop_newprod_box_container">
									<a title="" href="#"><img src="templates/ave/images/hp151111.jpg" alt="Canon Powershot G11" width="55" height="55"/></a>
								</div>
								<a title="" href="#">Canon Powershot G11</a><br />
								<span class="mod_shop_price_small">599 руб.</span>
							</td>
						</tr>
					</table>
				</div>
			</div>

			<div class="tab-body-element">
				<h3>Специальное предложение</h3>
				<div class="mod_shop_newprod_box">
					<table width="100%" cellpadding="0" cellspacing="0">
						<tr>
							<td style="text-align:center;">
								<div class="mod_shop_newprod_box_container">
									<a title="" href="#"><img src="templates/ave/images/hp151111.jpg" alt="Canon Powershot G11" width="55" height="55"/></a>
								</div>
								<a title="" href="#">Canon Powershot G11</a> <br />
								<strong>599,00 руб.</strong>
							</td>
							<td style="text-align:center;">
								<div class="mod_shop_newprod_box_container">
									<a title="" href="#"><img src="templates/ave/images/hp151111.jpg" alt="Canon Powershot G11" width="55" height="55"/></a>
								</div>
								<a title="" href="#">Canon Powershot G11</a> <br />
								<strong>599,00 руб.</strong>
							</td>
						</tr>
					</table>
				</div>
			</div>

			<div class="tab-body-element">
				<h3>Поледние поступления</h3>
				<div class="mod_shop_newprod_box">
					<table width="100%" cellpadding="0" cellspacing="0">
						<tr>
							<td style="text-align:center;">
								<div class="mod_shop_newprod_box_container">
									<a title="" href="#"><img src="templates/ave/images/hp151111.jpg" alt="Canon Powershot G11" width="55" height="55"/></a>
								</div>
								<a title="" href="#">Canon Powershot G11</a><br />
								<strong>599,00 руб.</strong>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="clear"></div>

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
