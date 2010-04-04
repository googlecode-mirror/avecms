<h2 id="page-heading">{#SEARCH_RESULTS#}</h2>
{if $no_results==1}
<p>{#SEARCH_NO_RESULTS#}</p>
{else}
{if $q_navi}
<div class="page_navigation_box"> {#SEARCH_PAGES#} {$q_navi} </div>
{/if} 
{foreach from=$searchresults item=res}

<h4> <a href="{$res->Url}">{$res->Titel}</a> </h4>
<blockquote> {$res->Text} <br />
<a href="{$res->Url}">{#SEARCH_VIEW#}</a> | <a target="_blank" href="{$res->Url}">{#SEARCH_VIEW_BLANK#}</a> {$Geklickt}</blockquote>
<br />
{/foreach} 
{if $q_navi}
<div class="page_navigation_box"> {#SEARCH_PAGES#} {$q_navi} </div>
{/if}

{/if}
{include file="$inc_path/form_big.tpl"}