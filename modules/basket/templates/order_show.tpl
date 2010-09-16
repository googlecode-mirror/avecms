{oBasket->getBasket assign='basket'}

{if $basket.products}
<div id="basket-order" class="tablebox">

<table class="progress" width="100%" border="0" cellpadding="0" cellspacing="0">
	<col width="38"><col width="195">
	<col width="38"><col width="195">
	<col width="38"><col width="195">
	<tr>
		<th class="active">1</th><td class="active">{#BASKET_PROGRESSBAR_STEP1#}</td>
		<th>2</th><td>{#BASKET_PROGRESSBAR_STEP2#}</td>
		<th>3</th><td>{#BASKET_PROGRESSBAR_STEP3#}</td>
	</tr>
</table>

<p><em>{#BASKET_ORDER_SHOW_TIP#}</em></p>

<form method="get" action="index.php">
	<input type="hidden" name="module" value="basket" />
	<input type="hidden" name="action" value="update" />

	<table width="100%" border="1" cellpadding="0" cellspacing="0">
		<colgroup>
			<col width="80">
			<col>
			<col width="80">
			<col width="80">
			<col width="80">
		</colgroup>

		<thead>
			<tr>
				<th>{#BASKET_PRODUCT_DELETE#}</th>
				<th>{#BASKET_PRODUCT_NAME#}</th>
				<th>{#BASKET_PRODUCT_QUANTITY#}</th>
				<th>{#BASKET_PRODUCT_PRICE#}</th>
				<th>{#BASKET_PRODUCT_AMOUNT#}</th>
			</tr>
		</thead>

		<tbody>
			{foreach from=$basket.products item=product}
				<tr>
					<td align="center"><input type="checkbox" name="product_delete[{$product->id}]" value="1" /></td>
					<td align="left">{$product->name|escape}</td>
					<td align="center"><input type="text" name="product_quantity[{$product->id}]" size="1" maxlength="2" value="{$product->quantity}" /></td>
					<td align="right">{$product->price|string_format:"%.2f"}</td>
					<td align="right">{$product->amount|string_format:"%.2f"}</td>
				</tr>
			{/foreach}
		</tbody>

		<tfoot>
			<tr>
				<th colspan="5" align="right">
					<input type="submit" class="button" value="{#BASKET_UPDATE#}" style="float:left;" />
					<span class="ajax-loader" style="display:none;"><img src="{$ABS_PATH}templates/{$smarty.const.THEME_FOLDER}/images/loader-12.gif"></span>
					{$basket.total|string_format:"%.2f"}
				</th>
			</tr>
		</tfoot>
	</table>

	<a href="index.php?module=basket&action=form">{#BASKET_NEXT#}</a>
</form>

{literal}
<script type="text/javascript">
$(document).ready(function() {
	$("#basket-order form").submit(function() {
		$(this).ajaxSubmit({
			type: "post",
			beforeSubmit: function(formData, jqForm) {
				$("#basket-order .ajax-loader").show();
			},
			success: function(response) {
				$("#basket-order").before(response).remove();
			}
		});
		return false;
	});
});
</script>
{/literal}
</div>
{else}
	<h2 id="page-heading">{#BASKET_EMPTY#}</h2>
{/if}