<div align="center">
<table width="100%" height="10" border="0" cellpadding="0" cellspacing="0"><tr><td></td></tr></table>
{foreach from=$news item=n}
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border-right:dotted; border-right-color:#000; border-right-width:1px; border-bottom:dotted; border-bottom-color:#000; border-bottom-width:1px;">
	<tr>
		<td colspan="2" bgcolor="#ccf"><div align="center"><strong style="color:#000;">{$n.Titel}</strong></div></td>
	</tr>
	<tr>
		<td colspan="2">
			<div align="left">
				<img src="/modules/news/preimages/{$n.preimage}" alt="{$n.Titel}" align="left" />
				<p>{$n.pretext}</p>
				<a href="{$n.link}">{#NEWS_DOC_DETAILED#}</a>
			</div>
		</td>
	</tr>
	<tr>
		<td bgcolor="#ffc"><div align="left">&nbsp;{$n.date}</div></td>
		<td bgcolor="#ffc"><div align="right">{#NEWS_DOC_VIEW#} {$n.Geklickt}&nbsp;</div></td>
	</tr>
</table>
<table width="100%" height="10" border="0" cellpadding="0" cellspacing="0"><tr><td></td></tr></table>
{/foreach}
{$page_nav}
</div>