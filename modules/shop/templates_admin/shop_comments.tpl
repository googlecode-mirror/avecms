{strip}

<div class="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_module">&nbsp;</div>
	<div class="HeaderTitle"><h2>{#EditCommentsR#}</h2></div>
	<div class="HeaderText">&nbsp;</div>
</div><br />

<form action="index.php?do=modules&action=modedit&mod=shop&moduleaction=edit_comments&pop=1&Id={$smarty.request.Id}&cp={$sess}&sub=save" method="post">
	<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
		<tr>
			<td align="center" width="1%" class="tableheader">&nbsp;</td>
			<td class="tableheader">{#CommentsPublic#}</td>
			<td class="tableheader">{#CommentsVote#}</td>
			<td class="tableheader">{#CommentsTitle#}</td>
			<td class="tableheader">{#CommentsText#}</td>
		</tr>

		{foreach from=$comments item=ss}
			<tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
				<td align="center" width="1%">
					<input title="{#Delete#}" name="Del[{$ss->Id}]" type="checkbox" value="1" />
				</td>

				<td width="10%" align="center" nowrap="nowrap">
					<input type="radio" name="Publik[{$ss->Id}]" value="1" {if $ss->Publik=='1'}checked{/if} />{#Yes#}&nbsp;
					<input type="radio" name="Publik[{$ss->Id}]" value="0" {if $ss->Publik=='0'}checked{/if} />{#No#}
				</td>

				<td>
					<input name="Wertung[{$ss->Id}]" type="text" style="width:30px" value="{$ss->Wertung}" maxlength="1" />
				</td>

				<td>
					<input style="width:160px" type="text" name="Titel[{$ss->Id}]" value="{$ss->Titel|stripslashes}" />
				</td>

				<td>
					<textarea onclick="this.style.height='200px'" onmouseout="this.style.height='80px'" style="width:500px; height:80px" name="Kommentar[{$ss->Id}]">{$ss->Kommentar}</textarea>
				</td>
			</tr>
		{/foreach}
	</table><br />

	<input type="submit" class="button" value="{#ButtonSave#}">
</form>

{/strip}