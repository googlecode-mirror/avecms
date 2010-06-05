<table width="100%" border="0" cellspacing="0" cellpadding="0" class="mod_comment_box">
	<tr>
		<td class="mod_comment_header">
			<div class="mod_comment_author">
				<a name="{$comment_id}"></a>{#COMMENT_USER_ADD#} <a title="{#COMMENT_INFO#}" href="javascript:void(0);" onclick="popup('index.php?module=comment&action=postinfo&pop=1&Id={$comment_id}&theme={$theme}','comment','500','300','1');">{$author_name}</a> • {$smarty.now|date_format:$TIME_FORMAT|pretty_date}{if $smarty.const.UGROUP==1} • IP:{$author_ip}{/if}
			</div>

			{if $smarty.const.UGROUP==1}
				<div class="mod_comment_icons">
					&nbsp;<a class="tooltip" title="{#COMMENT_DELETE_LINK#}" href="javascript:void(0);" onclick="cAction(this, 'delete', '{$comment_id}');"><img src="modules/comment/templates/images/trash.gif" alt="" border="0" /></a>
					{if $status!=1}
						&nbsp;<a class="tooltip" title="{#COMMENT_UNLOCK_LINK#}" href="javascript:void(0);" onclick="cAction(this, 'unlock', '{$comment_id}');"><img src="modules/comment/templates/images/unlock.gif" alt="" border="0" /></a>
					{else}
						&nbsp;<a class="tooltip" title="{#COMMENT_LOCK_LINK#}" href="javascript:void(0);" onclick="cAction(this, 'unlock', '{$comment_id}');"><img src="modules/comment/templates/images/lock.gif" alt="" border="0" /></a>
					{/if}
				</div>
			{/if}
		</td>
	</tr>

	<tr>
		<td id="id_{$comment_id}" class="mod_comment_text{if $smarty.session.user_id} editable_text{/if}">{$message}</td>
	</tr>
</table>