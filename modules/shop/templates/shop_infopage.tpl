<div class="grid_12">
	<!-- SHOP - TOP NAVI -->
	{$Inf}

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

  <!-- Блок популярных товаров -->
    <div class="box">
      <h2><a href="#" id="toggle-shoppopprods">Популярные товары</a></h2>
      <div class="block" id="shoppopprods">{$Topseller}</div>
    </div>
</div>
{/if}