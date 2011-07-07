{if $display_comments==1}<br />

<h6>{#COMMENT_SITE_TITLE#}{if $closed==1} {#COMMENT_SITE_CLOSED#}{/if}</h6>

{if $cancomment==1 && $closed!=1}
	<a href="javascript:void(0);" onclick="popup('index.php?docid={$smarty.request.id|escape}&module=comment&action=form&pop=1&theme={$theme}&page={$page}','comment','500','600','1')">{#COMMENT_SITE_ADD#}</a>&nbsp;|&nbsp;
{/if}

<a href="#end">{#COMMENT_LAST_COMMENT#}</a>

{if $smarty.const.UGROUP == 1}
	&nbsp;|&nbsp;
	{if $closed==1}
		<a href="javascript:void(0);" onclick="popup('index.php?document_id={$smarty.request.id|escape}&module=comment&action=open&pop=1','comment','50','50','1');">{#COMMENT_SITE_OPEN#}</a>
	{else}
		<a href="javascript:void(0);" onclick="popup('index.php?document_id={$smarty.request.id|escape}&module=comment&action=close&pop=1','comment','50','50','1');">{#COMMENT_SITE_CLOSE#}</a>
	{/if}
{/if}<br />
<br />

{foreach from=$comments.0 item=c name=co}
	{if $smarty.request.subaction=='showonly' && $smarty.request.comment_id==$c.Id}
		<div class="mod_comment_highlight">
	{/if}

	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="mod_comment_box">
		<tr>
			<td class="mod_comment_header">
				<div class="mod_comment_author">
					<a name="{$c.Id}"></a>{#COMMENT_USER_ADD#} <a title="{#COMMENT_INFO#}" href="javascript:void(0);" onclick="popup('index.php?module=comment&action=postinfo&pop=1&Id={$c.Id}&theme={$theme}','comment','500','300','1');">{$c.comment_author_name}{*|stripslashes|escape:html*}</a> • {$c.comment_published}{if $smarty.const.UGROUP==1} • IP:{$c.comment_author_ip}{/if}
				</div>

				<div class="mod_comment_icons">
					<a  class="popup" href="javascript:void(0);" onclick="popup('index.php?parent={$c.Id}&docid={$smarty.request.id|escape}&module=comment&action=form&pop=1&theme={$theme}&page={$page}','comment','500','520','1');">
						<img src="modules/comment/templates/images/reply.gif" alt="" border="0" /><span>{#COMMENT_ANSWER_LINK#}</span>
					</a>

					{if $smarty.const.UGROUP==1 || $c.comment_author_id==$smarty.session.user_id}
						&nbsp;<a class="popup" href="javascript:void(0);" onclick="popup('index.php?parent={$c.Id}&docid={$smarty.request.id|escape}&module=comment&action=edit&pop=1&Id={$c.Id}&theme={$theme}','comment','500','620','1');">
						<img src="modules/comment/templates/images/edit.gif" alt="" border="0" /><span>{#COMMENT_EDIT_LINK#}</span></a>
					{/if}

					{if $smarty.const.UGROUP==1}
						&nbsp;<a  class="popup"  href="javascript:void(0);" onclick="popup('index.php?parent={$c.Id}&docid={$smarty.request.id|escape}&module=comment&action=delete&pop=1&Id={$c.Id}','comment','100','100','1');">
							<img src="modules/comment/templates/images/trash.gif" alt="" border="0" /><span>{#COMMENT_DELETE_LINK#}</span>
						</a>
						{if $c.comment_status!=1}
							&nbsp;<a  class="popup"  href="javascript:void(0);" onclick="popup('index.php?parent={$c.Id}&docid={$smarty.request.id|escape}&module=comment&action=unlock&pop=1&Id={$c.Id}','comment','100','100','1');">
								<img src="modules/comment/templates/images/unlock.gif" alt="" border="0" /><span>{#COMMENT_UNLOCK_LINK#}</span>
							</a>
						{else}
							&nbsp;<a  class="popup"  href="javascript:void(0);" onclick="popup('index.php?parent={$c.Id}&docid={$smarty.request.id|escape}&module=comment&action=lock&pop=1&Id={$c.Id}','comment','100','100','1');">
								<img src="modules/comment/templates/images/lock.gif" alt="" border="0" /><span>{#COMMENT_LOCK_LINK#}</span>
							</a>
						{/if}
					{/if}
				</div>
			</td>
		</tr>

		<tr>
			<td class="mod_comment_text">
				{$c.comment_text}
				{if $c.comment_changed > 1}<br /><span class="mod_comment_changed">{#COMMENT_TEXT_CHANGED#} {$c.comment_changed}</span>{/if}
			</td>
		</tr>
	</table>

	{if $smarty.request.subaction=='showonly' && $smarty.request.comment_id==$c.Id}
		</div>
	{/if}

	{foreach from=$comments[$c.Id] item=sc}
		<div class="mod_comment_ans_box">
			{if $smarty.request.subaction=='showonly' && $smarty.request.comment_id==$sc.Id}
				<div class="mod_comment_highlight">
			{/if}

			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mod_comment_box">
				<tr>
					<td class="mod_comment_header">
						<div class="mod_comment_author">
							<a name="{$sc.Id}"></a>{#COMMENT_TEXT_ANSWER#} <a title="{#COMMENT_INFO#}" href="javascript:void(0);" onclick="popup('index.php?module=comment&action=postinfo&pop=1&Id={$sc.Id}&theme={$theme}','comment','500','300','1');">{$sc.comment_author_name}{*|stripslashes|escape:html*}</a> ({$sc.comment_published}){if $smarty.const.UGROUP==1}	IP:{$sc.comment_author_ip}{/if}
						</div>

						<div class="mod_comment_icons">
							{if $smarty.const.UGROUP==1 || $sc.comment_author_id==$smarty.session.user_id}
								<a title="{#COMMENT_EDIT_LINK#}" href="javascript:void(0);" onclick="popup('index.php?parent={$sc.Id}&docid={$smarty.request.id|escape}&module=comment&action=edit&pop=1&Id={$sc.Id}&theme={$theme}','comment','500','620','1');"><img src="modules/comment/templates/images/edit.gif" alt="" border="0" /></a>
							{/if}

							{if $smarty.const.UGROUP==1}
								<a title="{#COMMENT_DELETE_LINK#}" href="javascript:void(0);" onclick="popup('index.php?parent={$sc.Id}&docid={$smarty.request.id|escape}&module=comment&action=delete&pop=1&Id={$sc.Id}','comment','100','100','1');"><img src="modules/comment/templates/images/trash.gif" alt="" border="0" /></a>
								{if $sc.comment_status!=1}
									<a title="{#COMMENT_UNLOCK_LINK#}" href="javascript:void(0);" onclick="popup('index.php?parent={$sc.Id}&docid={$smarty.request.id|escape}&module=comment&action=unlock&pop=1&Id={$sc.Id}','comment','100','100','1');"><img src="modules/comment/templates/images/unlock.gif" alt="" border="0" /></a>
								{else}
									<a title="{#COMMENT_LOCK_LINK#}" href="javascript:void(0);" onclick="popup('index.php?parent={$sc.Id}&docid={$smarty.request.id|escape}&module=comment&action=lock&pop=1&Id={$sc.Id}','comment','100','100','1');"><img src="modules/comment/templates/images/lock.gif" alt="" border="0" /></a>
								{/if}
							{else}
								&nbsp;
							{/if}
						</div>
					</td>
				</tr>

				<tr>
					<td class="mod_comment_text">
						{$sc.comment_text}
						{if $sc.comment_changed > 1}<br /><span class="mod_comment_changed">{#COMMENT_TEXT_CHANGED#} {$sc.comment_changed}</span>{/if}
					</td>
				</tr>
			</table>

			{if $smarty.request.subaction=='showonly' && $smarty.request.comment_id==$sc.Id}
				</div>
			{/if}
		</div>
	{/foreach}
{/foreach}

{if $smarty.foreach.co.last}<a name="end"></a>{/if}

{/if}