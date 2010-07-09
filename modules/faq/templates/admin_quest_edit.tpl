<div class="pageHeaderTitle" style="padding-top:7px">
	<div class="h_module"></div>
	<div class="HeaderTitle"><h2>{#FAQ_INSERT_H#}</h2></div>
	<div class="HeaderText">{#FAQ_INSERT#}</div>
</div><br />

<form action="index.php?do=modules&action=modedit&mod=faq&moduleaction=questsave&cp={$sess}" method="post">
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<tr class="tableheader">
			<td>{#FAQ_INNAME#}</td>
		</tr>

		<tr>
			<td class="second">
				<div>
					<input type="hidden" id="faq_quest" name="faq_quest" value="{$faq_quest|escape}" style="display:none" />
					<input type="hidden" id="quest___Config" value="" style="display:none" />
					<div id="quest_data">
						<iframe id="quest___Frame" src="editor/editor/fckeditor.html?InstanceName=faq_quest&amp;Toolbar=cpengine" width="100%" height="400px" frameborder="0" scrolling="no"></iframe>
					</div>
				</div>
			</td>
		</tr>

		<tr class="tableheader">
			<td>{#FAQ_INDESC#}</td>
		</tr>

		<tr>
			<td class="second">
				<div>
					<input type="hidden" id="faq_answer" name="faq_answer" value="{$faq_answer|escape}" style="display:none" />
					<input type="hidden" id="answer___Config" value="" style="display:none" />
					<div id="answer_data">
						<iframe id="answer___Frame" src="editor/editor/fckeditor.html?InstanceName=faq_answer&amp;Toolbar=cpengine" width="100%" height="400px" frameborder="0" scrolling="no"></iframe>
					</div>
				</div>
			</td>
		</tr>

		<tr>
			<td class="first">
				<input type="hidden" name="id" value="{$id}">
				<input type="hidden" name="faq_id" value="{$faq_id}">
				<input name="submit" type="submit" class="button" value="{#FAQ_SAVE#}" />
			</td>
		</tr>
	</table>
</form>
