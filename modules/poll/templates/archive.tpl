<h2>{#POLL_ARCHIVE_TITLE#}</h2><br />
<br />

<table width="100%" border="0" cellpadding="0" cellspacing="1">
	<col>
	<col width="100">
	<col width="100">
	<col width="100">
	<tr>
		<td class="mod_poll_table"><a href="index.php?module=poll&amp;action=archive&amp;order=title{if $smarty.request.order=='title' && $smarty.request.by!='desc'}&amp;by=desc{/if}">{#POLL_PUB_TITLE#}</a></td>
		<td class="mod_poll_table" align="center"><a href="index.php?module=poll&amp;action=archive&amp;order=start{if $smarty.request.order=='start' && $smarty.request.by!='desc'}&amp;by=desc{/if}">{#POLL_PUB_START#}</a></td>
		<td class="mod_poll_table" align="center"><a href="index.php?module=poll&amp;action=archive&amp;order=end{if $smarty.request.order=='end' && $smarty.request.by!='desc'}&amp;by=desc{/if}">{#POLL_PUB_END#}</a></td>
		<td class="mod_poll_table" align="center"><a href="index.php?module=poll&amp;action=archive&amp;order=votes{if $smarty.request.order=='votes' && $smarty.request.by!='desc'}&amp;by=desc{/if}">{#POLL_ARCHIVE_HITS#}</a></td>
	</tr>
	{foreach from=$items item=item}
		<tr class="{cycle name='1' values="mod_poll_first,mod_poll_second"}">
			<td><a href="{$item->plink}">{$item->poll_title}</a></td>
			<td align="center">{$item->poll_start|date_format:$DATE_FORMAT|pretty_date}</td>
			<td align="center">{$item->poll_end|date_format:$DATE_FORMAT|pretty_date}</td>
			<td align="center">{$item->votes}</td>
		</tr>
	{/foreach}
</table><br />
<br />