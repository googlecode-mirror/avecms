<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<title>{#BASKET_SHOP_NAME#}</title>
{literal}
<style type="text/css">
html,body,td,th,div {font:11px Verdana,Arial,Helvetica,sans-serif;}
.border {background-color:#ccc;}
.header {background-color:#eee;}
.row {background-color:#fff;}
</style>
{/literal}
</head>
{oBasket->getBasket assign='basket'}
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><strong>{#BASKET_SHOP_NAME#}</strong><br>{#BASKET_SHOP_ADDRESS#}</td>
					<td align="right"><img src="{$smarty.const.HOST}{$smarty.const.ABS_PATH}templates/{$smarty.const.THEME_FOLDER}/images/{#BASKET_SHOP_LOGO#}" alt="" border="0" /></td>
				</tr>
			</table>

			<hr noshade="noshade" size="1">
			<h3><strong>{#BASKET_ORDER_TITLE#}</strong></h3>
			<hr noshade="noshade" size="1">
			<em>{#BASKET_ORDER_HEAD#}</em>
			<hr noshade="noshade" size="1"><br>

			<table width="100%" border="0" cellpadding="3" cellspacing="1" class="border">
				<col valign="top" align="center" width="30">
				<col valign="top">
				<col valign="top" align="center" width="100">
				<col valign="top" align="right" width="100">
				<col valign="top" align="right" width="100">
				<thead>
					<tr>
						<th class="header"><strong>№</strong></th>
						<th class="header"><strong>{#BASKET_PRODUCT_NAME#}</strong></th>
						<th class="header"><strong>{#BASKET_PRODUCT_QUANTITY#}</strong></th>
						<th class="header"><strong>{#BASKET_PRODUCT_PRICE#}</strong></th>
						<th class="header"><strong>{#BASKET_PRODUCT_AMOUNT#}</strong></th>
					</tr>
				</thead>

				<tbody>
{foreach name=product from=$basket.products item=product}
					<tr>
						<td class="row">{$smarty.foreach.product.iteration}</td>
						<td class="row">{$product->name|truncate:100|escape}</td>
						<td class="row">{$product->quantity}{#BASKET_UNIT#}</td>
						<td class="row" nowrap="nowrap">{$product->price|string_format:"%.2f"}{#BASKET_CURRENCY#}</td>
						<td class="row" nowrap="nowrap">{$product->amount|string_format:"%.2f"}{#BASKET_CURRENCY#}</td>
					</tr>
{/foreach}
					<tr>
						<td class="row" colspan="4" align="right">{#BASKET_ORDER_TOTAL#} </td>
						<td class="row"><strong>{$basket.total|string_format:"%.2f"}{#BASKET_CURRENCY#}</strong></td>
					</tr>
				</tbody>
			</table><br>

			<table width="100%" border="0" cellspacing="0" cellpadding="4">
				<col width="100" valign="top" align="right">
				<thead>
					<tr>
						<td class="header">&nbsp;</td>
						<td class="header"><strong>{#BASKET_CUSTOMER_INFO#}</strong></td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>{#BASKET_CUSTOMER_NAME#}</td>
						<td>{$customer.name|escape}</td>
					</tr>
					<tr>
						<td>{#BASKET_CUSTOMER_EMAIL#}</td>
						<td>{$customer.email}</td>
					</tr>
					<tr>
						<td>{#BASKET_CUSTOMER_PHONE#}</td>
						<td>{$customer.phone|escape}</td>
					</tr>
					<tr>
						<td>{#BASKET_CUSTOMER_ADDRESS#}</td>
						<td>{textformat wrap_char='<br>'}{$customer.address|truncate:1000|escape}{/textformat}</td>
					</tr>
					<tr>
						<td>{#BASKET_CUSTOMER_DESCRIPTION#}</td>
						<td>{textformat wrap_char='<br>'}{$customer.description|truncate:1000|escape}{/textformat}</td>
					</tr>
					<tr>
						<td colspan="2">&nbsp;</td>
					</tr>
					<tr>
						<td>{#BASKET_ORDER_DATE#}</td>
						<td>{$smarty.now|date_format:"%d.%m.%Y, %H:%M"}</td>
					</tr>
				</tbody>
			</table>

			<hr noshade="noshade" size="1">
			<strong>{#BASKET_ORDER_INFO#}</strong><br>
			<br>
			<strong>{#BASKET_SHOP_NAME#}</strong><br>
			{#BASKET_SHOP_ADDRESS#}
		</td>
	</tr>
</table>

</body>
</html>