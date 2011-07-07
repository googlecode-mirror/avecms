<div class="mod_searchbox">
<strong>{#ARCHIVE_TITLE#}</strong><br />
<br />
{foreach from=$months item=items}
	{if $items->nums != 0}
		<span style="line-height:25px;"><a href="index.php?module=newsarchive&id={$archiveid}&amp;month={$items->mid}&amp;year={$items->year}">{$items->month}, {$items->year}</a> <small>({$items->nums})</small></span><br />
	{else}
		{if $newsarchive_show_empty == 1}
			<span style="line-height:25px;"><a href="index.php?module=newsarchive&id={$archiveid}&amp;month={$items->mid}&amp;year={$items->year}">{$items->month}, {$items->year}</a> <small>(0)</small></span><br />
		{/if}
	{/if}
{/foreach}
</div>