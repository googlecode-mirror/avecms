{if $display_comments==1}
<h3>{#COMMENT_SITE_TITLE#}{if $closed==1 && $smarty.const.UGROUP!=1} <small>{#COMMENT_SITE_CLOSED#}</small>{/if}</h3>

<a href="#end">{#COMMENT_SITE_ADD#}</a>

{if $smarty.const.UGROUP==1}
	&nbsp;|&nbsp;
	{if $closed==1}
		<a id="mod_comment_open" href="javascript:void(0);">{#COMMENT_SITE_OPEN#}</a>
	{else}
		<a id="mod_comment_close" href="javascript:void(0);">{#COMMENT_SITE_CLOSE#}</a>
	{/if}<br />
{/if}

{if $comments[0]}
	{include file="$subtpl" subcomments=$comments[0]}
{/if}

<a id="end"></a>

{if $closed==1 && $smarty.const.UGROUP!=1}
	<p>{#COMMENT_NEW_CLOSED#}</p>
{elseif $cancomment!=1 && $smarty.const.UGROUP!=1}
	<p>{#COMMENT_NEW_FALSE#}</p>
{else}
<div id="mod_comment_new" class="box">
	<h2>
		<a href="#" id="toggle-forms">{#COMMENT_NEW_TITLE#}</a>
	</h2>
	<div class="block" id="forms">
		<fieldset>
			<form method="post" action="{$ABS_PATH}index.php">
				{if $smarty.session.user_group != '2'}
					<input name="author_name" type="hidden" id="in_author_name" value="{$smarty.session.user_name|escape|stripslashes}" />
				{else}
					<p>
						<label>{#COMMENT_YOUR_NAME#}</label>
						<input name="author_name" type="text" id="in_author_name" value="{$smarty.request.author_name|escape|stripslashes}" />&nbsp;
					</p>
				{/if}
				{if $smarty.session.user_email != ''}
					<input name="author_email" type="hidden" id="in_author_email" value="{$smarty.session.user_email|escape|stripslashes}" />
				{else}
					<p>
						<label>{#COMMENT_YOUR_EMAIL#}</label>
						<input name="author_email" type="text" id="in_author_email" value="{$smarty.request.author_email|escape|stripslashes}" />&nbsp;
					</p>
				{/if}
				<p>
					<label>{#COMMENT_YOUR_SITE#}</label>
					<input name="author_website" type="text" id="in_author_website" $value="{$smarty.request.author_website|escape|stripslashes}" />
				</p>
				<p>
					<label>{#COMMENT_YOUR_FROM#}</label>
					<input name="author_city" type="text" id="in_author_city" $value="{$smarty.request.author_city|escape|stripslashes}" />
				</p>
				<p>
					<label>{#COMMENT_YOUR_TEXT#}</label>
					<textarea rows="8" name="message" id="in_message"></textarea>
				</p>
				<p>
					<label>&nbsp;</label>
					{#COMMENT_CHARS_LEFT#} - <span class="charsLeft" id="charsLeft_new"></span>
				</p>
				{if $im}
					<p>
			        	<label>{#COMMENT_FORM_CODE#}</label>
						<span id="captcha"><img src="{$ABS_PATH}inc/captcha.php" alt="" width="120" height="60" border="0" /></span>
					</p>
					<p>
						<label for="securecode">{#COMMENT_FORM_CODE_ENTER#}</label>
						<input name="securecode" type="text" id="securecode" maxlength="10" />
					</p>
				{/if}
				<p>
					<input class="confirm button" value="{#COMMENT_BUTTON_ADD#}" type="submit">
					<input class="button" id="buttonReset" type="reset">
				</p>

				<input name="module" type="hidden" value="comment" />
				<input name="action" type="hidden" value="comment" />
				<input name="sub" type="hidden" value="send" />
				<input name="doc_id" type="hidden" value="{$smarty.request.id}" />
				<input name="parent_id" id="parent_id" type="hidden" value="" />
				<input name="page" type="hidden" value="{$page}" />
			</form>
		</fieldset>
	</div>
</div>

<script type="text/javascript">
var COMMENT_SITE_CLOSE = '{#COMMENT_SITE_CLOSE#}';
var COMMENT_SITE_OPEN = '{#COMMENT_SITE_OPEN#}';
var COMMENT_LOCK_LINK = '{#COMMENT_LOCK_LINK#}';
var COMMENT_EDIT_LINK = '{#COMMENT_EDIT_LINK#}';
var COMMENT_EDIT_TITLE = '{#COMMENT_EDIT_TITLE#}';
var COMMENT_UNLOCK_LINK = '{#COMMENT_UNLOCK_LINK#}';
var COMMENT_ERROR_AUTHOR = '{#COMMENT_ERROR_AUTHOR#}';
var COMMENT_ERROR_EMAIL = '{#COMMENT_ERROR_EMAIL#}';
var COMMENT_ERROR_TEXT = '{#COMMENT_ERROR_TEXT#}';
var COMMENT_ERROR_CAPTCHA = '{#COMMENT_ERROR_CAPTCHA#}';
var COMMENT_BUTTON_EDIT = '{#COMMENT_BUTTON_EDIT#}';
var COMMENT_BUTTON_CANCEL = '{#COMMENT_BUTTON_CANCEL#}';
var COMMENT_CHARS_LEFT = '{#COMMENT_CHARS_LEFT#}';
var COMMENT_DATE_TIME_FORMAT = '{#COMMENT_DATE_TIME_FORMAT#}';
var COMMENT_TEXT_CHANGED = '{#COMMENT_TEXT_CHANGED#}';
var COMMENT_WRONG_CODE = '{#COMMENT_WRONG_CODE#}';
var UGROUP = '{$smarty.const.UGROUP}';
var IS_IM = '{$im}';
var DOC_ID = '{$doc_id}';
var MAX_CHARS = '{$max_chars}';
</script>
 <script src="{$ABS_PATH}modules/comment/js/comment.js" type="text/javascript"></script>
{/if}
{/if}