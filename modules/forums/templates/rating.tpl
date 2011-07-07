
<form action="index.php?module=forums&amp;show=rating" method="post">
	<input type="hidden" name="t_id" value="{$topic->id}" />
	<table border="0" cellpadding="1" cellspacing="1" class="forum_tableborder">
		<tr class="forum_info_main">
		  <td nowrap="nowrap" class="forum_header" style="text-align: center;"><div align="left"><span class="forum_header ">{#VoteTopic#}</span></div></td>
			<td nowrap="nowrap" style="text-align: center;"><div align="center"><img src="{$forum_images}forum/flop.gif" alt="" /></div></td>
			<td nowrap="nowrap" style="text-align: center;"><input type="radio" name="rating" value="1" onclick="if(confirm('{#VoteTopic_start#} 1 {#VoteTopic_endO#}')) this.form.submit()" /></td>
			<td nowrap="nowrap" style="text-align: center;"><input type="radio" name="rating" value="2" onclick="if(confirm('{#VoteTopic_start#} 2 {#VoteTopic_end#}')) this.form.submit()" /></td>
			<td nowrap="nowrap" style="text-align: center;"><input type="radio" name="rating" value="3" onclick="if(confirm('{#VoteTopic_start#} 3 {#VoteTopic_end#}')) this.form.submit()" /></td>
			<td nowrap="nowrap" style="text-align: center;"><input type="radio" name="rating" value="4" onclick="if(confirm('{#VoteTopic_start#} 4 {#VoteTopic_end#}')) this.form.submit()" /></td>
			<td nowrap="nowrap" style="text-align: center;"><input type="radio" name="rating" value="5" onclick="if(confirm('{#VoteTopic_start#} 5 {#VoteTopic_end#}')) this.form.submit()" /></td>
		    <td nowrap="nowrap" style="text-align: center;"><img src="{$forum_images}forum/top.gif" alt="" /></td>
		</tr>
  </table>
</form>