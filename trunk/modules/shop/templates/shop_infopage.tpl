<div class="grid_12">
	<!-- SHOP - TOP NAVI -->
	{$Inf}

	<!-- FOOTER -->
	{$FooterText}
</div>

 {if $smarty.request.print!=1}
<div class="grid_4">
 <!-- ������ ���� -->
    <div class="box menu">
      <h2><a href="#" id="toggle-section-menu">������� �������</a></h2>
      <div class="block" id="section-menu">{$ShopNavi}</div>
    </div>

  <!-- ���� ����������� -->
    <div class="box">
      <h2> <a href="#" id="toggle-login-forms">�����������</a> </h2>
      <div class="block" id="login-forms">{$UserPanel}</div>
    </div>

  <!-- ���� ������ �� �������� -->
    <div class="box">
      <h2><a href="#" id="toggle-shop-search">����� �������</a></h2>
      <div class="block" id="shop-search">{$Search}</div>
    </div>

  <!-- ���� ������� -->
    <div class="box">
      <h2><a href="#" id="toggle-shopbasket">�������</a></h2>
      <div class="block" id="shopbasket">{$Basket}</div>
    </div>

  <!-- ���� ������������ ������� -->
    <div class="box">
      <h2><a href="#" id="toggle-myordersbox">��� ������</a></h2>
      <div class="block" id="myordersbox">{$MyOrders}</div>
    </div>

  <!-- ���� ���������� -->
    <div class="box">
      <h2><a href="#" id="toggle-shopinfobox">����������</a></h2>
      <div class="block" id="shopinfobox">{$InfoBox}</div>
    </div>

  <!-- ���� ���������� ������� -->
    <div class="box">
      <h2><a href="#" id="toggle-shoppopprods">���������� ������</a></h2>
      <div class="block" id="shoppopprods">{$Topseller}</div>
    </div>
</div>
{/if}