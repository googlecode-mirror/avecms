<h2 id="page-heading">{#SEARCH_RESULTS#}</h2>

{if $no_results==1}
	<p>{#SEARCH_NO_RESULTS#}</p>
{else}
	{if $q_navi}<div class="page_navigation_box">{#SEARCH_PAGES#} {$q_navi}</div>{/if}

	{foreach from=$searchresults item=result}
		<h4><a href="{$result->document_alias}">{$result->title|escape}</a></h4>
		<blockquote>{$result->Text}<br /><a href="{$result->document_alias}">{#SEARCH_VIEW#}</a> | <a target="_blank" href="{$result->document_alias}">{#SEARCH_VIEW_BLANK#}</a> {$result->document_count_view}</blockquote><br />
	{/foreach}

	{if $q_navi}<div class="page_navigation_box">{#SEARCH_PAGES#} {$q_navi}</div>{/if}
{/if}

{include file="$inc_path/form_big.tpl"}