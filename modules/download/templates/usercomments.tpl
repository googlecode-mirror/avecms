{if $Kommentare==1}

	<a name="comments"></a>
	<h1>{#CommentsW#}</h1><br />
	<br />

	{if $Comments}
		<div class="mod_download_commentbox">
			<table width="100%" border="0" cellpadding="2" cellspacing="0">
				{foreach from=$Comments item=c}
					<tr>
						<td>
							<a class="tooltip" href="javascript:void(0);" title="{$c->comment_text}">{$c->title|stripslashes|truncate:50}</a>
						</td>

						<td>
							{$c->Name|stripslashes}
						</td>

						<td align="right">
							{$c->Datum|date_format:$TIME_FORMAT|pretty_date}
						</td>
					</tr>
				{/foreach}
			</table>
		</div>
	{else}
		{#NoComments#}
	{/if}

	<div class="mod_download_spacer"></div>

	<a name="comment_new"></a>
	<h1>{#CommentNew#}</h1><br />
	<br />

	{#CommentInf#}

	<form method="post">
		{if $Spam==1}<br />
			<h1 class="mod_download_nospam">{#PleaseNoSpam#}</h1><br />
			{#NoSpamInf#}<br />
			<br />
		{/if}

		<label for="c_title">{#TitleC#}</label><br />
		{if $NoTitle==1}
			<div class="mod_download_commenterror">{#NoTitle#}</div>
		{/if}
		<input name="title" type="text" id="c_title" size="40" value="{$smarty.post.title|stripslashes|escape:html}" /><br />

		<label for="c_comment">{#YourComment#}</label><br />
		{if $NoComment==1}
			<div class="mod_download_commenterror">{#NoComment#}</div>
		{/if}
		<textarea name="comment_text" cols="45" rows="5" id="c_comment">{$smarty.post.comment_text|stripslashes|escape:html}</textarea><br />

		<label for="c_name">{#NameY#}</label><br />
		{if $NoName==1}
			<div class="mod_download_commenterror">{#NoName#}</div>
		{/if}
		<input name="Name" type="text" id="c_name" size="40" value="{$smarty.post.Name|stripslashes|escape:html}" /><br />

		<label for="c_email">{#EmailY#}</label><br />
		{if $NoEmail==1}
			<div class="mod_download_commenterror">{#NoMail#}</div>
		{/if}
		<input name="email" type="text" id="c_email" size="40" value="{$smarty.post.email|stripslashes|escape:html}" /><br />

		<input type="hidden" name="fileaction" value="comment" />

		{if $anti_spam == 1}
			{#SecureCode#}<br />

			{if $CodeCheck=='False'}
				<a name="code_wrong"></a>
				<div class="mod_download_commenterror">{#WrongCode#}</div>
			{/if}

			<img src="inc/antispam.php?cp_secureimage={$im}" alt="" width="121" height="41" border="0" /><br />
			<input name="scode" type="text" maxlength="7" style="font-size:18px; text-align:center; width:118px;" id="sCode" /><br />
		{/if}

		<br />
	    <input type="submit" class="button" value="{#ButtonSend#}" />
	</form>

	{if $CodeCheck=='False'}
		<script>location.href='#code_wrong';</script>
	{/if}
{/if}