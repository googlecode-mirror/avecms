{foreach from=$subcomments item=c}
	<div class="mod_comment_comment{if $c.parent_id} mod_comment_ans_box{/if}">

	{if $smarty.request.subaction=='showonly' && $smarty.request.comment_id==$c.Id}
		<div class="mod_comment_highlight">
	{/if}

	<div id="{$c.Id}" class="mod_comment_box">
		<div class="mod_comment_header clearfix">
			<div class="mod_comment_author">
				{#COMMENT_USER_ADD#} <a title="{#COMMENT_INFO#}" href="javascript:void(0);" onclick="popup('{$ABS_PATH}index.php?module=comment&action=postinfo&pop=1&Id={$c.Id}&theme={$theme}','comment','500','300','1');">{$c.author_name|stripslashes|escape}</a> • {$c.published}{if $smarty.const.UGROUP==1} • IP:{$c.author_ip}{/if}
				<span class="mod_comment_changed">{if $c.edited > 1} ({#COMMENT_TEXT_CHANGED#} {$c.edited}){/if}</span>
			</div>

			<div class="mod_comment_icons">
				{if $c.author_id!=$smarty.session.user_id|default:'*' && (($cancomment==1 && $closed!=1) || $smarty.const.UGROUP==1)}
					<a class="mod_comment_answer" href="javascript:void(0);"><img src="{$ABS_PATH}modules/comment/templates/images/reply.gif" alt="" border="0" /></a>
				{/if}
				{if $smarty.const.UGROUP==1}
					{if $c.status!=1}&nbsp;<a class="mod_comment_unlock" href="javascript:void(0);"><img src="{$ABS_PATH}modules/comment/templates/images/unlock.gif" alt="" border="0" /></a>
					{else}&nbsp;<a class="mod_comment_lock" href="javascript:void(0);"><img src="{$ABS_PATH}modules/comment/templates/images/lock.gif" alt="" border="0" /></a>
					{/if}&nbsp;<a class="mod_comment_delete" href="javascript:void(0);"><img src="{$ABS_PATH}modules/comment/templates/images/trash.gif" alt="" border="0" /></a>
				{/if}
			</div>
		</div>

		<div class="mod_comment_text{if $smarty.const.UGROUP==1 || $c.author_id==$smarty.session.user_id|default:'*'} editable_text{/if}">{$c.message|escape}</div>
	</div>

	{if $smarty.request.subaction=='showonly' && $smarty.request.comment_id==$c.Id}
		</div>
	{/if}

	{if $comments[$c.Id]}
		{include file="$subtpl" subcomments=$comments[$c.Id] sub=1}
	{/if}

	<a id="end{$c.Id}"></a>

	</div>
{/foreach}