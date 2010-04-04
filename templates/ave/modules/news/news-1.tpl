{foreach from=$news item=n}
<div class="newsbox">
<a  href="{$n.link}" title="{#NEWS_DOC_DETAILED#}"><img style="width:100px;" alt="{#NEWS_DOC_DETAILED#}" src="/modules/news/preimages/{$n.preimage}"/></a>
<h5><a href="{$n.link}" title="{$n.Titel}">{$n.Titel}</a></h5>
<div class="newsticker">{$n.pretext}</div>
<div class="newstime">{$n.date} • Просмотров: ({$n.Geklickt}) • Комментариев: ({$n.c_nums})</div>
</div>
<div style="clear: both;"></div>
<hr />
{/foreach}
{$page_nav}
