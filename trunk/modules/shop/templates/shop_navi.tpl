{strip}
<!-- shop_navi.tpl -->
<div class="menu_v">
	<ul>
		<li>
			{if ($smarty.request.action=='wishlist' || $smarty.request.action=='showbasket' || $smarty.request.action=='checkout') || ($smarty.request.action=='shopstart' && $smarty.request.categ=='')}
				<b><a href="{$shopStart}">{#ShopStart#}</a></b>
			{else}
				<a href="{$shopStart}">{#ShopStart#}</a>
			{/if}
		</li>

		{foreach from=$shopnavi item=item}
			<li>
				{if $smarty.request.categ==$item->Id || $item->sub_navi}
					<b><a href="{$item->dyn_link}">{$item->KatName|escape:'html'}</a></b>
				{else}
					<a href="{$item->dyn_link}">{$item->KatName|escape:'html'}</a>
				{/if}

				{if $item->sub_navi}
					<ul>
						{include file="$subtpl" items=$item->sub_navi}
					</ul>
				{/if}
			</li>
		{/foreach}
	</ul>
</div>
<!-- shop_navi.tpl -->
{/strip}