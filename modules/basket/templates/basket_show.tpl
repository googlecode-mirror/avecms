{oBasket->getBasket assign='basket'}

<div id="basket" class="box">
	<h2>{#BASKET_TITLE#} <span class="ajax-loader" style="display:none;"><img src="{$ABS_PATH}templates/{$smarty.const.THEME_FOLDER}/images/loader-12.gif" alt="load..."></span></h2>
	{if $basket.products}
	<div>
		<ul>
			{foreach from=$basket.products item=product}<li><a href="{$ABS_PATH}index.php?module=basket&action=delete&id={$product->id}" onClick="return false;"><img src="{$ABS_PATH}templates/{$smarty.const.THEME_FOLDER}/images/trash.gif" id="basket-delete_{$product->id}"></a>{$product->name} <small>({$product->quantity}{#BASKET_UNIT#}) - {$product->amount|string_format:"%.2f"}{#BASKET_CURRENCY#}</small></li>
			{/foreach}
		</ul>
		<hr />
		<p><a href="{$ABS_PATH}index.php?module=basket&action=order">{#BASKET_ORDER_CHECKOUT#}</a> {#BASKET_ORDER_TOTAL#}: {$basket.total|string_format:"%.2f"}{#BASKET_CURRENCY#}</p>
	</div>
	{/if}
</div>
{literal}
<script type="text/javascript">
<!--
$(document).ready(function() {
	$("#basket li img").click(function() {
		$("#basket .ajax-loader").show();
		var pid = (this.id).split("_");
		$.post("{/literal}{$ABS_PATH}{literal}index.php",
			{module: "basket", action: "delete", id: pid[1]},
			function(response) {
				$("#basket").before(response).remove();
			});
	});

	$("form.product").submit(function() {
		$(this).unbind("submit").ajaxSubmit({
			type: "post",
			resetForm: true,
			beforeSubmit: function(formData, jqForm) {
				$("#basket .ajax-loader").show();
				var productImage = jqForm.find(".product-image");
				var imagePosition = productImage.offset();
				var basketPosition = $("#basket").offset();
				productImage.before('<img src="' + productImage.attr("src")
					+ '" class="fly-image" style="position: absolute; top: '
					+ imagePosition.top + 'px; left: '
					+ imagePosition.left + 'px;" />');
				$(".fly-image").animate({
						top: basketPosition.top + 'px',
						left: basketPosition.left + 'px',
						opacity: 0,
						width: $("#basket").width(),
						heigth: $("#basket").height()},
					"slow",
					false,
					function(){
						$(".fly-image").remove();
					});
			},
			success: function(response) {
				$("#basket").before(response).remove()
							.find(".ajax-loader").hide();
			}
		});
		return false;
	});
});
-->
</script>
{/literal}