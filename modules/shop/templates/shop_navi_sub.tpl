{foreach from=$items item=item}
	<li>
{* Условие если активными должны быть все элементы в пути к активной категории
		{if $smarty.request.categ==$item->Id || $item->sub_navi}
*}		{if $smarty.request.categ==$item->Id}
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