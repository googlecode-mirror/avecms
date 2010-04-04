
<p class="forum_navi">
    {$navigation}
</p>


{if $error}
<div id="error_list">
    {$error}
</div>
{/if}
<table width="100%"  border="0" cellpadding="4" cellspacing="1" class="forum_tableborder">
  <tr>
    <td class="forum_header_bolder">{#PleaseLoginT#}</td>
  </tr>
  <tr>
    <td class="forum_info_main">{#PleaseLoginM#}</td>
  </tr>
  <tr>
    <td class="forum_info_meta">
	
<form action="index.php?module=forums&amp;show=forumlogin" method="post">
	<input type="hidden" name="fid" value="{$smarty.request.fid}" />
	<input type="password" name="pass" />
	<input class="button" type="submit" value="{#Login#}" />
</form>
	</td>
  </tr>
</table>
