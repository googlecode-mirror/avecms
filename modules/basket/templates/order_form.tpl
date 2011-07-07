{oBasket->getBasket assign='basket'}

{if $basket.products}
<div id="basket-order" class="tablebox">

<table class="progress" width="100%" border="0" cellpadding="0" cellspacing="0">
	<col width="38"><col width="195">
	<col width="38"><col width="195">
	<col width="38"><col width="195">
	<tr>
		<th>1</th><td>{#BASKET_PROGRESSBAR_STEP1#}</td>
		<th class="active">2</th><td class="active">{#BASKET_PROGRESSBAR_STEP2#}</td>
		<th>3</th><td>{#BASKET_PROGRESSBAR_STEP3#}</td>
	</tr>
</table>

<p><em>{#BASKET_ORDER_FORM_TIP#}</em></p>

<form method="post" action="index.php?module=basket&action=send">
{* раскомментировать при желании отображать список заказанных товаров
	<table width="100%" border="1" cellpadding="0" cellspacing="0">
		<colgroup>
			<col width="40">
			<col>
			<col width="80">
			<col width="80">
			<col width="80">
		</colgroup>

		<thead>
			<tr>
				<th>№</th>
				<th>{#BASKET_PRODUCT_NAME#}</th>
				<th>{#BASKET_PRODUCT_QUANTITY#}</th>
				<th>{#BASKET_PRODUCT_PRICE#}</th>
				<th>{#BASKET_PRODUCT_AMOUNT#}</th>
			</tr>
		</thead>

		<tbody>
			{foreach name=product from=$basket.products item=product}
				<tr>
					<td align="center">{$smarty.foreach.product.iteration}</td>
					<td align="left">{$product->name|escape}</td>
					<td align="center">{$product->quantity}</td>
					<td align="center">{$product->price|string_format:"%.2f"}</td>
					<td align="center">{$product->amount|string_format:"%.2f"}</td>
				</tr>
			{/foreach}
		</tbody>

		<tfoot>
			<tr>
				<th colspan="5" align="right">{$basket.total|string_format:"%.2f"}</th>
			</tr>
		</tfoot>
	</table>
*}
	<fieldset>
		<p>
			<label>{#BASKET_CUSTOMER_NAME#}</label>
			<input type="text" name="name" title="" maxlength="50" value="{$smarty.request.name|default:$smarty.session.user_name|escape}" />
		</p>

		<p>
			<label>{#BASKET_CUSTOMER_EMAIL#}</label>
			<input type="text" name="email" title="" maxlength="100" value="{$smarty.request.email|default:$smarty.session.user_email|escape}" />
		</p>

		<p>
			<label>{#BASKET_CUSTOMER_PHONE#}</label>
			<input type="text" name="phone" title="" maxlength="50" value="{$smarty.request.phone|escape}" />
		</p>

		<p>
			<label>{#BASKET_CUSTOMER_ADDRESS#}</label>
			<textarea name="address" title="">{$smarty.request.address}</textarea>
		</p>

		<p>
			<label>{#BASKET_CUSTOMER_DESCRIPTION#}</label>
			<textarea name="description" title="">{$smarty.request.description}</textarea>
		</p>

		<input type="submit" class="button" value="{#BASKET_SEND#}" />
	</fieldset>
</form>
</div>
{else}
	<h2 id="page-heading">{#BASKET_EMPTY#}</h2>
{/if}