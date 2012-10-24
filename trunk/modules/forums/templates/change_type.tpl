
<p>
	{$navigation} &raquo; <a href="{$ref}">{cpdecode val=$smarty.request.t}</a>
</p>
<table width="100%"  border="0" cellpadding="4" cellspacing="1" class="forum_tableborder">
	<tr>
		<td class="forum_header_bolder">{#FORUMS_CHANGE_TOPIC_TYPE#}</td>
	</tr>
	<tr>
		<td class="forum_info_main">
			<form action="index.php?module=forums&amp;show=change_type&amp;sub=save" method="post">
				<input type="hidden" name="toid" value="{$smarty.get.toid}" />
				<input type="hidden" name="fid" value="{$smarty.get.fid}" />
					<select name="type">
						<option value="0" {if $topic->type == 0}selected{/if}>{#FORUMS_USUAL_THREAD#}</option>
						<option value="1" {if $topic->type == 1}selected{/if}>{#FORUMS_STICK_THREAD#}</option>
						<option value="100" {if $topic->type == 100}selected{/if}>{#FORUMS_ANNOUNCEMENT#}</option>
					</select>
				<input type="submit" class="button" value="{#FORUMS_BUTTON_GO#}" />
			</form>
		</td>
	</tr>
</table>