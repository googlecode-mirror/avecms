
<!-- admin_edit.tpl -->
{strip}

<div id="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_module"></div>
	<div class="HeaderTitle"><h2>{#COMMENT_EDIT_TITLE#}</h2></div>
	<div class="HeaderText">&nbsp;</div>
</div>

<div id="module_content">
	{if $closed == 1 && $smarty.const.UGROUP != 1}
		{#COMMENT_IS_CLOSED#}
		<p>&nbsp;</p>
		<p><input onclick="window.close();" type="button" class="button" value="{#COMMENT_CLOSE_BUTTON#}" /></p>
	{else}
		{if $editfalse==1}
			{#COMMENT_EDIT_FALSE#}
		{else}
			<form method="post" action="index.php">
				<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
                    <col width="150">
					{if $smarty.const.UGROUP == 1}
						<tr>
							<td class="first">{#COMMENT_YOUR_NAME#}</td>
							<td class="second"><input name="author_name" type="text" id="in_author_name" style="width:250px" value="{$row.author_name|stripslashes|escape:html}" /></td>
						</tr>

						<tr>
							<td class="first">{#COMMENT_YOUR_EMAIL#}</td>
							<td class="second"><input name="author_email" type="text" id="in_author_email" style="width:250px" value="{$row.author_email|stripslashes|escape:html}" /></td>
						</tr>
					{else}
						<input type="hidden" name="author_name" value="{$row.author_name|stripslashes|escape:html}" />
						<input type="hidden" name="author_email" value="{$row.author_email|stripslashes|escape:html}" />
					{/if}
					<tr>
						<td class="first">{#COMMENT_YOUR_SITE#}</td>
						<td class="second"><input name="author_website" type="text" id="in_author_website" style="width:250px" value="{$row.author_website|stripslashes|escape:html}" /></td>
					</tr>

					<tr>
						<td class="first">{#COMMENT_YOUR_FROM#}</td>
						<td class="second"><input name="author_city" type="text" id="in_author_city" style="width:250px" value="{$row.author_city|stripslashes|escape:html}" /></td>
					</tr>

					<tr>
						<td class="first">{#COMMENT_YOUR_TEXT#}</td>
						<td class="second">
							<textarea style="width:100%; height:170px" name="message" id="in_message">{$row.message}</textarea>
							<span id="charsLeft"></span>&nbsp;{#COMMENT_CHARS_LEFT#}
						</td>
					</tr>

                    <input type="hidden" name="do" value="modules" />
                    <input type="hidden" name="action" value="modedit" />
					<input type="hidden" name="mod" value="comment" />
					<input type="hidden" name="moduleaction" value="admin_edit" />
					<input type="hidden" name="sub" value="send" />
					<input type="hidden" name="Id" value="{$smarty.request.Id}" />
				</table><br />

				<input type="submit" class="button" value="{#COMMENT_BUTTON_EDIT#}" />&nbsp;
				<input type="reset" class="button" />
			</form>
		{/if}
	{/if}
</div>

<script type="text/javascript">
$(document).ready(function(){ldelim}
    $('textarea').limit('{$max_chars}','#charsLeft');
{rdelim});
</script>

{/strip}
<!-- admin_edit.tpl -->
