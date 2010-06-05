{if $shopitems}
	{assign var="cols" value=1}
	{assign var="maxsubs" value=5}
	{if $cols==1}{assign var="width" value=99}
	{elseif $cols==2}{assign var="width" value=50}
	{elseif $cols==3}{assign var="width" value=33}
	{/if}

	<table width="100%" border="0" cellpadding="0" cellspacing="1">
		<tr>
			{foreach from=$shopitems item=item name=dl}
				{assign var="newtr" value=$newtr+1}
				<td valign="top" style="width:{$width}%" class="{cycle name='s' values='dl_first,dl_second'}">
					<table width="100%" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="1%" valign="top">
								{if $item->Bild!=''}
									<a class="tooltip" title="{$item->visible_title|escape:'html'}" href="{$item->dyn_link}">
									<img src="modules/download/icons/{$item->Bild}" alt=""  class="absmiddle" border="0" style="margin-right:10px" />	</a>
									<br />
								{else}
									<img src="{$download_images}folder.gif" alt=""  class="absmiddle" />
								{/if}
							</td>

							<td valign="top">
								<h3 class="download_categ" style="line-height:1.5em">
									<a class="tooltip" title="{$item->KatBeschreibung|default:$item->visible_title|escape:'html'}" href="{$item->dyn_link}">{$item->visible_title|truncate:'30'}</a>
									{if $item->fileCount}({$item->fileCount}){/if}
								</h3>
								{if $item->subs}
									<br />
									{foreach from=$item->subs item=sub name=s}
										<a class="tooltip" title="{$sub->KatBeschreibung|default:$sub->visible_title|escape:'html'}" href="{$sub->dyn_link}">{$sub->visible_title|truncate:'30'}</a>
										{if $sub->fileCount}({$sub->fileCount}){/if}{if !$smarty.foreach.s.last}, {/if}
									{/foreach}
								{/if}
							</td>
						</tr>
					</table>
				</td>

				{if $newtr % $cols == 0}</tr><tr>{/if}

			{/foreach}

			<div class="clear" style="width:100px">&nbsp;</div>
		</tr>
	</table>
{/if}