
<!-- replyform.tpl -->
{strip}

<div id="pageHeaderTitle" style="padding-top:7px">
	<div class="h_docs">&nbsp;</div>
	<div class="HeaderTitle">
		<h2>{#DOC_NEW_NOTICE_TITLE#}</h2>
	</div>
	<div class="HeaderText">{#DOC_SEND_NOTICE_INFO#}</div>
</div>
<div class="upPage">&nbsp;</div><br />

<form method="post" action="{$formaction}">
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<tr>
			<td class="first" width="135"><strong>{#DOC_NOTICE_TITLE#}</strong></td>
			<td class="second">
				<input name="Titel" type="text" id="Titel" style="width:600px" value="">
			</td>
		</tr>

		<tr>
			<td class="first" width="135"><strong>{#DOC_NOTICE_TEXT#}</strong></td>
			<td class="second">
				<textarea name="Kommentar" style="width:600px;height:100px" id="Kommentar"></textarea>
			</td>
		</tr>

		<tr>
			<td class="first" width="135"></td>
			<td class="second">
				<input type="submit" class="button" value="{#DOC_BUTTON_ADD_NOTICE#}" />
				<span class="first"><a name="comment"></a></span>
			</td>
		</tr>
	</table>
</form>

{/strip}
<!-- /replyform.tpl -->
