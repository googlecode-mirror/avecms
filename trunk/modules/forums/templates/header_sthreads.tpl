
{if $smarty.request.print!=1}
<table width="100%" border="0" cellpadding="2" cellspacing="1" class="forum_tableborder">
  <tr>
    <td align="center" class="forum_info_meta"><a href="index.php?module=forums">{#PageNameForums#}</a></td>
	  <td align="center" class="forum_info_meta"><a href="index.php?module=forums&amp;show=userlist">{#Users#}</a></td>
    <td align="center" class="forum_info_meta"><a {popup trigger="onclick" timeout="20000" sticky=true text=$SearchPop} href="javascript:void(0);">{#ForumsSearch#}</a> </td>

	  <td align="center" class="forum_info_meta">
	  <a href="index.php?module=forums&amp;show=last24">{#ShowLast24#}</a></td>
    {if $smarty.session.user_group != 2}
	  <td align="center" class="forum_info_meta"><a href="index.php?module=forums&amp;show=userpostings&amp;user_id={$smarty.session.user_id}">{#ShowMyPostings#}</a></td>
    <td align="center" class="forum_info_meta"><a href="index.php?module=forums&amp;show=showforums&amp;action=markread&amp;what=forum&amp;ReadAll=1">{#MarkForumsRead#}</a></td>
	  {/if}
  </tr>
</table>
<br />
{/if}