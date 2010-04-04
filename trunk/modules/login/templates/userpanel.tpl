<!-- userpanel.tpl -->
{strip}

<p><strong>{#LOGIN_WELCOME_TEXT#}, {$smarty.session.user_name}!</strong></p>
<ul>
	<li><a href="index.php?module=login&amp;action=profile">{#LOGIN_CHANGE_DETAILS#}</a></li>
	<li><a href="index.php?module=login&amp;action=delaccount">{#LOGIN_DELETE_LINK#}</a></li>
	<li><a href="index.php?module=login&amp;action=passwordchange">{#LOGIN_CHANGE_LINK#}</a></li>
	{if checkPermission("adminpanel")}
		<li><a href="admin/index.php" target="_blank">{#LOGIN_ADMIN_LINK#}</a></li>
	{/if}
	{if checkPermission("docs")}
		{if $smarty.session.user_adminmode==1}
			<li><a href="index.php?module=login&amp;action=wys&amp;sub=off">{#LOGIN_WYSIWYG_OFF#}</a></li>
		{else}
			<li><a href="index.php?module=login&amp;action=wys&amp;sub=on">{#LOGIN_WYSIWYG_ON#}</a></li>
		{/if}
	{/if}
	<li><a href="index.php?module=login&action=logout">{#LOGIN_LOGOUT_LINK#}</a> </li>
</ul>

{/strip}
<!-- /userpanel.tpl -->
