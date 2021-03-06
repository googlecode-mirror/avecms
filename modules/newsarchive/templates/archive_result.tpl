<h2>{#ARCHIVE_FROM#} {$month_name}, {$year} {#ARCHIVE_YEAR#}</h2><br /> <br />

{if $newsarchive->newsarchive_show_days == 1}
	<div>{#ARCHIVE_DAYS#}</div>

	<table width="100%" cellpadding="2" cellspacing="2">
		<tr>
			{if $day == 0}
				<td>{#ARCHIVE_ALL_DAY#}</td>
			{else}
				<td><a href="index.php?module=newsarchive&id={$newsarchive->id}&amp;month={$month}&amp;year={$year}">{#ARCHIVE_ALL_DAY#}</a></td>
			{/if}
			{foreach from=$days item=month_day}
				{if $day == $month_day}
					<td>{$month_day|string_format:"%02d"}</td>
				{else}
					<td><a href="index.php?module=newsarchive&id={$newsarchive->id}&amp;day={$month_day}&amp;month={$month}&amp;year={$year}">{$month_day|string_format:"%02d"}</a></td>
				{/if}
			{/foreach}
		</tr>
	</table>
{/if}

{if !$documents}
	<strong>{#ARCHIVE_NOT_FOUND#}</strong>
{else}
	<table width="100%" cellpadding="0" cellspacing="2">
		<tr class="arc_header">
			{if $day == 0}
				<td><a href="index.php?module=newsarchive&id={$newsarchive->id}&amp;month={$month}&amp;year={$year}&amp;sort=title{if $smarty.request.sort=='title'}_desc{/if}">{#ARCHIVE_DOC_NAME#}</a></td>
				<td><a href="index.php?module=newsarchive&id={$newsarchive->id}&amp;month={$month}&amp;year={$year}&amp;sort=date{if $smarty.request.sort=='date'}_desc{/if}">{#ARCHIVE_PUBLIC_DATE#}</a></td>
				<td><a href="index.php?module=newsarchive&id={$newsarchive->id}&amp;month={$month}&amp;year={$year}&amp;sort=rubric{if $smarty.request.sort=='rubric'}_desc{/if}">{#ARCHIVE_IN_RUBRIC#}</a></td>
			{else}
				<td><a href="index.php?module=newsarchive&id={$newsarchive->id}&amp;day={$day}&amp;month={$month}&amp;year={$year}&amp;sort=title{if $smarty.request.sort=='title'}_desc{/if}">{#ARCHIVE_DOC_NAME#}</a></td>
				<td><a href="index.php?module=newsarchive&id={$newsarchive->id}&amp;day={$day}&amp;month={$month}&amp;year={$year}&amp;sort=date{if $smarty.request.sort=='date'}_desc{/if}">{#ARCHIVE_PUBLIC_DATE#}</a></td>
				<td><a href="index.php?module=newsarchive&id={$newsarchive->id}&amp;day={$day}&amp;month={$month}&amp;year={$year}&amp;sort=rubric{if $smarty.request.sort=='rubric'}_desc{/if}">{#ARCHIVE_IN_RUBRIC#}</a></td>
			{/if}
		</tr>

		{foreach from=$documents item=document}
			<tr>
				<td><a href="{$document->document_alias}">{$document->document_title}</a></td>
				<td>{$document->document_published|date_format:$DATE_FORMAT|pretty_date}</td>
				<td>{$document->rubric_title}</td>
			</tr>
		{/foreach}
	</table>
{/if}