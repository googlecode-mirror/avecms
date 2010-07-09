{assign var="cols" value=3}
{assign var="maxsubs" value=5}
    <div class="box">
      <h2>{#ProductCategsAll#}</h2>
      <div class="block">
        <div class="mod_shop_newprod_box">
          <table width="100%"  cellpadding="0" cellspacing="0">
            <tr>

{foreach from=$shopitems item=item name=dl}
<td valign="top">
	{assign var=op value=$smarty.request.navop}
          <table width="100%"  cellpadding="5" cellspacing="5">
            <tr>
            <td valign="top" style="width: 5%;" >

			{if $item->Bild!=''}
				<a title="{$item->visible_title|escape:'html'}" href="{$item->dyn_link}"><img src="modules/shop/uploads/{$item->Bild}" alt="" border="0" /></a>
			{else}
				<img src="{$shop_images}folder.gif" alt=""/>
			{/if}
</td><td valign="top" style="padding: 0 0 0 10px;">
			<h3><a title="{$item->visible_title|escape:'html'}" href="{$item->dyn_link}">{$item->visible_title|truncate:'30'}</a> </h3>
<ul>
			{foreach from=$item->sub item=sub name=subs}
				{if $smarty.request.categ==""}
					{if ($smarty.foreach.subs.iteration <= $maxsubs)}
						<li><a class="categtitle_n" title="{$sub->visible_title|escape:'html'}" href="index.php?module=shop&categ={$sub->Id}&amp;parent={$sub->parent_id}&amp;navop={get_parent_shopcateg id=$sub->Id}">{$sub->visible_title|escape:'html'} </a></li>
						{if !$smarty.foreach.subs.last}{/if}
					{else}
						{if $showalllink!=1}
							<li>
							<a class="categtitle_n" href="index.php?module=shop&categ={$item->Id}&amp;parent={$item->parent_id}&amp;navop={get_parent_shopcateg id=$item->Id}">{#ShowAll#}</a></li>
							{assign var=showalllink value=1}
						{/if}
					{/if}
				{else}
					<li>
					<a class="categtitle_n" title="{$sub->visible_title|escape:'html'}" href="index.php?module=shop&categ={$sub->Id}&amp;parent={$sub->parent_id}&amp;navop={get_parent_shopcateg id=$sub->Id}">{$sub->visible_title|escape:'html'} </a></li>
					{*... {$sub->data} *}
				{/if}
			{/foreach}
</ul>
			{assign var=showalllink value=0}
</td>
            </tr>
          </table>
</td>
	{if $smarty.foreach.dl.iteration % $cols == 0}
<tr></tr>
	{/if}
{/foreach}

            </tr>
          </table>
        </div>
      </div>
    </div>