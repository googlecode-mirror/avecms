{foreach from=$news item=n}
{$n.date}
    <h2>{$n.Titel}</h2>
	<div align="justify" style="padding:10px">
		{if $n.preimage != ''}
			<img src="modules/news/preimages/{$n.preimage}" alt="{$n.Titel}" align="left" />
		{/if}
		{$n.pretext}
	</div>
	<div style="float:left">{#NEWS_DOC_VIEW#} {$n.Geklickt} | {#NEWS_DOC_COMMENT#} {$n.c_nums}</div>
	<div style="float:right"><a href="{$n.link}">{#NEWS_DOC_DETAILED#}</a></div>
	<div style="clear:both">&nbsp;</div>
{/foreach}
<br />
{$page_nav}