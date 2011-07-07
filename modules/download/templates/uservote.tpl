{if $ZeigeWertung==1}
<a name="voting"></a>
<h1>{#UserVote#}</h1>
<br /><br />
{if $DarfWerten==1}

{#YourVote#}
<br />
<form method="post">
	<img class="absmiddle" src="{$dl_images}up.gif" alt="" border="0" />
	<input name="voting" type="radio" value="top" id="top" checked="checked" />
	<label for="top">{#Good#}</label>
	&nbsp;&nbsp;&nbsp;
	<img class="absmiddle" src="{$dl_images}down.gif" alt="" border="0" />
	<input name="voting" type="radio" id="flop" value="flop" />
	<label for="flop">{#Bad#}</label>
	&nbsp;&nbsp;
	<input type="submit" class="button" value="{#VoteButton#}" />
	{* <input type="hidden" name="file_id" value="{$smarty.get.file_id}" /> *}
	<input type="hidden" name="fileaction" value="voting" />
</form>
</p>
{else}
{#AllreadyVoted#}
{/if}
<div class="mod_download_spacer"></div>
{/if}



