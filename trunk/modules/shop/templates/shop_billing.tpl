<div class="grid_12">
	<div id="shopcontent">
		<div class="mod_shop_topnav">
		<h2 id="page-heading">{#ShopPaySite#}</h2>
		</div>

		{include file="$mod_dir/shop/templates/shop_bar.tpl"}

		<form name="process" class="tablebox" method="post" action="index.php">
			<input type="hidden" name="module" value="shop" />
			<input type="hidden" name="action" value="checkout" />
			<input type="hidden" name="send" value="1" />
			<input type="hidden" name="create_account" value="{$smarty.request.create_account}" />

			{if $errors}
				<div class="mod_shop_warn">
					<strong>{#ErrorsA#}</strong><br />
					<ul>
						{foreach from=$errors item=e}
							<li style="line-height:1.1em">{$e}</li>
						{/foreach}
					</ul>
		  </div>
			{/if}


<div class="grid_6 alpha">
						<!-- Таблица формы доставки товара -->
						<table width="100%">
       <thead>
        <tr>
          <th colspan="2" class="table-head">{#ShippingAdress#}<br /><small>{#ShopShippingAdress#}</small></th>
        </tr>
      </thead>


							<tr>
								<td valign="middle" nowrap="nowrap" class="mod_shop_basket_row">{#SSCompany#}</td>
								<td class="mod_shop_basket_row_right"><input name="billing_company" type="text" class="mod_shop_inputfields" style="width:130px" value="{$smarty.session.billing_company|default:$row->company|escape}" maxlength="75" /></td>
							</tr>
							<tr>
								<td valign="middle" nowrap="nowrap" class="mod_shop_basket_row">{#SSSect#}</td>
								<td class="mod_shop_basket_row_right"><input name="billing_company_reciever" type="text" class="mod_shop_inputfields" style="width:130px" value="{$smarty.session.billing_company_reciever|escape|default:''}" maxlength="35" /></td>
							</tr>
							<tr>
								<td valign="middle" nowrap="nowrap" class="mod_shop_basket_row">{#SSFirst#}</td>
								<td class="mod_shop_basket_row_right"><input name="billing_firstname" type="text" class="mod_shop_inputfields" style="width:130px" value="{$smarty.session.billing_firstname|default:$row->firstname|escape}" maxlength="35" /></td>
							</tr>
							<tr>
								<td valign="middle" nowrap="nowrap" class="mod_shop_basket_row">{#SSLAst#}</td>
								<td class="mod_shop_basket_row_right"><input name="billing_lastname" type="text" class="mod_shop_inputfields" style="width:130px" value="{$smarty.session.billing_lastname|default:$row->lastname|escape}" maxlength="35" /></td>
							</tr>
							<tr>
								<td valign="middle" nowrap="nowrap" class="mod_shop_basket_row">{#SSStreet#}/{#SSHnr#}</td>
								<td class="mod_shop_basket_row_right">
									<input name="billing_street" type="text" class="mod_shop_inputfields" style="width:130px" value="{$smarty.session.billing_street|default:$row->street|escape}" maxlength="35" />
									<input name="billing_streetnumber" type="text" class="mod_shop_inputfields" style="width:40px" value="{$smarty.session.billing_streetnumber|default:$row->street_nr|escape}" maxlength="10" />
								</td>
							</tr>
							<tr>
								<td valign="middle" nowrap="nowrap" class="mod_shop_basket_row">{#SSZip#}/{#SSTown#}</td>
								<td class="mod_shop_basket_row_right">
									<input name="billing_zip" type="text" class="mod_shop_inputfields" style="width:40px" value="{$smarty.session.billing_zip|default:$row->zipcode|escape}" maxlength="15" />
									<input name="billing_town" type="text" class="mod_shop_inputfields" style="width:130px" value="{$smarty.session.billing_town|default:$row->city|escape}" maxlength="25" />
								</td>
							</tr>
							<tr>
								<td valign="middle" nowrap="nowrap" class="mod_shop_basket_row">{#SSEmail#}</td>
								<td class="mod_shop_basket_row_right"><input name="OrderEmail" type="text" class="mod_shop_inputfields" style="width:130px" value="{$smarty.session.OrderEmail|default:$row->email|escape}" maxlength="35" /></td>
							</tr>
							<tr>
								<td valign="middle" nowrap="nowrap" class="mod_shop_basket_row">{#SSPhone#}</td>
								<td class="mod_shop_basket_row_right"><input name="OrderPhone" type="text" class="mod_shop_inputfields" style="width:130px" value="{$smarty.session.OrderPhone|default:$row->phone|escape}" maxlength="35" /></td>
							</tr>
							<tr>
								<td valign="middle" nowrap="nowrap" class="mod_shop_basket_row">{#SSCountry#}</td>
								<td class="mod_shop_basket_row_right">
								{assign var=sl value=$smarty.request.country|upper|default:''}
								<select name="country" id="l_land" style="width:180px" class="mod_shop_inputfields" onchange="document.process.submit();">
									<option value="">Выберите страну </option>
									{foreach from=$available_countries item=land}
										{if in_array($land->country_code|upper,$shippingCountries)}
											<option value="{$land->country_code|upper}"{if $sl==$land->country_code|upper} selected{/if}>{$land->country_name}</option>
										{/if}
									{/foreach}
								</select>
								</td>
							</tr>
						</table>

</div>
<div class="grid_6 omega">

						<!-- Таблица формы доставки счета -->
						<table width="100%" border="0" cellpadding="3" cellspacing="1" class="mod_shop_basket_table">
       <thead>
        <tr>
          <th colspan="2" class="table-head">{#BillAdress#}<br /><small>{#ShopBillingAdress#}</small></th>
        </tr>
      </thead>
							<tr>
								<td valign="middle" nowrap="nowrap" class="mod_shop_basket_row">{#SSCompany#}</td>
								<td class="mod_shop_basket_row_right"><input class="mod_shop_inputfields" name="shipping_company" type="text" style="width:130px" value="{$smarty.session.shipping_company|escape|default:''}" /></td>
							</tr>
							<tr>
								<td valign="middle" nowrap="nowrap" class="mod_shop_basket_row">{#SSSect#}</td>
								<td class="mod_shop_basket_row_right"><input class="mod_shop_inputfields" name="shipping_company_reciever" type="text" style="width:130px" value="{$smarty.session.shipping_company_reciever|escape|default:''}" /></td>
							</tr>
							<tr>
								<td valign="middle" nowrap="nowrap" class="mod_shop_basket_row">{#SSFirst#}</td>
								<td class="mod_shop_basket_row_right"><input class="mod_shop_inputfields" name="shipping_firstname" type="text" style="width:130px" value="{$smarty.session.shipping_firstname|escape|default:''}" /></td>
							</tr>
							<tr>
								<td valign="middle" nowrap="nowrap" class="mod_shop_basket_row">{#SSLAst#}</td>
								<td class="mod_shop_basket_row_right"><input class="mod_shop_inputfields" name="shipping_lastname" type="text" style="width:130px" value="{$smarty.session.shipping_lastname|escape|default:''}" /></td>
							</tr>
							<tr>
								<td valign="middle" nowrap="nowrap" class="mod_shop_basket_row">{#SSStreet#}/{#SSHnr#}</td>
								<td class="mod_shop_basket_row_right">
									<input class="mod_shop_inputfields" name="shipping_street" type="text" style="width:130px" value="{$smarty.session.shipping_street|escape|default:''}" />
									<input class="mod_shop_inputfields" name="shipping_streetnumber" type="text" style="width:40px" value="{$smarty.session.shipping_streetnumber|escape|default:''}" />
								</td>
							</tr>
							<tr>
								<td valign="middle" nowrap="nowrap" class="mod_shop_basket_row">{#SSZip#}/{#SSTown#}</td>
								<td class="mod_shop_basket_row_right">
									<input class="mod_shop_inputfields" name="shipping_zip" type="text" style="width:40px" value="{$smarty.session.shipping_zip|escape|default:''}" />
									<input class="mod_shop_inputfields" name="shipping_city" type="text" style="width:130px" value="{$smarty.session.shipping_city|escape|default:''}" />
								</td>
							</tr>
							<tr>
								<td valign="middle" nowrap="nowrap" class="mod_shop_basket_row">{#SBCountry#}</td>
								<td class="mod_shop_basket_row_right">
									{assign var=Rsl value=$smarty.request.RLand|upper|default:''}
									<select name="RLand" id="ll_land" class="mod_shop_inputfields" style="width:180px">
										<option value="">Выберите страну </option>
										{foreach from=$available_countries item=land}
											{if in_array($land->country_code|upper,$shippingCountries)}
												<option value="{$land->country_code|upper}"{if $Rsl==$land->country_code|upper} selected{/if}>{$land->country_name}</option>
											{/if}
										{/foreach}
									</select>
								</td>
							</tr>
						</table>
</div>

			<!-- Таблица формы метода оплаты -->
			<table width="100%" class="tablebox">
       <thead>
        <tr>
          <th colspan="4" class="table-head">{#PleaseSelShippingMethod#}</th>
        </tr>
				{if $showShipper}
					{assign var=showPaymethods value=1}

					<tr>
						<th width="5" >&nbsp;</th>
						<th width="250" align="left" >{#Shippingmethod#}</th>
					  <th width="150" align="left" >{#Shippingcost#}</th>
						<th align="left" >{#Description#}</th>
					</tr>
      </thead>

					{foreach from=$showShipper item=ss}
						<tr>
							<td><input class="absmiddle" style="cursor:pointer" onclick="document.process.submit();" type="radio" name="ShipperId[]" value="{$ss->Id}" {if $smarty.session.ShipperId==$ss->Id}checked{/if}></td>
							<td><strong>{$ss->Name}</strong></td>
							<td>{if $smarty.request.ShippingSumm=='0' || $ss->cost=='0.00'}{#Free#}{else}{num_format val=$ss->cost} {$Currency}{if $ss->is_pauschal==1} {#Pauschal#}{/if}{/if}</td>
							<td><a class="tooltip" title="{$ss->description|escape}" href="javascript:void(0);">{#OpenDescWindow#}</a></td>
						</tr>
					{/foreach}

				{elseif $si_count < 1 && $smarty.post.country != ''}
					<tr>
						<td valign="top" colspan="4" class="mod_shop_basket_row">
							<div class="mod_shop_warn">{#WarningNoMethodFor#}</div>&gt;&gt; <a href="index.php?module=shop&action=showbasket">{#LinkToBasket#}</a>
						</td>
					</tr>

				{else}
					<tr>
						<td valign="top" colspan="4" class="mod_shop_basket_row">{#InfoShippingMethod#}</td>
					</tr>
				{/if}
			</table>

			<!-- Таблица формы метода оплаты -->
			<table width="100%" border="0" cellpadding="3" cellspacing="1" class="mod_shop_basket_table">
       <thead>
        <tr>
          <th colspan="4" class="table-head">{#InfoSelPayMethod#}</th>
        </tr>

				{if !$PaymentMethods}
					{assign var=NoVa value=1}
					<tr>
						<td valign="top" colspan="4" class="mod_shop_basket_row" >{#WarningFirstSMethod#}</td>
					</tr>
				{/if}

				{if $showPaymethods==1}
					{if $PaymentMethods}
						{assign var=ReadyToSell value=1}
						<tr>
							<th width="5"  align="left">&nbsp;</th>
							<th width="250"  align="left">{#PayMethod#}</th>
							<th width="150" align="left"> {#Cost#} </th>
							<th  align="left">{#Description#}</th>
						</tr>
                        </thead>
						{foreach from=$PaymentMethods item=ss}
							<tr>
								<td class="mod_shop_basket_row_right">
									{if $smarty.session.PaymentId==$ss->Id}{assign var=FormSend value=1}{/if}
									<input class="absmiddle" style="cursor:pointer" onclick="document.process.submit();" type="radio" name="PaymentId[]" value="{$ss->Id}" {if $smarty.session.PaymentId==$ss->Id}checked{/if}>
								</td>
								<td class="mod_shop_basket_row"><strong>{$ss->Name|escape}</strong></td>
								<td class="mod_shop_basket_row">{if $ss->Kosten=='0.00'}{#Free#}{else}{num_format val=$ss->Kosten} {if $ss->KostenOperant=='%'}%{else}{$Currency}{/if}{/if}</td>
								<td class="mod_shop_basket_row">
									<a href="javascript:void(0);"onclick="popup('index.php?module=shop&action=PaymentInfo&pop=1&theme_folder={$theme_folder}&payid={$ss->Id}','comment','500','400','1')">{#OpenDescWindow#}</a>
								</td>
							</tr>
						{/foreach}

					{else}
						{if $smarty.session.PaymentId!=''}
							<tr>
								<td valign="top" colspan="4" class="mod_shop_basket_row">
									<div class="mod_shop_warn">{#WarningNoPayMethodFor#}</div>
								</td>
							</tr>
						{/if}
					{/if}

				{elseif $smarty.session.PaymentId=='' || $si_count < 1 || $smarty.request.ShipperId==''}
					{if $NoVa != 1}
						<div class="mod_shop_basket_table">{#WarningFirstSMethod#}</div>
					{/if}
				{/if}
		  </table>
			<input class="absmiddle" type="image" src="{$shop_images}refresh.gif" />
			{if $showPaymethods == '1' && $ReadyToSell == '1' && $smarty.session.PaymentId != '' && $FormSend==1}
				<input type="hidden" name="zusammenfassung" id="zus" value="" />
				<input onclick="document.getElementById('zus').value='1'" class="absmiddle" type="image" src="{$shop_images}sendorder.gif" />
			{/if}
		</form>
	</div>
<br />

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