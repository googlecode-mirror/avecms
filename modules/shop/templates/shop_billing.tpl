<!-- shop_billing.tpl -->
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
								<td class="mod_shop_basket_row_right"><input name="billing_company" type="text" class="mod_shop_inputfields" style="width:130px" value="{if $smarty.session.billing_company}{$smarty.session.billing_company|escape}{else}{$row->Firma|escape}{/if}" maxlength="75" /></td>
							</tr>
							<tr>
								<td valign="middle" nowrap="nowrap" class="mod_shop_basket_row">{#SSSect#}</td>
								<td class="mod_shop_basket_row_right"><input name="billing_company_reciever" type="text" class="mod_shop_inputfields" style="width:130px" value="{if $smarty.session.billing_company_reciever}{$smarty.session.billing_company_reciever|escape}{/if}" maxlength="35" /></td>
							</tr>
							<tr>
								<td valign="middle" nowrap="nowrap" class="mod_shop_basket_row">{#SSFirst#}</td>
								<td class="mod_shop_basket_row_right"><input name="billing_firstname" type="text" class="mod_shop_inputfields" style="width:130px" value="{if $smarty.session.billing_firstname != ''}{$smarty.session.billing_firstname|stripslashes}{else}{$row->Vorname}{/if}" maxlength="35" /></td>
							</tr>
							<tr>
								<td valign="middle" nowrap="nowrap" class="mod_shop_basket_row">{#SSLAst#}</td>
								<td class="mod_shop_basket_row_right"><input name="billing_lastname" type="text" class="mod_shop_inputfields" style="width:130px" value="{if $smarty.session.billing_lastname != ''}{$smarty.session.billing_lastname|stripslashes}{else}{$row->Nachname}{/if}" maxlength="35" /></td>
							</tr>
							<tr>
								<td valign="middle" nowrap="nowrap" class="mod_shop_basket_row">{#SSStreet#}/{#SSHnr#}</td>
								<td class="mod_shop_basket_row_right">
									<input name="billing_street" type="text" class="mod_shop_inputfields" style="width:130px" value="{if $smarty.session.billing_street != ''}{$smarty.session.billing_street|stripslashes}{else}{$row->Strasse}{/if}" maxlength="35" />
									<input name="billing_streetnumber" type="text" class="mod_shop_inputfields" style="width:40px" value="{if $smarty.session.billing_streetnumber != ''}{$smarty.session.billing_streetnumber|stripslashes}{else}{$row->HausNr}{/if}" maxlength="10" />
								</td>
							</tr>
							<tr>
								<td valign="middle" nowrap="nowrap" class="mod_shop_basket_row">{#SSZip#}/{#SSTown#}</td>
								<td class="mod_shop_basket_row_right">
									<input name="billing_zip" type="text" class="mod_shop_inputfields" style="width:40px" value="{if $smarty.session.billing_zip != ''}{$smarty.session.billing_zip|stripslashes}{else}{$row->Postleitzahl}{/if}" maxlength="15" />
									<input name="billing_town" type="text" class="mod_shop_inputfields" style="width:130px" value="{if $smarty.session.billing_town != ''}{$smarty.session.billing_town|stripslashes}{else}{$row->city}{/if}" maxlength="25" />
								</td>
							</tr>
							<tr>
								<td valign="middle" nowrap="nowrap" class="mod_shop_basket_row">{#SSEmail#}</td>
								<td class="mod_shop_basket_row_right"><input name="OrderEmail" type="text" class="mod_shop_inputfields" style="width:130px" value="{if $smarty.session.OrderEmail != ''}{$smarty.session.OrderEmail|stripslashes}{else}{$row->Email}{/if}" maxlength="35" /></td>
							</tr>
							<tr>
								<td valign="middle" nowrap="nowrap" class="mod_shop_basket_row">{#SSPhone#}</td>
								<td class="mod_shop_basket_row_right"><input name="OrderPhone" type="text" class="mod_shop_inputfields" style="width:130px" value="{if $smarty.session.OrderPhone != ''}{$smarty.session.OrderPhone|stripslashes}{else}{$row->Telefon}{/if}" maxlength="35" /></td>
							</tr>
							<tr>
								<td valign="middle" nowrap="nowrap" class="mod_shop_basket_row">{#SSCountry#}</td>
								<td class="mod_shop_basket_row_right">
								{assign var=sl value=$smarty.request.Land|default:''|upper}
								<select name="Land" id="l_land" style="width:180px" class="mod_shop_inputfields" onchange="document.process.submit();">
									<option value="">Выберите страну </option>
									{foreach from=$available_countries item=land}
										{if in_array($land->LandCode|upper,$shippingCountries)}
											<option value="{$land->LandCode|upper}"{if $sl==$land->LandCode|upper} selected{/if}>{$land->LandName}</option>
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
								<td class="mod_shop_basket_row_right"><input class="mod_shop_inputfields" name="shipping_company" type="text" style="width:130px" value="{if $smarty.session.shipping_company != ''}{$smarty.session.shipping_company|escape}{else}{$row->company|escape}{/if}" /></td>
							</tr>
							<tr>
								<td valign="middle" nowrap="nowrap" class="mod_shop_basket_row">{#SSSect#}</td>
								<td class="mod_shop_basket_row_right"><input class="mod_shop_inputfields" name="shipping_company_reciever" type="text" style="width:130px" value="{if $smarty.session.shipping_company_reciever != ''}{$smarty.session.shipping_company_reciever|escape}{/if}" /></td>
							</tr>
							<tr>
								<td valign="middle" nowrap="nowrap" class="mod_shop_basket_row">{#SSFirst#}</td>
								<td class="mod_shop_basket_row_right"><input class="mod_shop_inputfields" name="shipping_firstname" type="text" style="width:130px" value="{if $smarty.session.shipping_firstname != ''}{$smarty.session.shipping_firstname|stripslashes}{else}{$row->name}{/if}" /></td>
							</tr>
							<tr>
								<td valign="middle" nowrap="nowrap" class="mod_shop_basket_row">{#SSLAst#}</td>
								<td class="mod_shop_basket_row_right"><input class="mod_shop_inputfields" name="shipping_lastname" type="text" style="width:130px" value="{if $smarty.session.shipping_lastname != ''}{$smarty.session.shipping_lastname|stripslashes}{else}{$row->lastname}{/if}" /></td>
							</tr>
							<tr>
								<td valign="middle" nowrap="nowrap" class="mod_shop_basket_row">{#SSStreet#}/{#SSHnr#}</td>
								<td class="mod_shop_basket_row_right">
									<input class="mod_shop_inputfields" name="shipping_street" type="text" style="width:130px" value="{if $smarty.session.shipping_street != ''}{$smarty.session.shipping_street|stripslashes}{else}{$row->street}{/if}" />
									<input class="mod_shop_inputfields" name="shipping_streetnumber" type="text" style="width:40px" value="{if $smarty.session.shipping_streetnumber != ''}{$smarty.session.shipping_streetnumber|stripslashes}{/if}" />
								</td>
							</tr>
							<tr>
								<td valign="middle" nowrap="nowrap" class="mod_shop_basket_row">{#SSZip#}/{#SSTown#}</td>
								<td class="mod_shop_basket_row_right">
									<input class="mod_shop_inputfields" name="shipping_zip" type="text" style="width:40px" value="{if $smarty.session.shipping_zip != ''}{$smarty.session.shipping_zip|stripslashes}{else}{$row->zip}{/if}" />
									<input class="mod_shop_inputfields" name="shipping_city" type="text" style="width:130px" value="{if $smarty.session.shipping_city != ''}{$smarty.session.shipping_city|stripslashes}{else}{$row->user_from}{/if}" />
								</td>
							</tr>
							<tr>
								<td valign="middle" nowrap="nowrap" class="mod_shop_basket_row">{#SBCountry#}</td>
								<td class="mod_shop_basket_row_right">
									{assign var=Rsl value=$smarty.request.RLand|default:''|upper}
									<select name="RLand" id="ll_land" class="mod_shop_inputfields" style="width:180px">
										<option value="">Выберите страну </option>
										{foreach from=$available_countries item=land}
											{if in_array($land->LandCode|upper,$shippingCountries)}
												<option value="{$land->LandCode|upper}"{if $Rsl==$land->LandCode|upper} selected{/if}>{$land->LandName}</option>
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
							<td>{if $smarty.request.ShippingSumm=='0' || $ss->cost=='0.00'}{#Free#}{else}{numFormat val=$ss->cost} {$Currency}{if $ss->is_pauschal==1} {#Pauschal#}{/if}{/if}</td>
							<td><a class="tooltip" title="{$ss->Beschreibung|stripslashes}" href="javascript:void(0);">{#OpenDescWindow#}</a></td>
						</tr>
					{/foreach}

				{elseif $si_count < 1 && $smarty.post.Land != ''}
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
								<td class="mod_shop_basket_row"><strong>{$ss->Name|stripslashes}</strong></td>
								<td class="mod_shop_basket_row">{if $ss->Kosten=='0.00'}{#Free#}{else}{numFormat val=$ss->Kosten} {if $ss->KostenOperant=='%'}%{else}{$Currency}{/if}{/if}</td>
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
<!-- /shop_billing.tpl -->