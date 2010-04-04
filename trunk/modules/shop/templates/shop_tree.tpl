{if $shopitems}
{assign var="cols" value=5} 
{assign var="maxsubs" value=5}
    <div class="box">
      <h2>{#ProductCategs#}</h2>
      <div class="block">
        <div class="mod_shop_newprod_box">
          <table width="100%"  cellpadding="0" cellspacing="0">
            <tr>
{foreach from=$shopitems item=item name=dl}
{assign var="newtr" value=$newtr+1}
<td style="text-align:center;"><div class="mod_shop_newprod_box_container">
<a title="{$item->visible_title|escape:'html'}" href="{$item->dyn_link}">
{if $item->Bild!=''}
<img src="modules/shop/uploads/{$item->Bild}" alt="{$item->visible_title|escape:'html'}" border="0" />
{else}
<img src="{$shop_images}folder.gif" alt="{$item->KatName|escape:html}"/>
{/if}
</a><br /><a title="{$item->visible_title|escape:'html'}" href="{$item->dyn_link}"><strong>{$item->visible_title|truncate:'30'}</strong></a> 
</td>
{if $newtr % $cols == 0}
<tr></tr>
{/if} 
{/foreach}

            </tr>
          </table>
        </div>
      </div>
    </div>

{/if}