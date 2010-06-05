<div class="grid_12 tablebox">
	<h2 id="page-heading"> {#ShopPaySite#}</h2>
<div class="grid_4 alpha">
	<table>
       <thead>
		<tr>
			<th align="left" valign="top" class="table-head">{#PaymentNewCust#}</th>
		</tr>
		</thead>
		<tr>
			<td  height="130">{#PaymentRegNew#}</td>
		</tr>
       <tfoot>
		<tr>
			<td align="center" valign="middle">
				<a href="index.php?module=login&action=register"><img src="{$shop_images}register.gif" alt="{#PaymentRegNewLink#}" border="" /></a>
			</td>
		</tr>
        </tfoot>
	</table>
</div>
<div class="grid_4">
	<form method="post" action="index.php">
		<table>
       <thead>
			<tr>
				<th  align="left" valign="top" class="table-head">{#PaymentAllreadyCust#}</th>
			</tr>
       </thead>

			<tr>
				<td height="130">
					{#PaymentAllCust#}
					{if $login=='false'}
						<div class="mod_shop_warn">{#LoginFalse#}</div>
					{/if}

					<input name="module" value="login" type="hidden" />
					<input name="action" value="login" type="hidden" />
					<div style="margin: 4px 0 0 0; display: block;">
						<input tabindex="1" class="inputbox" name="user_login" type="text" style="width:180px" value="{#LOGIN_YOUR_EMAIL#}" onfocus="this.value=''" />
					</div>
					<div style="margin: 4px 0; display: block;">
						<input tabindex="2" type="password" class="inputbox" autocomplete="off" name="user_pass" style="width:180px" value="{#LOGIN_YOUR_PASSWORD#}" onfocus="this.value=''" />
					</div>
<input name="SaveLogin" style="margin: 0;" type="checkbox" id="SaveLogin" value="1" />
{#LOGIN_SAVE_COOKIE#}&nbsp;<a class="tooltip" title="{#LOGIN_SAVE_INFO#}" href="#">{#LOGIN_SAVE_ICON#}</a>
				</td>
			</tr>
       <tfoot>
			<tr>
				<td align="center" valign="middle" class="mod_shop_basket_row">
					<input class="absmiddle" type="image" src="{$shop_images}login.gif" alt="{#BLogin#}" />
				</td>
			</tr>
</tfoot>
		</table>
	</form>
</div>
<div class="grid_4 omega">
	{if $GastBestellung==1}
		<table>
       <thead>
			<tr>
				<th  align="left" valign="top" class="table-head">{#PaymentGuestTitle#}</th>
			</tr>
		</thead>
			<tr>
				<td height="130">{#PaymentGuest#}</td>
			</tr>
<tfoot>
			<tr>
				<td align="center" valign="middle" class="mod_shop_basket_row">
					<form method="post" action="index.php">
						<input type="hidden" name="module" value="shop" />
						<input type="hidden" name="action" value="checkout" />
						<input type="hidden" name="create_account" value="no" />
						<input class="absmiddle" type="image" src="{$shop_images}guest_order.gif" alt="{#PaymentGuestLink#}" />
					</form>
				</td>
			</tr>
</tfoot>
		</table>
	{/if}
</div>
<div class="clear"></div>
<hr/>
<!-- FOOTER -->
	{$FooterText}
</div>
{if $smarty.request.print!=1}
<div class="grid_4">
  <!-- Правое меню -->
    <div class="box menu">
      <h2><a href="#" id="toggle-section-menu">Каталог товаров</a></h2>
      <div class="block" id="section-menu">{$ShopNavi}</div>
    </div>

  <!-- Блок авторизации -->
    <div class="box">
      <h2> <a href="#" id="toggle-login-forms">Авторизация</a> </h2>
      <div class="block" id="login-forms">{$UserPanel}</div>
    </div>

  <!-- Блок поиска по магазину -->
    <div class="box">
      <h2><a href="#" id="toggle-shop-search">Поиск товаров</a></h2>
      <div class="block" id="shop-search">{$Search}</div>
    </div>

  <!-- Блок корзины -->
    <div class="box">
      <h2><a href="#" id="toggle-shopbasket">Корзина</a></h2>
      <div class="block" id="shopbasket">{$Basket}</div>
    </div>

  <!-- Блок обработанных заказов -->
    <div class="box">
      <h2><a href="#" id="toggle-myordersbox">Мои заказы</a></h2>
      <div class="block" id="myordersbox">{$MyOrders}</div>
    </div>

  <!-- Блок информации -->
    <div class="box">
      <h2><a href="#" id="toggle-shopinfobox">Информация</a></h2>
      <div class="block" id="shopinfobox">{$InfoBox}</div>
    </div>
</div>
{/if}