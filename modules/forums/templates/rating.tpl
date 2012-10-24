<form action="index.php?module=forums&amp;show=rating" method="post">
	<input type="hidden" name="t_id" value="{$topic->id}" />
	<table border="0" cellpadding="1" cellspacing="1" class="forum_tableborder">
		<tr class="forum_info_main">
			<td nowrap="nowrap" class="forum_header" style="text-align: center;"><div align="left"><span class="forum_header ">{#FORUMS_VOTE_TOPIC#}</span></div></td>
			<td nowrap="nowrap" style="text-align: center;"><div align="center"><img src="{$forum_images}forum/flop.gif" alt="" /></div></td>
			<td nowrap="nowrap" style="text-align: center;"><input type="radio" name="rating" value="1" onclick="if(confirm('{#FORUMS_VOTE_TOPIC_START#} 1 {#FORUMS_VOTE_TOPIC_END_2#}')) this.form.submit()" /></td>
			<td nowrap="nowrap" style="text-align: center;"><input type="radio" name="rating" value="2" onclick="if(confirm('{#FORUMS_VOTE_TOPIC_START#} 2 {#FORUMS_VOTE_TOPIC_END#}')) this.form.submit()" /></td>
			<td nowrap="nowrap" style="text-align: center;"><input type="radio" name="rating" value="3" onclick="if(confirm('{#FORUMS_VOTE_TOPIC_START#} 3 {#FORUMS_VOTE_TOPIC_END#}')) this.form.submit()" /></td>
			<td nowrap="nowrap" style="text-align: center;"><input type="radio" name="rating" value="4" onclick="if(confirm('{#FORUMS_VOTE_TOPIC_START#} 4 {#FORUMS_VOTE_TOPIC_END#}')) this.form.submit()" /></td>
			<td nowrap="nowrap" style="text-align: center;"><input type="radio" name="rating" value="5" onclick="if(confirm('{#FORUMS_VOTE_TOPIC_START#} 5 {#FORUMS_VOTE_TOPIC_END#}')) this.form.submit()" /></td>
		    <td nowrap="nowrap" style="text-align: center;"><img src="{$forum_images}forum/top.gif" alt="" /></td>
		</tr>
    </table>
</form>