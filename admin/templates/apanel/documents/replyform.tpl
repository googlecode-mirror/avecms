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
				<input name="remark_title" type="text" id="remark_title" style="width:600px" value="">
			</td>
		</tr>

		<tr>
			<td class="first" width="135"><strong>{#DOC_NOTICE_TEXT#}</strong></td>
			<td class="second">
				<textarea name="remark_text" style="width:600px;height:100px" id="remark_text"></textarea>
			</td>
		</tr>

		<tr>
			<td class="first" width="135"></td>
			<td class="second">
				<input type="submit" class="button" value="{#DOC_BUTTON_ADD_NOTICE#}" />
				<a name="comment"></a>
			</td>
		</tr>
	</table>
</form>